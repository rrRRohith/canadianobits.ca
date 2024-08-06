<?php
/**
 * ThemeREX Addons Third-party plugins API
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Define list with api
if (!function_exists('trx_utils_api_load')) {
	add_action( 'after_setup_theme', 'trx_utils_api_load', 2 );
	add_action( 'trx_utils_action_save_options', 'trx_utils_api_load', 2 );
	function trx_utils_api_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_UTILS_STORAGE;
		$TRX_UTILS_STORAGE['api_list'] = apply_filters('trx_utils_api_list', array(
			
			'bbpress' => array(
							'title' => __('BB Press & Buddy Press', 'ancora-utils')
						),
			'booked' => array(
							'title' => __('Booked Appointments', 'ancora-utils')
						),
			'calculated-fields-form' => array(
							'title' => __('Calculated Fields Form', 'ancora-utils')
						),
			'contact-form-7' => array(
							'title' => __('Contact Form 7', 'ancora-utils')
						),
			'content_timeline' => array(
							'title' => __('Content Timeline', 'ancora-utils')
						),
			'easy-digital-downloads' => array(
							'title' => __('Easy Digital Downloads', 'ancora-utils')
						),
            'elegro-payment' => array(
                            'title' => __('Elegro Crypto Payment', 'trx_addons')
                        ),
			'essential-grid' => array(
							'title' => __('Essential Grid', 'ancora-utils')
						),
			'instagram-feed' => array(
							'title' => __('Instagram Feed', 'ancora-utils')
						),
			'mailchimp-for-wp' => array(
							'title' => __('MailChimp for WordPress', 'ancora-utils')
						),
			'mp-timetable' => array(
							'title' => __('MP TimeTable', 'ancora-utils')
						),
			'revslider' => array(
							'title' => __('Revolution Slider', 'ancora-utils')
						),
			'siteorigin-panels' => array(
							'title' => __('SiteOrigin Panels (free PageBuilder)', 'ancora-utils'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'the-events-calendar' => array(
							'title' => __('The Events Calendar', 'ancora-utils'),
							'layouts_sc' => array(
								'default'	=> esc_html__('Default', 'ancora-utils'),
								'detailed'	=> esc_html__('Detailed', 'ancora-utils')
							)
						),
			'tourmaster' => array(
							'title' => __('Tour Master', 'ancora-utils')
						),
			'trx_donations' => array(
							'title' => __('ThemeREX Donations', 'ancora-utils')
						),


			'ubermenu' => array(
							'title' => __('UberMenu', 'ancora-utils')
						),
			'js_composer' => array(
							'title' => __('Visual Composer', 'ancora-utils'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'vc-extensions-bundle' => array(
							'title' => __('VC Extensions Bundle', 'ancora-utils')
						),
			'woocommerce' => array(
							'title' => __('WooCommerce', 'ancora-utils')
						),
			'wp-booking-calendar' => array(
							'title' => __('WP Booking Calendar', 'ancora-utils')
						),
			'sitepress-multilingual-cms' => array(
							'title' => __('WPML - Sitepress Multilingual CMS', 'ancora-utils')
						),
			)
		);
		if (is_array($TRX_UTILS_STORAGE['api_list']) && count($TRX_UTILS_STORAGE['api_list']) > 0) {
			foreach ($TRX_UTILS_STORAGE['api_list'] as $w=>$params) {
				if (empty($params['preloaded'])
					&& ($fdir = (TRX_UTILS_PLUGIN_DIR . "api/{$w}/{$w}.php")) != '') {
					include_once $fdir;
				}
			}
		}
	}
}

//-----------------------------------------------------------------------------------
//-- CHECK FOR COMPONENTS EXISTS
//--  Attention! This functions are used in many files and must be declared here!!!
//-----------------------------------------------------------------------------------

// Check if plugin 'Visual Composer' is installed and activated
if ( !function_exists( 'trx_utils_exists_visual_composer' ) ) {
	function trx_utils_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if plugin 'SiteOrigin Panels' is installed and activated
if ( !function_exists( 'trx_utils_exists_sop' ) ) {
	function trx_utils_exists_sop() {
		return class_exists('SiteOrigin_Panels');
	}
}

// Check if any PageBuilder is installed and activated
if ( !function_exists( 'trx_utils_exists_page_builder' ) ) {
	function trx_utils_exists_page_builder() {
		return trx_utils_exists_visual_composer() || trx_utils_exists_sop();
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'trx_utils_exists_revslider' ) ) {
	function trx_utils_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_woocommerce' ) ) {
	function trx_utils_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_edd' ) ) {
	function trx_utils_exists_edd() {
		return class_exists('Easy_Digital_Downloads');
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_wpml' ) ) {
	function trx_utils_exists_wpml() {
		return defined('ICL_SITEPRESS_VERSION') && class_exists('sitepress');
	}
}
?>