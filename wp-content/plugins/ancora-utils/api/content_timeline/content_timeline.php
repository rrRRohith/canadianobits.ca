<?php
/**
 * Plugin support: Content Timeline
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_utils_exists_content_timeline' ) ) {
	function trx_utils_exists_content_timeline() {
		return class_exists( 'ContentTimelineAdmin' );
	}
}

// Return Content Timelines list, prepended inherit (if need)
if ( !function_exists( 'trx_utils_get_list_content_timelines' ) ) {
	function trx_utils_get_list_content_timelines($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_utils_exists_content_timeline()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT id, name FROM " . esc_sql($wpdb->prefix . 'ctimelines') );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->id] = $row->name;
					}
				}
			}
		}
		return $prepend_inherit ? array_merge(array('inherit' => esc_html__("Inherit", 'ancora-utils')), $list) : $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_content_timeline_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_content_timeline_importer_required_plugins', 10, 2 );
	function trx_utils_content_timeline_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'content_timeline')!==false && !trx_utils_exists_content_timeline() )
			$not_installed .= '<br>' . esc_html__('Content Timeline', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_content_timeline_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_content_timeline_importer_set_options' );
	function trx_utils_content_timeline_importer_set_options($options=array()) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $options['required_plugins']) ) {
			//$options['additional_options'][] = 'content_timeline_calendar_options';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_content_timeline'] = str_replace('name.ext', 'content_timeline.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_content_timeline_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_content_timeline_importer_show_params', 10, 1 );
	function trx_utils_content_timeline_importer_show_params($importer) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'content_timeline',
				'title' => esc_html__('Import Content Timeline', 'ancora-utils'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_content_timeline_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_content_timeline_importer_import', 10, 2 );
	function trx_utils_content_timeline_importer_import($importer, $action) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			if ( $action == 'import_content_timeline' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('content_timeline', esc_html__('Content Timeline', 'ancora-utils'));
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_content_timeline_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_content_timeline_importer_import_fields', 10, 1 );
	function trx_utils_content_timeline_importer_import_fields($importer) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'	=> 'content_timeline', 
				'title'	=> esc_html__('Content Timeline', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_content_timeline_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_content_timeline_importer_export', 10, 1 );
	function trx_utils_content_timeline_importer_export($importer) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/content_timeline.txt'), serialize( array(
				'ctimelines' => $importer->export_dump('ctimelines')
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_content_timeline_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_content_timeline_importer_export_fields', 10, 1 );
	function trx_utils_content_timeline_importer_export_fields($importer) {
		if ( trx_utils_exists_content_timeline() && in_array('content_timeline', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'content_timeline',
				'title' => esc_html__('Content Timeline', 'ancora-utils')
				)
			);
		}
	}
}

?>