	$.fbuilder.controls['ftextarea'] = function(){};
	$.extend(
		$.fbuilder.controls['ftextarea'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"ftextarea",
            autocomplete:"off",
			predefined:"",
			predefinedClick:false,
			required:false,
			readonly:false,
			size:"medium",
			minlength:"",
			maxlength:"",
            rows:4,
			show:function()
				{
					this.minlength = cff_esc_attr($.trim(this.minlength));
					this.maxlength = cff_esc_attr($.trim(this.maxlength));
					this.predefined = this._getAttr('predefined');
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-textarea-field" id="field'+this.form_identifier+'-'+this.index+'"><label for="'+this.name+'">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield"><textarea aria-label="'+cff_esc_attr(this.title)+'" '+((!/^\s*$/.test(this.rows)) ? 'rows='+this.rows : '')+' id="'+this.name+'" name="'+this.name+'"'+((this.minlength.length) ? ' minlength="'+cff_esc_attr(this.minlength)+'"' : '')+((this.maxlength.length) ? ' maxlength="'+cff_esc_attr(this.maxlength)+'"' : '')+' class="field '+this.size+((this.required)?" required":"")+'" '+((this.readonly)?'readonly':'')+' autocomplete="'+this.autocomplete+'">'+((!this.predefinedClick) ? this.predefined : '')+'</textarea><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
			val:function(raw, no_quotes)
				{
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $('[id="'+this.name+'"]:not(.ignore)');
					if(e.length)
					{
						var v = $.fbuilder.parseValStr(e.val(), raw, no_quotes);
						if(!raw) v = v.replace(/[\n\r]+/g, ' ');
						else if(!no_quotes) v = v.replace(/^"/, "`").replace(/"$/, "`");
						return v;
					}
					return 0;
				}
		}
	);