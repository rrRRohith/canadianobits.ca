	$.fbuilder.controls['fcheck']=function(){};
	$.extend(
		$.fbuilder.controls['fcheck'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Check All That Apply",
			ftype:"fcheck",
			layout:"one_column",
			required:false,
            readonly:false,
			merge:1,
            onoff:0,
			max:-1,
			maxError:"Check no more than {0} boxes",
			toSubmit:"text",
			showDep:false,
			show:function()
				{
					this.choicesVal = ((typeof(this.choicesVal) != "undefined" && this.choicesVal !== null)?this.choicesVal:this.choices);
					var str = "",
                        classDep;

					if (typeof this.choicesDep == "undefined" || this.choicesDep == null)
						this.choicesDep = new Array();

					for (var i=0, h=this.choices.length; i<h; i++)
					{
						if(typeof this.choicesDep[i] != 'undefined')
							this.choicesDep[i] = $.grep(this.choicesDep[i],function(n){ return n != ""; });
						else
							this.choicesDep[i] = [];

						classDep = (this.choicesDep[i].length) ? 'depItem': '';

						str += '<div class="'+this.layout+'"><label for="'+this.name+'_cb'+i+'"><input aria-label="'+cff_esc_attr(this.choices[i])+'" name="'+this.name+'[]" id="'+this.name+'_cb'+i+'" class="field '+classDep+' group '+((this.required)?" required":"")+'" value="'+cff_esc_attr(this.choicesVal[i])+'" vt="'+cff_esc_attr((this.toSubmit == 'text') ? this.choices[i] : this.choicesVal[i])+'" type="checkbox" '+(this.readonly ? ' onclick="return false;" ' : '')+((this.choiceSelected[i])?"checked":"")+'/> '+
                        (this.onoff ? '<span class="cff-switch"></span>': '') +
                        '<span>'+
                        cff_html_decode(this.choices[i])+'</span></label></div>';
					}
					return '<div class="fields '+cff_esc_attr(this.csslayout)+(this.onoff ? ' cff-switch-container' : '')+' '+this.name+' cff-checkbox-field" id="field'+this.form_identifier+'-'+this.index+'"><label>'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield">'+str+'<div class="clearer"></div><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
            enable_disable:function()
                {
                    var m = this;
                    if(0 < m.max)
                    {
                        var d = true;
                        if($('[id*="'+m.name+'"]:checked').length < m.max) d = false;
                        $('[id*="'+m.name+'"]:not(:checked)').prop('disabled', d);
                    }
                },
            after_show:function()
                {
                    var m = this;
                    $(document).off('click','[id*="'+m.name+'"]')
					.on('click','[id*="'+m.name+'"]', function(){m.enable_disable();});
                    m.enable_disable();
                    if(0 < m.max)
                        $('[id*="'+m.name+'"]').rules('add',{maxlength:m.max, messages:{maxlength:m.maxError}});
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
					var v, me = this, m = me.merge && !raw,
						e = $('[id*="'+me.name+'"]:checked:not(.ignore)');

					if(!m) v = [];
					if(e.length)
					{
						e.each(function(){
							var t = (m) ? $.fbuilder.parseVal(this.value) : $.fbuilder.parseValStr((raw == 'vt') ? this.getAttribute('vt') : this.value, raw, no_quotes);
							if(!$.isNumeric(t)) t = t.replace(/^"/,'').replace(/"$/,'');
							if(m) v = (v)?v+t:t;
							else v.push(t);
						});
					}
					return (typeof v == 'object' && typeof v['length'] !== 'undefined') ? v : ((v) ? (($.isNumeric(v)) ? v : '"'+v+'"') : 0);
				},
			setVal:function(v, nochange, _default)
				{
                    _default = _default || false;
                    nochange = nochange || false;

					var t, n = this.name, c = 0, e;
					if(!$.isArray(v)) v = [v];
					$('[id*="'+n+'"]').prop('checked', false);
					for(var i in v)
					{
						t = (new String(v[i])).replace(/(['"])/g, "\\$1");
                        if(0 < this.max && this.max < c+1) break;
                        if(_default) e = $('[id*="'+n+'"][vt="'+t+'"]');
                        if(!_default || !e.length) e = $('[id*="'+n+'"][value="'+t+'"]');
                        if(e.length){ e.prop('checked', true);c++;}
					}
                    this.enable_disable();
					if(!nochange) $('[id*="'+n+'"]').change();
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
						var html = me.show(),
							e = $('.'+me.name),
							c  = e.attr('class'),
							i = e.find('.ignore').length,
							ipb = e.find('.ignorepb').length;
						e.replaceWith(html);
						e = $('.'+me.name);
						e.attr('class', c);
						if(i) e.find('input').addClass('ignore');
						if(ipb) e.find('input').addClass('ignorepb');
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
					var i = [];
					$('[name*="'+this.name+'"]').each(function(j,v){if(this.checked){i.push(j);}});
					return i;
				}
		}
	);