		$.fbuilder.typeList.push(
			{
				id:"fslider",
				name:"Slider",
				control_category:1
			}
		);
        $.fbuilder.controls[ 'fslider' ] = function(){};
		$.extend(
			$.fbuilder.controls[ 'fslider' ].prototype,
			$.fbuilder.controls[ 'ffields' ].prototype,
			{
				title:"Slider",
				ftype:"fslider",
				exclude:false,
				readonly:false,
				predefined:"",
				predefinedMin:"",
				predefinedMax:"",
				predefinedClick:false,
				size:"small",
				thousandSeparator:",",
				centSeparator:".",
				typeValues:false,
				min:0,
				max:100,
				step:1,
				range:false,
				logarithmic:false,
				caption:"{0}",
				minCaption:"",
				maxCaption:"",
				display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+'</label><div class="dfield"><input class="field disabled '+this.size+'" type="text" value="'+( ( !this.range ) ? cff_esc_attr( this.predefined ) : cff_esc_attr( '['+this.predefinedMin+','+this.predefinedMax+']' ) )+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
				editItemEvents:function()
				{
					var evt = [
						{s:"#sSize",e:"change", l:"size", x:1},
						{s:"#sTypeValues",e:"click", l:"typeValues", f:function(el){return el.is(':checked');}},
						{s:"#sMin",e:"change keyup", l:"min", x:1},
						{s:"#sMax",e:"change keyup", l:"max", x:1},
						{s:"#sStep",e:"change keyup", l:"step", x:1},
						{s:"#sRange",e:"change", l:"range", f:function(el){
							var v = el.is(':checked');
							$( 'div.range'    )[ ( v ) ? 'show' : 'hide' ]();
							$( 'div.no-range' )[ ( v ) ? 'hide' : 'show' ]();
							if(v) $('#sLogarithmic').prop('checked', false).change();
							return v;
						}},
						{s:"#sLogarithmic",e:"change", l:"logarithmic", f:function(el){
							var v = el.is(':checked');
							if(v) $('#sRange').prop('checked', false).change();
							return v;
						}},
						{s:"#sCaption",e:"change keyup", l:"caption"},
						{s:"#sMinCaption",e:"change keyup", l:"minCaption"},
						{s:"#sMaxCaption",e:"change keyup", l:"maxCaption"},
						{s:"#sPredefinedMin",e:"change keyup", l:"predefinedMin", x:1},
						{s:"#sPredefinedMax",e:"change keyup", l:"predefinedMax", x:2},
						{s:"#sThousandSeparator",e:"change keyup", l:"thousandSeparator", x:1},
						{s:"#sCentSeparator",e:"change keyup", l:"centSeparator", x:1}
					];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, evt);
				},
				showRequired: function(){ return '<label><input type="checkbox" name="sTypeValues" id="sTypeValues" '+( (this.typeValues) ? 'CHECKED' : '')+'> Allow to type the values</label>'; },
				showPredefined: function()
				{
					return '<div class="no-range" style="display:'+( ( this.range ) ? 'none' : 'block')+';"><label>Predefined Value</label><input type="text" class="large" name="sPredefined" id="sPredefined" value="'+cff_esc_attr( this.predefined )+'"></div><div class="range" style="display:'+( ( this.range ) ? 'block' : 'none')+';"><div class="column width50"><label>Predefined Min</label><input type="text" name="sPredefinedMin" id="sPredefinedMin" value="'+cff_esc_attr( this.predefinedMin )+'" class="large"></div><div class="column width50"><label>Predefined Max</label><input type="text" name="sPredefinedMax" id="sPredefinedMax" value="'+cff_esc_attr( this.predefinedMax )+'" class="large"></div></div><div class="clearer" />';
				},
				showRangeIntance: function()
				{
					return $.fbuilder.showSettings.showExclude(this.exclude) +
						$.fbuilder.showSettings.showReadonly(this.readonly) +
						'<div><div class="column width30"><label>Min</label><input type="text" name="sMin" id="sMin" value="'+cff_esc_attr(this.min)+'" placeholder="0 by default" class="large"></div><div class="column width30"><label>Max</label><input type="text" name="sMax" id="sMax" value="'+cff_esc_attr(this.max)+'" placeholder="100 by default" class="large"></div><div class="column width30"><label>Step</label><input type="text" name="sStep" id="sStep" value="'+cff_esc_attr(this.step)+'" placeholder="1 by default" class="large"></div><div class="clearer" /></div><div style="margin-bottom:10px;"><i>It is possible to associate other fields in the form with the attributes "min", "max" and "step". Ex: fieldname1</i></div><label><input type="checkbox" name="sRange" id="sRange" '+( ( this.range ) ? 'CHECKED' : '' )+' /> Range slider </label><label class="no-range"><input type="checkbox" name="sLogarithmic" id="sLogarithmic" '+( ( this.logarithmic ) ? 'CHECKED' : '' )+' /> Logarithmic slider </label><div><label>Field Caption</label><input class="large" type="text" name="sCaption" id="sCaption" value="'+cff_esc_attr( this.caption )+'"></div><div><label>Min Corner Caption</label><input class="large" type="text" name="sMinCaption" id="sMinCaption" value="'+cff_esc_attr( this.minCaption )+'"></div><div><label>Max Corner Caption</label><input class="large" type="text" name="sMaxCaption" id="sMaxCaption" value="'+cff_esc_attr( this.maxCaption )+'"></div><div><label>Symbol for grouping thousands in the field\'s caption(Ex: 3,000,000)</label><input type="text" name="sThousandSeparator" id="sThousandSeparator" class="large" value="'+cff_esc_attr( this.thousandSeparator )+'" /></div><div><label>Decimals separator symbol (Ex: 25.20)</label><input type="text" name="sCentSeparator" id="sCentSeparator" class="large" value="'+cff_esc_attr( this.centSeparator )+'" /></div>';
				}
		});