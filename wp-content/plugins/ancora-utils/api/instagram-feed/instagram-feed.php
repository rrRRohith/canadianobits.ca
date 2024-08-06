<?php
/**
 * Plugin support: Instagram Feed
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */


// Check if Instagram Feed installed and activated
if ( !function_exists( 'trx_utils_exists_instagram_feed' ) ) {
	function trx_utils_exists_instagram_feed() {
		return defined('SBIVER');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_instagram_feed_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_instagram_feed_importer_required_plugins', 10, 2 );
	function trx_utils_instagram_feed_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'instagram-feed')!==false && !trx_utils_exists_instagram_feed() )
			$not_installed .= '<br>' . esc_html__('Instagram Feed', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_instagram_feed_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_instagram_feed_importer_set_options' );
	function trx_utils_instagram_feed_importer_set_options($options=array()) {
		if (trx_utils_exists_instagram_feed() && in_array('instagram-feed', $options['required_plugins'])) {
			if (is_array($options)) {
				$options['additional_options'][] = 'sb_instagram_settings';		// Add slugs to export options for this plugin
			}
		}
		return $options;
	}
}
?>