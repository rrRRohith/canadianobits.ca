<?php
/**
 * Plugin support: WPML
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_utils_exists_wpml' ) ) {
	function trx_utils_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}
*/


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_wpml_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_wpml_importer_required_plugins', 10, 2 );
	function trx_utils_wpml_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'sitepress-multilingual-cms')!==false && !trx_utils_exists_wpml() )
			$not_installed .= '<br>' . esc_html__('WPML - Sitepress Multilingual CMS', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_wpml_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_wpml_importer_set_options' );
	function trx_utils_wpml_importer_set_options($options=array()) {
		if ( trx_utils_exists_wpml() && in_array('sitepress-multilingual-cms', $options['required_plugins']) ) {
			$options['additional_options'][] = 'icl_sitepress_settings';
		}
		return $options;
	}
}
?>