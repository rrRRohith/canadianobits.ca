<?php
/**
 * Plugin support: WooCommerce
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php
/*
if ( !function_exists( 'trx_utils_exists_woocommerce' ) ) {
	function trx_utils_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}
*/


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_woocommerce_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_woocommerce_importer_required_plugins', 10, 2 );
	function trx_utils_woocommerce_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'woocommerce')!==false && !trx_utils_exists_woocommerce() )
			$not_installed .= '<br>' . esc_html__('WooCommerce', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_woocommerce_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_woocommerce_importer_set_options' );
	function trx_utils_woocommerce_importer_set_options($options=array()) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'shop_%';					// Add slugs to export options for this plugin
			$options['additional_options'][]	= 'woocommerce_%';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_woocommerce'] = str_replace('name.ext', 'woocommerce.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Setup WooC pages after import posts complete
if ( !function_exists( 'trx_utils_woocommerce_importer_after_import_posts' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_after_import_posts',	'trx_utils_woocommerce_importer_after_import_posts', 10, 1 );
	function trx_utils_woocommerce_importer_after_import_posts($importer) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$wooc_pages = array(						// Options slugs and pages titles for WooCommerce pages
				'woocommerce_shop_page_id' 				=> 'Shop',
				'woocommerce_cart_page_id' 				=> 'Cart',
				'woocommerce_checkout_page_id' 			=> 'Checkout',
				'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
				'woocommerce_thanks_page_id' 			=> 'Order Received',
				'woocommerce_myaccount_page_id' 		=> 'My Account',
				'woocommerce_edit_address_page_id'		=> 'Edit My Address',
				'woocommerce_view_order_page_id'		=> 'View Order',
				'woocommerce_change_password_page_id'	=> 'Change Password',
				'woocommerce_logout_page_id'			=> 'Logout',
				'woocommerce_lost_password_page_id'		=> 'Lost Password'
			);
			foreach ($wooc_pages as $woo_page_name => $woo_page_title) {
				$woopage = get_page_by_title( $woo_page_title );
				if (!empty($woopage->ID)) {
					update_option($woo_page_name, $woopage->ID);
				}
			}
			// We no longer need to install pages
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );
		}
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_woocommerce_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_woocommerce_importer_show_params', 10, 1 );
	function trx_utils_woocommerce_importer_show_params($importer) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'woocommerce',
				'title' => esc_html__('Import WooCommerce', 'ancora-utils'),
				'part' => 1
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_woocommerce_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_woocommerce_importer_import', 10, 2 );
	function trx_utils_woocommerce_importer_import($importer, $action) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			if ( $action == 'import_woocommerce' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('woocommerce', esc_html__('WooCommerce meta', 'ancora-utils'));
				delete_transient( 'wc_attribute_taxonomies' );
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_woocommerce_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_woocommerce_importer_check_row', 9, 4);
	function trx_utils_woocommerce_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'woocommerce')===false) return $flag;
		if ( trx_utils_exists_woocommerce() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('product', 'product_variation', 'shop_order', 'shop_order_refund', 'shop_coupon', 'shop_webhook'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_woocommerce_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_woocommerce_importer_import_fields', 10, 1 );
	function trx_utils_woocommerce_importer_import_fields($importer) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'woocommerce', 
				'title' => esc_html__('WooCommerce meta', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_woocommerce_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_woocommerce_importer_export', 10, 1 );
	function trx_utils_woocommerce_importer_export($importer) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
		    $stop =1;
			trx_utils_fpc(TRX_UTILS_PLUGIN_DIR . 'importer/export/woocommerce.txt', serialize( array(
				"woocommerce_attribute_taxonomies"				=> $importer->export_dump("woocommerce_attribute_taxonomies"),
				"woocommerce_downloadable_product_permissions"	=> $importer->export_dump("woocommerce_downloadable_product_permissions"),
				"woocommerce_order_itemmeta"					=> $importer->export_dump("woocommerce_order_itemmeta"),
				"woocommerce_order_items"						=> $importer->export_dump("woocommerce_order_items"),
				"woocommerce_termmeta"							=> $importer->export_dump("woocommerce_termmeta"),
                "wc_product_meta_lookup"                        => $importer->export_dump("wc_product_meta_lookup")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_woocommerce_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_woocommerce_importer_export_fields', 10, 1 );
	function trx_utils_woocommerce_importer_export_fields($importer) {
		if ( trx_utils_exists_woocommerce() && in_array('woocommerce', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'woocommerce',
				'title' => esc_html__('WooCommerce', 'ancora-utils')
				)
			);
		}
	}
}
?>