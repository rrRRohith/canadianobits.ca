	$.fbuilder.typeList.push(
		{
			id:"ffile",
			name:"Upload File",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'ffile' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'ffile' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Untitled",
			ftype:"ffile",
			required:false,
			exclude:false,
			size:"medium",
			accept:"",
			upload_size:"",
			multiple:false,
			preview: false,
			thumb_width: '80px',
			thumb_height: '',
			display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><input type="file" disabled class="field '+this.size+'" /><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
							{s:"#sSize",e:"change", l:"size", x:1},
							{s:"#sAccept",e:"change keyup", l:"accept", x:1},
							{s:"#sUpload_size",e:"change keyup", l:"upload_size", x:1},
							{s:"#sThumbWidth",e:"change keyup", l:"thumb_width", x:1},
							{s:"#sThumbHeight",e:"change keyup", l:"thumb_height", x:1},
							{s:"#sMultiple",e:"click", l:"multiple",f:function(el){return el.is(":checked");}},
							{s:"#sPreview",e:"click", l:"preview",f:function(el){return el.is(":checked");}}
						];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showSpecialDataInstance: function()
				{
					return '<label>Accept these file extensions [<a class="helpfbuilder" text="Extensions comma separated and without the dot.\n\nExample: jpg,png,gif,pdf">help?</a>]</label><input type="text" name="sAccept" id="sAccept" value="'+cff_esc_attr(this.accept)+'" class="large"><label>Maximum upload size in kB [<a class="helpfbuilder" text="1024 kB = 1 MB.\n\nThe support for this HTML5 feature may be partially available or not available in some browsers.">help?</a>]</label><input type="text" name="sUpload_size" id="sUpload_size" value="'+cff_esc_attr(this.upload_size)+'" class="large"><label><input type="checkbox" id="sMultiple" name="sMultiple" '+((typeof this.multiple != 'undefined' && this.multiple) ? 'CHECKED' : '')+' /> Upload multiple files</label><hr /><label><input type="checkbox" id="sPreview" name="sPreview" '+((typeof this.preview != 'undefined' && this.preview) ? 'CHECKED' : '')+' /> Show preview of images</label><label>Thumbnail width</label><input type="text" id="sThumbWidth" name="sThumbWidth" value="'+cff_esc_attr(this.thumb_width)+'" class="large" /><label>Thumbnail height</label><input type="text" id="sThumbHeight" name="sThumbHeight" value="'+cff_esc_attr(this.thumb_height)+'" class="large" /><hr />';
				}
	});