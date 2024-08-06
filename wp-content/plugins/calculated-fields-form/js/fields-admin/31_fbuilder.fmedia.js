	$.fbuilder.typeList.push(
		{
			id:"fMedia",
			name:"Media",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fMedia' ]=function(){};
	$.extend(
		$.fbuilder.controls[ 'fMedia' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			ftype:"fMedia",
            sMediaType:"image", // image, audio, video
            init : function()
				{
					this.data = {
							image:{
								sWidth:"",
								sHeight:"",
								sSrc:"",
								sAlt:"",
								sLink:"",
								sTarget:"",
								sFigcaption: ""
							},
							audio:{
								sWidth:"",
								sSrc:"",
								sSrcAlt:"",
								sControls:1,
								sLoop:0,
								sAutoplay:0,
								sMuted:0,
								sPreload: "auto",
								sFallback: "",
								sFigcaption: "",
								sHideDownload: 0
							},
							video:{
								sWidth:"",
								sHeight:"",
								sSrc:"",
								sSrcAlt:"",
								sPoster:"",
								sControls:1,
								sLoop:0,
								sAutoplay:0,
								sMuted:0,
								sPreload: "auto",
								sFallback: "",
								sFigcaption: "",
								sHideDownload: 0
							}
						};
				},
            _display_image: function()
                {
                    var d = this.data.image,
                        esc = cff_esc_attr,
                        a = [],
                        l = [],
                        r = '';

                    if( $.trim( d.sWidth ) ) a.push( 'width="'+esc( d.sWidth )+'"' );
                    if( $.trim( d.sHeight ) ) a.push( 'height="'+esc( d.sHeight )+'"' );
                    if( $.trim( d.sSrc ) ) a.push( 'src="'+esc( d.sSrc )+'"' );
                    if( $.trim( d.sAlt ) ) a.push( 'alt="'+esc( d.sAlt )+'"' );
                    r = '<img '+a.join( ' ' )+' />';

                    return r;
                },
            _display_audio_video: function( d, isV )
                {
                    var esc = cff_esc_attr,
                        a = [],
						s = [],
                        t = ( isV) ? 'video' : 'audio';

                    if( $.trim( d.sWidth ) ) s.push( 'width:'+esc( d.sWidth )+';' );
                    if( isV && $.trim( d.sHeight ) ) s.push( 'height:'+esc( d.sHeight )+';' );
                    if( isV && $.trim( d.sPoster ) ) a.push( 'poster="'+esc( d.sPoster )+'"' );
                    if( $.trim( d.sSrc ) ) a.push( 'src="'+esc( d.sSrc )+'"' );
                    if( d.sAutoplay ) a.push( 'autoplay' );
                    if( d.sControls ) a.push( 'controls' );
                    if( d.sLoop ) a.push( 'loop' );
                    if( d.sMuted ) a.push( 'muted' );
					if( d.sHideDownload ) a.push( 'controlsList="nodownload"' );
                    a.push( 'preload="'+esc( d.sPreload )+'"' );

                    return '<'+t+' '+a.join(' ')+' style="'+s.join(' ')+'">'+(($.trim(d.sSrcAlt)) ? '<source src="'+esc(d.sSrcAlt)+'" />' : '')+'<p>'+d.sFallback+'</p></'+t+'>';
                },
            _display_audio: function()
                {
                    return this._display_audio_video( this.data.audio, false );
                },
            _display_video: function()
                {
                    return this._display_audio_video( this.data.video, true );
                },
            display:function()
				{
					return '<div class="fields fmark '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this[ '_display_'+this.sMediaType ]()+'</label><span class="uh">'+this.data[ this.sMediaType ][ 'sFigcaption' ]+'</span><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
                    var me = this;
                    $("#sMediaBtn").bind("click", function(e)
						{
							me._loadMedia( 'sSrc', me.sMediaType );
						});
                    $("#sMediaAltBtn").bind("click", function(e)
						{
							me._loadMedia( 'sSrcAlt', me.sMediaType );
						});
                    $("#sPosterBtn").bind("click", function(e)
						{
							me._loadMedia( 'sPoster', 'image' );
						});
                    $("[name='sMediaType']").bind("click", {obj: this}, function(e)
                        {
                            e.data.obj[ this.name ] = $(this).val();
                            $.fbuilder.editItem( e.data.obj.index );
                            $.fbuilder.reloadItems({'field':e.data.obj});
                        });
					$("#sControls,#sLoop,#sAutoplay,#sMuted,#sHideDownload").bind("click", {obj: this}, function(e)
                        {
                            e.data.obj[ 'data' ][ e.data.obj[ 'sMediaType' ] ][ this.id ] = ( this.checked) ? 1 : 0;
                            $.fbuilder.reloadItems({'field':e.data.obj});
                        });
					$("#sWidth,#sHeight,#sSrc,#sSrcAlt,#sPoster,#sAlt,#sLink,#sTarget,#sFallback,#sFigcaption,#sPreload").bind("change keyup", {obj: this}, function(e)
						{
							e.data.obj[ 'data' ][ e.data.obj[ 'sMediaType' ] ][ this.id ] = $(this).val();
                            $.fbuilder.reloadItems({'field':e.data.obj});
						});

					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this);
				},
            showSpecialDataInstance: function()
                {
                    return this._showMediaList()+this._showSettingsBox();
                },
		    _showMediaList: function()
                {
                    var l = [ 'image', 'audio', 'video' ],
                        r  = "", v;

                    for( var i = 0, h = l.length; i < h; i++ )
                    {
                        v = cff_esc_attr(l[i]);
                        r += '<label class="column width30"><input type="radio" name="sMediaType" value="'+v+'" '+((this.sMediaType == v) ? 'CHECKED' : '')+' >'+v+'</label>';
                    }
                    return '<label>Select media type</label>'+r+'<div class="clearer" />';
                },
            _loadMedia: function( f, type )
                {
                    var src_field = $( '#'+f ),
                        media = wp.media({
                            title: 'Select Source',
                            button: {
                                text: 'Select Source'
                            },
                            multiple: false
                    }).on('select',
                        (function( field, type ){
                            return function() {
                                var regExp = new RegExp( type, 'i'),
                                    attachment = media.state().get('selection').first().toJSON();
                                if( !regExp.test( attachment.mime ) )
                                {
                                    alert( 'Invalid mime type' );
                                    return;
                                }
                                field.val( attachment.url ).change();
                            };
                        })( src_field, type )
                    ).open();
                    return false;
                },
            _showSettingsBox: function()
                {
                    var d = this.data[ this.sMediaType ];
                    return '<div class="groupBox">'+this[ '_showSettings_'+this.sMediaType ]( d )+'</div>';
                },
            _showSettings_image: function( d )
                {
                    var esc = cff_esc_attr;
					return '<label>Width</label><input type="text" class="large" name="sWidth" id="sWidth" value="'+esc(d.sWidth)+'">'+
                    '<label>Height</label><input type="text" class="large" name="sHeight" id="sHeight" value="'+esc(d.sHeight)+'">'+
                    '<label>Source</label><div><input type="text" style="width:70%;" name="sSrc" id="sSrc" value="'+esc(d.sSrc)+'"><input id="sMediaBtn" type="button" value="Browse" style="width:28%;" /></div>'+
                    '<label>Alternate</label><input type="text" class="large" name="sAlt" id="sAlt" value="'+esc(d.sAlt)+'">'+
                    '<label>Figcaption</label><input type="text" class="large" name="sFigcaption" id="sFigcaption" value="'+esc(d.sFigcaption)+'">'+
                    '<label>Link</label><input type="text" class="large" name="sLink" id="sLink" value="'+esc(d.sLink)+'">'+
                    '<label>Target</label><input type="text" class="large" name="sTarget" id="sTarget" value="'+esc(d.sTarget)+'" /><span class="uh">_blank, _new, _parent, _self, _top</span>';
                },
            _showSettings_audio_video: function( d, isV )
                {
                    var esc = cff_esc_attr,
                    r  = '<label>Width</label><input type="text" class="large" name="sWidth" id="sWidth" value="'+esc(d.sWidth)+'">';

                    if( isV )
                    r += '<label>Height</label><input type="text" class="large" name="sHeight" id="sHeight" value="'+esc(d.sHeight)+'">';

                    r += '<label>Source</label><div><input type="text" style="width:70%;" name="sSrc" id="sSrc" value="'+esc(d.sSrc)+'"><input id="sMediaBtn" type="button" value="Browse" style="width:28%;" /></div>';

                    if( isV )
                    r += '<label>Poster</label><div><input type="text" style="width:70%;" name="sPoster" id="sPoster" value="'+esc(d.sPoster)+'"><input id="sPosterBtn" type="button" value="Browse" style="width:28%;" /></div>';

                    r += '<label>Alternative Source</label><div><input type="text" style="width:70%;" name="sSrcAlt" id="sSrcAlt" value="'+esc(d.sSrcAlt)+'"><input id="sMediaAltBtn" type="button" value="Browse" style="width:28%;" /></div>'+
                    '<label><input type="checkbox" name="sControls" id="sControls" value="1" '+((d.sControls) ? 'CHECKED' : '')+'> Controls</label>'+
                    '<label><input type="checkbox" name="sLoop" id="sLoop" value="1" '+((d.sLoop) ? 'CHECKED' : '')+'> Loop</label>'+
                    '<label><input type="checkbox" name="sAutoplay" id="sAutoplay" value="1" '+((d.sAutoplay) ? 'CHECKED' : '')+'> Autoplay</label>'+
                    '<label><input type="checkbox" name="sMuted" id="sMuted" value="1" '+((d.sMuted) ? 'CHECKED' : '')+'> Muted</label>'+
					'<label><input type="checkbox" name="sHideDownload" id="sHideDownload" value="1" '+((d.sHideDownload) ? 'CHECKED' : '')+'> Hide the download file control</label>';
                    var s = '',
                        l = [ 'none', 'auto', 'metadata' ];
                    for( var i = 0; i < 3; i++ )
                    {
                        s += '<option value="'+esc(l[i])+'" '+((l[i] == d.sPreload) ? 'SELECTED' : '')+'>'+esc(l[i])+'</option>';
                    }
                    r += '<label>Preload</label><select class="large" name="sPreload" id="sPreload">'+s+'</select>'+
                    '<label>Fallback Text</label><input type="text" class="large" name="sFallback" id="sFallback" value="'+esc(d.sFallback)+'">'+
                    '<label>Figcaption</label><input type="text" class="large" name="sFigcaption" id="sFigcaption" value="'+esc(d.sFigcaption)+'">';
                    return r;
                },
            _showSettings_audio: function( d )
                {
                    return this._showSettings_audio_video( d, false );
                },
            _showSettings_video: function( d )
                {
                    return this._showSettings_audio_video( d, true );
                },
            showTitle: function(){ return ''; },
            showShortLabel: function(){ return ''; },
			showUserhelp: function(){ return ''; }
	});