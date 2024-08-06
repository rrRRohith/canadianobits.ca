<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('ancora_cf7_theme_setup')) {
    add_action( 'ancora_action_before_init_theme', 'ancora_cf7_theme_setup', 1 );
    function ancora_cf7_theme_setup() {
        if (is_admin()) {
            add_filter( 'ancora_filter_required_plugins', 'ancora_cf7_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'ancora_cf7_required_plugins' ) ) {
    function ancora_cf7_required_plugins($list=array()) {
        if (in_array('contact-form-7', (array)ancora_get_global('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Contact Form 7', 'blessing'),
                'slug'         => 'contact-form-7',
                'required'     => false
            );
        return $list;
    }
}


// Check if cf7 installed and activated
if ( !function_exists( 'ancora_exists_cf7' ) ) {
	function ancora_exists_cf7() {
		return class_exists('WPCF7');
	}
}
?>