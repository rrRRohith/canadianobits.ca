<?php
/**
 * Plugin support: Easy Digital Downloads
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_edd_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_edd_importer_required_plugins', 10, 2 );
	function trx_utils_edd_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'easy-digital-downloads')!==false && !trx_utils_exists_edd() )
			$not_installed .= '<br>' . esc_html__('Easy Digital Downloads', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_edd_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_edd_importer_set_options' );
	function trx_utils_edd_importer_set_options($options=array()) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $options['required_plugins']) ) {
			$options['additional_options'][] = 'edd_settings';					// Add slugs to export options for this plugin
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_edd'] = str_replace('name.ext', 'easy-digital-downloads.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_edd_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_edd_importer_show_params', 10, 1 );
	function trx_utils_edd_importer_show_params($importer) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'edd',
				'title' => esc_html__('Import Easy Digital Downloads', 'ancora-utils'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_edd_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_edd_importer_import', 10, 2 );
	function trx_utils_edd_importer_import($importer, $action) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			if ( $action == 'import_edd' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('easy-digital-downloads', esc_html__('Easy Digital Downloads meta', 'ancora-utils'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_edd_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_edd_importer_check_row', 9, 4);
	function trx_utils_edd_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'easy-digital-downloads')===false) return $flag;
		if ( trx_utils_exists_edd() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('download', 'edd_log', 'edd_discount', 'edd_payment'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_edd_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_edd_importer_import_fields', 10, 1 );
	function trx_utils_edd_importer_import_fields($importer) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'edd', 
				'title' => esc_html__('Easy Digital Downloads meta', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_edd_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_edd_importer_export', 10, 1 );
	function trx_utils_edd_importer_export($importer) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/easy-digital-downloads.txt'), serialize( array(
				"edd_customers"		=> $importer->export_dump("edd_customers"),
				"edd_customermeta"	=> $importer->export_dump("edd_customermeta"),
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_edd_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_edd_importer_export_fields', 10, 1 );
	function trx_utils_edd_importer_export_fields($importer) {
		if ( trx_utils_exists_edd() && in_array('easy-digital-downloads', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'edd',
				'title' => esc_html__('Easy Digital Downloads', 'ancora-utils')
				)
			);
		}
	}
}
?>