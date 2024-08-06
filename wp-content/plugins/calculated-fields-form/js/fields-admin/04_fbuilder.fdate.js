	$.fbuilder.typeList.push(
		{
			id:"fdate",
			name:"Date Time",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fdate' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fdate' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Date",
			ftype:"fdate",
			predefined:"",
			predefinedClick:false,
			size:"medium",
			required:false,
			exclude:false,
			readonly:false,
            disableKeyboardOnMobile:false,
			dformat:"mm/dd/yyyy",
			dseparator:"/",
			tformat:"24",
			showDropdown:false,
			dropdownRange:"-10:+10",

			minDate:"",
			maxDate:"",
            invalidDates:"",
            mondayFirstDay:false,
			minHour:0,
			maxHour:23,
			minMinute:0,
			maxMinute:59,

			stepHour: 1,
			stepMinute: 1,

			showDatepicker: true,
			showTimepicker: false,

			ariaHourLabel: 'hours',
			ariaMinuteLabel: 'minutes',
			ariaAMPMLabel: 'am or pm',

			defaultDate:"",
			defaultTime:"",
			working_dates:[true,true,true,true,true,true,true],

			formats:['mm/dd/yyyy','dd/mm/yyyy','yyyy/mm/dd','yyyy/dd/mm'],
			separators: ['/','-','.'],

            errorMssg:'',

			display:function()
				{
					var me = this,
						dformat = me.dformat.replace(/\//g, me.dseparator);
					return '<div class="fields '+me.name+' '+this.ftype+'" id="field'+me.form_identifier+'-'+me.index+'" title="'+me.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+me.title+''+((me.required)?"*":"")+' ('+dformat+')</label><div class="dfield"><input class="field disabled '+me.size+'" type="text" value="'+cff_esc_attr(me.predefined)+'"/><span class="uh">'+me.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
							{s:"#sDropdownRange",e:"keyup", l:"dropdownRange", x:1},
							{s:"#sSize",e:"change", l:"size", x:1},
							{s:"#sFormat",e:"change", l:"dformat", x:1},
							{s:"#sSeparator",e:"change", l:"dseparator", x:1},
							{s:"[name='sTimeFormat']",e:"change", l:"tformat", x:1},
							{s:"#sMinDate",e:"change keyup", l:"minDate", x:1},
							{s:"#sMaxDate",e:"change keyup", l:"maxDate", x:1},
							{s:"#sInvalidDates",e:"change keyup", l:"invalidDates", x:1},
							{s:"#sErrorMssg",e:"change keyup", l:"errorMssg", x:1},
							{s:"#sDefaultDate",e:"change keyup", l:"defaultDate", x:1},
							{s:"#sShowDropdown",e:"click", l:"showDropdown", f:function(el){
								var v = el.is(':checked');
								$("#divdropdownRange")[( v ) ? 'show' : 'hide']();
								return v;
								}
							},
							{s:"#sShowTimepicker",e:"click", l:"showTimepicker", f:function(el){
								var v = el.is(':checked');
								$(".time-options")[( v ) ? 'show' : 'hide']();
								return v;
								}
							},
							{s:"#sShowDatepicker",e:"click", l:"showDatepicker", f:function(el){return el.is(':checked');}},
							{s:"#sDisableKeyboardOnMobile",e:"click", l:"disableKeyboardOnMobile", f:function(el){return el.is(':checked');}},
							{s:"#sMondayFirstDay",e:"click", l:"mondayFirstDay", f:function(el){return el.is(':checked');}},
							{s:"#sAriaAMPMLabel",e:"change keyup", l:"ariaAMPMLabel"},
							{s:"#sAriaHourLabel",e:"change keyup", l:"ariaHourLabel"},
							{s:"#sAriaMinuteLabel",e:"change keyup", l:"ariaMinuteLabel"},
							{s:"#sMinHour",e:"change keyup", l:"minHour", x:1},
							{s:"#sMaxHour",e:"change keyup", l:"maxHour", x:1},
							{s:"#sMinMinute",e:"change keyup", l:"minMinute", x:1},
							{s:"#sMaxMinute",e:"change keyup", l:"maxMinute", x:1},
							{s:"#sStepHour",e:"change keyup", l:"stepHour", x:1},
							{s:"#sStepMinute",e:"change keyup", l:"stepMinute", x:1},
							{s:"#sDefaultTime",e:"change keyup", l:"defaultTime", x:1}
						];
					$(".working_dates input").bind("click", {obj: this}, function(e) {
						e.data.obj.working_dates[$(this).val()] = $(this).is(':checked');
						$.fbuilder.reloadItems({'field':e.data.obj});
					});
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this, evt);
				},
			showFormatIntance: function()
				{
					var me = this,
						formatOpts = "",
						separatorOpts = "";

					for (var i in me.formats)
						formatOpts += '<option value="'+cff_esc_attr(me.formats[i])+'" '+((me.formats[i]==me.dformat)?"selected":"")+'>'+cff_esc_attr(me.formats[i])+'</option>';

					for (var i in me.separators)
						separatorOpts += '<option value="'+cff_esc_attr(me.separators[i])+'" '+((me.separators[i]==me.dseparator)?"selected":"")+'>'+cff_esc_attr(me.separators[i])+'</option>';

					return '<hr></hr><label><input type="checkbox" name="sShowDatepicker" id="sShowDatepicker" '+( ( me.showDatepicker ) ? 'CHECKED' : '' )+' > Show input field for the date</label><div class="width50 column"><label>Date Format</label><select name="sFormat" id="sFormat" class="large">'+formatOpts+'</select></div><div class="width50 column"><label>Parts separator</label><select name="sSeparator" id="sSeparator" class="large">'+separatorOpts+'</select></div><div class="clearer"></div>';
				},
			showSpecialDataInstance: function()
				{
					return '<label><input type="checkbox" name="sDisableKeyboardOnMobile" id="sDisableKeyboardOnMobile" '+( ( this.disableKeyboardOnMobile ) ? 'CHECKED' : '' )+' > Disable keboard on mobiles</label>'+

                    '<label><input type="checkbox" name="sMondayFirstDay" id="sMondayFirstDay" '+( ( this.mondayFirstDay ) ? 'CHECKED' : '' )+' > Make Monday the first day of the week</label>'+

                    '<label>Default date [<a class="helpfbuilder" text="You can put one of the following type of values into this field:\n\nEmpty: Leave empty for current date.\n\nDate: A Fixed date with the same date format indicated in the &quot;Date Format&quot; drop-down field.\n\nNumber: A number of days from today. For example 2 represents two days from today and -1 represents yesterday.\n\nString: A smart text indicating a relative date. Relative dates must contain value (number) and period pairs; valid periods are &quot;y&quot; for years, &quot;m&quot; for months, &quot;w&quot; for weeks, and &quot;d&quot; for days. For example, &quot;+1m +7d&quot; represents one month and seven days from today.">help?</a>]</label><input type="text" class="large" name="sDefaultDate" id="sDefaultDate" value="'+cff_esc_attr(this.defaultDate)+'" />'+

					'<label>Min date [<a class="helpfbuilder" text="You can put one of the following type of values into this field:\n\nEmpty: No min Date.\n\nDate: A Fixed date with the same date format indicated in the &quot;Date Format&quot; drop-down field.\n\nField Name: the name of another date field, Ex: fieldname1\n\nNumber: A number of days from today. For example 2 represents two days from today and -1 represents yesterday.\n\nString: A smart text indicating a relative date. Relative dates must contain value (number) and period pairs; valid periods are &quot;y&quot; for years, &quot;m&quot; for months, &quot;w&quot; for weeks, and &quot;d&quot; for days. For example, &quot;+1m +7d&quot; represents one month and seven days from today.">help?</a>]</label><input type="text" class="large" name="sMinDate" id="sMinDate" value="'+cff_esc_attr(this.minDate)+'" />'+

					'<label>Max date [<a class="helpfbuilder" text="You can put one of the following type of values into this field:\n\nEmpty: No max Date.\n\nDate: A Fixed date with the same date format indicated in the &quot;Date Format&quot; drop-down field.\n\nField Name: the name of another date field, Ex: fieldname1\n\nNumber: A number of days from today. For example 2 represents two days from today and -1 represents yesterday.\n\nString: A smart text indicating a relative date. Relative dates must contain value (number) and period pairs; valid periods are &quot;y&quot; for years, &quot;m&quot; for months, &quot;w&quot; for weeks, and &quot;d&quot; for days. For example, &quot;+1m +7d&quot; represents one month and seven days from today.">help?</a>]</label><input type="text" class="large" name="sMaxDate" id="sMaxDate" value="'+cff_esc_attr(this.maxDate)+'" />'+

                    '<label>Invalid Dates [<a class="helpfbuilder" text="To define some dates as invalid, enter the dates with the format: mm/dd/yyyy separated by comma; for example: 12/31/2014,02/20/2014 or by hyphen for intervals; for example: 12/20/2014-12/28/2014 ">help?</a>]</label><input type="text" class="large" name="sInvalidDates" id="sInvalidDates" value="'+cff_esc_attr(this.invalidDates)+'" />'+

                    '<label>Invalid Dates Error Message</label><input type="text" class="large" name="sErrorMssg" id="sErrorMssg" value="'+cff_esc_attr(this.errorMssg)+'" />'+

                    '<label><input type="checkbox" name="sShowDropdown" id="sShowDropdown" '+((this.showDropdown)?"checked":"")+'/> Show Dropdown Year and Month</label><div id="divdropdownRange" style="display:'+((this.showDropdown)?"":"none")+'">Year Range [<a class="helpfbuilder" text="The range of years displayed in the year drop-down: either relative to today\'s year (&quot;-nn:+nn&quot;), absolute (&quot;nnnn:nnnn&quot;), or combinations of these formats (&quot;nnnn:-nn&quot;)">help?</a>]: <input type="text" name="sDropdownRange" id="sDropdownRange" value="'+cff_esc_attr(this.dropdownRange)+'"/></div>'+

					'<div class="working_dates"><label>Selectable dates </label><input name="sWD0" id="sWD0" value="0" type="checkbox" '+((this.working_dates[0])?"checked":"")+'/>Su<input name="sWD1" id="sWD1" value="1" type="checkbox" '+((this.working_dates[1])?"checked":"")+'/>Mo<input name="sWD2" id="sWD2" value="2" type="checkbox" '+((this.working_dates[2])?"checked":"")+'/>Tu<input name="sWD3" id="sWD3" value="3" type="checkbox" '+((this.working_dates[3])?"checked":"")+'/>We<input name="sWD4" id="sWD4" value="4" type="checkbox" '+((this.working_dates[4])?"checked":"")+'/>Th<input name="sWD5" id="sWD5" value="5" type="checkbox" '+((this.working_dates[5])?"checked":"")+'/>Fr<input name="sWD6" id="sWD6" value="6" type="checkbox" '+((this.working_dates[6])?"checked":"")+'/>Sa</div>'+

					// Fields for timepicker
					'<hr></hr>'+
					'<label><input type="checkbox" name="sShowTimepicker" id="sShowTimepicker" '+( ( this.showTimepicker ) ? 'CHECKED' : '' )+' > Include time</label>'+
					'<div class="time-options" '+( ( !this.showTimepicker ) ? 'style="display:none;"': '' )+'>'+

					'<label>Time Format</label><label><input type="radio" name="sTimeFormat" id="sTimeFormat" value="24" '+( ( this.tformat == 24 ) ? 'CHECKED' : '' )+' /> 24 hours</label> <label><input type="radio" name="sTimeFormat" id="sTimeFormat" value="12" '+( ( this.tformat == 12 ) ? 'CHECKED' : '' )+' /> 12 hours</label>'+

					'<label>Default Time HH:mm</label><input type="text" class="large" name="sDefaultTime" id="sDefaultTime" value="'+cff_esc_attr(this.defaultTime)+'" />'+
					'<div class="width50 column"><label>Min Hour</label><input type="text" class="large" name="sMinHour" id="sMinHour" value="'+cff_esc_attr(this.minHour)+'" /></div>'+
					'<div class="width50 columnr"><label>Min Minutes</label><input type="text" class="large" name="sMinMinute" id="sMinMinute" value="'+cff_esc_attr(this.minMinute)+'" /></div>'+
					'<div class="width50 column"><label>Max Hour</label><input type="text" class="large" name="sMaxHour" id="sMaxHour" value="'+cff_esc_attr(this.maxHour)+'" /></div>'+
					'<div class="width50 columnr"><label>Max Minutes</label><input type="text" class="large" name="sMaxMinute" id="sMaxMinute" value="'+cff_esc_attr(this.maxMinute)+'" /></div>'+

					'<label>Steps for hours</label><input type="text" class="large" name="sStepHour" id="sStepHour" value="'+cff_esc_attr(this.stepHour)+'" />'+
					'<label>Steps for minutes</label><input type="text" class="large" name="sStepMinute" id="sStepMinute" value="'+cff_esc_attr(this.stepMinute)+'" />'+
					'<label>Label for hours in screen readers</label><input type="text" class="large" name="sAriaHourLabel" id="sAriaHourLabel" value="'+cff_esc_attr(this.ariaHourLabel)+'" />'+
					'<label>Label for minutes in screen readers</label><input type="text" class="large" name="sAriaMinuteLabel" id="sAriaMinuteLabel" value="'+cff_esc_attr(this.ariaMinuteLabel)+'" />'+
					'<label>Label for am/pm component in screen readers</label><input type="text" class="large" name="sAriaAMPMLabel" id="sAriaAMPMLabel" value="'+cff_esc_attr(this.ariaAMPMLabel)+'" />'+
					'</div>'+
					'<hr></hr>';
				}
	});