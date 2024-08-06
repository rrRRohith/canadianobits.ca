<?php
/**
 * ANCORA Framework: shortcodes manipulations
 *
 * @package	ancora
 * @since	ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('ancora_sc_theme_setup')) {
	add_action( 'ancora_action_before_init_theme', 'ancora_sc_theme_setup' );
	function ancora_sc_theme_setup() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'ancora_sc_excerpt_shortcodes');

			// Prepare shortcodes in the content
			if (function_exists('ancora_sc_prepare_content')) ancora_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('ancora_shortcode_output', 'ancora_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_contact_form',			'ancora_sc_contact_form_send');
		add_action('wp_ajax_nopriv_send_contact_form',	'ancora_sc_contact_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',						'ancora_sc_selector_add_in_toolbar', 11);

	}
}


// Add shortcodes init scripts and styles
if ( !function_exists( 'ancora_sc_add_scripts' ) ) {
	//add_filter('ancora_shortcode_output', 'ancora_sc_add_scripts', 10, 4);
	function ancora_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		global $ANCORA_GLOBALS;

		if (empty($ANCORA_GLOBALS['shortcodes_scripts_added'])) {
			$ANCORA_GLOBALS['shortcodes_scripts_added'] = true;
			if (ancora_get_theme_option('debug_mode')=='yes' || ancora_get_theme_option('packed_scripts')=='no' || !file_exists(ancora_get_file_dir('css/__packed.js')))
				wp_enqueue_script( 'ancora-shortcodes-script', trx_utils_get_file_url('shortcodes/shortcodes.js'), array('jquery'), null, true );
		}

		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('ancora_sc_prepare_content')) {
	function ancora_sc_prepare_content() {
		if (function_exists('ancora_sc_clear_around')) {
			$filters = array(
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (ancora_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			foreach ($filters as $flt)
				add_filter(join('_', $flt), 'ancora_sc_clear_around', 1);
		}
		/*
		if (function_exists('ancora_sc_clear_around')) {
			$filters = array(
				array('ancora', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (ancora_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			foreach ($filters as $flt)
				add_filter(join('_', $flt), 'ancora_sc_clear_around');
		}
		*/
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('ancora_sc_excerpt_shortcodes')) {
	function ancora_sc_excerpt_shortcodes($content) {
		$content = do_shortcode($content);
		//$content = strip_shortcodes($content);
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('ancora_sc_clear_around')) {
	function ancora_sc_clear_around($content) {
		$content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// ANCORA shortcodes load scripts
if (!function_exists('ancora_sc_load_scripts')) {
	function ancora_sc_load_scripts() {
		wp_enqueue_script( 'ancora-shortcodes-script', trx_utils_get_file_url('shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		wp_enqueue_script( 'ancora-selection-script',  ancora_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
	}
}

// ANCORA shortcodes prepare scripts
if (!function_exists('ancora_sc_prepare_scripts')) {
	function ancora_sc_prepare_scripts() {
		global $ANCORA_GLOBALS;
		if (!isset($ANCORA_GLOBALS['shortcodes_prepared'])) {
			$ANCORA_GLOBALS['shortcodes_prepared'] = true;
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					ANCORA_GLOBALS['shortcodes'] = JSON.parse('<?php echo str_replace("'", "\\'", json_encode(ancora_array_prepare_to_json($ANCORA_GLOBALS['shortcodes']))); ?>');
					ANCORA_GLOBALS['shortcodes_cp'] = '<?php echo is_admin() ? 'wp' : 'internal'; ?>';
				});
			</script>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('ancora_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','ancora_sc_selector_add_in_toolbar', 11);
	function ancora_sc_selector_add_in_toolbar(){

		if ( !ancora_options_is_used() ) return;

		ancora_sc_load_scripts();
		ancora_sc_prepare_scripts();

		global $ANCORA_GLOBALS;

		$shortcodes = $ANCORA_GLOBALS['shortcodes'];
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.__('- Select Shortcode -', 'ancora-utils').'&nbsp;</option>';

		foreach ($shortcodes as $idx => $sc) {
			$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
		}

		$shortcodes_list .= '</select>';

		echo ($shortcodes_list);
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
if (!function_exists('ancora_sc_param_is_inherit')) {
	function ancora_sc_param_is_inherit($prm) {
		return in_array(ancora_strtolower($prm), array('inherit', 'default'));
	}
}

// Return classes list for the specified animation
if (!function_exists('ancora_sc_get_animation_classes')) {
	function ancora_sc_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return ancora_sc_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!ancora_sc_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}

// Decode html-entities in the shortcode parameters
if (!function_exists('ancora_sc_html_decode')) {
	function ancora_sc_html_decode($prm) {
		if (count($prm) > 0) {
			foreach ($prm as $k=>$v) {
				if (is_string($v))
					$prm[$k] = htmlspecialchars_decode($v, ENT_QUOTES);
			}
		}
		return $prm;
	}
}


require_once( trx_utils_get_file_dir('shortcodes/shortcodes_settings.php') );

if ( class_exists('WPBakeryShortCode')
		&& (
			is_admin()
			|| (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true' )
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline')
			)
	) {
	require_once( trx_utils_get_file_dir('shortcodes/shortcodes_vc_classes.php') );
	require_once( trx_utils_get_file_dir('shortcodes/shortcodes_vc.php') );
}

require_once( trx_utils_get_file_dir('shortcodes/shortcodes.php') );
?>