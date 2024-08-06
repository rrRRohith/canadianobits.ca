	$.fbuilder.controls['fhidden']=function(){};
	$.extend(
		$.fbuilder.controls['fhidden'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			ftype:"fhidden",
			title:"",
			predefined:"",
			show:function()
				{
					this.predefined = this._getAttr('predefined');
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-hidden-field" id="field'+this.form_identifier+'-'+this.index+'" style="padding:0;margin:0;border:0;width:0;height:0;overflow:hidden;"><label for="'+this.name+'">'+this.title+'</label><div class="dfield"><input id="'+this.name+'" name="'+this.name+'" type="hidden" value="'+cff_esc_attr(this.predefined)+'" class="field" /></div></div>';
				}
		}
	);