<?php
/**
 * ANCORA Framework: Theme specific actions
 *
 * @package	ancora
 * @since	ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_core_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_core_theme_setup', 11 );
	function ancora_core_theme_setup() {
		
		// Editor custom stylesheet - for user
		add_editor_style(ancora_get_file_url('css/editor-style.css'));
		
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'blessing', ancora_get_folder_dir('languages') );


		/* Front and Admin actions and filters:
		------------------------------------------------------------------------ */

		if ( !is_admin() ) {
			
			/* Front actions and filters:
			------------------------------------------------------------------------ */

			// Get theme calendar (instead standard WP calendar) to support Events
			add_filter( 'get_calendar',						'ancora_get_calendar' );
	
			// Filters wp_title to print a neat <title> tag based on what is being viewed
			if (floatval(get_bloginfo('version')) < "4.1") {
				add_filter('wp_title',						'ancora_wp_title', 10, 2);
			}

			// Add main menu classes
			
	
			// Prepare logo text
			add_filter('ancora_filter_prepare_logo_text',	'ancora_prepare_logo_text', 10, 1);
	
			// Add class "widget_number_#' for each widget
			add_filter('dynamic_sidebar_params', 			'ancora_add_widget_number', 10, 1);

			// Frontend editor: Save post data
			add_action('wp_ajax_frontend_editor_save',		'ancora_callback_frontend_editor_save');

			// Frontend editor: Delete post
			add_action('wp_ajax_frontend_editor_delete', 	'ancora_callback_frontend_editor_delete');
	
			// Enqueue scripts and styles
			add_action('wp_enqueue_scripts', 				'ancora_core_frontend_scripts');
			add_action('wp_footer',		 					'ancora_core_frontend_scripts_inline', 9);
			add_filter('ancora_action_add_scripts_inline','ancora_core_add_scripts_inline');

			// Prepare theme core global variables
			add_action('ancora_action_prepare_globals',	'ancora_core_prepare_globals');

		}

		// Register theme specific nav menus
		ancora_register_theme_menus();

		// Register theme specific sidebars
		ancora_register_theme_sidebars();
	}
}

// Show content with the html layout (if not empty)
if ( !function_exists('ancora_show_layout') ) {
    function ancora_show_layout($str, $before='', $after='') {
        if (!empty($str)) {
            printf("%s%s%s", $before, $str, $after);
        }
    }
}


/* Theme init
------------------------------------------------------------------------ */

// Init theme template
function ancora_core_init_theme() {
	global $ANCORA_GLOBALS;
	if (!empty($ANCORA_GLOBALS['theme_inited'])) return;
	$ANCORA_GLOBALS['theme_inited'] = true;

	// Load custom options from GET and post/page/cat options
	if (isset($_GET['set']) && $_GET['set']==1) {
		foreach ($_GET as $k=>$v) {
			if (ancora_get_theme_option($k, null) !== null) {
				setcookie($k, $v, 0, '/');
				$_COOKIE[$k] = $v;
			}
		}
	}

	// Get custom options from current category / page / post / shop / event
	ancora_load_custom_options();

	// Load skin
	$skin = sanitize_file_name(ancora_get_custom_option('theme_skin'));
	$ANCORA_GLOBALS['theme_skin'] = $skin;
	if ( file_exists(ancora_get_file_dir('skins/'.($skin).'/skin.php')) ) {
		require_once( ancora_get_file_dir('skins/'.($skin).'/skin.php') );
	}

	// Fire init theme actions (after custom options loaded)
	do_action('ancora_action_init_theme');

	// Prepare theme core global variables
	do_action('ancora_action_prepare_globals');

	// Fire after init theme actions
	do_action('ancora_action_after_init_theme');
}


// Prepare theme global variables
if ( !function_exists( 'ancora_core_prepare_globals' ) ) {
	function ancora_core_prepare_globals() {
		if (!is_admin()) {
			// AJAX Queries settings
			global $ANCORA_GLOBALS;

			// Logo text and slogan
			$ANCORA_GLOBALS['logo_text'] = apply_filters('ancora_filter_prepare_logo_text', ancora_get_custom_option('logo_text'));
			$slogan = ancora_get_custom_option('logo_slogan');
			if (!$slogan) $slogan = get_bloginfo ( 'description' );
			$ANCORA_GLOBALS['logo_slogan'] = $slogan;
			
			// Logo image and icons from skin
			$logo_side   = ancora_get_logo_icon('logo_side');
			$logo_fixed  = ancora_get_logo_icon('logo_fixed');
			$logo_footer = ancora_get_logo_icon('logo_footer');
			$ANCORA_GLOBALS['logo_icon']   = ancora_get_logo_icon('logo_icon');
			$ANCORA_GLOBALS['logo_dark']   = ancora_get_logo_icon('logo_dark');
			$ANCORA_GLOBALS['logo_light']  = ancora_get_logo_icon('logo_light');
			$ANCORA_GLOBALS['logo_side']   = $logo_side   ? $logo_side   : $ANCORA_GLOBALS['logo_dark'];
			$ANCORA_GLOBALS['logo_fixed']  = $logo_fixed  ? $logo_fixed  : $ANCORA_GLOBALS['logo_dark'];
			$ANCORA_GLOBALS['logo_footer'] = $logo_footer ? $logo_footer : $ANCORA_GLOBALS['logo_dark'];
	
			$shop_mode = '';
			if (ancora_get_custom_option('show_mode_buttons')=='yes')
				$shop_mode = ancora_get_value_gpc('ancora_shop_mode');
			if (empty($shop_mode))
				$shop_mode = ancora_get_custom_option('shop_mode', '');
			if (empty($shop_mode) || !is_archive())
				$shop_mode = 'thumbs';
			$ANCORA_GLOBALS['shop_mode'] = $shop_mode;
		}
	}
}


// Return url for the uploaded logo image or (if not uploaded) - to image from skin folder
if ( !function_exists( 'ancora_get_logo_icon' ) ) {
	function ancora_get_logo_icon($slug) {
		global $ANCORA_GLOBALS;
		$skin = sanitize_file_name($ANCORA_GLOBALS['theme_skin']);
		$logo_icon = ancora_get_custom_option($slug);
		if (empty($logo_icon) && ancora_get_theme_option('logo_from_skin')=='yes' && file_exists(ancora_get_file_dir('skins/' . ($skin) . '/images/' . ($slug) . '.png')))
			$logo_icon = ancora_get_file_url('skins/' . ($skin) . '/images/' . ($slug) . '.png');
		return $logo_icon;
	}
}


// Add menu locations
if ( !function_exists( 'ancora_register_theme_menus' ) ) {
	function ancora_register_theme_menus() {
		register_nav_menus(apply_filters('ancora_filter_add_theme_menus', array(
			'menu_main' => esc_html__('Main Menu', 'blessing'),
			'menu_user' => esc_html__('User Menu', 'blessing'),
			'menu_side' => esc_html__('Side Menu', 'blessing')
		)));
	}
}


// Register widgetized area
if ( !function_exists( 'ancora_register_theme_sidebars' ) ) {
    add_action('widgets_init', 'ancora_register_theme_sidebars');
	function ancora_register_theme_sidebars($sidebars=array()) {
		global $ANCORA_GLOBALS;
		if (!is_array($sidebars)) $sidebars = array();
		// Custom sidebars
		$custom = ancora_get_theme_option('custom_sidebars');
		if (is_array($custom) && count($custom) > 0) {
			foreach ($custom as $i => $sb) {
				if (trim(chop($sb))=='') continue;
				$sidebars['sidebar_custom_'.($i)]  = $sb;
			}
		}
		$sidebars = apply_filters( 'ancora_filter_add_theme_sidebars', $sidebars );
        $registered = ancora_get_global('registered_sidebars');
        if (!is_array($registered)) $registered = array();
		if (count($sidebars) > 0) {
			foreach ($sidebars as $id=>$name) {
                if (isset($registered[$id])) continue;
                $registered[$id] = $name;
				register_sidebar( array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h5 class="widget_title">',
					'after_title'   => '</h5>',
				) );
			}
		}
        ancora_set_global('registered_sidebars', $registered);
	}
}





/* Front actions and filters:
------------------------------------------------------------------------ */

//  Enqueue scripts and styles
if ( !function_exists( 'ancora_core_frontend_scripts' ) ) {
	function ancora_core_frontend_scripts() {
		global $wp_styles, $ANCORA_GLOBALS;

		// Enqueue styles
		//-----------------------------------------------------------------------------------------------------
		
		// Prepare custom fonts
		$fonts = ancora_get_list_fonts(false);
		$theme_fonts = array();
		if (ancora_get_custom_option('typography_custom')=='yes') {
			$selectors = array('p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');
			foreach ($selectors as $s) {
				$font = ancora_get_custom_option('typography_'.($s).'_font');
				if (!empty($font)) $theme_fonts[$font] = 1;
			}
		}
		// Prepare current skin fonts
		$theme_fonts = apply_filters('ancora_filter_used_fonts', $theme_fonts);
		// Link to selected fonts
		foreach ($theme_fonts as $font=>$v) {
			if (isset($fonts[$font])) {
				$font_name = ($pos=ancora_strpos($font,' ('))!==false ? ancora_substr($font, 0, $pos) : $font;
				$css = !empty($fonts[$font]['css']) 
					? $fonts[$font]['css'] 
					: ancora_get_protocol().'://fonts.googleapis.com/css?family='
						.(!empty($fonts[$font]['link']) ? $fonts[$font]['link'] : str_replace(' ', '+', $font_name).':100,100italic,300,300italic,400,400italic,700,700italic')
						.(empty($fonts[$font]['link']) || ancora_strpos($fonts[$font]['link'], 'subset=')===false ? '&subset=latin,latin-ext,cyrillic,cyrillic-ext' : '');
				wp_enqueue_style( 'theme-font-'.str_replace(' ', '-', $font_name), $css, array(), null );
			}
		}
		
		// Fontello styles must be loaded before main stylesheet
		wp_enqueue_style( 'fontello-style',  ancora_get_file_url('css/fontello/css/fontello.css'),  array(), null);

		// Main stylesheet
		wp_enqueue_style( 'ancora-main-style', get_stylesheet_uri(), array(), null );
		
		if (ancora_get_theme_option('debug_mode')=='no' && ancora_get_theme_option('packed_scripts')=='yes' && file_exists(ancora_get_file_dir('css/__packed.css'))) {
			// Load packed styles
			wp_enqueue_style( 'ancora-packed-style',  		ancora_get_file_url('css/__packed.css'), array(), null );
		} else {
			// Shortcodes
            if(function_exists('trx_utils_get_file_url')){
                wp_enqueue_style( 'ancora-shortcodes-style',	trx_utils_get_file_url('shortcodes/shortcodes.css'), array(), null );
            }
			// Animations
			if (ancora_get_theme_option('css_animation')=='yes')
				wp_enqueue_style( 'ancora-animation-style',	ancora_get_file_url('css/core.animation.css'), array(), null );
		}
		// Theme skin stylesheet
		do_action('ancora_action_add_styles');
		
		// Theme customizer stylesheet and inline styles
		ancora_enqueue_custom_styles();

		// Responsive
		if (ancora_get_theme_option('responsive_layouts') == 'yes') {
			wp_enqueue_style( 'ancora-responsive-style', ancora_get_file_url('css/responsive.css'), array(), null );
			do_action('ancora_action_add_responsive');
			if (ancora_get_custom_option('theme_skin')!='') {
				$css = apply_filters('ancora_filter_add_responsive_inline', '');
				if (!empty($css)) wp_add_inline_style( 'ancora-responsive-style', $css );
			}
		}

		// Disable loading JQuery UI CSS
		$wp_styles->done[]	= 'jquery-ui';
		$wp_styles->done[]	= 'date-picker-css';


		// Enqueue scripts
		//----------------------------------------------------------------------------------------------------------------------------
		
		if (ancora_get_theme_option('debug_mode')=='no' && ancora_get_theme_option('packed_scripts')=='yes' && file_exists(ancora_get_file_dir('js/__packed.js'))) {
			// Load packed theme scripts
			wp_enqueue_script( 'ancora-packed-scripts', ancora_get_file_url('js/__packed.js'), array('jquery'), null, true);
		} else {
			// Load separate theme scripts
			wp_enqueue_script( 'superfish', ancora_get_file_url('js/superfish.min.js'), array('jquery'), null, true );
			if (ancora_get_theme_option('menu_slider')=='yes') {
				wp_enqueue_script( 'ancora-slidemenu-script', ancora_get_file_url('js/jquery.slidemenu.js'), array('jquery'), null, true );
			}
			
			if ( is_single() && ancora_get_custom_option('show_reviews')=='yes' && function_exists('ancora_reviews_theme_setup')) {
                wp_enqueue_script( 'ancora-core-reviews-script', trx_utils_get_file_url('includes/core.reviews.js'), array('jquery'), null, true );
			}
			wp_enqueue_script( 'ancora-core-utils-script', ancora_get_file_url('js/core.utils.js'), array('jquery'), null, true );
			wp_enqueue_script( 'ancora-core-init-script', ancora_get_file_url('js/core.init.js'), array('jquery'), null, true );
		}

		// Media elements library	
		if (ancora_get_theme_option('use_mediaelement')=='yes') {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		} else {
			global $wp_scripts;
			$wp_scripts->done[]	= 'mediaelement';
			$wp_scripts->done[]	= 'wp-mediaelement';
			$wp_styles->done[]	= 'mediaelement';
			$wp_styles->done[]	= 'wp-mediaelement';
		}
		
		// Video background
		if (ancora_get_custom_option('show_video_bg') == 'yes' && ancora_get_custom_option('video_bg_youtube_code') != '') {
			wp_enqueue_script( 'video-bg-script', ancora_get_file_url('js/jquery.tubular.js'), array('jquery'), null, true );
		}

			
		// Social share buttons
		if (is_singular() && !ancora_get_global('blog_streampage') && ancora_get_custom_option('show_share')!='hide') {
			wp_enqueue_script( 'ancora-social-share-script', ancora_get_file_url('js/social/social-share.js'), array('jquery'), null, true );
		}

		// Comments
		if ( is_singular() && !ancora_get_global('blog_streampage') && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), null, true );
		}

		// Custom panel
		if (ancora_get_theme_option('show_theme_customizer') == 'yes') {
			if (file_exists(ancora_get_file_dir('core/core.customizer/front.customizer.css')))
				wp_enqueue_style(  'ancora-customizer-style',  ancora_get_file_url('core/core.customizer/front.customizer.css'), array(), null );
			if (file_exists(ancora_get_file_dir('core/core.customizer/front.customizer.js')))
				wp_enqueue_script( 'ancora-customizer-script', ancora_get_file_url('core/core.customizer/front.customizer.js'), array(), null, true );
		}
		
		//Debug utils
		if (ancora_get_theme_option('debug_mode')=='yes') {
			wp_enqueue_script( 'ancora-core-debug-script', ancora_get_file_url('js/core.debug.js'), array(), null, true );
		}

		// Theme skin script
		do_action('ancora_action_add_scripts');
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'ancora_enqueue_slider' ) ) {
	function ancora_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('css/__packed.css'))) {
				wp_enqueue_style( 'swiperslider-style', ancora_get_file_url('js/swiper/swiper.css'), array(), null );
			}
			if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('js/__packed.js'))) {
				wp_enqueue_script( 'swiperslider-script', 			ancora_get_file_url('js/swiper/swiper.js'), array('jquery'), null, true );
				wp_enqueue_script( 'swiperslider-scrollbar-script',	ancora_get_file_url('js/swiper/swiper.scrollbar.js'), array('jquery'), null, true );
			}
		}
	}
}

//  Enqueue Messages scripts and styles
if ( !function_exists( 'ancora_enqueue_messages' ) ) {
	function ancora_enqueue_messages() {
		if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('css/__packed.css'))) {
			wp_enqueue_style( 'ancora-messages-style',		ancora_get_file_url('js/core.messages/core.messages.css'), array(), null );
		}
		if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('js/__packed.js'))) {
			wp_enqueue_script( 'ancora-messages-script',	ancora_get_file_url('js/core.messages/core.messages.js'),  array('jquery'), null, true );
		}
	}
}

//  Enqueue Portfolio hover scripts and styles
if ( !function_exists( 'ancora_enqueue_portfolio' ) ) {
	function ancora_enqueue_portfolio($hover='') {
		if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('css/__packed.css'))) {
			wp_enqueue_style( 'ancora-portfolio-style',  ancora_get_file_url('css/core.portfolio.css'), array(), null );
			if (ancora_strpos($hover, 'effect_dir')!==false)
				wp_enqueue_script( 'hoverdir', ancora_get_file_url('js/hover/jquery.hoverdir.js'), array(), null, true );
		}
	}
}

//  Enqueue Charts and Diagrams scripts and styles
if ( !function_exists( 'ancora_enqueue_diagram' ) ) {
	function ancora_enqueue_diagram($type='all') {
		if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('js/__packed.js'))) {
			if ($type=='all' || $type=='pie') wp_enqueue_script( 'diagram-chart-script',	ancora_get_file_url('js/diagram/chart.min.js'), array(), null, true );
			if ($type=='all' || $type=='arc') wp_enqueue_script( 'diagram-raphael-script',	ancora_get_file_url('js/diagram/diagram.raphael.min.js'), array(), 'no-compose', true );
		}
	}
}

// Enqueue Theme Popup scripts and styles
// Link must have attribute: data-rel="popup" or data-rel="popup[gallery]"
if ( !function_exists( 'ancora_enqueue_popup' ) ) {
	function ancora_enqueue_popup($engine='') {
		if ($engine=='pretty' || (empty($engine) && ancora_get_theme_option('popup_engine')=='pretty')) {
			wp_enqueue_style(  'prettyphoto-style',	ancora_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			wp_enqueue_script( 'prettyphoto-script',	ancora_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else if ($engine=='magnific' || (empty($engine) && ancora_get_theme_option('popup_engine')=='magnific')) {
			wp_enqueue_style(  'magnific-style',	ancora_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			wp_enqueue_script( 'magnific-script',ancora_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), '', true );
		} else if ($engine=='internal' || (empty($engine) && ancora_get_theme_option('popup_engine')=='internal')) {
			ancora_enqueue_messages();
		}
	}
}

//  Add inline scripts in the footer hook
if ( !function_exists( 'ancora_core_frontend_scripts_inline' ) ) {
	function ancora_core_frontend_scripts_inline() {
        $vars = ancora_get_global('js_vars');
        if (empty($vars) || !is_array($vars)) $vars = array();
        wp_localize_script('ancora-core-init-script', 'ANCORA_GLOBALS', apply_filters('ancora_action_add_scripts_inline', $vars));
	}
}

//  Add inline scripts in the footer
if (!function_exists('ancora_core_add_scripts_inline')) {
	function ancora_core_add_scripts_inline($vars = array()) {
        $msg = ancora_get_system_message(true);
        if (!empty($msg['message'])) ancora_enqueue_messages();

        // AJAX parameters
        $vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
        $vars['ajax_nonce'] = esc_attr(wp_create_nonce('ajax_nonce'));
        $vars['ajax_nonce_editor'] = esc_attr(wp_create_nonce('ancora_editor_nonce'));
        $vars['ajax_login'] = ancora_get_theme_option('ajax_login')=='yes';

        // AJAX posts counter
        $vars['use_ajax_views_counter'] = is_singular() && ancora_get_theme_option('use_ajax_views_counter')=='yes';
        if (is_singular() && ancora_get_theme_option('use_ajax_views_counter')=='yes' && function_exists('trx_utils_get_post_views')) {
            $vars['post_id'] = (int) get_the_ID();
            $vars['views'] = (int) trx_utils_get_post_views(get_the_ID()) + 1;
        }

        // Site base url
        $vars['site_url'] = esc_url(get_site_url());

        // Site protocol
        $vars['site_protocol'] = ancora_get_protocol();


        // VC frontend edit mode
        $vars['vc_edit_mode'] = function_exists('ancora_vc_is_frontend') && ancora_vc_is_frontend();

        // Theme base font
        $vars['theme_font'] = ancora_get_custom_option('typography_custom')=='yes' ? ancora_get_custom_option('typography_p_font') : '';

        // Theme skin
        $vars['theme_skin'] = esc_attr(ancora_get_custom_option('theme_skin'));
        $vars['theme_skin_bg'] = apply_filters('ancora_filter_get_theme_bgcolor', '');

        // Slider height
        $vars['slider_height'] = max(100, ancora_get_custom_option('slider_height'));

        // System message
        $vars['system_message']    = $msg;

        // User logged in
        $vars['user_logged_in']    = is_user_logged_in();

        // Show table of content for the current page
        $vars['toc_menu'] = ancora_get_custom_option('menu_toc');
        $vars['toc_menu_home'] = ancora_get_custom_option('menu_toc')!='hide' && ancora_get_custom_option('menu_toc_home')=='yes';
        $vars['toc_menu_top'] = ancora_get_custom_option('menu_toc')!='hide' && ancora_get_custom_option('menu_toc_top')=='yes';

        // Fix main menu
        $vars['menu_fixed'] = ancora_get_theme_option('menu_position')=='fixed';

        // Use responsive version for main menu
        $vars['menu_relayout'] = max(0, (int) ancora_get_theme_option('menu_relayout'));
        $vars['menu_responsive'] = ancora_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) ancora_get_theme_option('menu_responsive')) : 0;
        $vars['menu_slider'] = ancora_get_theme_option('menu_slider')=='yes';

        // Right panel demo timer
        $vars['demo_time'] = ancora_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) ancora_get_theme_option('customizer_demo')) : 0;

        // Right panel demo timer
        $vars['demo_time'] = ancora_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) ancora_get_theme_option('customizer_demo')) : 0;

        // Video and Audio tag wrapper
        $vars['media_elements_enabled'] = ancora_get_theme_option('use_mediaelement')=='yes';

        // Use AJAX search
        $vars['ajax_search_enabled'] = ancora_get_theme_option('use_ajax_search')=='yes';
        $vars['ajax_search_min_length']    = min(3, ancora_get_theme_option('ajax_search_min_length'));
        $vars['ajax_search_delay'] = min(200, max(1000, ancora_get_theme_option('ajax_search_delay')));

        // Use CSS animation
        $vars['css_animation'] = ancora_get_theme_option('css_animation')=='yes';
        $vars['menu_animation_in'] = ancora_get_theme_option('menu_animation_in');
        $vars['menu_animation_out'] = ancora_get_theme_option('menu_animation_out');

        // Popup windows engine
        $vars['popup_engine'] = ancora_get_theme_option('popup_engine');
        $vars['popup_gallery'] = ancora_get_theme_option('popup_gallery') =='yes';

        // E-mail mask
        $vars['email_mask'] = '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';

        // Messages max length
        $vars['contacts_maxlength']    = intval(ancora_get_theme_option('message_maxlength_contacts'));
        $vars['comments_maxlength']    = intval(ancora_get_theme_option('message_maxlength_comments'));

        // Remember visitors settings
        $vars['remember_visitors_settings']    = ancora_get_theme_option('remember_visitors_settings')=='yes';

        // Internal vars - do not change it!
        // Flag for review mechanism
        $vars['admin_mode'] = false;
        // Max scale factor for the portfolio and other isotope elements before relayout
        $vars['isotope_resize_delta'] = 0.3;
        // jQuery object for the message box in the form
        $vars['error_message_box'] = null;
        // Waiting for the viewmore results
        $vars['viewmore_busy'] = false;
        $vars['video_resize_inited'] = false;
        $vars['top_panel_height'] = 0;

        return $vars;
	}
}


//  Enqueue Custom styles (main Theme options settings)
if ( !function_exists( 'ancora_enqueue_custom_styles' ) ) {
	function ancora_enqueue_custom_styles() {
		// Custom stylesheet
		$custom_css = '';	
		wp_enqueue_style( 'ancora-custom-style', $custom_css ? $custom_css : ancora_get_file_url('css/custom-style.css'), array(), null );
		// Custom inline styles
		wp_add_inline_style( 'ancora-custom-style', ancora_prepare_custom_styles() );
	}
}

// Add class "widget_number_#' for each widget
if ( !function_exists( 'ancora_add_widget_number' ) ) {
	function ancora_add_widget_number($prm) {
		global $ANCORA_GLOBALS;
		if (is_admin()) return $prm;
		static $num=0, $last_sidebar='', $last_sidebar_id='', $last_sidebar_columns=0, $last_sidebar_count=0, $sidebars_widgets=array();
		$cur_sidebar = $ANCORA_GLOBALS['current_sidebar'];
		if (count($sidebars_widgets) == 0)
			$sidebars_widgets = wp_get_sidebars_widgets();
		if ($last_sidebar != $cur_sidebar) {
			$num = 0;
			$last_sidebar = $cur_sidebar;
			$last_sidebar_id = $prm[0]['id'];
			$last_sidebar_columns = max(1, (int) ancora_get_custom_option('sidebar_'.($cur_sidebar).'_columns'));
			$last_sidebar_count = count($sidebars_widgets[$last_sidebar_id]);
		}
		$num++;
		$prm[0]['before_widget'] = str_replace(' class="', ' class="widget_number_'.esc_attr($num).($last_sidebar_columns > 1 ? ' column-1_'.esc_attr($last_sidebar_columns) : '').' ', $prm[0]['before_widget']);
		return $prm;
	}
}


// Filters wp_title to print a neat <title> tag based on what is being viewed.

if ( !function_exists( 'ancora_wp_title' ) ) {
	function ancora_wp_title( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) return $title;
		// Add the blog name
		$title .= get_bloginfo( 'name' );
		// Add the blog description for the home/front page.
		if ( is_home() || is_front_page() ) {
			$site_description = ancora_get_custom_option('logo_slogan');
			if (empty($site_description)) 
				$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description )
				$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( __( 'Page %s', 'blessing' ), max( $paged, $page ) );
		return $title;
	}
}

// Add main menu classes

if ( !function_exists( 'ancora_add_mainmenu_classes' ) ) {
	function ancora_add_mainmenu_classes($items, $args) {
		if (is_admin()) return $items;
		if ($args->menu_id == 'mainmenu' && ancora_get_theme_option('menu_colored')=='yes') {
			foreach($items as $k=>$item) {
				if ($item->menu_item_parent==0) {
					if ($item->type=='taxonomy' && $item->object=='category') {
						$cur_tint = ancora_taxonomy_get_inherited_property('category', $item->object_id, 'bg_tint');
						if (!empty($cur_tint) && !ancora_is_inherit_option($cur_tint))
							$items[$k]->classes[] = 'bg_tint_'.esc_attr($cur_tint);
					}
				}
			}
		}
		return $items;
	}
}


// Save post data from frontend editor
if ( !function_exists( 'ancora_callback_frontend_editor_save' ) ) {
	function ancora_callback_frontend_editor_save() {
		global $_REQUEST;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ancora_editor_nonce' ) )
			wp_die();

		$response = array('error'=>'');

        parse_str(ancora_get_value_gp('data'), $output);
		$post_id = $output['frontend_editor_post_id'];

		if ( ancora_get_theme_option("allow_editor")=='yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id)) ) {
			if ($post_id > 0) {
				$title   = stripslashes($output['frontend_editor_post_title']);
				$content = stripslashes($output['frontend_editor_post_content']);
				$excerpt = stripslashes($output['frontend_editor_post_excerpt']);
				$rez = wp_update_post(array(
					'ID'           => $post_id,
					'post_content' => $content,
					'post_excerpt' => $excerpt,
					'post_title'   => $title
				));
				if ($rez == 0) 
					$response['error'] = esc_html__('Post update error!', 'blessing');
			} else {
				$response['error'] = esc_html__('Post update error!', 'blessing');
			}
		} else
			$response['error'] = esc_html__('Post update denied!', 'blessing');
		
		echo json_encode($response);
		wp_die();
	}
}

// Delete post from frontend editor
if ( !function_exists( 'ancora_callback_frontend_editor_delete' ) ) {
	function ancora_callback_frontend_editor_delete() {
		global $_REQUEST;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ancora_editor_nonce' ) )
			wp_die();

		$response = array('error'=>'');
		
		$post_id = sanitize_text_field($_REQUEST['post_id']);

		if ( ancora_get_theme_option("allow_editor")=='yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id)) ) {
			if ($post_id > 0) {
				$rez = wp_delete_post($post_id);
				if ($rez === false) 
					$response['error'] = esc_html__('Post delete error!', 'blessing');
			} else {
				$response['error'] = esc_html__('Post delete error!', 'blessing');
			}
		} else
			$response['error'] = esc_html__('Post delete denied!', 'blessing');

		echo json_encode($response);
		wp_die();
	}
}


// Prepare logo text
if ( !function_exists( 'ancora_prepare_logo_text' ) ) {
	function ancora_prepare_logo_text($text) {
		$text = str_replace(array('[', ']'), array('<span class="theme_accent">', '</span>'), $text);
		$text = str_replace(array('{', '}'), array('<strong>', '</strong>'), $text);
		return $text;
	}
}
?>