	$.fbuilder.typeList.push(
		{
			id:"facceptance",
			name:"Acceptance (GDPR)",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'facceptance' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'facceptance' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Accept terms and conditions",
			ftype:"facceptance",
			value:"I accept",
			url:"",
			message:"",
			required:true,
			exclude:false,
            onoff:0,
			display:function()
				{
					var	str = '<div class="one_column"><input class="field" disabled="true" type="checkbox"/> '+this.title+((this.required)?"*":"")+'</div>';
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><div class="dfield">'+str+'<span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var me 		= this;
						evt 	= [
							{s:"#sValue",e:"change keyup", l:"value"},
							{s:"#sURL",e:"change keyup", l:"url"},
                            {s:'[name="sOnOff"]', e:"change", l:"onoff", f: function(el){return (el.is(':checked')) ? 1 : 0;}},
							{s:"#sMessage",e:"change keyup", l:"message"}
						];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, evt);
				},
			showRequired: function(v)
				{
					return '<label><input type="checkbox" checked disabled>Acceptance fields are always required</label>'+
                    '<div class="choicesSet"><label><input type="checkbox" name="sOnOff" '+((this.onoff) ? ' CHECKED ' : '')+'/> Display as on/off switch.</label></div>';
				},
			showUserhelp: function(){ return ''; },
			showValue:function()
				{
					return '<label>Value</label><input class="large" type="text" name="sValue" id="sValue" value="'+cff_esc_attr(this.value)+'">';
				},
			showURL:function()
				{
					return '<label>URL to the Consent and Acknowledgement page</label><input class="large" type="text" name="sURL" id="sURL" value="'+cff_esc_attr(this.url)+'">';
				},
			showMessage:function()
				{
					return '<label>- or - enter the Consent and Acknowledgement text</label><textarea class="large" name="sMessage" id="sMessage" style="height:150px;">'+cff_esc_attr(this.message)+'</textarea>';
				},
			showCsslayout:function()
				{
					return $.fbuilder.controls[ 'ffields' ].prototype.showCsslayout.call(this)+'<div style="color: #666;border: 1px solid #EF7E59;display: block;padding: 5px;background: #FBF0EC;border-radius: 4px;text-align: center;margin-top:20px;">The Acceptance control helps to make the form comply with one of requirements of the General Data Protection Regulation (GDPR)</div>';
				},
			showSpecialDataInstance: function()
				{
					return this.showValue()+this.showURL()+this.showMessage();
				}
	});