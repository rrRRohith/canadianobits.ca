	$.fbuilder.typeList.push(
		{
			id:"fcolor",
			name:"Color",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fcolor' ]=function(){};
	$.extend(
		$.fbuilder.controls[ 'fcolor' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Untitled",
			ftype:"fcolor",
			predefined:"",
			predefinedClick:false,
			required:false,
			exclude:false,
			readonly:false,
			size:"default",
            display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><input class="field disabled '+this.size+'" type="color" value="'+cff_esc_attr(this.predefined)+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var me = this, evt = [{s:"#sSize",e:"change", l:"size", x:1}];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showSize:function()
			{
                var bk = $.fbuilder.showSettings.sizeList.slice();
                $.fbuilder.showSettings.sizeList.unshift({id:"default",name:"Default"});
				var output = $.fbuilder.showSettings.showSize(this.size);
                $.fbuilder.showSettings.sizeList = bk;
                return output;
			}
	});