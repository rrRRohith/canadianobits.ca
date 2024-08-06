<?php
/**
 * Theme sprecific functions and definitions
 */


/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'ancora_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_theme_setup', 1 );
	function ancora_theme_setup() {
        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

		// Register theme menus
		add_filter( 'ancora_filter_add_theme_menus',		'ancora_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'ancora_filter_add_theme_sidebars',	'ancora_add_theme_sidebars' );

        // Set options for importer
        add_filter( 'ancora_filter_importer_options',		'ancora_set_importer_options' );

		// Set theme name and folder (for the update notifier)
		add_filter('ancora_filter_update_notifier', 		'ancora_set_theme_names_for_updater');

		// Set list of the theme required custom fonts from folder /css/font-faces
		// Attention! Font's folder must have name equal to the font's name
		ancora_set_global('required_custom_fonts', array(
			'Amadeus'
			)
		);

        // Gutenberg support
        add_theme_support( 'align-wide' );


        // Set list of the theme required plugins
        ancora_set_global('required_plugins', array(
                'revslider',
                'ancora-utils',
                'woocommerce',
                'ancora-paypal-donation',
                'calculated-fields-form',
                'wp-instagram-widget',
                'instagram-widget-by-wpzoom',
                'visual_composer'
            )
        );

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'ancora_add_theme_menus' ) ) {
	
	function ancora_add_theme_menus($menus) {
		if (isset($menus['menu_side'])) unset($menus['menu_side']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'ancora_add_theme_sidebars' ) ) {
	
	function ancora_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'blessing' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'blessing' )
			);
			if (ancora_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'blessing' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Set theme name and folder (for the update notifier)
if ( !function_exists( 'ancora_set_theme_names_for_updater' ) ) {
	
	function ancora_set_theme_names_for_updater($opt) {
		$opt['theme_name']   = 'Blessing';
		$opt['theme_folder'] = 'blessing';
		return $opt;
	}
}


function ancora_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'ancora_move_comment_field_to_bottom' );

// Add page meta to the head
if (!function_exists('ancora_head_add_page_meta')) {
    add_action('wp_head', 'ancora_head_add_page_meta', 1);
    function ancora_head_add_page_meta() {
        $theme_skin = sanitize_file_name(ancora_get_custom_option('theme_skin'));
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <?php
        if (ancora_get_theme_option('responsive_layouts') == 'yes') {
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <?php
        }
        if (floatval(get_bloginfo('version')) < "4.1") {
            ?>
            <title><?php wp_title( '|', true, 'right' ); ?></title>
            <?php
        }
        ?>
        <link rel="profile" href="//gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php

    }
}

// Return text for the Privacy Policy checkbox
if ( ! function_exists('ancora_get_privacy_text' ) ) {
    function ancora_get_privacy_text() {
        $page = get_option( 'wp_page_for_privacy_policy' );
        $privacy_text = ancora_get_theme_option( 'privacy_text' );
        return apply_filters( 'ancora_filter_privacy_text', wp_kses_post(
                $privacy_text
                . ( ! empty( $page ) && ! empty( $privacy_text )
                    // Translators: Add url to the Privacy Policy page
                    ? ' ' . sprintf( __( 'For further details on handling user data, see our %s', 'blessing' ),
                        '<a href="' . esc_url( get_permalink( $page ) ) . '" target="_blank">'
                        . __( 'Privacy Policy', 'blessing' )
                        . '</a>' )
                    : ''
                )
            )
        );
    }
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'ancora_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'ancora_trx_addons_privacy_text' );
    function ancora_trx_addons_privacy_text( $text='' ) {
        return ancora_get_privacy_text();
    }
}

// Add theme required plugins
if ( !function_exists( 'ancora_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'ancora_add_trx_utils' );
    function ancora_add_trx_utils($enable=true) {
        return true;
    }
}

// Check shortcodes params
if (!function_exists('ancora_sc_param_is_on')) {
    function ancora_sc_param_is_on($prm) {
        return $prm>0 || in_array(ancora_strtolower($prm), array('true', 'on', 'yes', 'show'));
    }
}
if (!function_exists('ancora_sc_param_is_off')) {
    function ancora_sc_param_is_off($prm) {
        return empty($prm) || $prm===0 || in_array(ancora_strtolower($prm), array('false', 'off', 'no', 'none', 'hide'));
    }
}

//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'ancora_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'ancora_importer_set_options', 9 );
    function ancora_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file
            $options['debug'] = false;
            // Prepare demo data
            if ( is_dir( ANCORA_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = ANCORA_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( ancora_get_protocol().'://demofiles.ancorathemes.com/blessing/' ); // Demo-site domain
            }

            // Required plugins
            $options['required_plugins'] =  array(
                'revslider',
                'js_composer',
                'contact-form-7',
                'woocommerce',
                'calculated-fields-form',
            );

            $options['theme_slug'] = 'ancora';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
            $options['regenerate_thumbnails'] = 3;
            // Default demo
            $options['files']['default']['title'] = esc_html__( 'Blessing Demo', 'blessing' );
            $options['files']['default']['domain_dev'] = esc_url('http://blessing.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url('http://blessing.ancorathemes.com'); // Demo-site domain

        }
        return $options;
    }
}

// Add theme specified classes to the body
if ( ! function_exists( 'ancora_add_body_classes' ) ) {
    add_filter( 'body_class', 'ancora_add_body_classes' );
    function ancora_add_body_classes($classes) {
        $class = $style = '';
        $theme_skin = sanitize_file_name(ancora_get_custom_option('theme_skin'));
        $blog_style = ancora_get_custom_option(is_singular() && !ancora_get_global('blog_streampage') ? 'single_style' : 'blog_style');
        $article_style = ancora_get_custom_option('article_style');
        $top_panel_style = ancora_get_custom_option('top_panel_style');
        $top_panel_opacity = ancora_get_custom_option('top_panel_opacity');
        $top_panel_position = ancora_get_custom_option('top_panel_position');
        $video_bg_show = ancora_get_custom_option('show_video_bg') == 'yes' && (ancora_get_custom_option('video_bg_youtube_code') != '' || ancora_get_custom_option('video_bg_url') != '');
        $classes[] = 'body_' . (ancora_get_custom_option('body_filled') == 'yes' ? 'filled' : 'transparent');
        $classes[] = 'theme_skin_' . esc_attr($theme_skin);
        $classes[] = ' article_style_' . esc_attr($article_style);
        $classes[] = ' layout_' . esc_attr($blog_style);
        $classes[] = ' template_' . esc_attr(ancora_get_template_name($blog_style));
        $classes[] = ' top_panel_style_' . esc_attr($top_panel_style);
        $classes[] = ' top_panel_opacity_' . esc_attr($top_panel_opacity);
        $classes[] = ' menu_' . esc_attr(ancora_get_custom_option('menu_align'));
        $classes[] = ' user_menu_' . (ancora_get_custom_option('show_menu_user') == 'yes' ? 'show' : 'hide');
        $classes[] = ($video_bg_show ? ' video_bg_show' : '');
        $classes[] = ($class != '' ? ' ' . esc_attr($class) : '');
        $classes[] = esc_attr(ancora_get_sidebar_class(ancora_get_custom_option('show_sidebar_main'), ancora_get_custom_option('sidebar_main_position')));
        $classes[] = ($top_panel_position != 'hide' ? ' top_panel_show top_panel_' . esc_attr($top_panel_position) : '');
        if ($style!='') echo ' style="'.esc_attr($style).'"';
        return $classes;
    }
}





/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action('wp_body_open');
    }
}

/* Include framework core files
------------------------------------------------------------------- */

require_once( get_template_directory().'/fw/loader.php' );
?>