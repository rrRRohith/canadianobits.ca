<?php
/**
 * Plugin support: SiteOrigin Panels
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0.30
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


// Check if plugin 'SiteOrigin Panels' is installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_utils_exists_sop' ) ) {
	function trx_utils_exists_sop() {
		return class_exists('SiteOrigin_Panels');
	}
}
*/

// Check if plugin 'SiteOrigin Widgets bundle' is installed and activated
if ( !function_exists( 'trx_utils_exists_sow' ) ) {
	function trx_utils_exists_sow() {
		return class_exists('SiteOrigin_Widgets_Bundle');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_sop_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_sop_importer_required_plugins', 10, 2 );
	function trx_utils_sop_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'siteorigin-panels')!==false && !trx_utils_exists_visual_composer())
			$not_installed .= '<br>' . esc_html__('SiteOrigin Panels', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_sop_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_sop_importer_set_options' );
	function trx_utils_sop_importer_set_options($options=array()) {
		if ( trx_utils_exists_sop() && in_array('siteorigin-panels', $options['required_plugins']) ) {
			$options['additional_options'][] = 'siteorigin_panels_settings';
			$options['additional_options'][] = 'siteorigin_widgets_active';
		}
		return $options;
	}
}

?>