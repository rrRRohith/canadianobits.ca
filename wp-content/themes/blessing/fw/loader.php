<?php
/**
 * ANCORA Framework
 *
 * @package ancora
 * @since ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'ANCORA_FW_DIR' ) )		define( 'ANCORA_FW_DIR', '/fw/' );
if ( ! defined( 'ANCORA_THEME_PATH' ) )	define( 'ANCORA_THEME_PATH',	trailingslashit( get_template_directory() ) );
if ( ! defined( 'ANCORA_FW_PATH' ) )		define( 'ANCORA_FW_PATH',		ANCORA_THEME_PATH . ANCORA_FW_DIR . '/' );


// Theme timing
if ( ! defined( 'ANCORA_START_TIME' ) )	define( 'ANCORA_START_TIME', microtime());			// Framework start time
if ( ! defined( 'ANCORA_START_MEMORY' ) )	define( 'ANCORA_START_MEMORY', memory_get_usage());	// Memory usage before core loading

// Global variables storage
global $ANCORA_GLOBALS;
$ANCORA_GLOBALS = array(
    'options_prefix'=> 'ancora',	// Theme slug (used as prefix for theme's functions, text domain, global variables, etc.)
    'theme_slug' => 'ancora', // Theme slug (used as prefix for theme's functions, text domain, global variables, etc.)
    'page_template' => ''   // Storage for current page template name (used in the inheritance system)
);
$ANCORA_GLOBALS['admin_url']	= get_admin_url();
$ANCORA_GLOBALS['admin_nonce']= wp_create_nonce($ANCORA_GLOBALS['admin_url']);
$ANCORA_GLOBALS['ajax_url']	= esc_url(admin_url('admin-ajax.php'));
$ANCORA_GLOBALS['ajax_nonce']	= wp_create_nonce($ANCORA_GLOBALS['ajax_url']);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'ancora_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'ancora_loader_theme_setup', 20 );
	function ancora_loader_theme_setup() {
        global $ANCORA_GLOBALS;
        $ANCORA_GLOBALS['admin_url']	= get_admin_url();
        $ANCORA_GLOBALS['admin_nonce']= wp_create_nonce($ANCORA_GLOBALS['admin_url']);
        $ANCORA_GLOBALS['ajax_url']	= esc_url(admin_url('admin-ajax.php'));
        $ANCORA_GLOBALS['ajax_nonce']	= wp_create_nonce($ANCORA_GLOBALS['ajax_url']);
        
		// Before init theme
		do_action('ancora_action_before_init_theme');

		// Load current values for main theme options
		ancora_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			ancora_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// core.strings must be first - we use ancora_str...() in the ancora_get_file_dir()
// core.files must be first - we use ancora_get_file_dir() to include all rest parts
require_once( (file_exists(get_stylesheet_directory().(ANCORA_FW_DIR).'core/core.strings.php') ? get_stylesheet_directory() : get_template_directory()).(ANCORA_FW_DIR).'core/core.strings.php' );
require_once( (file_exists(get_stylesheet_directory().(ANCORA_FW_DIR).'core/core.files.php') ? get_stylesheet_directory() : get_template_directory()).(ANCORA_FW_DIR).'core/core.files.php' );
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.admin.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.arrays.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.date.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.debug.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.globals.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.html.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.http.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.ini.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.less.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.lists.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.media.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.messages.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.templates.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.theme.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.updater.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.wp.php');

require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.customizer/core.customizer.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/core.options/core.options.php');

require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.revslider.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.contact-form-7.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.elegro-payment.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.gdpr-compliance.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.gutenberg.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.calculated-fields-form.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.visual-composer.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.widgets.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/plugin.woocommerce.php');

require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.attachment.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.post.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.post_type.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.taxonomy.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.team.php');
require_once ancora_get_file_dir(ANCORA_FW_DIR . 'core/type.testimonials.php');

// Include theme templates
require_once ancora_get_file_dir('templates/404.php');
require_once ancora_get_file_dir('templates/accordion.php');
require_once ancora_get_file_dir('templates/attachment.php');
require_once ancora_get_file_dir('templates/date.php');
require_once ancora_get_file_dir('templates/excerpt.php');
require_once ancora_get_file_dir('templates/list.php');
require_once ancora_get_file_dir('templates/masonry.php');
require_once ancora_get_file_dir('templates/news.php');
require_once ancora_get_file_dir('templates/no-articles.php');
require_once ancora_get_file_dir('templates/no-search.php');
require_once ancora_get_file_dir('templates/obituaries.php');
require_once ancora_get_file_dir('templates/portfolio.php');
require_once ancora_get_file_dir('templates/related.php');
require_once ancora_get_file_dir('templates/single-portfolio.php');
require_once ancora_get_file_dir('templates/single-standard.php');
require_once ancora_get_file_dir('templates/single-team.php');
require_once ancora_get_file_dir('templates/test.php');
?>