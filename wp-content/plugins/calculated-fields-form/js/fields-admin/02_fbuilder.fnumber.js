		$.fbuilder.typeList.push(
			{
				id:"fnumber",
				name:"Number",
				control_category:1
			}
		);
        $.fbuilder.controls[ 'fnumber' ] = function(){};
		$.extend(
			$.fbuilder.controls[ 'fnumber' ].prototype,
			$.fbuilder.controls[ 'ffields' ].prototype,
			{
				title:"Number",
				ftype:"fnumber",
				predefined:"",
				predefinedClick:false,
				required:false,
				exclude:false,
				readonly:false,
                numberpad:false,
				spinner:false,
				size:"small",
				thousandSeparator:"",
				decimalSymbol:".",
				min:"",
				max:"",
				formatDynamically:false,
				dformat:"digits",
				formats:new Array("digits","number", "percent"),
				display:function()
					{
						return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><input class="field disabled '+this.size+'" type="text" value="'+cff_esc_attr(this.predefined)+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
					},
				editItemEvents:function()
					{
						var f   = function(el){return el.is(':checked');},
							evt = [
							{s:"#sSize",e:"change", l:"size", x:1},
							{s:"#sFormat",e:"change", l:"dformat", f:function(el){
								var v = el.val();
								$( '.fnumber-symbols' )[(v == 'digits')?'hide':'show']();
								$( '.fnumber-hint' )[(v == 'percent')?'show':'hide']();
								return v;
								}, x:1
							},
							{s:"#sMin",e:"change keyup", l:"min", x:1},
							{s:"#sMax",e:"change keyup", l:"max", x:1},
							{s:"#sThousandSeparator",e:"change keyup", l:"thousandSeparator", x:1},
							{s:"#sDecimalSymbol",e:"change keyup", l:"decimalSymbol", x:1},
							{s:"#sSpinner",e:"click", l:"spinner",f:f},
							{s:"#sFormatDynamically",e:"click", l:"formatDynamically",f:f},
						];
						$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, evt);
					},
				showFormatIntance: function()
					{
						var str = "", df = this.dformat;
						for (var i=0;i<this.formats.length;i++)
						{
							str += '<option value="'+this.formats[i]+'" '+((this.formats[i]==df)?"selected":"")+'>'+this.formats[i]+'</option>';
						}
						return '<div><label><input type="checkbox" name="sSpinner" id="sSpinner" '+( (this.spinner) ? 'CHECKED' : '')+'> Display spinner buttons</label></div>'+
						'<div><label>Number Format</label><select name="sFormat" id="sFormat">'+str+'</select></div>'+
						'<div class="fnumber-hint" '+((df != 'percent') ? 'style="display:none;"' : '')+'><i>The field value in the equations would be its decimal representation. Ex. 10% would be 0.1</i></div>'+
						'<div class="fnumber-symbols" '+((df == 'digits') ? 'style="display:none;"' : '')+'><label>Decimals separator symbol (Ex: 25.20)</label><input type="text" name="sDecimalSymbol" id="sDecimalSymbol" class="large" value="'+cff_esc_attr(this.decimalSymbol)+'" /><label>Symbol for grouping thousands (Ex: 3,000,000)</label><input type="text" name="sThousandSeparator" id="sThousandSeparator" class="large" value="'+cff_esc_attr(this.thousandSeparator)+'" /><label><input type="checkbox" name="sFormatDynamically" id="sFormatDynamically" '+( (this.formatDynamically) ? 'CHECKED' : '')+'> Format dynamically</label></div>';
					},
				showRangeIntance: function()
					{
						return '<div class="column width50"><label>Min</label><input type="text" name="sMin" id="sMin" value="'+cff_esc_attr(this.min)+'" class="large"></div><div class="column width50"><label>Max</label><input type="text" name="sMax" id="sMax" value="'+cff_esc_attr(this.max)+'" class="large"></div><div class="clearer"><i>It is possible to associate other fields in the form to the attributes "min" and "max". Ex: fieldname1</i></div>';
					}
		});