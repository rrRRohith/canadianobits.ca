<?php
/**
 * Plugin support: Revolution Slider
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Check if RevSlider installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_utils_exists_revslider' ) ) {
	function trx_utils_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
*/

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'trx_utils_get_list_revsliders' ) ) {
	function trx_utils_get_list_revsliders($prepend_inherit=false) {
		static $list = false;
		if ($list === false) {
			$list = array();
			if (trx_utils_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
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
if ( !function_exists( 'trx_utils_revslider_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_revslider_importer_required_plugins', 10, 2 );
	function trx_utils_revslider_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'revslider')!==false && !trx_utils_exists_revslider() )
			$not_installed .= '<br>' . esc_html__('Revolution Slider', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_revslider_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_revslider_importer_set_options', 10, 2 );
	function trx_utils_revslider_importer_set_options($options=array()) {
		if (trx_utils_exists_revslider() && in_array('revslider', $options['required_plugins'])) {
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_revslider'] = str_replace('name.ext', 'revslider.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_revslider_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_revslider_importer_show_params', 10, 1 );
	function trx_utils_revslider_importer_show_params($importer) {
		if (trx_utils_exists_revslider() && in_array('revslider', $importer->options['required_plugins'])) {
			$importer->show_importer_params(array(
				'slug' => 'revslider',
				'title' => esc_html__('Import Revolution Sliders', 'ancora-utils'),
				'part' => 1
			));
		}
	}
}

// Clear tables
if ( !function_exists( 'trx_utils_revslider_importer_clear_tables' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_clear_tables',	'trx_utils_revslider_importer_clear_tables', 10, 2 );
	function trx_utils_revslider_importer_clear_tables($importer, $clear_tables) {
		if (trx_utils_exists_revslider() && in_array('revslider', $importer->options['required_plugins'])) {
			if (strpos($clear_tables, 'revslider')!==false) {
				if ($importer->options['debug']) dfl(__('Clear Revolution Slider tables', 'ancora-utils'));
				global $wpdb;
				$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_sliders");
				if ( is_wp_error( $res ) ) dfl( __( 'Failed truncate table "revslider_sliders".', 'ancora-utils' ) . ' ' . ($res->get_error_message()) );
				$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_slides");
				if ( is_wp_error( $res ) ) dfl( __( 'Failed truncate table "revslider_slides".', 'ancora-utils' ) . ' ' . ($res->get_error_message()) );
				$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_static_slides");
				if ( is_wp_error( $res ) ) dfl( __( 'Failed truncate table "revslider_static_slides".', 'ancora-utils' ) . ' ' . ($res->get_error_message()) );
			}
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_revslider_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_revslider_importer_import', 10, 2 );
	function trx_utils_revslider_importer_import($importer, $action) {
		if (trx_utils_exists_revslider() && in_array('revslider', $importer->options['required_plugins'])) {
			if ( $action == 'import_revslider' && !empty($importer->options['files'][$importer->options['demo_type']]['file_with_revslider']) ) {
				if (file_exists(WP_PLUGIN_DIR . '/revslider/revslider.php')) {
					require_once WP_PLUGIN_DIR . '/revslider/revslider.php';
					if ($importer->options['debug']) dfl( __('Import Revolution sliders', 'ancora-utils') );
					// Get last processed slider
					$last_arh = $importer->response['start_from_id'] = isset($_POST['start_from_id']) ? $_POST['start_from_id'] : '';
					// Get list of the sliders
					if ( ($txt = get_option('trx_utils_importer_revsliders')) == '' ) {
						if ( ($txt = $importer->get_file($importer->options['files'][$importer->options['demo_type']]['file_with_revslider'])) === false)
							return;
						else
							update_option('trx_utils_importer_revsliders', $txt);
					}
					$files = trx_utils_unserialize($txt);
					if (!is_array($files)) $files = explode("\n", str_replace("\r\n", "\n", $files));
					// Remove empty lines
					foreach ($files as $k=>$file) {
						if (trim($file)=='') unset($files[$k]);
					}
					// Process next slider
					$slider = new RevSlider();
					// Process files
					$counter = 0;
					$result = 0;
					if (!is_array($_FILES)) $_FILES = array();
					foreach ($files as $file) {
						$counter++;
						if ( ($file = trim($file)) == '' )
							continue;
						if (!empty($last_arh)) {
							if ($file==$last_arh) 
								$last_arh = '';
							continue;
						}
						$need_del = false;
						// Load single file into system temp folder
						if ( ($zip = $importer->download_file($file, round(max(0, $counter-1) / count($files) * 100))) != '') {
							$need_del = substr($zip, 0, 5)=='http:' || substr($zip, 0, 6)=='https:';
							$_FILES["import_file"] = array("tmp_name" => $zip, 'error' => UPLOAD_ERR_OK);
							$response = $slider->importSliderFromPost();
							if ($need_del && file_exists($_FILES["import_file"]["tmp_name"]))
								unlink($_FILES["import_file"]["tmp_name"]);
							if ($response["success"] == false) {
								$msg = sprintf(esc_html__('Revolution Slider "%s" import error.', 'ancora-utils'), $file);
								unset($importer->response['attempt']);
								$importer->response['error'] = $msg;
								if ($importer->options['debug'])  {
									dfl( $msg );
									dfo( $response );
								}
							} else {
								$importer->response['start_from_id'] = $file;
								$importer->response['result'] = min(100, round($counter / count($files) * 100));
								if ($importer->options['debug']) 
									dfl( sprintf(__('Slider "%s" imported', 'ancora-utils'), basename($file)) );
							}
						}
						break;
					}
					if ($counter == count($files)) {
						update_option('trx_utils_importer_revsliders', '');
					}
				} else {
					if ($importer->options['debug']) 
						dfl( sprintf(__('Can not locate plugin Revolution Slider: %s', 'ancora-utils'), WP_PLUGIN_DIR.'/revslider/revslider.php') );
				}
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_revslider_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_revslider_importer_import_fields', 10, 1 );
	function trx_utils_revslider_importer_import_fields($importer) {
		if (trx_utils_exists_revslider() && in_array('revslider', $importer->options['required_plugins'])) {
			$importer->show_importer_fields(array(
				'slug'=>'revslider', 
				'title' => esc_html__('Revolution Slider', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_revslider_importer_export' ) ) {
	add_action( 'trx_utils_action_importer_export',	'trx_utils_revslider_importer_export', 10, 1 );
	function trx_utils_revslider_importer_export($importer) {
		$list = array_keys(trx_utils_get_list_revsliders());
		$output = '';
		foreach ($list as $alias)
			$output .= ($output ? "\n" : '') . sprintf("revslider/%s.zip", $alias);
		trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/revslider.txt'), $output);
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_revslider_importer_export_fields' ) ) {
	//add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_revslider_importer_export_fields', 10, 1 );
	function trx_utils_revslider_importer_export_fields($importer) {
		$importer->show_exporter_fields(array(
			'slug' => 'revslider',
			'title' => esc_html__('Revolution Sliders', 'ancora-utils')
			));
	}
}
?>