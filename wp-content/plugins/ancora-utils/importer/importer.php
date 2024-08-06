<?php
// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('trx_utils_importer_theme_setup')) {
	add_action( 'after_setup_theme', 'trx_utils_importer_theme_setup' );
	function trx_utils_importer_theme_setup() {
		if (is_admin() && current_user_can('import')) {
			if (($fdir = TRX_UTILS_PLUGIN_DIR . 'importer/class.importer.php') != '') { include_once $fdir; }
			new trx_utils_demo_data_importer();
		}
	}
}

if (!function_exists('trx_utils_importer_localize_script_admin')) {
	add_action( 'trx_utils_localize_script_admin', 'trx_utils_importer_localize_script_admin' );
	function trx_utils_importer_localize_script_admin($vars) {
		$vars['msg_importer_error'] = esc_html__('Errors that occurred during the import process:', 'ancora-utils');
		return $vars;
	}
}
?>