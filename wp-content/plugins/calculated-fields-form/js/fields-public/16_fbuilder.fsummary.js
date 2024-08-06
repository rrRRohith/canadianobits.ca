	$.fbuilder.controls['fsummary'] = function(){};
	$.extend(
		$.fbuilder.controls['fsummary'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Summary",
			ftype:"fsummary",
			fields:"",
			exclude_empty: false,
			titleClassname:"summary-field-title",
			valueClassname:"summary-field-value",
			fieldsArray:[],
			show:function()
				{
					var me = this;
					if('string' != typeof me.fields) return;
                    var p = $.trim(me.fields.replace(/\,+/g, ',')).split(','),
					    l = p.length;
					if(l)
					{
						var str = '<div class="fields '+cff_esc_attr(me.csslayout)+' '+me.name+' cff-summary-field" id="field'+me.form_identifier+'-'+me.index+'">'+((!/^\s*$/.test(me.title)) ? '<h2>'+me.title+'</h2>': '')+'<div id="'+me.name+'">';
						for(var i = 0; i < l; i++)
						{
							if(!/^\s*$/.test(p[i]))
							{
								p[i] = $.trim(p[i]);
								str += '<div ref="'+p[i]+me.form_identifier+'" class="cff-summary-item"><span class="'+cff_esc_attr(me.titleClassname)+' cff-summary-title"></span><span class="'+cff_esc_attr(me.valueClassname)+' cff-summary-value"></span></div>';
							}
						}
						str += '</div></div>';

						return str;
					}
				},
			after_show: function(){
                    var me = this;
					if('string' != typeof me.fields) return;
                    var p = $.trim(me.fields.replace(/\,+/g, ',')).split(','),
                        l = p.length;

                    if(l)
                    {
                        for(var i = 0; i < l; i++)
                        {
                            if(!/^\s*$/.test(p[i]))
                            {
                                p[i] = $.trim(p[i]);
                                me.fieldsArray.push(p[i]+me.form_identifier);
                                $(document).on('change', '[id*="'+p[i]+me.form_identifier+'"]', function(){ me.update(); });
                            }
                        }
                        $(document).on('showHideDepEvent', function(evt, form_identifier)
                        {
						    me.update();
                        });

                        $('#cp_calculatedfieldsf_pform'+me.form_identifier).bind('reset', function(){ setTimeout(function(){ me.update(); }, 10); });
                    }
                },
			update:function()
				{
					for (var j = 0, k = this.fieldsArray.length; j < k; j++)
					{
						var i  = this.fieldsArray[j],
							e  = $('[id="'+i+'"],[id^="'+i+'_rb"],[id^="'+i+'_cb"]'),
							tt = $('[ref="'+i+'"]');

						if(e.length && tt.length)
						{
							var l  = $('[id="'+i+'"],[id^="'+i+'_rb"],[id^="'+i+'_cb"]')
									.closest('.fields')
									.find('label:first')
									.clone()
									.find('.r,.dformat')
									.remove()
									.end(),
								t  = $.trim(l.text())
									.replace(/\:$/,''),
								v  = [];

							e.each(
								function(){
									var e = $(this);
									if(/(checkbox|radio)/i.test(e.attr('type')) && !e.is(':checked'))
									{
										return;
									}
									else if(e[0].tagName == 'SELECT')
									{
										var vt = [];
										e.find('option:selected').each(function(){vt.push($(this).attr('vt'));});
										v.push(vt.join(', '));
									}
									else
									{
										if(e.attr('vt'))
										{
											v.push(e.attr('vt'));
										}
										else if( e.attr( 'summary' ) )
										{
											v.push( $( '#' + i ).closest( '.fields' ).find( '.'+e.attr( 'summary' )+i ).html() );
										}
										else
										{
											var d = $('[id="'+i+'_date"]');
											if(d.length)
											{
												if(d.is(':disabled'))
												{
													v.push(e.val().replace(d.val(),''));
												}
												else v.push(e.val());
											}
											else
											{
												if(e.attr('type') == 'file')
												{
													var f = [];
													$.each(e[0].files, function(i,o){f.push(o.name);});
													v.push(f.join(', '));
												}
												else
												{
													var c = $('[id="'+i+'_caption"]');
													v.push((c.length && !/^\s*$/.test(c.html())) ? c.html() : e.val());
												}
											}
										}
									}
								}
							);
							v = v.join(', ');
							tt.find('.cff-summary-title')[(/^\s*$/.test(t)) ? 'hide' : 'show']().html(t);

                            var tmp = $('<div></div>').html(v);
							tmp.find('script').remove();
							tt.find('.cff-summary-value').html(tmp.html().replace(/\s(on[a-z]*\s*=)/gi, "_$1"));

							if(e.hasClass('ignore') || (this.exclude_empty && v == ''))
							{
								tt.hide();
							}
							else
							{
								tt.show();
							}
						}
					}
					$('[id="' + this.name + '"]').trigger( 'cff-summary-update' );
				}
	});
