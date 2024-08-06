	$.fbuilder.controls['fradio']=function(){};
	$.extend(
		$.fbuilder.controls['fradio'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Select a Choice",
			ftype:"fradio",
			layout:"one_column",
			required:false,
            readonly:false,
			onoff:0,
			toSubmit:"text",
			choiceSelected:"",
			showDep:false,
			untickAccepted:true,
			initStatus:function()
				{
					$('[id*="'+this.name+'_"]').each(function(){$(this).data('previous-status', this.checked);});
				},
			show:function()
				{
					this.choicesVal = ((typeof(this.choicesVal) != "undefined" && this.choicesVal !== null)?this.choicesVal:this.choices);

					var l 		 = this.choices.length,
						str 	 = "",
						classDep = "";

					if (typeof this.choicesDep == "undefined" || this.choicesDep == null)
						this.choicesDep = new Array();

					for (var i=0;i<l;i++)
					{
						if(typeof this.choicesDep[i] != 'undefined')
							this.choicesDep[i] = $.grep(this.choicesDep[i],function(n){ return n != ""; });
						else
							this.choicesDep[i] = [];

						if(this.choicesDep[i].length)
							classDep = 'depItem';
					}

					for (var i=0;i<l;i++)
					{
						str += '<div class="'+this.layout+'"><label for="'+this.name+'_rb'+i+'"><input aria-label="'+cff_esc_attr(this.choices[i])+'" name="'+this.name+'" id="'+this.name+'_rb'+i+'" class="field '+classDep+' group '+((this.required)?" required":"")+'" value="'+cff_esc_attr(this.choicesVal[i])+'" vt="'+cff_esc_attr((this.toSubmit=='text') ? this.choices[i] : this.choicesVal[i])+'" type="radio" '+(this.readonly ? ' onclick="return false;" ' : '')+((this.choices[i]+' - '+this.choicesVal[i]==this.choiceSelected)?"checked":"")+'/> '+
                        (this.onoff ? '<span class="cff-switch"></span>': '') +
                        '<span>'+cff_html_decode(this.choices[i])+'</span></label></div>';
					}

					return '<div class="fields '+cff_esc_attr(this.csslayout)+(this.onoff ? ' cff-switch-container' : '')+' '+this.name+' cff-radiobutton-field" id="field'+this.form_identifier+'-'+this.index+'"><label>'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield">'+str+'<div class="clearer"></div><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
			after_show: function()
				{
					var me = this,
						n = me.name;

					me.initStatus();
					if(me.untickAccepted)
					{
						$(document).off('click', '[id*="'+n+'_"]').on('click', '[id*="'+n+'_"]', function(){
							var m = this,
								e = $(m);

							$('[id*="'+n+'_"]').each(function(){if(m !== this) $(this).data('previous-status', false);});
							if(e.data('previous-status')){ m.checked = false; e.change();}
							e.data('previous-status', m.checked);
						});
					}
				},
			showHideDep:function(toShow, toHide, hiddenByContainer, interval)
				{
                    if(typeof hiddenByContainer == 'undefined') hiddenByContainer = {};
					var me		= this,
						item 	= $('input[id*="'+me.name+'"]'),
						form_identifier = me.form_identifier,
						isHidden = (typeof toHide[me.name] != 'undefined' || typeof hiddenByContainer[me.name] != 'undefined'),
						result 	= [];

					try
					{
						item.each(function(i,e){
							if(typeof me.choicesDep[i] != 'undefined' && me.choicesDep[i].length)
							{
								var checked = e.checked;
								for(var j = 0, k = me.choicesDep[i].length; j < k; j++)
								{
									if(!/fieldname/i.test(me.choicesDep[i][j])) continue;
									var dep = me.choicesDep[i][j]+form_identifier;
									if(isHidden || !checked)
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
						});
					}
					catch(e){  }
					return result;
				},
			val:function(raw, no_quotes)
				{
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $('[id*="' + this.name + '"]:not(.ignore):checked');
					if(e.length) return $.fbuilder.parseValStr((raw == 'vt') ? e.attr('vt') : e.val(), raw, no_quotes);
					return 0;
				},
			setVal:function(v, nochange, _default)
				{
                    _default = _default || false;
                    nochange = nochange || false;

					var t = (new String(v)).replace(/(['"])/g, "\\$1"), n = this.name, e;
					$('[id*="'+n+'"]').prop('checked', false);
                    if(_default) e = $('[id*="'+n+'"][vt="'+t+'"]');
                    if(!_default || !e.length) e = $('[id*="'+n+'"][value="'+t+'"]');
                    if(e.length) e.prop('checked', true);
					this.initStatus();
					if(!nochange) $('[id*="'+n+'"]').change();
				},
			setChoices:function(choices)
				{
					if($.isPlainObject(choices))
					{
						var bk = this.val(true);
						if('texts' in choices && $.isArray(choices.texts)) this.choices = choices.texts;
						if('values' in choices && $.isArray(choices.values)) this.choicesVal = choices.values;
                        if('dependencies' in choices && $.isArray(choices.dependencies))
                        {
                            this.choicesDep = choices.dependencies.map(
                                function(x){
                                    return ($.isArray(x)) ? x.map(
                                        function(y){
                                            return (typeof y == 'number') ? 'fieldname'+parseInt(y) : y;
                                        }) : x;
                                }
                          );
                        }
						var html = this.show(),
							e = $('.'+this.name),
							c  = e.attr('class'),
							i = e.find('.ignore').length,
							ipb = e.find('.ignorepb').length;
						e.replaceWith(html);
						e = $('.'+this.name);
						e.attr('class', c);
						if(i) e.find('input').addClass('ignore');
						if(ipb) e.find('input').addClass('ignorepb');
						if(i || ipb) e.hide();
                        try{ bk = JSON.parse(bk); }catch(err){}
						this.setVal(bk, this.choicesVal.indexOf(bk) > -1);
					}
				},
			getIndex:function()
				{
					var i = -1;
					$('[name*="'+this.name+'"]').each(function(j,v){if(this.checked){i = j; return false;}});
					return i;
				}
		}
	);