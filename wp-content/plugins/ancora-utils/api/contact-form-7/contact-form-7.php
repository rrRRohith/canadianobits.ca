<?php
/**
 * Plugin support: Contact Form 7
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */


// Check if Contact Form 7 installed and activated
if ( !function_exists( 'trx_utils_exists_cf7' ) ) {
	function trx_utils_exists_cf7() {
		return class_exists('WPCF7') && class_exists('WPCF7_ContactForm');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_cf7_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_cf7_importer_required_plugins', 10, 2 );
	function trx_utils_cf7_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'contact-form-7')!==false && !trx_utils_exists_cf7() )
			$not_installed .= '<br>' . esc_html__('Contact Form 7', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_cf7_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_cf7_importer_set_options' );
	function trx_utils_cf7_importer_set_options($options=array()) {
		if ( trx_utils_exists_cf7() && in_array('contact-form-7', $options['required_plugins']) ) {
			$options['additional_options'][] = 'wpcf7';
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_cf7_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_cf7_importer_show_params', 10, 1 );
	function trx_utils_cf7_importer_show_params($importer) {
		if ( trx_utils_exists_cf7() && in_array('contact-form-7', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'contact-form-7',
				'title' => esc_html__('Import Contact Form 7', 'ancora-utils'),
				'part' => 1
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_cf7_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_cf7_importer_check_row', 9, 4);
	function trx_utils_cf7_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'contact-form-7')===false) return $flag;
		if ( trx_utils_exists_cf7() ) {
			if ($table == 'posts')
				$flag = $row['post_type']==WPCF7_ContactForm::post_type;
		}
		return $flag;
	}
}
?>