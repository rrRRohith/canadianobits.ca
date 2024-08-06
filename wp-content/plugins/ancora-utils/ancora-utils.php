<?php
/*
Plugin Name: Ancora Utilities
Plugin URI: http://ancorathemes.com
Description: Utils for files, directories, post type and taxonomies manipulations
Version: 3.1
Author: Ancora
Author URI: http://ancorathemes.com
*/

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin's storage
if ( ! defined( 'TRX_UTILS_PLUGIN_DIR' ) ) define( 'TRX_UTILS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if ( ! defined( 'TRX_UTILS_PLUGIN_URL' ) ) define( 'TRX_UTILS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'TRX_UTILS_PLUGIN_BASE' ) ) define( 'TRX_UTILS_PLUGIN_BASE', dirname( plugin_basename( __FILE__ ) ) );

// Current version
if ( ! defined( 'TRX_UTILS_VERSION' ) ) {
	define( 'TRX_UTILS_VERSION', '3.0' );
}

global $TRX_UTILS_STORAGE;
$TRX_UTILS_STORAGE = array(
	// Plugin's location and name
	'plugin_dir' => plugin_dir_path(__FILE__),
	'plugin_url' => plugin_dir_url(__FILE__),
	'plugin_base'=> explode('/', plugin_basename(__FILE__)),
	'plugin_active' => false,
	// Custom post types and taxonomies
	'register_taxonomies' => array(),
	'register_post_types' => array()
);


/* Types and taxonomies 
------------------------------------------------------ */

// Plugin activate hook
if (!function_exists('trx_utils_activate')) {
	register_activation_hook(__FILE__, 'trx_utils_activate');
	function trx_utils_activate() {
		update_option('trx_utils_just_activated', 'yes');
	}
}

// Plugin init
if (!function_exists('trx_utils_setup')) {
	add_action( 'init', 'trx_utils_setup' );
	function trx_utils_setup() {
		global $TRX_UTILS_STORAGE;

		// Load translation files
		trx_utils_load_plugin_textdomain();
		
		if (count($TRX_UTILS_STORAGE['register_taxonomies']) > 0) {
			foreach ($TRX_UTILS_STORAGE['register_taxonomies'] as $name=>$args) {
				do_action('trx_utils_custom_taxonomy', $name, $args);
			}
		}
		
		if (count($TRX_UTILS_STORAGE['register_post_types']) > 0) {
			foreach ($TRX_UTILS_STORAGE['register_post_types'] as $name=>$args) {
				do_action('trx_utils_custom_post_type', $name, $args);
			}
		}

		// Check if this is first run
		if (get_option('trx_utils_just_activated')=='yes') {
			update_option('trx_utils_just_activated', 'no');
			flush_rewrite_rules();			
		}
	}
}

/* Load plugin's translation files
------------------------------------------------------------------- */
if ( !function_exists( 'trx_utils_load_plugin_textdomain' ) ) {
    function trx_utils_load_plugin_textdomain($domain='ancora-utils') {
        if ( is_textdomain_loaded( $domain ) && !is_a( $GLOBALS['l10n'][ $domain ], 'NOOP_Translations' ) ) return true;
        return load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
    }
}

// Register theme required types and taxes
if (!function_exists('ancora_require_data')) {	
	function ancora_require_data($type, $name, $args) {
		if ($type == 'taxonomy')
			register_taxonomy($name, $args['post_type'], $args);
		else
			register_post_type($name, $args);
	}
}


/* Shortcodes
------------------------------------------------------ */

// Register theme required shortcodes
if (!function_exists('ancora_require_shortcode')) {	
	function ancora_require_shortcode($name, $callback) {
		add_shortcode($name, $callback);
	}
}


/* Twitter API
------------------------------------------------------ */
if (!function_exists('ancora_twitter_acquire_data')) {
	function ancora_get_twitter_data($cfg) {
		if (empty($cfg['mode'])) $cfg['mode'] = 'user_timeline';
		$data = get_transient("twitter_data_".($cfg['mode']));
		if (!$data) {
			require_once( plugin_dir_path( __FILE__ ) . 'lib/tmhOAuth/tmhOAuth.php' );
			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'    => $cfg['consumer_key'],
				'consumer_secret' => $cfg['consumer_secret'],
				'token'           => $cfg['token'],
				'secret'          => $cfg['secret']
			));
			$code = $tmhOAuth->user_request(array(
				'url' => $tmhOAuth->url(ancora_twitter_mode_url($cfg['mode']))
			));
			if ($code == 200) {
				$data = json_decode($tmhOAuth->response['response'], true);
				if (isset($data['status'])) {
					$code = $tmhOAuth->user_request(array(
						'url' => $tmhOAuth->url(ancora_twitter_mode_url($cfg['oembed'])),
						'params' => array(
							'id' => $data['status']['id_str']
						)
					));
					if ($code == 200)
						$data = json_decode($tmhOAuth->response['response'], true);
				}
				set_transient("twitter_data_".($cfg['mode']), $data, 60*60);
			}
		} else if (!is_array($data) && substr($data, 0, 2)=='a:') {
			$data = unserialize($data);
		}
		return $data;
	}
}

if (!function_exists('ancora_twitter_mode_url')) {
	function ancora_twitter_mode_url($mode) {
		$url = '/1.1/statuses/';
		if ($mode == 'user_timeline')
			$url .= $mode;
		else if ($mode == 'home_timeline')
			$url .= $mode;
		return $url;
	}
}

/* Support for meta boxes
--------------------------------------------------- */
if (!function_exists('trx_utils_meta_box_add')) {
    add_action('add_meta_boxes', 'trx_utils_meta_box_add');
    function trx_utils_meta_box_add() {
        // Custom theme-specific meta-boxes
        $boxes = apply_filters('trx_utils_filter_override_options', array());
        if (is_array($boxes)) {
            foreach ($boxes as $box) {
                $box = array_merge(array('id' => '',
                    'title' => '',
                    'callback' => '',
                    'page' => null,        // screen
                    'context' => 'advanced',
                    'priority' => 'default',
                    'callbacks' => null
                ),
                    $box);
                add_meta_box($box['id'], $box['title'], $box['callback'], $box['page'], $box['context'], $box['priority'], $box['callbacks']);
            }
        }
    }
}

// Return text for the Privacy Policy checkbox
if (!function_exists('trx_utils_get_privacy_text')) {
    function trx_utils_get_privacy_text() {
        $page = get_option('wp_page_for_privacy_policy');
        return apply_filters( 'trx_utils_filter_privacy_text', wp_kses_post(
                __( 'I agree that my submitted data is being collected and stored.', 'ancora-utils' )
                . ( '' != $page
                    // Translators: Add url to the Privacy Policy page
                    ? ' ' . sprintf(__('For further details on handling user data, see our %s', 'ancora-utils'),
                        '<a href="' . esc_url(get_permalink($page)) . '" target="_blank">'
                        . __('Privacy Policy', 'ancora-utils')
                        . '</a>')
                    : ''
                )
            )
        );
    }
}

// Shortcodes init
if (!function_exists('trx_utils_sc_init')) {
    add_action( 'after_setup_theme', 'trx_utils_sc_init' );
    function trx_utils_sc_init() {
        global $TRX_UTILS_STORAGE;
        if ( !($TRX_UTILS_STORAGE['plugin_active'] = apply_filters('trx_utils_active', $TRX_UTILS_STORAGE['plugin_active'])) ) return;

        // Include shortcodes
        require_once trx_utils_get_file_dir('shortcodes/core.shortcodes.php');
    }
}

require_once 'includes/plugin.files.php';
require_once trx_utils_get_file_dir('includes/plugin.debug.php');
require_once trx_utils_get_file_dir('includes/plugin.html.php');
require_once trx_utils_get_file_dir('includes/plugin.users.php');
require_once trx_utils_get_file_dir('includes/core.socials.php');
require_once trx_utils_get_file_dir('includes/core.users.php');
require_once trx_utils_get_file_dir('includes/core.reviews.php');

// Shortcodes init
if (!function_exists('trx_utils_sc_init')) {
    add_action( 'after_setup_theme', 'trx_utils_sc_init' );
    function trx_utils_sc_init() {
        global $TRX_UTILS_STORAGE;
        if ( !($TRX_UTILS_STORAGE['plugin_active'] = apply_filters('trx_utils_active', $TRX_UTILS_STORAGE['plugin_active'])) ) return;

        // Include shortcodes
        require_once trx_utils_get_file_dir('shortcodes/core.shortcodes.php');
    }
}


// Widgets init
if (!function_exists('trx_utils_setup_widgets')) {
    add_action( 'widgets_init', 'trx_utils_setup_widgets', 9 );
    function trx_utils_setup_widgets() {
        global $TRX_UTILS_STORAGE;
        if ( !($TRX_UTILS_STORAGE['plugin_active'] = apply_filters('trx_utils_active', $TRX_UTILS_STORAGE['plugin_active'])) ) return;

        // Include widgets
        require_once trx_utils_get_file_dir('widgets/advert.php');
        require_once trx_utils_get_file_dir('widgets/banner.php');
        require_once trx_utils_get_file_dir('widgets/big_banner.php');
        require_once trx_utils_get_file_dir('widgets/calendar.php');
        require_once trx_utils_get_file_dir('widgets/categories.php');
        require_once trx_utils_get_file_dir('widgets/flickr.php');
        require_once trx_utils_get_file_dir('widgets/most_commented.php');
        require_once trx_utils_get_file_dir('widgets/most_viewed.php');
        require_once trx_utils_get_file_dir('widgets/popular_posts.php');
        require_once trx_utils_get_file_dir('widgets/recent_posts.php');
        require_once trx_utils_get_file_dir('widgets/socials.php');
        require_once trx_utils_get_file_dir('widgets/top10.php');
        require_once trx_utils_get_file_dir('widgets/twitter.php');
        require_once trx_utils_get_file_dir('widgets/qrcode/qrcode.php');
    }
}

/* Support for meta boxes
--------------------------------------------------- */
if (!function_exists('trx_utils_meta_box_add')) {
    add_action('add_meta_boxes', 'trx_utils_meta_box_add');
    function trx_utils_meta_box_add() {
        // Custom theme-specific meta-boxes
        $boxes = apply_filters('trx_utils_filter_override_options', array());
        if (is_array($boxes)) {
            foreach ($boxes as $box) {
                $box = array_merge(array('id' => '',
                    'title' => '',
                    'callback' => '',
                    'page' => null,        // screen
                    'context' => 'advanced',
                    'priority' => 'default',
                    'callbacks' => null
                ),
                    $box);
                add_meta_box($box['id'], $box['title'], $box['callback'], $box['page'], $box['context'], $box['priority'], $box['callbacks']);
            }
        }
    }
}

// Return text for the Privacy Policy checkbox
if (!function_exists('trx_utils_get_privacy_text')) {
    function trx_utils_get_privacy_text() {
        $page = get_option('wp_page_for_privacy_policy');
        return apply_filters( 'trx_utils_filter_privacy_text', wp_kses_post(
                __( 'I agree that my submitted data is being collected and stored.', 'ancora-utils' )
                . ( '' != $page
                    // Translators: Add url to the Privacy Policy page
                    ? ' ' . sprintf(__('For further details on handling user data, see our %s', 'ancora-utils'),
                        '<a href="' . esc_url(get_permalink($page)) . '" target="_blank">'
                        . __('Privacy Policy', 'ancora-utils')
                        . '</a>')
                    : ''
                )
            )
        );
    }
}

// Register theme required types and taxes
if (!function_exists('ancora_require_data')) {
    function ancora_require_data( $type, $name, $args) {
        $fn = join('_', array('register', $type));
        if ($type == 'taxonomy')
            @$fn($name, $args['post_type'], $args);
        else
            @$fn($name, $args);
    }
}

/* LESS compilers
------------------------------------------------------ */

// Compile less-files
if (!function_exists('trx_utils_less_compiler')) {	
	function trx_utils_less_compiler($list, $opt) {

		$success = true;

		// Load and create LESS Parser
		if ($opt['compiler'] == 'lessc') {
			// 1: Compiler Lessc
			require_once( plugin_dir_path( __FILE__ ) . 'lib/lessc/lessc.inc.php' );
		} else {
			// 2: Compiler Less
			require_once( plugin_dir_path( __FILE__ ) . 'lib/less/Less.php' );
		}

		foreach($list as $file) {
			if (empty($file) || !file_exists($file)) continue;
			$file_css = substr_replace($file , 'css', strrpos($file , '.') + 1);
				
			// Check if time of .css file after .less - skip current .less
			if (!empty($opt['check_time']) && file_exists($file_css)) {
				$css_time = filemtime($file_css);
				if ($css_time >= filemtime($file) && ($opt['utils_time']==0 || $css_time > $opt['utils_time'])) continue;
			}
				
			// Compile current .less file
			try {
				// Create Parser
				if ($opt['compiler'] == 'lessc') {
					$parser = new lessc;
					if (!empty($opt['import'])) $parser->setImportDir($opt['import']);
					//$parser->registerFunction("replace", "trx_utils_less_func_replace");
					if ($opt['compressed']) $parser->setFormatter("compressed");
				} else {
					if ($opt['compressed'])
						$args = array('compress' => true);
					else {
						$args = array('compress' => false);
						if ($opt['map'] != 'no') {
							$args['sourceMap'] = true;
							if ($opt['map'] == 'external') {
								$args['sourceMapWriteTo'] = $file.'.map';
								$args['sourceMapURL'] = str_replace(
									array(get_template_directory(), get_stylesheet_directory()),
									array(get_template_directory_uri(), get_stylesheet_directory_uri()),
									$file) . '.map';
							}
						}
					}
					$parser = new Less_Parser($args);
				}

				// Parse main file
				$css = '';

				if ($opt['map'] != 'no' || !empty($opt['parse_files'])) {
					
					if ($opt['map'] != 'no' || $opt['compiler'] == 'less') {
						// Parse main file
						$parser->parseFile( $file, '');
						// Parse less utils
						if (is_array($opt['utils']) && count($opt['utils']) > 0) {
							foreach($opt['utils'] as $utility) {
								$parser->parseFile( $utility, '');
							}
						}
						// Parse less vars (from Theme Options)
						if (!empty($opt['vars'])) {
							$parser->parse($opt['vars']);
						}
						// Get compiled CSS code
						$css = $parser->getCss();
						// Reset LESS engine
						$parser->Reset();
					} else {
						$css = $parser->compileFile($file);
					}

				} else if (($text = file_get_contents($file))!='') {
					$parts = $opt['separator'] != '' ? explode($opt['separator'], $text) : array($text);
					for ($i=0; $i<count($parts); $i++) {
						$text = $parts[$i]
							. (!empty($opt['utils']) ? $opt['utils'] : '')			// Add less utils
							. (!empty($opt['vars']) ? $opt['vars'] : '');			// Add less vars (from Theme Options)
						// Get compiled CSS code
						if ($opt['compiler']=='lessc')
							$css .= $parser->compile($text);
						else {
							$parser->parse($text);
							$css .= $parser->getCss();
							$parser->Reset();
						}
					}
					if ($css && $opt['compiler']=='lessc' && $opt['compressed']) {
						$css = trx_utils_minify_css($css);
					}
				}
				if ($css) {
					if ($opt['map']=='no') {
						// If it main theme style - append CSS after header comments
						if ($file == get_template_directory(). '/style.less') {
							// Append to the main Theme Style CSS
							$theme_css = file_get_contents( get_template_directory() . '/style.css' );
							$css = substr($theme_css, 0, strpos($theme_css, '*/')+2) . "\n\n" . $css;
						} else {
							$css =	"/*"
									. "\n"
									. __('Attention! Do not modify this .css-file!', 'ancora-utils') 
									. "\n"
									. __('Please, make all necessary changes in the corresponding .less-file!', 'ancora-utils')
									. "\n"
									. "*/"
									. "\n"
									. '@charset "utf-8";'
									. "\n\n"
									. $css;
						}
					}
					// Save compiled CSS
					file_put_contents( $file_css, $css);
				}
			} catch (Exception $e) {
				if (function_exists('dfl')) dfl($e->getMessage());
				$success = false;
			}
		}
		return $success;
	}
}

// Prepare required styles and scripts for admin mode
if ( ! function_exists( 'trx_utils_admin_prepare_scripts' ) ) {
    add_action( 'admin_head', 'trx_utils_admin_prepare_scripts' );
    function trx_utils_admin_prepare_scripts() {
        ?>
        <script>
            if ( typeof TRX_UTILS_GLOBALS == 'undefined' ) var TRX_UTILS_GLOBALS = {};
            jQuery(document).ready(function() {
                TRX_UTILS_GLOBALS['admin_mode'] = true;
            });
        </script>
        <?php
    }
}

// File functions
if ( file_exists( TRX_UTILS_PLUGIN_DIR . 'includes/plugin.files.php' ) ) {
    require_once TRX_UTILS_PLUGIN_DIR . 'includes/plugin.files.php';
}

// Third-party plugins support
if ( file_exists( TRX_UTILS_PLUGIN_DIR . 'api/api.php' ) ) {
    require_once TRX_UTILS_PLUGIN_DIR . 'api/api.php';
}


// Demo data import/export
if ( file_exists( TRX_UTILS_PLUGIN_DIR . 'importer/importer.php' ) ) {
    require_once TRX_UTILS_PLUGIN_DIR . 'importer/importer.php';
}

// Add scroll to top button
if (!function_exists('ancora_footer_add_scroll_to_top')) {
    add_action('wp_footer', 'ancora_footer_add_scroll_to_top', 1);
    function ancora_footer_add_scroll_to_top() {
        ?><a href="#" class="scroll_to_top icon-up-2" title="<?php _e('Scroll to top', 'ancora-utils'); ?>"></a>
        <?php
    }
}


if(!function_exists('trx_utils_filter_options')){
    add_filter('ancora_filter_options', 'trx_utils_filter_options');
    function trx_utils_filter_options($options){
        global $ANCORA_GLOBALS;
        $custom_options = array(

            'info_custom_2' => array(
                "title" => __('Additional CSS and HTML/JS code', 'ancora-utils'),
                "desc" => __('Put here your custom CSS and JS code', 'ancora-utils'),
                "override" => "category,courses_group,page,post",
                "type" => "info"
            ),

            'custom_css' => array(
                "title" => __('Your CSS code',  'ancora-utils'),
                "desc" => __('Put here your css code to correct main theme styles',  'ancora-utils'),
                "override" => "category,courses_group,post,page",
                "divider" => false,
                "cols" => 80,
                "rows" => 20,
                "std" => "",
                "type" => "textarea"
            ),

            'custom_code' => array(
                "title" => __('Your HTML/JS code',  'ancora-utils'),
                "desc" => __('Put here your invisible html/js code: Google analitics, counters, etc',  'ancora-utils'),
                "override" => "category,courses_group,post,page",
                "cols" => 80,
                "rows" => 20,
                "std" => "",
                "type" => "textarea"
            ),

        );

        trx_utils_array_insert_after($options, 'privacy_text', $custom_options);

        return $options;
    }
}


//Return Post Views Count
if (!function_exists('trx_utils_get_post_views')) {
    add_filter('trx_utils_filter_get_post_views', 'trx_utils_get_post_views', 10, 2);
    function trx_utils_get_post_views($default=0, $id=0){
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, '0');
            $count = 0;
        }
        return $count;
    }
}

//Set Post Views Count
if (!function_exists('trx_utils_set_post_views')) {
    add_action('trx_utils_filter_set_post_views', 'trx_utils_set_post_views', 10, 2);
    function trx_utils_set_post_views($id=0, $counter=-1) {
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = 'post_views_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, 1);
        } else {
            $count = $counter >= 0 ? $counter : $count+1;
            update_post_meta($id, $count_key, $count);
        }
    }
}

//Return Post Likes Count
if (!function_exists('trx_utils_get_post_likes')) {
    add_filter('trx_utils_filter_get_post_likes', 'trx_utils_get_post_likes', 10, 2);
    function trx_utils_get_post_likes($default=0, $id=0){
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = 'post_likes_count';
        $count = get_post_meta($id, $count_key, true);
        if ($count===''){
            delete_post_meta($id, $count_key);
            add_post_meta($id, $count_key, '0');
            $count = 0;
        }
        return $count;
    }
}

//Set Post Likes Count
if (!function_exists('trx_utils_set_post_likes')) {
    add_action('trx_utils_filter_set_post_likes', 'trx_utils_set_post_likes', 10, 2);
    function trx_utils_set_post_likes($id=0, $counter=-1) {
        global $wp_query;
        if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
        $count_key = 'post_likes_count';
        update_post_meta($id, $count_key, $counter);
    }
}

// AJAX: Set post likes/views count


if ( !function_exists( 'trx_utils_callback_post_counter' ) ) {
    // AJAX: Set post likes/views count
    add_action('wp_ajax_post_counter', 					'trx_utils_callback_post_counter');
    add_action('wp_ajax_nopriv_post_counter', 			'trx_utils_callback_post_counter');
    function trx_utils_callback_post_counter() {
        global $_REQUEST;
        if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
            wp_die();

        $response = array('error'=>'');

        $id = (int) $_REQUEST['post_id'];
        if (isset($_REQUEST['likes'])) {
            $counter = max(0, (int) $_REQUEST['likes']);
            trx_utils_set_post_likes($id, $counter);
        } else if (isset($_REQUEST['views'])) {
            $counter = max(0, (int) $_REQUEST['views']);
            trx_utils_set_post_views($id, $counter);
        }
        echo json_encode($response);
        wp_die();
    }
}



?>