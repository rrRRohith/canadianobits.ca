	$.fbuilder.controls['fdropdown']=function(){};
	$.extend(
		$.fbuilder.controls['fdropdown'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Select a Choice",
			ftype:"fdropdown",
			size:"medium",
			required:false,
			toSubmit:"text",
			merge:0,
			choiceSelected:"",
            select2:false,
			multiple:false,
			vChoices:1,
			showDep:false,
			show:function()
				{
					this.choicesVal = ((typeof(this.choicesVal) != "undefined" && this.choicesVal !== null)?this.choicesVal:this.choices)

					var c	 = this.choices,
						cv	 = this.choicesVal,
						og   = (typeof this.optgroup == 'undefined') ? new Array() : this.optgroup,
						op_o = false,
						l 	 = c.length,
						classDep = '',
						str  = '';

					if (typeof this.choicesDep == "undefined" || this.choicesDep == null)
						this.choicesDep = new Array();

					for (var i=0;i<l;i++)
					{
						if(typeof this.choicesDep[i] != 'undefined' && (typeof og[i] == 'undefined' || !og[i]))
							this.choicesDep[i] = $.grep(this.choicesDep[i],function(n){ return n != ""; });
						else
							this.choicesDep[i] = [];

						if(this.choicesDep[i].length && (typeof og[i] == 'undefined' || !og[i]))
							classDep = 'depItem';
					}

					for (var i=0;i<l;i++)
					{
						if(og[i])
						{
							if(op_o) str += '</optgroup>';
							str += '<optgroup label="'+cff_esc_attr(c[i])+'">';
							op_o = true;
						}
						else
						{
							str += '<option '+((this.choiceSelected == c[i]+' - '+cv[i])?"selected":"")+' '+((classDep != '') ? 'class="'+classDep+'"' : '')+' value="'+cff_esc_attr(cv[i])+'" vt="'+cff_esc_attr((this.toSubmit=='text') ? c[i] : cv[i])+'" data-i="'+i+'">'+cff_esc_attr(c[i])+'</option>';
						}
					}
					if(op_o) str += '</optgroup>';
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-dropdown-field" id="field'+this.form_identifier+'-'+this.index+'"><label for="'+this.name+'">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label>'+
					'<div class="dfield"><select aria-label="'+cff_esc_attr(this.title)+'" id="'+this.name+'" name="'+this.name+((this.multiple)? '[]':'')+'" class="field '+((classDep != '') ? ' depItemSel ' : '')+this.size+((this.required)?' required':'')+'" '+((this.multiple == true)?' multiple="multiple" size="'+((this.vChoices) ? this.vChoices : 1)+'"':'')+'>'+str+'</select><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div><div class="clearer"></div></div>';
				},
            after_show:function()
                {
                    var me = this;
                    if(me.select2)
                    {
                        function formatState(state)
                        {
							return !state.id ? state.text : $('<span style="display:inline-flex;align-items:center">'+state.text+'</span>');
                        };

                        $('#'+me.name).after('<span class="cff-select2-container"></span>');
                        $('#'+me.name).on('change', function(){$(this).valid();});
                        if('select2' in $.fn)
                            $('#'+me.name).select2({
                                'templateResult': formatState,
                                'templateSelection': formatState,
                                'dropdownParent':$('#'+me.name).next('.cff-select2-container')
                            });
                        else
                            $(document).ready(function(){if('select2' in $.fn) $('#'+me.name).select2({'dropdownParent':$('#'+me.name).next('.cff-select2-container')});});
                    }
                },
			showHideDep:function(toShow, toHide, hiddenByContainer, interval)
				{
                    if(typeof hiddenByContainer == 'undefined') hiddenByContainer = {};
					var me = this,
						item = $('#'+me.name+'.depItemSel'),
						form_identifier = me.form_identifier,
						isHidden = (typeof toHide[me.name] != 'undefined' || typeof hiddenByContainer[me.name] != 'undefined'),
						result = [];

					try
					{
						if(item.length)
						{
							var selected = [];
							$(item).find(':selected').each(function(){selected.push($(this).data('i'));});

							for(var i = 0, h = me.choices.length; i < h; i++)
							{
								if(typeof me.choicesDep[i] != 'undefined' && me.choicesDep[i].length)
								{
									for(var j = 0, k = me.choicesDep[i].length; j < k; j++)
									{
										if(!/fieldname/i.test(me.choicesDep[i][j])) continue;
										var dep = me.choicesDep[i][j]+form_identifier;
										if(isHidden || $.inArray(i,selected) == -1)
										{
											if(typeof toShow[dep] != 'undefined')
											{
												delete toShow[dep]['ref'][me.name+'_'+i];
												if($.isEmptyObject(toShow[dep]['ref']))
												delete toShow[dep];
											}

											if(typeof toShow[dep] == 'undefined')
											{
												$('[id*="'+dep+'"],.'+dep).closest('.fields').hide();
												$('[id*="'+dep+'"]:not(.ignore)').addClass('ignore');
												toHide[dep] = {};
											}
										}
										else
										{
											delete toHide[dep];
											if(typeof toShow[dep] == 'undefined')
											toShow[dep] = { 'ref': {}};
											toShow[dep]['ref'][me.name+'_'+i]  = 1;
											if(!(dep in hiddenByContainer))
											{
												$('[id*="'+dep+'"],.'+dep).closest('.fields').fadeIn(interval || 0);
												$('[id*="'+dep+'"].ignore').removeClass('ignore');
											}
										}
										if($.inArray(dep,result) == -1) result.push(dep);
									}
								}
							}
						}
					}
					catch(e){}
					return result;
				},
			val:function(raw, no_quotes)
				{
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $('[id="'+this.name+'"]:not(.ignore) option:selected'),
						v,
						m = this.multiple,
						g = this.merge && !raw;

					if(m && !g)	v = [];
					if(e.length)
					{
						e.each(function(){
							var t = $.fbuilder.parseValStr((raw == 'vt') ? this.getAttribute('vt') : this.value, raw, no_quotes);
							if(!$.isNumeric(t)) t = t.replace(/^"/,'').replace(/"$/,'');
							if(!m || g) v = (v)?v+t:t;
							else v.push(t);
						});
					}
					return (typeof v == 'object' && typeof v['length'] !== 'undefined') ? v : ((v) ? (($.isNumeric(v)) ? v : '"'+v+'"') : 0);
				},
			setVal:function(v, nochange, _default)
				{
                    _default = _default || false;
                    nochange = nochange || false;
					if(!$.isArray(v)) v = [v];
					var t, e, n = this.name, selector;
					for(var i in v)
					{
						t = (new String(v[i])).replace(/(['"])/g, "\\$1");
                        if(_default) e = $('[id="'+n+'"] OPTION[vt="'+t+'"]');
                        if(!_default || !e.length) e = $('[id="'+n+'"] OPTION[value="'+t+'"]');
                        if(e.length) e.prop('selected', true);
					}
					if(!nochange) $('[id="'+n+'"]').change();
				},
			setChoices:function(choices)
				{
					if($.isPlainObject(choices))
					{
						var me = this,
                            bk = me.val(true);

						if('texts' in choices && $.isArray(choices.texts)) me.choices = choices.texts;
						if('values' in choices && $.isArray(choices.values)) me.choicesVal = choices.values;
                        if('dependencies' in choices && $.isArray(choices.dependencies))
                        {
                            me.choicesDep = choices.dependencies.map(
                                function(x){
                                    return ($.isArray(x)) ? x.map(
                                        function(y){
                                            return (typeof y == 'number') ? 'fieldname'+parseInt(y) : y;
                                        }) : x;
                                }
);
                        }
						if('optgroup' in choices && $.isArray(choices.optgroup)) me.optgroup = choices.optgroup;
						var html = me.show(),
							e = $('.'+me.name),
							c  = e.attr('class'),
							i = e.find('.ignore').length,
							ipb = e.find('.ignorepb').length;
						e.replaceWith(html);
						e = $('.'+me.name);
						e.attr('class', c);
						if(i) e.find('select').addClass('ignore');
						if(ipb) e.find('select').addClass('ignorepb');
						if(i || ipb) e.hide();
                        if(!$.isArray(bk)) bk = [bk];
                        for(var j in bk)
                        {
                            try{ bk[j] = JSON.parse(bk[j]); }catch(err){}
                        }
						me.setVal(bk, bk.every(function(e){ return me.choicesVal.indexOf(e) > -1; }));
					}
				},
			getIndex:function()
				{
					var f = $('[name*="'+this.name+'"]');
					if(this.multiple){
						var i = [];
						f.find('option').each(function(j,v){if(this.selected) i.push(j);});
						return i;
					}
					else return f[0].selectedIndex;
				}
		}
	);