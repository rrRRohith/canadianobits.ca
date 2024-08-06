		$.fbuilder.controls['fslider'] = function(){};
		$.extend(
			$.fbuilder.controls['fslider'].prototype,
			$.fbuilder.controls['ffields'].prototype,
			{
				title:"Slider",
				ftype:"fslider",
				exclude:false,
				readonly:false,
				predefined:"",
				predefinedMin:"",
				predefinedMax:"",
				predefinedClick:false,
				size:"small",
				thousandSeparator:",",
				centSeparator:".",
				typeValues:false,
				min:0,
				max:100,
				step:1,
				range:false,
				logarithmic:false,
				minCaption:"",
				maxCaption:"",
				caption:"{0}",
				_expon : function(v)
					{
						if(v == 0) return v;
						var el   = $('#'+this.name+'_slider'),
							step = el.slider('option', 'step'),
							min  = Math.max(el.slider('option', 'min'), step),
							max  = el.slider('option', 'max'),

							minv = Math.log(Math.max(min, 0.1)),
							maxv = Math.log(max),
							scale = (maxv - minv) / (max - min);

						return Math.round( Math.exp(minv + scale * (v - min))/step ) * step;
					},
				_inverse : function(v)
					{
						var el   = $('#'+this.name+'_slider'),
							min  = el.slider('option', 'min'),
							max  = el.slider('option', 'max'),
							step = el.slider('option', 'step'),

							minv = Math.log(Math.max(min, 0.1)),
							maxv = Math.log(max),
							scale = (maxv - minv) / (max - min);

						return Math.round( ( ( Math.log(v) - minv ) / scale + min ) / step )*step;
					},
				_setThousandsSeparator : function(v)
					{
						v = $.fbuilder.parseVal(v, this.thousandSeparator, this.centSeparator);
						if(!isNaN(v))
						{
							v = v.toString();
							var parts = v.toString().split("."),
								counter = 0,
								str = '';

							for(var i = parts[0].length-1; i >= 0; i--)
							{
								counter++;
								str = parts[0][i] + str;
								if(counter%3 == 0 && i != 0) str = this.thousandSeparator + str;

							}
							parts[0] = str;

							if(typeof parts[1] != 'undefined' && parts[1].length == 1)
							{
								parts[1] += '0';
							}

							return parts.join(this.centSeparator);
						}
						else
						{
							return v;
						}
					},
				_setFieldValue:function(val, nochange)
					{
						var me = this;
						if(me.range)
						{
							var values = ( typeof val != 'undefined' && val !== null ) ? val : $('#'+me.name+'_slider').slider('values'),
								vl  = values[0], vr = values[1],
								vlf = me._setThousandsSeparator(vl),
								vrf = me._setThousandsSeparator(vr);

							$('#'+me.name+'_component_left').val(vlf);
							$('#'+me.name+'_component_right').val(vrf);
							$('#'+me.name).val('['+vl+','+vr+']').attr('vt', '['+vlf+','+vrf+']');
							$('#'+me.name+'_caption').html(
								me.caption
								  .replace(/\{\s*0\s*\}/, vlf)
								  .replace(/\{\s*0\s*\}/, vrf)
							);
						}
						else
						{
							var v  = ( typeof val != 'undefined' && val !== null ) ? val : $('#'+me.name+'_slider').slider('value'),
								vf = me._setThousandsSeparator(v);

							$('#'+me.name).val(v).attr('vt', vf);
							$('#'+me.name+'_component_center').val(vf);
							$('#'+me.name+'_caption').html(
								me.caption.replace(/\{\s*0\s*\}/, vf)
							);
						}
						if(!nochange) $('#'+me.name).change();
					},
				_toNumber:function(n){return (new String(n)).replace(/[^\-\d\.]/g,'')*1;},
				init:function()
					{
						this.min  = (/^\s*$/.test(this.min)) ? 0   : $.trim(this.min);
						this.max  = (/^\s*$/.test(this.max)) ? 100 : $.trim(this.max);
						this.step = (/^\s*$/.test(this.step)) ? 1   : $.trim(this.step);
						this.predefinedMin = (/^\s*$/.test(this.predefinedMin))? this.min : this._toNumber(this.predefinedMin);
						this.predefinedMax = (/^\s*$/.test(this.predefinedMax))? this.max : this._toNumber(this.predefinedMax);
						this._setHndl('min');
						this._setHndl('max');
						this._setHndl('step');
						this.centSeparator = (/^\s*$/.test(this.centSeparator)) ? '.' : $.trim(this.centSeparator);
					},
				show:function()
					{
						var me = this;
						function typeValuesComponents()
						{
							function component(c)
							{
								var min = cff_esc_attr(me.min),
									max = cff_esc_attr(me.max),
									step = cff_esc_attr(me.step),
									predefined = cff_esc_attr(
										(c == 'left') ? me.predefinedMin :
										((c == 'right') ? me.predefinedMax : me.predefined)
									),
									timeoutId;

								$(document).on('keyup change', '#'+me.name+'_component_'+c, function(evt){
                                    function stepRound(v)
                                    {
                                        var _e    = $('#'+me.name+'_slider'),
                                            _max  = _e.slider('option', 'max'),
                                            _step = _e.slider('option', 'step');
                                        return MIN(CEIL(v, _step), _max);
                                    };
									var v = $('#'+me.name+'_component_center').val(),
										v1 = $('#'+me.name+'_component_left').val(),
										v2 = $('#'+me.name+'_component_right').val(),
										t = 0;
									clearTimeout(timeoutId);
									if(evt.type == 'keyup') t = 2500;
									timeoutId = setTimeout(function(){
										if(v != undefined)
										{
											v = $.fbuilder.parseVal(v, me.thousandSeparator, me.centSeparator);
											if(isNaN(v)) v = 0;
										}
										if(v1 != undefined)
										{
											v1 = $.fbuilder.parseVal(v1, me.thousandSeparator, me.centSeparator);
											if(isNaN(v1)) v1 = 0;
										}
										if(v2 != undefined)
										{
											v2 = $.fbuilder.parseVal(v2, me.thousandSeparator, me.centSeparator);
											if(isNaN(v2)) v2 = 0;
										}
										$('#'+me.name+'_slider').slider(
											((v != undefined) ? 'value' : 'values'),
											((v != undefined) ? (me.logarithmic ? me._inverse(v*1) : stepRound(v*1)) : [stepRound(Math.min(v1*1,v2*1)), stepRound(Math.max(v1*1,v2*1))])
										);
										me._setFieldValue(me.logarithmic ? v : null);
									}, t);
								});
								return '<div class="slider-type-'+c+'-component"><input aria-label="'+cff_esc_attr(me.title)+'" id="'+me.name+'_component_'+c+'" class="large" type="text" value="'+cff_esc_attr(
									/fieldname/.test(predefined) &&
									getField(predefined) &&
									'val' in getField(predefined)
									? getField(predefined).val()
									: predefined
								)+'" '+((me.readonly) ? 'readonly' : '')+' /></div>';
							};

							var str = '';
							if(me.typeValues)
								str += '<div class="slider-type-components '+me.size+'">'+
								((me.range) ? component('left')+component('right') : component('center'))+
								'</div>';
							return str;
						};
						me.predefined = (/^\s*$/.test(me.predefined)) ? me.min : me._toNumber(me._getAttr('predefined'));
						return '<div class="fields '+cff_esc_attr(me.csslayout)+' '+me.name+' cff-slider-field" id="field'+me.form_identifier+'-'+me.index+'">'+
							'<label for="'+me.name+'">'+me.title+'</label>'+
							'<div class="dfield slider-container">'+
								typeValuesComponents()+
								'<input id="'+me.name+'" name="'+me.name+'" class="field" type="hidden" value="'+cff_esc_attr(me.predefined)+'"/>'+
								'<div id="'+me.name+'_slider" class="slider '+me.size+'"></div>'+
								'<div class="corner-captions '+me.size+'">'+
									'<span class="left-corner">'+me.minCaption+'</span>'+
									'<span class="right-corner">'+me.maxCaption+'</span>'+
									'<div id="'+me.name+'_caption" class="slider-caption"></div>'+
									'<div class="clearer"></div>'+
								'</div>'+
								'<span class="uh">'+me.userhelp+'</span>'+
							'</div>'+
							'<div class="clearer"></div>'+
						'</div>';
					},
				set_min:function(v, ignore)
					{
						try{
							var e = $('[id="'+this.name+'_slider"]'), c = this.val(), r = false;
							if(ignore) v = 0;
							e.slider('option', 'min', v);
							if($.isArray(c)){if(c[0] < v){c[0] = v; r = true;}}
							else if(c < v){c = v; r = true;}
							if(r) this.setVal(c);
							this.set_min_caption(v);
						}
						catch(err){}
					},
				set_max:function(v, ignore)
					{
						try{
							var e = $('[id="'+this.name+'_slider"]'), c = this.val(), r = false;
							if(ignore) v = 100;
							e.slider('option', 'max', v);
							if($.isArray(c)){if(v < c[1]){c[1] = v; r = true;}}
							else if(v < c){c = v; r = true;}
							if(r) this.setVal(c);
							this.set_max_caption(v);
						}
						catch(err){}
					},
				set_min_caption:function(v)
					{
						try{
							var e = $('.'+this.name+' .left-corner');
							e.html(this.minCaption.replace(/\{\s*0\s*\}/, v));
						}
						catch(err){}
					},
				set_max_caption:function(v)
					{
						try{
							var e = $('.'+this.name+' .right-corner');
							e.html(this.maxCaption.replace(/\{\s*0\s*\}/, v));
						}
						catch(err){}
					},
				set_step:function(v, ignore)
					{
						try{
							if(ignore) v = 1;
							$('[id="'+this.name+'_slider"]').slider("option", "step", v);
						}
						catch(err){}
					},
				after_show:function()
					{
						var me  = this,
							opt = {
								range: (me.range != false) ? me.range : "min",
								min  : me._getAttr('min'),
								max  : me._getAttr('max'),
								step : me._getAttr('step')
							};

						me.set_min_caption(opt.min);
						me.set_max_caption(opt.max);

						if(me.range)
						{
							var _min = Math.min(Math.max(me._getAttr('predefinedMin'), opt.min), opt.max),
								_max = Math.min(Math.max(me._getAttr('predefinedMax'), opt.min), opt.max);
							opt['values'] = [_min, _max];
						}
						else opt['value'] = Math.min(Math.max(me._getAttr('predefined'), opt.min), opt.max);

						opt['disabled'] = me.readonly;

						opt['slide'] = opt['stop'] = (function(e){
							return function(event, ui)
								{
									var v = (typeof ui.value != 'undefined') ? ui.value : ui.values;

									if ( me.logarithmic ) {
										v = me._expon(v);
										e._setFieldValue(v);
									} else {
										$(this).slider( Array.isArray(v) ? 'values' : 'value', v);
										e._setFieldValue();
									}
								}
						})(me);
						$('#'+this.name+'_slider').slider(opt);
						me._setFieldValue();
						$('#cp_calculatedfieldsf_pform'+me.form_identifier).bind('reset', function(){
							setTimeout(function(){
								$('#'+me.name+'_slider').slider(opt); me._setFieldValue();
							}, 20);
						});
					},
				val:function(raw)
					{
						try{
							raw = raw || false;
							var e = $('[id="' + this.name + '"]:not(.ignore)');
							return (e.length) ? ((raw) ? e.val() : JSON.parse(e.val())) : 0;
						}
						catch(err){return 0;}
					},
				setVal:function(v, nochange)
					{
						try{ v = JSON.parse(v); }catch(err){}
						try{
							$('[name="'+this.name+'"]').val(v);
							$('#'+this.name+'_slider').slider((($.isArray(v)) ? 'values' : 'value'), (this.logarithmic ? this._inverse(v) : v) );
							this._setFieldValue(v, nochange);
						}catch(err){}
					}
		});