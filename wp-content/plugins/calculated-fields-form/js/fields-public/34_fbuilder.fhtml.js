	$.fbuilder.controls['fhtml']=function(){};
	$.extend(
		$.fbuilder.controls['fhtml'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			ftype:"fhtml",
			fcontent:"",
			show:function()
				{
					var content = this.fcontent;
					content = content.replace(/\(\s*document\s*\)\.one\(\s*['"]showHideDepEvent['"]/ig,
					'(window).one("showHideDepEvent"');
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-html-field" id="field'+this.form_identifier+'-'+this.index+'"><div id="'+this.name+'" class="dfield">'+content+'</div><div class="clearer"></div></div>';
				}
		}
	);