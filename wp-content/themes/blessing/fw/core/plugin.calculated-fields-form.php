<?php
/* Calculated fields form support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('ancora_calcfields_form_theme_setup')) {
    add_action( 'ancora_action_before_init_theme', 'ancora_calcfields_form_theme_setup', 1 );
    function ancora_calcfields_form_theme_setup() {
        if (is_admin()) {
            add_filter( 'ancora_filter_required_plugins', 'ancora_calcfields_form_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'ancora_calcfields_form_required_plugins' ) ) {
    function ancora_calcfields_form_required_plugins($list=array()) {
        if (in_array('calculated-fields-form', (array)ancora_get_global('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Calculated Fields Form', 'blessing'),
                'slug'         => 'calculated-fields-form',
                'required'     => false
            );
        return $list;
    }
}

// Check if plugin installed and activated
if ( !function_exists( 'ancora_exists_calcfields_form' ) ) {
	function ancora_exists_calcfields_form() {

        return defined( 'CP_CALCULATEDFIELDSF_VERSION' );
	}
}


?>