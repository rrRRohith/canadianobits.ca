	$.fbuilder.controls['fButton']=function(){};
	$.extend(
		$.fbuilder.controls['fButton'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			ftype:"fButton",
            sType:"button",
            sValue:"button",
			sLoading:false,
            sMultipage:false,
			sOnclick:"",
            sOnmousedown:"",
			userhelp:"A description of the section goes here.",
			show:function()
				{
                    var esc  = cff_esc_attr,
                        type = this.sType,
                        clss = '';

                    if(this.sType == 'calculate')
                    {
                        type = 'button';
                        clss = 'calculate-button';
                    }
					if(this.sType == 'print')
                    {
                        type = 'button';
                    }
					else if(this.sType == 'reset')
					{
						clss = 'reset-button';
					}

                    return '<div class="fields '+esc(this.csslayout)+' '+this.name+' cff-button-field" id="field'+this.form_identifier+'-'+this.index+'"><input id="'+this.name+'" type="'+type+'" value="'+esc(this.sValue)+'" class="field '+clss+'" /><span class="uh">'+this.userhelp+'</span><div class="clearer"></div></div>';
				},
            after_show:function()
                {
					var me = this;
					$('#'+this.name).mousedown(function(){eval(me.sOnmousedown);});
					$('#'+this.name).click(
                        function()
                            {
                                var e = $(this), f = e.closest('form'), fid = me.form_identifier;
                                if(e.hasClass('calculate-button'))
                                {
                                    var items = $.fbuilder['forms'][fid].getItems();
									if(me.sLoading)
									{
										f.find('.cff-processing-form').remove();
										$('<div class="cff-processing-form"></div>').appendTo(e.closest('#fbuilder'));
									}
									$(document).on('equationsQueueEmpty', function(evt, id){
										if(id == fid)
										{
											if(me.sLoading) f.find('.cff-processing-form').remove();
											$(document).off('equationsQueueEmpty');
											for(var i = 0, h = items.length; i < h; i++)
											{
												if(items[i].ftype == 'fsummary')
												{
													items[i].update();
												}
											}
										}
									});

                                    $.fbuilder['calculator'].defaultCalc('#'+e.closest('form').attr('id'), false);
                                }
								if(e.hasClass('reset-button'))
								{
									setTimeout(
										function()
										{
											var id = f.attr('id');
                                            f.validate().resetForm();
											f.find(':data(manually)').removeData('manually');
											$.fbuilder['showHideDep']({ 'formIdentifier' : fid });

											var page = parseInt(e.closest('.pbreak').attr('page'));
											if(page)
											{
												$.fbuilder.forms[fid]['currentPage'] = 0;
												$("#fieldlist"+fid+" .pbreak").css("display","none");
												$("#fieldlist"+fid+" .pbreak").find(".field").addClass("ignorepb");
												$("#fieldlist"+fid+" .pb0").css("display","block");
												if ($("#fieldlist"+fid+" .pb0").find(".field").length>0)
												{
													$("#fieldlist"+fid+" .pb0").find(".field").removeClass("ignorepb");
													try
													{
														$("#fieldlist"+fid+" .pb0").find(".field")[0].focus();
													}
													catch(e){}
												}
											}
                                            if(f.data('evalequations')*1)
                                                $.fbuilder['calculator'].defaultCalc('#'+id, false);
										},
										50
									);
								}
								eval(me.sOnclick);
                                if(me.sType == 'print')
                                {
                                    fbuilderjQuery.fbuilder.currentFormId = f.attr('id');
                                    PRINTFORM(me.sMultipage);
                                }
                            }
                  );
                }
		}
	);