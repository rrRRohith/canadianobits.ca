<?php
/**
 * Plugin support: Booked Appointments
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_utils_exists_booked' ) ) {
	function trx_utils_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_booked_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_booked_importer_required_plugins', 10, 2 );
	function trx_utils_booked_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'booked')!==false && !trx_utils_exists_booked() )
			$not_installed .= '<br>' . esc_html__('Booked Appointments', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_booked_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options', 'trx_utils_booked_importer_set_options', 10, 1 );
	function trx_utils_booked_importer_set_options($options=array()) {
		if ( trx_utils_exists_booked() && in_array('booked', $options['required_plugins']) ) {
			$options['additional_options'][] = 'booked_%';				// Add slugs to export options of this plugin
		}
		return $options;
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_booked_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_booked_importer_check_row', 9, 4);
	function trx_utils_booked_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'booked')===false) return $flag;
		if ( trx_utils_exists_booked() ) {
			if ($table == 'posts')
				$flag = $row['post_type']=='booked_appointments';
		}
		return $flag;
	}
}

?>