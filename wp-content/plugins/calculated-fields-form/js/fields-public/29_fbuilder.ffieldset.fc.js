	$.fbuilder.controls['ffieldset']=function(){};
	$.extend(
		$.fbuilder.controls['ffieldset'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"ffieldset",
			fields:[],
			columns:1,
			collapsible:false,
			defaultCollapsed:true,
            selfClosing:false,
			rearrange: 0,
			show:function()
				{
                    return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-container-field '+((this.collapsible) ? 'cff-collapsible'+((this.selfClosing) ? ' cff-selfclosing' : '')+((this.defaultCollapsed) ?  ' cff-collapsed' : '') : '')+'" id="field'+this.form_identifier+'-'+this.index+'"><FIELDSET>'+((!/^\s*$/.test(this.title) || this.collapsible) ? '<LEGEND>'+this.title+'</LEGEND>' : '')+'<div id="'+this.name+'"></div></FIELDSET><div class="clearer"></div></div>';
				},
			after_show: function()
				{
					var me = this;
					$.fbuilder.controls['fcontainer'].prototype.after_show.call(this);
					if(me.collapsible){
                        $('.'+me.name+'>fieldset>legend').bind('click', function(){
                            var p = $(this).closest('.cff-collapsible');
                            if(p.length)
                            {
                                p.toggleClass('cff-collapsed');
                                if(!p.hasClass('cff-collapsed'))
                                {
                                    p.siblings('.cff-selfclosing').addClass('cff-collapsed');
                                }
                            }
                        });
                    }
				},
			showHideDep:function(toShow, toHide, hiddenByContainer)
				{
					return $.fbuilder.controls['fcontainer'].prototype.showHideDep.call(this, toShow, toHide, hiddenByContainer);
				}
		}
	);