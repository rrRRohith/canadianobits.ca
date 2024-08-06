	$.fbuilder.controls['ffile'] = function(){};
	$.extend(
		$.fbuilder.controls['ffile'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Untitled",
			ftype:"ffile",
			required:false,
			size:"medium",
			accept:"",
			upload_size:"",
			multiple:false,
			preview: false,
			thumb_width: '80px',
			thumb_height: '',
			_patch: false, // Used only if the submission is being updated to preserves the previous values
			init: function(){
				this.thumb_width  = $.trim(this.thumb_width);
				this.thumb_height = $.trim(this.thumb_height);
				var form_identifier = this.form_identifier.replace(/[^\d]/g, '');
				this._patch = ('cpcff_default' in window && form_identifier in cpcff_default) ? true : false;
			},
			show:function()
				{
					this.accept = cff_esc_attr($.trim(this.accept));
					this.upload_size = cff_esc_attr($.trim(this.upload_size));

					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-file-field" id="field'+this.form_identifier+'-'+this.index+'"><label for="'+this.name+'">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield"><input aria-label="'+cff_esc_attr(this.title)+'" type="file" id="'+this.name+'" name="'+this.name+'[]"'+((this.accept.length) ? ' accept="'+this.accept+'"' : '')+((this.upload_size.length) ? ' upload_size="'+this.upload_size+'"' : '')+' class="field '+this.size+((this.required)?" required":"")+'" '+((this.multiple) ? 'multiple' : '')+' /><div id="'+this.name+'_clearer" class="cff-file-clearer"></div>'+((this._patch) ? '<input type="hidden" id="'+this.name+'_patch" name="'+this.name+'_patch" value="1" />' : '')+'<span class="uh">'+this.userhelp+'</span></div><div class="clearer"></div></div>';
				},
			after_show:function()
			{
				var me = this;

				if(!('accept' in $.validator.methods))
					$.validator.addMethod("accept", function(value, element, param)
					{
						if(this.optional(element)) return true;
						else{
							param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
							var regExpObj = new RegExp(".("+param+")$", "i");
							for(var i = 0, h = element.files.length; i < h; i++)
								if(!element.files[i].name.match(regExpObj)) return false;
							return true;
						}
					});

				if(!('upload_size' in $.validator.methods))
					$.validator.addMethod("upload_size", function(value, element,params)
					{
						if(this.optional(element)) return true;
						else{
							var total = 0;
							for(var i = 0, h = element.files.length; i < h; i++)
								total += element.files[i].size/1024;
							return (total <= params);
						}
					});

				$('#'+me.name).change(function(){
					var h = this.files.length, n = 0;
					$(this).siblings('span.files-list').remove();
					$('[id="'+me.name+'_patch"]').remove();
					if(1 <= h)
					{
						var filesContainer = $('<span class="files-list"></span>');
						for(var i = 0; i < h; i++)
						{
							(function(i, file){
								if(me.preview && file.type.match('image.*') && 'FileReader' in window)
								{
									var reader = new FileReader();
									reader.onload = function (e) {
										var img = $('<img>');
										img.attr('src', e.target.result).css('maxWidth', '100%');
										if(me.thumb_height != '') img.attr('height', me.thumb_height);
										if(me.thumb_width  != '') img.attr('width', me.thumb_width);
										filesContainer.append($('<span>'+(n ? ', ' : '')+'</span>').append(img));
										n++;
									};
									reader.readAsDataURL(file);
								}
								else if(1 < h){filesContainer.append($('<span>').text((n ? ', ' : '')+file.name));n++;}
							})(i, this.files[i]);
						}
						$('#'+this.id+'_clearer').after(filesContainer);
					}
				});

                $('#'+me.name+'_clearer').click(function(){$('#'+me.name).val('').change().valid();});
			},
			val : function(raw, no_quotes)
			{
                raw = raw || false;
                no_quotes = no_quotes || false;
				var e = $("[id='"+this.name+"']:not(.ignore)"), result = '', separator = '';
				if(e.length)
                {
                    if(raw) result = e[0].files;
                    else
                    {
                        for(var i = 0, h = e[0].files.length; i<h; i++)
                        {
                            result += separator+e[0].files[i].name;
                            separator = ', ';
                        }
                        result = $.fbuilder.parseValStr(result, raw, no_quotes);
                    }
                }
				return result;
			}
		}
	);