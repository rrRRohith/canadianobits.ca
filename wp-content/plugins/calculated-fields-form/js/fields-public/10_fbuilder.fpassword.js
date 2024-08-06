	$.fbuilder.controls['fpassword'] = function(){};
	$.extend(
		$.fbuilder.controls['fpassword'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"fpassword",
			predefined:"",
			predefinedClick:false,
			required:false,
			size:"medium",
			minlength:"",
			maxlength:"",
			equalTo:"",
			regExp:"",
			regExpMssg:"",
			show:function()
				{
					this.minlength = cff_esc_attr($.trim(this.minlength));
					this.maxlength = cff_esc_attr($.trim(this.maxlength));
					this.equalTo = cff_esc_attr($.trim(this.equalTo));
					this.predefined = this._getAttr('predefined');
					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-password-field" id="field'+this.form_identifier+'-'+this.index+'"><label for="'+this.name+'">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield"><input aria-label="'+cff_esc_attr(this.title)+'" id="'+this.name+'" name="'+this.name+'"'+((this.minlength.length) ? ' minlength="'+cff_esc_attr(this.minlength)+'"' : '')+((this.maxlength.length) ? ' maxlength="'+cff_esc_attr(this.maxlength)+'"' : '')+((this.equalTo.length) ? ' equalTo="#'+this.equalTo+this.form_identifier+'"' : '')+' class="field '+this.size+((this.required)?" required":"")+'" type="password" autocomplete="new-password" value="'+cff_esc_attr(this.predefined)+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
			after_show:function()
				{
					if(this.regExp != "" && typeof $['validator'] != 'undefined')
					{
						var parts 	= this.regExp.match(/(\/)(.*)(\/)([gimy]{0,4})$/i);
						this.regExp = (parts === null) ? new RegExp(this.regExp) : new RegExp(parts[2],parts[4].toLowerCase());

						if(!('pattern' in $.validator.methods))
							$.validator.addMethod('pattern', function(value, element, param)
								{
									try{
										return this.optional(element) || param.test(value);
									}
									catch(err){return true;}
								}
							);
						$('#'+this.name).rules('add',{'pattern':this.regExp, messages:{'pattern':this.regExpMssg}});
					}
				},
			val:function(raw, no_quotes)
				{
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $('[id="'+this.name+'"]:not(.ignore)');
					if(e.length) return $.fbuilder.parseValStr(e.val(), raw, no_quotes);
					return 0;
				}
		}
	);