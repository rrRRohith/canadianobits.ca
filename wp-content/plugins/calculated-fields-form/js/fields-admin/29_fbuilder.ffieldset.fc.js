	$.fbuilder.typeList.push(
		{
			id:"ffieldset",
			name:"Fieldset",
			control_category:10
		}
	);
	$.fbuilder.controls[ 'ffieldset' ]=function(){};
	$.extend(
		$.fbuilder.controls[ 'ffieldset' ].prototype,
		$.fbuilder.controls[ 'fcontainer' ].prototype,
		{
			title:"Untitled",
			ftype:"ffieldset",
			fields:[],
			columns:1,
			rearrange: 0,
			collapsible:false, // Public
			defaultCollapsed: true, // Public
			collapsed:false, // Admin
            selfClosing:false,
			display:function()
				{
					return '<div class="fields '+this.name+((this.collapsed) ? ' collapsed' : '')+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Collapse" class="collapse ui-icon ui-icon-folder-collapsed "></div><div title="Uncollapse" class="uncollapse ui-icon ui-icon-folder-open "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><div class="dfield"><FIELDSET class="fcontainer">'+( ( !/^\s*$/.test( this.title ) ) ? '<LEGEND>'+cff_esc_attr(this.title)+'</LEGEND>' : '' )+$.fbuilder.controls['fcontainer'].prototype.columnsSticker.call(this)+'<label class="collapsed-label">Collapsed ['+this.name+']</label><div class="fieldscontainer"></div></FIELDSET></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					$.fbuilder.controls[ 'fcontainer' ].prototype.editItemEvents.call(this);
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, [{s:"#sCollapsible",e:"click", l:"collapsible", f:function(el){return el.is(':checked');}}, {s:"#sCollapsedByDefault",e:"click", l:"defaultCollapsed", f:function(el){return el.is(':checked');}}, {s:"#sSelfClosing",e:"click", l:"selfClosing", f:function(el){return el.is(':checked');}}]);
				},
			remove : function()
				{
					return $.fbuilder.controls[ 'fcontainer' ].prototype.remove.call(this);
				},
			duplicateItem: function( currentField, newField )
				{
					return $.fbuilder.controls[ 'fcontainer' ].prototype.duplicateItem.call( this, currentField, newField );
				},
			after_show:function()
				{
					return $.fbuilder.controls[ 'fcontainer' ].prototype.after_show.call(this);
				},
			showCollapsible:function()
				{
					return '<label><input type="checkbox" name="sCollapsible" id="sCollapsible" '+((this.collapsible)?"checked":"")+'> Make it collapsible</label>'+
					'<label style="padding-left:30px"><input type="checkbox" name="sCollapsedByDefault" id="sCollapsedByDefault" '+((this.defaultCollapsed)?"checked":"")+'> Collapsed by default</label>'+
					'<label style="padding-left:30px"><input type="checkbox" name="sSelfClosing" id="sSelfClosing" '+((this.selfClosing)?"checked":"")+'> Only one opened at a time <br><i>If there are several fieldsets configured as collapsible on the same level, this fieldset will auto-close when another fieldset is opened.</i></label>';
				},
			showSpecialDataInstance: function()
			{
				return $.fbuilder.controls[ 'fcontainer' ].prototype.showSpecialDataInstance.call(this) + this.showCollapsible();
			}
	});