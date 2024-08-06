	$.fbuilder.typeList.push(
		{
			id:"fsummary",
			name:"Summary",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fsummary' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fsummary' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Summary",
			ftype:"fsummary",
			exclude_empty:false,
			fields:"",
			titleClassname:"summary-field-title",
			valueClassname:"summary-field-value",
			display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><span class="field">'+this.fields+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
							{s:"#sFields",e:"change keyup", l:"fields", x:1},
							{s:"#sExcludeEmpty",e:"click", l:"exclude_empty", f:function(el){return el.is(':checked');}},
							{s:"#sTitleClassname",e:"change keyup", l:"titleClassname", x:1},
							{s:"#sValueClassname",e:"change keyup", l:"valueClassname", x:1},
							{s:"#sPlusBtn",e:"click", l:"fields",f:function(){
								var v = $( "#sSelectedField" ).val(),
									e = $( "#sFields" ),
									f = $.trim( e.val() );
								f += ((f!='')?',':'')+v;
								e.val(f)
								return f;
								}
							}
						];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showAllSettings:function()
				{
					return this.showFieldType()+this.showTitle()+this.showSummaryFields()+this.showCsslayout();
				},
			showSummaryFields: function()
				{
					var str = '',
						items = this.fBuild.getItems();

					str += '<label>Fields to display on summary</label><input type="text" name="sFields" id="sFields" class="large" value="'+cff_esc_attr(this.fields)+'">'+
					'<label>Select field and press the plus button</label><select name="sSelectedField" id="sSelectedField" class="large">';

					for(var i=0; i<items.length; i++)
					{
						str += '<option value="'+items[i].name+'">'+( ( typeof items[i].title != 'undefined' ) ? cff_esc_attr(items[i].title) : '' )+'('+items[i].name+')'+'</option>';
					}
					str += '</select><div style="margin-top:10px;"><input type="button" value="+" name="sPlusBtn" id="sPlusBtn" style="padding:3px 10px;" /></div>'+
					'<label>Exclude empty fields: <input type="checkbox" id="sExcludeEmpty" name="sExcludeEmpty" '+((this.exclude_empty) ? 'CHECKED' : '')+'/></label>'+
					'<label>Classname for fields titles</label><input type="text" class="large" name="sTitleClassname" id="sTitleClassname" value="'+cff_esc_attr(this.titleClassname)+'">'+
					'<label>Classname for fields values</label><input type="text" class="large" name="sValueClassname" id="sValueClassname" value="'+cff_esc_attr(this.valueClassname)+'">';

					return str;
				}
	});