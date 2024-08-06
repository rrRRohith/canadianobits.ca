	$.fbuilder.typeList.push(
		{
			id:"fdropdown",
			name:"Dropdown",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fdropdown' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fdropdown' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Select a Choice",
			ftype:"fdropdown",
			size:"medium",
			required:false,
			exclude:false,
			toSubmit:'text',
			merge:0,
			choiceSelected:"",
            select2: false,
			multiple: false,
			vChoices: 1,
			showDep:false,
			init:function()
				{
					this.choices = new Array("First Choice","Second Choice","Third Choice");
					this.optgroup = new Array(false,false,false);
					this.choicesVal = new Array("First Choice","Second Choice","Third Choice");
					this.choicesDep = new Array(new Array(),new Array(),new Array());
				},
			display:function()
				{
					this.choicesVal = ((typeof(this.choicesVal) != "undefined" && this.choicesVal !== null)?this.choicesVal:this.choices.slice(0));
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><select class="field disabled '+this.size+'" ><option>'+cff_esc_attr(this.choiceSelected)+'</option></select><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					$(".choice_text").bind("change keyup", {obj: this}, function(e)
						{
							if (e.data.obj.choices[$(this).attr("i")] == e.data.obj.choicesVal[$(this).attr("i")])
							{
								$("#"+$(this).attr("id")+"V"+$(this).attr("i")).val($(this).val());
								e.data.obj.choicesVal[$(this).attr("i")]= $(this).val();
							}
							e.data.obj.choices[$(this).attr("i")]= $(this).val();
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_value").bind("change keyup", {obj: this}, function(e)
						{
							e.data.obj.choicesVal[$(this).attr("i")]= $(this).val();
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_optgroup").bind("change", {obj: this}, function(e)
						{
							e.data.obj.optgroup[$(this).attr("i")]= $(this).is(':checked');
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_select").bind("mousedown", function(){$(this).data('previous-status', $(this).is(':checked'));});
					$(".choice_select").bind("click", {obj: this}, function(e)
						{
							var el = $(this),
								i = el.attr("i");

							el.prop('checked', !el.data('previous-status'));
							e.data.obj.choiceSelected = (el.is(':checked')) ? e.data.obj.choices[i] + ' - ' + e.data.obj.choicesVal[i] : "";
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$("#sSize").bind("change", {obj: this}, function(e)
						{
							e.data.obj.size = $(this).val();
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_up").bind("click", {obj: this}, function(e)
						{
							var i = $(this).attr("i")*1;
							if (i!=0)
							{
								e.data.obj.choices.splice(i-1, 0, e.data.obj.choices.splice(i, 1)[0]);
								e.data.obj.choicesVal.splice(i-1, 0, e.data.obj.choicesVal.splice(i, 1)[0]);
								e.data.obj.choicesDep.splice(i-1, 0, e.data.obj.choicesDep.splice(i, 1)[0]);
								e.data.obj.optgroup.splice(i-1, 0, e.data.obj.optgroup.splice(i, 1)[0]);
							}
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_down").bind("click", {obj: this}, function(e)
						{
							var i = $(this).attr("i")*1;
							var n = $(this).attr("n")*1;
							if (i!=n)
							{
								e.data.obj.choices.splice(i, 0, e.data.obj.choices.splice(i+1, 1)[0]);
								e.data.obj.choicesVal.splice(i, 0, e.data.obj.choicesVal.splice(i+1, 1)[0]);
								e.data.obj.choicesDep.splice(i, 0, e.data.obj.choicesDep.splice(i+1, 1)[0]);
								e.data.obj.optgroup.splice(i, 0, e.data.obj.optgroup.splice(i+1, 1)[0]);
							}
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_removeDep").bind("click", {obj: this}, function(e)
						{
							if (e.data.obj.choicesDep[$(this).attr("i")].length == 1)
							{
								e.data.obj.choicesDep[$(this).attr("i")][0]="";
							}
							else
							{
								e.data.obj.choicesDep[$(this).attr("i")].splice($(this).attr("j"),1);
							}
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_addDep").bind("click", {obj: this}, function(e)
						{
							e.data.obj.choicesDep[$(this).attr("i")].splice($(this).attr("j")*1+1,0,"");
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_remove").bind("click", {obj: this}, function(e)
						{
							var i = $(this).attr("i");

							if( e.data.obj.choices[ i ] + ' - ' + e.data.obj.choicesVal[ i ] == e.data.obj.choiceSelected )
							{
								e.data.obj.choiceSelected = "";
							}

							if (e.data.obj.choices.length==1)
							{
								e.data.obj.choices[0]="";
								e.data.obj.choicesVal[0]="";
								e.data.obj.optgroup[0]=false;
								e.data.obj.choicesDep[0]=new Array();
							}
							else
							{
								e.data.obj.choices.splice( i, 1 );
								e.data.obj.choicesVal.splice( i, 1 );
								e.data.obj.choicesDep.splice( i, 1 );
								e.data.obj.optgroup.splice( i, 1 );
							}

							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".choice_add").bind("click", {obj: this}, function(e)
						{
							e.data.obj.choices.splice($(this).attr("i")*1+1,0,"");
							e.data.obj.choicesVal.splice($(this).attr("i")*1+1,0,"");
							e.data.obj.optgroup.splice($(this).attr("i")*1+1,0,false);
							e.data.obj.choicesDep.splice($(this).attr("i")*1+1,0,new Array());
							$.fbuilder.editItem(e.data.obj.index);
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					$(".showHideDependencies").bind("click", {obj: this}, function(e)
						{
							if (e.data.obj.showDep)
							{
								$(this).parent().removeClass("show");
								$(this).parent().addClass("hide");
								$(this).html("Show Dependencies");
								e.data.obj.showDep = false;
							}
							else
							{
								$(this).parent().addClass("show");
								$(this).parent().removeClass("hide");
								$(this).html("Hide Dependencies");
								e.data.obj.showDep = true;
							}
							$.fbuilder.editItem(e.data.obj.index);
							return false;
						});
					$('.dependencies').bind("change", {obj: this}, function(e)
						{
							e.data.obj.choicesDep[$(this).attr("i")][$(this).attr("j")] = $(this).val();
							$.fbuilder.reloadItems({'field':e.data.obj});
						});
					var me 		= this,
						items 	= me.fBuild.getItems(),
						evt 	= [
							{s:'[name="sToSubmit"]', e:"click", l:"toSubmit"},
							{s:'[name="sMerge"]', e:"change", l:"merge", f: function(el){return (el.is(':checked')) ? 1 : 0;}},
							{s:'[name="sSelect2"]', e:"change", l:"select2", f: function(el){return el.is(':checked');}},
							{s:'[name="sMultiple"]', e:"click", l:"multiple", f: function(el){return el.is(':checked');}},
							{s:'[name="sVChoices"]', e:"change keyup", l:"vChoices", f: function(el){
								var v = el.val();
								return ($.isNumeric(v)) ? Math.ceil(v) : 1;
							}}
						];
					$('.dependencies').each(function()
						{
							var str = '<option value="" '+(("" == $(this).attr("dvalue"))?"selected":"")+'></option>';
							for (var i=0;i<items.length;i++)
							{
								if (items[i].name != me.name && items[i].ftype != 'fPageBreak' && items[i].ftype != 'frecordsetds')
								{
									str += '<option value="'+items[i].name+'" '+((items[i].name == $(this).attr("dvalue"))?"selected":"")+'>'+(items[i].name)+( ( typeof items[ i ].title != 'undefined' ) ? ' (' + cff_esc_attr(items[ i ].title) + ')' : '' )+'</option>';
								}
							}
							$(this).html(str);
						});
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, evt);
				},
				mergeValues: function()
				{
					return '<div class="choicesSet"><label><input type="checkbox" name="sMerge" '+((this.merge) ? ' CHECKED ' : '')+'/> Merge selected options (sum or concatenation) or their values are returned as an array (only applied when multiple choices selection is enabled).</label></div>';
				},
				attributeToSubmit: function()
				{
					return '<div class="choicesSet"><label>Value to Submit</label><div class="column width50"><label><input type="radio" name="sToSubmit" value="text" '+((this.toSubmit == 'text') ? ' CHECKED ' : '')+'/> Choice Text</label></div><div class="column width50"><label><input type="radio" name="sToSubmit" value="value" '+((this.toSubmit == 'value') ? ' CHECKED ' : '')+'/> Choice Value</label></div><div class="clearer" /></div>';
				},
				multipleSelection: function()
				{
					return '<label style="margin-bottom"><input type="checkbox" name="sMultiple" '+((typeof this.multiple != 'undefined' && this.multiple) ? ' CHECKED ' : '')+' /> Allows to select multiple choices.</label>'+
					'<label><input type="number" name="sVChoices" value="'+(($.isNumeric(this.vChoices) && this.vChoices) ? this.vChoices : 1)+'" style="max-width:60px;" min="1" /> Number of visual choices.</label>';
				},
				showChoiceIntance: function()
				{
					this.choicesVal = ((typeof(this.choicesVal) != "undefined" && this.choicesVal !== null)?this.choicesVal:this.choices.slice(0));
					if(typeof this.optgroup == 'undefined' ) this.optgroup = new Array();
					var l  = this.choices,
						lv = this.choicesVal,
						og = this.optgroup,
						str = '', str1, j;
					if (!(typeof(this.choicesDep) != "undefined" && this.choicesDep !== null))
					{
						this.choicesDep = new Array();
						for (var i=0;i<l.length;i++)
						{
							this.choicesDep[i] = new Array();
						}
					}
					var d = this.choicesDep;
					for (var i=0;i<l.length;i++)
					{
						str1 = '';
						if(typeof og[i] == 'undefined') og[i] = false;

						str += '<div class="choicesEdit"><input class="choice_select" i="'+i+'" type="radio" '+((this.choiceSelected==l[i]+' - '+lv[i])?"checked":"")+' name="choice_select" /><input class="choice_text" i="'+i+'" type="text" name="sChoice'+this.name+'" id="sChoice'+this.name+'" value="'+cff_esc_attr(l[i])+'"/><input class="choice_value" i="'+i+'" type="text" name="sChoice'+this.name+'V'+i+'" id="sChoice'+this.name+'V'+i+'" value="'+cff_esc_attr(lv[i])+'"/><input type="checkbox" name="optgroup" i="'+i+'" '+((og[i]) ? ' CHECKED ' : '' )+' class="choice_optgroup" /><div class="choice-ctrls"><a class="choice_down ui-icon ui-icon-arrowthick-1-s" i="'+i+'" n="'+(l.length-1)+'" title="Down"></a><a class="choice_up ui-icon ui-icon-arrowthick-1-n" i="'+i+'" title="Up"></a><a class="choice_add ui-icon ui-icon-circle-plus" i="'+i+'" title="Add another choice."></a><a class="choice_remove ui-icon ui-icon-circle-minus" i="'+i+'" title="Delete this choice."></a></div></div>';

						j = d[i].length;
						if(j)
						{
							while(j--)
							{
								str1 = '<div class="choicesEditDep"><span>If selected show:</span> <select class="dependencies" i="'+i+'" j="'+j+'" dname="'+this.name+'" dvalue="'+d[i][j]+'" ></select><div class="choice-ctrls"><a class="choice_addDep ui-icon ui-icon-circle-plus" i="'+i+'" j="'+j+'" title="Add another dependency."></a><a class="choice_removeDep ui-icon ui-icon-circle-minus" i="'+i+'" j="'+j+'" title="Delete this dependency."></a></div></div>'+str1;
							}
							str += str1;
						}
						else
						{
							str += '<div class="choicesEditDep"><span>If selected show:</span> <select class="dependencies" i="'+i+'" j="'+j+'" dname="'+this.name+'" dvalue="" ></select><div class="choice-ctrls"><a class="choice_addDep ui-icon ui-icon-circle-plus" i="'+i+'" j="'+j+'" title="Add another dependency."></a><a class="choice_removeDep ui-icon ui-icon-circle-minus" i="'+i+'" j="'+j+'" title="Delete this dependency."></a></div></div>';
						}
					}
					return '<div class="choicesSet '+((this.showDep)?"show":"hide")+'"><label>Choices <a class="helpfbuilder dep" text="Dependencies are used to show/hide other fields depending of the option selected in this field.">help?</a> <a href="" class="showHideDependencies">'+((this.showDep)?"Hide":"Show")+' Dependencies</a></label><div><div class="t">Text</div><div class="t">Value</div><div>optgroup</div><div class="clearer" /></div>'+str+this.mergeValues()+this.attributeToSubmit()+this.multipleSelection()+'</div>';
				}
	});