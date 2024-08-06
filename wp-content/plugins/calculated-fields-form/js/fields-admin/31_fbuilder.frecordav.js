	$.fbuilder.typeList.push(
		{
			id:"frecordav",
			name:"Recording",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'frecordav' ]=function(){};
	$.extend(
		$.fbuilder.controls[ 'frecordav' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Recording Audio and Video",
			ftype:"frecordav",
			required:false,
			exclude:false,
			size:"medium",
			to_record:"video",
			max_time:0,
			beep:0,
			preview:false,
			video_width:320,
			video_height:240,
			record_label: 'Record',
			stop_label: 'Stop',
			status_message: 'Recording saved',
			showFieldType: function()
			{
				return '<label><b>Field Type: Recording Audio and Video</b><br><i>(Experimental control)</i></label>';
			},
			display:function()
				{
					var hours = Math.floor( this.max_time / 3600 ),
						minutes = Math.floor( ( this.max_time - hours * 3600 ) / 60 ),
						seconds = ( this.max_time - hours * 3600 - minutes * 60 ) % 60,
						max_time_formatted = ( hours ? ( hours < 10 ? '0' + hours : hours ) + ':' : '' ) + ( minutes < 10 ? '0' + minutes : minutes ) + ':' + ( seconds < 10 ? '0' + seconds : seconds ),
						time_formatted = ( hours ? '00:' : '')+'00:00';

					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+cff_sanitize(this.title)+''+((this.required)?"*":"")+'</label><div class="dfield">' +
					'<div class="cff-record-btn">'+cff_sanitize(this.record_label)+'</div>' +
					( this.preview ? '<div class="cff-record-play-btn"></div>' : '' ) +
					( this.max_time ? '<div class="cff-record-time">'+time_formatted+'</div><div class="cff-record-max-time">'+max_time_formatted+'</div>' : '' ) +
					'<div class="clearer"></div>' +
					'<div class="cff-record-status">'+cff_sanitize(this.status_message)+'</div>' +
					'<span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
							{s:"[name='sToRecord']", e:"change", l:"to_record", f:function(el){ return $('[name="sToRecord"]:checked').val();}, x:1},
							{s:"#sPreview",e:"click", l:"preview",f:function(el){return el.is(":checked");}},
							{s:"#sBeepSound",e:"click", l:"beep",f:function(el){return el.is(":checked");}},
							{s:"#sVideoWidth",e:"change keyup", l:"video_width", x:1},
							{s:"#sVideoHeight",e:"change keyup", l:"video_height", x:1},
							{s:"#sMaxTime",e:"change keyup", l:"max_time", x:1},
							{s:"#sRecordLabel",e:"change keyup", l:"record_label", x:1},
							{s:"#sStopLabel",e:"change keyup", l:"stop_label", x:1},
							{s:"#sStatusMessage",e:"change keyup", l:"status_message", x:1}
						];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showSpecialDataInstance: function()
				{
					return '<hr><label>To record</label><label><input type="radio" name="sToRecord" value="audio" '+(this.to_record == 'audio' ? 'CHECKED' : '')+' /> Audio</label><label><input type="radio" name="sToRecord" value="video" '+(this.to_record == 'video' ? 'CHECKED' : '')+' /> Video</label><label><input type="radio" name="sToRecord" value="audio-video" '+(this.to_record == 'audio-video' ? 'CHECKED' : '')+' /> Audio and video</label><hr>'+

					'<label><input type="checkbox" id="sPreview" name="sPreview" '+((typeof this.preview != 'undefined' && this.preview) ? 'CHECKED' : '')+'" /> Audio and video preview</label>'+

					'<div class="column width50"><label>Video Width</label><input type="text" name="sVideoWidth" id="sVideoWidth" value="'+cff_esc_attr(this.video_width)+'"  class="large" /></div>'+

					'<div class="column width50"><label>Video Height</label><input type="text" name="sVideoHeight" id="sVideoHeight" value="'+cff_esc_attr(this.video_height)+'"  class="large" /></div>'+

					'<div class="clearer"></div>'+

					'<label>Max Length (in seconds)</label><input type="number" name="sMaxTime" id="sMaxTime" value="'+cff_esc_attr(this.max_time ? this.max_time : '')+'"  class="width50" /><div class="clearer"><i>Maximum allowed recording time in seconds. A value of 60 means 1 minute.</i></div>'+

					'<label><input type="checkbox" name="sBeepSound" id="sBeepSound" '+(this.beep ? 'CHECKED' : '')+' /> Beep Sound</label><div class="clearer"><i>Will play a beep sound to notify that the recording time is up.</i></div><hr>'+

					'<label>Labels<label>'+
					'<div class="column width50"><label>Record Button</label><input type="text" name="sRecordLabel" id="sRecordLabel" value="'+cff_esc_attr(this.record_label)+'" class="large" /></div>'+
					'<div class="column width50"><label>Stop Button</label><input type="text" name="sStopLabel" id="sStopLabel" value="'+cff_esc_attr(this.stop_label)+'" class="large" /></div><div class="clearer"></div>'+
					'<div><label>Status Message</label><input type="text" name="sStatusMessage" id="sStatusMessage" value="'+cff_esc_attr(this.status_message)+'" class="large" /></div>';
				}
		}
	);