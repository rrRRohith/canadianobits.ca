	$.fbuilder['version'] = '1.1.128';
	$.fbuilder['controls'] = $.fbuilder['controls'] || {};
	$.fbuilder['forms'] = $.fbuilder['forms'] || {};

	$.fbuilder['htmlEncode'] = window['cff_esc_attr'] = function(value)
	{
		return $('<div/>').text(value).html()
				.replace(/"/g, "&quot;")
				.replace(/&amp;lt;/g, '&lt;')
				.replace(/&amp;gt;/g, '&gt;');
	};

	$.fbuilder['htmlDecode'] = window['cff_html_decode'] = function(value)
	{
		return (/&(?:#x[a-f0-9]+|#[0-9]+|[a-z0-9]+);?/ig.test(value)) ? $('<div/>').html(value).text() : value;
	};

	$.fbuilder['sanitize'] = window['cff_sanitize'] = function(value)
	{
        if(typeof value == 'string')
            value = value.replace(/<script\b.*\bscript>/ig, '')
                         .replace(/<script[^>]*>/ig, '');
		return value;
	};

    $.fbuilder['escapeSymbol'] = function( value ) // Escape the symbols used in regulars expressions
	{
		return value.replace(/([\^\$\-\.\,\[\]\(\)\/\\\*\?\+\!\{\}])/g, "\\$1");
	};

	$.fbuilder[ 'parseValStr' ] = function( value, raw, no_quotes )
	{
		raw = raw || false;
        no_quotes = no_quotes || false;
		value = $.trim(value || '');
		value = value.replace(/\\/g, "\\\\").replace(/'/g, "\\'").replace(/"/g, '\\"');
		return ($.isNumeric(value)) ? ((raw) ? value : value*1) : ((no_quotes) ? value : '"' + value + '"');
	};

	$.fbuilder[ 'parseVal' ] = function( value, thousand, decimal, no_quotes )
	{
		if(!!value == false) return 0;
        no_quotes = no_quotes || false;
		/* date */
		if(/(\d{1,2}[\/\.\-]\d{1,2}[\/\.\-]\d{4})|(\d{4}[\/\.\-]\d{1,2}[\/\.\-]\d{1,2})/.test(value))
			return $.fbuilder[ 'parseValStr' ]( value, false, no_quotes );

		/* number */
		thousand = $.fbuilder.escapeSymbol($.trim((typeof thousand != 'undefined') ? thousand : ','));
		decimal  = $.trim((!!!decimal || /^\s*$/.test(decimal)) ? '.': decimal);

		var t = (new String(value)).replace(new RegExp((/^\s*$/.test(thousand) ? '\,' : thousand)+'\(\\d{1,2}\)$' ), decimal+'$1')
				.replace( new RegExp(thousand, 'g'), '' )
				.replace( new RegExp($.fbuilder.escapeSymbol(decimal), 'g' ), '.' )
				.replace( /\s/g, '' ),
			p = /[+\-]?((\d+(\.\d+)?)|(\.\d+))(?:[eE][+\-]?\d+)?/.exec( t );
		return (p) ? ((/^0\d/.test(p[0])) ? p[0].substr(1) : p[0])*1 : $.fbuilder['parseValStr'](value, false, no_quotes);
	};

	$.fbuilder[ 'isMobile' ] = function() {
        try{ document.createEvent("TouchEvent"); return true; }
        catch(e){ return false; }
    };

	$.fbuilder[ 'setBrowserHistory' ] = function(r)
	{
		if('history' in window)
		{
			var b = '#',
				s = '';
			for(var id in $.fbuilder.forms)
			{
				b += s+'f'+id.replace(/[^\d]/g,'')+'p'+($.fbuilder.forms[id]['currentPage'] || 0);
				s = '|';
			}
			history[(r) ? 'replaceState' : 'pushState']({}, document.title, b);
		}
	};

	$.fbuilder[ 'manageHistory' ] = function(onload)
	{
		var b = (document.URL.split('#')[1] || null),
			m, f, t, flag = false;

		if(b)
		{
			while(m = b.match(/f(\d+)p(\d+)\|?/))
			{
				f = '_'+m[1];
				t = onload ? 0 : m[2]*1;
				b = b.replace(m[0],'');

				flag = (
					!(f in $.fbuilder.forms) ||
					t != $.fbuilder['goToPage'](
						{
							'formIdentifier' : f,
							'from' 			 : 0,
							'to'			 : t,
                            'animate'        : false
						}
					)
				);
			}
		}
		else
		{
			for(f in $.fbuilder.forms)
				if('currentPage' in $.fbuilder.forms[f])
					$.fbuilder['goToPage']({'formIdentifier' : f, 'from' : 0, 'to' : 0, 'animate': false});
		}
		if(flag) $.fbuilder.setBrowserHistory(true);
	};

	$.fbuilder[ 'goToPage' ] = function( config )
	{
        function swapPages(pageToHide, pageToShow, callback)
        {
            var t = 300;
            if(('animate' in config && config.animate == false) || pageToHide.closest('form').data('animate_form')*1 == 0) t = 0;
            pageToHide.fadeOut(t, function(){
                pageToHide.find(".field").addClass("ignorepb");
                pageToShow.fadeIn(t, function(){
                    pageToShow.find(".ignorepb").removeClass("ignorepb");
                    callback();
                    if('callback' in config) config.callback();
                });
            });
        };

		if(
			('formIdentifier' in config || 'form' in config) &&
			'to' in config
		)
		{
			var id 	= (config['form']) ?  $('[name="cp_calculatedfieldsf_pform_psequence"]', config['form']).val() : config['formIdentifier'],
				formObj 	= $.fbuilder.forms[id],
				_from		= (config['from'] || formObj['currentPage'] || 0)*1,
				_to			= config['to']*1,
				direction  	= (_from < _to) ? 1 : -1,
				formDom		= $(config['form'] || '[id="'+formObj.formId+'"]'),
				pageDom, i  = _from;

			while(i != _to)
			{
				if(direction == 1 && ( ! ( 'forcing' in config ) ||  config[ 'forcing' ] == false ) && !formDom.valid() ) break;
				i += direction;
			}
			formObj['currentPage'] = i;
			pageDom = $(".pbreak.pb"+i,formDom);

            swapPages(
                $(".pbreak:visible",formDom),
                pageDom,
                function()
                {
                    if(i != _from)
                    {
                        try
                        {
                            if(!$.fbuilder.isMobile())
                            {
                                var ff  = pageDom.find(":focusable:first");
                                if( ff &&
                                    !ff.hasClass('hasDatepicker') &&
                                    ff.attr('type') != 'button' &&
                                    ff.attr('type') != 'radio' &&
                                    ff.attr('type') != 'checkbox' &&
                                    ff.closest('[uh]').length == 0 /* FIXES AUTO-OPEN TOOLTIPS */
                                ) ff.focus();
                            }
                            var _wScrollTop = $(window).scrollTop(),
                                _viewportHeight = $(window).height(),
                                _scrollTop  = formDom.offset().top;
                            if(_scrollTop < _wScrollTop || (_wScrollTop+_viewportHeight)<_scrollTop )
                                $( 'html, body' ).animate({scrollTop:  _scrollTop}, 50);
                        }
                        catch(e){}
                    }
                    else
                    {
                        formDom.validate().focusInvalid();
                    }
                    $(document).trigger('cff-gotopage', {'from': _from, 'to': i, 'form': formDom});
                }
            );

			return i;
		}
	}; // End goToPage

	$.fbuilder[ 'showHideDep' ] = function( config )
	{
        // If isNotFirstTime the enqueue the equations associated to the fields
		var processItems = function( items, isNotFirstTime )
		{
			for( var i = 0, h = items.length; i < h; i++ )
			{
				if(typeof items[i] == 'string') items[i] = $.fbuilder['forms'][id].getItem(items[i]);
				if(items[i])
				{
					if(isNotFirstTime)
					{
						$('[name="'+items[i].name+'"]').trigger('depEvent');
						if(items[i].usedInEquations) $.fbuilder['calculator'].enqueueEquation(id, items[i].usedInEquations);
					}
					if('showHideDep' in items[i])
					{
						var list = items[i]['showHideDep']( toShow, toHide, hiddenByContainer, interval );
						if(list && list.length) processItems( list, true );
					}
				}
			}
		};

		if('formIdentifier' in config)
		{
			var id = config['formIdentifier'];

			if(id in $.fbuilder['forms'])
			{
				var interval = $('#'+$.fbuilder['forms'][id]['formId']).data('animate_form') ? 250 : 0,
                    toShow = $.fbuilder['forms'][id]['toShow'],
					toHide = $.fbuilder['forms'][id]['toHide'],
					hiddenByContainer = $.fbuilder['forms'][id]['hiddenByContainer'],
					items = ('fieldIdentifier' in config) ? [$.fbuilder['forms'][id].getItem(config['fieldIdentifier'].replace(/_[cr]b\d+$/i, ''))] : $.fbuilder['forms'][id].getItems();

				processItems(items);
				$(document).trigger('showHideDepEvent', $.fbuilder['forms'][id]['formId']);
			}
		}
	};

	// Load default values
	$.fbuilder[ 'cpcffLoadDefaults' ] = function( o )
	{
		if( typeof cpcff_default != 'undefined' )
		{
			var $ = fbuilderjQuery,
				id = o.identifier.replace(/[^\d]/g, ''),
				item, data, formObj, f;

			if(id in cpcff_default)
			{
				data = cpcff_default[id];
				id = '_'+id;
				formObj = $.fbuilder['forms'][id];
				f = $('#'+formObj['formId']);
				f.attr('data-evalequations',0);
				for( var fieldId in data )
				{
					item = formObj.getItem(fieldId+id);
					try{ if('setVal' in item) item.setVal(data[fieldId], true, true); $('[name*="'+item.name+'"]').trigger('trigger_ds'); }
					catch(err){}
				}

				f.attr('data-evalequations',o.evalequations);
				$.fbuilder.showHideDep({'formIdentifier' : o.identifier});
			}
		}
	};

	$.fn.fbuilder = function(options){
		var opt = $.extend({},
					{
						pub:false,
						identifier:"",
						title:""
					},options, true);

		opt.messages = $.extend(
			{
				previous: "Previous",
				next: "Next",
				pageof: "Page {0} of {0}",
				required: "This field is required.",
				email: "Please enter a valid email address.",
				datemmddyyyy: "Please enter a valid date with this format(mm/dd/yyyy)",
				dateddmmyyyy: "Please enter a valid date with this format(dd/mm/yyyy)",
				number: "Please enter a valid number.",
				digits: "Please enter only digits.",
				maxlength: "Please enter no more than {0} characters.",
				minlength: "Please enter at least {0} characters.",
				equalTo: "Please enter the same value again.",
				max: "Please enter a value less than or equal to {0}.",
				min: "Please enter a value greater than or equal to {0}.",
				currency: "Please enter a valid currency value."
			},
			(opt.messages || {})
		);

		opt.messages.max = $.validator.format(opt.messages.max);
		opt.messages.min = $.validator.format(opt.messages.min);
		opt.messages.maxlength = $.validator.format(opt.messages.maxlength);
		opt.messages.minlength = $.validator.format(opt.messages.minlength);
		opt.messages.dateyyyymmdd = opt.messages.datemmddyyyy;
		opt.messages.dateyyyyddmm = opt.messages.dateddmmyyyy;

		$.extend($.validator.messages, opt.messages);

		$("#cp_calculatedfieldsf_pform"+opt.identifier).validate({
			ignore:".ignore,.ignorepb",
			errorElement: "div",
			errorPlacement: function(e, element)
				{
					var _parent = element.closest( '.dfield' ),
						_uh =  _parent.find( 'span.uh:visible' ),
						_arg = {'position' : 'absolute'},
						_t  = _parent.find('input[type="button"],input[type="reset"],input[type="text"],input[type="number"],input[type="email"],input[type="file"],input[type="color"],input[type="date"],input[type="password"],input[type="email"],select,textarea');

						try{
							if(_t.length) _arg['left'] = _t.first()[0].offsetLeft;
						} catch (err) {}
					e.addClass( 'message' ).css( _arg ).appendTo( ( _uh.length ) ? _uh : _parent );
				}
		}).messages = opt.messages;

		var items = [],
			fieldsIndex = {},
			reloadItemsPublic = function()
			{
				var form_tag 		= $("#cp_calculatedfieldsf_pform"+opt.identifier),
                    header_tag      = $("#formheader"+opt.identifier),
					fieldlist_tag 	= $("#fieldlist"+opt.identifier),
					page_tag,
					i = 0,
					page = 0,
					getCaptchaHTML = function(){
						var captcha_tag = $( "#cpcaptchalayer"+opt.identifier+':not(:empty)')
							html = '';
						if( captcha_tag.length )
						{
							html += '<div class="captcha">'+captcha_tag.html()+'</div><div class="clearer"></div>';
							captcha_tag.remove();
						}
						return html;
					},
					getSubmitHTML = function(){
						var submit_tag = $("#cp_subbtn"+opt.identifier+':not(:empty)'),
							html = '';
						if( submit_tag.length )
						{
							html += '<div class="pbSubmit" tabindex="0">'+submit_tag.html()+'</div>';
							submit_tag.remove();
						}
						return html;
					};

				form_tag.addClass( theForm.formtemplate );
				if( !opt.cached )
				{
					page_tag = $('<div class="pb'+page+' pbreak" page="'+page+'"></div>');
                    header_tag.html($.fbuilder.sanitize(theForm.show()));
					fieldlist_tag.addClass(theForm.formlayout).append(page_tag);

					for(i; i<items.length; i++)
					{
						items[i].index = i;
						if (items[i].ftype=="fPageBreak")
						{
							page++;
							page_tag = $('<div class="pb'+page+' pbreak" page="'+page+'"></div>');
							fieldlist_tag.append(page_tag);
						}
						else
						{
							page_tag.append((items[i].ftype != 'fhtml') ? $.fbuilder.sanitize(items[i].show()) : items[i].show());
							if (items[i].predefinedClick)
							{
								page_tag.find("#"+items[i].name).attr({placeholder: items[i].predefined, value: ""});
							}
							if(items[i].exclude)
							{
								page_tag.find('.'+items[i].name).addClass('cff-exclude');
							}
							if('audiotutorial' in items[i] && !/^\s*$/.test(items[i].audiotutorial))
							{
								(function(){
									var t = ( typeof opt != 'undefined' && 'messages' in opt && 'audio_tutorial' in opt.messages) ? opt.messages.audio_tutorial : false,
										e = items[i].jQueryRef(),
										c = $('<span class="cff-audio-icon" '+(t ? 'uh="'+cff_esc_attr(t)+'"' : '')+'></span>'),
										a = $('<audio src="'+cff_esc_attr(items[i].audiotutorial)+'" class="cff-audio-tutorial"></audio>');

									a.appendTo(e.find('.dfield'));
									c.appendTo($(e.children('label')[0] || e));

									c.click(function(evt){
										var e = $(this);
										if(e.hasClass('cff-audio-stop-icon')) {
											e.removeClass('cff-audio-stop-icon');
											a[0].pause();
											a[0].currentTime = 0;
										} else {
											$('.cff-audio-stop-icon').click();
											e.addClass('cff-audio-stop-icon');
											a[0].play();
										}
										evt.stopPropagation();evt.preventDefault();return false;
									});
								})()
							}
							if (items[i].userhelpTooltip)
							{
								var uh = items[i].jQueryRef();
								if(items[i].userhelp && items[i].userhelp.length)
								{
									if(items[i].tooltipIcon) $('<span class="cff-help-icon"></span>').attr('uh', items[i].userhelp).appendTo($(uh.children('label')[0] || uh));
									else{
                                        var target = uh.find('input[type="button"],input[type="reset"],input[type="text"],input[type="number"],input[type="email"],input[type="file"],input[type="color"],input[type="date"],input[type="password"],input[type="email"],select,textarea');
                                        if(!target.length) target = uh.find('.slider');
                                        if(!target.length) target = uh.find('.dfield label');
                                        if(!target.length) target = uh.find('.dfield');
                                        if(!target.length) target = uh;
                                        $(target).attr('uh', items[i].userhelp);
                                    }
								}
								uh.find(".uh").remove();
							}
						}
					}
                }
				else
				{
					page = fieldlist_tag.find( '.pbreak' ).length;
					i	 = items.length;
				}

				if (page>0)
				{
					if( !opt.cached ) // Check if the form is cached
					{
						$(".pb"+page, fieldlist_tag).addClass("pbEnd");
						$(".pbreak", fieldlist_tag).each(function(index) {
							var code = '',
								bSubmit = '';

							if (index == page)
							{
								code += getCaptchaHTML();
								bSubmit = getSubmitHTML();
							}

                            $(this).wrapInner('<fieldset></fieldset>')
                            .find('fieldset:eq(0)')
                            .prepend('<legend>'+opt.messages.pageof.replace( /\{\s*\d+\s*\}/, (index+1) ).replace( /\{\s*\d+\s*\}/, (page+1) )+'</legend>')
                            .append(code+'<div class="pbPrevious" tabindex="0">'+opt.messages.previous+'</div><div class="pbNext" tabindex="0">'+opt.messages.next+'</div>'+bSubmit+'<div class="clearer"></div>');
						});
					}

					fieldlist_tag.find(".pbPrevious,.pbNext").bind("keyup", function(evt){
						if(evt.which == 13 || evt.which == 32) $(this).click();
					}).bind("click", {'identifier' : opt.identifier}, function(evt){
						var _from = ($.fbuilder.forms[evt.data.identifier]['currentPage'] || 0),
							_inc  = ($(this).hasClass("pbPrevious")) ? -1 : 1,
							_p = $.fbuilder['goToPage'](
                                {
                                    'formIdentifier' : evt.data.identifier,
                                    'from'			 : _from,
                                    'to'			 : _from+_inc,
                                    'callback'       : function()
                                    {
                                        setTimeout(function(){
                                            if(_from != _p) $.fbuilder.setBrowserHistory();
                                            if(_pDom.find('.fields:visible').length == 0)
                                                if(_inc == -1 && 0 < _p) _pDom.find('.pbPrevious').click();
                                                else if(!_pDom.hasClass('pbEnd')) _pDom.find('.pbNext').click();
                                        }, 10);
                                    }
                                }),
                            _pDom = $('.pb'+_p);

                        return false;
					});
                }
				else
				{
					if( !opt.cached ) $(".pb"+page, fieldlist_tag).append(getCaptchaHTML()+getSubmitHTML());
				}

				if( !opt.cached && opt.setCache)
				{
					// Set Cache
					var url  = document.location.href,
						data = {
							'cffaction' : 'cff_cache',
							'cache'	 : form_tag.html().replace( /\n+/g, '' ),
							'form'	 : form_tag.find( '[name="cp_calculatedfieldsf_id"]').val()
						};
					$.post( url, data, function( data ){ if(typeof console != 'undefined' )console.log( data ); } );
				}

                // Set icon event
				jQuery(document).on('click', '.cff-help-icon', function(evt){evt.stopPropagation(); evt.preventDefault();});

				// Set Captcha Event
				$(document).on('click', '#fbuilder .captcha img', function(){
                    var e = $( this ), src = e.attr('src');
                    // Check URL, and replace it if different from website domain
                    if(
                        !(new RegExp('^http(s)?\:\/\/'+$.fbuilder.escapeSymbol(window.location.host), 'i')).
                        test(src)
                    ) src = document.location.href.split('?')[0]+'?'+src.split('?')[1];
                    e.attr('src', src.replace(/&\d+$/, '') + '&' + Math.floor(Math.random()*1000));
                });
				$( form_tag ).find( '.captcha img' ).click();

				$( '#fieldlist'+opt.identifier).find(".pbSubmit").bind("keyup", function(evt){
					if(evt.which == 13 || evt.which == 32) $(this).click();
				}).bind("click", { 'identifier' : opt.identifier }, function(evt){
					$(this).closest("form").submit();
				});

				if (i>0)
				{
                    theForm.after_show( opt.identifier );
					for (var i=0;i<items.length;i++)
					{
						items[i].after_show();
                        if('csslayout' in items[i] && /\bignorefield\b/i.test(items[i]['csslayout']))
                            IGNOREFIELD(items[i].name, items[i].form_identifier);
					}

					$(document).on(
						'change',
						'#fieldlist'+opt.identifier+' .depItemSel,'+'#fieldlist'+opt.identifier+' .depItem',
						{ 'identifier' : opt.identifier },
						function( evt )
						{
							$.fbuilder.showHideDep(
								{
									'formIdentifier' : evt.data.identifier,
									'fieldIdentifier': evt.target.id
								}
							);
						}
					);

					setTimeout(
						function(){
							$.fbuilder.showHideDep(
								{
									'formIdentifier' : opt.identifier
								}
							);
							$('.cff-processing-form').remove();
						}, 50
					);

					try
					{
						$.widget.bridge('uitooltip', $.ui.tooltip);
						$( "#fbuilder"+opt.identifier ).uitooltip({show: false,hide:false,tooltipClass:"uh-tooltip",position: { my: "left top", at: "left bottom+5", collision: "flipfit"  },items: "[uh]",content: function (){return $(this).attr("uh");}, open: function( evt, ui ){ try{ if(window.matchMedia("screen and (max-width: 640px)").matches){
							var duration = ('undefined' != typeof tooltip_duration && /^\d+$/.test(tooltip_duration)) ? tooltip_duration : 3000;
							setTimeout( function(){$(ui.tooltip).hide('fade'); }, duration);
						}}catch( err ){}} });
					} catch(e){}
                }
                $("#fieldlist"+opt.identifier+" .pbreak:not(.pb0)").find(".field").addClass("ignorepb");
			};

		var fform=function(){};
		$.extend(fform.prototype,
			{
				title:"Untitled Form",
				description:"This is my form. Please fill it out. It's awesome!",
				formlayout:"top_aligned",
				formtemplate:"",
                evalequations:1,
                evalequationsevent:2,
                loading_animation:0,
                animate_form:0,
                autocomplete:1,
				show:function(){
                    return '<div class="fform" id="field">'+( !/^\s*$/.test( this.title ) ? '<h2>'+this.title+'</h2>' : '' )+( !/^\s*$/.test( this.description ) ? '<span>'+this.description+'</span>' : '' )+'</div>';
				},
                after_show:function( id ){
                    // Common validators
                    if( typeof $[ 'validator' ] != 'undefined' )
					{
						if(!('cffcurrency' in $.validator.methods))
							$.validator.addMethod(
								'cffcurrency',
								function(v, el)
								{
									var f = el.id.match( /_\d+$/),
										esc = $.fbuilder.escapeSymbol,
										r;

									e = $.fbuilder['forms'][f[0]].getItem( el.name );
									r = new RegExp('^\\s*('+esc(e.currencySymbol)+')?\\s*\\-?\\d+('+esc(e.thousandSeparator)+'\\d{3})*'+((e.noCents) ? '': '('+e.centSeparator+'\\d+)?')+'\\s*('+esc(e.currencyText)+')?\\s*$','i');

									return this.optional(el) || r.test(v) || ($.isNumeric(v) && (!e.noCents || v === FLOOR(v)));
								},
								$.validator.messages['currency']
							);
                        $.validator.methods.number = function(v, el)
							{
								var f = el.id.match(/_\d+$/),
									esc = $.fbuilder.escapeSymbol,
									e, r;

								if(f) e = $.fbuilder['forms'][f[0]].getItem(el.name);
								if(!e) e = {thousandSeparator: ',', decimalSymbol: '.'};

								r = new RegExp('^\\s*\\-?\\d+('+esc(e.thousandSeparator)+'\\d{3})*('+esc(e.decimalSymbol)+'\\d+)?\\s*\\%?\\s*$','i');
								return this.optional(el) || r.test(v) || $.isNumeric(v);
							};
                        $.validator.methods.min = function(v, el, p)
							{
								var f = el.id.match( /_\d+$/), e;
								if(f) e = $.fbuilder['forms'][f[0]].getItem(el.name);
								if(e){
									v = e.val();
									if('dformat' in e && e.dformat == 'percent') v*=100;
								}
								return this.optional(el) || v >= p;
							};
						$.validator.methods.max = function(v, el, p)
							{
								var f = el.id.match( /_\d+$/), e;
								if(f) e = $.fbuilder['forms'][f[0]].getItem(el.name);
								if(e){
									v = e.val();
									if('dformat' in e && e.dformat == 'percent') v*=100;
								}
								return this.optional(el) || v <= p;
							};
					}

					var form = $( '#cp_calculatedfieldsf_pform'+id );

                    // Disabling enter key
                    form.on('keydown keyup keypress', '[type="text"],[type="number"],[type="password"],[type="email"]',
                        function(evt){
                            if (evt.keyCode === 13)
                            {
                                evt.preventDefault();
                                evt.stopPropagation();
                                return false;
                            }
                        });

					if(typeof $.fn.fbuilder_localstorage != 'undefined' && form.hasClass('persist-form'))
					{
						form.fbuilder_localstorage();
					}

                    form.attr( 'data-evalequations', this.evalequations )
						.attr( 'data-evalequationsevent', this.evalequationsevent )
						.attr( 'data-animate_form', this.animate_form )
						.attr( 'autocomplete', ( ( this.autocomplete ) ? 'on' : 'off' ) )
						.find( 'input,select' )
						.blur( function(){ try{ if(!$(this).is(':file')) $(this).valid(); }catch(e){};} );
					if(!this.autocomplete) form.find('input[name*="fieldname"]:not([autocomplete])').attr('autocomplete', 'new-password');
                }
			});

		//var theForm = new fform(),
		var theForm,
			ffunct = {
				toShow : {},
				toHide : {},
				hiddenByContainer : {},
				getItem: function( name )
					{
						if(name in fieldsIndex) return items[fieldsIndex[name]];
						var regExp = new RegExp((parseInt(name,10) == name) ? 'fieldname'+name+'_' : name+'_', i);
						for( var i in items )
						{
							if( items[ i ].name == name || regExp.test(items[ i ].name))
							{
								return items[ i ];
							}
						}
						return false;
					},
				getItems: function()
					{
					   return items;
					},
				loadData:function(f)
					{
						var d =  window[ f ];
						if ( typeof d != 'undefined' )
						{
							if( typeof d == 'object' && ( typeof d.nodeType !== 'undefined' || d instanceof jQuery ) ){ d = jQuery.parseJSON( jQuery(d).val() ); }
							else if( typeof d == 'string' ){ d = jQuery.parseJSON( d ); }

							if (d.length == 2)
							{
							   this.formId = d[ 1 ][ 'formid' ];
							   items = [];
							   for (var i=0;i<d[0].length;i++)
							   {
								   var obj = new $.fbuilder.controls[d[0][i].ftype]();
								   obj = $.extend(true, {}, obj,d[0][i]);
								   obj.name = obj.name+opt.identifier;
								   obj.form_identifier = opt.identifier;
								   obj.init();
								   /* items[items.length] = obj; */
								   items[i] = obj;
								   fieldsIndex[obj.name] = i;
							   }
							   theForm = new fform();
							   theForm = $.extend(theForm,d[1][0]);

							   opt.evalequations = d[1][0][ 'evalequations' ];
							   opt.cached   = (typeof d[ 1 ][ 'cached' ] != 'undefined' && d[ 1 ][ 'cached' ] ) ? true : false;
							   opt.setCache = (!this.cached && typeof d[ 1 ][ 'setCache' ] != 'undefined' && d[ 1 ][ 'setCache' ]) ? true : false;

							   reloadItemsPublic();
						    }
							$.fbuilder.cpcffLoadDefaults( opt );
						}
					}
			};

		$.fbuilder[ 'forms' ][ opt.identifier ] = ffunct;
	    this.fBuild = ffunct;
	    return this;
	}; // End fbuilder plugin

	$.fbuilder.controls[ 'ffields' ] = function(){};
	$.extend($.fbuilder.controls[ 'ffields' ].prototype,
		{
				form_identifier:"",
				name:"",
				shortlabel:"",
				index:-1,
				ftype:"",
				userhelp:"",
				audiotutorial:"",
				userhelpTooltip:false,
				csslayout:"",
				init:function(){},
				_getAttr:function(attr, raw)
					{
						var me = this, f, v = $.trim(me[attr]), raw = raw || false;
						if(!raw && $.isNumeric(v)) return parseFloat(v);
						f = (/^fieldname\d+$/i.test(v)) ? me.getField(v) : false;
						if(f)
						{
							v = f.val();
							if(f.ftype == 'fdate') return new Date(v*86400000);
							if(!raw && $.isNumeric(v)) return parseFloat(v);
							return v.replace(/^"+/, '').replace(/"+$/, '');
						}
						return v;
					},
				_setHndl:function(attr, one)
					{
						var me = this, v = $.trim(me[attr]);
						if($.isNumeric(v)) return;
						var s = (/^fieldname\d+$/i.test(v)) ? '[id*="'+v+me.form_identifier+'"]' : v,
							i = (one) ? 'one' : 'on';
						if('string' == typeof s && !/^\s*$/.test(s))
						{
							s = $.trim(s);
							if(!$.isNumeric(s.charAt(0)))
							{
								$(document)[i]('change depEvent', s, function(evt){
									if(me['set_'+attr]) me['set_'+attr](me._getAttr(attr), $(evt.target).hasClass('ignore'));
								});

                                $(document)['one']('showHideDepEvent', function(evt,formId){
                                    try
                                    {
                                        if(me['set_'+attr])
                                        {
                                            me['set_'+attr](me._getAttr(attr), $(s).hasClass('ignore'));
                                            $('#'+formId).validate().resetForm();
                                        }
                                    }
                                    catch(err){}
								});
							}
						}
					},
				getField: function(f){return $.fbuilder['forms'][this.form_identifier].getItem(f);},
				jQueryRef: function(){return $('.'+this.name);},
				show:function()
					{
						return 'Not available yet';
					},
				after_show:function(){},
				val:function(raw, no_quotes){
					raw = raw || false;
                    no_quotes = no_quotes || false;
					var e = $( "[id='" + this.name + "']:not(.ignore)" );
					if( e.length )
					{
						var v = e.val();
						if(raw) return $.fbuilder.parseValStr(v, raw, no_quotes);

						v = $.trim(v);
						return ($.isNumeric(v)) ? $.fbuilder.parseVal(v) : $.fbuilder.parseValStr(v, raw, no_quotes);
					}
					return 0;
				},
				setVal:function( v, nochange )
				{
					var e = $( "[id='" + this.name + "']" );
					e.val( v );
					if(!nochange) e.change();
				}
		});

	// Read history
	window.addEventListener('popstate', function(){
		try
		{
			// Solves an issue with the datepicker if it is opened and back/next buttons in browser are pressed
			$(".ui-datepicker").hide();
			$.fbuilder.manageHistory();
		}
		catch(err){}
	});

	$(window).on('load', function(){
		$.fbuilder.manageHistory(true);
	});

	$(document).on('click', '#fbuilder .cff-spinner-down,#fbuilder .cff-spinner-up', function(){
		var u = $(this).hasClass('cff-spinner-up'),
			e = $(this)[u ? 'prev' : 'next']('input'),
			o, s, m, v;

		if(e.length) {
			o = getField(e.attr('id'), e[0].form);
			s = e.attr('step') || 1;
			m = e.attr(u ? 'max' : 'min');
			v = o.val();
			if(e.hasClass('percent')){ v = PREC(v*100, 4)*1; }
			if(u) v += s;
			else v -= s;
			if(m) v = u ? MIN(v,m) : MAX(v,m);
			o.setVal(v);
			e.valid();
		}
	});