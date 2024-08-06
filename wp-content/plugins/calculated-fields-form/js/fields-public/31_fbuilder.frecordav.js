	$.fbuilder.controls['frecordav']=function(){};
	$.extend(
		$.fbuilder.controls['frecordav'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
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
			_has_hours_component:function(){return Math.floor( this.max_time / 3600 ) ? 1 : 0;},
			_is_video: function(){ return this.to_record == 'video' || this.to_record == 'audio-video';},
			_is_audio: function(){ return this.to_record == 'audio' || this.to_record == 'audio-video';},
			_format_time_component:function(v)
				{
					var _has_hours = this._has_hours_component(),
						hours = Math.floor( v / 3600 ),
						minutes = Math.floor( ( v - hours * 3600 ) / 60 ),
						seconds = ( v - hours * 3600 - minutes * 60 ) % 60,
						time_formatted = ( _has_hours ? ( hours < 10 ? '0' + hours : hours ) + ':' : '' ) + ( minutes < 10 ? '0' + minutes : minutes ) + ':' + ( seconds < 10 ? '0' + seconds : seconds );
					return time_formatted;
				},
			_getUserMedia:function()
				{
					return navigator.getUserMedia || navigator.webkitGetUserMedia ||
						navigator.mozGetUserMedia || navigator.msGetUserMedia || false;
				},
            show:function()
				{
					var max_time_formatted = this._format_time_component(this.max_time),
						time_formatted = ( this._has_hours_component() ? '00:' : '')+'00:00';

					return '<div class="fields '+cff_esc_attr(this.csslayout)+' '+this.name+' cff-record-av-field" id="field'+this.form_identifier+'-'+this.index+'">' +
					'<label for="'+this.name+'_record_btn">'+this.title+''+((this.required)?"<span class='r'>*</span>":"")+'</label>' +
					'<div class="dfield">' +
					'<input type="file" id="'+this.name+'" name="'+this.name+'[]" class="hide-strong" />' +
					'<div class="cff-record-controls-container">' +
					'<div class="cff-record-btn" id="'+this.name+'_record_btn">'+cff_sanitize(this.record_label)+'</div>' +
					( this.preview ? '<div class="cff-record-play-btn hide-strong" id="'+this.name+'_play_btn"></div>' : '' ) +
					( this.max_time ? '<div class="cff-record-time" id="'+this.name+'_record_time">'+time_formatted+'</div><div class="cff-record-max-time">'+max_time_formatted+'</div>' : '' ) +
					'</div>' +
					'<div class="clearer"></div>' +
					'<div class="cff-record-status hide-strong" id="'+this.name+'_record_status">'+cff_sanitize(this.status_message)+'</div>' +
					( this.preview ? (this._is_video() ? '<video id="'+this.name+'_media" width="'+cff_esc_attr(this.video_width)+'" height="'+cff_esc_attr(this.video_height)+'" class="hide-strong" style="margin-top:20px;" preload="metadata"></video>': '<audio id="'+this.name+'_media" class="hide-strong"></audio>') : '' ) +
					'<div class="clearer"></div>' +
					'<span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			after_show:function()
			{
				var me 			= this,
					mssg 		= $('#'+me.name+'_record_status'),
					record_btn 	= $('#'+this.name+'_record_btn'),
					play_btn 	= $('#'+me.name+'_play_btn'),
					file_ctrl	= $('#'+me.name),
					media_ctrl	= $('#'+me.name+'_media'),
					record_time = $('#'+me.name+'_record_time'),
					chunks 		= [],
					interval,
					streamRecorder,
					recording_flag = false;

				play_btn[_files().length ? 'removeClass' : 'addClass' ]('hide-strong');
				navigator.getUserMedia = me._getUserMedia();

				if(media_ctrl.length)
				{
					media_ctrl[0].ontimeupdate = function(evt){
						if(!recording_flag)	record_time.text(me._format_time_component(Math.round(evt.target.currentTime)));
					};
					media_ctrl[0].onended = function(evt){
						evt.target.currentTime = 0;
						play_btn.removeClass('cff-record-stop-btn');
					};
				}

				if(!navigator.getUserMedia) {
					$('.'+me.name).remove();
					return;
				}

				function _files() {
					return file_ctrl[0].files;
				};

				function _load_file() {
					var files = _files();
					if(files.length && media_ctrl.length)
					{
						media_ctrl[0].src = URL.createObjectURL(files[0]);
						return true;
					}
					return false;
				}

				function _random() {
					return Math.floor(Math.random()*(1000-9999+1)+1000);
				};

				function _stopRecording() {
					try {
						if(typeof streamRecorder != 'undefined')
						{
							streamRecorder.onstop = function(evt) {
								var container = new DataTransfer(),
									file = new File(
										chunks,
										me.to_record+_random()+'.webm',
										{type:'video/webm', lastModified:new Date().getTime()}
									);
								container.items.add(file);
								file_ctrl[0].files = container.files;
								play_btn.removeClass('cff-record-stop-btn hide-strong');
								mssg.removeClass('hide-strong');
								_load_file();
							};
							streamRecorder.stop();
						}
					} catch(err) {console.log(err);};

					record_btn.removeClass('cff-record-btn-recording');
					if(me._is_video() && media_ctrl.length)
					{
						media_ctrl[0].pause();
						media_ctrl[0].srcObject = null;

					}
					recording_flag = false;
				};

				record_btn.click(function(evt){
					var settings = {
							video: (me._is_video()) ? {'facingMode':{exact:'user'}} : false,
							audio: (me._is_audio()) ? true : false
						};

					clearInterval(interval);

					play_btn.addClass('hide-strong');
					mssg.addClass('hide-strong');

					record_btn.toggleClass('cff-record-btn-recording');
					if(record_btn.hasClass('cff-record-btn-recording'))
					{
						var i = 0;
						chunks = [];
						recording_flag = true;
						if(me._is_video() && media_ctrl.length) media_ctrl.removeClass('hide-strong');

						navigator.getUserMedia(
							settings,
							function(localMediaStream)
							{
								streamRecorder = new MediaRecorder(localMediaStream);
								streamRecorder.ondataavailable = function(evt) {chunks.push(evt.data);};
								streamRecorder.start();

								if(me._is_video() && media_ctrl.length)
								{
									media_ctrl[0].srcObject = localMediaStream;
									media_ctrl[0].play();
								}

								interval = setInterval(function(){
									i++;
									if(i < me.max_time) record_time.text(me._format_time_component(i));
									else{
										clearInterval(interval);
										if(me.beep){
											var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
											snd.play();
									   }
									   _stopRecording();
									}
								}, 1000);
							},
							function(err){
								$('.'+me.name+' .dfield').html('<div class="cff-record-error">'+err.name+'</div>');
							}
						);
					}
					else
					{
						_stopRecording();
					}
				});
				play_btn.click(function(){
					if(_load_file())
					{
						play_btn.toggleClass('cff-record-stop-btn');
						if(play_btn.hasClass('cff-record-stop-btn')) media_ctrl[0].play();
						else media_ctrl[0].pause();
					}
				});
			}
		}
	);