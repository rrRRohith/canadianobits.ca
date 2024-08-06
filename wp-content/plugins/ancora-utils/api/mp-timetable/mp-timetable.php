<?php
/**
 * Plugin support: MP Timetable
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */


if (!defined('TRX_UTILS_MPTT_PT_EVENT')) define('TRX_UTILS_MPTT_PT_EVENT', 'mp-event');
if (!defined('TRX_UTILS_MPTT_PT_COLUMN')) define('TRX_UTILS_MPTT_PT_COLUMN', 'mp-column');
if (!defined('TRX_UTILS_MPTT_TAXONOMY_CATEGORY')) define('TRX_UTILS_MPTT_TAXONOMY_CATEGORY', 'mp-event_category');


// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_mptt' ) ) {
	function trx_utils_exists_mptt() {
		return class_exists('Mp_Time_Table');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_mptt_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_mptt_importer_required_plugins', 10, 2 );
	function trx_utils_mptt_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'mp-timetable')!==false && !trx_utils_exists_mptt() )
			$not_installed .= '<br>' . esc_html__('MP TimeTable', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_mptt_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_mptt_importer_set_options' );
	function trx_utils_mptt_importer_set_options($options=array()) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $options['required_plugins']) ) {
			//$options['additional_options'][]	= 'mptt_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_mp-timetable'] = str_replace('name.ext', 'mp-timetable.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_mptt_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_mptt_importer_show_params', 10, 1 );
	function trx_utils_mptt_importer_show_params($importer) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'mp-timetable',
				'title' => esc_html__('Import MP TimeTable', 'ancora-utils'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_mptt_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_mptt_importer_import', 10, 2 );
	function trx_utils_mptt_importer_import($importer, $action) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			if ( $action == 'import_mp-timetable' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('mp-timetable', esc_html__('MP TimeTable data', 'ancora-utils'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_mptt_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_mptt_importer_check_row', 9, 4);
	function trx_utils_mptt_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mp-timetable')===false) return $flag;
		if ( trx_utils_exists_mptt() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array(TRX_UTILS_MPTT_PT_EVENT, TRX_UTILS_MPTT_PT_COLUMN));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_mptt_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_mptt_importer_import_fields', 10, 1 );
	function trx_utils_mptt_importer_import_fields($importer) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'mp-timetable', 
				'title' => esc_html__('MP TimeTable data', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_mptt_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_mptt_importer_export', 10, 1 );
	function trx_utils_mptt_importer_export($importer) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/mp-timetable.txt'), serialize( array(
				"mp_timetable_data"	=> $importer->export_dump("mp_timetable_data")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_mptt_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_mptt_importer_export_fields', 10, 1 );
	function trx_utils_mptt_importer_export_fields($importer) {
		if ( trx_utils_exists_mptt() && in_array('mp-timetable', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'mp-timetable',
				'title' => esc_html__('MP TimeTable', 'ancora-utils')
				)
			);
		}
	}
}

?>