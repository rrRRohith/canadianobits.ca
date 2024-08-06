<?php
/**
 * Plugin support: Tour Master
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.38
 */

if (!defined('TRX_UTILS_TOURMASTER_CPT_TOUR'))			define('TRX_UTILS_TOURMASTER_CPT_TOUR', 			'tour');
if (!defined('TRX_UTILS_TOURMASTER_CPT_TOUR_COUPON'))	define('TRX_UTILS_TOURMASTER_CPT_TOUR_COUPON',		'tour_coupon');
if (!defined('TRX_UTILS_TOURMASTER_CPT_TOUR_SERVICE'))	define('TRX_UTILS_TOURMASTER_CPT_TOUR_SERVICE',	'tour_service');
if (!defined('TRX_UTILS_TOURMASTER_TAX_TOUR_CATEGORY'))define('TRX_UTILS_TOURMASTER_TAX_TOUR_CATEGORY',	'tour_category');
if (!defined('TRX_UTILS_TOURMASTER_TAX_TOUR_TAG'))		define('TRX_UTILS_TOURMASTER_TAX_TOUR_TAG',		'tour_tag');

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_tourmaster' ) ) {
	function trx_utils_exists_tourmaster() {
		return defined( 'TOURMASTER_LOCAL' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_tourmaster_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_tourmaster_importer_required_plugins', 10, 2 );
	function trx_utils_tourmaster_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'tourmaster')!==false && !trx_utils_exists_tourmaster() )
			$not_installed .= '<br>' . esc_html__('Tour Master', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_tourmaster_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_tourmaster_importer_set_options' );
	function trx_utils_tourmaster_importer_set_options($options=array()) {
		if ( trx_utils_exists_tourmaster() && in_array('opal-hotel-room-booking', $options['required_plugins']) ) {
			$options['additional_options'][] = 'tourmaster_general';					// Add slugs to export options for this plugin
			$options['additional_options'][] = 'tourmaster_color';
			$options['additional_options'][] = 'tourmaster_plugin';
			// Do not export this option, because it contain secret keys
			//$options['additional_options'][] = 'tourmaster_payment';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_tourmaster'] = str_replace('name.ext', 'tourmaster.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_tourmaster_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_tourmaster_importer_show_params', 10, 1 );
	function trx_utils_tourmaster_importer_show_params($importer) {
		if ( trx_utils_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'tourmaster',
				'title' => esc_html__('Import Tour Master', 'ancora-utils'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_tourmaster_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_tourmaster_importer_import', 10, 2 );
	function trx_utils_tourmaster_importer_import($importer, $action) {
		if ( trx_utils_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			if ( $action == 'import_tourmaster' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('tourmaster', esc_html__('Tour Master data', 'ancora-utils'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_tourmaster_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_tourmaster_importer_check_row', 9, 4);
	function trx_utils_tourmaster_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'tourmaster')===false) return $flag;
		if ( trx_utils_exists_tourmaster() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_UTILS_TOURMASTER_CPT_TOUR, TRX_UTILS_TOURMASTER_CPT_TOUR_COUPON, TRX_UTILS_TOURMASTER_CPT_TOUR_SERVICE));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_tourmaster_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_tourmaster_importer_import_fields', 10, 1 );
	function trx_utils_tourmaster_importer_import_fields($importer) {
		if ( trx_utils_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'tourmaster', 
				'title' => esc_html__('Tour Master', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_tourmaster_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_tourmaster_importer_export', 10, 1 );
	function trx_utils_tourmaster_importer_export($importer) {
		if ( trx_utils_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/tourmaster.txt'), serialize( array(
				"tourmaster_order"	=> $importer->export_dump("tourmaster_order"),
				"tourmaster_review"	=> $importer->export_dump("tourmaster_review")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_tourmaster_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_tourmaster_importer_export_fields', 10, 1 );
	function trx_utils_tourmaster_importer_export_fields($importer) {
		if ( trx_utils_exists_tourmaster() && in_array('tourmaster', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'tourmaster',
				'title' => esc_html__('Tour Master', 'ancora-utils')
				)
			);
		}
	}
}
?>