	$.fbuilder.controls['fCalculated'] = function(){};
	$.extend(
		$.fbuilder.controls['fCalculated'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"fCalculated",
			predefined:"",
			required:false,
			size:"medium",
            min:"",
            max:"",
			eq:"",
			suffix:"",
			prefix:"",
			decimalsymbol:".",
			groupingsymbol:"",
			dependencies:[{'rule' : '', 'complex' : false, 'fields' : [''] }],
			readonly:true,
			currency:false,
			noEvalIfManual:true,
			formatDynamically:false,
			hidefield:false,
            configuration : function()
                {
                    var me = this;
					return { "suffix" : me.suffix, "prefix" : me.prefix, "groupingsymbol" : me.groupingsymbol, "decimalsymbol" : me.decimalsymbol, "currency": me.currency };
                },
			show:function()
				{
					this.predefined = this._getAttr('predefined');
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-calculated-field" id="field'+this.form_identifier+'-'+this.index+'" style="'+((this.hidefield)? 'padding:0;margin:0;border:0;opacity:0;width:0;height:0;overflow:hidden;' : '')+'"><label for="'+this.name+'">'+this.title+''+((this.required) ? '<span class="r">*</span>' : '')+'</label><div class="dfield"><input aria-label="'+cff_esc_attr(this.title)+'" id="'+this.name+'" name="'+this.name+'" '+((this.readonly) ? ' readonly ' : '')+' '+((!/^\s*$/.test(this.min)) ? 'min="'+cff_esc_attr($.fbuilder.parseVal(this._getAttr('min'), this.thousandSeparator, this.decimalSymbol))+'" ' : '')+((!/^\s*$/.test(this.max)) ? ' max="'+cff_esc_attr($.fbuilder.parseVal(this._getAttr('max'), this.thousandSeparator, this.decimalSymbol))+'" ' : '')+' class="codepeoplecalculatedfield field '+this.size+((this.required)?" required":"")+'" type="'+((this.hidefield) ? 'hidden' : 'text')+'" value="'+cff_esc_attr(this.predefined)+'" />'+((!this.hidefield) ? '<span class="uh">'+this.userhelp+'</span>' : '')+'</div><div class="clearer"></div></div>';
				},
            after_show:function()
				{
	                // Add equations
					var me = this,
						dependencies = [];

					$.each(me.dependencies, function(i, d)
						{
							d.rule = d.rule.replace(/^\s+/, '').replace(/\s+$/, '');
							if(d.rule != '' && d.fields.length){

								var fields = [];
								$.each(d.fields, function(j, f){
									if(f != '')
									{
										fields.push(f);
									}
								});

								if(fields.length){
									dependencies.push({ 'rule' : d.rule, 'fields' : fields });
								}
							}
						});

					me.dependencies = dependencies;
					var eq = me.eq;
					eq = eq.replace(/\n/g, ' ').replace(/fieldname(\d+)/g, "fieldname$1"+me.form_identifier).replace(/form_identifier/g, '\''+this['form_identifier']+'\'').replace(/;\s*\)/g, ')').replace(/;\s*$/, '');

					if(!/^\s*$/.test(eq))
                    {
                        $.fbuilder.calculator.addEquation(me, eq, dependencies, me.form_identifier);
                    }

                    // Events
			        var e = $('[id="'+me.name+'"]');

					e.bind(
                        'calcualtedfield_changed',
                        {obj: me},
                        function(evt){
							if($.fbuilder['calculator'].getDepList(evt.data.obj.name, {value: evt.data.obj.val(), raw: evt.data.obj.val(true)}, evt.data.obj.dependencies))
                            {
								$.fbuilder.showHideDep(
                                                {
                                                    'formIdentifier' : evt.data.obj.form_identifier,
                                                    'fieldIdentifier': evt.data.obj.name
                                                }
                                         );
                            }
                        }
                 ).on('keyup', function(){
                        if(!me.readonly)
                        {
                            if(me.noEvalIfManual) e.data('manually', 1);
                            e.trigger('calcualtedfield_changed');
                        }
                    }).on('change', function(){
                        if(
                            e.data('manually') &&
                            e.data('manually') == 1 &&
                            me.formatDynamically
                     )
                        {
                            var v = me.val(true, true);
                            this.value = $.fbuilder.calculator.format(v, me.configuration());
                        }
                        try
                        {
                            $(this).valid();
                        } catch(err) {}
					});

					$('#cp_calculatedfieldsf_pform'+me.form_identifier).bind('reset', function(){e.removeData('manually');});
				},
			showHideDep: function(toShow, toHide, hiddenByContainer, interval)
				{
                    if(typeof hiddenByContainer == 'undefined') hiddenByContainer = {};
					var me   	= this,
						result 	= [];

					if($.fbuilder['calculator'].getDepList(me.name, {value: me.val(), raw: me.val(true)}, me.dependencies))
					{
						var	item 	= $('#'+me.name),
							identifier = me.form_identifier,
							isHidden= (typeof toHide[me.name] != 'undefined' || typeof hiddenByContainer[me.name] != 'undefined'),
							d, n, dep,
							clearRef = function(id){
								if(typeof toShow[id] != 'undefined')
								{
									delete toShow[id]['ref'][me.name];
									if($.isEmptyObject(toShow[id]['ref']))
									delete toShow[id];
								}
							},
							hideField = function(id){
								$('[id*="'+id+'"],.'+id).closest('.fields').hide();
								$('[id*="'+id+'"]:not(.ignore)').addClass('ignore');
								toHide[id] = {};
							};

						try
						{
							d = item.attr('dep');
							if(typeof d != 'undefined' && !/^\s*$/.test(d)) d = d.split(',');
							else d = [];

							n = item.attr('notdep');
							if(typeof n != 'undefined' && !/^\s*$/.test(n)) n = n.split(',');
							else n = [];

							if(isHidden)
							{
								n = n.concat(d);
								d = [];
							}

							for (i=0; i<d.length; i++)
							{
								if(!/fieldname/i.test(d[i])) continue;
								dep = d[i]+identifier;
								delete toHide[dep];
								if(typeof toShow[dep] == 'undefined')
								toShow[dep] = { 'ref': {}};
								toShow[dep]['ref'][me.name]  = 1;
								if(!(dep in hiddenByContainer))
								{
									$('[id*="'+dep+'"],.'+dep).closest('.fields').fadeIn(interval || 0);
									$('[id*="'+dep+'"].ignore').removeClass('ignore');
								}
								if($.inArray(dep,result) == -1) result.push(dep);
							}

							for (i=0; i<n.length; i++)
							{
								if(!/fieldname/i.test(n[i])) continue;
								dep = n[i]+identifier;
								clearRef(dep);
								if (
									typeof toShow[dep] == 'undefined' &&
									typeof toHide[dep] == 'undefined'
								) hideField(dep);
								if($.inArray(dep,result) == -1) result.push(dep);
							}
						}
						catch(e){}
					}
					return result;
				},
			val: function(raw, no_quotes)
				{
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $('[id="'+this.name+'"]:not(.ignore)');
					if(e.length)
					{
						var v = e.val();
						if(raw) return $.fbuilder.parseValStr(v, raw, no_quotes);
						v = $.trim(v);

						v = v.replace(new RegExp($.fbuilder['escapeSymbol'](this.prefix), 'g'), '')
						     .replace(new RegExp($.fbuilder['escapeSymbol'](this.suffix), 'g'), '');

						return $.fbuilder.parseVal(v, this.groupingsymbol, this.decimalsymbol, no_quotes);
					}
					return 0;
				}
		}
	);

	/*
	* Extend the window object with the methods of obj, the prefix is used to avoid redefine window methods
	*/
	$.fbuilder['extend_window']  = function(prefix, obj)
		{
			for(method in obj)
			{
				window[prefix+method] = (function(m)
					{
						return function()
							{
								return m.obj[m.method_name].apply(m.obj, arguments);
							};
					})({ "method_name" : method, 'obj' : obj });
			}
		};

	// Calculate Field code
	$.fbuilder['calculator'] = (function()
		{
				// Used to validate the equations results
				var validators = [];

                // Loading available modules
				if(typeof $.fbuilder['modules'] != 'undefined')
				{
					var modules = $.fbuilder['modules'];
					for(var module in modules)
					{
						if(typeof modules[module]['callback'] != 'undefined')
						{
							modules[module]['callback']();
						}

						if(typeof modules[module]['validator'] != 'undefined')
						{
							validators.push(modules[module]['validator']);
						}
					}
				}

				// Private function to validate the equation results
				_validate_result = function(v)
					{
						if(validators.length)
						{
							var h = validators.length;
							while(h--)
							{
								if(validators[h](v))
								{
									return true;
								}
							}
						}
						else
						{
							return true;
						}

						return false;
					};

				// Private function, the variable names in the equations are replaced by its values, return the equation result or false if error
				_eval = function(eq)
					{
						return eval(eq); // Evaluate the final equation
					};

				_calculate = function(eq, suffix, __ME__)
					{
						var e = $.fbuilder['forms'][suffix].getItem(__ME__),
							__ME__ = e.val();

						if($('#'+e.name).data('manually') == 1) return __ME__;

						var	_match,
							field_regexp = new RegExp('(fieldname\\d+'+suffix+')(_[cr]b\\d+)?(\\|[rnv])?([\\D\\b])','i');

						$.fbuilder['currentFormId'] = $.fbuilder['forms'][suffix].formId;
						eq = '('+eq+')';
						while (_match = field_regexp.exec(eq))
						{
							var field = $.fbuilder['forms'][suffix].getItem(_match[1]),
								v = '';
							if(field)
							{
								if(_match[3] && _match[3] == '|n')
								{
									v = '"'+_match[1].match(/fieldname\d+/)[0]+'"';
								}
								else
								{
									v = field.val((_match[3]) ? ((_match[3] == '|v') ? 'vt' : ((_match[3] == '|r') ? true : false)) : false);
									if(typeof v == 'object' && typeof window.JSON != 'undefined') v = JSON.stringify(v);
									else if($.isNumeric(v)) v = '('+v+')';
								}
							}
							eq = eq.replace(_match[0], v+''+_match[4]); // Replace the variable name by value
						}
						try
						{
							var r = _eval(eq.replace(/^\(/, '').replace(/\)$/, '').replace(/\b__ME__\b/g, __ME__)); // Evaluate the final equation
							return (typeof r != 'undefined' && _validate_result(r)) ? r : false;
						}
						catch(e)
						{
							if(typeof console != 'undefined'){console.log(eq); console.log(e.message);}
							return false;
						}
					};

				_checkValueThrowingEquation = function(t)
					{
						if(typeof t.attr('data-timeout') != 'undefined') clearTimeout(t.attr('data-timeout'));
						if(typeof t.attr('data-previousvalue') == 'undefined') t.attr('data-previousvalue', t.val());
						else
						{
							if(t.val() == t.attr('data-previousvalue'))
							{
								t.removeAttr('data-timeout');
								obj.Calculate(t[0]);
								return;
							}
							t.attr('data-previousvalue',  t.val());
						}
						t.attr('data-timeout',  setTimeout(_checkValueThrowingEquation, 500, t));
					};

				// The public object
                var CalcFieldClss = function(){};
				CalcFieldClss.prototype = {
					processing_queue : {}, // Flag indicating the queued equations are being processed
					pendings : {},
					// object where attributes names are the forms identifiers, and their values the queue of equations
					queued_equations : {},
					addPending : function(form_identifier)
					{
						if(!(form_identifier in this.pendings)) this.pendings[form_identifier] = 1;
						else this.pendings[form_identifier]++;
					},
					removePending : function(form_identifier)
					{
						if((form_identifier in this.pendings) && this.pendings[form_identifier]) this.pendings[form_identifier]--;
					},
					thereIsPending : function(form_identifier)
					{
						if(form_identifier in this.pendings) return this.pendings[form_identifier];
						return 0;
					},
					addEquation : function(fieldObj, equation, dependencies, form_identifier)
						{
							var equation_result = $('[id="'+fieldObj.name+'"]');
							if(equation_result.length)
							{
								var form = equation_result[0].form,
									equationObj, field,
									regexp = new RegExp('(fieldname\\d+)_'),
									match;

								if(typeof form.equations == 'undefined') form['equations'] = [];
								var  i, j=-1, h = form.equations.length;

								// Avoid insert the equation multiple times to the form
								for(i = 0 ; i < h; i++)
								{
									if(form.equations[i].result == fieldObj.name) break;
									if(form.equations[i].equation.match(fieldObj.name)){ j = i; break; }
								}

								// The equation hasn't been inserted previously
								if(i == h || j != -1)
								{
                                    /* conf attribute only for compatibility */
									equationObj = {'result':fieldObj.name, 'resultField':fieldObj, 'equation':equation, 'conf':fieldObj.configuration(), 'dep':dependencies, 'identifier':form_identifier};
									form.equations.splice(i, 0, equationObj);

									while(match = /(pdfpagesnumber|imgdimension|viewfile|csvtojson)\s*\(\s*fieldname\d+_\d+(\|n)\b/i.exec(equation)) {
										equation = equation.replace(match[2], match[0].replace('|n', ''));
									}
									equation = equation.replace(/fieldname\d+_\d+\|n\b/g, '');
									while (match = regexp.exec(equation))
									{
										field = $.fbuilder['forms'][form_identifier].getItem(match[1]+form_identifier);
										if(field)
										{
											if(typeof field.usedInEquations == 'undefined') field.usedInEquations = [];
											field.usedInEquations.push(equationObj);
										}
										equation = equation.replace(new RegExp(match[0], 'g'), '');
									}
								}
							}

						},
					enqueueEquation : function(form_identifier, equations)
						{
							if(typeof this.queued_equations[form_identifier] == 'undefined')
								this.queued_equations[form_identifier] = [];
							var queue = this.queued_equations[form_identifier], f;

							for(var i = 0, h = equations.length; i < h; i++)
							{
								f = -1;
								for(var j = 0, k = queue.length; j < k; j++)
								{
									if(queue[j].result == equations[i].result) break;
									if(queue[j].equation.match(equations[i].result)){ f = j; break; }
								}
								if(j == k || f != -1)
								{
									queue.splice(j, 0, equations[i]);
								}
							}
						},
					getDepList : function(calculated_field, values, dependencies) // Get the list of dependent fields
						{
							var list    = [], // Fields that comply the rules
								list_h  = []; // Fields that don't comply the rules

							// The value is correct and the field has dependencies
							if(values.value !== false && dependencies.length)
							{
								for(var i = 0, h = dependencies.length; i < h; i++)
								{
									try
									{
										// Get the rule and evaluate
										var rule = eval(dependencies[i].rule.replace(/value\|r/gi, values.raw).replace(/value/gi, values.value));
										$.each(dependencies[i].fields, function(j, e)
											{
												if(e != '')
												{
													if(rule)
													{
														var k = $.inArray(e, list_h);
                                                        while(k != -1)
                                                        {
                                                            list_h.splice(k, 1);
                                                            k = $.inArray(e, list_h);
                                                        }
														if($.inArray(e, list) == -1) list.push(e);
													}
													else
													{
														if($.inArray(e, list) == -1) list_h.push(e);
													}
												}
											});

									}
									catch(e)
									{
										if(typeof console != 'undefined') console.log(e.message);
										continue;
									}
								}
							}

							$('[id="'+calculated_field+'"]').attr('dep', list.join(',')).attr('notdep', list_h.join(','));
							return list.length || list_h.length;
						},

                    defaultCalc : function(form, enqueued) // Evaluate all equations in form
						{
							var dep  = false;
							form = $(form);

							// The form exists and has equations
							if(form.length)
							{
								var fSec  = form.attr('id').match(/_\d+$/)[0];
								if(enqueued)
								{
									this.processQueue(fSec);
								}
								else if(typeof form[0].equations != 'undefined')
								{
									this.queued_equations[fSec] = form[0].equations.slice(0);
									this.processQueue(fSec);
								}
								$(form).trigger('cpcff_default_calc');
							}
						},

                    Calculate : function (field)
						{
							if(field.id == undefined) return;
							var id 	 = field.id.replace(/_[cr]b\d+$/i,''),
								fSec  = id.match(/(_\d+)?_\d+$/),
								item,
								me   = this;

							if(fSec)
							{
								fSec = (typeof fSec[1] != 'undefined') ? fSec[1] : fSec[0];
								item = $.fbuilder['forms'][fSec].getItem(id);
								if(item && typeof item['usedInEquations'] != 'undefined')
								{
									me.enqueueEquation(fSec, item.usedInEquations);
									me.processQueue(fSec);
								}
							}
						},
					processQueue : function(fSec)
						{
							var me = this;
							if(fSec in me.processing_queue && me.processing_queue[fSec])
							{
								setTimeout(
									(function ( fSec ) {
										if(fSec in me.processing_queue && me.processing_queue[fSec]) {
											me.processing_queue[fSec] = false;
											me.processQueue(fSec);
										}
									})(fSec),
									(typeof CFF_PROCESS_QUEUE_INTERVAL != 'undefined') ? CFF_PROCESS_QUEUE_INTERVAL : 3000
								);
								return;
							}
							me.processing_queue[fSec] = true;

							if(typeof me.queued_equations[fSec] != 'undefined')
							{
								var queue = me.queued_equations[fSec], eq_obj;
								while(queue.length)
								{
									eq_obj = queue.shift();
									$.fbuilder['currentEq'] = eq_obj;
									var field = $('[id="'+eq_obj.result+'"]'),
										result = _calculate(eq_obj.equation,  eq_obj.identifier,  eq_obj.result),
										bk =  field.data('bk');

									field.val((result !== false) ? me.format(result, eq_obj.resultField.configuration()) : '');
									if(bk != field.val())
									{
										field.data('bk',field.val());
										field.trigger('calcualtedfield_changed');
										field.change();
									}
								}
							}

							me.processing_queue[fSec] = false;
							if(!me.thereIsPending(fSec)) $(document).trigger('equationsQueueEmpty', [fSec]);
						},
                    format : function(value,  config)
						{
							config = $.extend({}, config);
							if(!/^\s*$/.test(value))
                            {
								var symbol = '', isNumeric = false;
                                if($.isNumeric(value) && !/[+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)/.test(value))
                                {
									isNumeric = true;
									if(value < 0) symbol =  '-';
                                    var parts = value.toString().replace("-", "").split("."),
                                        counter = 0,
                                        str = '';

                                    if(config.groupingsymbol)
                                    {
                                        for(var i = parts[0].length-1; i >= 0; i--){
                                            counter++;
                                            str = parts[0][i]+str;
                                            if(counter%3 == 0 && i != 0) str = config.groupingsymbol+str;

                                        }
                                        parts[0] = str;
                                    }
									if(!('decimalsymbol' in config)) config.decimalsymbol = '.';
                                    value = parts.join(config.decimalsymbol);
                                }

								if(config.currency && !isNumeric)
								{
									delete config.prefix;
									delete config.suffix;
								}

                                if(config.prefix)
                                {
									if(!config.currency)
									{
										value = symbol+value;
										symbol = '';
									}
									value = config.prefix+value;
                                }

                                if(config.suffix) value += config.suffix;

								value = symbol+value;
                            }
							return value;
						},

                    unformat : function(field)
						{
							var escapeSymbol = $.fbuilder.escapeSymbol;

							var eq = field[0].form.equations,
								v = field.val();

							for(var i = 0, h = eq.length; i < h; i++)
							{
								if(eq[i].result == field[0].id)
								{
									var c = eq[i].resultField.configuration(); // Configuration object

									if(c.prefix && !/^\s*$/.test(c.prefix))
									{
										v = v.replace(new RegExp("^"+escapeSymbol(c.prefix)), '');
									}

									if(c.suffix && !/^\s*$/.test(c.suffix))
									{
										v = v.replace(new RegExp(escapeSymbol(c.suffix)+"$"), '');
									}

									if(!/[+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)/.test(v))
									{
										if(c.groupingsymbol && !/^\s*$/.test(c.groupingsymbol))
										{
											v = v.replace(new RegExp(escapeSymbol(c.groupingsymbol), 'g'), '');
										}

										if(c.decimalsymbol && !/^\s*$/.test(c.decimalsymbol))
										{
											v = v.replace(new RegExp(escapeSymbol(c.decimalsymbol), 'g'), '.');
										}
									}
								}
							}
							return v;
						}
				};

				var obj = new CalcFieldClss();

				// Associate events to the document for throw the corresponding equations
                $(document).on('keyup change blur', '[id="fbuilder"] :input', function(evt)
					{
                        // If evalequations = 0 the equations shouldn't be evaluated dynamically
                        var t = $(evt.target),
							f = t.closest('form'),
							evalequations 		= f.attr('data-evalequations'),
							evalequationsevent 	= f.attr('data-evalequationsevent');

                        if(
							typeof evalequations != 'undefined' &&
							evalequations*1 == 0 &&
							(
                                !(t.hasClass('codepeoplecalculatedfield') && evt.type == 'change') ||
                                (t.hasClass('codepeoplecalculatedfield') && t.data('manually') == 1)
                         )
						)
                        {
                            return;
                        }

                        if(evt.type == 'keyup')
						{
							if('undefined' != typeof evalequationsevent && evalequationsevent*1 == 1)
							{
								return;
							}
							// The key out of range
							if(evt.keyCode && (evt.keyCode >= 33 && evt.keyCode <= 40)) return;
							_checkValueThrowingEquation(t);
						}
						else
						{
							if(/*t.hasClass('depItem') ||*/
								(
									(
										t.prop('tagName') == 'INPUT' &&
										/(text|number|email|password)/.test(t.attr('type').toLowerCase()) ||
										t.prop('tagName') == 'TEXTAREA'
									) &&
									evt.type != 'change'
								)
							)
							{
								return;
							}
							obj.Calculate(t[0]);
						}
					});

				//Associate an event to the document waiting for the showHideDepEvent and recalculate all equations
				$(document).on('showHideDepEvent', function(evt, form_identifier)
					{
						// If evalequations = 0 the equations shouldn't be evaluated dynamically
						var f, evalequations, first_time;
						if(form_identifier) f = $('#'+form_identifier);
						else f = $('[id*="cp_calculatedfieldsf_pform_"]:eq(0)');

						if(f.length)
						{
							first_time = (typeof f.data('first_time') == 'undefined');
							f.data('first_time', 0);
							evalequations = f.data('evalequations');
							if(typeof evalequations == 'undefined' || evalequations*1 == 1)
							{
								if(first_time) obj.defaultCalc('#'+f.attr('id'));
								else obj.defaultCalc('#'+f.attr('id'), true);
							}
						}
                    });
                return obj; // Return the public object
            }
     )();