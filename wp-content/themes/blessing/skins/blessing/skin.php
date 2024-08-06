<?php
/**
 * blessing skin file for theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('ancora_skin_theme_setup_blessing')) {
	add_action( 'ancora_action_init_theme', 'ancora_skin_theme_setup_blessing', 1 );
	function ancora_skin_theme_setup_blessing() {

		// Add skin fonts in the used fonts list
		add_filter('ancora_filter_used_fonts',			'ancora_filter_used_fonts_blessing');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('ancora_filter_list_fonts',			'ancora_filter_list_fonts_blessing');

		// Add skin stylesheets
		add_action('ancora_action_add_styles',			'ancora_action_add_styles_blessing');
		// Add skin inline styles
		add_filter('ancora_filter_add_styles_inline',		'ancora_filter_add_styles_inline_blessing');
		// Add skin responsive styles
		add_action('ancora_action_add_responsive',		'ancora_action_add_responsive_blessing');
		// Add skin responsive inline styles
		add_filter('ancora_filter_add_responsive_inline',	'ancora_filter_add_responsive_inline_blessing');

		// Add skin scripts
		add_action('ancora_action_add_scripts',			'ancora_action_add_scripts_blessing');
		// Add skin scripts inline
		add_filter('ancora_action_add_scripts_inline',	'ancora_action_add_scripts_inline_blessing');

		// Return links color (if not set in the theme options)
		add_filter('ancora_filter_get_link_color',		'ancora_filter_get_link_color_blessing', 10, 1);
		// Return links dark color
		add_filter('ancora_filter_get_link_dark',			'ancora_filter_get_link_dark_blessing',  10, 1);

		// Return main menu items color (if not set in the theme options)
		add_filter('ancora_filter_get_menu_color',		'ancora_filter_get_menu_color_blessing', 10, 1);
		// Return main menu items dark color
		add_filter('ancora_filter_get_menu_dark',			'ancora_filter_get_menu_dark_blessing',  10, 1);

		// Return user menu items color (if not set in the theme options)
		add_filter('ancora_filter_get_user_color',		'ancora_filter_get_user_color_blessing', 10, 1);
		// Return user menu items dark color
		add_filter('ancora_filter_get_user_dark',			'ancora_filter_get_user_dark_blessing',  10, 1);

		// Add color schemes
		ancora_add_color_scheme('original', array(
			'title'					=> esc_html__('Original', 'blessing'),
			// Old settings
			'menu_color' => '#592131',
			'menu_dark'  => '#592131',
			'link_color' => '#493834',
			'link_dark'  => '#592131',
			'user_color' => '#f1ad48',
			'user_dark'  => '#f1ad48'
			)
		);
		ancora_add_color_scheme('blue', array(
			'title'		 =>	esc_html__('Blue', 'blessing'),
			// Old settings
                'menu_color' => '#0d3153',
                'menu_dark'  => '#0d3153',
                'link_color' => '#493834',
                'link_dark'  => '#0d3153',
                'user_color' => '#f1ad48',
                'user_dark'  => '#f1ad48'
			)
		);
		ancora_add_color_scheme('green', array(
			'title'		 =>	esc_html__('Green', 'blessing'),
			// Old settings
                'menu_color' => '#295c37',
                'menu_dark'  => '#295c37',
                'link_color' => '#493834',
                'link_dark'  => '#295c37',
                'user_color' => '#f1ad48',
                'user_dark'  => '#f1ad48'
			)
		);
	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('ancora_filter_used_fonts_blessing')) {
	
	function ancora_filter_used_fonts_blessing($theme_fonts) {
		$theme_fonts['Cinzel'] = 1;
		$theme_fonts['Quattrocento Sans'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('ancora_filter_list_fonts_blessing')) {
	
	function ancora_filter_list_fonts_blessing($list) {
		if (!isset($list['Cinzel']))				$list['Cinzel'] = array('family'=>'serif', 'link'=>'Cinzel:400,700');
		if (!isset($list['Quattrocento Sans']))	$list['Quattrocento Sans'] = array('family'=>'sans-serif', 'link'=>'Quattrocento+Sans:400,400italic,700,700italic');
		return $list;
	}
}


//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('ancora_action_add_styles_blessing')) {
	
	function ancora_action_add_styles_blessing() {
		// Add stylesheet files
		$file_url = sprintf('skins/%s/skin.css', ancora_get_currently_used_skin());
		wp_enqueue_style( 'ancora-skin-style', ancora_get_file_url($file_url), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('ancora_filter_add_styles_inline_blessing')) {
	
	function ancora_filter_add_styles_inline_blessing($custom_style) {


        // Color scheme
        $scheme = ancora_get_custom_option('color_scheme');
        if (empty($scheme)) $scheme = 'original';

        global $ANCORA_GLOBALS;

        // Links color
        $clr = ancora_get_custom_option('link_color');
        if (empty($clr) && $scheme!= 'original')	$clr = apply_filters('ancora_filter_get_link_color', '');
        if (!empty($clr)) {
            $ANCORA_GLOBALS['color_schemes'][$scheme]['link_color'] = $clr;
            $rgb = ancora_hex2rgb($clr);
            $custom_style .= '
            a,
			.bg_tint_light a,
			.bg_tint_light h1,
			.bg_tint_light h2,
			.bg_tint_light h3,
			.bg_tint_light h4,
			.bg_tint_light h5,
			.bg_tint_light h6,
            .bg_tint_light h1 a,
            .bg_tint_light h2 a,
            .bg_tint_light h3 a,
            .bg_tint_light h4 a,
            .bg_tint_light h5 a,
            .bg_tint_light h6 a,
            table tr:first-child,
            .widget_area a,
            .widget_area ul li:before,
            .widget_area ul li a:hover,
            .woocommerce ul.products li.product .woocommerce-loop-category__title a,
            .woocommerce ul.products li.product .woocommerce-loop-product__title a,
            .woocommerce ul.products li.product h3 a,
            .woocommerce-page ul.products li.product h3 a
			{
					color:'.esc_attr($clr).';
				}
			';
        }
        // Links dark color
        $clr_dark = ancora_get_custom_option('link_dark');
                if (empty($clr_dark) && $scheme!= 'original')	$clr_dark = apply_filters('ancora_filter_get_link_dark', '');
                if (!empty($clr) || !empty($clr_dark)) {
                    if (empty($clr_dark)) {
                $hsb = ancora_hex2hsb($clr);
                $hsb['s'] = min(100, $hsb['s'] + 15);
                $hsb['b'] = max(0, $hsb['b'] - 20);
                $clr = ancora_hsb2hex($hsb);
            } else
                $clr = $clr_dark;
            $ANCORA_GLOBALS['color_schemes'][$scheme]['link_dark'] = $clr;
            
            $custom_style .= '
            a:hover,
			.bg_tint_light a:hover,
            .bg_tint_light h1 a:hover,
            .bg_tint_light h2 a:hover,
            .bg_tint_light h3 a:hover,
            .bg_tint_light h4 a:hover,
            .bg_tint_light h5 a:hover,
            .bg_tint_light h6 a:hover,
            .widget_area a:hover,
            .widget_area ul li:before,
            .widget_area ul li a:hover,
            .woocommerce ul.products li.product h3 a:hover,
            .woocommerce-page ul.products li.product h3 a:hover,
            .sc_team_item .sc_team_item_info .sc_team_item_title a:hover,
            a.rsswidget:hover,
            .widget_area ul li.recentcomments a:hover
				{
					color:'.esc_attr($clr).';
				}
			';
        }


        // Menu color
        $clr = ancora_get_custom_option('menu_color');
        if (empty($clr) && $scheme!= 'original')	$clr = apply_filters('ancora_filter_get_menu_color', '');
        if (!empty($clr)) {
            $ANCORA_GLOBALS['color_schemes'][$scheme]['menu_color'] = $clr;
            $rgb = ancora_hex2rgb($clr);
            $custom_style .= '
			.bg_tint_dark,
            .bg_tint_dark h1,
            .bg_tint_dark h2,
            .bg_tint_dark h3,
            .bg_tint_dark h4,
            .bg_tint_dark h5,
            .bg_tint_dark h6,
            a.link_color:hover,
            .link_dark,
            .menu_color,
			a.menu_color:hover,
			.menu_dark,
			.bg_tint_light .menu_main_responsive_button,
			.search_results .post_more,
            .search_results .search_results_close,
			.post_title .post_icon,
			.post_item_related .post_title a,
            .pagination_wrap .pager_next,
            .pagination_wrap .pager_prev,
            .pagination_wrap .pager_last,
            .pagination_wrap .pager_first,
            .comments_list_wrap .comment_info > span.comment_author,
            .comments_list_wrap .comment_info > .comment_date > .comment_date_value,
            .post_item_404 .page_subtitle,
            .post_item_404 .page_description a,
            .layout_single-courses .post_info .post_info_date,
            .layout_single-courses .post_info .post_info_posted:before,
			.sidebar.widget_area a:hover,
            .sidebar.widget_area ul li a,
            .sidebar.widget_area ul li a:hover,
            .widget_area ul li a.username,
            .widget_area ul li a.username:hover,
            .widget_area .widget_text a,
            .widget_area .post_info a,
            .widget_area .widget_socials .logo .logo_text,
			.widget_area .widget_product_tag_cloud a:hover,
            .widget_area .widget_tag_cloud a:hover,
            .woocommerce .woocommerce-message:before,
            .woocommerce-page .woocommerce-message:before,
            .woocommerce div.product span.price,
            .woocommerce div.product p.price,
            .woocommerce #content div.product span.price,
            .woocommerce #content div.product p.price,
            .woocommerce-page div.product span.price,
            .woocommerce-page div.product p.price,
            .woocommerce-page #content div.product span.price,
            .woocommerce-page #content div.product p.price,
            .woocommerce ul.products li.product .price,
            .woocommerce-page ul.products li.product .price,
            .woocommerce a.button.alt:hover,
            .woocommerce button.button.alt:hover,
            .woocommerce input.button.alt:hover,
            .woocommerce #respond input#submit.alt:hover,
            .woocommerce #content input.button.alt:hover,
            .woocommerce-page a.button.alt:hover,
            .woocommerce-page button.button.alt:hover,
            .woocommerce-page input.button.alt:hover,
            .woocommerce-page #respond input#submit.alt:hover,
            .woocommerce-page #content input.button.alt:hover,
            .woocommerce a.button:hover,
            .woocommerce button.button:hover,
            .woocommerce input.button:hover,
            .woocommerce #respond input#submit:hover,
            .woocommerce #content input.button:hover,
            .woocommerce-page a.button:hover,
            .woocommerce-page button.button:hover,
            .woocommerce-page input.button:hover,
            .woocommerce-page #respond input#submit:hover,
            .woocommerce-page #content input.button:hover,
            .woocommerce .quantity input[type="button"]:hover,
            .woocommerce #content input[type="button"]:hover,
            .woocommerce-page .quantity input[type="button"]:hover,
            .woocommerce-page #content .quantity input[type="button"]:hover,
            .woocommerce ul.cart_list li > .amount,
            .woocommerce ul.product_list_widget li > .amount,
            .woocommerce-page ul.cart_list li > .amount,
            .woocommerce-page ul.product_list_widget li > .amount,
            .woocommerce ul.cart_list li span .amount,
            .woocommerce ul.product_list_widget li span .amount,
            .woocommerce-page ul.cart_list li span .amount,
            .woocommerce-page ul.product_list_widget li span .amount,
            .woocommerce ul.cart_list li ins .amount,
            .woocommerce ul.product_list_widget li ins .amount,
            .woocommerce-page ul.cart_list li ins .amount,
            .woocommerce-page ul.product_list_widget li ins .amount,
            .woocommerce.widget_shopping_cart .total .amount,
            .woocommerce .widget_shopping_cart .total .amount,
            .woocommerce-page.widget_shopping_cart .total .amount,
            .woocommerce-page .widget_shopping_cart .total .amount,
            .woocommerce a:hover h3,
            .woocommerce-page a:hover h3,
            .woocommerce .cart-collaterals .order-total strong,
            .woocommerce-page .cart-collaterals .order-total strong,
            .woocommerce .checkout #order_review .order-total .amount,
            .woocommerce-page .checkout #order_review .order-total .amount,
            .woocommerce .star-rating,
            .woocommerce-page .star-rating,
            .woocommerce .star-rating:before,
            .woocommerce-page .star-rating:before,
            .widget_area .widgetWrap ul > li .star-rating span,
            .woocommerce #review_form #respond .stars a,
            .woocommerce-page #review_form #respond .stars a,
            .woocommerce ul.products li.product h3 a,
            .woocommerce-page ul.products li.product h3 a,
            .woocommerce ul.products li.product .star-rating:before,
            .woocommerce ul.products li.product .star-rating span,
            .woocommerce nav.woocommerce-pagination ul li a:focus,
            .woocommerce nav.woocommerce-pagination ul li a:hover,
            .woocommerce nav.woocommerce-pagination ul li span.current,
            .sc_accordion.sc_accordion_style_1 .sc_accordion_item .sc_accordion_title:hover,
            .sc_countdown.sc_countdown_style_1 .sc_countdown_digits,
            .sc_countdown.sc_countdown_style_1 .sc_countdown_separator,
            .sc_countdown.sc_countdown_style_1 .sc_countdown_label,
            .sc_icon_bg_link,
            .sc_icon_bg_menu,
            .sc_icon_shape_round.sc_icon_bg_link:hover,
            .sc_icon_shape_square.sc_icon_bg_link:hover,
            a:hover .sc_icon_shape_round.sc_icon_bg_link,
            a:hover .sc_icon_shape_square.sc_icon_bg_link,
           .sc_icon_shape_round.sc_icon_bg_menu:hover,
            .sc_icon_shape_square.sc_icon_bg_menu:hover,
            a:hover .sc_icon_shape_round.sc_icon_bg_menu,
            a:hover .sc_icon_shape_square.sc_icon_bg_menu,
            .sc_slider_controls_wrap a:hover,
            .sc_tabs.sc_tabs_style_1 .sc_tabs_titles li a,
            .sc_title_icon,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title.ui-state-active,
            .widget_area .widget_calendar a.month_prev:before,
            .widget_area .widget_calendar .month_prev a:before,
            .boxed_icon a,
            .post_content h4,
            .post_info .post_info_counters .post_counters_likes.disabled,
            .history_service .wpb_wrapper p,
            .post_item_obituaries .post_descr a
            .ih-item.square .info .post_title,
            .ih-item.square .info .post_title a,
            .post_item_single > .post_title,
            .related_wrap .section_title,
            .comments_form_wrap .comments_form_title,
            .comments_list_wrap .comments_list_title,
            .comments_list_wrap .comment_reply a,
            #fbuilder .fields h5,
            #fbuilder .fields.testik .fields,
            .logo .logo_text,
            .post_item_obituaries .post_descr a
			{
				color: '.esc_attr($clr).';
			}
			.menu_dark_bg,
			.menu_dark_bgc,
			.link_dark_bgc,
			.link_dark_bg,
			.menu_color_bgc,
			.menu_color_bg,
             menu_left .menu_main_wrap .menu_main_nav_area,
            .menu_center .menu_main_wrap .menu_main_nav_area,
            .menu_main_wrap .menu_main_nav > li:hover,
            .menu_main_wrap .menu_main_nav > li.sfHover,
            .menu_main_wrap .menu_main_nav > li#blob,
            .menu_main_wrap .menu_main_nav > li.current-menu-item,
            .menu_main_wrap .menu_main_nav > li.current-menu-parent,
            .menu_main_wrap .menu_main_nav > li.current-menu-ancestor,
            .menu_main_wrap .menu_main_nav > li ul li,
			.top_panel_style_light .page_top_wrap,
			.top_panel_style_dark.article_style_boxed .page_top_wrap .breadcrumbs a.breadcrumbs_item:hover,
            .page_top_wrap .breadcrumbs a.breadcrumbs_item:hover,
            .pagination_viewmore > a,
            .viewmore_loader,
            .mfp-preloader span,
            .sc_video_frame.sc_video_active:before,
            .content .post_item_404 .page_search .search_wrap .search_form_wrap .search_submit,
            .widget_area .widget_calendar .today .day_wrap,
            .scroll_to_top,
            .woocommerce span.new, .woocommerce-page span.new,
            .woocommerce span.onsale, .woocommerce-page span.onsale,
            .woocommerce nav.woocommerce-pagination ul li a,
            .woocommerce nav.woocommerce-pagination ul li span.current,
            .woocommerce table.cart thead th,
            .woocommerce #content table.cart thead th,
            .woocommerce-page table.cart thead th,
            .woocommerce-page #content table.cart thead th,
            .tribe-events-calendar thead th,
            a.tribe-events-read-more,
            .tribe-events-button,
            .tribe-events-nav-previous a,
            .tribe-events-nav-next a,
            .tribe-events-widget-link a,
            .tribe-events-viewmore a,
            #bbpress-forums div.bbp-topic-content a,
            #buddypress button,
            #buddypress a.button,
            #buddypress input[type="submit"],
            #buddypress input[type="button"],
            #buddypress input[type="reset"],
            #buddypress ul.button-nav li a,
            #buddypress div.generic-button a,
            #buddypress .comment-reply-link,
            a.bp-title-button,
            #buddypress div.item-list-tabs ul li.selected a,
            .sc_accordion .sc_accordion_item .sc_accordion_title .sc_accordion_icon:before,
            .sc_accordion .sc_accordion_item .sc_accordion_title .sc_accordion_icon_opened:before,
            .sc_audio.sc_audio_info,
            .sc_button.sc_button_style_dark,
            .sc_button.sc_button_style_filled,
            .sc_button.sc_button_style_dark.sc_button_bg_menu,
            .sc_button.sc_button_style_filled.sc_button_bg_menu,
            .sc_button.sc_button_style_dark.sc_button_bg_user,
            .sc_button.sc_button_style_filled.sc_button_bg_user,
            .sc_blogger.layout_date .sc_blogger_item .sc_blogger_date,
            .sc_dropcaps.sc_dropcaps_style_1 .sc_dropcaps_item,
            .sc_highlight_style_1,
            .sc_highlight_style_2,
            .sc_icon_shape_round.sc_icon_bg_link,
            .sc_icon_shape_square.sc_icon_bg_link,
            .sc_icon_shape_round.sc_icon_bg_menu,
            .sc_icon_shape_square.sc_icon_bg_menu,
            .sc_popup:before,
            .sc_scroll_controls_wrap a,
            .sc_team_style_1 .sc_team_item_info,
            blockquote,
            .sc_quote_style_1,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title.ui-state-active .sc_toggles_icon_opened,
            .bottom_cont,
            .big_banner .sc_contact_form .sc_contact_form_item.label_left button,
            .obituaries .search_wrap.search_style_regular .search_form_wrap .search_submit,
            form.comment-form .submit
            {
				background-color: '.esc_attr($clr).';
			}
			.menu_dark_border,
			.menu_color_border,
			.link_dark_border,
			.pagination > a,
			.widget_area .widget_calendar .today .day_wrap,
			.sc_blogger.layout_date .sc_blogger_item .sc_blogger_date,
			.sc_icon_shape_round.sc_icon_bg_link,
            .sc_icon_shape_square.sc_icon_bg_link,
            .sc_icon_shape_round.sc_icon_bg_menu,
            .sc_icon_shape_square.sc_icon_bg_menu,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title.ui-state-active
			 {
			 	border-color: '.esc_attr($clr).';
			}

			';
        }

        // Menu dark color
        $clr_dark = ancora_get_custom_option('menu_dark');
        if (empty($clr_dark) && $scheme!= 'original')	$clr_dark = apply_filters('ancora_filter_get_menu_dark', '');
        if (!empty($clr) || !empty($clr_dark)) {
            if (empty($clr_dark)) {
                $hsb = ancora_hex2hsb($clr);
                $hsb['s'] = min(100, $hsb['s'] + 15);
                $hsb['b'] = max(0, $hsb['b'] - 20);
                $clr = ancora_hsb2hex($hsb);
            } else
                $clr = $clr_dark;
            $ANCORA_GLOBALS['color_schemes'][$scheme]['menu_dark'] = $clr;
            
            $custom_style .= '
			';
        }

        // User color
        $clr = ancora_get_custom_option('user_color');
        if (empty($clr) && $scheme!= 'original')	$clr = apply_filters('ancora_filter_get_user_color', '');
        if (!empty($clr)) {
            $ANCORA_GLOBALS['color_schemes'][$scheme]['user_color'] = $clr;
            $rgb = ancora_hex2rgb($clr);
            $custom_style .= '
            .user_color,
		    .sc_icon_bg_user,
		    a:hover .sc_icon_shape_round.sc_icon_bg_user,
            a:hover .sc_icon_shape_square.sc_icon_bg_user,
            .menu_main_wrap .menu_main_nav > li ul li a:hover,
            .bg_tint_light .menu_main_responsive_button:hover,
            .widget_area ul li a.username:hover,
            .woocommerce ul.products li.product h3 a:hover,
            .woocommerce-page ul.products li.product h3 a:hover,
            .sc_icon.sc_icon_bg_link:hover,
            a:hover .sc_icon.sc_icon_bg_link,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:hover,
            .widget_area .widget_twitter ul li:before,
            .post_info .post_info_counters .post_counters_item:before,
            .small_banner .small_banner_title a:hover
		        {
				    color: '.esc_attr($clr).';
				}
		    .user_color_bgc,
		    .user_color_bg,
		    .custom_options #co_toggle,
		    .pagination_viewmore > a:hover,
		    .woocommerce a.button:hover,
		    .woocommerce button.button:hover,
		    .woocommerce input.button:hover,
		    .woocommerce #respond input#submit:hover,
		    .woocommerce #content input.button:hover,
		    .woocommerce-page a.button:hover,
		    .woocommerce-page button.button:hover,
		    .woocommerce-page input.button:hover,
		    .woocommerce-page #respond input#submit:hover,
		     woocommerce-page #content input.button:hover,
		     woocommerce a.button.alt:hover,
		    .woocommerce button.button.alt:hover,
		    .woocommerce input.button.alt:hover,
		    .woocommerce #respond input#submit.alt:hover,
		    .woocommerce #content input.button.alt:hover,
		    .woocommerce-page a.button.alt:hover,
		    .woocommerce-page button.button.alt:hover,
		    .woocommerce-page input.button.alt:hover,
		    .woocommerce-page #respond input#submit.alt:hover,
		    .woocommerce-page #content input.button.alt:hover,
		    a.tribe-events-read-more:hover,
            .tribe-events-button:hover,
            .tribe-events-nav-previous a:hover,
            .tribe-events-nav-next a:hover,
            .tribe-events-widget-link a:hover,
            .tribe-events-viewmore a:hover,
            #bbpress-forums div.bbp-topic-content a:hover,
            #buddypress button:hover,
            #buddypress a.button:hover,
            #buddypress input[type="submit"]:hover,
            #buddypress input[type="button"]:hover,
            #buddypress input[type="reset"]:hover,
            #buddypress ul.button-nav li a:hover,
            #buddypress div.generic-button a:hover,
            #buddypress .comment-reply-link:hover,
            a.bp-title-button:hover,
            #buddypress div.item-list-tabs ul li.selected a:hover,
            .sc_icon_shape_round.sc_icon_bg_user,
            .sc_icon_shape_square.sc_icon_bg_user,
            .menu_main_wrap .menu_main_nav > li.current-menu-parent,
            .menu_main_wrap .menu_main_nav > li.current-menu-item,
            .menu_main_wrap .menu_main_nav > li.blob_over:hover,
            .menu_main_wrap .menu_main_nav > li.blob_over.sfHover,
            .content .post_item_404 .page_search .search_wrap .search_form_wrap .search_submit:hover,
            .scroll_to_top:hover,
            .woocommerce ul.products li.product .add_to_cart_button:hover,
            .woocommerce-page ul.products li.product .add_to_cart_button:hover,
            .sc_button.sc_button_style_global,
            .sc_button.sc_button_style_global.sc_button_bg_menu,
            .sc_button.sc_button_style_global.sc_button_bg_user,
            .sc_button.sc_button_style_dark:hover,
            .sc_button.sc_button_style_filled:hover,
            .sc_button.sc_button_style_light:hover,
            .sc_dropcaps.sc_dropcaps_style_2 .sc_dropcaps_item,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:hover .sc_toggles_icon_opened,
            .sc_highlight_style_3,
            .obituaries .search_wrap.search_style_regular .search_form_wrap button.search_submit:hover,
            .big_banner .sc_contact_form .sc_contact_form_item.label_left button:hover,
            form.comment-form .submit:hover
    			{
    				background-color: '.esc_attr($clr).';
    			}
    		.user_color_border,
    		.sc_icon_shape_round.sc_icon_bg_user,
            .sc_icon_shape_square.sc_icon_bg_user,
            .sc_toggles.sc_toggles_style_1 .sc_toggles_item .sc_toggles_title:hover
    		    {
    		        border-color:  '.esc_attr($clr).';
    		    }

			';
        }
        // User dark color
        $clr_dark = ancora_get_custom_option('user_dark');
        if (empty($clr_dark) && $scheme!= 'original')	$clr_dark = apply_filters('ancora_filter_get_user_dark', '');
        if (!empty($clr) || !empty($clr_dark)) {
            if (empty($clr_dark)) {
                $hsb = ancora_hex2hsb($clr);
                $hsb['s'] = min(100, $hsb['s'] + 15);
                $hsb['b'] = max(0, $hsb['b'] - 20);
                $clr = ancora_hsb2hex($hsb);
            } else
                $clr = $clr_dark;
            $ANCORA_GLOBALS['color_schemes'][$scheme]['user_dark'] = $clr;
            
            $custom_style .= '
			';
        }
		return $custom_style;
	}
}

// Add skin responsive styles
if (!function_exists('ancora_action_add_responsive_blessing')) {
	
	function ancora_action_add_responsive_blessing() {
		$file_url = sprintf('skins/%s/skin-responsive.css', ancora_get_currently_used_skin());
		if (file_exists(ancora_get_file_dir($file_url)))
			wp_enqueue_style( 'ancora-skin-responsive-style', ancora_get_file_url($file_url), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('ancora_filter_add_responsive_inline_blessing')) {
	
	function ancora_filter_add_responsive_inline_blessing($custom_style) {
		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('ancora_action_add_scripts_blessing')) {
	
	function ancora_action_add_scripts_blessing() {
		$file_url = sprintf('skins/%s/skin.js', ancora_get_currently_used_skin());
		$file_url_1 = sprintf('skins/%s/skin.customizer.js', ancora_get_currently_used_skin());
		$file_url_2 = sprintf('skins/%s/add_title_to_link.js', ancora_get_currently_used_skin());

		if (file_exists(ancora_get_file_dir($file_url)))
			wp_enqueue_script( 'ancora-skin-script', ancora_get_file_url($file_url), array(), null, true );
		if (ancora_get_theme_option('show_theme_customizer') == 'yes' && file_exists(ancora_get_file_dir($file_url_1)))
			wp_enqueue_script( 'ancora-skin-customizer-script', ancora_get_file_url($file_url_1), array(), null , true);
        if (file_exists(ancora_get_file_dir($file_url_2)))
            wp_enqueue_script( 'ancora-skin-link-script', ancora_get_file_url($file_url_2), array(), null, true );
	}
}

// Add skin scripts inline
if (!function_exists('ancora_action_add_scripts_inline_blessing')) {
	
	function ancora_action_add_scripts_inline_blessing($vars=array()) {
        if(ancora_get_global('theme_font') == '') $vars['theme_font'] = 'Roboto';
        $vars['link_color'] = apply_filters('ancora_filter_get_link_color', ancora_get_custom_option('link_color'));
        $vars['menu_color'] = apply_filters('ancora_filter_get_menu_color', ancora_get_custom_option('menu_color'));
        $vars['user_color'] = apply_filters('ancora_filter_get_user_color', ancora_get_custom_option('user_color'));
        return $vars;
	}
}


//------------------------------------------------------------------------------
// Get skin's colors
//------------------------------------------------------------------------------


// Return main theme bg color
if (!function_exists('ancora_filter_get_theme_bgcolor_blessing')) {
	
	function ancora_filter_get_theme_bgcolor_blessing($clr) {
		return '#ffffff';
	}
}



// Return link color (if not set in the theme options)
if (!function_exists('ancora_filter_get_link_color_blessing')) {
	
	function ancora_filter_get_link_color_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('link_color') : $clr;
	}
}

// Return links dark color (if not set in the theme options)
if (!function_exists('ancora_filter_get_link_dark_blessing')) {
	
	function ancora_filter_get_link_dark_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('link_dark') : $clr;
	}
}



// Return main menu color (if not set in the theme options)
if (!function_exists('ancora_filter_get_menu_color_blessing')) {
	
	function ancora_filter_get_menu_color_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('menu_color') : $clr;
	}
}

// Return main menu dark color (if not set in the theme options)
if (!function_exists('ancora_filter_get_menu_dark_blessing')) {
	
	function ancora_filter_get_menu_dark_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('menu_dark') : $clr;
	}
}



// Return user menu color (if not set in the theme options)
if (!function_exists('ancora_filter_get_user_color_blessing')) {
	
	function ancora_filter_get_user_color_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('user_color') : $clr;
	}
}

// Return user menu dark color (if not set in the theme options)
if (!function_exists('ancora_filter_get_user_dark_blessing')) {
	
	function ancora_filter_get_user_dark_blessing($clr) {
		return empty($clr) ? ancora_get_scheme_color('user_dark') : $clr;
	}
}
?>