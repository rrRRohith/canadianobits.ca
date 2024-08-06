<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'ancora_shortcodes_is_used' ) ) {
	function ancora_shortcodes_is_used() {
		return ancora_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| ancora_vc_is_frontend();															// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'ancora_shortcodes_width' ) ) {
	function ancora_shortcodes_width($w="") {
		return array(
			"title" => __("Width", 'ancora-utils'),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'ancora_shortcodes_height' ) ) {
	function ancora_shortcodes_height($h='') {
		return array(
			"title" => __("Height", 'ancora-utils'),
			"desc" => __("Width (in pixels or percent) and height (only in pixels) of element", 'ancora-utils'),
			"value" => $h,
			"type" => "text"
		);
	}
}

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_shortcodes_settings_theme_setup' ) ) {
//	if ( ancora_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'ancora_action_before_init_theme', 'ancora_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'ancora_action_after_init_theme', 'ancora_shortcodes_settings_theme_setup' );
	function ancora_shortcodes_settings_theme_setup() {
		if (ancora_shortcodes_is_used()) {
			global $ANCORA_GLOBALS;

			// Prepare arrays 
			$ANCORA_GLOBALS['sc_params'] = array(
			
				// Current element id
				'id' => array(
					"title" => __("Element ID", 'ancora-utils'),
					"desc" => __("ID for current element", 'ancora-utils'),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => __("Element CSS class", 'ancora-utils'),
					"desc" => __("CSS class for current element (optional)", 'ancora-utils'),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => __("CSS styles", 'ancora-utils'),
					"desc" => __("Any additional CSS rules (if need)", 'ancora-utils'),
					"value" => "",
					"type" => "text"
				),
			
				// Margins params
				'top' => array(
					"title" => __("Top margin", 'ancora-utils'),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				'bottom' => array(
					"title" => __("Bottom margin", 'ancora-utils'),
					"value" => "",
					"type" => "text"
				),
			
				'left' => array(
					"title" => __("Left margin", 'ancora-utils'),
					"value" => "",
					"type" => "text"
				),
			
				'right' => array(
					"title" => __("Right margin", 'ancora-utils'),
					"desc" => __("Margins around list (in pixels).", 'ancora-utils'),
					"value" => "",
					"type" => "text"
				),
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> __('Unordered', 'ancora-utils'),
					'ol'	=> __('Ordered', 'ancora-utils'),
					'iconed'=> __('Iconed', 'ancora-utils')
				),
				'yes_no'	=> ancora_get_list_yesno(),
				'on_off'	=> ancora_get_list_onoff(),
				'dir' 		=> ancora_get_list_directions(),
				'align'		=> ancora_get_list_alignments(),
				'float'		=> ancora_get_list_floats(),
				'show_hide'	=> ancora_get_list_showhide(),
				'sorting' 	=> ancora_get_list_sortings(),
				'ordering' 	=> ancora_get_list_orderings(),
				'sliders'	=> ancora_get_list_sliders(),
				'users'		=> ancora_get_list_users(),
				'members'	=> ancora_get_list_posts(false, array('post_type'=>'team', 'orderby'=>'title', 'order'=>'asc', 'return'=>'title')),
				'categories'=> ancora_get_list_categories(),
				'testimonials_groups'=> ancora_get_list_terms(false, 'testimonial_group'),
				'team_groups'=> ancora_get_list_terms(false, 'team_group'),
				'columns'	=> ancora_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), ancora_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), ancora_get_list_icons()),
				'locations'	=> ancora_get_list_dedicated_locations(),
				'filters'	=> ancora_get_list_portfolio_filters(),
				'formats'	=> ancora_get_list_post_formats_filters(),
				'hovers'	=> ancora_get_list_hovers(),
				'hovers_dir'=> ancora_get_list_hovers_directions(),
				'tint'		=> ancora_get_list_bg_tints(),
				'animations'=> ancora_get_list_animations_in(),
				'blogger_styles'	=> ancora_get_list_templates_blogger(),
				'posts_types'		=> ancora_get_list_posts_types(),
				'button_styles'		=> ancora_get_list_button_styles(),
				'googlemap_styles'	=> ancora_get_list_googlemap_styles(),
				'field_types'		=> ancora_get_list_field_types(),
				'label_positions'	=> ancora_get_list_label_positions()
			);

			$ANCORA_GLOBALS['sc_params']['animation'] = array(
				"title" => __("Animation",  'ancora-utils'),
				"desc" => __('Select animation while object enter in the visible area of page',  'ancora-utils'),
				"value" => "none",
				"type" => "select",
				"options" => $ANCORA_GLOBALS['sc_params']['animations']
			);
	
			// Shortcodes list
			//------------------------------------------------------------------
			$ANCORA_GLOBALS['shortcodes'] = array(
			
				// Accordion
				"trx_accordion" => array(
					"title" => __("Accordion", 'ancora-utils'),
					"desc" => __("Accordion items", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Accordion style", 'ancora-utils'),
							"desc" => __("Select style for display accordion", 'ancora-utils'),
							"value" => 1,
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils')
							),
							"type" => "radio"
						),
						"counter" => array(
							"title" => __("Counter", 'ancora-utils'),
							"desc" => __("Display counter before each accordion title", 'ancora-utils'),
							"value" => "off",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['on_off']
						),
						"initial" => array(
							"title" => __("Initially opened item", 'ancora-utils'),
							"desc" => __("Number of initially opened item", 'ancora-utils'),
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"icon_closed" => array(
							"title" => __("Icon while closed",  'ancora-utils'),
							"desc" => __('Select icon for the closed accordion item from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => __("Icon while opened",  'ancora-utils'),
							"desc" => __('Select icon for the opened accordion item from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_accordion_item",
						"title" => __("Item", 'ancora-utils'),
						"desc" => __("Accordion item", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Accordion item title", 'ancora-utils'),
								"desc" => __("Title for current accordion item", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"icon_closed" => array(
								"title" => __("Icon while closed",  'ancora-utils'),
								"desc" => __('Select icon for the closed accordion item from Fontello icons set',  'ancora-utils'),
								"value" => "",
								"type" => "icons",
								"options" => $ANCORA_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => __("Icon while opened",  'ancora-utils'),
								"desc" => __('Select icon for the opened accordion item from Fontello icons set',  'ancora-utils'),
								"value" => "",
								"type" => "icons",
								"options" => $ANCORA_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => __("Accordion item content", 'ancora-utils'),
								"desc" => __("Current accordion item content", 'ancora-utils'),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Anchor
				"trx_anchor" => array(
					"title" => __("Anchor", 'ancora-utils'),
					"desc" => __("Insert anchor for the TOC (table of content)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => __("Anchor's icon",  'ancora-utils'),
							"desc" => __('Select icon for the anchor from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"title" => array(
							"title" => __("Short title", 'ancora-utils'),
							"desc" => __("Short title of the anchor (for the table of content)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => __("Long description", 'ancora-utils'),
							"desc" => __("Description for the popup (then hover on the icon). You can use '{' and '}' - make the text italic, '|' - insert line break", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"url" => array(
							"title" => __("External URL", 'ancora-utils'),
							"desc" => __("External URL for this TOC item", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"separator" => array(
							"title" => __("Add separator", 'ancora-utils'),
							"desc" => __("Add separator under item in the TOC", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"id" => $ANCORA_GLOBALS['sc_params']['id']
					)
				),
			
			
				// Audio
				"trx_audio" => array(
					"title" => __("Audio", 'ancora-utils'),
					"desc" => __("Insert audio player", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for audio file", 'ancora-utils'),
							"desc" => __("URL for audio file", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose audio', 'ancora-utils'),
								'action' => 'media_upload',
								'type' => 'audio',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose audio file', 'ancora-utils'),
									'update' => __('Select audio file', 'ancora-utils')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
                        "style" => array(
                            "title" => __("Style", 'ancora-utils'),
                            "desc" => __("Select style", 'ancora-utils'),
                            "value" => "none",
                            "type" => "checklist",
                            "dir" => "horizontal",
                            "options" => array('audio_normal' => 'Normal', 'audio_dark' => 'Dark'),
                        ),
						"image" => array(
							"title" => __("Cover image", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for audio cover", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Title of the audio file", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"author" => array(
							"title" => __("Author", 'ancora-utils'),
							"desc" => __("Author of the audio file", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => __("Show controls", 'ancora-utils'),
							"desc" => __("Show controls in audio player", 'ancora-utils'),
							"divider" => true,
							"size" => "medium",
							"value" => "show",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['show_hide']
						),
						"autoplay" => array(
							"title" => __("Autoplay audio", 'ancora-utils'),
							"desc" => __("Autoplay audio on page load", 'ancora-utils'),
							"value" => "off",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select block alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Block
				"trx_block" => array(
					"title" => __("Block container", 'ancora-utils'),
					"desc" => __("Container for any block ([section] analog - to enable nesting)", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => __("Dedicated", 'ancora-utils'),
							"desc" => __("Use this block as dedicated content - show it before post title on single page", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select block alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => __("Columns emulation", 'ancora-utils'),
							"desc" => __("Select width for columns emulation", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => __("Use pan effect", 'ancora-utils'),
							"desc" => __("Use pan effect to show section content", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => __("Use scroller", 'ancora-utils'),
							"desc" => __("Use scroller to show section content", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => __("Scroll direction", 'ancora-utils'),
							"desc" => __("Scroll direction (if Use scroller = yes)", 'ancora-utils'),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => __("Scroll controls", 'ancora-utils'),
							"desc" => __("Show scroll controls (if Use scroller = yes)", 'ancora-utils'),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"color" => array(
							"title" => __("Fore color", 'ancora-utils'),
							"desc" => __("Any color for objects in this section", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Background tint", 'ancora-utils'),
							"desc" => __("Main background tint: dark or light", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Any background color for this section", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", 'ancora-utils'),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", 'ancora-utils'),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", 'ancora-utils'),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => __("Font size", 'ancora-utils'),
							"desc" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", 'ancora-utils'),
							"desc" => __("Font weight of the text", 'ancora-utils'),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'ancora-utils'),
								'300' => __('Light (300)', 'ancora-utils'),
								'400' => __('Normal (400)', 'ancora-utils'),
								'700' => __('Bold (700)', 'ancora-utils')
							)
						),
						"_content_" => array(
							"title" => __("Container content", 'ancora-utils'),
							"desc" => __("Content for section container", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Blogger
				"trx_blogger" => array(
					"title" => __("Blogger", 'ancora-utils'),
					"desc" => __("Insert posts (pages) in many styles from desired categories or directly from ids", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Posts output style", 'ancora-utils'),
							"desc" => __("Select desired style for posts output", 'ancora-utils'),
							"value" => "regular",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['blogger_styles']
						),
						"filters" => array(
							"title" => __("Show filters", 'ancora-utils'),
							"desc" => __("Use post's tags or categories as filter buttons", 'ancora-utils'),
							"value" => "no",
							"dir" => "horizontal",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['filters']
						),
						"hover" => array(
							"title" => __("Hover effect", 'ancora-utils'),
							"desc" => __("Select hover effect (only if style=Portfolio)", 'ancora-utils'),
							"dependency" => array(
								'style' => array('portfolio','grid','square','courses')
							),
							"value" => "",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['hovers']
						),
						"hover_dir" => array(
							"title" => __("Hover direction", 'ancora-utils'),
							"desc" => __("Select hover direction (only if style=Portfolio and hover=Circle|Square)", 'ancora-utils'),
							"dependency" => array(
								'style' => array('portfolio','grid','square','courses'),
								'hover' => array('square','circle')
							),
							"value" => "left_to_right",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['hovers_dir']
						),
						"dir" => array(
							"title" => __("Posts direction", 'ancora-utils'),
							"desc" => __("Display posts in horizontal or vertical direction", 'ancora-utils'),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['dir']
						),
						"post_type" => array(
							"title" => __("Post type", 'ancora-utils'),
							"desc" => __("Select post type to show", 'ancora-utils'),
							"value" => "post",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['posts_types']
						),
						"ids" => array(
							"title" => __("Post IDs list", 'ancora-utils'),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"cat" => array(
							"title" => __("Categories list", 'ancora-utils'),
							"desc" => __("Select the desired categories. If not selected - show posts from any category or from IDs list", 'ancora-utils'),
							"dependency" => array(
								'ids' => array('is_empty'),
								'post_type' => array('refresh')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $ANCORA_GLOBALS['sc_params']['categories']
						),
						"count" => array(
							"title" => __("Total posts to show", 'ancora-utils'),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", 'ancora-utils'),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns number", 'ancora-utils'),
							"desc" => __("How many columns used to show posts? If empty or 0 - equal to posts number", 'ancora-utils'),
							"dependency" => array(
								'dir' => array('horizontal')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", 'ancora-utils'),
							"desc" => __("Skip posts before select next part.", 'ancora-utils'),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", 'ancora-utils'),
							"desc" => __("Select desired posts sorting method", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", 'ancora-utils'),
							"desc" => __("Select desired posts order", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"only" => array(
							"title" => __("Select posts only", 'ancora-utils'),
							"desc" => __("Select posts only with reviews, videos, audios, thumbs or galleries", 'ancora-utils'),
							"value" => "no",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['formats']
						),
						"scroll" => array(
							"title" => __("Use scroller", 'ancora-utils'),
							"desc" => __("Use scroller to show all posts", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"controls" => array(
							"title" => __("Show slider controls", 'ancora-utils'),
							"desc" => __("Show arrows to control scroll slider", 'ancora-utils'),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"location" => array(
							"title" => __("Dedicated content location", 'ancora-utils'),
							"desc" => __("Select position for dedicated content (only for style=excerpt)", 'ancora-utils'),
							"divider" => true,
							"dependency" => array(
								'style' => array('excerpt')
							),
							"value" => "default",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['locations']
						),
						"rating" => array(
							"title" => __("Show rating stars", 'ancora-utils'),
							"desc" => __("Show rating stars under post's header", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"info" => array(
							"title" => __("Show post info block", 'ancora-utils'),
							"desc" => __("Show post info block (author, date, tags, etc.)", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"links" => array(
							"title" => __("Allow links on the post", 'ancora-utils'),
							"desc" => __("Allow links on the post from each blogger item", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"descr" => array(
							"title" => __("Description length", 'ancora-utils'),
							"desc" => __("How many characters are displayed from post excerpt? If 0 - don't show description", 'ancora-utils'),
							"value" => 0,
							"min" => 0,
							"step" => 10,
							"type" => "spinner"
						),
						"readmore" => array(
							"title" => __("More link text", 'ancora-utils'),
							"desc" => __("Read more link text. If empty - show 'More', else - used as link text", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Br
				"trx_br" => array(
					"title" => __("Break", 'ancora-utils'),
					"desc" => __("Line break with clear floating (if need)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"clear" => 	array(
							"title" => __("Clear floating", 'ancora-utils'),
							"desc" => __("Clear floating (if need)", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"options" => array(
								'none' => __('None', 'ancora-utils'),
								'left' => __('Left', 'ancora-utils'),
								'right' => __('Right', 'ancora-utils'),
								'both' => __('Both', 'ancora-utils')
							)
						)
					)
				),
			
			
			
			
				// Button
				"trx_button" => array(
					"title" => __("Button", 'ancora-utils'),
					"desc" => __("Button with link", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Caption", 'ancora-utils'),
							"desc" => __("Button caption", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"type" => array(
							"title" => __("Button's shape", 'ancora-utils'),
							"desc" => __("Select button's shape", 'ancora-utils'),
							"value" => "square",
							"size" => "medium",
							"options" => array(
								'square' => __('Square', 'ancora-utils'),
								'round' => __('Round', 'ancora-utils')
							),
							"type" => "switch"
						), 
						"style" => array(
							"title" => __("Button's style", 'ancora-utils'),
							"desc" => __("Select button's style", 'ancora-utils'),
							"value" => "default",
							"dir" => "horizontal",
							"options" => array(
								'dark' => __('Dark', 'ancora-utils'),
								'light' => __('Light', 'ancora-utils'),
                                'global' => __('Global', 'ancora-utils')
							),
							"type" => "checklist"
						), 
						"size" => array(
							"title" => __("Button's size", 'ancora-utils'),
							"desc" => __("Select button's size", 'ancora-utils'),
							"value" => "small",
							"dir" => "horizontal",
							"options" => array(
								'small' => __('Small', 'ancora-utils'),
								'medium' => __('Medium', 'ancora-utils'),
								'large' => __('Large', 'ancora-utils')
							),
							"type" => "checklist"
						), 
						"icon" => array(
							"title" => __("Button's icon",  'ancora-utils'),
							"desc" => __('Select icon for the title from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"bg_style" => array(
							"title" => __("Button's color scheme", 'ancora-utils'),
							"desc" => __("Select button's color scheme", 'ancora-utils'),
							"value" => "custom",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['button_styles']
						), 
						"color" => array(
							"title" => __("Button's text color", 'ancora-utils'),
							"desc" => __("Any color for button's caption", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Button's backcolor", 'ancora-utils'),
							"desc" => __("Any color for button's background", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"align" => array(
							"title" => __("Button's alignment", 'ancora-utils'),
							"desc" => __("Align button to left, center or right", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => __("Link URL", 'ancora-utils'),
							"desc" => __("URL for link on button click", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"target" => array(
							"title" => __("Link target", 'ancora-utils'),
							"desc" => __("Target for link on button click", 'ancora-utils'),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"popup" => array(
							"title" => __("Open link in popup", 'ancora-utils'),
							"desc" => __("Open link target in popup window", 'ancora-utils'),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						), 
						"rel" => array(
							"title" => __("Rel attribute", 'ancora-utils'),
							"desc" => __("Rel attribute for button's link (if need)", 'ancora-utils'),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Chat
				"trx_chat" => array(
					"title" => __("Chat", 'ancora-utils'),
					"desc" => __("Chat message", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => __("Item title", 'ancora-utils'),
							"desc" => __("Chat item title", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"photo" => array(
							"title" => __("Item photo", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the item photo (avatar)", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"link" => array(
							"title" => __("Item link", 'ancora-utils'),
							"desc" => __("Chat item link", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Chat item content", 'ancora-utils'),
							"desc" => __("Current chat item content", 'ancora-utils'),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Columns
				"trx_columns" => array(
					"title" => __("Columns", 'ancora-utils'),
					"desc" => __("Insert up to 5 columns in your page (post)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"fluid" => array(
							"title" => __("Fluid columns", 'ancora-utils'),
							"desc" => __("To squeeze the columns when reducing the size of the window (fluid=yes) or to rebuild them (fluid=no)", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						), 
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_column_item",
						"title" => __("Column", 'ancora-utils'),
						"desc" => __("Column item", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"span" => array(
								"title" => __("Merge columns", 'ancora-utils'),
								"desc" => __("Count merged columns from current", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"align" => array(
								"title" => __("Alignment", 'ancora-utils'),
								"desc" => __("Alignment text in the column", 'ancora-utils'),
								"value" => "",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $ANCORA_GLOBALS['sc_params']['align']
							),
							"color" => array(
								"title" => __("Fore color", 'ancora-utils'),
								"desc" => __("Any color for objects in this column", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => __("Background color", 'ancora-utils'),
								"desc" => __("Any background color for this column", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"bg_image" => array(
								"title" => __("URL for background image file", 'ancora-utils'),
								"desc" => __("Select or upload image or write URL from other site for the background", 'ancora-utils'),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => __("Column item content", 'ancora-utils'),
								"desc" => __("Current column item content", 'ancora-utils'),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Contact form
				"trx_contact_form" => array(
					"title" => __("Contact form", 'ancora-utils'),
					"desc" => __("Insert contact form", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"custom" => array(
							"title" => __("Custom", 'ancora-utils'),
							"desc" => __("Use custom fields or create standard contact form (ignore info from 'Field' tabs)", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						), 
						"action" => array(
							"title" => __("Action", 'ancora-utils'),
							"desc" => __("Contact form action (URL to handle form data). If empty - use internal action", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select form alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Contact form title", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => __("Description", 'ancora-utils'),
							"desc" => __("Short description for contact form", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_form_item",
						"title" => __("Field", 'ancora-utils'),
						"desc" => __("Custom field", 'ancora-utils'),
						"container" => false,
						"params" => array(
							"type" => array(
								"title" => __("Type", 'ancora-utils'),
								"desc" => __("Type of the custom field", 'ancora-utils'),
								"value" => "text",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $ANCORA_GLOBALS['sc_params']['field_types']
							), 
							"name" => array(
								"title" => __("Name", 'ancora-utils'),
								"desc" => __("Name of the custom field", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => __("Default value", 'ancora-utils'),
								"desc" => __("Default value of the custom field", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"label" => array(
								"title" => __("Label", 'ancora-utils'),
								"desc" => __("Label for the custom field", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"label_position" => array(
								"title" => __("Label position", 'ancora-utils'),
								"desc" => __("Label position relative to the field", 'ancora-utils'),
								"value" => "top",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $ANCORA_GLOBALS['sc_params']['label_positions']
							), 
							"top" => $ANCORA_GLOBALS['sc_params']['top'],
							"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
							"left" => $ANCORA_GLOBALS['sc_params']['left'],
							"right" => $ANCORA_GLOBALS['sc_params']['right'],
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Content block on fullscreen page
				"trx_content" => array(
					"title" => __("Content block", 'ancora-utils'),
					"desc" => __("Container for main content block with desired class and style (use it only on fullscreen pages)", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Container content", 'ancora-utils'),
							"desc" => __("Content for section container", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Countdown
				"trx_countdown" => array(
					"title" => __("Countdown", 'ancora-utils'),
					"desc" => __("Insert countdown object", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"date" => array(
							"title" => __("Date", 'ancora-utils'),
							"desc" => __("Upcoming date (format: yyyy-mm-dd)", 'ancora-utils'),
							"value" => "",
							"format" => "yy-mm-dd",
							"type" => "date"
						),
						"time" => array(
							"title" => __("Time", 'ancora-utils'),
							"desc" => __("Upcoming time (format: HH:mm:ss)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => __("Style", 'ancora-utils'),
							"desc" => __("Countdown style", 'ancora-utils'),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils')
							)
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Align counter to left, center or right", 'ancora-utils'),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Dropcaps
				"trx_dropcaps" => array(
					"title" => __("Dropcaps", 'ancora-utils'),
					"desc" => __("Make first letter as dropcaps", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => __("Style", 'ancora-utils'),
							"desc" => __("Dropcaps style", 'ancora-utils'),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils'),
								3 => __('Style 3', 'ancora-utils'),
								4 => __('Style 4', 'ancora-utils')
							)
						),
						"_content_" => array(
							"title" => __("Paragraph content", 'ancora-utils'),
							"desc" => __("Paragraph with dropcaps content", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Emailer
				"trx_emailer" => array(
					"title" => __("E-mail collector", 'ancora-utils'),
					"desc" => __("Collect the e-mail address into specified group", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"group" => array(
							"title" => __("Group", 'ancora-utils'),
							"desc" => __("The name of group to collect e-mail address", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"open" => array(
							"title" => __("Open", 'ancora-utils'),
							"desc" => __("Initially open the input field on show object", 'ancora-utils'),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Align object to left, center or right", 'ancora-utils'),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Gap
				"trx_gap" => array(
					"title" => __("Gap", 'ancora-utils'),
					"desc" => __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Gap content", 'ancora-utils'),
							"desc" => __("Gap inner content", 'ancora-utils'),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						)
					)
				),
			
			
			
			
			
				// Google map
				"trx_googlemap" => array(
					"title" => __("Google map", 'ancora-utils'),
					"desc" => __("Insert Google map with desired address or coordinates", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"address" => array(
							"title" => __("Address", 'ancora-utils'),
							"desc" => __("Address to show in map center", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"latlng" => array(
							"title" => __("Latitude and Longtitude", 'ancora-utils'),
							"desc" => __("Comma separated map center coorditanes (instead Address)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
                        "description" => array(
                            "title" => __("Description", 'ancora-utils'),
                            "desc" => __("Description", 'ancora-utils'),
                            "value" => "",
                            "type" => "text"
                        ),
						"zoom" => array(
							"title" => __("Zoom", 'ancora-utils'),
							"desc" => __("Map zoom factor", 'ancora-utils'),
							"divider" => true,
							"value" => 16,
							"min" => 1,
							"max" => 20,
							"type" => "spinner"
						),
						"style" => array(
							"title" => __("Map style", 'ancora-utils'),
							"desc" => __("Select map style", 'ancora-utils'),
							"value" => "default",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['googlemap_styles']
						),
						"width" => ancora_shortcodes_width('100%'),
						"height" => ancora_shortcodes_height(240),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Hide or show any block
				"trx_hide" => array(
					"title" => __("Hide/Show any block", 'ancora-utils'),
					"desc" => __("Hide or Show any block with desired CSS-selector", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"selector" => array(
							"title" => __("Selector", 'ancora-utils'),
							"desc" => __("Any block's CSS-selector", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"hide" => array(
							"title" => __("Hide or Show", 'ancora-utils'),
							"desc" => __("New state for the block: hide or show", 'ancora-utils'),
							"value" => "yes",
							"size" => "small",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						)
					)
				),
			
			
			
				// Highlght text
				"trx_highlight" => array(
					"title" => __("Highlight text", 'ancora-utils'),
					"desc" => __("Highlight text with selected color, background color and other styles", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"type" => array(
							"title" => __("Type", 'ancora-utils'),
							"desc" => __("Highlight type", 'ancora-utils'),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								0 => __('Custom', 'ancora-utils'),
								1 => __('Type 1', 'ancora-utils'),
								2 => __('Type 2', 'ancora-utils'),
								3 => __('Type 3', 'ancora-utils')
							)
						),
						"color" => array(
							"title" => __("Color", 'ancora-utils'),
							"desc" => __("Color for the highlighted text", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Background color for the highlighted text", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"font_size" => array(
							"title" => __("Font size", 'ancora-utils'),
							"desc" => __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Highlighting content", 'ancora-utils'),
							"desc" => __("Content for highlight", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Icon
				"trx_icon" => array(
					"title" => __("Icon", 'ancora-utils'),
					"desc" => __("Insert icon", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => __('Icon',  'ancora-utils'),
							"desc" => __('Select font icon from the Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => __("Icon's color", 'ancora-utils'),
							"desc" => __("Icon's color", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "color"
						),
						"bg_shape" => array(
							"title" => __("Background shape", 'ancora-utils'),
							"desc" => __("Shape of the icon background", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "none",
							"type" => "radio",
							"options" => array(
								'none' => __('None', 'ancora-utils'),
								'round' => __('Round', 'ancora-utils'),
								'square' => __('Square', 'ancora-utils')
							)
						),
						"bg_style" => array(
							"title" => __("Background style", 'ancora-utils'),
							"desc" => __("Select icon's color scheme", 'ancora-utils'),
							"value" => "custom",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['button_styles']
						), 
						"bg_color" => array(
							"title" => __("Icon's background color", 'ancora-utils'),
							"desc" => __("Icon's background color", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty'),
								'background' => array('round','square')
							),
							"value" => "",
							"type" => "color"
						),
						"font_size" => array(
							"title" => __("Font size", 'ancora-utils'),
							"desc" => __("Icon's font size", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "spinner",
							"min" => 8,
							"max" => 240
						),
						"font_weight" => array(
							"title" => __("Font weight", 'ancora-utils'),
							"desc" => __("Icon font weight", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'ancora-utils'),
								'300' => __('Light (300)', 'ancora-utils'),
								'400' => __('Normal (400)', 'ancora-utils'),
								'700' => __('Bold (700)', 'ancora-utils')
							)
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Icon text alignment", 'ancora-utils'),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => __("Link URL", 'ancora-utils'),
							"desc" => __("Link URL from this icon (if not empty)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Image
				"trx_image" => array(
					"title" => __("Image", 'ancora-utils'),
					"desc" => __("Insert image into your post (page)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for image file", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Image title (if need)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => __("Icon before title",  'ancora-utils'),
							"desc" => __('Select icon for the title from Fontello icons set',  'ancora-utils'),
							"value" => "none",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"align" => array(
							"title" => __("Float image", 'ancora-utils'),
							"desc" => __("Float image to left or right side", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						), 
						"shape" => array(
							"title" => __("Image Shape", 'ancora-utils'),
							"desc" => __("Shape of the image: square (rectangle) or round", 'ancora-utils'),
							"value" => "square",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"square" => __('Square', 'ancora-utils'),
								"round" => __('Round', 'ancora-utils')
							)
						), 
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Infobox
				"trx_infobox" => array(
					"title" => __("Infobox", 'ancora-utils'),
					"desc" => __("Insert infobox into your post (page)", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => __("Style", 'ancora-utils'),
							"desc" => __("Infobox style", 'ancora-utils'),
							"value" => "regular",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'regular' => __('Regular', 'ancora-utils'),
								'info' => __('Info', 'ancora-utils'),
								'success' => __('Success', 'ancora-utils'),
								'error' => __('Error', 'ancora-utils'),
                                'warning'=> __('Warning','ancora-utils')
							)
						),
						"closeable" => array(
							"title" => __("Closeable box", 'ancora-utils'),
							"desc" => __("Create closeable box (with close button)", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"icon" => array(
							"title" => __("Custom icon",  'ancora-utils'),
							"desc" => __('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => __("Text color", 'ancora-utils'),
							"desc" => __("Any color for text and headers", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Any background color for this infobox", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"_content_" => array(
							"title" => __("Infobox content", 'ancora-utils'),
							"desc" => __("Content for infobox", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Line
				"trx_line" => array(
					"title" => __("Line", 'ancora-utils'),
					"desc" => __("Insert Line into your post (page)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Style", 'ancora-utils'),
							"desc" => __("Line style", 'ancora-utils'),
							"value" => "solid",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'solid' => __('Solid', 'ancora-utils'),
								'dashed' => __('Dashed', 'ancora-utils'),
								'dotted' => __('Dotted', 'ancora-utils'),
								'double' => __('Double', 'ancora-utils')
							)
						),
						"color" => array(
							"title" => __("Color", 'ancora-utils'),
							"desc" => __("Line color", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// List
				"trx_list" => array(
					"title" => __("List", 'ancora-utils'),
					"desc" => __("List items with specific bullets", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Bullet's style", 'ancora-utils'),
							"desc" => __("Bullet's style for each list item", 'ancora-utils'),
							"value" => "ul",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['list_styles']
						), 
						"color" => array(
							"title" => __("Color", 'ancora-utils'),
							"desc" => __("List items color", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => __('List icon',  'ancora-utils'),
							"desc" => __("Select list icon from Fontello icons set (only for style=Iconed)",  'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"icon_color" => array(
							"title" => __("Icon color", 'ancora-utils'),
							"desc" => __("List icons color", 'ancora-utils'),
							"value" => "",
							"dependency" => array(
								'style' => array('iconed')
							),
							"type" => "color"
						),
                        "boxed_icon" => array(
                            "title" => __("Boxed Icon", 'ancora-utils'),
                            "desc" => __("Create border around icon", 'ancora-utils'),
                            "value" => "",
                            "type" => "checklist",
                            "options" => array('' => 'No', 'boxed_icon' => 'Yes'),
                        ),
                        "top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_list_item",
						"title" => __("Item", 'ancora-utils'),
						"desc" => __("List item with specific bullet", 'ancora-utils'),
						"decorate" => false,
						"container" => true,
						"params" => array(
							"_content_" => array(
								"title" => __("List item content", 'ancora-utils'),
								"desc" => __("Current list item content", 'ancora-utils'),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"title" => array(
								"title" => __("List item title", 'ancora-utils'),
								"desc" => __("Current list item title (show it as tooltip)", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"color" => array(
								"title" => __("Color", 'ancora-utils'),
								"desc" => __("Text color for this item", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"icon" => array(
								"title" => __('List icon',  'ancora-utils'),
								"desc" => __("Select list item icon from Fontello icons set (only for style=Iconed)",  'ancora-utils'),
								"value" => "",
								"type" => "icons",
								"options" => $ANCORA_GLOBALS['sc_params']['icons']
							),
							"icon_color" => array(
								"title" => __("Icon color", 'ancora-utils'),
								"desc" => __("Icon color for this item", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"link" => array(
								"title" => __("Link URL", 'ancora-utils'),
								"desc" => __("Link URL for the current list item", 'ancora-utils'),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"target" => array(
								"title" => __("Link target", 'ancora-utils'),
								"desc" => __("Link target for the current list item", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
				// Number
				"trx_number" => array(
					"title" => __("Number", 'ancora-utils'),
					"desc" => __("Insert number or any word as set separate characters", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"value" => array(
							"title" => __("Value", 'ancora-utils'),
							"desc" => __("Number or any word", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select block alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Parallax
				"trx_parallax" => array(
					"title" => __("Parallax", 'ancora-utils'),
					"desc" => __("Create the parallax container (with asinc background image)", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"gap" => array(
							"title" => __("Create gap", 'ancora-utils'),
							"desc" => __("Create gap around parallax container", 'ancora-utils'),
							"value" => "no",
							"size" => "small",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						), 
						"dir" => array(
							"title" => __("Dir", 'ancora-utils'),
							"desc" => __("Scroll direction for the parallax background", 'ancora-utils'),
							"value" => "up",
							"size" => "medium",
							"options" => array(
								'up' => __('Up', 'ancora-utils'),
								'down' => __('Down', 'ancora-utils')
							),
							"type" => "switch"
						), 
						"speed" => array(
							"title" => __("Speed", 'ancora-utils'),
							"desc" => __("Image motion speed (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0.3",
							"type" => "spinner"
						),
						"color" => array(
							"title" => __("Text color", 'ancora-utils'),
							"desc" => __("Select color for text object inside parallax block", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Bg tint", 'ancora-utils'),
							"desc" => __("Select tint of the parallax background (for correct font color choise)", 'ancora-utils'),
							"value" => "light",
							"size" => "medium",
							"options" => array(
								'light' => __('Light', 'ancora-utils'),
								'dark' => __('Dark', 'ancora-utils')
							),
							"type" => "switch"
						), 
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Select color for parallax background", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the parallax background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image_x" => array(
							"title" => __("Image X position", 'ancora-utils'),
							"desc" => __("Image horizontal position (as background of the parallax block) - in percent", 'ancora-utils'),
							"min" => "0",
							"max" => "100",
							"value" => "50",
							"type" => "spinner"
						),
						"bg_video" => array(
							"title" => __("Video background", 'ancora-utils'),
							"desc" => __("Select video from media library or paste URL for video file from other site to show it as parallax background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose video', 'ancora-utils'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose video file', 'ancora-utils'),
									'update' => __('Select video file', 'ancora-utils')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"bg_video_ratio" => array(
							"title" => __("Video ratio", 'ancora-utils'),
							"desc" => __("Specify ratio of the video background. For example: 16:9 (default), 4:3, etc.", 'ancora-utils'),
							"value" => "16:9",
							"type" => "text"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", 'ancora-utils'),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", 'ancora-utils'),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", 'ancora-utils'),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"_content_" => array(
							"title" => __("Content", 'ancora-utils'),
							"desc" => __("Content for the parallax container", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Popup
				"trx_popup" => array(
					"title" => __("Popup window", 'ancora-utils'),
					"desc" => __("Container for any html-block with desired class and style for popup window", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Container content", 'ancora-utils'),
							"desc" => __("Content for section container", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Price
				"trx_price" => array(
					"title" => __("Price", 'ancora-utils'),
					"desc" => __("Insert price with decoration", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"money" => array(
							"title" => __("Money", 'ancora-utils'),
							"desc" => __("Money value (dot or comma separated)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => __("Currency", 'ancora-utils'),
							"desc" => __("Currency character", 'ancora-utils'),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => __("Period", 'ancora-utils'),
							"desc" => __("Period text (if need). For example: monthly, daily, etc.", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Align price to left or right side", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						), 
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Price block
				"trx_price_block" => array(
					"title" => __("Price block", 'ancora-utils'),
					"desc" => __("Insert price block with title, price and description", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Block title", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => __("Link URL", 'ancora-utils'),
							"desc" => __("URL for link from button (at bottom of the block)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"link_text" => array(
							"title" => __("Link text", 'ancora-utils'),
							"desc" => __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => __("Icon",  'ancora-utils'),
							"desc" => __('Select icon from Fontello icons set (placed before/instead price)',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"money" => array(
							"title" => __("Money", 'ancora-utils'),
							"desc" => __("Money value (dot or comma separated)", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => __("Currency", 'ancora-utils'),
							"desc" => __("Currency character", 'ancora-utils'),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => __("Period", 'ancora-utils'),
							"desc" => __("Period text (if need). For example: monthly, daily, etc.", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Align price to left or right side", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						), 
						"_content_" => array(
							"title" => __("Description", 'ancora-utils'),
							"desc" => __("Description for this price block", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Quote
				"trx_quote" => array(
					"title" => __("Quote", 'ancora-utils'),
					"desc" => __("Quote text", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
                        "style" => array(
                            "title" => __("Style", 'ancora-utils'),
                            "desc" => __("Quote style", 'ancora-utils'),
                            "value" => "",
                            "type" => "checklist",
                            "options" => array ( '1' => 'Dark', '2' => 'White')
                        ),
						"cite" => array(
							"title" => __("Quote cite", 'ancora-utils'),
							"desc" => __("URL for quote cite", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"title" => array(
							"title" => __("Title (author)", 'ancora-utils'),
							"desc" => __("Quote title (author name)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Quote content", 'ancora-utils'),
							"desc" => __("Quote content", 'ancora-utils'),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Reviews
				"trx_reviews" => array(
					"title" => __("Reviews", 'ancora-utils'),
					"desc" => __("Insert reviews block in the single post", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Align counter to left, center or right", 'ancora-utils'),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Search
				"trx_search" => array(
					"title" => __("Search", 'ancora-utils'),
					"desc" => __("Show search form", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"ajax" => array(
							"title" => __("Style", 'ancora-utils'),
							"desc" => __("Select style to display search field", 'ancora-utils'),
							"value" => "regular",
							"options" => array(
								"regular" => __('Regular', 'ancora-utils'),
								"flat" => __('Flat', 'ancora-utils')
							),
							"type" => "checklist"
						),
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Title (placeholder) for the search field", 'ancora-utils'),
							"value" => __("Search &hellip;", 'ancora-utils'),
							"type" => "text"
						),
						"ajax" => array(
							"title" => __("AJAX", 'ancora-utils'),
							"desc" => __("Search via AJAX or reload page", 'ancora-utils'),
							"value" => "yes",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Section
				"trx_section" => array(
					"title" => __("Section container", 'ancora-utils'),
					"desc" => __("Container for any block with desired class and style", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => __("Dedicated", 'ancora-utils'),
							"desc" => __("Use this block as dedicated content - show it before post title on single page", 'ancora-utils'),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select block alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => __("Columns emulation", 'ancora-utils'),
							"desc" => __("Select width for columns emulation", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => __("Use pan effect", 'ancora-utils'),
							"desc" => __("Use pan effect to show section content", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => __("Use scroller", 'ancora-utils'),
							"desc" => __("Use scroller to show section content", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => __("Scroll and Pan direction", 'ancora-utils'),
							"desc" => __("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", 'ancora-utils'),
							"dependency" => array(
								'pan' => array('yes'),
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => __("Scroll controls", 'ancora-utils'),
							"desc" => __("Show scroll controls (if Use scroller = yes)", 'ancora-utils'),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"color" => array(
							"title" => __("Fore color", 'ancora-utils'),
							"desc" => __("Any color for objects in this section", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_tint" => array(
							"title" => __("Background tint", 'ancora-utils'),
							"desc" => __("Main background tint: dark or light", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Any background color for this section", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", 'ancora-utils'),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", 'ancora-utils'),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", 'ancora-utils'),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => __("Font size", 'ancora-utils'),
							"desc" => __("Font size of the text (default - in pixels, allows any CSS units of measure)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", 'ancora-utils'),
							"desc" => __("Font weight of the text", 'ancora-utils'),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => __('Thin (100)', 'ancora-utils'),
								'300' => __('Light (300)', 'ancora-utils'),
								'400' => __('Normal (400)', 'ancora-utils'),
								'700' => __('Bold (700)', 'ancora-utils')
							)
						),
						"_content_" => array(
							"title" => __("Container content", 'ancora-utils'),
							"desc" => __("Content for section container", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Skills
				"trx_skills" => array(
					"title" => __("Skills", 'ancora-utils'),
					"desc" => __("Insert skills diagramm in your page (post)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"max_value" => array(
							"title" => __("Max value", 'ancora-utils'),
							"desc" => __("Max value for skills items", 'ancora-utils'),
							"value" => 100,
							"min" => 1,
							"type" => "spinner"
						),
						"type" => array(
							"title" => __("Skills type", 'ancora-utils'),
							"desc" => __("Select type of skills block", 'ancora-utils'),
							"value" => "bar",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'bar' => __('Bar', 'ancora-utils'),
								'pie' => __('Pie chart', 'ancora-utils'),
								'counter' => __('Counter', 'ancora-utils'),
								'arc' => __('Arc', 'ancora-utils')
							)
						), 
						"layout" => array(
							"title" => __("Skills layout", 'ancora-utils'),
							"desc" => __("Select layout of skills block", 'ancora-utils'),
							"dependency" => array(
								'type' => array('counter','pie','bar')
							),
							"value" => "rows",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'rows' => __('Rows', 'ancora-utils'),
								'columns' => __('Columns', 'ancora-utils')
							)
						),
						"dir" => array(
							"title" => __("Direction", 'ancora-utils'),
							"desc" => __("Select direction of skills block", 'ancora-utils'),
							"dependency" => array(
								'type' => array('counter','pie','bar')
							),
							"value" => "horizontal",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['dir']
						), 
						"style" => array(
							"title" => __("Counters style", 'ancora-utils'),
							"desc" => __("Select style of skills items (only for type=counter)", 'ancora-utils'),
							"dependency" => array(
								'type' => array('counter')
							),
							"value" => 1,
							"min" => 1,
							"max" => 4,
							"type" => "spinner"
						), 
						// "columns" - autodetect, not set manual
						"color" => array(
							"title" => __("Skills items color", 'ancora-utils'),
							"desc" => __("Color for all skills items", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Background color for all skills items (only for type=pie)", 'ancora-utils'),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"border_color" => array(
							"title" => __("Border color", 'ancora-utils'),
							"desc" => __("Border color for all skills items (only for type=pie)", 'ancora-utils'),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"title" => array(
							"title" => __("Skills title", 'ancora-utils'),
							"desc" => __("Skills block title", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => __("Skills subtitle", 'ancora-utils'),
							"desc" => __("Skills block subtitle - text in the center (only for type=arc)", 'ancora-utils'),
							"dependency" => array(
								'type' => array('arc')
							),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => __("Align skills block", 'ancora-utils'),
							"desc" => __("Align skills block to left or right side", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						), 
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_skills_item",
						"title" => __("Skill", 'ancora-utils'),
						"desc" => __("Skills item", 'ancora-utils'),
						"container" => false,
						"params" => array(
							"title" => array(
								"title" => __("Title", 'ancora-utils'),
								"desc" => __("Current skills item title", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => __("Value", 'ancora-utils'),
								"desc" => __("Current skills level", 'ancora-utils'),
								"value" => 50,
								"min" => 0,
								"step" => 1,
								"type" => "spinner"
							),
							"color" => array(
								"title" => __("Color", 'ancora-utils'),
								"desc" => __("Current skills item color", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => __("Background color", 'ancora-utils'),
								"desc" => __("Current skills item background color (only for type=pie)", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"border_color" => array(
								"title" => __("Border color", 'ancora-utils'),
								"desc" => __("Current skills item border color (only for type=pie)", 'ancora-utils'),
								"value" => "",
								"type" => "color"
							),
							"style" => array(
								"title" => __("Counter tyle", 'ancora-utils'),
								"desc" => __("Select style for the current skills item (only for type=counter)", 'ancora-utils'),
								"value" => 1,
								"min" => 1,
								"max" => 4,
								"type" => "spinner"
							), 
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Slider
				"trx_slider" => array(
					"title" => __("Slider", 'ancora-utils'),
					"desc" => __("Insert slider into your post (page)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array_merge(array(
						"engine" => array(
							"title" => __("Slider engine", 'ancora-utils'),
							"desc" => __("Select engine for slider. Attention! Swiper is built-in engine, all other engines appears only if corresponding plugings are installed", 'ancora-utils'),
							"value" => "swiper",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['sliders']
						),
						"align" => array(
							"title" => __("Float slider", 'ancora-utils'),
							"desc" => __("Float slider to left or right side", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						),
						"custom" => array(
							"title" => __("Custom slides", 'ancora-utils'),
							"desc" => __("Make custom slides from inner shortcodes (prepare it on tabs) or prepare slides from posts thumbnails", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						)
						),
						ancora_exists_revslider() ? array(
						"alias" => array(
							"title" => __("Revolution slider alias", 'ancora-utils'),
							"desc" => __("Alias for Revolution slider", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('revo','royal')
							),
							"divider" => true,
							"value" => "",
							"type" => "text"
						)) : array(), array(
						"cat" => array(
							"title" => __("Swiper: Category list", 'ancora-utils'),
							"desc" => __("Comma separated list of category slugs. If empty - select posts from any category or from IDs list", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $ANCORA_GLOBALS['sc_params']['categories']
						),
						"count" => array(
							"title" => __("Swiper: Number of posts", 'ancora-utils'),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Swiper: Offset before select posts", 'ancora-utils'),
							"desc" => __("Skip posts before select next part.", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Swiper: Post order by", 'ancora-utils'),
							"desc" => __("Select desired posts sorting method", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "date",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Swiper: Post order", 'ancora-utils'),
							"desc" => __("Select desired posts order", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Swiper: Post IDs list", 'ancora-utils'),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => __("Swiper: Show slider controls", 'ancora-utils'),
							"desc" => __("Show arrows inside slider", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"pagination" => array(
							"title" => __("Swiper: Show slider pagination", 'ancora-utils'),
							"desc" => __("Show bullets for switch slides", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "checklist",
							"options" => array(
								'yes'  => __('Dots', 'ancora-utils'),
								'full' => __('Side Titles', 'ancora-utils'),
								'over' => __('Over Titles', 'ancora-utils'),
								'no'   => __('None', 'ancora-utils')
							)
						),
						"titles" => array(
							"title" => __("Swiper: Show titles section", 'ancora-utils'),
							"desc" => __("Show section with post's title and short post's description", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "no",
							"type" => "checklist",
							"options" => array(
								"no"    => __('Not show', 'ancora-utils'),
								"slide" => __('Show/Hide info', 'ancora-utils'),
								"fixed" => __('Fixed info', 'ancora-utils')
							)
						),
						"descriptions" => array(
							"title" => __("Swiper: Post descriptions", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"desc" => __("Show post's excerpt max length (characters)", 'ancora-utils'),
							"value" => 0,
							"min" => 0,
							"max" => 1000,
							"step" => 10,
							"type" => "spinner"
						),
						"links" => array(
							"title" => __("Swiper: Post's title as link", 'ancora-utils'),
							"desc" => __("Make links from post's titles", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"crop" => array(
							"title" => __("Swiper: Crop images", 'ancora-utils'),
							"desc" => __("Crop images in each slide or live it unchanged", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"autoheight" => array(
							"title" => __("Swiper: Autoheight", 'ancora-utils'),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => __("Swiper: Slides change interval", 'ancora-utils'),
							"desc" => __("Slides change interval (in milliseconds: 1000ms = 1s)", 'ancora-utils'),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 5000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)),
					"children" => array(
						"name" => "trx_slider_item",
						"title" => __("Slide", 'ancora-utils'),
						"desc" => __("Slider item", 'ancora-utils'),
						"container" => false,
						"params" => array(
							"src" => array(
								"title" => __("URL (source) for image file", 'ancora-utils'),
								"desc" => __("Select or upload image or write URL from other site for the current slide", 'ancora-utils'),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Socials
				"trx_socials" => array(
					"title" => __("Social icons", 'ancora-utils'),
					"desc" => __("List of social icons (with hovers)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"size" => array(
							"title" => __("Icon's size", 'ancora-utils'),
							"desc" => __("Size of the icons", 'ancora-utils'),
							"value" => "small",
							"type" => "checklist",
							"options" => array(
								"tiny" => __('Tiny', 'ancora-utils'),
								"small" => __('Small', 'ancora-utils'),
								"large" => __('Large', 'ancora-utils')
							)
						), 
						"socials" => array(
							"title" => __("Manual socials list", 'ancora-utils'),
							"desc" => __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebooc.com/my_profile. If empty - use socials from Theme options.", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"custom" => array(
							"title" => __("Custom socials", 'ancora-utils'),
							"desc" => __("Make custom icons from inner shortcodes (prepare it on tabs)", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_social_item",
						"title" => __("Custom social item", 'ancora-utils'),
						"desc" => __("Custom social item: name, profile url and icon url", 'ancora-utils'),
						"decorate" => false,
						"container" => false,
						"params" => array(
							"name" => array(
								"title" => __("Social name", 'ancora-utils'),
								"desc" => __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"url" => array(
								"title" => __("Your profile URL", 'ancora-utils'),
								"desc" => __("URL of your profile in specified social network", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"icon" => array(
								"title" => __("URL (source) for icon file", 'ancora-utils'),
								"desc" => __("Select or upload image or write URL from other site for the current social icon", 'ancora-utils'),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							)
						)
					)
				),
			
			
			
			
				// Table
				"trx_table" => array(
					"title" => __("Table", 'ancora-utils'),
					"desc" => __("Insert a table into post (page). ", 'ancora-utils'),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"align" => array(
							"title" => __("Content alignment", 'ancora-utils'),
							"desc" => __("Select alignment for each table cell", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"_content_" => array(
							"title" => __("Table content", 'ancora-utils'),
							"desc" => __("Content, created with any table-generator", 'ancora-utils'),
							"divider" => true,
							"rows" => 8,
							"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
							"type" => "textarea"
						),
						"width" => ancora_shortcodes_width(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Tabs
				"trx_tabs" => array(
					"title" => __("Tabs", 'ancora-utils'),
					"desc" => __("Insert tabs in your page (post)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Tabs style", 'ancora-utils'),
							"desc" => __("Select style for tabs items", 'ancora-utils'),
							"value" => 1,
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils')
							),
							"type" => "radio"
						),
						"initial" => array(
							"title" => __("Initially opened tab", 'ancora-utils'),
							"desc" => __("Number of initially opened tab", 'ancora-utils'),
							"divider" => true,
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"scroll" => array(
							"title" => __("Use scroller", 'ancora-utils'),
							"desc" => __("Use scroller to show tab content (height parameter required)", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_tab",
						"title" => __("Tab", 'ancora-utils'),
						"desc" => __("Tab item", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Tab title", 'ancora-utils'),
								"desc" => __("Current tab title", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => __("Tab content", 'ancora-utils'),
								"desc" => __("Current tab content", 'ancora-utils'),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
			
				// Team
				"trx_team" => array(
					"title" => __("Team", 'ancora-utils'),
					"desc" => __("Insert team in your page (post)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Team style", 'ancora-utils'),
							"desc" => __("Select style to display team members", 'ancora-utils'),
							"value" => "1",
							"type" => "select",
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils')
							)
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns use to show team members", 'ancora-utils'),
							"value" => 3,
							"min" => 2,
							"max" => 5,
							"step" => 1,
							"type" => "spinner"
						),
						"custom" => array(
							"title" => __("Custom", 'ancora-utils'),
							"desc" => __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => __("Categories", 'ancora-utils'),
							"desc" => __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $ANCORA_GLOBALS['sc_params']['team_groups']
						),
						"count" => array(
							"title" => __("Number of posts", 'ancora-utils'),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", 'ancora-utils'),
							"desc" => __("Skip posts before select next part.", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", 'ancora-utils'),
							"desc" => __("Select desired posts sorting method", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "title",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", 'ancora-utils'),
							"desc" => __("Select desired posts order", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Post IDs list", 'ancora-utils'),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_team_item",
						"title" => __("Member", 'ancora-utils'),
						"desc" => __("Team member", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"user" => array(
								"title" => __("Registerd user", 'ancora-utils'),
								"desc" => __("Select one of registered users (if present) or put name, position, etc. in fields below", 'ancora-utils'),
								"value" => "",
								"type" => "select",
								"options" => $ANCORA_GLOBALS['sc_params']['users']
							),
							"member" => array(
								"title" => __("Team member", 'ancora-utils'),
								"desc" => __("Select one of team members (if present) or put name, position, etc. in fields below", 'ancora-utils'),
								"value" => "",
								"type" => "select",
								"options" => $ANCORA_GLOBALS['sc_params']['members']
							),
							"link" => array(
								"title" => __("Link", 'ancora-utils'),
								"desc" => __("Link on team member's personal page", 'ancora-utils'),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"name" => array(
								"title" => __("Name", 'ancora-utils'),
								"desc" => __("Team member's name", 'ancora-utils'),
								"divider" => true,
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => __("Position", 'ancora-utils'),
								"desc" => __("Team member's position", 'ancora-utils'),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => __("E-mail", 'ancora-utils'),
								"desc" => __("Team member's e-mail", 'ancora-utils'),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => __("Photo", 'ancora-utils'),
								"desc" => __("Team member's photo (avatar)", 'ancora-utils'),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"socials" => array(
								"title" => __("Socials", 'ancora-utils'),
								"desc" => __("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", 'ancora-utils'),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => __("Description", 'ancora-utils'),
								"desc" => __("Team member's short description", 'ancora-utils'),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Testimonials
				"trx_testimonials" => array(
					"title" => __("Testimonials", 'ancora-utils'),
					"desc" => __("Insert testimonials into post (page)", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"controls" => array(
							"title" => __("Show arrows", 'ancora-utils'),
							"desc" => __("Show control buttons", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => __("Testimonials change interval", 'ancora-utils'),
							"desc" => __("Testimonials change interval (in milliseconds: 1000ms = 1s)", 'ancora-utils'),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Alignment of the testimonials block", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"autoheight" => array(
							"title" => __("Autoheight", 'ancora-utils'),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"custom" => array(
							"title" => __("Custom", 'ancora-utils'),
							"desc" => __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", 'ancora-utils'),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => __("Categories", 'ancora-utils'),
							"desc" => __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => $ANCORA_GLOBALS['sc_params']['testimonials_groups']
						),
						"count" => array(
							"title" => __("Number of posts", 'ancora-utils'),
							"desc" => __("How many posts will be displayed? If used IDs - this parameter ignored.", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => __("Offset before select posts", 'ancora-utils'),
							"desc" => __("Skip posts before select next part.", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Post order by", 'ancora-utils'),
							"desc" => __("Select desired posts sorting method", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "date",
							"type" => "select",
							"options" => $ANCORA_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => __("Post order", 'ancora-utils'),
							"desc" => __("Select desired posts order", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => __("Post IDs list", 'ancora-utils'),
							"desc" => __("Comma separated list of posts ID. If set - parameters above are ignored!", 'ancora-utils'),
							"dependency" => array(
								'custom' => array('yes')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_tint" => array(
							"title" => __("Background tint", 'ancora-utils'),
							"desc" => __("Main background tint: dark or light", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Any background color for this section", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", 'ancora-utils'),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", 'ancora-utils'),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", 'ancora-utils'),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_testimonials_item",
						"title" => __("Item", 'ancora-utils'),
						"desc" => __("Testimonials item", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"author" => array(
								"title" => __("Author", 'ancora-utils'),
								"desc" => __("Name of the testimonmials author", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => __("Link", 'ancora-utils'),
								"desc" => __("Link URL to the testimonmials author page", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => __("E-mail", 'ancora-utils'),
								"desc" => __("E-mail of the testimonmials author (to get gravatar)", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => __("Photo", 'ancora-utils'),
								"desc" => __("Select or upload photo of testimonmials author or write URL of photo from other site", 'ancora-utils'),
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => __("Testimonials text", 'ancora-utils'),
								"desc" => __("Current testimonials text", 'ancora-utils'),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Title
				"trx_title" => array(
					"title" => __("Title", 'ancora-utils'),
					"desc" => __("Create header tag (1-6 level) with many styles", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => __("Title content", 'ancora-utils'),
							"desc" => __("Title content", 'ancora-utils'),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"type" => array(
							"title" => __("Title type", 'ancora-utils'),
							"desc" => __("Title type (header level)", 'ancora-utils'),
							"divider" => true,
							"value" => "1",
							"type" => "select",
							"options" => array(
								'1' => __('Header 1', 'ancora-utils'),
								'2' => __('Header 2', 'ancora-utils'),
								'3' => __('Header 3', 'ancora-utils'),
								'4' => __('Header 4', 'ancora-utils'),
								'5' => __('Header 5', 'ancora-utils'),
								'6' => __('Header 6', 'ancora-utils'),
							)
						),
						"style" => array(
							"title" => __("Title style", 'ancora-utils'),
							"desc" => __("Title style", 'ancora-utils'),
							"value" => "regular",
							"type" => "select",
							"options" => array(
								'regular' => __('Regular', 'ancora-utils'),
								'underline' => __('Underline', 'ancora-utils'),
								'divider' => __('Divider', 'ancora-utils'),
								'iconed' => __('With icon (image)', 'ancora-utils')
							)
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Title text alignment", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						), 
						"font_size" => array(
							"title" => __("Font_size", 'ancora-utils'),
							"desc" => __("Custom font size. If empty - use theme default", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => __("Font weight", 'ancora-utils'),
							"desc" => __("Custom font weight. If empty or inherit - use theme default", 'ancora-utils'),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'inherit' => __('Default', 'ancora-utils'),
								'100' => __('Thin (100)', 'ancora-utils'),
								'300' => __('Light (300)', 'ancora-utils'),
								'400' => __('Normal (400)', 'ancora-utils'),
								'600' => __('Semibold (600)', 'ancora-utils'),
								'700' => __('Bold (700)', 'ancora-utils'),
								'900' => __('Black (900)', 'ancora-utils')
							)
						),
                        "fig_border" => array(
                            "title" => __("Figure botoom border", 'ancora-utils'),
                            "desc" => __("Apply a figure botoom border", 'ancora-utils'),
                            "value" => "",
                            "type" => "checklist",
                            "options" => array('No' => '', 'Yes' => 'fig_border'),
                        ),
                        "color" => array(
							"title" => __("Title color", 'ancora-utils'),
							"desc" => __("Select color for the title", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => __('Title font icon',  'ancora-utils'),
							"desc" => __("Select font icon for the title from Fontello icons set (if style=iconed)",  'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"image" => array(
							"title" => __('or image icon',  'ancora-utils'),
							"desc" => __("Select image icon for the title instead icon above (if style=iconed)",  'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "images",
							"size" => "small",
							"options" => $ANCORA_GLOBALS['sc_params']['images']
						),
						"picture" => array(
							"title" => __('or URL for image file', 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site (if style=iconed)", 'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"image_size" => array(
							"title" => __('Image (picture) size', 'ancora-utils'),
							"desc" => __("Select image (picture) size (if style='iconed')", 'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "small",
							"type" => "checklist",
							"options" => array(
								'small' => __('Small', 'ancora-utils'),
								'medium' => __('Medium', 'ancora-utils'),
								'large' => __('Large', 'ancora-utils')
							)
						),
						"position" => array(
							"title" => __('Icon (image) position', 'ancora-utils'),
							"desc" => __("Select icon (image) position (if style=iconed)", 'ancora-utils'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "left",
							"type" => "checklist",
							"options" => array(
								'top' => __('Top', 'ancora-utils'),
								'left' => __('Left', 'ancora-utils')
							)
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Toggles
				"trx_toggles" => array(
					"title" => __("Toggles", 'ancora-utils'),
					"desc" => __("Toggles items", 'ancora-utils'),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => __("Toggles style", 'ancora-utils'),
							"desc" => __("Select style for display toggles", 'ancora-utils'),
							"value" => 1,
							"options" => array(
								1 => __('Style 1', 'ancora-utils'),
								2 => __('Style 2', 'ancora-utils')
							),
							"type" => "radio"
						),
						"counter" => array(
							"title" => __("Counter", 'ancora-utils'),
							"desc" => __("Display counter before each toggles title", 'ancora-utils'),
							"value" => "off",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['on_off']
						),
						"icon_closed" => array(
							"title" => __("Icon while closed",  'ancora-utils'),
							"desc" => __('Select icon for the closed toggles item from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => __("Icon while opened",  'ancora-utils'),
							"desc" => __('Select icon for the opened toggles item from Fontello icons set',  'ancora-utils'),
							"value" => "",
							"type" => "icons",
							"options" => $ANCORA_GLOBALS['sc_params']['icons']
						),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_toggles_item",
						"title" => __("Toggles item", 'ancora-utils'),
						"desc" => __("Toggles item", 'ancora-utils'),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => __("Toggles item title", 'ancora-utils'),
								"desc" => __("Title for current toggles item", 'ancora-utils'),
								"value" => "",
								"type" => "text"
							),
							"open" => array(
								"title" => __("Open on show", 'ancora-utils'),
								"desc" => __("Open current toggles item on show", 'ancora-utils'),
								"value" => "no",
								"type" => "switch",
								"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
							),
							"icon_closed" => array(
								"title" => __("Icon while closed",  'ancora-utils'),
								"desc" => __('Select icon for the closed toggles item from Fontello icons set',  'ancora-utils'),
								"value" => "",
								"type" => "icons",
								"options" => $ANCORA_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => __("Icon while opened",  'ancora-utils'),
								"desc" => __('Select icon for the opened toggles item from Fontello icons set',  'ancora-utils'),
								"value" => "",
								"type" => "icons",
								"options" => $ANCORA_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => __("Toggles item content", 'ancora-utils'),
								"desc" => __("Current toggles item content", 'ancora-utils'),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ANCORA_GLOBALS['sc_params']['id'],
							"class" => $ANCORA_GLOBALS['sc_params']['class'],
							"css" => $ANCORA_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
			
				// Tooltip
				"trx_tooltip" => array(
					"title" => __("Tooltip", 'ancora-utils'),
					"desc" => __("Create tooltip for selected text", 'ancora-utils'),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => __("Title", 'ancora-utils'),
							"desc" => __("Tooltip title (required)", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => __("Tipped content", 'ancora-utils'),
							"desc" => __("Highlighted content with tooltip", 'ancora-utils'),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),

			
				// Twitter
				"trx_twitter" => array(
					"title" => __("Twitter", 'ancora-utils'),
					"desc" => __("Insert twitter feed into post (page)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"user" => array(
							"title" => __("Twitter Username", 'ancora-utils'),
							"desc" => __("Your username in the twitter account. If empty - get it from Theme Options.", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"consumer_key" => array(
							"title" => __("Consumer Key", 'ancora-utils'),
							"desc" => __("Consumer Key from the twitter account", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"consumer_secret" => array(
							"title" => __("Consumer Secret", 'ancora-utils'),
							"desc" => __("Consumer Secret from the twitter account", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"token_key" => array(
							"title" => __("Token Key", 'ancora-utils'),
							"desc" => __("Token Key from the twitter account", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"token_secret" => array(
							"title" => __("Token Secret", 'ancora-utils'),
							"desc" => __("Token Secret from the twitter account", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"count" => array(
							"title" => __("Tweets number", 'ancora-utils'),
							"desc" => __("Tweets number to show", 'ancora-utils'),
							"divider" => true,
							"value" => 3,
							"max" => 20,
							"min" => 1,
							"type" => "spinner"
						),
						"controls" => array(
							"title" => __("Show arrows", 'ancora-utils'),
							"desc" => __("Show control buttons", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => __("Tweets change interval", 'ancora-utils'),
							"desc" => __("Tweets change interval (in milliseconds: 1000ms = 1s)", 'ancora-utils'),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"align" => array(
							"title" => __("Alignment", 'ancora-utils'),
							"desc" => __("Alignment of the tweets block", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"autoheight" => array(
							"title" => __("Autoheight", 'ancora-utils'),
							"desc" => __("Change whole slider's height (make it equal current slide's height)", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						),
						"bg_tint" => array(
							"title" => __("Background tint", 'ancora-utils'),
							"desc" => __("Main background tint: dark or light", 'ancora-utils'),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"options" => $ANCORA_GLOBALS['sc_params']['tint']
						),
						"bg_color" => array(
							"title" => __("Background color", 'ancora-utils'),
							"desc" => __("Any background color for this section", 'ancora-utils'),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => __("Background image URL", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for the background", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => __("Overlay", 'ancora-utils'),
							"desc" => __("Overlay color opacity (from 0.0 to 1.0)", 'ancora-utils'),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => __("Texture", 'ancora-utils'),
							"desc" => __("Predefined texture style from 1 to 11. 0 - without texture.", 'ancora-utils'),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Video
				"trx_video" => array(
					"title" => __("Video", 'ancora-utils'),
					"desc" => __("Insert video player", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => __("URL for video file", 'ancora-utils'),
							"desc" => __("Select video from media library or paste URL for video file from other site", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => __('Choose video', 'ancora-utils'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => __('Choose video file', 'ancora-utils'),
									'update' => __('Select video file', 'ancora-utils')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"ratio" => array(
							"title" => __("Ratio", 'ancora-utils'),
							"desc" => __("Ratio of the video", 'ancora-utils'),
							"value" => "16:9",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"16:9" => __("16:9", 'ancora-utils'),
								"4:3" => __("4:3", 'ancora-utils')
							)
						),
						"autoplay" => array(
							"title" => __("Autoplay video", 'ancora-utils'),
							"desc" => __("Autoplay video on page load", 'ancora-utils'),
							"value" => "off",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => __("Align", 'ancora-utils'),
							"desc" => __("Select block alignment", 'ancora-utils'),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['align']
						),
						"image" => array(
							"title" => __("Cover image", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for video preview", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image" => array(
							"title" => __("Background image", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for video background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", 'ancora-utils'),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => __("Top offset", 'ancora-utils'),
							"desc" => __("Top offset (padding) inside background image to video block (in percent). For example: 3%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => __("Bottom offset", 'ancora-utils'),
							"desc" => __("Bottom offset (padding) inside background image to video block (in percent). For example: 3%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => __("Left offset", 'ancora-utils'),
							"desc" => __("Left offset (padding) inside background image to video block (in percent). For example: 20%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => __("Right offset", 'ancora-utils'),
							"desc" => __("Right offset (padding) inside background image to video block (in percent). For example: 12%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Zoom
				"trx_zoom" => array(
					"title" => __("Zoom", 'ancora-utils'),
					"desc" => __("Insert the image with zoom/lens effect", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"effect" => array(
							"title" => __("Effect", 'ancora-utils'),
							"desc" => __("Select effect to display overlapping image", 'ancora-utils'),
							"value" => "lens",
							"size" => "medium",
							"type" => "switch",
							"options" => array(
								"lens" => __('Lens', 'ancora-utils'),
								"zoom" => __('Zoom', 'ancora-utils')
							)
						),
						"url" => array(
							"title" => __("Main image", 'ancora-utils'),
							"desc" => __("Select or upload main image", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"over" => array(
							"title" => __("Overlaping image", 'ancora-utils'),
							"desc" => __("Select or upload overlaping image", 'ancora-utils'),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"align" => array(
							"title" => __("Float zoom", 'ancora-utils'),
							"desc" => __("Float zoom to left or right side", 'ancora-utils'),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ANCORA_GLOBALS['sc_params']['float']
						), 
						"bg_image" => array(
							"title" => __("Background image", 'ancora-utils'),
							"desc" => __("Select or upload image or write URL from other site for zoom block background. Attention! If you use background image - specify paddings below from background margins to zoom block in percents!", 'ancora-utils'),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => __("Top offset", 'ancora-utils'),
							"desc" => __("Top offset (padding) inside background image to zoom block (in percent). For example: 3%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => __("Bottom offset", 'ancora-utils'),
							"desc" => __("Bottom offset (padding) inside background image to zoom block (in percent). For example: 3%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => __("Left offset", 'ancora-utils'),
							"desc" => __("Left offset (padding) inside background image to zoom block (in percent). For example: 20%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => __("Right offset", 'ancora-utils'),
							"desc" => __("Right offset (padding) inside background image to zoom block (in percent). For example: 12%", 'ancora-utils'),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => ancora_shortcodes_width(),
						"height" => ancora_shortcodes_height(),
						"top" => $ANCORA_GLOBALS['sc_params']['top'],
						"bottom" => $ANCORA_GLOBALS['sc_params']['bottom'],
						"left" => $ANCORA_GLOBALS['sc_params']['left'],
						"right" => $ANCORA_GLOBALS['sc_params']['right'],
						"id" => $ANCORA_GLOBALS['sc_params']['id'],
						"class" => $ANCORA_GLOBALS['sc_params']['class'],
						"animation" => $ANCORA_GLOBALS['sc_params']['animation'],
						"css" => $ANCORA_GLOBALS['sc_params']['css']
					)
				)
			);
	
			// Woocommerce Shortcodes list
			//------------------------------------------------------------------
			if (ancora_exists_woocommerce()) {
				
				// WooCommerce - Cart
				$ANCORA_GLOBALS['shortcodes']["woocommerce_cart"] = array(
					"title" => __("Woocommerce: Cart", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show Cart page", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Checkout
				$ANCORA_GLOBALS['shortcodes']["woocommerce_checkout"] = array(
					"title" => __("Woocommerce: Checkout", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show Checkout page", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - My Account
				$ANCORA_GLOBALS['shortcodes']["woocommerce_my_account"] = array(
					"title" => __("Woocommerce: My Account", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show My Account page", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Order Tracking
				$ANCORA_GLOBALS['shortcodes']["woocommerce_order_tracking"] = array(
					"title" => __("Woocommerce: Order Tracking", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show Order Tracking page", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Shop Messages
				$ANCORA_GLOBALS['shortcodes']["shop_messages"] = array(
					"title" => __("Woocommerce: Shop Messages", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show shop messages", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Product Page
				$ANCORA_GLOBALS['shortcodes']["product_page"] = array(
					"title" => __("Woocommerce: Product Page", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: display single product page", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => __("SKU", 'ancora-utils'),
							"desc" => __("SKU code of displayed product", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => __("ID", 'ancora-utils'),
							"desc" => __("ID of displayed product", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"posts_per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => "1",
							"min" => 1,
							"type" => "spinner"
						),
						"post_type" => array(
							"title" => __("Post type", 'ancora-utils'),
							"desc" => __("Post type for the WP query (leave 'product')", 'ancora-utils'),
							"value" => "product",
							"type" => "text"
						),
						"post_status" => array(
							"title" => __("Post status", 'ancora-utils'),
							"desc" => __("Display posts only with this status", 'ancora-utils'),
							"value" => "publish",
							"type" => "select",
							"options" => array(
								"publish" => __('Publish', 'ancora-utils'),
								"protected" => __('Protected', 'ancora-utils'),
								"private" => __('Private', 'ancora-utils'),
								"pending" => __('Pending', 'ancora-utils'),
								"draft" => __('Draft', 'ancora-utils')
							)
						)
					)
				);
				
				// WooCommerce - Product
				$ANCORA_GLOBALS['shortcodes']["product"] = array(
					"title" => __("Woocommerce: Product", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: display one product", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => __("SKU", 'ancora-utils'),
							"desc" => __("SKU code of displayed product", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => __("ID", 'ancora-utils'),
							"desc" => __("ID of displayed product", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Best Selling Products
				$ANCORA_GLOBALS['shortcodes']["best_selling_products"] = array(
					"title" => __("Woocommerce: Best Selling Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show best selling products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						)
					)
				);
				
				// WooCommerce - Recent Products
				$ANCORA_GLOBALS['shortcodes']["recent_products"] = array(
					"title" => __("Woocommerce: Recent Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show recent products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Related Products
				$ANCORA_GLOBALS['shortcodes']["related_products"] = array(
					"title" => __("Woocommerce: Related Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show related products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"posts_per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						)
					)
				);
				
				// WooCommerce - Featured Products
				$ANCORA_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Featured Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show featured products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Top Rated Products
				$ANCORA_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Top Rated Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show top rated products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Sale Products
				$ANCORA_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => __("Woocommerce: Sale Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: list products on sale", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product Category
				$ANCORA_GLOBALS['shortcodes']["product_category"] = array(
					"title" => __("Woocommerce: Products from category", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: list products in specified category(-ies)", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"category" => array(
							"title" => __("Categories", 'ancora-utils'),
							"desc" => __("Comma separated category slugs", 'ancora-utils'),
							"value" => '',
							"type" => "text"
						),
						"operator" => array(
							"title" => __("Operator", 'ancora-utils'),
							"desc" => __("Categories operator", 'ancora-utils'),
							"value" => "IN",
							"type" => "checklist",
							"size" => "medium",
							"options" => array(
								"IN" => __('IN', 'ancora-utils'),
								"NOT IN" => __('NOT IN', 'ancora-utils'),
								"AND" => __('AND', 'ancora-utils')
							)
						)
					)
				);
				
				// WooCommerce - Products
				$ANCORA_GLOBALS['shortcodes']["products"] = array(
					"title" => __("Woocommerce: Products", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: list all products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"skus" => array(
							"title" => __("SKUs", 'ancora-utils'),
							"desc" => __("Comma separated SKU codes of products", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => __("IDs", 'ancora-utils'),
							"desc" => __("Comma separated ID of products", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product attribute
				$ANCORA_GLOBALS['shortcodes']["product_attribute"] = array(
					"title" => __("Woocommerce: Products by Attribute", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show products with specified attribute", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many products showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for products output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"attribute" => array(
							"title" => __("Attribute", 'ancora-utils'),
							"desc" => __("Attribute name", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"filter" => array(
							"title" => __("Filter", 'ancora-utils'),
							"desc" => __("Attribute value", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Products Categories
				$ANCORA_GLOBALS['shortcodes']["product_categories"] = array(
					"title" => __("Woocommerce: Product Categories", 'ancora-utils'),
					"desc" => __("WooCommerce shortcode: show categories with products", 'ancora-utils'),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"number" => array(
							"title" => __("Number", 'ancora-utils'),
							"desc" => __("How many categories showed", 'ancora-utils'),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => __("Columns", 'ancora-utils'),
							"desc" => __("How many columns per row use for categories output", 'ancora-utils'),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => __("Order by", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => __('Date', 'ancora-utils'),
								"title" => __('Title', 'ancora-utils')
							)
						),
						"order" => array(
							"title" => __("Order", 'ancora-utils'),
							"desc" => __("Sorting order for products output", 'ancora-utils'),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ANCORA_GLOBALS['sc_params']['ordering']
						),
						"parent" => array(
							"title" => __("Parent", 'ancora-utils'),
							"desc" => __("Parent category slug", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => __("IDs", 'ancora-utils'),
							"desc" => __("Comma separated ID of products", 'ancora-utils'),
							"value" => "",
							"type" => "text"
						),
						"hide_empty" => array(
							"title" => __("Hide empty", 'ancora-utils'),
							"desc" => __("Hide empty categories", 'ancora-utils'),
							"value" => "yes",
							"type" => "switch",
							"options" => $ANCORA_GLOBALS['sc_params']['yes_no']
						)
					)
				);

			}
			
			do_action('ancora_action_shortcodes_list');

		}
	}
}
?>