// Fire Department Options scripts

jQuery(document).ready(function(){
    "use strict";

    ANCORA_GLOBALS['to_media_frame'] = [];

    // Init fields and groups
    //----------------------------------------------------------------
    ancora_options_init(jQuery('.ancora_options_body'));

    // Check top section for fixed position
    //----------------------------------------------------------------
    ancora_options_fix_scroll_menu();

    // Override menu
    //----------------------------------------------------------------
    jQuery('.ancora_options').on('click', '.ancora_options_override_title', function (e) {
        jQuery(this).toggleClass('opened').parents('.ancora_options_title').find('.ancora_options_override_menu').slideToggle();
        e.preventDefault();
        return false;
    });

    // Save options
    //----------------------------------------------------------------
    jQuery('.ancora_options').on('click', '.ancora_options_button_save', function (e) {
        "use strict";
        // Save editors content
        if (typeof(tinymce) != 'undefined') {
            var editor = tinymce.activeEditor;
            if ( editor!=null && 'mce_fullscreen' == editor.id )
                tinymce.get('content').setContent(editor.getContent({format : 'raw'}), {format : 'raw'});
            tinymce.triggerSave();
        }
        // Prepare data
        var data = {
            action: 'ancora_options_save',
            nonce: ANCORA_GLOBALS['ajax_nonce'],
            data: jQuery(".ancora_options_form").serialize(),
            override: ANCORA_GLOBALS['to_override'],
            slug: ANCORA_GLOBALS['to_slug'],
            mode: "save"
        };
        jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
            "use strict";
            ancora_message_success('', ANCORA_GLOBALS['to_strings']['save_options']);
        });
        e.preventDefault();
        return false;
    });


    // Reset options
    //----------------------------------------------------------------
    jQuery('.ancora_options').on('click', '.ancora_options_button_reset', function (e) {
        "use strict";
        ancora_message_confirm(ANCORA_GLOBALS['to_strings']['reset_options_confirm'], ANCORA_GLOBALS['to_strings']['reset_options'], function(btn) {
            "use strict";
            if (btn != 1) return;
            var data = {
                action: 'ancora_options_save',
                nonce: ANCORA_GLOBALS['ajax_nonce'],
                override: ANCORA_GLOBALS['to_override'],
                slug: ANCORA_GLOBALS['to_slug'],
                mode: "reset"
            };
            setTimeout(function(){
                ancora_message_info(ANCORA_GLOBALS['to_override']=='customizer' ? ANCORA_GLOBALS['to_strings']['recompile_styles'] : '', ANCORA_GLOBALS['to_strings']['wait'], 'spin3 animate-spin', 60000);
            }, 600);
            jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
                "use strict";
                ancora_message_success(ANCORA_GLOBALS['to_strings']['reset_options_complete']+'<br>'+ANCORA_GLOBALS['to_strings']['reload_page'], ANCORA_GLOBALS['to_strings']['reset_options']);
                setTimeout(function() { location.reload(); }, 3000);
            });

        });
        e.preventDefault();
        return false;
    });


    // Export options
    //----------------------------------------------------------------
    jQuery('.ancora_options').on('click', '.ancora_options_button_export,.ancora_options_button_import', function (e) {
        "use strict";
        var action = 'import';
        if (jQuery(this).hasClass('ancora_options_button_export')) {
            action = 'export';
            // Save editors content
            if (typeof(tinymce) != 'undefined') {
                var editor = tinymce.activeEditor;
                if ( editor!=null && 'mce_fullscreen' == editor.id )
                    tinymce.get('content').setContent(editor.getContent({format : 'raw'}), {format : 'raw'});
                tinymce.triggerSave();
            }
        }
        // Prepare dialog
        var html = '<div class="ancora_options_export_set_name">'
            +'<form>'
            +(action=='import'
                ? ''
                : '<div class="ancora_options_export_name_area">'
            +'<label for="ancora_options_export_name">'+ANCORA_GLOBALS['to_strings']['export_options_label']+'</label>'
            +'<input id="ancora_options_export_name" name="ancora_options_export_name" class="ancora_options_export_name" type="text">'
            +'</div>');
        var export_list = ANCORA_GLOBALS['to_export_list'];
        if (export_list.length > 0) {
            html += '<div class="ancora_options_export_name2_area">'
            +'<label for="ancora_options_export_name2">'+(action=='import' ? ANCORA_GLOBALS['to_strings']['export_options_label'] : ANCORA_GLOBALS['to_strings']['export_options_label2'])+'</label>'
            +'<select id="ancora_options_export_name2" name="ancora_options_export_name2" class="ancora_options_export_name2">'
            +'<option value="">'+ANCORA_GLOBALS['to_strings']['export_options_select']+'</option>';
            for (var i=0; i<export_list.length; i++) {
                html += '<option value="'+export_list[i]+'">'+export_list[i]+'</option>';
            }
            html += '</select>'
            +'</div>';
        } else if (action=='import') {
            html += '<div class="ancora_options_export_empty">'+ANCORA_GLOBALS['to_strings']['export_empty']+'</div>';
        }
        if (action=='import') {
            html += '<div class="ancora_options_export_textarea">'
            +'<label for="ancora_options_export_data">'+ANCORA_GLOBALS['to_strings']['import_options_label']+'</label>'
            +'<textarea id="ancora_options_export_data" name="ancora_options_export_data" class="ancora_options_export_data"></textarea>'
            +'</div>';
        }
        html += '</form>'
        +'</div>';

        // Show Dialog popup
        var export_popup = ancora_message_dialog(html, action=='import' ? ANCORA_GLOBALS['to_strings']['import_options_header'] : ANCORA_GLOBALS['to_strings']['export_options_header'],
            function(popup) {
                "use strict";
                // Init code
            },
            function(btn, popup) {
                "use strict";
                if (btn != 1) return;

                var val2 = export_popup.find('#ancora_options_export_name2').val();

                if (action=='import') {			// Import settings

                    var text = export_popup.find('#ancora_options_export_data').val();

                    if (val2=='' && text=='') {
                        ancora_message_warning(ANCORA_GLOBALS['to_strings']['import_options_error'], ANCORA_GLOBALS['to_strings']['import_options_header']);
                        return;
                    }

                    var data = {
                        action: 'ancora_options_import',
                        nonce: ANCORA_GLOBALS['ajax_nonce'],
                        name2: val2,
                        text: text,
                        override: ANCORA_GLOBALS['to_override'],
                        slug: ANCORA_GLOBALS['to_slug']
                    };
                    jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
                        "use strict";
                        var rez = {};
                        try {
                            rez = JSON.parse(response);
                        } catch (e) {
                            rez = { error: ANCORA_GLOBALS['ajax_error'] };
                            console.log(response);
                        }
                        if (rez.error === '') {
                            ancora_options_import_values(rez.data);
                            ancora_message_success(ANCORA_GLOBALS['to_strings']['import_options'], ANCORA_GLOBALS['to_strings']['import_options_header']);
                        } else {
                            ancora_message_warning(ANCORA_GLOBALS['to_strings']['import_options_failed'], ANCORA_GLOBALS['to_strings']['import_options_header']);
                        }
                    });


                } else {						// Export settings

                    var val = export_popup.find('#ancora_options_export_name').val();
                    if (val=='' && val2=='') {
                        ancora_message_warning(ANCORA_GLOBALS['to_strings']['export_options_error'], ANCORA_GLOBALS['to_strings']['export_options_header']);
                        return;
                    }
                    // Prepare data
                    var form = null;
                    if (jQuery("form.ancora_options_form").length === 1) {		// Main theme options
                        form = jQuery("form.ancora_options_form");
                    } else if (jQuery("form#addtag").length === 1 ) {				// Options for the category (add new)
                        form = jQuery("form#addtag");
                    } else if (jQuery("form#edittag").length === 1 ) {				// Options for the category (edit)
                        form = jQuery("form#edittag");
                    } else if (jQuery("form#post").length === 1 ) {					// Options for the post or page
                        form = jQuery("form#post");
                    }
                    var data = {
                        action: 'ancora_options_save',
                        nonce: ANCORA_GLOBALS['ajax_nonce'],
                        data: form.serialize(),
                        name: val,
                        name2: val2,
                        mode: 'export',
                        override: ANCORA_GLOBALS['to_override'],
                        slug: ANCORA_GLOBALS['to_slug']
                    };
                    jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
                        "use strict";
                        var rez = {};
                        try {
                            rez = JSON.parse(response);
                        } catch (e) {
                            rez = { error: ANCORA_GLOBALS['ajax_error'] };
                            console.log(response);
                        }
                        ancora_message_success(ANCORA_GLOBALS['to_strings']['export_options']+'<br>'+ANCORA_GLOBALS['to_strings']['export_link'].replace('%s', '<br><a target="_blank" href="'+rez.link+'">'+ANCORA_GLOBALS['to_strings']['export_download']+'</a>'), ANCORA_GLOBALS['to_strings']['export_options_header']);
                        if (val!='') {
                            if (val2!='') {
                                for (var i=0; i<ANCORA_GLOBALS['to_export_list'].length; i++) {
                                    if (ANCORA_GLOBALS['to_export_list'][i] == val2) {
                                        ANCORA_GLOBALS['to_export_list'][i] = val;
                                        break;
                                    }
                                }
                            } else
                                ANCORA_GLOBALS['to_export_list'].push(val);
                        }
                    });
                }
            });
        e.preventDefault();
        return false;
    });

});


// Init all elements
//-----------------------------------------------------------------
function ancora_options_init(to_body) {
"use strict";
    ANCORA_GLOBALS['to_body'] = to_body;

    // Init Dependencies
    //----------------------------------------------------------------
    // Add data-param to all editor areas
    to_body.find('.wp-editor-area').each(function() {
        "use strict";
        jQuery(this).attr('data-param', jQuery(this).attr('id'));
    });

    // Check dependencies
    to_body.on('change', '[data-param]', function() {
        "use strict";
        var cont = jQuery(this).parents('.ancora_options_tab_content');
        if (cont.length==0) cont = jQuery(this).parents('.ancora_options_partition_content');
        ancora_options_check_dependency(cont);
    });

    // Popups init
    //----------------------------------------------------------------
    ancora_options_popup_init(to_body);

    // Tabs and partitions init
    //----------------------------------------------------------------
    to_body.find('.ancora_options_tab,.ancora_options_partition').tabs({
        // Init options, which depends from width() or height() only after open it's parent tab or partition
        create: function(e, ui) {
            "use strict";
            if (ui.panel) {
                ancora_options_init_hidden_elements(ui.panel);
                if (window.ancora_init_hidden_elements) ancora_init_hidden_elements(ui.panel);
            }
        },
        activate: function(e, ui) {
            "use strict";
            if (ui.newPanel) {
                ancora_options_init_hidden_elements(ui.newPanel);
                if (window.ancora_init_hidden_elements) ancora_init_hidden_elements(ui.newPanel);
            }
        }
    });


    // Accordion init
    //----------------------------------------------------------------
    to_body.find('.ancora_options_accordion').accordion({
        header: ".ancora_options_accordion_header",
        collapsible: true,
        heightStyle: "content",
        // Init options, which depends from width() or height() only after open it's parent accordion
        create: function (e, ui) {
            if (ui.panel) {
                ancora_options_init_hidden_elements(ui.panel);
                if (window.ancora_init_hidden_elements) ancora_init_hidden_elements(ui.panel);
            }
        },
        activate: function (e, ui) {
            if (ui.newPanel) {
                ancora_options_init_hidden_elements(ui.newPanel);
                if (window.ancora_init_hidden_elements) ancora_init_hidden_elements(ui.newPanel);
            }
        }
    });


    // Toggles
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_toggle .ancora_options_toggle_header', function () {
        "use strict";
        if (jQuery(this).hasClass('ui-state-active')) {
            jQuery(this).removeClass('ui-state-active');
            jQuery(this).siblings('div').slideUp();
        } else {
            jQuery(this).addClass('ui-state-active');
            jQuery(this).siblings('div').slideDown();
            ancora_options_init_hidden_elements(jQuery(this));
            if (window.ancora_init_hidden_elements) ancora_init_hidden_elements(jQuery(this));
        }
    });

    // Masked input init
    //----------------------------------------------------------------
    to_body.find('.ancora_options_input_masked').each(function () {
        "use strict";
        if (jQuery.mask) jQuery(this).mask(''+jQuery(this).data('mask'));
    });


    // Datepicker init
    //----------------------------------------------------------------
    to_body.find('.ancora_options_input_date').each(function () {
        "use strict";
        var linked = jQuery(this).data('linked-field');
        var curDate = linked ? jQuery('#'+linked).val() : jQuery(this).val();
        jQuery(this).datepicker({
            dateFormat: jQuery(this).data('format'),
            numberOfMonths: jQuery(this).data('months'),
            gotoCurrent: true,
            changeMonth: true,
            changeYear: true,
            defaultDate: curDate,
            onSelect: function (text, ui) {
                var linked = jQuery(this).data('linked-field');
                if (!ancora_empty(linked)) {
                    jQuery('#'+linked).val(text).trigger('change');
                } else {
                    ui.input.trigger('change');
                }
            }
        });
    });


    // Spinner arrows click
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_field_spinner .ancora_options_arrow_up,.ancora_options_field_spinner .ancora_options_arrow_down', function () {
        "use strict";
        var field = jQuery(this).parent().siblings('input');
        var step = field.data('step') ? String(field.data('step')) : "1";
        var prec = step.indexOf('.')==-1 ? 0 : step.length - step.indexOf('.') - 1;
        step = Math.round((jQuery(this).hasClass('ancora_options_arrow_up') ? 1 : -1) * parseFloat(step) * Math.pow(10, prec) ) / Math.pow(10, prec);
        var minValue = field.data('min');
        var maxValue = field.data('max');
        var newValue = Math.round( (isNaN(field.val()) ? 0 : parseFloat(field.val()) + step) * Math.pow(10, prec) ) / Math.pow(10, prec);
        if (!isNaN(maxValue) && newValue > maxValue) {
            newValue = maxValue;
        }
        if (!isNaN(minValue) && newValue < minValue) {
            newValue = minValue;
        }
        field.val(newValue).trigger('change');
    });


    // Tags
    //----------------------------------------------------------------
    to_body.find('.ancora_options_field_tags .ancora_options_field_content').sortable({
        items: "span",
        update: function(event, ui) {
            var tags = '';
            ui.item.parent().find('.ancora_options_tag').each(function() {
                tags += (tags ? ANCORA_GLOBALS['to_delimiter'] : '') + jQuery(this).text();
            });
            ui.item.siblings('input[type="hidden"]').eq(0).val(tags).trigger('change');
        }
    }).disableSelection();
    to_body.on('keypress', '.ancora_options_field_tags input[type="text"]', function (e) {
        "use strict";
        if (e.which===44) {
            ancora_options_add_tag_in_list(jQuery(this));
            e.preventDefault();
            return false;
        }
    });
    to_body.on('keydown', '.ancora_options_field_tags input[type="text"]', function (e) {
        "use strict";
        if (e.which===13) {
            ancora_options_add_tag_in_list(jQuery(this));
            e.preventDefault();
            return false;
        }
    });
    function ancora_options_add_tag_in_list(obj) {
        "use strict";
        if (obj.val().trim()!='') {
            var text = obj.val().trim();
            obj.before('<span class="ancora_options_tag iconadmin-cancel">'+text+'</span>');
            var tags = obj.next().val();
            obj.next().val(tags + (tags ? ANCORA_GLOBALS['to_delimiter'] : '') + text).trigger('change');
            obj.val('');
        }
    }
    to_body.on('click', '.ancora_options_field_tags .ancora_options_field_content span', function (e) {
        "use strict";
        var text = jQuery(this).text();
        var tags = jQuery(this).siblings('input[type="hidden"]').eq(0).val()+ANCORA_GLOBALS['to_delimiter'];
        tags = tags.replace(text+ANCORA_GLOBALS['to_delimiter'], '');
        tags = tags.substring(0, tags.length-1);
        jQuery(this).siblings('input[type="hidden"]').eq(0).val(tags).trigger('change');
        jQuery(this).siblings('input[type="text"]').focus();
        jQuery(this).remove();
        e.preventDefault();
        return false;
    });
    to_body.on('click', '.ancora_options_field_tags .ancora_options_field_content', function (e) {
        "use strict";
        jQuery(this).find('input[type="text"]').focus();
        e.preventDefault();
        return false;
    });


    // Checkbox
    //----------------------------------------------------------------
    to_body.on('change', '.ancora_options_field_checkbox input', function (e) {
        "use strict";
        jQuery(this).next('label').eq(0).toggleClass('ancora_options_state_checked');
        if (jQuery(this).next('label').eq(0).hasClass('ancora_options_state_checked'))
            jQuery(this).attr('checked', 'checked');
        else
            jQuery(this).removeAttr('checked');
        e.preventDefault();
        return false;
    });


    // Radio button
    //----------------------------------------------------------------
    to_body.on('change', '.ancora_options_field_radio input[type="radio"]', function (e) {
        "use strict";
        jQuery(this).parent().parent().find('label').removeClass('ancora_options_state_checked').find('span').removeClass('iconadmin-dot-circled');
        jQuery(this).parent().parent().find('input:checked').next('label').eq(0).addClass('ancora_options_state_checked').find('span').addClass('iconadmin-dot-circled');
        jQuery(this).parent().parent().find('input[type="hidden"]').val(jQuery(this).parent().parent().find('input:checked').val()).trigger('change');
        e.preventDefault();
        return false;
    });


    // Switch button
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_field_switch .ancora_options_switch_inner', function (e) {
        "use strict";
        var val = parseInt(jQuery(this).css('marginLeft'))==0 ? 2 : 1;
        var data = jQuery(this).find('span').eq(val-1).data('value');
        jQuery(this).parent().siblings('input[type="hidden"]').eq(0).val(data).trigger('change');
        jQuery(this).parent().toggleClass('ancora_options_state_off', val==2)
        e.preventDefault();
        return false;
    });


    // Checklist
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_field_checklist .ancora_options_listitem', function (e) {
        "use strict";
        var multiple = jQuery(this).parents('.ancora_options_field_checklist').hasClass('ancora_options_multiple');
        if (!multiple) {
            jQuery(this).siblings('.ancora_options_listitem').removeClass('ancora_options_state_checked');
        }
        jQuery(this).toggleClass('ancora_options_state_checked');
        collectCheckedItems(jQuery(this).parent());
        e.preventDefault();
        return false;
    });
    to_body.find('.ancora_options_field_checklist.ancora_options_multiple .ancora_options_field_content').sortable({
        update: function(event, ui) {
            "use strict";
            collectCheckedItems(ui.item.parent());
        }
    }).disableSelection();


    // Select, list, images, icons, fonts
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_field_select .ancora_options_input,.ancora_options_field_select .ancora_options_field_after,.ancora_options_field_images .ancora_options_caption_image,.ancora_options_field_icons .ancora_options_caption_icon', function (e) {
        "use strict";
        jQuery(this).siblings('.ancora_options_input_menu').slideToggle();
        e.preventDefault();
        return false;
    });

    to_body.on('click', '.ancora_options_field .ancora_options_menuitem', function (e) {
        "use strict";
        var multiple = jQuery(this).parents('.ancora_options_field').hasClass('ancora_options_multiple');
        if (!multiple) {
            jQuery(this).siblings('.ancora_options_menuitem').removeClass('ancora_options_state_checked');
            jQuery(this).addClass('ancora_options_state_checked');
        } else {
            jQuery(this).toggleClass('ancora_options_state_checked');
        }
        collectCheckedItems(jQuery(this).parent());
        if (!multiple && !jQuery(this).parent().hasClass('ancora_options_input_menu_list'))
            jQuery(this).parent().slideToggle();
        e.preventDefault();
        return false;
    });

    to_body.find('.ancora_options_field.ancora_options_multiple .ancora_options_input_menu').sortable({
        update: function(event, ui) {
            "use strict";
            collectCheckedItems(ui.item.parent());
        }
    }).disableSelection();

    // Collect checked items
    function collectCheckedItems(list) {
        "use strict";
        var val = '', caption = '', image = '', icon = '';
        list.find('.ancora_options_menuitem,.ancora_options_listitem').each(function() {
            "use strict";
            if (jQuery(this).hasClass('ancora_options_state_checked')) {
                val += (val ? ANCORA_GLOBALS['to_delimiter'] : '') + jQuery(this).data('value');
                var img = jQuery(this).find('.ancora_options_input_image');
                if (img.length > 0) {
                    image = img.eq(0).data('src');
                } else if (jQuery(this).parents('.ancora_options_field_icons').length > 0) {
                    icon = jQuery(this).data('value');
                } else {
                    caption += (caption ? ANCORA_GLOBALS['to_delimiter'] : '') + jQuery(this).html();
                }
            }
        });
        list.parent().find('input[type="hidden"]').eq(0).val(val).trigger('change');
        if (caption != '')
            list.parent().find('input[type="text"]').eq(0).val(caption);
        if (image != '')
            list.parent().find('.ancora_options_caption_image span').eq(0).css('backgroundImage', 'url('+image+')'); //.attr('src', image);
        if (icon != '') {
            var field = list.parent().find('.ancora_options_input_socials');
            if (field.length > 0) {
                var btn = field.next();
                var cls = btn.attr('class');
                cls = (cls.indexOf(' icon') > 0 ? cls.substr(0, cls.indexOf(' icon')) : cls) + ' ' + icon;
                btn.removeClass().addClass(cls).trigger('change');
            } else
                list.parent().find('.ancora_options_caption_icon span').eq(0).removeClass().addClass(icon).trigger('change');
        }
    }



    // Color selector
    //----------------------------------------------------------------

    // Standard WP Color Picker
    if (to_body.find('.ancora_options_input_color_wp').length > 0) {
        to_body.find('.ancora_options_input_color_wp').wpColorPicker({
            // you can declare a default color here,
            // or in the data-default-color attribute on the input
            //defaultColor: false,

            // a callback to fire whenever the color changes to a valid color
            change: function(e, ui){
                jQuery(e.target).val(ui.color).trigger('change');
            },

            // a callback to fire when the input is emptied or an invalid color
            clear: function(e) {
                jQuery(e.target).prev().trigger('change')
            },

            // hide the color picker controls on load
            //hide: true,

            // show a group of common colors beneath the square
            // or, supply an array of colors to customize further
            //palettes: true
        });
    }

    // Tiny Color Picker
    if (to_body.find('.ancora_options_input_color_tiny').length > 0) {
        to_body.find('.ancora_options_input_color_tiny').colorPicker({
            animationSpeed: 0,
            margin: '1px 0 0 0',
            cssAddon: '.cp-color-picker { background-color: #ddd; z-index:1000; }',
            renderCallback: function($elm, toggled) {
                var colors = this.color.colors,
                    rgb = colors.RND.rgb,
                    clr = colors.alpha == 1
                        ? '#'+colors.HEX
                        : 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + (Math.round(colors.alpha * 100) / 100) + ')';
                $elm.val(clr).data('last-color', clr);
            }

        });
    }

    // Internal Theme Color Picker
    if (to_body.find('.ancora_options_input_color + .iColorPicker').length > 0) {
        ancora_color_picker();
        to_body.find('.ancora_options_input_color + .iColorPicker').each(function() {
            jQuery(this).on('click', function (e) {
                "use strict";
                ancora_color_picker_show(null, jQuery(this), function(fld, clr) {
                    "use strict";
                    fld.css('backgroundColor', clr);
                    fld.siblings('input').attr('value', clr).trigger('change');
                });
            });
            var prev_fld = jQuery(this).prev();
            var prev_val = prev_fld.val();
            if (prev_val!='') {
                jQuery(this).css('backgroundColor', prev_val);
            }
            prev_fld.on('change', function() {
                "use strict";
                jQuery(this).next().css('backgroundColor', jQuery(this).val());
            });
        });
    }

    // Clone buttons
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_clone_button_add', function (e) {
        "use strict";
        var clone_area = jQuery(this).parents('.ancora_options_cloneable_area').eq(0);
        var clone_item = null;
        var max_num = 0;
        clone_area.find('.ancora_options_cloneable_item').each(function() {
            "use strict";
            var cur_item = jQuery(this);
            if (clone_item == null)
                clone_item = cur_item;
            var num = Number(cur_item.find('input[name*="_numbers[]"]').eq(0).val());
            if (num > max_num)
                max_num = num;
        });
        var clonedObj = clone_item.clone();
        clonedObj.find('input[type="text"],textarea').val('');
        clonedObj.find('input[name*="_numbers[]"]').val(max_num+1);
        jQuery(this).before(clonedObj);
        e.preventDefault();
        return false;
    });

    to_body.on('click', '.ancora_options_clone_button_del', function (e) {
        "use strict";
        if (jQuery(this).parents('.ancora_options_cloneable_item').parent().find('.ancora_options_cloneable_item').length > 1)
            jQuery(this).parents('.ancora_options_cloneable_item').eq(0).remove();
        else
            ancora_message_warning(ANCORA_GLOBALS['to_strings']['del_item_error'], ANCORA_GLOBALS['to_strings']['del_item']);
        e.preventDefault();
        return false;
    });



    // Inherit buttons
    //----------------------------------------------------------------
    to_body.on('click', '.ancora_options_button_inherit', function (e) {
        "use strict";
        var inherit = !jQuery(this).hasClass('ancora_options_inherit_off');
        if (inherit) {
            jQuery(this).addClass('ancora_options_inherit_off');
            jQuery(this).parents('.ancora_options_field').find('.ancora_options_content_inherit').fadeOut().find('input').val('');
        } else {
            jQuery(this).removeClass('ancora_options_inherit_off');
            jQuery(this).parents('.ancora_options_field').find('.ancora_options_content_inherit').fadeIn().find('input').val('inherit');
        }
        e.preventDefault();
        return false;
    });
    to_body.on('click', '.ancora_options_content_inherit', function (e) {
        "use strict";
        jQuery(this).parents('.ancora_options_field').find('.ancora_options_button_inherit').addClass('ancora_options_inherit_off');
        jQuery(this).fadeOut().find('input').val('');
        e.preventDefault();
        return false;
    });
}


// Standard actions
//-----------------------------------------------------------------

// Open Wordpress media manager window
function ancora_options_action_media_upload(obj) {
    "use strict";
    var button = jQuery(obj);
    var field  = button.data('linked-field') ? jQuery("#"+button.data('linked-field')).eq(0) : button.siblings('input');
    var fieldId = field.attr('id');
    if ( ANCORA_GLOBALS['to_media_frame'][fieldId] ) {
        ANCORA_GLOBALS['to_media_frame'][fieldId]['field'] = field;
        ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'].open();
        return;
    }
    ANCORA_GLOBALS['to_media_frame'][fieldId] = [];
    ANCORA_GLOBALS['to_media_frame'][fieldId]['field'] = field;
    ANCORA_GLOBALS['to_media_frame'][fieldId]['sizes'] = button.data('sizes');
    ANCORA_GLOBALS['to_media_frame'][fieldId]['multi'] = button.data('multiple');
    // Create media selector
    var media_args = {
        // Popup layout (if comment next row - hide filters and image sizes popups)
        frame: 'post',
        // Multiple choise
        multiple: ANCORA_GLOBALS['to_media_frame'][fieldId]['multi'] ? 'add' : false,
        // Set the title of the modal.
        title: button.data('caption-choose'),
        // Tell the modal to show only specified type
        library: {
            type: button.data('type') ? button.data('type') : 'image',
        },
        // Customize the submit button.
        button: {
            // Set the text of the button.
            text: button.data('caption-update'),
            // Tell the button to close the modal
            close: true
        }
    };
    ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'] = wp.media(media_args);			// = wp.media.frames.media_frame
    ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'].on( 'insert select', function(e) {
        "use strict";
        var attachment_url = '', pos = -1, init = false;
        if (ANCORA_GLOBALS['to_media_frame'][fieldId]['multi']) {
            ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'].state().get('selection').map( function( att ) {
                "use strict";
                attachment += (attachment ? "\n" : "") + att.toJSON().url;
            });
            var val = ANCORA_GLOBALS['to_media_frame'][fieldId]['field'].val();
            attachment_url = val + (val ? "\n" : '') + attachment;
        } else {
            var attachment = ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'].state().get('selection').first().toJSON();
            var sizes_selector = jQuery('.media-modal-content .attachment-display-settings select.size');
            if (ANCORA_GLOBALS['to_media_frame'][fieldId]['sizes'] && sizes_selector.length > 0) {
                var size = ancora_get_listbox_selected_value(sizes_selector.get(0));
                if (size != '') attachment_url = attachment.sizes[size].url;
            }
            if (attachment_url == '') attachment_url = attachment.url;
            if (!button.data('linked-field')) {
                var output = '';
                if ((pos = attachment_url.lastIndexOf('.'))>=0) {
                    var ext = attachment_url.substr(pos+1);
                    output = '<a class="ancora_options_image_preview" rel="popupImage" target="_blank" href="' + attachment_url + '">';
                    if ('jpg,png,gif'.indexOf(ext)>=0) {
                        output += '<img src="'+attachment_url+'" alt="" rel="popupImage" />';
                        init = true;
                    } else {
                        output += '<span>'+attachment_url.substr(attachment_url.lastIndexOf('/')+1)+'</span>';
                    }
                    output += '</a>';
                }
                button.siblings('.ancora_options_image_preview').remove();
                if (output != '') {
                    button.parent().append(output);
                    if (init) ancora_options_popup_init(ANCORA_GLOBALS['to_body']);
                }
            }
        }
        ANCORA_GLOBALS['to_media_frame'][fieldId]['field'].val(attachment_url).trigger('change');
    });
    ANCORA_GLOBALS['to_media_frame'][fieldId]['frame'].open();
}

// Clear media field
function ancora_options_action_media_reset(obj) {
    "use strict";
    var button = jQuery(obj);
    var field  = button.data('linked-field') ? jQuery("#"+button.data('linked-field')).eq(0) : button.siblings('input');
    button.siblings('.ancora_options_image_preview').remove();
    field.val('').trigger('change');
}

// Clear color field
function ancora_options_action_color_reset(obj) {
    "use strict";
    var button = jQuery(obj);
    var field  = button.data('linked-field') ? jQuery("#"+button.data('linked-field')).eq(0) : button.siblings('input');
    field.val('').css('backgroundColor', '#ffffff').trigger('change');
}

// Select fontello icon
function ancora_options_action_select_icon(obj) {
    "use strict";
    var button = jQuery(obj);
    var field  = button.data('linked-field') ? jQuery("#"+button.data('linked-field')).eq(0) : button.siblings('input[type="hidden"]').eq(0);
    button.siblings('.ancora_options_input_menu').slideToggle();
}


// Popup init
function ancora_options_popup_init(to_body) {
    "use strict";
    to_body.find("a[rel*='popupImage']:not(.inited)").each(function() {
        "use strict";
        if (ANCORA_GLOBALS['to_popup']=='pretty') {
            jQuery(this).addClass('inited').prettyPhoto({
                social_tools: '',
                theme: 'facebook',
                deeplinking: false
            });
        } else if (ANCORA_GLOBALS['to_popup']=='magnific') {
            jQuery(this).addClass('inited').magnificPopup({
                type: 'image',
                mainClass: 'mfp-img-mobile',
                closeOnContentClick: true,
                closeBtnInside: true,
                fixedContentPos: true,
                midClick: true,
                //removalDelay: 500,
                preloader: true,
                image: {
                    verticalFit: true
                }
            });
        }
    });
}


// Init previously hidden elements
//-----------------------------------------------------------------------------------
function ancora_options_init_hidden_elements(container) {
    "use strict";
    // Fields visibility
    ancora_options_check_dependency(container);
    // Range sliders
    container.find('.ancora_options_field_range').each(function () {
        "use strict";
        var obj = jQuery(this);
        var scale = obj.find('.ancora_options_range_scale');
        //var scaleWidth = obj.width() - parseInt(scale.css('left')) - parseInt(scale.css('right'));
        var scaleWidth = scale.width();
        if (scaleWidth <= 0) return;
        var step = parseFloat(obj.find('.ancora_options_input_range').data('step'));
        var prec = Math.pow(10, step.toString().indexOf('.') < 0 ? 0 : step.toString().length - step.toString().indexOf('.') - 1);
        var field = obj.find('.ancora_options_input_range input[type="hidden"]').eq(0);
        var val = field.val().split(ANCORA_GLOBALS['to_delimiter']);
        var rangeMin = parseFloat(obj.find('.ancora_options_range_min').html());
        var rangeMax = parseFloat(obj.find('.ancora_options_range_max').html());
        var scaleStep = scaleWidth / ((rangeMax - rangeMin) / step);
        var i = 0;
        obj.find('.ancora_options_range_slider').each(function () {
            "use strict";
            var fill = val.length==1 || i==1 ? 'width' : 'left';
            jQuery(this).css('left', (val[i]-rangeMin)*scaleStep/step+'px');
            scale.find('span').css(fill, ((val[i]-rangeMin)*scaleStep/step-(i==1 ? (val[0]-rangeMin)*scaleStep/step : 0))+'px');
            i++;
        });
        if (!obj.hasClass('inited')) {
            obj.addClass('inited').find('.ancora_options_range_slider').draggable({
                axis: 'x',
                grid: [scaleStep, scaleStep],
                containment: '.ancora_options_input_range',
                scroll: false,
                drag: function (e, ui) {
                    "use strict";
                    var field = obj.find('.ancora_options_input_range input[type="hidden"]').eq(0);
                    var val = field.val().split(ANCORA_GLOBALS['to_delimiter']);
                    var slider = ui.helper;
                    var idx = slider.index()-1;
                    var newVal = Math.min(rangeMax, Math.max(rangeMin, Math.round(ui.position.left / scaleStep * step * prec) / prec + rangeMin));
                    if (val.length==2) {
                        if (idx==0 && newVal > val[1]) {
                            newVal = val[1];
                            ui.position.left = (newVal-rangeMin)*scaleStep/step;
                        }
                        if (idx==1 && newVal < val[0]) {
                            newVal = val[0];
                            ui.position.left = (newVal-rangeMin)*scaleStep/step;
                        }
                    }
                    if (val[idx] != newVal) {
                        slider.find('.ancora_options_range_slider_value').html(newVal);
                        val[idx] = newVal;
                        field.val(val.join(ANCORA_GLOBALS['to_delimiter'])).trigger('change');
                        if (val.length==2)
                            scale.find('span').css('left', (val[0]-rangeMin)*scaleStep/step+'px');
                        scale.find('span').css('width', ((val[val.length==2 ? 1 : 0]-rangeMin)*scaleStep/step-(val.length==2 ? (val[0]-rangeMin)*scaleStep/step : 0))+'px');
                    }
                }
            });
        }
    });
}


// Check dependencies
function ancora_options_check_dependency(cont) {
    "use strict";
    if (cont.parents('.ancora_shortcodes_body').length==1) {
        if (typeof ANCORA_GLOBALS['shortcodes'] == 'undefined') return;
        var sc_name = ANCORA_GLOBALS['shortcodes_current_idx'];
        if (sc_name == '') return;
        var sc = ANCORA_GLOBALS['shortcodes'][sc_name];
    } else if (cont.parents('.ancora_options_body').length==1) {
        if (typeof ANCORA_GLOBALS['to_options'] == 'undefined') return;
        var sc = ANCORA_GLOBALS['to_options'];
    } else {
        return;
    }
    var popup = cont.parents('.ancora_options_tab');
    if (popup.length==0) popup = cont;
    //var cont = jQuery('.ancora_shortcodes_body');
    cont.find('[data-param]').each(function() {
        "use strict";
        var field = jQuery(this);
        var param = field.data('param');
        var value = field.attr('type') != 'checkbox' || field.get(0).checked ? field.val() : '';
        var depend = false;
        if (typeof sc.params != 'undefined' && typeof sc.params[param] != 'undefined' && typeof sc.params[param].dependency != 'undefined')
            depend = sc.params[param].dependency;
        if (depend === false && typeof sc.children != 'undefined' && typeof sc.children.params != 'undefined' && typeof sc.children.params[param] != 'undefined' && typeof sc.children.params[param].dependency != 'undefined')
            depend = sc.children.params[param].dependency;
        if (depend === false && typeof sc[param] != 'undefined' && typeof sc[param].dependency != 'undefined')
            depend = sc[param].dependency;
        if (depend) {
            var dep_cnt = 0, dep_all = 0;
            var dep_cmp = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
            var fld=null, val='';
            for (var i in depend) {
                if (i == 'compare') continue;
                dep_all++;
                fld = cont.find('[data-param="'+i+'"]');
                if (fld.length==0) fld = popup.find('[data-param="'+i+'"]');
                if (fld.length > 0) {
                    val = fld.attr('type') != 'checkbox' || fld.get(0).checked ? fld.val() : '';
                    for (var j in depend[i]) {
                        if (
                            (depend[i][j]=='not_empty' && val!='') 										// Main field value is not empty - show current field
                            || (depend[i][j]=='is_empty' && val=='')										// Main field value is empty - show current field
                            || (depend[i][j]=='refresh' && ancora_options_refresh_field(field, i, val))	// Main field value changed - refresh current field
                            || (val!='' && val.indexOf(depend[i][j])==0)									// Main field value equal to specified value - show current field
                        ) {
                            dep_cnt++;
                            break;
                        }
                    }
                }
                if (dep_cnt > 0 && dep_cmp == 'or')
                    break;
            }
            if ((dep_cnt > 0 && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
                field.parents('.ancora_options_field').show().removeClass('ancora_options_no_use');
            } else {
                field.parents('.ancora_options_field').hide().addClass('ancora_options_no_use');
            }
        }
    });
}

// Fix header on scroll
jQuery(window).scroll(function () {
    "use strict";
    ancora_options_fix_scroll_menu();
});

function ancora_options_fix_scroll_menu() {
    "use strict";
    var headerOptions = jQuery('.ancora_options_form .ancora_options_header');
    if (headerOptions.length > 0) {
        if (headerOptions.data('wrap') != 1){
            headerOptions.wrap('<div class="ancora_options_header_wrap" style="height:'+headerOptions.height()+'px;"></div>' );
            headerOptions.attr('data-wrap','1')
        }
        var scrollPosition = jQuery(window).scrollTop();
        var adminBarHeight = jQuery('#wpadminbar').height();
        var tRexBar = jQuery('.ancora_options_header').height();
        if (scrollPosition > (adminBarHeight + 20 + tRexBar)) {
            jQuery('.ancora_options_header').addClass('ancora_options_header_fixed');
        } else {
            jQuery('.ancora_options_header').removeClass('ancora_options_header_fixed');
        }
    }
}


// Import values
function ancora_options_import_values(data) {
    "use strict";
    var msg = '', res = '';
    for (var opt in data) {
        if ((res = ancora_options_set_value(opt, data[opt])) != '') {
            msg += (msg!='' ? ',<br>' : '') + res;
        }
    }
    if (msg != '') {
        ancora_message_warning(ANCORA_GLOBALS['to_strings']['import_options_broken']+'<br>'+msg, ANCORA_GLOBALS['to_strings']['import_options_header']);
    }
}

// Set new value for one field
function ancora_options_set_value(opt, val) {
    "use strict";
    var result = '';
    var suffix = (typeof val == 'object' ? '[]' : '');
    var fld = jQuery('[name="'+opt+suffix+'"]');
    if (fld.length == 0) return false;
    var parent = fld.parents('.ancora_options_field');
    var type = ancora_options_get_type(parent);
    var clone_area = fld.parents('.ancora_options_cloneable_area');
    var clone_item = null;
    if (clone_area.length > 0) {
        clone_area.find('.ancora_options_cloneable_item').each(function(idx) {
            if (idx == 0) {
                clone_item = jQuery(this);
                fld.eq(0).val('');
                jQuery(this).find('[name="'+opt+'_numbers[]"]').val(0);
                if (type=='socials') jQuery(this).find('[name="'+opt+'_icon[]"]').val('');
            } else
                jQuery(this).remove();
        });
    }
    if (typeof val != 'object' || typeof val[0] == 'undefined')
        val = [val];
    var cnt = 0;
    for (var i in val) {
        if (ANCORA_GLOBALS['to_override']!='general') {
            if (val[i] != 'inherit') {
                parent.find('.ancora_options_button_inherit').addClass('ancora_options_inherit_off');
                parent.find('.ancora_options_content_inherit').fadeOut().find('input').val('');
            } else {
                parent.find('.ancora_options_button_inherit').removeClass('ancora_options_inherit_off');
                parent.find('.ancora_options_content_inherit').fadeIn().find('input').val('inherit');
            }
        }
        if (cnt > 0 && clone_area.length > 0) {
            var clonedObj = clone_item.clone();
            clonedObj.find('input[name*="_numbers[]"]').val(i);
            clone_area.find('.ancora_options_clone_button_add').before(clonedObj);
            fld = jQuery('[name="'+opt+'[]"]');
        }
        if (ANCORA_GLOBALS['to_override']=='general' || val[i] != 'inherit') {
            if (type=='text' || type=='textarea' || type=='hidden' || type=='spinner') {
                fld.eq(cnt).val(val[i]).trigger('change');
            } else if (type=='editor') {
                fld.eq(cnt).val(val[i]).trigger('change');
                if (typeof(tinymce) != 'undefined' && typeof(tinymce.editors[opt])!='undefined') {
                    tinymce.editors[opt].setContent(val[i]);
                }
            } else if (type=='date') {
                parent.datepicker( "setDate", val[i] );
                fld.eq(cnt).val(val[i]).trigger('change');
            } else if (type=='tags') {
                fld.eq(cnt).val(val[i]).trigger('change');
                fld.eq(cnt).parent().find('.ancora_options_tag').remove();
                fld.eq(cnt).prev().val('');
                var tags = val[i].split(ANCORA_GLOBALS['to_delimiter']);
                for (var j=0; j<tags.length; j++)
                    fld.eq(cnt).prev().before('<span class="ancora_options_tag iconadmin-cancel">'+tags[j]+'</span>');
            } else if (type=='checkbox') {
                fld.eq(cnt).next('label').eq(0).toggleClass('ancora_options_state_checked', val[i]=='true');
                if (val[i]=='true')
                    fld.eq(cnt).attr('checked', 'checked');
                else
                    fld.eq(cnt).removeAttr('checked');
            } else if (type=='radio') {
                fld.eq(cnt).removeAttr('checked').parent().parent().find('label').removeClass('ancora_options_state_checked').find('span').removeClass('iconadmin-dot-circled');
                fld.eq(cnt).parent().parent().find('input[value="'+val[i]+'"]').attr('checked', 'checked').next('label').eq(0).addClass('ancora_options_state_checked').find('span').addClass('iconadmin-dot-circled');
                fld.eq(cnt).parent().parent().find('input[type="hidden"]').val(val[i]).trigger('change');
            } else if (type=='switch') {
                fld.eq(cnt).val(val[i]).trigger('change');
                var idx = fld.siblings('.ancora_options_switch').find('[data-value="'+val[i]+'"]').index();
                fld.eq(cnt).siblings('.ancora_options_switch').toggleClass('ancora_options_state_off', idx==1);
            } else if (type=='checklist') {
                fld.eq(cnt).val(val[i]).trigger('change');
                fld.eq(cnt).siblings('.ancora_options_listitem').removeClass('ancora_options_state_checked');
                var items = val[i].split(ANCORA_GLOBALS['to_delimiter']);
                for (var j=0; j<items.length; j++)
                    fld.eq(cnt).siblings('.ancora_options_listitem[data-value="'+items[j]+'"]').addClass('ancora_options_state_checked');
            } else if (type=='media') {
                fld.eq(cnt).val(val[i]).trigger('change');
                fld.eq(cnt).siblings('.ancora_options_image_preview').remove();
                if (val[i]!='') {
                    var file = val[i].split('/').pop();
                    if (file!='') {
                        var parts = file.split('.');
                        var fname = parts[0];
                        var ext = parts.length > 1 ? parts[1] : '';
                        fld.eq(cnt).after('<a class="ancora_options_image_preview" rel="prettyPhoto" target="_blank" href="'+val[i]+'">'+('jpg,png,gif'.indexOf(ext)>=0 ? '<img src="'+val[i]+'" alt="" />' : '<span>'+fname+'</span>')+'</a>');
                    }
                }
            } else if (type=='range') {
                fld.eq(cnt).val(val[i]).trigger('change');
                var scale = parent.find('.ancora_options_range_scale');
                var step = parseInt(parent.find('.ancora_options_input_range').data('step'));
                var rangeMin = parseInt(parent.find('.ancora_options_range_min').html());
                var rangeMax = parseInt(parent.find('.ancora_options_range_max').html());
                var scaleWidth = scale.width();
                var scaleStep = scaleWidth / (rangeMax - rangeMin) * step;
                var items = val[i].split(ANCORA_GLOBALS['to_delimiter']);
                for (var j=0; j<items.length; j++) {
                    var slider = fld.eq(cnt).siblings('.ancora_options_range_slider').eq(j);
                    slider.find('.ancora_options_range_slider_value').html(items[j]);
                    var fill = items.length==1 || j==1 ? 'width' : 'left';
                    slider.css('left', (items[j]-rangeMin)*scaleStep+'px');
                    scale.find('span').css(fill, ((items[j]-rangeMin)*scaleStep-(j==1 ? (items[0]-rangeMin)*scaleStep : 0))+'px');
                }
            } else if (type=='select' || type=='images' || type=='icons') {
                fld.eq(cnt).val(val[i]).trigger('change');
                fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem').removeClass('ancora_options_state_checked');
                var items = val[i].split(ANCORA_GLOBALS['to_delimiter']);
                for (var j=0; j<items.length; j++) {
                    fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem[data-value="'+items[j]+'"]').addClass('ancora_options_state_checked');
                    if (type=='images') {
                        var src = fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem[data-value="'+items[j]+'"]').find('span').data('src');
                        fld.eq(cnt).siblings('.ancora_options_caption_image').find('span').css('backgroundImage', 'url('+src+')');
                    } else if (type=='icons') {
                        var cls = fld.eq(cnt).siblings('.ancora_options_caption_icon').find('span').attr('class');
                        cls = (cls.indexOf(' icon') > 0 ? cls.substr(0, cls.indexOf(' icon')) : cls) + ' ' + items[i];
                        fld.eq(cnt).siblings('.ancora_options_caption_icon').find('span').removeClass().addClass(cls);
                    } else {
                        var caption = fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem[data-value="'+items[j]+'"]').text();
                        fld.eq(cnt).siblings('.ancora_options_input').val(caption);
                    }
                }
            } else if (type=='socials') {
                fld.eq(cnt).val(val[i].url).trigger('change');
                fld.eq(cnt).siblings('[name="social_icons_icon[]"]').val(val[i].icon);
                fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem').removeClass('ancora_options_state_checked');
                fld.eq(cnt).siblings('.ancora_options_input_menu').find('.ancora_options_menuitem[data-value="'+val[i].icon+'"]').addClass('ancora_options_state_checked');
                var subtype = parent.hasClass('ancora_options_field_images') ? 'images' : 'icons';
                if (subtype=='images') {
                    fld.eq(cnt).siblings('.ancora_options_caption_image').find('span').css('backgroundImage', 'url('+val[i].icon+')');
                } else if (subtype=='icons') {
                    var cls = fld.eq(cnt).siblings('.ancora_options_field_after').attr('class');
                    cls = (cls.indexOf(' icon') > 0 ? cls.substr(0, cls.indexOf(' icon')) : cls) + ' ' + val[i].icon;
                    fld.eq(cnt).siblings('.ancora_options_field_after').removeClass().addClass(cls);
                }
            } else if (type=='color') {
                fld.eq(cnt).val(val[i]).trigger('change');
            } else {
                fld.eq(cnt).val(val[i]).trigger('change');
                if (!result) result = opt+' ('+type+') = '+val[i];
            }
        }
        cnt++;
    }
    return result;
}

// Return type of the field
function ancora_options_get_type(fld) {
    "use strict";
    var classes = fld.attr('class').split(' ');
    var type = 'text';
    for (var i=0; i < classes.length; i++) {
        if (classes[i].indexOf('ancora_options_field_')==0) {
            type = classes[i].split('_').pop();
            break;
        }
    }
    return type;
}

// Refresh field then main field changed
function ancora_options_refresh_field(fld, main_name, main_val) {
    "use strict";
    if (main_name == 'post_type') {
        if (fld.data(main_name)==undefined)
            fld.data(main_name, main_val);
        else if (fld.data(main_name)!=main_val) {
            var cat_field = fld;
            var cat_list = cat_field.prev().slideToggle();
            var cat_lbl = cat_list.parent().prev();
            cat_lbl.append('<span class="sc_refresh iconadmin-spin3 animate-spin"></span>');
            // Prepare data
            var data = {
                action: 'ancora_admin_change_post_type',
                nonce: ANCORA_GLOBALS['ajax_nonce'],
                post_type: main_val
            };
            jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
                "use strict";
                var rez = {};
                try {
                    rez = JSON.parse(response);
                } catch (e) {
                    rez = { error: ANCORA_GLOBALS['ajax_error'] };
                    console.log(response);
                }
                if (rez.error === '') {
                    var cat_str = '';
                    for (var i in rez.data.ids) {
                        cat_str += '<span class="ancora_options_menuitem ui-sortable-handle" data-value="'+rez.data.ids[i]+'">'+rez.data.titles[i]+'</span>';
                    }
                    cat_field.data(main_name, main_val).val('');
                    cat_list.empty().html(cat_str).slideToggle();
                    cat_lbl.find('span').remove();
                }
            });
        }
    }
    return true;
}
