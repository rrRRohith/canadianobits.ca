<?php
/**
 * Plugin support: Booked Appointments
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Check if plugin is installed and activated
if ( !function_exists( 'trx_utils_exists_booking_calendar' ) ) {
	function trx_utils_exists_booking_calendar() {
		return function_exists( 'wp_booking_multisite_update' );
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_booking_calendar_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_booking_calendar_importer_required_plugins', 10, 2 );
	function trx_utils_booking_calendar_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'wp-booking-calendar')!==false && !trx_utils_exists_booking_calendar() )
			$not_installed .= '<br>' . esc_html__('Booking Calendar WP Plugin', 'ancora-utils');
		return $not_installed;
	}
}


// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_booking_calendar_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options', 'trx_utils_booking_calendar_importer_set_options', 10, 1 );
	function trx_utils_booking_calendar_importer_set_options($options=array()) {
		if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $options['required_plugins']) ) {
			$options['additional_options'][] = 'wbc_%';				// Add slugs to export options of this plugin
		}
        if (is_array($options['files']) && count($options['files']) > 0) {
            foreach ($options['files'] as $k => $v) {
                $options['files'][$k]['file_with_wp-booking-calendar'] = str_replace('name.ext', 'wp-booking-calendar.txt', $v['file_with_']);
            }
        }
		return $options;
	}
}


// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_booking_calendar_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_booking_calendar_importer_show_params', 10, 1 );
    function trx_utils_booking_calendar_importer_show_params($importer) {
        if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'wp-booking-calendar',
                'title' => esc_html__('Import Booking Calendar', 'ancora-utils'),
                'part' => '1',
            ));
        }
    }
}

// Display import progress
if ( !function_exists( 'trx_utils_booking_calendar_importer_import_fields' ) ) {
    if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_booking_calendar_importer_import_fields', 10, 1 );
    function trx_utils_booking_calendar_importer_import_fields($importer) {
        if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $importer->options['required_plugins']) ) {
            $importer->show_importer_fields(array(
                    'slug'=>'wp-booking-calendar',
                    'title' => esc_html__('Booking Calendar meta', 'ancora-utils')
                )
            );
        }
    }
}

// Import posts
if ( !function_exists( 'trx_utils_booking_calendar_importer_import' ) ) {
    if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_booking_calendar_importer_import', 10, 2 );
    function trx_utils_booking_calendar_importer_import($importer, $action) {
        if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $importer->options['required_plugins']) ) {
            if ( $action == 'import_wp-booking-calendar' ) {
                $importer->response['start_from_id'] = 0;
                $importer->import_dump('wp-booking-calendar', esc_html__('Booking Calendar', 'ancora-utils'));
            }
        }
    }
}

// Export posts
if ( !function_exists( 'trx_utils_booking_calendar_importer_export' ) ) {
    if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_booking_calendar_importer_export', 10, 1 );
    function trx_utils_booking_calendar_importer_export($importer) {
        if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $importer->options['required_plugins']) ) {
            trx_utils_fpc(TRX_UTILS_PLUGIN_DIR . 'importer/export/wp-booking-calendar.txt', serialize( array(
                    "booking_calendars"         => $importer->export_dump("booking_calendars"),
                    "booking_categories"        => $importer->export_dump("booking_categories"),
                    "booking_config"            => $importer->export_dump("booking_config"),
                    "booking_emails"            => $importer->export_dump("booking_emails"),
                    "booking_fields_types"      => $importer->export_dump("booking_fields_types"),
                    "booking_holidays"	        => $importer->export_dump("booking_holidays"),
                    "booking_pages"	            => $importer->export_dump("booking_pages"),
                    "booking_paypal_currency"   => $importer->export_dump("booking_paypal_currency"),
                    "booking_paypal_locale"     => $importer->export_dump("booking_paypal_locale"),
                    "booking_reservation"       => $importer->export_dump("booking_reservation"),
                    "booking_slots"	            => $importer->export_dump("booking_slots"),
                    "booking_slots_bundles"	    => $importer->export_dump("booking_slots_bundles"),
                    "booking_texts"             => $importer->export_dump("booking_texts"),
                    "booking_timezones"	        => $importer->export_dump("booking_timezones"),
                ) )
            );
        }
    }
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_booking_calendar_importer_export_fields' ) ) {
    if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_booking_calendar_importer_export_fields', 10, 1 );
    function trx_utils_booking_calendar_importer_export_fields($importer) {
        if ( trx_utils_exists_booking_calendar() && in_array('wp-booking-calendar', $importer->options['required_plugins']) ) {
            $importer->show_exporter_fields(array(
                    'slug'	=> 'wp-booking-calendar',
                    'title' => esc_html__('Booking Calendar', 'ancora-utils')
                )
            );
        }
    }
}
?>