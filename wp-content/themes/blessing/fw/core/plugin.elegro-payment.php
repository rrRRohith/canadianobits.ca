<?php
/* elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('ancora_woocommerce_elegro_payment_theme_setup')) {
    add_action( 'ancora_action_before_init_theme', 'ancora_woocommerce_elegro_payment_theme_setup', 1 );
    function ancora_woocommerce_elegro_payment_theme_setup() {
        if (is_admin()) {
            add_filter( 'ancora_filter_required_plugins', 'ancora_woocommerce_elegro_payment_required_plugins' );
        }
    }
}



// Filter to add in the required plugins list
if ( !function_exists( 'ancora_woocommerce_elegro_payment_required_plugins' ) ) {
    function ancora_woocommerce_elegro_payment_required_plugins($list=array()) {
        if (in_array('elegro-payment', (array)ancora_get_global('required_plugins')))
            $list[] = array(
                'name' 		=> esc_html__('elegro Crypto Payment', 'blessing'),
                'slug' 		=> 'elegro-payment',
                'required' 	=> false
            );
        return $list;
    }
}



// Check if cf7 installed and activated
if ( !function_exists( 'ancora_exists_woocommerce_elegro_payment' ) ) {
    function ancora_exists_woocommerce_elegro_payment() {
        return function_exists('init_Elegro_Payment');
    }
}
