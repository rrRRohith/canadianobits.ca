<?php
/**
 * Plugin support: Elegro Crypto Payment (Add Crypto payments to WooCommerce)
 *
 * @package ThemeREX Addons
 * @since v1.70.3
 */

// Don't load directly
if ( ! defined( 'TRX_UTILS_VERSION' ) ) {
    die( '-1' );
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_utils_exists_elegro_payment' ) ) {
    function trx_utils_exists_elegro_payment() {
        return class_exists( 'WC_Elegro_Payment' );
    }
}

// Add our ref to the link
if ( !function_exists( 'trx_utils_elegro_payment_add_ref' ) ) {
    add_filter( 'woocommerce_settings_api_form_fields_elegro', 'trx_utils_elegro_payment_add_ref' );
    function trx_utils_elegro_payment_add_ref( $fields ) {
        if ( ! empty( $fields['listen_url']['description'] ) ) {
            $fields['listen_url']['description'] = preg_replace( '/href="([^"]+)"/', 'href="$1?ref=246218d7-a23d-444d-83c5-a884ecfa4ebd"', $fields['listen_url']['description'] );
        }
        return $fields;
    }
}

// Remove API keys from dummy data
if ( !function_exists( 'trx_utils_elegro_payment_filter_export_options' ) ) {
    add_filter( 'trx_utils_filter_export_options', 'trx_utils_elegro_payment_filter_export_options' );
    function trx_utils_elegro_payment_filter_export_options( $options ) {
        if ( isset( $options['woocommerce_elegro_settings'] ) ) {
            unset( $options['woocommerce_elegro_settings'] );
        }
        return $options;
    }
}
