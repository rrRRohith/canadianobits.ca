	$.fbuilder.controls['fPageBreak']=function(){};
	$.extend(
		$.fbuilder.controls['fPageBreak'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Page Break",
			ftype:"fPageBreak",
			show:function()
				{
                    return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' section_breaks" id="field'+this.form_identifier+'-'+this.index+'"><div class="section_break" id="'+this.name+'" ></div><label>'+this.title+'</label><span class="uh">'+this.userhelp+'</span><div class="clearer"></div></div>';
				}
		}
	);