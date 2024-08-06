<?php
/**
 * Plugin support: ThemeREX Donations
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_trx_donations' ) ) {
	function trx_utils_exists_trx_donations() {
		return class_exists('TRX_DONATIONS');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_trx_donations_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_trx_donations_importer_required_plugins', 10, 2 );
	function trx_utils_trx_donations_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'trx_donations')!==false && !trx_utils_exists_trx_donations() )
			$not_installed .= '<br>' . esc_html__('trx_donations', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_trx_donations_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_trx_donations_importer_set_options' );
	function trx_utils_trx_donations_importer_set_options($options=array()) {
		if ( trx_utils_exists_trx_donations() && in_array('trx_donations', $options['required_plugins']) ) {
			$options['additional_options'][] = 'trx_donations_options';
		}
		return $options;
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_trx_donations_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_trx_donations_importer_check_row', 9, 4);
	function trx_utils_trx_donations_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'trx_donations')===false) return $flag;
		if ( trx_utils_exists_trx_donations() ) {
			if ($table == 'posts')
				$flag = $row['post_type']==TRX_DONATIONS::POST_TYPE;
		}
		return $flag;
	}
}

?>