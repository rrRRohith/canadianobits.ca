<?php

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_options_settings_theme_setup2' ) ) {
	add_action( 'ancora_action_after_init_theme', 'ancora_options_settings_theme_setup2', 1 );
	function ancora_options_settings_theme_setup2() {
		if (ancora_options_is_used()) {
			global $ANCORA_GLOBALS;
			// Replace arrays with actual parameters
			$lists = array();
			foreach ($ANCORA_GLOBALS['options'] as $k=>$v) {
				if (isset($v['options']) && is_array($v['options'])) {
					foreach ($v['options'] as $k1=>$v1) {
						if (ancora_substr($k1, 0, 8) == '$ancora_' || ancora_substr($v1, 0, 8) == '$ancora_') {
							$list_func = ancora_substr(ancora_substr($k1, 0, 8) == '$ancora_' ? $k1 : $v1, 1);
							unset($ANCORA_GLOBALS['options'][$k]['options'][$k1]);
							if (isset($lists[$list_func]))
								$ANCORA_GLOBALS['options'][$k]['options'] = ancora_array_merge($ANCORA_GLOBALS['options'][$k]['options'], $lists[$list_func]);
							else {
								if (function_exists($list_func)) {
									$ANCORA_GLOBALS['options'][$k]['options'] = $lists[$list_func] = ancora_array_merge($ANCORA_GLOBALS['options'][$k]['options'], $list_func == 'ancora_get_list_menus' ? $list_func(true) : $list_func());
							   	} else
							   		echo sprintf(__('Wrong function name %s in the theme options array', 'blessing'), $list_func);
							}
						}
					}
				}
			}
		}
	}
}

// Reset old Theme Options while theme first run
if ( !function_exists( 'ancora_options_reset' ) ) {
    function ancora_options_reset($clear=true) {
        $theme_data = wp_get_theme();
        $slug = str_replace(' ', '_', trim(ancora_strtolower((string) $theme_data->get('Name'))));
        $option_name =  ancora_get_global('options_prefix') . '_' . trim($slug) . '_options_reset';

        // Prepare demo data
        if ( is_dir( ANCORA_THEME_PATH . 'demo/' ) ) {
            $demo_url = ANCORA_THEME_PATH . 'demo/';
        } else {
            $demo_url = esc_url( ancora_get_protocol().'://demofiles.ancorathemes.com/blessing/' ); // Demo-site domain
        }
        $txt = ancora_fgc( $demo_url . 'default/templates_options.txt');


        if ( get_option($option_name, false) === false ) {
            if ($clear) {
                // Remove Theme Options from WP Options
                global $wpdb;
                $wpdb->query( $wpdb->prepare(
                    "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                    ancora_get_global('options_prefix').'_%'
                )
                );
                // Add Templates Options

                if ($txt) {
                    $data = ancora_unserialize($txt);
                    // Replace upload url in options
                    if (is_array($data) && count($data) > 0) {
                        foreach ($data as $k=>$v) {
                            if (is_array($v) && count($v) > 0) {
                                foreach ($v as $k1=>$v1) {
                                    $v[$k1] = ancora_replace_uploads_url(ancora_replace_uploads_url($v1, 'uploads'), 'imports');
                                }
                            }
                            add_option( $k, $v, '', 'yes' );
                        }
                    }
                }
            }
            add_option($option_name, 1, '', 'yes');
        }
    }
}

// Prepare default Theme Options
if ( !function_exists( 'ancora_options_settings_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_options_settings_theme_setup', 2 );	// Priority 1 for add ancora_filter handlers
	function ancora_options_settings_theme_setup() {
		global $ANCORA_GLOBALS;

		// Remove 'false' to clear all saved Theme Options on next run.
		// Attention! Use this way only on new theme installation, not in updates!
        add_action('after_switch_theme', 'ancora_options_reset');

		// Prepare arrays
		$ANCORA_GLOBALS['options_params'] = array(
			'list_fonts'		=> array('$ancora_get_list_fonts' => ''),
			'list_fonts_styles'	=> array('$ancora_get_list_fonts_styles' => ''),
			'list_socials' 		=> array('$ancora_get_list_socials' => ''),
			'list_icons' 		=> array('$ancora_get_list_icons' => ''),
			'list_posts_types' 	=> array('$ancora_get_list_posts_types' => ''),
			'list_categories' 	=> array('$ancora_get_list_categories' => ''),
			'list_menus'		=> array('$ancora_get_list_menus' => ''),
			'list_sidebars'		=> array('$ancora_get_list_sidebars' => ''),
			'list_positions' 	=> array('$ancora_get_list_sidebars_positions' => ''),
			'list_tints'	 	=> array('$ancora_get_list_bg_tints' => ''),
			'list_sidebar_styles' => array('$ancora_get_list_sidebar_styles' => ''),
			'list_skins'		=> array('$ancora_get_list_skins' => ''),
			'list_color_schemes'=> array('$ancora_get_list_color_schemes' => ''),
			'list_body_styles'	=> array('$ancora_get_list_body_styles' => ''),
			'list_blog_styles'	=> array('$ancora_get_list_templates_blog' => ''),
			'list_single_styles'=> array('$ancora_get_list_templates_single' => ''),
			'list_article_styles'=> array('$ancora_get_list_article_styles' => ''),
			'list_animations_in' => array('$ancora_get_list_animations_in' => ''),
			'list_animations_out'=> array('$ancora_get_list_animations_out' => ''),
			'list_filters'		=> array('$ancora_get_list_portfolio_filters' => ''),
			'list_hovers'		=> array('$ancora_get_list_hovers' => ''),
			'list_hovers_dir'	=> array('$ancora_get_list_hovers_directions' => ''),
			'list_sliders' 		=> array('$ancora_get_list_sliders' => ''),
			'list_popups' 		=> array('$ancora_get_list_popup_engines' => ''),
			'list_gmap_styles' 	=> array('$ancora_get_list_googlemap_styles' => ''),
			'list_yes_no' 		=> array('$ancora_get_list_yesno' => ''),
			'list_on_off' 		=> array('$ancora_get_list_onoff' => ''),
			'list_show_hide' 	=> array('$ancora_get_list_showhide' => ''),
			'list_sorting' 		=> array('$ancora_get_list_sortings' => ''),
			'list_ordering' 	=> array('$ancora_get_list_orderings' => ''),
			'list_locations' 	=> array('$ancora_get_list_dedicated_locations' => '')
			);


		// Theme options array
        ancora_set_global('options', apply_filters('ancora_filter_options', array(


		//###############################
		//#### Customization         ####
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'blessing'),
					"start" => "partitions",
					"override" => "category,courses_group,page,post",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),


		// Customization -> General
		//-------------------------------------------------

		'customization_general' => array(
					"title" => esc_html__('General', 'blessing'),
					"override" => "category,courses_group,page,post",
					"icon" => 'iconadmin-cog',
					"start" => "customization_tabs",
					"type" => "tab"
					),

		'info_custom_1' => array(
					"title" => esc_html__('Theme customization general parameters', 'blessing'),
					"desc" => esc_html__('Select main theme skin, customize colors and enable responsive layouts for the small screens', 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"
					),

		'theme_skin' => array(
					"title" => esc_html__('Select theme skin', 'blessing'),
					"desc" => esc_html__('Select skin for the theme decoration', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "blessing",
					"options" => $ANCORA_GLOBALS['options_params']['list_skins'],
					"type" => "select"
					),

		"icon" => array(
					"title" => esc_html__('Select icon', 'blessing'),
					"desc" => esc_html__('Select icon for output before post/category name in some layouts', 'blessing'),
					"override" => "category,courses_group,post",
					"std" => "",
					"options" => $ANCORA_GLOBALS['options_params']['list_icons'],
					"style" => "select",
					"type" => "icons"
					),

		"post_color" => array(
					"title" => esc_html__('Posts color', 'blessing'),
					"desc" => esc_html__('Posts color - used as accent color to display posts in some layouts. If empty - used link, menu and usermenu colors - see below', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"color_scheme" => array(
					"title" => esc_html__('Color scheme', 'blessing'),
					"desc" => esc_html__('Select predefined color scheme. Or set separate colors in fields below', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "original",
					"dir" => "horizontal",
					"options" => $ANCORA_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),

		"link_color" => array(
					"title" => esc_html__('Links color', 'blessing'),
					"desc" => esc_html__('Links color. Also used as background color for the page header area and some other elements', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"link_dark" => array(
					"title" => esc_html__('Links dark color', 'blessing'),
					"desc" => esc_html__('Used as background color for the buttons, hover states and some other elements', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"menu_color" => array(
					"title" => esc_html__('Main menu color', 'blessing'),
					"desc" => esc_html__('Used as background color for the active menu item, calendar item, tabs and some other elements', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"menu_dark" => array(
					"title" => esc_html__('Main menu dark color', 'blessing'),
					"desc" => esc_html__('Used as text color for the menu items (in the Light style), as background color for the selected menu item, etc.', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"user_color" => array(
					"title" => esc_html__('User menu color', 'blessing'),
					"desc" => esc_html__('Used as background color for the user menu items and some other elements', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"user_dark" => array(
					"title" => esc_html__('User menu dark color', 'blessing'),
					"desc" => esc_html__('Used as background color for the selected user menu item, etc.', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),


		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'blessing'),
					"desc" => esc_html__('Do you want to show theme customizer in the left panel? Your website visitors will be able to customise it yourself.', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'blessing'),
					"desc" => esc_html__('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'blessing'),
					"divider" => false,
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),

		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'blessing'),
					"desc" => esc_html__('Do you want use extended animations effects on your site?', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'remember_visitors_settings' => array(
					"title" => esc_html__('Remember visitor\'s settings', 'blessing'),
					"desc" => esc_html__('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'blessing'),
					"desc" => esc_html__('Do you want use responsive layouts on small screen or still use main layout?', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'blessing'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'blessing') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'blessing') ),
                "type"  => "text"
            ),


		// Customization -> Body Style
		//-------------------------------------------------

		'customization_body' => array(
					"title" => esc_html__('Body style', 'blessing'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-picture-1',
					"type" => "tab"
					),

		'info_custom_3' => array(
					"title" => esc_html__('Body parameters', 'blessing'),
					"desc" => esc_html__('Background color, pattern and image used only for fixed body style.', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),

		'body_style' => array(
					"title" => esc_html__('Body style', 'blessing'),
					"desc" => esc_html__('Select body style:<br><b>boxed</b> - if you want use background color and/or image,<br><b>wide</b> - page fill whole window with centered content,<br><b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings),<br><b>fullscreen</b> - page content fill whole window without any paddings', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "wide",
					"options" => $ANCORA_GLOBALS['options_params']['list_body_styles'],
					"dir" => "horizontal",
					"type" => "radio"
					),

		'body_filled' => array(
					"title" => esc_html__('Fill body', 'blessing'),
					"desc" => esc_html__('Fill the body background with the solid color (white or grey) or leave it transparend to show background image (or video)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'load_bg_image' => array(
					"title" => esc_html__('Load background image', 'blessing'),
					"desc" => esc_html__('Always load background images or only for boxed body style', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "boxed",
					"size" => "medium",
					"options" => array(
						'boxed' => esc_html__('Boxed', 'blessing'),
						'always' => esc_html__('Always', 'blessing')
					),
					"type" => "switch"
					),

		'bg_color' => array(
					"title" => esc_html__('Background color',  'blessing'),
					"desc" => esc_html__('Body background color',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "#bfbfbf",
					"type" => "color"
					),

		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'blessing'),
					"desc" => esc_html__('Select theme background pattern (first case - without pattern)',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"options" => array(
						0 => ancora_get_file_url('/images/spacer.png'),
						1 => ancora_get_file_url('/images/bg/pattern_1.png'),
						2 => ancora_get_file_url('/images/bg/pattern_2.png'),
						3 => ancora_get_file_url('/images/bg/pattern_3.png'),
						4 => ancora_get_file_url('/images/bg/pattern_4.png'),
						5 => ancora_get_file_url('/images/bg/pattern_5.png'),
						6 => ancora_get_file_url('/images/bg/pattern_6.png'),
						7 => ancora_get_file_url('/images/bg/pattern_7.png'),
						8 => ancora_get_file_url('/images/bg/pattern_8.png'),
						9 => ancora_get_file_url('/images/bg/pattern_9.png')
					),
					"style" => "list",
					"type" => "images"
					),

		'bg_custom_pattern' => array(
					"title" => esc_html__('Background custom pattern',  'blessing'),
					"desc" => esc_html__('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),

		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'blessing'),
					"desc" => esc_html__('Select theme background image (first case - without image)',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"options" => array(
						0 => ancora_get_file_dir('/images/spacer.png'),
						1 => ancora_get_file_dir('/images/bg/image_1_thumb.jpg'),
						2 => ancora_get_file_dir('/images/bg/image_2_thumb.jpg'),
						3 => ancora_get_file_dir('/images/bg/image_3_thumb.jpg'),
						4 => ancora_get_file_dir('/images/bg/image_4_thumb.jpg'),
						5 => ancora_get_file_dir('/images/bg/image_5_thumb.jpg'),
						6 => ancora_get_file_dir('/images/bg/image_6_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),

		'bg_custom_image' => array(
					"title" => esc_html__('Background custom image',  'blessing'),
					"desc" => esc_html__('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),

		'bg_custom_image_position' => array(
					"title" => esc_html__('Background custom image position',  'blessing'),
					"desc" => esc_html__('Select custom image position',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "left_top",
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),

		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'blessing'),
					"desc" => esc_html__("Show video on the site background (only for Fullscreen body style)", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'blessing'),
					"desc" => esc_html__("Youtube code of video", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "text"
					),

		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'blessing'),
					"desc" => esc_html__("URL to video-file (uploaded on your site)", 'blessing'),
					"readonly" =>false,
					"override" => "category,courses_group,post,page",
					"before" => array(	'title' => esc_html__('Choose video', 'blessing'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'blessing'),
															'update' => esc_html__( 'Select Video', 'blessing')
														)
								),
					"std" => "",
					"type" => "media"
					),

		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'blessing'),
					"desc" => esc_html__('Use overlay texture for the video background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),



		// Customization -> Logo
		//-------------------------------------------------

		'customization_logo' => array(
					"title" => esc_html__('Logo', 'blessing'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-heart-1',
					"type" => "tab"
					),

		'info_custom_4' => array(
					"title" => esc_html__('Main logo', 'blessing'),
					"desc" => esc_html__('Select or upload logos for the site\'s header and select it position', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),

		'favicon' => array(
					"title" => esc_html__('Favicon', 'blessing'),
					"desc" => esc_html__('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="//www.favicon.cc/">www.favicon.cc</a>)</em>', 'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_dark' => array(
					"title" => esc_html__('Logo image (dark header)', 'blessing'),
					"desc" => esc_html__('Main logo image for the dark header', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"
					),

		'logo_light' => array(
					"title" => esc_html__('Logo image (light header)', 'blessing'),
					"desc" => esc_html__('Main logo image for the light header', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'blessing'),
					"desc" => esc_html__('Logo image for the header (if menu is fixed after the page is scrolled)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_from_skin' => array(
					"title" => esc_html__('Logo from skin',  'blessing'),
					"desc" => esc_html__("Use logo images from current skin folder if not filled out fields above", 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'blessing'),
					"desc" => esc_html__('Logo text - display it after logo image', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_slogan' => array(
					"title" => esc_html__('Logo slogan', 'blessing'),
					"desc" => esc_html__('Logo slogan - display it under logo image (instead the site slogan)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'blessing'),
					"desc" => esc_html__('Height for the logo in the header area', 'blessing'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'blessing'),
					"desc" => esc_html__('Top offset for the logo in the header area', 'blessing'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),

		'logo_align' => array(
					"title" => esc_html__('Logo alignment', 'blessing'),
					"desc" => esc_html__('Logo alignment (only if logo above menu)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "left",
					"options" =>  array("left"=> esc_html__("Left", 'blessing'), "center"=> esc_html__("Center", 'blessing'), "right"=> esc_html__("Right", 'blessing')),
					"dir" => "horizontal",
					"type" => "hidden"
					),

		'iinfo_custom_5' => array(
					"title" => esc_html__('Logo for footer', 'blessing'),
					"desc" => esc_html__('Select or upload logos for the site\'s footer and set it height', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"
					),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'blessing'),
					"desc" => esc_html__('Logo image for the footer', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'blessing'),
					"desc" => esc_html__('Height for the logo in the footer area (in contacts)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),



		// Customization -> Menus
		//-------------------------------------------------

		"customization_menus" => array(
					"title" => esc_html__('Menus', 'blessing'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-menu',
					"type" => "tab"),

		"info_custom_6" => array(
					"title" => esc_html__('Top panel', 'blessing'),
					"desc" => esc_html__('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),

		"top_panel_position" => array(
					"title" => esc_html__('Top panel position', 'blessing'),
					"desc" => esc_html__('Select position for the top panel with logo and main menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'blessing'),
						'above' => esc_html__('Above slider', 'blessing'),
						'below' => esc_html__('Below slider', 'blessing'),
						'over'  => esc_html__('Over slider', 'blessing')
					),
					"type" => "checklist"),

		"top_panel_style" => array(
					"title" => esc_html__('Top panel style', 'blessing'),
					"desc" => esc_html__('Select background style for the top panel with logo and main menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "dark",
					"options" => array(
						'dark' => esc_html__('Dark', 'blessing'),
						'light' => esc_html__('Light', 'blessing')
					),
					"type" => "checklist"),

		"top_panel_opacity" => array(
					"title" => esc_html__('Top panel opacity', 'blessing'),
					"desc" => esc_html__('Select background opacity for the top panel with logo and main menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "transparent",
					"options" => array(
						'solid' => esc_html__('Solid', 'blessing'),
						'transparent' => esc_html__('Transparent', 'blessing')
					),
					"type" => "checklist"),

		'top_panel_bg_color' => array(
					"title" => esc_html__('Top panel bg color',  'blessing'),
					"desc" => esc_html__('Background color for the top panel',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"
					),

		"top_panel_bg_image" => array(
					"title" => esc_html__('Top panel bg image', 'blessing'),
					"desc" => esc_html__('Upload top panel background image', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"),


		"info_custom_7" => array(
					"title" => esc_html__('Main menu style and position', 'blessing'),
					"desc" => esc_html__('Select the Main menu style and position', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),

		"menu_main" => array(
					"title" => esc_html__('Select main menu',  'blessing'),
					"desc" => esc_html__('Select main menu for the current page',  'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "default",
					"options" => $ANCORA_GLOBALS['options_params']['list_menus'],
					"type" => "select"),

		"menu_position" => array(
					"title" => esc_html__('Main menu position', 'blessing'),
					"desc" => esc_html__('Attach main menu to top of window then page scroll down', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "fixed",
					"options" => array("fixed"=> esc_html__("Fix menu position", 'blessing'), "none"=> esc_html__("Don't fix menu position", 'blessing')),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_align" => array(
					"title" => esc_html__('Main menu alignment', 'blessing'),
					"desc" => esc_html__('Main menu alignment', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "center",
					"options" => array(

						"center" => esc_html__("Center (under logo)", 'blessing'),

					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_slider" => array(
					"title" => esc_html__('Main menu slider', 'blessing'),
					"desc" => esc_html__('Use slider background for main menu items', 'blessing'),
					"std" => "yes",
					"type" => "switch",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no']),

		"menu_animation_in" => array(
					"title" => esc_html__('Submenu show animation', 'blessing'),
					"desc" => esc_html__('Select animation to show submenu ', 'blessing'),
					"std" => "fadeIn",
					"type" => "select",
					"options" => $ANCORA_GLOBALS['options_params']['list_animations_in']),

		"menu_animation_out" => array(
					"title" => esc_html__('Submenu hide animation', 'blessing'),
					"desc" => esc_html__('Select animation to hide submenu ', 'blessing'),
					"std" => "fadeOutDown",
					"type" => "select",
					"options" => $ANCORA_GLOBALS['options_params']['list_animations_out']),

		"menu_relayout" => array(
					"title" => esc_html__('Main menu relayout', 'blessing'),
					"desc" => esc_html__('Allow relayout main menu if window width less then this value', 'blessing'),
					"std" => 960,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),

		"menu_responsive" => array(
					"title" => esc_html__('Main menu responsive', 'blessing'),
					"desc" => esc_html__('Allow responsive version for the main menu if window width less then this value', 'blessing'),
					"std" => 640,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),

		"menu_width" => array(
					"title" => esc_html__('Submenu width', 'blessing'),
					"desc" => esc_html__('Width for dropdown menus in main menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),



		"info_custom_8" => array(
					"title" => esc_html__("User's menu area components", 'blessing'),
					"desc" => esc_html__("Select parts for the user's menu area", 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_menu_user" => array(
					"title" => esc_html__('Show user menu area', 'blessing'),
					"desc" => esc_html__('Show user menu area on top of page', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'blessing'),
					"desc" => esc_html__('Select user menu for the current page',  'blessing'),
                    "override" => "category,courses_group,post,page",
                    "divider" => false,
                    "std" => "default",
                    "options" => $ANCORA_GLOBALS['options_params']['list_menus'],
                    "type" => "select"),

		"show_contact_info" => array(
					"title" => esc_html__('Show contact info', 'blessing'),
					"desc" => esc_html__("Show the contact details for the owner of the site at the top left corner of the page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_currency" => array(
					"title" => esc_html__('Show currency selector', 'blessing'),
					"desc" => esc_html__('Show currency selector in the user menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "hidden"),

		"show_cart" => array(
					"title" => esc_html__('Show cart button', 'blessing'),
					"desc" => esc_html__('Show cart button in the user menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "hide",
					"options" => array(
						'hide'   => esc_html__('Hide', 'blessing'),
						'always' => esc_html__('Always', 'blessing'),
						'shop'   => esc_html__('Only on shop pages', 'blessing')
					),
					"type" => "hidden"),

		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'blessing'),
					"desc" => esc_html__('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_login" => array(
					"title" => esc_html__('Show Login/Logout buttons', 'blessing'),
					"desc" => esc_html__('Show Login and Logout buttons in the user menu area', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "hidden"),

		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'blessing'),
					"desc" => esc_html__('Show bookmarks selector in the user menu', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "hidden"),




		"info_custom_9" => array(
					"title" => esc_html__("Table of Contents (TOC)", 'blessing'),
					"desc" => esc_html__("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"menu_toc" => array(
					"title" => esc_html__('TOC position', 'blessing'),
					"desc" => esc_html__('Show TOC for the current page', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'blessing'),
						'fixed' => esc_html__('Fixed', 'blessing'),
						'float' => esc_html__('Float', 'blessing')
					),
					"type" => "checklist"),

		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'blessing'),
					"desc" => esc_html__('Automatically add "Home" item into table of contents - return to home page of the site', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"menu_toc_top" => array(
					"title" => esc_html__('Add "To Top" into TOC', 'blessing'),
					"desc" => esc_html__('Automatically add "To Top" item into table of contents - scroll to top of the page', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),





		// Customization -> Sidebars
		//-------------------------------------------------

		"customization_sidebars" => array(
					"title" => esc_html__('Sidebars', 'blessing'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),

		"info_custom_10" => array(
					"title" => esc_html__('Custom sidebars', 'blessing'),
					"desc" => esc_html__('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'blessing'),
					"type" => "info"),

		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'blessing'),
					"desc" => esc_html__('Manage custom sidebars. You can use it with each category (page, post) independently',  'blessing'),
					"divider" => false,
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		"info_custom_11" => array(
					"title" => esc_html__('Sidebars settings', 'blessing'),
					"desc" => esc_html__('Show / Hide and Select sidebar in each location', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),

		'show_sidebar_main' => array(
					"title" => esc_html__('Show main sidebar',  'blessing'),
					"desc" => esc_html__('Select style for the main sidebar or hide it',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "light",
					"options" => $ANCORA_GLOBALS['options_params']['list_sidebar_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),

		'sidebar_main_position' => array(
					"title" => esc_html__('Main sidebar position',  'blessing'),
					"desc" => esc_html__('Select main sidebar position on blog page',  'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "right",
					"options" => $ANCORA_GLOBALS['options_params']['list_positions'],
					"size" => "medium",
					"type" => "switch"),

		"sidebar_main" => array(
					"title" => esc_html__('Select main sidebar',  'blessing'),
					"desc" => esc_html__('Select main sidebar for the blog page',  'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "sidebar_main",
					"options" => $ANCORA_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),

		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'blessing'),
					"desc" => esc_html__('Select style for the footer sidebar or hide it', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "Light",
					"options" => $ANCORA_GLOBALS['options_params']['list_sidebar_styles'],
					"dir" => "horizontal",
					"type" => "checklist"),

		"sidebar_footer" => array(
					"title" => esc_html__('Select footer sidebar',  'blessing'),
					"desc" => esc_html__('Select footer sidebar for the blog page',  'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "sidebar_footer",
					"options" => $ANCORA_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),


		"sidebar_footer_columns" => array(
					"title" => esc_html__('Footer sidebar columns',  'blessing'),
					"desc" => esc_html__('Select columns number for the footer sidebar',  'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),

            "show_sidebar_footer2" => array(
                "title" => esc_html__('Show additional footer sidebar', 'blessing'),
                "desc" => esc_html__('Select style for the additional footer sidebar or hide it', 'blessing'),
                "override" => "category,courses_group,post,page",
                "std" => "none",
                "options" => $ANCORA_GLOBALS['options_params']['list_sidebar_styles'],
                "dir" => "horizontal",
                "type" => "checklist"),

            "sidebar_footer2" => array(
                "title" => esc_html__('Select additional footer sidebar',  'blessing'),
                "desc" => esc_html__('Select additional footer sidebar for the blog page',  'blessing'),
                "override" => "category,courses_group,post,page",
                "divider" => false,
                "std" => "sidebar_footer2",
                "options" => $ANCORA_GLOBALS['options_params']['list_sidebars'],
                "type" => "select"),

            "sidebar_footer2_columns" => array(
                "title" => esc_html__('Footer additional sidebar columns',  'blessing'),
                "desc" => esc_html__('Select columns number for the additional footer sidebar',  'blessing'),
                "override" => "category,courses_group,post,page",
                "divider" => false,
                "std" => 3,
                "min" => 1,
                "max" => 6,
                "type" => "spinner"),




		// Customization -> Slider
		//-------------------------------------------------

		"customization_slider" => array(
					"title" => esc_html__('Slider', 'blessing'),
					"icon" => "iconadmin-picture",
					"override" => "category,courses_group,page",
					"type" => "tab"),

		"info_custom_13" => array(
					"title" => esc_html__('Main slider parameters', 'blessing'),
					"desc" => esc_html__('Select parameters for main slider (you can override it in each category and page)', 'blessing'),
					"override" => "category,courses_group,page",
					"type" => "info"),

		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'blessing'),
					"desc" => esc_html__('Do you want to show slider on each page (post)', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_display" => array(
					"title" => esc_html__('Slider display', 'blessing'),
					"desc" => esc_html__('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "none",
					"options" => array(
						"boxed"=> esc_html__("Boxed", 'blessing'),
						"fullwide"=> esc_html__("Fullwide", 'blessing'),
						"fullscreen"=> esc_html__("Fullscreen", 'blessing')
					),
					"type" => "checklist"),

		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'blessing'),
					"desc" => esc_html__("Slider height (in pixels) - only if slider display with fixed height.", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),

		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'blessing'),
					"desc" => esc_html__('What engine use to show slider?', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "flex",
					"options" => $ANCORA_GLOBALS['options_params']['list_sliders'],
					"type" => "radio"),

		"slider_alias" => array(
					"title" => esc_html__('Layer Slider: Alias (for Revolution) or ID (for Royal)',  'blessing'),
					"desc" => esc_html__("Revolution Slider alias or Royal Slider ID (see in slider settings on plugin page)", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "",
					"type" => "text"),

		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'blessing'),
					"desc" => esc_html__('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "",
					"options" => ancora_array_merge(array(0 => esc_html__('- Select category -', 'blessing')), $ANCORA_GLOBALS['options_params']['list_categories']),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),

		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'blessing'),
					"desc" => esc_html__("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "5",
					"type" => "text"),
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'blessing'),
					"desc" => esc_html__("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "date",
					"options" => $ANCORA_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),

		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'blessing'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "desc",
					"options" => $ANCORA_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),

		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'blessing'),
					"desc" => esc_html__("Interval (in ms) for slides change in slider", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),

		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'blessing'),
					"desc" => esc_html__("Choose pagination style for the slider", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'blessing'),
						'yes'  => esc_html__('Dots', 'blessing'),
						'over' => esc_html__('Titles', 'blessing')
					),
					"type" => "checklist"),

		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'blessing'),
					"desc" => esc_html__("Do you want to show post's title, reviews rating and description on slides in slider", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'blessing'),
						'slide' => esc_html__('Slide', 'blessing'),
						'fixed' => esc_html__('Fixed', 'blessing')
					),
					"type" => "checklist"),

		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'blessing'),
					"desc" => esc_html__("Do you want to show post's category on slides in slider", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'blessing'),
					"desc" => esc_html__("Do you want to show post's reviews rating on slides in slider", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'blessing'),
					"desc" => esc_html__("How many characters show in the post's description in slider. 0 - no descriptions", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),




		// Customization -> Header & Footer
		//-------------------------------------------------

		'customization_header_footer' => array(
					"title" => esc_html__("Header &amp; Footer", 'blessing'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-window',
					"type" => "tab"),


		"info_footer_1" => array(
					"title" => esc_html__("Header settings", 'blessing'),
					"desc" => esc_html__("Select components of the page header, set style and put the content for the user's header area", 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

        "disclaimer" => array(
                    "title" => esc_html__('Disclaimer in top',  'blessing'),
                    "desc" => esc_html__("Enter disclaimer in top", 'blessing'),
                    "std" => "",
                    "type" => "text"),

        "show_flower_block" => array(
                    "title" => esc_html__("Show flower block", 'blessing'),
                    "desc" => esc_html__("Show flower block", 'blessing'),
                    "override" => "category,courses_group,page,post",
                    "std" => "no",
                    "options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
                    "type" => "switch"),
        'flower_image' => array(
                    "title" => esc_html__('Image for flower block',  'blessing'),
                    "desc" => esc_html__('Select or upload image for flower block',  'blessing'),
                    "override" => "category,courses_group,post,page",
                    "std" => "",
                    "type" => "media"
                   ),
        "flower_title" => array(
                    "title" => esc_html__('Flower title',  'blessing'),
                    "desc" => esc_html__("Flower title text", 'blessing'),
                    "std" => "",
                    "divider" => false,
                    "type" => "text"),
        "link_under_flower_title" => array(
                    "title" => esc_html__('Link under flower title',  'blessing'),
                    "desc" => esc_html__("Link under flower title", 'blessing'),
                    "std" => "",
                    "divider" => false,
                    "type" => "text"),
        "text_under_flower_title" => array(
                    "title" => esc_html__('Text under flower title',  'blessing'),
                    "desc" => esc_html__("Text under flower title", 'blessing'),
                    "std" => "",
                    "divider" => false,
                    "type" => "text"),

        "show_number_block" => array(
                    "title" => esc_html__("Show phone block", 'blessing'),
                    "desc" => esc_html__("Show phone block", 'blessing'),
                    "override" => "category,courses_group,page,post",
                    "std" => "no",
                    "options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
                    "type" => "switch"),
        'number_image' => array(
                    "title" => esc_html__('Image for phone block',  'blessing'),
                    "desc" => esc_html__('Select or upload image for phone block',  'blessing'),
                    "override" => "category,courses_group,post,page",
                    "std" => "",
                    "type" => "media"
                    ),
        "text_under_number_title" => array(
                    "title" => esc_html__('Text under number title',  'blessing'),
                    "desc" => esc_html__("Text under number title", 'blessing'),
                    "std" => "",
                    "divider" => false,
                    "type" => "text"),

    	"show_user_header" => array(
					"title" => esc_html__("Show user's header", 'blessing'),
					"desc" => esc_html__("Show custom user's header", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"user_header_content" => array(
					"title" => esc_html__("User's header content", 'blessing'),
					"desc" => esc_html__('Put header html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),

		"show_page_top" => array(
					"title" => esc_html__('Show Top of page section', 'blessing'),
					"desc" => esc_html__('Show top section with post/page/category title and breadcrumbs', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'blessing'),
					"desc" => esc_html__('Show post/page/category title', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'blessing'),
					"desc" => esc_html__('Show path to current category (post, page)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'blessing'),
					"desc" => esc_html__("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'blessing'),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),




		"info_footer_2" => array(
					"title" => esc_html__("Footer settings", 'blessing'),
					"desc" => esc_html__("Select components of the footer, set style and put the content for the user's footer area", 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_user_footer" => array(
					"title" => esc_html__("Show user's footer", 'blessing'),
					"desc" => esc_html__("Show custom user's footer", 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"user_footer_content" => array(
					"title" => esc_html__("User's footer content", 'blessing'),
					"desc" => esc_html__('Put footer html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"rows" => "10",
					"type" => "editor"),

		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'blessing'),
					"desc" => esc_html__('Show contact information area in footer: site logo, contact info and large social icons', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "dark",
					"options" => array(
						'hide' 	=> esc_html__('Hide', 'blessing'),
						'light'	=> esc_html__('Light', 'blessing'),
						'dark'	=> esc_html__('Dark', 'blessing')
					),
					"dir" => "horizontal",
					"type" => "checklist"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'blessing'),
					"desc" => esc_html__('Show area with copyright information and small social icons in footer', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'blessing'),
					"desc" => esc_html__("Copyright text to show in footer area (bottom of site)", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "ANCORA &copy; {Y} All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),


		"info_footer_3" => array(
					"title" => esc_html__('Testimonials in Footer', 'blessing'),
					"desc" => esc_html__('Select parameters for Testimonials in the Footer (you can override it in each category and page)', 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'blessing'),
					"desc" => esc_html__('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $ANCORA_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"testimonials_count" => array(
					"title" => esc_html__('Testimonials count', 'blessing'),
					"desc" => esc_html__('Number testimonials to show', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"testimonials_bg_image" => array(
					"title" => esc_html__('Testimonials bg image', 'blessing'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as testimonials block background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"readonly" => false,
					"std" => "",
					"type" => "media"),

		"testimonials_bg_color" => array(
					"title" => esc_html__('Testimonials bg color', 'blessing'),
					"desc" => esc_html__('Select color to use it as testimonials block background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"testimonials_bg_overlay" => array(
					"title" => esc_html__('Testimonials bg overlay', 'blessing'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),


		"info_footer_4" => array(
					"title" => esc_html__('Twitter in Footer', 'blessing'),
					"desc" => esc_html__('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'blessing'),
					"desc" => esc_html__('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'blessing'),
					"override" => "category,courses_group,post,page",
					"divider" => false,
					"std" => "none",
					"options" => $ANCORA_GLOBALS['options_params']['list_tints'],
					"type" => "checklist"),

		"twitter_count" => array(
					"title" => esc_html__('Twitter count', 'blessing'),
					"desc" => esc_html__('Number twitter to show', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"twitter_bg_image" => array(
					"title" => esc_html__('Twitter bg image', 'blessing'),
					"desc" => esc_html__('Select image or put image URL from other site to use it as Twitter block background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "media"),

		"twitter_bg_color" => array(
					"title" => esc_html__('Twitter bg color', 'blessing'),
					"desc" => esc_html__('Select color to use it as Twitter block background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "",
					"type" => "color"),

		"twitter_bg_overlay" => array(
					"title" => esc_html__('Twitter bg overlay', 'blessing'),
					"desc" => esc_html__('Select background color opacity to create overlay effect on background', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => 0,
					"step" => 0.1,
					"min" => 0,
					"max" => 1,
					"type" => "spinner"),


		"info_footer_5" => array(
					"title" => esc_html__('Google map parameters', 'blessing'),
					"desc" => esc_html__('Select parameters for Google map (you can override it in each category and page)', 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'blessing'),
					"desc" => esc_html__('Do you want to show Google map on each page (post)', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'blessing'),
					"desc" => esc_html__("Map height (default - in pixels, allows any CSS units of measure)", 'blessing'),
					"override" => "category,courses_group,page",
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),

		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'blessing'),
					"desc" => esc_html__("Enter address to show on map center", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),

		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longtitude to show on map',  'blessing'),
					"desc" => esc_html__("Enter coordinates (separated by comma) to show on map center (instead of address)", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),

		"googlemap_title" => array(
					"title" => esc_html__("Marker's title",  'blessing'),
					"desc" => esc_html__("Title to be displayed when hovering on the marker", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),

		"googlemap_description" => array(
					"title" => esc_html__("Marker's description",  'blessing'),
					"desc" => esc_html__("Description to be displayed when clicking on the marker", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "",
					"type" => "text"),

		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'blessing'),
					"desc" => esc_html__("Enter desired initial zoom for Google map", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),

		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'blessing'),
					"desc" => esc_html__("Select style to show Google map", 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => 'style1',
					"options" => $ANCORA_GLOBALS['options_params']['list_gmap_styles'],
					"type" => "select"),

		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'blessing'),
					"desc" => esc_html__("Select or upload png-image with Google map marker", 'blessing'),
					"std" => '',
					"type" => "media"),




		// Customization -> Media
		//-------------------------------------------------

		'customization_media' => array(
					"title" => esc_html__('Media', 'blessing'),
					"override" => "category,courses_group,post,page",
					"icon" => 'iconadmin-picture',
					"type" => "tab"),

		"info_media_1" => array(
					"title" => esc_html__('Retina ready', 'blessing'),
					"desc" => esc_html__("Additional parameters for the Retina displays", 'blessing'),
					"type" => "info"),

		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'blessing'),
					"desc" => esc_html__('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'blessing'),
					"divider" => false,
					"std" => "1",
					"size" => "medium",
					"options" => array("1"=> esc_html__("Original", 'blessing'), "2"=> esc_html__("Retina", 'blessing')),
					"type" => "switch"),

		"info_media_2" => array(
					"title" => esc_html__('Media Substitution parameters', 'blessing'),
					"desc" => esc_html__("Set up the media substitution parameters and slider's options", 'blessing'),
					"override" => "category,courses_group,page,post",
					"type" => "info"),

		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'blessing'),
					"desc" => esc_html__('Substitute standard Wordpress gallery with our slider on the single pages', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"substitute_slider_engine" => array(
					"title" => esc_html__('Substitution Slider engine', 'blessing'),
					"desc" => esc_html__('What engine use to show slider instead standard gallery?', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "swiper",
					"options" => array(

						"swiper" => esc_html__("Swiper slider", 'blessing')
					),
					"type" => "radio"),

		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'blessing'),
					"desc" => esc_html__('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'blessing'),
					"desc" => esc_html__('Maximum images number from gallery into slider', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),

		"popup_engine" => array(
					"title" => esc_html__('Gallery popup engine', 'blessing'),
					"desc" => esc_html__('Select engine to show popup windows with galleries', 'blessing'),
					"std" => "magnific",
					"options" => $ANCORA_GLOBALS['options_params']['list_popups'],
					"type" => "select"),

		"popup_gallery" => array(
					"title" => esc_html__('Enable Gallery mode in the popup', 'blessing'),
					"desc" => esc_html__('Enable Gallery mode in the popup or show only single image', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),


		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'blessing'),
					"desc" => esc_html__('Substitute audio tag with source from soundcloud to embed player', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'blessing'),
					"desc" => esc_html__('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'blessing'),
					"desc" => esc_html__('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),





		// Customization -> Typography
		//-------------------------------------------------

		'customization_typography' => array(
					"title" => esc_html__("Typography", 'blessing'),
					"icon" => 'iconadmin-font',
					"type" => "tab"),

		"info_typo_1" => array(
					"title" => esc_html__('Typography settings', 'blessing'),
					"desc" => esc_html__('Select fonts, sizes and styles for the headings and paragraphs. You can use Google fonts and custom fonts.<br><br>How to install custom @font-face fonts into the theme?<br>All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!<br>Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.<br>Create your @font-face kit by using <a href="//www.fontsquirrel.com/fontface/generator">Fontsquirrel @font-face Generator</a> and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install.', 'blessing'),
					"type" => "info"),

		"typography_custom" => array(
					"title" => esc_html__('Use custom typography', 'blessing'),
					"desc" => esc_html__('Use custom font settings or leave theme-styled fonts', 'blessing'),
					"divider" => false,
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"typography_h1_font" => array(
					"title" => esc_html__('Heading 1', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h1_size" => array(
					"title" => esc_html__('Size', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "48",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h1_lineheight" => array(
					"title" => esc_html__('Line height', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "60",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h1_weight" => array(
					"title" => esc_html__('Weight', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h1_style" => array(
					"title" => esc_html__('Style', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h1_color" => array(
					"title" => esc_html__('Color', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_h2_font" => array(
					"title" => esc_html__('Heading 2', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h2_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "36",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h2_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "43",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h2_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h2_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h2_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_h3_font" => array(
					"title" => esc_html__('Heading 3', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h3_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h3_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "28",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h3_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h3_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h3_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_h4_font" => array(
					"title" => esc_html__('Heading 4', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h4_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h4_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "24",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h4_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h4_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h4_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_h5_font" => array(
					"title" => esc_html__('Heading 5', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h5_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h5_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "20",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h5_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h5_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h5_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_h6_font" => array(
					"title" => esc_html__('Heading 6', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Signika",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_h6_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "16",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_h6_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "18",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_h6_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "400",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_h6_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_h6_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),

		"typography_p_font" => array(
					"title" => esc_html__('Paragraph text', 'blessing'),
					"desc" => '',
					"divider" => false,
					"columns" => "3_8 first",
					"std" => "Source Sans Pro",
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts'],
					"type" => "fonts"),

		"typography_p_size" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "14",
					"step" => 1,
					"from" => 12,
					"to" => 60,
					"type" => "select"),

		"typography_p_lineheight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "21",
					"step" => 1,
					"from" => 12,
					"to" => 100,
					"type" => "select"),

		"typography_p_weight" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "300",
					"step" => 100,
					"from" => 100,
					"to" => 900,
					"type" => "select"),

		"typography_p_style" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8",
					"std" => "",
					"multiple" => true,
					"options" => $ANCORA_GLOBALS['options_params']['list_fonts_styles'],
					"type" => "checklist"),

		"typography_p_color" => array(
					"title" => '',
					"desc" => '',
					"divider" => false,
					"columns" => "1_8 last",
					"std" => "#222222",
					"style" => "custom",
					"type" => "color"),












		//###############################
		//#### Blog and Single pages ####
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'blessing'),
					"icon" => "iconadmin-docs",
					"override" => "category,courses_group,post,page",
					"type" => "partition"),



		// Blog -> Stream page
		//-------------------------------------------------

		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'blessing'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),

		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'blessing'),
					"desc" => esc_html__('Select desired blog streampage parameters (you can override it in each category)', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),

		"blog_style" => array(
					"title" => esc_html__('Blog style', 'blessing'),
					"desc" => esc_html__('Select desired blog style', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,page",
					"std" => "excerpt",
					"options" => $ANCORA_GLOBALS['options_params']['list_blog_styles'],
					"type" => "select"),

		"article_style" => array(
					"title" => esc_html__('Article style', 'blessing'),
					"desc" => esc_html__('Select article display method: boxed or stretch', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "stretch",
					"options" => $ANCORA_GLOBALS['options_params']['list_article_styles'],
					"size" => "medium",
					"type" => "switch"),

		"hover_style" => array(
					"title" => esc_html__('Hover style', 'blessing'),
					"desc" => esc_html__('Select desired hover style (only for Blog style = Portfolio)', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "square effect_shift",
					"options" => $ANCORA_GLOBALS['options_params']['list_hovers'],
					"type" => "select"),

		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'blessing'),
					"desc" => esc_html__('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "left_to_right",
					"options" => $ANCORA_GLOBALS['options_params']['list_hovers_dir'],
					"type" => "select"),

		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'blessing'),
					"desc" => esc_html__('Select location for the dedicated content or featured image in the "excerpt" blog style', 'blessing'),
					"override" => "category,courses_group,page,post",
					"std" => "default",
					"options" => $ANCORA_GLOBALS['options_params']['list_locations'],
					"type" => "select"),

		"show_filters" => array(
					"title" => esc_html__('Show filters', 'blessing'),
					"desc" => esc_html__('Show filter buttons (only for Blog style = Portfolio, Masonry, Classic)', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "hide",
					"options" => $ANCORA_GLOBALS['options_params']['list_filters'],
					"type" => "checklist"),

		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'blessing'),
					"desc" => esc_html__('Select the desired sorting method for posts', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "date",
					"options" => $ANCORA_GLOBALS['options_params']['list_sorting'],
					"dir" => "vertical",
					"type" => "radio"),

		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'blessing'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "desc",
					"options" => $ANCORA_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),

		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'blessing'),
					"desc" => esc_html__('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'blessing'),
					"override" => "category,courses_group,page",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),

		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt(Obituaries) maxlength for streampage',  'blessing'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'blessing'),
					"override" => "category,courses_group,page",
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),

		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'blessing'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'blessing'),
					"override" => "category,courses_group,page",
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),




		// Blog -> Single page
		//-------------------------------------------------

		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'blessing'),
					"icon" => "iconadmin-doc",
					"override" => "category,courses_group,post,page",
					"type" => "tab"),


		"info_blog_2" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'blessing'),
					"desc" => esc_html__('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'blessing'),
					"override" => "category,courses_group,post,page",
					"type" => "info"),

		"single_style" => array(
					"title" => esc_html__('Single page style', 'blessing'),
					"desc" => esc_html__('Select desired style for single page', 'blessing'),
					"divider" => false,
					"override" => "category,courses_group,page,post",
					"std" => "single-standard",
					"options" => $ANCORA_GLOBALS['options_params']['list_single_styles'],
					"dir" => "horizontal",
					"type" => "radio"),

		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'blessing'),
					"desc" => esc_html__("Allow authors to edit their posts in frontend area)", 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'blessing'),
					"desc" => esc_html__("Show featured image (if selected) before post content on single pages", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'blessing'),
					"desc" => esc_html__('Show area with post title on single pages', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'blessing'),
					"desc" => esc_html__('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'blessing'),
					"desc" => esc_html__('Show area with post info on single pages', 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'blessing'),
					"desc" => esc_html__('Show text before "Read more" tag on single pages', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'blessing'),
					"desc" => esc_html__("Show post author information block on single post page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'blessing'),
					"desc" => esc_html__("Show tags block on single post page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'blessing'),
					"desc" => esc_html__("Show related posts block on single post page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'blessing'),
					"desc" => esc_html__("How many related posts showed on single post page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'blessing'),
					"desc" => esc_html__("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),

		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'blessing'),
					"desc" => esc_html__('Select the desired sorting method for related posts', 'blessing'),

					"std" => "date",
					"options" => $ANCORA_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),

		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'blessing'),
					"desc" => esc_html__('Select the desired ordering method for related posts', 'blessing'),

					"std" => "desc",
					"options" => $ANCORA_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),

		"show_post_comments" => array(
					"title" => esc_html__('Show comments',  'blessing'),
					"desc" => esc_html__("Show comments block on single post page", 'blessing'),
					"override" => "category,courses_group,post,page",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),



		// Blog -> Other parameters
		//-------------------------------------------------

		'blog_tab_general' => array(
					"title" => esc_html__('Other parameters', 'blessing'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,courses_group,page",
					"type" => "tab"),

		"info_blog_3" => array(
					"title" => esc_html__('Other Blog parameters', 'blessing'),
					"desc" => esc_html__('Select excluded categories, substitute parameters, etc.', 'blessing'),
					"type" => "info"),

		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'blessing'),
					"desc" => esc_html__('Select categories, which posts are exclude from blog page', 'blessing'),
					"divider" => false,
					"std" => "",
					"options" => $ANCORA_GLOBALS['options_params']['list_categories'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),

		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'blessing'),
					"desc" => esc_html__('Select type of the pagination on blog streampages', 'blessing'),
					"std" => "pages",
					"override" => "category,courses_group,page",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'blessing')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"blog_pagination_style" => array(
					"title" => esc_html__('Blog pagination style', 'blessing'),
					"desc" => esc_html__('Select pagination style for standard page numbers', 'blessing'),
					"std" => "pages",
					"override" => "category,courses_group,page",
					"options" => array(
						'pages'  => esc_html__('Page numbers list', 'blessing'),
						'slider' => esc_html__('Slider with page numbers', 'blessing')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'blessing'),
					"desc" => esc_html__('Select counters, displayed near the post title', 'blessing'),
					"std" => "views",
					"override" => "category,courses_group,page",
					"options" => array(
						'views' => esc_html__('Views', 'blessing'),
						'likes' => esc_html__('Likes', 'blessing'),
						'rating' => esc_html__('Rating', 'blessing'),
						'comments' => esc_html__('Comments', 'blessing')
					),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),

		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'blessing'),
					"desc" => esc_html__('What category display in announce block (over posts thumb) - original or nearest parental', 'blessing'),
					"std" => "parental",
					"override" => "category,courses_group,page",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'blessing'),
						'original' => esc_html__("Original post's category", 'blessing')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'blessing'),
					"desc" => esc_html__('Show post date after N days (before - show post age)', 'blessing'),
					"override" => "category,courses_group,page",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),





		//###############################
		//#### Reviews               ####
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'blessing'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,courses_group",
					"type" => "partition"),

		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'blessing'),
					"desc" => esc_html__('Set up list of reviews criterias. You can override it in any category.', 'blessing'),
					"override" => "category,courses_group",
					"type" => "info"),

		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'blessing'),
					"desc" => esc_html__("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'blessing'),
					"divider" => false,
					"override" => "category,courses_group",
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'blessing'),
					"desc" => esc_html__("Maximum level for reviews marks", 'blessing'),
					"std" => "5",
					"options" => array(
						'5'=> esc_html__('5 stars', 'blessing'),
						'10'=> esc_html__('10 stars', 'blessing'),
						'100'=> esc_html__('100%', 'blessing')
					),
					"type" => "radio",
					),

		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'blessing'),
					"desc" => esc_html__("Show rating marks as text or as stars/progress bars.", 'blessing'),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'blessing'),
						'stars' => esc_html__('As stars or bars', 'blessing')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'blessing'),
					"desc" => esc_html__('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'blessing'),
					"std" => esc_html__("bad,poor,normal,good,great", 'blessing'),
					"type" => "tags"),

		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'blessing'),
					"desc" => esc_html__("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'blessing'),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'blessing'),
						'users' => esc_html__('By visitors', 'blessing')
						),
					"dir" => "horizontal",
					"type" => "radio"),

		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'blessing'),
					"desc" => esc_html__("Do you want hide second reviews tab in widgets and single posts?", 'blessing'),
					"std" => "show",
					"options" => $ANCORA_GLOBALS['options_params']['list_show_hide'],
					"size" => "medium",
					"type" => "switch"),

		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'blessing'),
					"desc" => esc_html__("What visitors can vote: all or only registered", 'blessing'),
					"std" => "all",
					"options" => array(
						'all'=> esc_html__('All visitors', 'blessing'),
						'registered'=> esc_html__('Only registered', 'blessing')
					),
					"dir" => "horizontal",
					"type" => "radio"),

		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'blessing'),
					"desc" => esc_html__('Add default reviews criterias.',  'blessing'),
					"override" => "category,courses_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),





		//###############################
		//#### Contact info          ####
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'blessing'),
					"icon" => "iconadmin-mail",
					"type" => "partition"),

		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'blessing'),
					"desc" => esc_html__('Company address, phones and e-mail', 'blessing'),
					"type" => "info"),

		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'blessing'),
					"desc" => esc_html__('E-mail for send contact form and user registration data', 'blessing'),
					"divider" => false,
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail'),
					"type" => "text"),

		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'blessing'),
					"desc" => esc_html__('Company country, post code and city', 'blessing'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),

		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'blessing'),
					"desc" => esc_html__('Street and house number', 'blessing'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),

		"contact_phone" => array(
					"title" => esc_html__('Phone', 'blessing'),
					"desc" => esc_html__('Phone number', 'blessing'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),

		"contact_fax" => array(
					"title" => esc_html__('Fax', 'blessing'),
					"desc" => esc_html__('Fax number', 'blessing'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),

		"contact_info" => array(
					"title" => esc_html__('Contacts in header', 'blessing'),
					"desc" => esc_html__('String with contact info in the site header', 'blessing'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),

		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'blessing'),
					"desc" => esc_html__('Maximum length of the messages in the contact form shortcode and in the comments form', 'blessing'),
					"type" => "info"),

		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'blessing'),
					"desc" => esc_html__("Message's maxlength in the contact form shortcode", 'blessing'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),

		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'blessing'),
					"desc" => esc_html__("Message's maxlength in the comments form", 'blessing'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),

		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'blessing'),
					"desc" => esc_html__('What function you want to use for sending mail: the built-in Wordpress or standard PHP function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'blessing'),
					"type" => "info"),

		"mail_function" => array(
					"title" => esc_html__("Mail function", 'blessing'),
					"desc" => esc_html__("What function you want to use for sending mail?", 'blessing'),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'blessing'),
						'mail' => esc_html__('PHP mail', 'blessing')
					),
					"type" => "switch"),




		//###############################
		//#### Socials               ####
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'blessing'),
					"icon" => "iconadmin-users",
					"override" => "category,courses_group,page",
					"type" => "partition"),

		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'blessing'),
					"desc" => esc_html__("Social networks list for site footer and Social widget", 'blessing'),
					"type" => "info"),

		"social_icons" => array(
					"title" => esc_html__('Social networks',  'blessing'),
					"desc" => esc_html__('Select icon and write URL to your profile in desired social networks.',  'blessing'),
					"divider" => false,
					"std" => array(array('url'=>'', 'icon'=>'')),
                    "options" => $ANCORA_GLOBALS['options_params']['list_icons'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'icons',
					"type" => "socials"),

		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'blessing'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'blessing'),
					"type" => "info"),

		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'blessing'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__("Show social share buttons block", 'blessing'),
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'blessing'),
						'vertical'	=> esc_html__('Vertical', 'blessing'),
						'horizontal'=> esc_html__('Horizontal', 'blessing')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'blessing'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__("Show share counters after social buttons", 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'blessing'),
					"override" => "category,courses_group,page",
					"desc" => esc_html__('Caption for the block with social share buttons',  'blessing'),
					"std" => esc_html__('Share:', 'blessing'),
					"type" => "text"),

		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'blessing'),
					"desc" => esc_html__('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'blessing'),
					"std" => array(array('url'=>'', 'icon'=>'')),
                    "options" => $ANCORA_GLOBALS['options_params']['list_icons'],
					"cloneable" => true,
					"size" => "small",
					"style" => 'icons',
					"type" => "socials"),


		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'blessing'),
					"desc" => esc_html__("Put to this section Twitter API 1.1 keys.<br>
					You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'blessing'),
					"type" => "info"),

		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'blessing'),
					"desc" => esc_html__('Your login (username) in Twitter',  'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "text"),

		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'blessing'),
					"desc" => esc_html__('Twitter API Consumer key',  'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "text"),

		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'blessing'),
					"desc" => esc_html__('Twitter API Consumer secret',  'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "text"),

		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'blessing'),
					"desc" => esc_html__('Twitter API Token key',  'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "text"),

		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'blessing'),
					"desc" => esc_html__('Twitter API Token secret',  'blessing'),
					"divider" => false,
					"std" => "",
					"type" => "text"),







		//###############################
		//#### Search parameters     ####
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'blessing'),
					"icon" => "iconadmin-search",
					"type" => "partition"),

		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'blessing'),
					"desc" => esc_html__('Enable/disable AJAX search and output settings for it', 'blessing'),
					"type" => "info"),

		"show_search" => array(
					"title" => esc_html__('Show search field', 'blessing'),
					"desc" => esc_html__('Show search field in the top area and side menus', 'blessing'),
					"divider" => false,
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'blessing'),
					"desc" => esc_html__('Use incremental AJAX search for the search field in top of page', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'blessing'),
					"desc" => esc_html__('The minimum length of the search string',  'blessing'),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),

		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'blessing'),
					"desc" => esc_html__('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'blessing'),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),

		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'blessing'),
					"desc" => esc_html__('Select post types, what will be include in search results. If not selected - use all types.', 'blessing'),
					"std" => "",
					"options" => $ANCORA_GLOBALS['options_params']['list_posts_types'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),

		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'blessing'),
					"desc" => esc_html__('Number of the posts to show in search results',  'blessing'),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),

		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'blessing'),
					"desc" => esc_html__("Show post's thumbnail in the search results", 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'blessing'),
					"desc" => esc_html__("Show post's publish date in the search results", 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'blessing'),
					"desc" => esc_html__("Show post's author in the search results", 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'blessing'),
					"desc" => esc_html__("Show post's counters (views, comments, likes) in the search results", 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),





		//###############################
		//#### Service               ####
		//###############################

		"partition_service" => array(
					"title" => esc_html__('Service', 'blessing'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),

		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'blessing'),
					"desc" => esc_html__('Basic theme functionality settings', 'blessing'),
					"type" => "info"),

		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'blessing'),
					"desc" => esc_html__('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'blessing'),
					"desc" => esc_html__('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'blessing'),
					"desc" => esc_html__('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'blessing'),
					"desc" => esc_html__('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'blessing'),
					"desc" => esc_html__('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'blessing'),
					"desc" => esc_html__('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'blessing'),
					"std" => 1200,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),

		"admin_update_notifier" => array(
					"title" => esc_html__('Enable Update Notifier', 'blessing'),
					"desc" => esc_html__('Show update notifier in admin panel. <b>Attention!</b> When this option is enabled, the theme periodically (every few hours) will communicate with our server, to check the current version. When the connection is slow, it may slow down Dashboard.', 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'blessing'),
					"desc" => esc_html__('Allow to use Ancora Emailer for mass-volume e-mail distribution and management of mailing lists in "Appearance - Emailer"', 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "hidden"),

		"clear_shortcodes" => array(
					"title" => esc_html__('Remove line breaks around shortcodes', 'blessing'),
					"desc" => esc_html__('Do you want remove spaces and line breaks around shortcodes? <b>Be attentive!</b> This option thoroughly tested on our theme, but may affect third party plugins.', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'blessing'),
					"desc" => esc_html__('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services (for example <a href="//yui.2clics.net/" target="_blank">http://yui.2clics.net/</a>) or utility <b>yuicompressor-x.y.z.jar</b>', 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"packed_scripts" => array(
					"title" => esc_html__('Use packed css and js files', 'blessing'),
					"desc" => esc_html__('Do you want to use one packed css and one js file with most theme scripts and styles instead many separate files (for speed up page loading). This reduces the number of HTTP requests when loading pages.', 'blessing'),
					"std" => "no",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'blessing'),
					"desc" => esc_html__('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'blessing'),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),

		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'blessing'),
					"desc" => esc_html__('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'blessing'),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),

		"info_service_2" => array(
					"title" => esc_html__('API Keys', 'blessing'),
					"desc" => wp_kses_data( __('API Keys for some Web services', 'blessing') ),
					"type" => "info"),
		'api_google' => array(
					"title" => esc_html__('Google API Key', 'blessing'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps. Please note that this option will only work with the active TRX Utils/Addons plugin. 
", 'blessing') ),
					"std" => "",
					"type" => "text"),

		"info_service_3" => array(
					"title" => esc_html__('Login and Register', 'blessing'),
					"desc" => wp_kses_data( __('Settings for the users login and registration', 'blessing') ),
					"type" => "info"),

		"ajax_login" => array(
					"title" => esc_html__('Allow AJAX login', 'blessing'),
					"desc" => esc_html__('Allow AJAX login or redirect visitors on the WP Login screen', 'blessing'),
					"std" => "yes",
					"options" => $ANCORA_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"social_login" => array(
					"title" => esc_html__('Social Login code',  'blessing'),
					"desc" => wp_kses_data( __('Specify shortcode from your Social Login Plugin or any HTML/JS code to make Social Login section',  'blessing') ),
					"std" => "",
					"type" => "textarea"),
		)
                )
            );

	}
}
?>