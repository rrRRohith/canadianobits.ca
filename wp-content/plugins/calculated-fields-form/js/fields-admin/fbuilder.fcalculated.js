    $(document).on('mouseover', '.eq_btn', function(){$(this).addClass('button-primary');})
    .on('mouseout' , '.eq_btn', function(){$(this).removeClass('button-primary');});
	$.fbuilder.typeList.push(
		{
			id:"fCalculated",
			name:"Calculated Field",
			control_category:1
		}
	);
	$.fbuilder.controls['fCalculated']=function(){this.dependencies = [{'rule':'', 'complex':false, 'fields':['']}];};
	$.extend(
		$.fbuilder.controls['fCalculated'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"fCalculated",
			predefined:"",
			required:false,
			exclude:false,
			size:"medium",
            eq:"",
            min:"",
            max:"",
			suffix:"",
			prefix:"",
			decimalsymbol:".",
			groupingsymbol:"",
			readonly:true,
			currency:false,
			noEvalIfManual:true,
			formatDynamically:false,
			hidefield:false,
			init:function()
				{
					delete(this['eq_factored']);
					delete(this['items']);
					/* Global variable to allows the integration with the Advanced Editor */
					if(typeof cff_form_fields_list == 'undefined') cff_form_fields_list = {};
				},
			display:function()
				{
					this.init();
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><input class="field disabled '+this.size+'" type="text" value="'+cff_esc_attr(this.predefined)+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt=[
                        {s:"#sMin",e:"change keyup", l:"min"},
                        {s:"#sMax",e:"change keyup", l:"max"},
						{s:"#sSuffix",e:"change keyup", l:"suffix"},
						{s:"#sPrefix",e:"change keyup", l:"prefix"},
						{s:"#sDecimalSymbol",e:"change keyup", l:"decimalsymbol"},
						{s:"#sGroupingSymbol",e:"change keyup", l:"groupingsymbol"},
						{s:"#sHideField",e:"click", l:"hidefield", f:function(el){return el.is(':checked');}},
						{s:"#sFormatDynamically",e:"click", l:"formatDynamically", f:function(el){return el.is(':checked');}},
						{s:"#sNoEvalIfManual",e:"click", l:"noEvalIfManual", f:function(el){return el.is(':checked');}},
						{s:"#sCurrency",e:"click", l:"currency", f:function(el){return el.is(':checked');}},
						{s:"#sSize",e:"change", l:"size"}
					];

					$("#sEq").bind("change keyup", {obj: this}, function(e)
						{
                            if($.inArray(e.keyCode, [16,17,18,27,37,38,39,40]) == -1)
                            {
                                e.data.obj.eq = $(this).val();
                                $.fbuilder.reloadItems({'field':e.data.obj});
                            }
						});
					$(document).on('click', '.cff-light-modal-close-icon', function(){$('[id="cff-advanced-equation-editor"]').remove();$(this).remove();});
					$(document).on('keyup', function(e){if(e.key === 'Escape') $('.cff-light-modal-close-icon').click();});
					$("#sAdvancedEditor").bind("click", {obj: this}, function(e)
						{
							$(window).unbind('message');
							$(window).bind('message', function(event){$('#sEq').val(event.originalEvent.data).change();});
                            var advEditor = '<div class="cff-light-modal" id="cff-advanced-equation-editor" role="dialog" aria-hidden="false">'+
							'<div class="cff-light-modal-content">'+
							'<div class="cff-light-modal-body">'+
							'<iframe width="560" height="315" frameborder="0" allowfullscreen scrolling="no"></iframe>'+
							'</div>'+
							'</div>'+
							'</div>'+
							'<div class="cff-light-modal-close-icon" aria-label="close" title="Close">Save & Close</div>';

							$('body').append(advEditor);
							$('[id="cff-advanced-equation-editor"] iframe').on(
								'load',
								function(){
									var args = {};
									args.code = e.data.obj.eq;
									args.fields = cff_form_fields_list;
									if($.fbuilder['modules'])
									{
										args.operations = {};
										for(var i in $.fbuilder['modules'])
                                        {
                                            for(var j in $.fbuilder['modules'][i]['toolbars'])
                                            {
                                                if($.fbuilder['modules'][i]['toolbars'][j]['buttons'].length)
                                                {
                                                    $.extend(true, args.operations, $.fbuilder['modules'][i]['toolbars'])
                                                    break;
                                                }
                                            }
                                        }
									}
									this.contentWindow.postMessage(JSON.stringify(args), '*');
								}
							).attr('src', '//fxeditor.dwbooster.com/?open_by=cff');

							document.location.href="#cff-advanced-equation-editor";
						});
					$('.displayWizard').bind("click", {obj: this}, function(e)
						{
							e.preventDefault();
							var me = $(this),
								i  = me.attr("i");
							e.data.obj.dependencies[i].rule = '';
							e.data.obj.dependencies[i].complex = false;
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$('.displayComplexRule').bind("click", {obj: this}, function(e)
						{
							e.preventDefault();
							e.data.obj.dependencies[$(this).attr("i")].complex = true;
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".cf_dependence_operator").bind("change", {obj: this}, function(e)
						{
							var me = $(this),
								i  = me.attr("i"),
								o  = e.data.obj.dependencies[i];

							o.rule = 'value'+me.val()+$(".cf_dependence_value[i='"+i+"']").val().replace(/'/g, "\'");
							o.complex = false;
							e.data.obj.dependencies[me.attr("i")].rule = o.rule;
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".cf_dependence_value").bind("change keyup", {obj: this}, function(e)
						{
							var me = $(this),
								i  = me.attr("i"),
								o  = e.data.obj.dependencies[i];

							o.rule = 'value'+$(".cf_dependence_operator[i='"+i+"']").val()+me.val();
							o.complex = false;
							e.data.obj.dependencies[me.attr("i")].rule = o.rule;
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".cf_dependence_rule").bind("change keyup", {obj: this}, function(e)
						{
							var me = $(this);
							e.data.obj.dependencies[me.attr("i")].rule = me.val();
							e.data.obj.dependencies[me.attr("i")].complex = true;
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".cf_dependence_field").bind("change", {obj: this}, function(e)
						{
							var me = $(this);
							e.data.obj.dependencies[me.attr("i")].fields[me.attr("j")]  = me.val();
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".addDep").bind("click", {obj: this}, function(e)
						{
							var j = $(this).attr("j");
							if(typeof j == 'undefined')
							{
								e.data.obj.dependencies.splice($(this).attr("i")*1+1, 0, { 'rule' : '', 'complex' : false, 'fields' : [''] });
							}else
							{
								e.data.obj.dependencies[$(this).attr("i")].fields.splice(j+1, 0, "")
							}

							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".removeDep").bind("click", {obj: this}, function(e)
						{
							var i = $(this).attr("i"),
								j = $(this).attr("j");

							if(typeof j != 'undefined')
							{
								if(e.data.obj.dependencies[i].fields.length != 1)
								{
									e.data.obj.dependencies[i].fields.splice(j, 1);
								}else
								{
									e.data.obj.dependencies[i].fields = [''];
								}
							}
							else
							{
								if(e.data.obj.dependencies.length != 1)
								{
									e.data.obj.dependencies.splice(i, 1);
								}
								else
								{
									e.data.obj.dependencies[0] = { 'rule' : '', 'complex' : false, 'fields' : [''] };
								}
							}

							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$.fbuilder.controls['ffields'].prototype.editItemEvents.call(this, evt);
				},
		showSpecialDataInstance: function()
			{
				return this.showNoEvalIfManual()+this.showFormatDynamically()+this.showHideField()+this.showEqEditor()+this.showDependencies();
			},
		showDependencies : function()
			{
				// Instance
				var me = this;

				function setOperator(indx, op)
				{
					var ops = [
								{'text' : 'Equal to', 'value' : '=='},
								{'text' : 'Not equal to', 'value' : '!='},
								{'text' : 'Greater than', 'value' : '>'},
								{'text' : 'Greater than or equal to', 'value' : '>='},
								{'text' : 'Less than', 'value' : '<'},
								{'text' : 'Less than or equal to', 'value' : '<='}
							],
						r = '';

					for(var i = 0, h = ops.length; i < h; i++)
					{
						r += '<option value="'+cff_esc_attr(ops[i]['value'])+'" '+((op == ops[i]['value']) ? 'SELECTED' : '')+'>'+ops[i]['text']+'</option>';
					}

					return '<select i="'+cff_esc_attr(indx)+'" class="cf_dependence_operator">'+r+'</select>';
				}

				var r = '';
				var items = this.fBuild.getItems();
				$.each(this.dependencies, function (i, o)
					{
						if(o.complex)
						{
							r += '<div class="cff-dependency-rule"><div style="position:relative;"><span style="font-weight:bold;">If value is</span><span class="cf_dependence_edition" i="'+i+'" ><input class="cf_dependence_rule" type="text" i="'+i+'" value="'+cff_esc_attr(o.rule)+'" /></span><div class="choice-ctrls"><a class="addDep ui-icon ui-icon-circle-plus" i="'+i+'" title="Add another dependency."></a><a class="removeDep ui-icon ui-icon-circle-minus" i="'+i+'" title="Delete this dependency."></a></div><div style="text-align:right;position:relative;"><span style="float:left;">Ex: value==10</span><a href="#" class="displayWizard" i="'+i+'">Edit through wizard</a><br />(The rule entered will lost)</div></div>';
						}
						else
						{
							var operator = '',
								value = '';

							if(!/^\s*$/.test(o.rule))
							{
								var re    = new RegExp('^value([!=<>]+)(.*)$'),
									parts = re.exec(o.rule);

								operator = parts[1];
								value = parts[2];
							}

							r += '<div class="cff-dependency-rule"><div style="position:relative;"><span style="font-weight:bold;">If value is</span><span class="cf_dependence_edition" i="'+i+'" >'+setOperator(i, operator)+' <input type="text" i="'+i+'" class="cf_dependence_value" value="'+cff_esc_attr(value)+'" /></span><div class="choice-ctrls"><a class="addDep ui-icon ui-icon-circle-plus" i="'+i+'" title="Add another dependency."></a><a class="removeDep ui-icon ui-icon-circle-minus" i="'+i+'" title="Delete this dependency."></a></div><div style="text-align:right;"><a i="'+i+'" class="displayComplexRule" href="#">Edit rule manually</a></div></div>';
						}
						r += '<div>';
						$.each(o.fields, function(j, v)
							{

								var opt = '<option value=""></option>';
								for (var k=0;k<items.length;k++)
								{
									if (items[k].name != me.name && items[k].ftype != 'fPageBreak' && items[k].ftype != 'frecordsetds')
									{
										opt += '<option value="'+items[k].name+'" '+((items[k].name == v) ? 'selected="SELECTED"' : '')+'>'+items[k].name+((typeof items[k].title != 'undefined') ? ' ('+cff_esc_attr(items[k].title)+')' : '')+'</option>';
									}
								}
								r += '<div style="position:relative;" class="cff-dependency-item"><span>If rule is valid show:</span> <select class="cf_dependence_field" i="'+i+'" j="'+j+'" >'+opt+'</select><div class="choice-ctrls"><a class="addDep ui-icon ui-icon-circle-plus" i="'+i+'" j="'+j+'" title="Add another dependency."></a><a class="removeDep ui-icon ui-icon-circle-minus" i="'+i+'" j="'+j+'" title="Delete this dependency."></a></div></div>';
							});
						r += '</div></div>';
					});

				return '<label>Define dependencies</label><div class="dependenciesBox">'+r+'</div>';
			},
		showNoEvalIfManual:function()
			{
				return '<label><input type="checkbox" name="sNoEvalIfManual" id="sNoEvalIfManual" '+((this.noEvalIfManual)?"checked":"")+'> If value entered manually, no evaluate equation</label>';
			},
		showFormatDynamically:function()
			{
				return '<label><input type="checkbox" name="sFormatDynamically" id="sFormatDynamically" '+((this.formatDynamically)?"checked":"")+'> If editable, format dynamically</label>';
			},
		showHideField:function()
			{
				return '<label><input type="checkbox" name="sHideField" id="sHideField" '+((this.hidefield)?"checked":"")+'> Hide Field From Public Page</label>';
			},
        showRangeIntance: function()
            {
                return '<div class="clearer"></div><div class="column width50"><label>Min</label><input type="text" name="sMin" id="sMin" value="'+cff_esc_attr(this.min)+'" class="large"></div><div class="column width50"><label>Max</label><input type="text" name="sMax" id="sMax" value="'+cff_esc_attr(this.max)+'" class="large"></div><div class="clearer"></div>';
            },
		showEqEditor:function(eq)
			{
				var default_toolbar = "default|mathematical",
					me    = this,
					tools = $.fbuilder['objName']+'.fbuilder.controls.fCalculated.tools';

				$.fbuilder.controls['fCalculated']['tools'] = {
						setField : function()
							{
								this.setSymbol($('#sFieldList').val());
							},
						setSymbol : function(s)
							{
								var sEQ = $('#sEq');
								if(sEQ.length)
								{
									var p = sEQ.caret(),
										v = sEQ.val(),
										nv;

									sEQ.val(v.substr(0,p)+s+v.substr(p));
									sEQ.caret(p+s.length);
									me.eq = sEQ.val();
									$.fbuilder.reloadItems({'field':me});
								}
							},
						loadTutorial : function(toolbar)
							{
								var parts = toolbar.split('|'),
									out   = '';

								if($.fbuilder['modules'][parts[0]]['tutorial'])
								{
									out = '<input type="button" class="eq_btn button-secondary" onclick="window.open(\''+$.fbuilder['modules'][parts[0]]['tutorial']+'\');" value="?" title="Tutorial" />';
								}
								$('#sEqModuleTutorial').html(out);
								return out;
							},
						loadToolbarList : function()
							{
								var out = '<select id="sToolbarList" onchange="'+tools+'.loadToolbar(this.options[this.selectedIndex].value);'+tools+'.loadTutorial(this.options[this.selectedIndex].value);">';

								if($.fbuilder['modules'])
								{
									for(var m in $.fbuilder['modules'])
									{
										var module = $.fbuilder['modules'][m];
										for(var toolbar in module['toolbars'])
										{
											out += '<option value="'+m+'|'+toolbar+'" '+((default_toolbar == m+'|'+toolbar) ? 'SELECTED' : '')+'>'+module['toolbars'][toolbar]['label']+'</options>';
										}
									}
								}
								out += '</select>';
								return out;
							},
						loadToolbar : function(toolbar)
							{
								var parts = toolbar.split('|'),
									out   = '';

								if($.fbuilder['modules'][parts[0]]['toolbars'][parts[1]])
								{
									var buttons = $.fbuilder['modules'][parts[0]]['toolbars'][parts[1]]['buttons'];
                                    if(buttons.length)
                                    {
                                        for(var i = 0, h = buttons.length; i < h; i++)
                                        {
                                            out += '<input type="button" value="'+cff_esc_attr(buttons[i]['value'])+'" onclick="'+tools+'.setSymbol(\''+buttons[i]['code']+'\');'+tools+'.setTip(\''+buttons[i]['tip']+'\');" class="eq_btn button-secondary" title="'+buttons[i]['value']+'" />';
                                        }
                                        this.setTip('');
                                    }
                                    else
                                    {
                                        this.setTip('The module is distributed with the <a href="https://cff.dwbooster.com/download" target="_blank">Developer and Platinum versions</a> of the plugin.');
                                    }
								}

								$('#sEqButtonsContainer').html(out);
								return out;
							},
						setTip : function(t)
							{
								if(!/^\s*$/.test(t))
								{
									$('#sEqTipsContainer').html(t).show();
								}
								else
								{
									$('#sEqTipsContainer').html('').hide();
								}
							}
					};

                    var out = '<label>Set Equation</label><textarea class="large" name="sEq" id="sEq" style="height:150px;">'+me.eq+'</textarea>'+
					'<div id="sAdvancedEditor" title="The Advance Editor is still in experimental state">Advanced Equation\'s Editor</div>'+
					'<label>Operands <div style="float:right;"><a href="https://cff.dwbooster.com/documentation#modules" target="_blank">Read equation tutorial</a></div></label><div class="groupBox"><select id="sFieldList">';

                    var items = this.fBuild.getItems(),
						invalidFields = { 'fSectionBreak':1, 'fPageBreak':1, 'fsummary':1, 'ffieldset':1, 'fdiv':1, 'fMedia':1, 'fButton':1, 'fhtml':1, 'ffile':1 };

					for(var i in items)
					{
						var item = items[i];
						if(item['name'] != this.name && typeof invalidFields[item.ftype] == 'undefined')
						{
							var fName = item['name'],
								fTitle = item['title'];

							cff_form_fields_list[fName] = {label:fTitle, type:item.ftype};

							fName = fName.replace(/'/g, "\'").replace(/"/g, '\"');
							out += '<option value="'+cff_esc_attr(fName)+'">'+item['name']+((item['title'] && !/^\s*$/.test(item['title'])) ? '('+cff_esc_attr(item['title'])+')' : '')+'</option>';
						}
					}
                    out += '</select><input type="button" value="+" class="eq_btn button-secondary" onclick="'+tools+'.setField();" /></div><label>Operators</label><div style="text-align:center;" class="groupBox"><div style="text-align:left;">'+$.fbuilder.controls['fCalculated']['tools'].loadToolbarList()+'<span id="sEqModuleTutorial">'+$.fbuilder.controls['fCalculated']['tools'].loadTutorial(default_toolbar)+'</span></div><div id="sEqButtonsContainer" style="margin-top:10px;">'+$.fbuilder.controls['fCalculated']['tools'].loadToolbar(default_toolbar)+'</div><div id="sEqTipsContainer" style="background-color:#DFEFFF;border:1px solid #C2D7EF;padding:5px;margin:5px;display:none;text-align:left;"></div><div style="padding-top:20px;" class="large"><input type="button" class="button-primary large" onclick="window.open(\'https://cff-bundles.dwbooster.com/?category[]=operations\',\'_blank\');" value="More operations [+]" /></div></div><label>Symbol to display at beginning of calculated field</label><input type="text" name="sPrefix" id="sPrefix" class="large" value="'+cff_esc_attr(me.prefix)+'" /><label><input type="checkbox" id="sCurrency" name="sCurrency" '+((me.currency) ? 'CHECKED' : '')+' /> it is a currency</label><label>Symbol to display at the end of calculated field</label><input type="text" name="sSuffix" id="sSuffix" class="large" value="'+cff_esc_attr(me.suffix)+'" /><label>Decimals separator symbol (Ex: 25.20)</label><input type="text" name="sDecimalSymbol" id="sDecimalSymbol" class="large" value="'+cff_esc_attr(me.decimalsymbol)+'" /><label>Symbol for grouping thousands (Ex: 3,000,000)</label><input type="text" name="sGroupingSymbol" id="sGroupingSymbol" class="large" value="'+cff_esc_attr(me.groupingsymbol)+'" />';

                    return out;
			}
	});