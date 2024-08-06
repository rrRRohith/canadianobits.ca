	$.fbuilder[ 'typeList' ] = [];
	$.fbuilder[ 'categoryList' ] = [];
	$.fbuilder[ 'controls' ] = {};
	$.fbuilder[ 'displayedDuplicateContainerMessage' ] = false;
	$.fbuilder[ 'duplicateContainerMessage' ] = 'Note: If the container field being duplicated includes calculated fields or fields with dependency rules, the equations and dependencies rules in the new fields are exactly the same equations and dependency rules than in the original fields.';

	$.fbuilder[ 'preview' ] = function( e )
	{
		var f  = $( e.form );
		f.attr( 'target', 'formpopup' ).attr(
			'onsubmit',
			function( f )
			{
				var w = screen.width*0.8,
					h = screen.height*0.7,
					l = screen.width/2 - w/2,
					t = screen.height/2 - h/2,
					new_window = window.open('', 'formpopup', 'resizeable,scrollbars,width='+w+',height='+h+',left='+l+',top='+t);

				$( f ).removeAttr( 'onsubmit' );
				new_window.focus();
			}
		);
		$( '<input type="hidden" name="preview" value="1" />' ).appendTo( f );

		f[ 0 ].submit();
		f.attr( 'target', '_self' ).find( 'input[name="preview"]').remove();
	};

    $.fbuilder['printFields'] = function(){
        var h = '<div><b>field name (title) [Exclude from submission]</b></div><hr />', w;
        $.each(window.cff_form.fBuild.getItems(), function(i, item){
            h += '<div>'+item.name;
            if('title' in item) h += ' ('+item.title+')';
            if('exclude' in item && item.exclude) h += '[EXCLUDED]';
            h += '</div>';
        });
        w = window.open("","cff-fieldlist-popup", "width=500,height=300,scrollbars=1,resizable=1");
        w.document.title = 'Fields List';
        w.document.body.innerHTML = h;
    };

	$.fbuilder[ 'htmlEncode' ] = window[ 'cff_esc_attr' ] = function(value)
	{
		value = $('<div/>').text(value).html();
		value = value.replace(/&/g, '&amp;')
					 .replace(/"/g, "&quot;")
					 .replace(/&amp;lt;/g, '&lt;')
					 .replace(/&amp;gt;/g, '&gt;');
		value = value.replace(/&amp;/g, '&');
		return value;
	};

    $.fbuilder['sanitize'] = window['cff_sanitize'] = function(value)
	{
        if(typeof value == 'string')
            value = value.replace(/<script\b.*\bscript>/ig, '')
                         .replace(/<script[^>]*>/ig, '')
                         .replace(/(\b)(on[a-z]+)\s*=/ig, "$1_$2=");
		return value;
	};

	$.fbuilder['htmlDecode'] = window['cff_html_decode'] = function(value)
	{
		if( /&(?:#x[a-f0-9]+|#[0-9]+|[a-z0-9]+);?/ig.test( value ) ) value = $( '<div/>' ).html( value ).text();
		return value;
	};

	$.fbuilder[ 'escapeSymbol' ] = function( value ) // Escape the symbols used in regulars expressions
	{
		return value.replace(/([\^\$\-\.\,\[\]\(\)\/\\\*\?\+\!\{\}])/g, "\\$1");
	};

	$.fbuilder[ 'parseVal' ] = function( value, thousandSeparator, decimalSymbol )
	{
		if( value == '' ) return 0;
		value += '';

		thousandSeparator = new RegExp( $.fbuilder.escapeSymbol( ( typeof thousandSeparator == 'undefined' ) ? ',' : thousandSeparator ), 'g' );
		decimalSymbol = new RegExp( $.fbuilder.escapeSymbol( ( typeof decimalSymbol == 'undefined' || /^\s*$/.test( decimalSymbol ) ) ? '.' : decimalSymbol ), 'g' );

		var t = value.replace( thousandSeparator, '' ).replace( decimalSymbol, '.' ).replace( /\s/g, '' ),
			p = /[+\-]?((\d+(\.\d+)?)|(\.\d+))(?:[eE][+\-]?\d+)?/.exec( t );

		return ( p ) ? p[0]*1 : '"' + value.replace(/'/g, "\\'").replace( /\$/g, '') + '"';
	};

    $.fbuilder[ 'showErrorMssg' ] = function( str ) // Display an error message
    {
        $( '.form-builder-error-messages' ).html( '<div class="error-text">' + str + '</div>' );
    };

    // fbuilder plugin
	$.fn.fbuilder = function(){
		var typeList = 	$.fbuilder.typeList,
			categoryList = $.fbuilder.categoryList;

		$.fbuilder[ 'getNameByIdFromType' ] = function( id )
			{
				for ( var i = 0, h = typeList.length; i < h; i++ )
				{
					if ( typeList[i].id == id )
					{
						return  typeList[i].name;
					}
				}
				return "";
			};

		for ( var i=0, h = typeList.length; i < h; i++ )
		{
			var category_id = typeList[ i ].control_category;

			if( typeof categoryList[ category_id ]  == 'undefined' )
			{
				categoryList[ category_id ] = { title : '', description : '', typeList : [] };
			}
			else if( typeof categoryList[ category_id ][ 'typeList' ]  == 'undefined' )
			{
				categoryList[ category_id ][ 'typeList' ] = [];
			}

			categoryList[ category_id ].typeList.push( i );
		}

		for ( var i in categoryList )
		{
			$("#tabs-1").append('<div style="clear:both;"></div><div>'+categoryList[ i ].title+'</div><hr />');
			if( typeof categoryList[ i ][ 'description' ] != 'undefined' && !/^\s*$/.test( categoryList[ i ][ 'description' ] ) )
			{
				$("#tabs-1").append('<div style="clear:both;"></div><div class="category-description">'+categoryList[ i ].description+'</div>');
			}

			if( typeof categoryList[ i ][ 'typeList' ]  != 'undefined' )
			{
				for( var j = 0, k = categoryList[ i ].typeList.length; j < k; j++ )
				{
					var index = categoryList[ i ].typeList[ j ];
					$("#tabs-1").append('<div class="button itemForm width40" id="'+typeList[ index ].id+'">'+typeList[ index ].name+'</div>');
				}
			}
		}

		$("#tabs-1").append('<div class="clearer"></div>');
		$( ".button").button();
        $(document).on('mousedown', function(){$.fbuilder.mousedown = 1;})
                   .on('mouseup', function(){$.fbuilder.mousedown = 0;})
                   .on('mouseover', '.ctrlsColumn .itemForm:not(#facceptance):not(#fCalculated)', function(){
                       $(this).addClass('button-primary');
                   })
                   .on('mouseout', '.ctrlsColumn .itemForm', function(){
                        if(!('mousedown' in $.fbuilder) || !$.fbuilder.mousedown)
                                $(this).removeClass('button-primary');
                   });

		// Create a items object
		var items = [],
            fieldsIndex = {},
            selected = -3;

		$.fbuilder[ 'editItem' ] = function( id )
			{
                selected = id;

                try
                {
                    $('#tabs-2').html( items[id].showAllSettings() );
                } catch (e) {}
				items[id].editItemEvents();
				setTimeout(function(){try{$('#tabs-2 .choicesSet select:visible, #tabs-2 .cf_dependence_field:visible, #tabs-2 #sSelectedField, #tabs-2 #sFieldList').chosen();}catch(e){}}, 50);
			};

		$.fbuilder[ 'removeItem' ] = function( index )
			{
				if( typeof items[ index ][ 'remove' ] != 'undefined' ) items[ index ][ 'remove' ]();
				items[ index ] = 0;
				selected = -2;
				$('#tabs').tabs("option", "active", 0);
			};

		$.fbuilder[ 'duplicateItem' ] = function( index, parentItem )
			{
				var n = 0, i, h, item, nIndex, duplicate = items[index];
				for ( i in fieldsIndex ) if( /fieldname/.test( i ) ) n = Math.max( parseInt( i.replace( /fieldname/g,"" ) ), n );

				item = $.extend( true, {}, duplicate, { name:"fieldname"+(n+1) } );
				if( typeof item[ 'fields' ] != 'undefined' && typeof item[ 'duplicateItem' ] != 'undefined') item[ 'fields' ] = [];
				if( typeof parentItem != 'undefined' ) item[ 'parent' ] = parentItem;
				else
				{
					/* Check if the parent is a container, and insert the new item as child of parent */
					if(
						duplicate[ 'parent' ] != '' &&
						typeof items[ fieldsIndex[ duplicate[ 'parent' ] ] ][ 'duplicateItem' ] != 'undefined'
					)
					items[ fieldsIndex[ duplicate[ 'parent' ] ] ][ 'duplicateItem' ]( duplicate.name, item['name'] );
				}

				// Insert the duplicated item just below the original
				nIndex = index*1+1;
				items.splice( nIndex, 0,  item);
				fieldsIndex[ item[ 'name' ] ] = nIndex;
				i = nIndex; h = items.length;
				for ( i; i<h; i++ ) // Correct the rest of indices
				{
					items[i].index = i;
					fieldsIndex[ items[i].name ] = i;
				}

				// The duplicated item is a container
				if( typeof item[ 'duplicateItem' ] != 'undefined' )
				{
					// Alert Message
					if( !$.fbuilder[ 'displayedDuplicateContainerMessage' ] )
					{
						alert( $.fbuilder[ 'duplicateContainerMessage' ] );
						$.fbuilder[ 'displayedDuplicateContainerMessage' ] = true;
					}

					i = 0; h = duplicate[ 'fields' ].length;
					for( i; i < h; i++ )
					{
						item[ 'fields' ][ i ] = $.fbuilder[ 'duplicateItem' ]( fieldsIndex[duplicate[ 'fields' ][ i ]], item[ 'name' ] );
					}
				}
				return item[ 'name' ];
			};

		$.fbuilder[ 'editForm' ] = function()
			{
				$('#tabs-3').html(theForm.showAllSettings());
				selected = -1;

				$("#fTitle").keyup(function()
				{
					theForm.title = $(this).val();
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fEvalEquations").click(function()
				{
					theForm.evalequations = ($(this).is( ':checked' )) ? 1 : 0;
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fAnimateForm").click(function()
				{
					theForm.animate_form = ($(this).is( ':checked' )) ? 1 : 0;
					$.fbuilder.reloadItems({'form':1});
				});

				$("[name='fEvalEquationsEvent']").change(function()
				{
					theForm.evalequationsevent = $("[name='fEvalEquationsEvent']:checked").val();
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fLoadingAnimation").click(function()
				{
					theForm.loading_animation = ($(this).is( ':checked' )) ? 1 : 0;
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fAutocomplete").click(function()
				{
					theForm.autocomplete = ($(this).is( ':checked' )) ? 1 : 0;
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fPersistence").click(function()
				{
					theForm.persistence = ($(this).is( ':checked' )) ? 1 : 0;
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fDescription").keyup(function()
				{
					theForm.description = $(this).val();
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fLayout").change(function()
				{
					theForm.formlayout = $(this).val();
					$.fbuilder.reloadItems();
				});

				$("#fTemplate").change(function()
				{
					theForm.formtemplate = $(this).val();
					var template 	= $.fbuilder.showSettings.formTemplateDic[ theForm.formtemplate ],
						thumbnail	= '',
						description = '';

					if( typeof template != 'undefined' )
					{
						if( typeof template[ 'thumbnail' ] != 'undefined' )
						{
							thumbnail = '<img src="' + template[ 'thumbnail' ] + '">';
						}
						if( typeof template[ 'description' ] != 'undefined' )
						{
							description = template[ 'description' ];
						}
					}
					$( '#fTemplateThumbnail' ).html( thumbnail );
					$( '#fTemplateDescription' ).html( description );
					$.fbuilder.reloadItems({'form':1});
				});

				$("#fCustomStyles").change(function()
				{
					theForm.customstyles = $(this).val();
					$.fbuilder.reloadItems({'form':1});
				});

				// CSS Editor
				if( 'codeEditor' in wp)
				{
					var cssEditorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {},
						editor;
					cssEditorSettings.codemirror = _.extend(
						{},
						cssEditorSettings.codemirror,
						{
							indentUnit: 2,
							tabSize: 2,
							mode: 'css'
						}
					);
					editor = wp.codeEditor.initialize( $('#fCustomStyles'), cssEditorSettings );
					editor.codemirror.on('change', function(cm){ $('#fCustomStyles').val(cm.getValue()).change();});

					$('.cff-editor-extend-shrink').on('click', function(){$(this).closest('.cff-editor-container').toggleClass('fullscreen');});
				}
			};

		$.fbuilder[ 'defineGeneralEvents' ] = function()
			{
				// Fields events
				$(document).on(
					{
						'click' : function(evt){
							$.fbuilder[ 'editItem' ]($(this).attr("id").replace("field-",""));
							$( '#fieldlist .ui-selected' ).removeClass("ui-selected");
							$(this).addClass("ui-selected");
							$('#tabs').tabs("option", "active", 1);
							evt.stopPropagation();
						},
						'mouseover' : function(evt){
							$(this).addClass("ui-over");
							evt.stopPropagation();
						},
						'mouseout' : function(evt){
							$(this).removeClass("ui-over");
							evt.stopPropagation();
						}
					},
					'.fields'
				);

				$(document).on('focus', '.field', function(){$(this).blur();});

				// Handle events
				$(document).on('click', '.fields .remove', function(evt){
					evt.stopPropagation();
					$.fbuilder[ 'removeItem' ]($(this).parent().attr("id").replace("field-",""));
					items = $.grep( items, function( e ){ return (e != 0 ); } );
					$.fbuilder.reloadItems();
				});

				$(document).on('click', '.fields .copy', function(evt){
					evt.stopPropagation();
					$.fbuilder[ 'duplicateItem' ]($(this).parent().attr("id").replace("field-",""));
					$('#tabs').tabs("option", "active", 0);
					$.fbuilder.reloadItems();
				});

				$(document).on('click', '.fields .collapse', function(evt){
					evt.stopPropagation();
					var f = $(this).closest('.fields'),
						i = f.attr("id").replace("field-",""),
						item = ffunct.getItems()[i];

					item['collapsed'] = true;
					f.addClass('collapsed');
					$.fbuilder.reloadItems({'field': item});
				});

				$(document).on('click', '.fields .uncollapse', function(evt){
					evt.stopPropagation();
					var f = $(this).closest('.fields'),
						i = f.attr("id").replace("field-",""),
						item = ffunct.getItems()[i];

					item['collapsed'] = false;
					f.removeClass('collapsed');
					$.fbuilder.reloadItems({'field': item});
				});

				// Title and subtitle section events
				$(document).on(
					{
						'mouseover' : function(){
							$(this).addClass("ui-over");
						},
						'mouseout' : function(){
							$(this).removeClass("ui-over");
						},
						'click' : function(evt){
							evt.stopPropagation();
							$('#tabs').tabs("option", "active", 2);
							$.fbuilder.editForm();
							$(this).siblings().removeClass("ui-selected");
							$(this).addClass("ui-selected");
						}
					},
					'.fform'
				);

				// Dashboard event
				$(document).on('click', '.expand-shrink', function(){
					$(this).toggleClass( 'ui-icon-triangle-1-e ui-icon-triangle-1-w' );
					$('.form-builder .ctrlsColumn').toggleClass( 'expanded' );
				});

				$(document).on('click', '#fbuilder', function(evt)
					{
						evt.stopPropagation();
						selected = -2;
						$(".fform").removeClass("ui-selected")
						$( '#fieldlist .ui-selected' ).removeClass("ui-selected");
						$('#tabs').tabs("option", "active", 0);
					}
				);
			};

		$.fbuilder[ 'reloadItems' ] = function( args )
			{
				function replaceFieldTags( field )
				{
					if( typeof field[ 'display' ] != 'undefined' )
					{
						var e  = $('.'+field['name']),
							n  = $(cff_sanitize(field.display())),
							as = true; // Call after_show

						if( n.find( '.dfield:eq(0)>.fcontainer>.fieldscontainer').length )
						{
							n.find( '.dfield:eq(0)>.fcontainer>.fieldscontainer')
							 .replaceWith( e.find( '.dfield:eq(0)>.fcontainer>.fieldscontainer' ) );
							as = false;
						}
						e.replaceWith(n);
						if( as && typeof field[ 'after_show' ] != 'undefined') field.after_show();
						$("#field-"+field.index).addClass("ui-selected");
					}
				} // End replaceFieldTags

				function replaceTitleDescTags()
				{
					$("#formheader").html(theForm.display());
				} // End replaceTitleDescTags

				var default_args = {
						'field' : {},
						'form'  : false
					};

				args = $.extend(true, {}, default_args, ( typeof args != 'undefined' ) ? args : {} );
				if( !$.isEmptyObject( args[ 'field' ] ) )
				{
					replaceFieldTags( args[ 'field' ] );
				}
				else if( args['form'] )
				{
					replaceTitleDescTags();
				}
				else
				{
					var	email_str = '', // email fields list
						cu_user_email_field = ($('#cu_user_email_field').attr("def") || '').split( ',' ),

						cost_str = '', // fields list for paypal request
						request_cost = $('#request_cost').attr("def"),

						recurrent_str = '', // fields list for recurrent payments
						paypal_recurrent_field = $('[name="paypal_recurrent_field"]').attr("def"),

						paypal_price_field = $('#paypal_price_field').attr("def"), // fields for times intervals in recurrent payments
						interval_fields_str = '<option value="" '+( ('' == paypal_price_field ) ? "selected" : "" )+'> ---- No ---- </option>';

					// Set the correct fields alignment class
					for ( var i=0, h = $.fbuilder.showSettings.formlayoutList.length; i < h; i++ )
					{
						$("#fieldlist").removeClass( $.fbuilder.showSettings.formlayoutList[i].id );
					}
					$("#fieldlist").addClass(theForm.formlayout);

					replaceTitleDescTags();
					$("#fieldlist").html("");
					fieldsIndex = {};
					for ( var i=0, h = items.length; i < h; i++ )
					{
						var item = items[i];

						item.index = i;
						item.parent = '';
						fieldsIndex[ item.name ] = i;

                        $("#fieldlist").append(cff_sanitize(item.display()));
						if ( i == selected )
						{
							$("#field-"+i).addClass("ui-selected");
							if( $('#tabs').tabs("option", "active") != 1 )
							{
								$.fbuilder[ 'editItem' ]( i );
							}
						}
						else
						{
							$("#field-"+i).removeClass("ui-selected");
						}

						// Email fields
						if (item.ftype=="femail" || item.ftype=="femailds")
						{
                            email_str += '<option value="'+cff_esc_attr(item.name)+'" '+( ( $.inArray( item.name, cu_user_email_field ) != -1 ) ? "selected" : "" )+'>'+cff_esc_attr(item.name+' ('+cff_sanitize(item.title)+')')+'</option>';
						}
						else
						{
							// Request cost fields
                            if(!/(femail)|(fdate)|(ffile)|(fpassword)|(fphone)|(fsectionbreak)|(fpagebreak)|(fsummary)|(fcontainer)|(ffieldset)|(fdiv)|(fmedia)|(fbutton)|(fhtml)|(frecordsetds)|(fcommentarea)/i.test(item.ftype))
							{
                                cost_str += '<option value="'+cff_esc_attr(item.name)+'" '+( ( item.name == request_cost ) ? "selected" : "" )+'>'+cff_esc_attr(item.name+'('+cff_sanitize(item.title)+')')+'</option>'
							}

							// Recurrent Payments
                            if (item.ftype=="fradio" || item.ftype=="fdropdown" || item.ftype=="fCalculated")
							{
                                recurrent_str += '<option value="'+cff_esc_attr(item.name)+'" '+( ( item.name == paypal_recurrent_field ) ? "selected" : "" )+'>'+cff_esc_attr(item.name+' ('+cff_sanitize(item.title)+')')+'</option>';
							}

							// Times Intervals
                            interval_fields_str += '<option value="'+cff_esc_attr(item.name)+'" '+( ( item.name == paypal_price_field ) ? "selected" : "" )+'>'+cff_esc_attr(cff_sanitize(item.title))+'</option>';
						}
					}

					// Assign the email fields to the "cu_user_email_field" list
					$('#cu_user_email_field').html(email_str);

					// Assign the fields to the "request_cost" list
					$('#request_cost').html(cost_str);

					// Assign the fields to the "paypal_recurrent_field" list
					$('[name="paypal_recurrent_field"]').html(recurrent_str);

					// Assign the fields to the "paypal_price_field" list
					$('#paypal_price_field').html(interval_fields_str);

					for ( var i=0, h = items.length; i < h; i++ )
					{
						if( typeof items[ i ].after_show != 'undefined' ) items[ i ].after_show();
					}
				}

				ffunct.saveData("form_structure");
                $(document).trigger('cff_reloadItems', items);
			};

		var fform=function(){};
		$.extend(fform.prototype,
			{
				title:"Untitled Form",
				description:"This is my form. Please fill it out. It's awesome!",
				formlayout:"top_aligned",
				formtemplate:$.fbuilder.default_template,
                evalequations:1,
                evalequationsevent:2,
                loading_animation:0,
                autocomplete:1,
				persistence:0,
                animate_form:0,
				customstyles:"",
				display:function()
				{
					return cff_sanitize('<div class="fform" id="field"><div class="arrow ui-icon ui-icon-play "></div><h2>'+this.title+'</h2><span>'+this.description+'</span></div>');
				},

				showAllSettings:function()
				{
					var layout 	    = '',
						template    = '<option value="">Use default template</option>',
						thumbnail   = '',
						description = '',
						selected    = '',
						str 		= '';

					for ( var i = 0; i< $.fbuilder.showSettings.formlayoutList.length; i++ )
					{
						layout += '<option value="'+cff_esc_attr($.fbuilder.showSettings.formlayoutList[i].id)+'" '+(($.fbuilder.showSettings.formlayoutList[i].id==this.formlayout)?"selected":"")+'>'+cff_esc_attr($.fbuilder.showSettings.formlayoutList[i].name)+'</option>';
					}

					for ( var i in $.fbuilder.showSettings.formTemplateDic )
					{
						if( /^\s*$/.test( i ) ) break;
						selected = '';
						if( $.fbuilder.showSettings.formTemplateDic[i].prefix==this.formtemplate )
						{
							selected = 'SELECTED';
							if( typeof $.fbuilder.showSettings.formTemplateDic[i].thumbnail != 'undefined' )
							{
								thumbnail = '<img src="'+$.fbuilder.showSettings.formTemplateDic[i].thumbnail+'">';
							}

							if( typeof $.fbuilder.showSettings.formTemplateDic[i].description != 'undefined' )
							{
								description = $.fbuilder.showSettings.formTemplateDic[i].description;
							}
						}

						template += '<option value="'+cff_esc_attr($.fbuilder.showSettings.formTemplateDic[i].prefix)+'" ' + selected + '>'+cff_esc_attr($.fbuilder.showSettings.formTemplateDic[i].title)+'</option>';
					}

					str += '<div><label>Form Name</label><input type="text" class="large" name="fTitle" id="fTitle" value="'+cff_esc_attr(this.title)+'" /></div><div><label>Description</label><textarea class="large" name="fDescription" id="fDescription">'+cff_esc_attr(this.description)+'</textarea></div><div><label>Label Placement</label><select name="fLayout" id="fLayout" class="large">'+layout+'</select></div><div><label><input type="checkbox" name="fLoadingAnimation" id="fLoadingAnimation" '+( ( this.loading_animation ) ? 'CHECKED' : '' )+' /> Display loading form animation</label></div><div><label><input type="checkbox" name="fAutocomplete" id="fAutocomplete" '+( ( this.autocomplete ) ? 'CHECKED' : '' )+' /> Enable autocompletion</label></div><div><label><input type="checkbox" name="fPersistence" id="fPersistence" '+( ( this.persistence ) ? 'CHECKED' : '' )+' /> Enable the browser\'s persistence (the data are stored locally on browser)</label></div>';

					if(typeof $.fbuilder.controls[ 'fCalculated' ] != 'undefined')
					{
						str += '<div><label><input type="checkbox" name="fEvalEquations" id="fEvalEquations" '+( ( this.evalequations ) ? 'CHECKED' : '' )+' /> Dynamically evaluate the equations associated with the calculated fields</label></div>';

						str += '<div class="groupBox"><label><input type="radio" name="fEvalEquationsEvent" name="fEvalEquationsEvent" value="1" '+( ( this.evalequationsevent == 1 ) ? 'CHECKED' : '' )+' /> Eval the equations in the onchange events</label><label><input type="radio" name="fEvalEquationsEvent" name="fEvalEquationsEvent" value="2" '+( ( 'undefined' == typeof this.evalequationsevent || this.evalequationsevent == 2 ) ? 'CHECKED' : '' )+' /> Eval the equations in the onchange and keyup events</label></div>';
					}

					str += '<div><label>Form Template</label><select name="fTemplate" id="fTemplate" class="large">'+template+'</select></div><div style="text-align:center;padding:10px 0;"><span id="fTemplateThumbnail">'+thumbnail+'</span><div></div><span  id="fTemplateDescription">'+description+'</span></div>'+
                    '<div><label><input type="checkbox" name="fAnimateForm" id="fAnimateForm" '+( ( this.animate_form ) ? 'CHECKED' : '' )+' /> Animate page breaks in multipage forms, and dependencies</label></div>'+
                    '<div class="cff-editor-container"><label><div class="cff-editor-extend-shrink"></div>Customize Form Design <i>(Enter the CSS rules. <a href="http://cff.dwbooster.com/faq#q82" target="_blank">More information</a>)</i></label><textarea id="fCustomStyles" style="width:100%;height:150px;">'+cff_esc_attr(this.customstyles)+'</textarea></div>' ;

					return str;
				}
			}
		);

		var theForm = new fform();
		$("#fieldlist").sortable(
			{
				'connectWith': '.ui-sortable',
				'items': '.fields',
				'placeholder': 'ui-state-highlight',
				'tolerance': 'pointer',
				'update': function( event, ui )
				{
                    var index = ui.item.index('#fieldlist>div');
                    if(0<=index)
                    {
                        if(ui.item.hasClass('cff-button-drag')) // It is  an new control
                        {
                            ui.item = $('.'+window['cff_form'].fBuild.addItem(ui.item.data('control'), -3).name);
                        }
                        var i, h = items.length;
                        for( i = 0; i < h; i++ )
                        {
                            if( ui.item.hasClass(items[i].name)) break;
                        }

                        if( index )
                        {
                            var prev = $('#fieldlist>div:eq('+(index-1)+')');
                            for( var j = 0; j < h; j++ )
                            {
                                if( prev.hasClass(items[j].name) )
                                {
                                    index = (i<=j) ? j : ++j;
                                    break;
                                }
                            }
                        }

                        items.splice( index, 0,  items.splice( i, 1 )[ 0 ] );
                        $.fbuilder.reloadItems();
                        $('.'+/((fieldname)|(separator))\d+/.exec(ui.item.attr('class'))[0]).click();
                    }
                    else
                    {
                        // remove
                        try
                        {
                            var i, h = items.length;
                            for( i = 0; i < h; i++ ) if( ui.item.hasClass(items[i].name)) break;
                            items = items.concat( items.splice( i, 1 ) );
                        }
                        catch(err){}
                    }
				}
			}
		);

		$('#tabs').tabs(
			{
				activate: function(event, ui)
					{
						switch( $(this).tabs( "option", "active" ) )
						{
							case 0:
								$(".fform").removeClass("ui-selected");
							break;
							case 1:
								$(".fform").removeClass("ui-selected");
								if (selected < 0)
								{
								   $('#tabs-2').html('<b>No Field Selected</b><br />Please click on a field in the form preview on the right to change its properties.');
								}
							break;
							case 2:
								$(".fields").removeClass("ui-selected");
								$(".fform").addClass("ui-selected");
								$.fbuilder.editForm();
							break;
						}
					}
			}
		);

	    var ffunct = {
	        getFieldsIndex: function()
			{
			   return fieldsIndex;
		    },
		    getItems: function()
			{
			   return items;
		    },
		    addItem: function(id, _selected)
			{
			    var obj = new $.fbuilder.controls[id](),
					fBuild = this,
					n = 0;

                selected = _selected || selected;

                obj.init();
				for ( var i in fieldsIndex ) if( /fieldname/.test( i ) ) n = Math.max( parseInt( i.replace( /fieldname/g,"" ) ), n );
			    n++;

				obj.fBuild = fBuild;
			    $.extend(obj,{name:"fieldname"+n});

                if( selected >= 0 )
                {
					n =  (selected)*1+1;
                    items.splice( n, 0, obj );
					fieldsIndex[obj.name] = n;
					for(var i = n, h = items.length; i<h; i++) fieldsIndex[items[i].name] = i;

					if( id != 'fPageBreak' )
					{
						if( typeof items[ selected ][ 'addItem' ] != 'undefined' )
						{
							obj.name[ 'parent' ] = items[ selected ][ 'name' ];
							items[ selected ][ 'addItem' ]( obj.name );
						}
						else
						{
							// get the parent
							if( items[ selected ][ 'parent' ] !== '' )
							{
								items[ fieldsIndex[ items[ selected ][ 'parent' ] ] ][ 'addItem' ]( obj.name, items[ selected ][ 'name' ]);
							}

							selected++;
						}
					}
					else
					{
						selected++;
					}
                }
                else
                {
                    selected = items.length;
                    items[selected] = obj;
                }
				$.fbuilder.reloadItems();
				return obj;
		    },
		    saveData:function(f)
			{
				try{
					var itemsStringified   = $.stringifyXX( items ),
						theFormStringified = $.stringifyXX( theForm ),
						errorTxt = 'The entered data includes invalid characters. Please, if you are copying and pasting from another platform, be sure the data not include invalid characters.',
						str;

					if( typeof global_varible_save_data != 'undefined' )
					{
						// If the global_varible_save_data exists clear the form-builder-error-messages
						$( '.form-builder-error-messages' ).html( '' );
					}
					else
					{
						setTimeout(function(){ global_varible_save_data = true; }, 1000);
					}

					try{
						if( $.parseJSON( itemsStringified ) != null && $.parseJSON( theFormStringified ) != null )
						{
							str = "["+ itemsStringified +",["+ theFormStringified +"]]";
							$( "#"+f ).val( str );
						}
						else
						{
							$.fbuilder[ 'showErrorMssg' ]( errorTxt );
						}
					}
					catch( err )
					{
						$.fbuilder[ 'showErrorMssg' ]( errorTxt );
					}
				}catch( err ){}
		    },
		    loadData:function(form_structure, available_templates)
			{
				var structure,
					templates = null,
					fBuild = this;

				try{
					structure =  $.parseJSON( $("#"+form_structure).val() );
				}
				catch(err)
				{
					structure = [];
					if(typeof console != 'undefined') console.log(err);
				}

			    try{
					 if( typeof available_templates != 'undefined' ) templates = $.parseJSON( $("#"+available_templates).val() );
				}
				catch(err)
				{
					templates = null;
					if(typeof console != 'undefined') console.log(err);
				}

			    if ( structure )
				{
					$.fbuilder.defineGeneralEvents();
					if (structure.length==2)
					{
						items = [];
						for (var i=0;i<structure[0].length;i++)
						{
						   var obj = new $.fbuilder.controls[structure[0][i].ftype]();
						   obj = $.extend( true, {}, obj, structure[0][i] );
						   obj.fBuild = fBuild;
						   items[items.length] = obj;
						}
						theForm = new fform();
						theForm = $.extend(theForm,structure[1][0]);
						$.fbuilder.reloadItems();
					}
				}

				if( templates )
				{
					$.fbuilder.showSettings.formTemplateDic = templates;
				}
		    },
		    removeItem: $.fbuilder[ 'removeItem' ],
		    editItem:   $.fbuilder[ 'editItem' ]
	    }

	    this.fBuild = ffunct;
	    return this;
	};

    $.fbuilder[ 'showSettings' ] = {
		sizeList:new Array({id:"small",name:"Small"},{id:"medium",name:"Medium"},{id:"large",name:"Large"}),
		layoutList:new Array({id:"one_column",name:"One Column"},{id:"two_column",name:"Two Column"},{id:"three_column",name:"Three Column"},{id:"side_by_side",name:"Side by Side"}),
		formlayoutList:new Array({id:"top_aligned",name:"Top Aligned"},{id:"left_aligned",name:"Left Aligned"},{id:"right_aligned",name:"Right Aligned"}),
		formTemplateDic: {}, // Form Template dictionary
        showFieldType: function( v )
        {
            return '<label><b>Field Type: '+$.fbuilder[ 'getNameByIdFromType' ]( v )+'</b></label>';
        },
		showTitle: function(v)
		{
			return '<label>Field Label</label><textarea class="large" name="sTitle" id="sTitle">'+cff_esc_attr(v)+'</textarea>';
		},
		showShortLabel: function( v )
		{
			return '<div><label>Short label (optional) [<a class="helpfbuilder" text="The short label is used at title for the column when exporting the form data to CSV files.\n\nIf the short label is empty then, the field label will be used for the CSV file.">help?</a>] :</label><input type="text" class="large" name="sShortlabel" id="sShortlabel" value="'+cff_esc_attr(v)+'" /></div>';
		},
		showName: function( v )
		{
			return '<div><label>Field name, tag for the message:</label><input type="text" readonly="readonly" class="large" name="sNametag" id="sNametag" value="&lt;%'+cff_esc_attr(v)+'%&gt;" />'+
				   '<input style="display:none" readonly="readonly" class="large" name="sName" id="sName" value="'+cff_esc_attr(v)+'" /></div>';
		},
		showPredefined: function(v,c)
		{
			return '<div><label>Predefined Value</label><textarea class="large" name="sPredefined" id="sPredefined">'+cff_esc_attr(v)+'</textarea><br /><i>It is possible to use another field in the form as predefined value. Ex: fieldname1</i><label><input type="checkbox" name="sPredefinedClick" id="sPredefinedClick" '+((c)?"checked":"")+' value="1" > Use predefined value as placeholder.</label></div>';
		},
		showEqualTo: function(v,name)
		{
			return '<div><label>Equal to [<a class="helpfbuilder" text="Use this field to create password confirmation field or email confirmation fields.\n\nSpecify this setting ONLY into the confirmation field, not in the original field.">help?</a>]</label><select class="equalTo" name="sEqualTo" id="sEqualTo" dvalue="'+cff_esc_attr(v)+'" dname="'+cff_esc_attr(name)+'"></select></div>';
		},
		showAutocomplete: function(v)
		{
            var options = '', values = ['off', 'on', 'name', 'honorific-prefix', 'given-name', 'additional-name', 'family-name', 'honorific-suffix', 'nickname', 'email', 'username', 'new-password', 'current-password', 'one-time-code', 'organization-title', 'organization', 'street-address', 'address-line1', 'address-line2', 'address-line3', 'address-level4', 'address-level3', 'address-level2', 'address-level1', 'country', 'country-name', 'postal-code', 'cc-name', 'cc-given-name', 'cc-additional-name', 'cc-family-name', 'cc-number', 'cc-exp', 'cc-exp-month', 'cc-exp-year', 'cc-csc', 'cc-type', 'transaction-currency', 'transaction-amount', 'language', 'bday', 'bday-day', 'bday-month', 'bday-year', 'sex', 'tel', 'tel-country-code', 'tel-national', 'tel-area-code', 'tel-local', 'tel-extension', 'impp', 'url', 'photo'];

            for(var i = 0, h = values.length; i<h; i++)
            {
                options += '<option value="'+cff_esc_attr(values[i])+'" '+(values[i] == v ? 'SELECTED' : '')+'>'+cff_esc_attr(values[i])+'</option>';
            }
			return '<div><label>Autocomplete</label>'+
            '<select class="large" name="sAutocomplete" id="sAutocomplete">'+options+'</select><br><i>The field attribute takes precedence over the form settings.</i></div>';
		},
		showRequired: function(v)
		{
			return '<label><input type="checkbox" name="sRequired" id="sRequired" '+((v)?"checked":"")+'>Required</label>';
		},
		showExclude: function(v)
		{
			return '<label><input type="checkbox" name="sExclude" id="sExclude" '+((v)?"checked":"")+'>Exclude from submission</label>';
		},
		showSelect2: function(v)
		{
			return '<label><input type="checkbox" name="sSelect2" id="sSelect2" '+((v)?"checked":"")+'>Apply Select2 library (Experimental)</label>';
		},
		showReadonly: function(v)
		{
			return '<label><input type="checkbox" name="sReadonly" id="sReadonly" '+((v)?"checked":"")+'>Read Only</label>';
		},
		showNumberpad: function(v)
		{
			return '<label><input type="checkbox" name="sNumberpad" id="sNumberpad" '+((v)?"checked":"")+'>Forcing numberpad on mobiles</label>';
		},
		showSize: function(v)
		{
			var str = "";
			for (var i=0;i<this.sizeList.length;i++)
			{
				str += '<option value="'+cff_esc_attr(this.sizeList[i].id)+'" '+((this.sizeList[i].id==v)?"selected":"")+'>'+cff_esc_attr(this.sizeList[i].name)+'</option>';
			}
			return '<label>Field Size</label><select name="sSize" id="sSize">'+str+'</select>';
		},
		showLayout: function(v)
		{
			var str = "";
			for (var i=0;i<this.layoutList.length;i++)
			{
				str += '<option value="'+cff_esc_attr(this.layoutList[i].id)+'" '+((this.layoutList[i].id==v)?"selected":"")+'>'+cff_esc_attr(this.layoutList[i].name)+'</option>';
			}
			return '<label>Field Layout</label><select name="sLayout" id="sLayout">'+str+'</select>';
		},
		showUserhelp: function(v,a,c,i)
		{
			return '<hr>'+
			'<label>Instructions for User</label><textarea class="large" name="sUserhelp" id="sUserhelp">'+cff_esc_attr(v)+'</textarea><label class="column"><input type="checkbox" name="sUserhelpTooltip" id="sUserhelpTooltip" '+((c)?"checked":"")+' value="1" > Show as floating tooltip&nbsp;&nbsp;</label><label class="column"><input type="checkbox" name="sTooltipIcon" id="sTooltipIcon" '+((i)?"checked":"")+' value="1" > Display on icon</label><div class="clearer"></div>'+
			'<label>Audio Tutorial</label>'+
			'<div><input type="text" style="width:70%;" name="sAudioSrc" id="sAudioSrc" value="'+cff_esc_attr(a)+'"><input id="sSelectAudioBtn" type="button" value="Browse" style="width:28%;" /></div>'+
			'<hr>';
		},
		showCsslayout: function(v)
		{
			return '<div><label>Add Css Layout Keywords</label><input type="text" class="large" name="sCsslayout" id="sCsslayout" value="'+cff_esc_attr(v)+'" /></div>';
		}
	};

	$.fbuilder.controls[ 'ffields' ] = function(){};
	$.extend( $.fbuilder.controls[ 'ffields' ].prototype,
		{
			form_identifier:"",
			name:"",
			shortlabel:"",
			index:-1,
			ftype:"",
			userhelp:"",
			audiotutorial:"",
			userhelpTooltip:false,
			tooltipIcon:false,
			csslayout:"",
			init:function(){},
			editItemEvents:function( e )
			{
				if( typeof e != 'undefined' && typeof e.length != 'undefined' )
				{
					for( var i = 0, h = e.length; i<h; i++ )
					{
						/**
						* s -> selector
						* e -> event name
						* l -> element
						* f -> function to apply the value
                        * x -> escape
						*/
						$(e[i].s).bind(e[i].e, {obj:this, i:e[i]}, function(e){
							var v = $(this).val();
							if(typeof e.data.i['f'] != 'undefined') v = e.data.i.f($(this));
							e.data.obj[e.data.i.l] = ('x' in e.data.i && e.data.i.x) ? cff_esc_attr(v) : v;
							$.fbuilder.reloadItems( {'field': e.data.obj} );
						});
					}
				}

				$("#sTitle").bind("keyup", {obj: this}, function(e)
					{
						var str = $(this).val();
						e.data.obj.title = str.replace(/\n/g,"<br />");
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sShortlabel").bind("keyup", {obj: this}, function(e)
					{
						e.data.obj.shortlabel = $(this).val();
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sReadonly").bind("click", {obj: this}, function(e)
					{
						e.data.obj.readonly = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sNumberpad").bind("click", {obj: this}, function(e)
					{
						e.data.obj.numberpad = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sAutocomplete").bind("change", {obj: this}, function(e)
					{
						e.data.obj.autocomplete = $(this).val();
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sPredefined").bind("keyup", {obj: this}, function(e)
					{
						e.data.obj.predefined = $(this).val();
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sPredefinedClick").bind("click", {obj: this}, function(e)
					{
						e.data.obj.predefinedClick = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sRequired").bind("click", {obj: this}, function(e)
					{
						e.data.obj.required = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sExclude").bind("click", {obj: this}, function(e)
					{
						e.data.obj.exclude = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sUserhelp").bind("keyup", {obj: this}, function(e)
					{
						e.data.obj.userhelp = $(this).val();
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sUserhelpTooltip").bind("click", {obj: this}, function(e)
					{
						e.data.obj.userhelpTooltip = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sTooltipIcon").bind("click", {obj: this}, function(e)
					{
						e.data.obj.tooltipIcon = $(this).is(':checked');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sAudioSrc").bind("keyup change", {obj: this}, function(e)
					{
						e.data.obj.audiotutorial = $(this).val();
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

				$("#sSelectAudioBtn").bind("click", {obj: this}, function(e)
					{
						var media = wp.media({
									title: 'Select Source',
									button: {
										text: 'Select Source'
									},
									multiple: false
							}).on('select',
								function() {
									var regExp = new RegExp( 'audio', 'i'),
										attachment = media.state().get('selection').first().toJSON();
									if( !regExp.test( attachment.mime ) )
									{
										alert( 'Invalid mime type' );
										return;
									}
									$( '#sAudioSrc' ).val( attachment.url ).change();
								}
							).open();
						return false;
					});

				$("#sCsslayout").bind("keyup", {obj: this}, function(e)
					{
						e.data.obj.csslayout = $(this).val().replace(/\,/g, ' ').replace(/\s+/g, ' ');
						$.fbuilder.reloadItems( {'field': e.data.obj} );
					});

                $(".helpfbuilder").unbind('click');
				$(".helpfbuilder").bind('click', function()
					{
						alert($(this).attr("text"));
					});
			},

			showSpecialData:function()
			{
				if(typeof this.showSpecialDataInstance != 'undefined')
				{
					return this.showSpecialDataInstance();
				}
				else
				{
					return "";
				}
			},

			showEqualTo:function()
			{
				if(typeof this.equalTo != 'undefined')
				{
					return $.fbuilder.showSettings.showEqualTo(this.equalTo,this.name);
				}
				else
				{
					return "";
				}
			},

			showPredefined:function()
			{
				if(typeof this.predefined != 'undefined')
				{
					return $.fbuilder.showSettings.showPredefined(this.predefined,this.predefinedClick);
				}
				else
				{
					return "";
				}
			},
			/** Modified for showing required and readonly attributes **/
			showRequired:function()
			{
				var result = '';
                if(typeof this.autocomplete != 'undefined') result += $.fbuilder.showSettings.showAutocomplete(this.autocomplete);
				if(typeof this.required != 'undefined') result += $.fbuilder.showSettings.showRequired(this.required);
				if(typeof this.exclude != 'undefined')  result += $.fbuilder.showSettings.showExclude(this.exclude);
				if(typeof this.select2 != 'undefined')  result += $.fbuilder.showSettings.showSelect2(this.select2);
				if(typeof this.readonly != 'undefined') result += $.fbuilder.showSettings.showReadonly(this.readonly);
				if(typeof this.numberpad != 'undefined') result += $.fbuilder.showSettings.showNumberpad(this.numberpad);
				return result;
			},

			showSize:function()
			{
				if(typeof this.size != 'undefined')
				{
					return $.fbuilder.showSettings.showSize(this.size);
				}
				else
				{
					return "";
				}
			},

			showLayout:function()
			{
				if(typeof this.layout != 'undefined')
				{
					return $.fbuilder.showSettings.showLayout(this.layout);
				}
				else
				{
					return "";
				}
			},

			showRange:function()
			{
				if(typeof this.min != 'undefined')
				{
					return this.showRangeIntance();
				}
				else
				{
					return "";
				}
			},

			showFormat:function()
			{
				if(typeof this.dformat != 'undefined')
				{
					try
					{
						return this.showFormatIntance();
					} catch(e) {return "";}
				}
				else
				{
					return "";
				}
			},

			showChoice:function()
			{
				if(typeof this.choices != 'undefined')
				{
					return this.showChoiceIntance();
				}
				else
				{
					return "";
				}
			},

			showUserhelp:function()
			{
				return $.fbuilder.showSettings.showUserhelp(this.userhelp,this.audiotutorial,this.userhelpTooltip,this.tooltipIcon);
			},

			showCsslayout:function()
			{
				return $.fbuilder.showSettings.showCsslayout(this.csslayout);
			},

			showAllSettings:function()
			{
				return this.showFieldType()+this.showTitle()+this.showShortLabel()+this.showName()+this.showSize()+this.showLayout()+this.showFormat()+this.showRange()+this.showRequired()+this.showSpecialData()+this.showEqualTo()+this.showPredefined()+this.showChoice()+this.showUserhelp()+this.showCsslayout();
			},

			showFieldType:function()
			{
				return $.fbuilder.showSettings.showFieldType(this.ftype);
			},

			showTitle:function()
			{
				return $.fbuilder.showSettings.showTitle(this.title);
			},

			showName:function()
			{
				return $.fbuilder.showSettings.showName(this.name);
			},

			showShortLabel:function()
			{
				return $.fbuilder.showSettings.showShortLabel(this.shortlabel);
			},

			display:function()
			{
				return 'Not available yet';
			},

			show:function()
			{
				return 'Not available yet';
			}
		}
	);

	$( '.cff-metabox .hndle' ).on( 'click', function(){
		var e = $( this ).closest('.cff-metabox');
		e.toggleClass( 'cff-metabox-opened cff-metabox-closed' );
		$.post(
			'admin.php?page=cp_calculated_fields_form',
			{
				'cff-metabox-id' : e.attr('id'),
				'cff-metabox-action' : e.hasClass( 'cff-metabox-opened' ) ? 'open' : 'close',
				'cff-metabox-nonce'  : cff_metabox_nonce || 0
			}
		);
	} );