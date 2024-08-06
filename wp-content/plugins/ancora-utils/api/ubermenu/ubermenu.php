<?php
/**
 * Plugin support: Uber Menu
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_ubermenu' ) ) {
	function trx_utils_exists_ubermenu() {
		return class_exists('UberMenu');
	}
}
	


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_ubermenu_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_ubermenu_importer_required_plugins', 10, 2 );
	function trx_utils_ubermenu_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'ubermenu')!==false && !trx_utils_exists_ubermenu() )
			$not_installed .= '<br>' . esc_html__('UberMenu', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_ubermenu_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options', 'trx_utils_ubermenu_importer_set_options', 10, 1 );
	function trx_utils_ubermenu_importer_set_options($options=array()) {
		if ( trx_utils_exists_ubermenu() && in_array('ubermenu', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'ubermenu_%';				// Add slugs to export options of this plugin
		}
		return $options;
	}
}
?>