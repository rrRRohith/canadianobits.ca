// Init scripts
jQuery(document).ready(function(){
	"use strict";
	
	// Settings and constants
	ANCORA_GLOBALS['shortcodes_delimiter'] = ',';		// Delimiter for multiple values
	ANCORA_GLOBALS['shortcodes_popup'] = null;		// Popup with current shortcode settings
	ANCORA_GLOBALS['shortcodes_current_idx'] = '';	// Current shortcode's index
	ANCORA_GLOBALS['shortcodes_tab_clone_tab'] = '<li id="ancora_shortcodes_tab_{id}" data-id="{id}"><a href="#ancora_shortcodes_tab_{id}_content"><span class="iconadmin-{icon}"></span>{title}</a></li>';
	ANCORA_GLOBALS['shortcodes_tab_clone_content'] = '';

	// Shortcode selector - "change" event handler - add selected shortcode in editor
	jQuery('body').on('change', ".sc_selector", function() {
		"use strict";
		ANCORA_GLOBALS['shortcodes_current_idx'] = jQuery(this).find(":selected").val();
		if (ANCORA_GLOBALS['shortcodes_current_idx'] == '') return;
		var sc = ancora_clone_object(ANCORA_GLOBALS['shortcodes'][ANCORA_GLOBALS['shortcodes_current_idx']]);
		var hdr = sc.title;
		var content = "";
		try {
			content = tinyMCE.activeEditor ? tinyMCE.activeEditor.selection.getContent({format : 'raw'}) : jQuery('#wp-content-editor-container textarea').selection();
		} catch(e) {};
		if (content) {
			for (var i in sc.params) {
				if (i == '_content_') {
					sc.params[i].value = content;
					break;
				}
			}
		}
		var html = (!ancora_empty(sc.desc) ? '<p>'+sc.desc+'</p>' : '')
			+ ancora_shortcodes_prepare_layout(sc);

		// Show Dialog popup
		ANCORA_GLOBALS['shortcodes_popup'] = ancora_message_dialog(html, hdr,
			function(popup) {
				"use strict";
				ancora_options_init(popup);
				popup.find('.ancora_options_tab_content').css({
					maxHeight: jQuery(window).height() - 300 + 'px',
					overflow: 'auto'
				});
			},
			function(btn, popup) {
				"use strict";
				if (btn != 1) return;
				var sc = ancora_shortcodes_get_code(ANCORA_GLOBALS['shortcodes_popup']);
				if (tinyMCE.activeEditor) {
					if ( !tinyMCE.activeEditor.isHidden() )
						tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, sc );
					//else if (typeof wpActiveEditor != 'undefined' && wpActiveEditor != '') {
					//	document.getElementById( wpActiveEditor ).value += sc;
					else
						send_to_editor(sc);
				} else
					send_to_editor(sc);
			});

		// Set first item active
		jQuery(this).get(0).options[0].selected = true;

		// Add new child tab
		ANCORA_GLOBALS['shortcodes_popup'].find('.ancora_shortcodes_tab').on('tabsbeforeactivate', function (e, ui) {
			if (ui.newTab.data('id')=='add') {
				ancora_shortcodes_add_tab(ui.newTab);
				e.stopImmediatePropagation();
				e.preventDefault();
				return false;
			}
		});

		// Delete child tab
		ANCORA_GLOBALS['shortcodes_popup'].find('.ancora_shortcodes_tab > ul').on('click', '> li+li > a > span', function (e) {
			var tab = jQuery(this).parents('li');
			var idx = tab.data('id');
			if (parseInt(idx) > 1) {
				if (tab.hasClass('ui-state-active')) {
					tab.prev().find('a').trigger('click');
				}
				tab.parents('.ancora_shortcodes_tab').find('.ancora_options_tab_content').eq(idx).remove();
				tab.remove();
				e.preventDefault();
				return false;
			}
		});

		return false;
	});

});



// Return result code
//------------------------------------------------------------------------------------------
function ancora_shortcodes_get_code(popup) {
	ANCORA_GLOBALS['sc_custom'] = '';
	
	var sc_name = ANCORA_GLOBALS['shortcodes_current_idx'];
	var sc = ANCORA_GLOBALS['shortcodes'][sc_name];
	var tabs = popup.find('.ancora_shortcodes_tab > ul > li');
	var decor = !ancora_isset(sc.decorate) || sc.decorate;
	var rez = '[' + sc_name + ancora_shortcodes_get_code_from_tab(popup.find('#ancora_shortcodes_tab_0_content').eq(0)) + ']'
			// + (decor ? '\n' : '')
			;
	if (ancora_isset(sc.children)) {
		if (ANCORA_GLOBALS['sc_custom']!='no') {
			var decor2 = !ancora_isset(sc.children.decorate) || sc.children.decorate;
			for (var i=0; i<tabs.length; i++) {
				var tab = tabs.eq(i);
				var idx = tab.data('id');
				if (isNaN(idx) || parseInt(idx) < 1) continue;
				var content = popup.find('#ancora_shortcodes_tab_' + idx + '_content').eq(0);
				rez += (decor2 ? '\n\t' : '') + '[' + sc.children.name + ancora_shortcodes_get_code_from_tab(content) + ']';	// + (decor2 ? '\n' : '');
				if (ancora_isset(sc.children.container) && sc.children.container) {
					if (content.find('[data-param="_content_"]').length > 0) {
						rez += 
							//(decor2 ? '\t\t' : '') + 
							content.find('[data-param="_content_"]').val()
							// + (decor2 ? '\n' : '')
							;
					}
					rez += 
						//(decor2 ? '\t' : '') + 
						'[/' + sc.children.name + ']'
						// + (decor ? '\n' : '')
						;
				}
			}
		}
	} else if (ancora_isset(sc.container) && sc.container && popup.find('#ancora_shortcodes_tab_0_content [data-param="_content_"]').length > 0) {
		rez += 
			//(decor ? '\t' : '') + 
			popup.find('#ancora_shortcodes_tab_0_content [data-param="_content_"]').val()
			// + (decor ? '\n' : '')
			;
	}
	if (ancora_isset(sc.container) && sc.container || ancora_isset(sc.children))
		rez += 
			(ancora_isset(sc.children) && decor && ANCORA_GLOBALS['sc_custom']!='no' ? '\n' : '')
			+ '[/' + sc_name + ']'
			 //+ (decor ? '\n' : '')
			 ;
	return rez;
}

// Collect all parameters from tab into string
function ancora_shortcodes_get_code_from_tab(tab) {
	var rez = ''
	var mainTab = tab.attr('id').indexOf('tab_0') > 0;
	tab.find('[data-param]').each(function () {
		var field = jQuery(this);
		var param = field.data('param');
		if (!field.parents('.ancora_options_field').hasClass('ancora_options_no_use') && param.substr(0, 1)!='_' && !ancora_empty(field.val()) && field.val()!='none' && (field.attr('type') != 'checkbox' || field.get(0).checked)) {
			rez += ' '+param+'="'+ancora_shortcodes_prepare_value(field.val())+'"';
		}
		// On main tab detect param "custom"
		if (mainTab && param=='custom') {
			ANCORA_GLOBALS['sc_custom'] = field.val();
		}
	});
	// Get additional params for general tab from items tabs
	if (ANCORA_GLOBALS['sc_custom']!='no' && mainTab) {
		var sc = ANCORA_GLOBALS['shortcodes'][ANCORA_GLOBALS['shortcodes_current_idx']];
		var sc_name = ANCORA_GLOBALS['shortcodes_current_idx'];
		if (sc_name == 'trx_columns' || sc_name == 'trx_skills' || sc_name == 'trx_team' || sc_name == 'trx_price_table') {	// Determine "count" parameter
			var cnt = 0;
			tab.siblings('div').each(function() {
				var item_tab = jQuery(this);
				var merge = parseInt(item_tab.find('[data-param="span"]').val());
				cnt += !isNaN(merge) && merge > 0 ? merge : 1;
			});
			rez += ' count="'+cnt+'"';
		}
	}
	return rez;
}


// Shortcode parameters builder
//-------------------------------------------------------------------------------------------

// Prepare layout from shortcode object (array)
function ancora_shortcodes_prepare_layout(field) {
	"use strict";
	// Make params cloneable
	field['params'] = [field['params']];
	if (!ancora_empty(field.children)) {
		field.children['params'] = [field.children['params']];
	}
	// Prepare output
	var output = '<div class="ancora_shortcodes_body ancora_options_body"><form>';
	output += ancora_shortcodes_show_tabs(field);
	output += ancora_shortcodes_show_field(field, 0);
	if (!ancora_empty(field.children)) {
		ANCORA_GLOBALS['shortcodes_tab_clone_content'] = ancora_shortcodes_show_field(field.children, 1);
		output += ANCORA_GLOBALS['shortcodes_tab_clone_content'];
	}
	output += '</div></form></div>';
	return output;
}



// Show tabs
function ancora_shortcodes_show_tabs(field) {
	"use strict";
	// html output
	var output = '<div class="ancora_shortcodes_tab ancora_options_container ancora_options_tab">'
		+ '<ul>'
		+ ANCORA_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, 0).replace('{icon}', 'cog').replace('{title}', 'General');
	if (ancora_isset(field.children)) {
		for (var i=0; i<field.children.params.length; i++)
			output += ANCORA_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, i+1).replace('{icon}', 'cancel').replace('{title}', field.children.title + ' ' + (i+1));
		output += ANCORA_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, 'add').replace('{icon}', 'list-add').replace('{title}', '');
	}
	output += '</ul>';
	return output;
}

// Add new tab
function ancora_shortcodes_add_tab(tab) {
	"use strict";
	var idx = 0;
	tab.siblings().each(function () {
		"use strict";
		var i = parseInt(jQuery(this).data('id'));
		if (i > idx) idx = i;
	});
	idx++;
	tab.before( ANCORA_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, idx).replace('{icon}', 'cancel').replace('{title}', ANCORA_GLOBALS['shortcodes'][ANCORA_GLOBALS['shortcodes_current_idx']].children.title + ' ' + idx) );
	tab.parents('.ancora_shortcodes_tab').append(ANCORA_GLOBALS['shortcodes_tab_clone_content'].replace(/tab_1_/g, 'tab_' + idx + '_'));
	tab.parents('.ancora_shortcodes_tab').tabs('refresh');
	ancora_options_init(tab.parents('.ancora_shortcodes_tab').find('.ancora_options_tab_content').eq(idx));
	tab.prev().find('a').trigger('click');
}



// Show one field layout
function ancora_shortcodes_show_field(field, tab_idx) {
	"use strict";
	
	// html output
	var output = '';

	// Parse field params
	for (var clone_num in field['params']) {
		var tab_id = 'tab_' + (parseInt(tab_idx) + parseInt(clone_num));
		output += '<div id="ancora_shortcodes_' + tab_id + '_content" class="ancora_options_content ancora_options_tab_content">';

		for (var param_num in field['params'][clone_num]) {
			
			var param = field['params'][clone_num][param_num];
			var id = tab_id + '_' + param_num;
	
			// Divider after field
			var divider = ancora_isset(param['divider']) && param['divider'] ? ' ancora_options_divider' : '';
		
			// Setup default parameters
			if (param['type']=='media') {
				if (!ancora_isset(param['before'])) {
					param['before'] = {
						'title': 'Choose image',
						'action': 'media_upload',
						'type': 'image',
						'multiple': false,
						'linked_field': '',
						'captions': { 	
							'choose': 'Choose image',
							'update': 'Select image'
							}
					};
				}
				if (!ancora_isset(param['after'])) {
					param['after'] = {
						'icon': 'iconadmin-delete',
						'action': 'media_reset'
					};
				}
			}
		
			// Buttons before and after field
			var before = '', after = '', buttons_classes = '', rez, rez2, i, key, opt;
			
			if (ancora_isset(param['before'])) {
				rez = ancora_shortcodes_action_button(param['before'], 'before');
				before = rez[0];
				buttons_classes += rez[1];
			}
			if (ancora_isset(param['after'])) {
				rez = ancora_shortcodes_action_button(param['after'], 'after');
				after = rez[0];
				buttons_classes += rez[1];
			}
			if (ancora_in_array(param['type'], ['list', 'select', 'fonts']) || (param['type']=='socials' && (ancora_empty(param['style']) || param['style']=='icons'))) {
				buttons_classes += ' ancora_options_button_after_small';
			}

			if (param['type'] != 'hidden') {
				output += '<div class="ancora_options_field'
					+ ' ancora_options_field_' + (ancora_in_array(param['type'], ['list','fonts']) ? 'select' : param['type'])
					+ (ancora_in_array(param['type'], ['media', 'fonts', 'list', 'select', 'socials', 'date', 'time']) ? ' ancora_options_field_text'  : '')
					+ (param['type']=='socials' && !ancora_empty(param['style']) && param['style']=='images' ? ' ancora_options_field_images'  : '')
					+ (param['type']=='socials' && (ancora_empty(param['style']) || param['style']=='icons') ? ' ancora_options_field_icons'  : '')
					+ (ancora_isset(param['dir']) && param['dir']=='vertical' ? ' ancora_options_vertical' : '')
					+ (!ancora_empty(param['multiple']) ? ' ancora_options_multiple' : '')
					+ (ancora_isset(param['size']) ? ' ancora_options_size_'+param['size'] : '')
					+ (ancora_isset(param['class']) ? ' ' + param['class'] : '')
					+ divider 
					+ '">' 
					+ "\n"
					+ '<label class="ancora_options_field_label" for="' + id + '">' + param['title']
					+ '</label>'
					+ "\n"
					+ '<div class="ancora_options_field_content'
					+ buttons_classes
					+ '">'
					+ "\n";
			}
			
			if (!ancora_isset(param['value'])) {
				param['value'] = '';
			}
			

			switch ( param['type'] ) {
	
			case 'hidden':
				output += '<input class="ancora_options_input ancora_options_input_hidden" name="' + id + '" id="' + id + '" type="hidden" value="' + ancora_shortcodes_prepare_value(param['value']) + '" data-param="' + ancora_shortcodes_prepare_value(param_num) + '" />';
			break;

			case 'date':
				if (ancora_isset(param['style']) && param['style']=='inline') {
					output += '<div class="ancora_options_input_date"'
						+ ' id="' + id + '_calendar"'
						+ ' data-format="' + (!ancora_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!ancora_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-linked-field="' + (!ancora_empty(data['linked_field']) ? data['linked_field'] : id) + '"'
						+ '></div>'
						+ '<input id="' + id + '"'
							+ ' name="' + id + '"'
							+ ' type="hidden"'
							+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
							+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
							+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
							+ ' />';
				} else {
					output += '<input class="ancora_options_input ancora_options_input_date' + (!ancora_empty(param['mask']) ? ' ancora_options_input_masked' : '') + '"'
						+ ' name="' + id + '"'
						+ ' id="' + id + '"'
						+ ' type="text"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-format="' + (!ancora_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!ancora_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
						+ before 
						+ after;
				}
			break;

			case 'text':
				output += '<input class="ancora_options_input ancora_options_input_text' + (!ancora_empty(param['mask']) ? ' ancora_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
					+ (!ancora_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
				+ before 
				+ after;
			break;
		
			case 'textarea':
				var cols = ancora_isset(param['cols']) && param['cols'] > 10 ? param['cols'] : '40';
				var rows = ancora_isset(param['rows']) && param['rows'] > 1 ? param['rows'] : '8';
				output += '<textarea class="ancora_options_input ancora_options_input_textarea"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' cols="' + cols + '"'
					+ ' rows="' + rows + '"'
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ '>'
					+ param['value']
					+ '</textarea>';
			break;

			case 'spinner':
				output += '<input class="ancora_options_input ancora_options_input_spinner' + (!ancora_empty(param['mask']) ? ' ancora_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
					+ (!ancora_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ (ancora_isset(param['min']) ? ' data-min="'+param['min']+'"' : '')
					+ (ancora_isset(param['max']) ? ' data-max="'+param['max']+'"' : '')
					+ (!ancora_empty(param['step']) ? ' data-step="'+param['step']+'"' : '')
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />' 
					+ '<span class="ancora_options_arrows"><span class="ancora_options_arrow_up iconadmin-up-dir"></span><span class="ancora_options_arrow_down iconadmin-down-dir"></span></span>';
			break;

			case 'tags':
				var tags = param['value'].split(ANCORA_GLOBALS['shortcodes_delimiter']);
				if (tags.length > 0) {
					for (i=0; i<tags.length; i++) {
						if (ancora_empty(tags[i])) continue;
						output += '<span class="ancora_options_tag iconadmin-delete">' + tags[i] + '</span>';
					}
				}
				output += '<input class="ancora_options_input_tags"'
					+ ' type="text"'
					+ ' value=""'
					+ ' />'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case "checkbox": 
				output += '<input type="checkbox" class="ancora_options_input ancora_options_input_checkbox"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' value="true"' 
					+ (param['value'] == 'true' ? ' checked="checked"' : '') 
					+ (!ancora_empty(param['disabled']) ? ' readonly="readonly"' : '')
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<label for="' + id + '" class="' + (!ancora_empty(param['disabled']) ? 'ancora_options_state_disabled' : '') + (param['value']=='true' ? ' ancora_options_state_checked' : '') + '"><span class="ancora_options_input_checkbox_image iconadmin-check"></span>' + (!ancora_empty(param['label']) ? param['label'] : param['title']) + '</label>';
			break;
		
			case "radio":
				for (key in param['options']) { 
					output += '<span class="ancora_options_radioitem"><input class="ancora_options_input ancora_options_input_radio" type="radio"'
						+ ' name="' + id + '"'
						+ ' value="' + ancora_shortcodes_prepare_value(key) + '"'
						+ ' data-value="' + ancora_shortcodes_prepare_value(key) + '"'
						+ (param['value'] == key ? ' checked="checked"' : '') 
						+ ' id="' + id + '_' + key + '"'
						+ ' />'
						+ '<label for="' + id + '_' + key + '"' + (param['value'] == key ? ' class="ancora_options_state_checked"' : '') + '><span class="ancora_options_input_radio_image iconadmin-circle-empty' + (param['value'] == key ? ' iconadmin-dot-circled' : '') + '"></span>' + param['options'][key] + '</label></span>';
				}
				output += '<input type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';

			break;
		
			case "switch":
				opt = [];
				i = 0;
				for (key in param['options']) {
					opt[i++] = {'key': key, 'title': param['options'][key]};
					if (i==2) break;
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + ancora_shortcodes_prepare_value(ancora_empty(param['value']) ? opt[0]['key'] : param['value']) + '"'
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<span class="ancora_options_switch' + (param['value']==opt[1]['key'] ? ' ancora_options_state_off' : '') + '"><span class="ancora_options_switch_inner iconadmin-circle"><span class="ancora_options_switch_val1" data-value="' + opt[0]['key'] + '">' + opt[0]['title'] + '</span><span class="ancora_options_switch_val2" data-value="' + opt[1]['key'] + '">' + opt[1]['title'] + '</span></span></span>';
			break;

			case 'media':
				output += '<input class="ancora_options_input ancora_options_input_text ancora_options_input_media"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
					+ (!ancora_isset(param['readonly']) || param['readonly'] ? ' readonly="readonly"' : '')
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ before 
					+ after;
				if (!ancora_empty(param['value'])) {
					var fname = ancora_get_file_name(param['value']);
					var fext  = ancora_get_file_ext(param['value']);
					output += '<a class="ancora_options_image_preview" rel="prettyPhoto" target="_blank" href="' + param['value'] + '">' + (fext!='' && ancora_in_list('jpg,png,gif', fext, ',') ? '<img src="'+param['value']+'" alt="" />' : '<span>'+fname+'</span>') + '</a>';
				}
			break;
		
			case 'button':
				rez = ancora_shortcodes_action_button(param, 'button');
				output += rez[0];
			break;

			case 'range':
				output += '<div class="ancora_options_input_range" data-step="'+(!ancora_empty(param['step']) ? param['step'] : 1) + '">'
					+ '<span class="ancora_options_range_scale"><span class="ancora_options_range_scale_filled"></span></span>';
				if (param['value'].toString().indexOf(ANCORA_GLOBALS['shortcodes_delimiter']) == -1)
					param['value'] = Math.min(param['max'], Math.max(param['min'], param['value']));
				var sliders = param['value'].toString().split(ANCORA_GLOBALS['shortcodes_delimiter']);
				for (i=0; i<sliders.length; i++) {
					output += '<span class="ancora_options_range_slider"><span class="ancora_options_range_slider_value">' + sliders[i] + '</span><span class="ancora_options_range_slider_button"></span></span>';
				}
				output += '<span class="ancora_options_range_min">' + param['min'] + '</span><span class="ancora_options_range_max">' + param['max'] + '</span>'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
					+ '</div>';			
			break;
		
			case "checklist":
				for (key in param['options']) { 
					output += '<span class="ancora_options_listitem'
						+ (ancora_in_list(param['value'], key, ANCORA_GLOBALS['shortcodes_delimiter']) ? ' ancora_options_state_checked' : '') + '"'
						+ ' data-value="' + ancora_shortcodes_prepare_value(key) + '"'
						+ '>'
						+ param['options'][key]
						+ '</span>';
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />';
			break;
		
			case 'fonts':
				for (key in param['options']) {
					param['options'][key] = key;
				}
			case 'list':
			case 'select':
				if (!ancora_isset(param['options']) && !ancora_empty(param['from']) && !ancora_empty(param['to'])) {
					param['options'] = [];
					for (i = param['from']; i <= param['to']; i+=(!ancora_empty(param['step']) ? param['step'] : 1)) {
						param['options'][i] = i;
					}
				}
				rez = ancora_shortcodes_menu_list(param);
				if (ancora_empty(param['style']) || param['style']=='select') {
					output += '<input class="ancora_options_input ancora_options_input_select" type="text" value="' + ancora_shortcodes_prepare_value(rez[1]) + '"'
						+ ' readonly="readonly"'
						//+ (!ancora_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
						+ ' />'
						+ '<span class="ancora_options_field_after ancora_options_with_action iconadmin-down-open" onchange="ancora_options_action_show_menu(this);return false;"></span>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'images':
				rez = ancora_shortcodes_menu_list(param);
				if (ancora_empty(param['style']) || param['style']=='select') {
					output += '<div class="ancora_options_caption_image iconadmin-down-open">'
						//+'<img src="' + rez[1] + '" alt="" />'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case 'icons':
				rez = ancora_shortcodes_menu_list(param);
				if (ancora_empty(param['style']) || param['style']=='select') {
					output += '<div class="ancora_options_caption_icon iconadmin-down-open"><span class="' + rez[1] + '"></span></div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
						+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'socials':
				if (!ancora_is_object(param['value'])) param['value'] = {'url': '', 'icon': ''};
				rez = ancora_shortcodes_menu_list(param);
				if (ancora_empty(param['style']) || param['style']=='icons') {
					rez2 = ancora_shortcodes_action_button({
						'action': ancora_empty(param['style']) || param['style']=='icons' ? 'select_icon' : '',
						'icon': (ancora_empty(param['style']) || param['style']=='icons') && !ancora_empty(param['value']['icon']) ? param['value']['icon'] : 'iconadmin-users'
						}, 'after');
				} else
					rez2 = ['', ''];
				output += '<input class="ancora_options_input ancora_options_input_text ancora_options_input_socials'
					+ (!ancora_empty(param['mask']) ? ' ancora_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text" value="' + ancora_shortcodes_prepare_value(param['value']['url']) + '"'
					+ (!ancora_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ rez2[0];
				if (!ancora_empty(param['style']) && param['style']=='images') {
					output += '<div class="ancora_options_caption_image iconadmin-down-open">'
						//+'<img src="' + rez[1] + '" alt="" />'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '_icon' + '" type="hidden" value="' + ancora_shortcodes_prepare_value(param['value']['icon']) + '" />';
			break;

			case "color":
                var cp_style = ANCORA_GLOBALS['shortcodes_cp']=='internal'
                    ? 'custom'
                    : (ancora_isset(param['style'])
                        ? param['style']
                        : 'wp');
                output += '<input class="ancora_options_input ancora_options_input_color ancora_options_input_color_'+cp_style+'"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + ancora_shortcodes_prepare_value(param['value']) + '"'
					+ ' data-param="' + ancora_shortcodes_prepare_value(param_num) + '"'
					+ (!ancora_empty(param['action']) ? ' onchange="ancora_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ (cp_style=='custom' ? '<span class="iColorPicker"></span>' : '');
			break;   
	
			}

			if (param['type'] != 'hidden') {
				output += '</div>';
				if (!ancora_empty(param['desc']))
					output += '<div class="ancora_options_desc">' + param['desc'] + '</div>' + "\n";
				output += '</div>' + "\n";
			}

		}

		output += '</div>';
	}

	
	return output;
}



// Return menu items list (menu, images or icons)
function ancora_shortcodes_menu_list(field) {
	"use strict";
	if (field['type'] == 'socials') field['value'] = field['value']['icon'];
	var list = '<div class="ancora_options_input_menu ' + (ancora_empty(field['style']) ? '' : ' ancora_options_input_menu_' + field['style']) + '">';
	var caption = '';
	for (var key in field['options']) {
		var value = field['options'][key];
		if (ancora_in_array(field['type'], ['list', 'icons', 'socials'])) key = value;
		var selected = '';
		if (ancora_in_list(field['value'], key, ANCORA_GLOBALS['shortcodes_delimiter'])) {
			caption = value;
			selected = ' ancora_options_state_checked';
		}
		list += '<span class="ancora_options_menuitem'
			+ selected 
			+ '" data-value="' + ancora_shortcodes_prepare_value(key) + '"'
			+ '>';
		if (ancora_in_array(field['type'], ['list', 'select', 'fonts']))
			list += value;
		else if (field['type'] == 'icons' || (field['type'] == 'socials' && field['style'] == 'icons'))
			list += '<span class="' + value + '"></span>';
		else if (field['type'] == 'images' || (field['type'] == 'socials' && field['style'] == 'images'))
			//list += '<img src="' + value + '" data-icon="' + key + '" alt="" class="ancora_options_input_image" />';
			list += '<span style="background-image:url(' + value + ')" data-src="' + value + '" data-icon="' + key + '" class="ancora_options_input_image"></span>';
		list += '</span>';
	}
	list += '</div>';
	return [list, caption];
}



// Return action button
function ancora_shortcodes_action_button(data, type) {
	"use strict";
	var class_name = ' ancora_options_button_' + type + (ancora_empty(data['title']) ? ' ancora_options_button_'+type+'_small' : '');
	var output = '<span class="' 
				+ (type == 'button' ? 'ancora_options_input_button'  : 'ancora_options_field_'+type)
				+ (!ancora_empty(data['action']) ? ' ancora_options_with_action' : '')
				+ (!ancora_empty(data['icon']) ? ' '+data['icon'] : '')
				+ '"'
				+ (!ancora_empty(data['icon']) && !ancora_empty(data['title']) ? ' title="'+ancora_shortcodes_prepare_value(data['title'])+'"' : '')
				+ (!ancora_empty(data['action']) ? ' onclick="ancora_options_action_'+data['action']+'(this);return false;"' : '')
				+ (!ancora_empty(data['type']) ? ' data-type="'+data['type']+'"' : '')
				+ (!ancora_empty(data['multiple']) ? ' data-multiple="'+data['multiple']+'"' : '')
				+ (!ancora_empty(data['linked_field']) ? ' data-linked-field="'+data['linked_field']+'"' : '')
				+ (!ancora_empty(data['captions']) && !ancora_empty(data['captions']['choose']) ? ' data-caption-choose="'+ancora_shortcodes_prepare_value(data['captions']['choose'])+'"' : '')
				+ (!ancora_empty(data['captions']) && !ancora_empty(data['captions']['update']) ? ' data-caption-update="'+ancora_shortcodes_prepare_value(data['captions']['update'])+'"' : '')
				+ '>'
				+ (type == 'button' || (ancora_empty(data['icon']) && !ancora_empty(data['title'])) ? data['title'] : '')
				+ '</span>';
	return [output, class_name];
}

// Prepare string to insert as parameter's value
function ancora_shortcodes_prepare_value(val) {
	return typeof val == 'string' ? val.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;') : val;
}
