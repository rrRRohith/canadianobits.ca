<?php
/**
 * Plugin support: Mail Chimp
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_mailchimp' ) ) {
	function trx_utils_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_mailchimp_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_mailchimp_importer_required_plugins', 10, 2 );
	function trx_utils_mailchimp_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'mailchimp-for-wp')!==false && !trx_utils_exists_mailchimp() )
			$not_installed .= '<br>' . esc_html__('MailChimp for WP', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_mailchimp_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_mailchimp_importer_set_options' );
	function trx_utils_mailchimp_importer_set_options($options=array()) {
		if ( trx_utils_exists_mailchimp() && in_array('mailchimp-for-wp', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'mc4wp_default_form_id';		// Add slugs to export options for this plugin
				$options['additional_options'][] = 'mc4wp_form_stylesheets';
				$options['additional_options'][] = 'mc4wp_flash_messages';
				$options['additional_options'][] = 'mc4wp_integrations';
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_mailchimp_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_mailchimp_importer_show_params', 10, 1 );
	function trx_utils_mailchimp_importer_show_params($importer) {
		if ( trx_utils_exists_mailchimp() && in_array('mailchimp-for-wp', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'mailchimp-for-wp',
				'title' => esc_html__('Import MailChimp for WP', 'ancora-utils'),
				'part' => 1
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_mailchimp_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_mailchimp_importer_check_row', 9, 4);
	function trx_utils_mailchimp_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mailchimp-for-wp')===false) return $flag;
		if ( trx_utils_exists_mailchimp() ) {
			if ($table == 'posts')
				$flag = $row['post_type']=='mc4wp-form';
		}
		return $flag;
	}
}
?>