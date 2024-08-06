<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('ancora_revslider_theme_setup')) {
    add_action( 'ancora_action_before_init_theme', 'ancora_revslider_theme_setup', 1 );
    function ancora_revslider_theme_setup() {
        if (ancora_exists_revslider()) {
            add_filter( 'ancora_filter_list_sliders',					'ancora_revslider_list_sliders' );
            add_filter( 'ancora_filter_shortcodes_params',			'ancora_revslider_shortcodes_params' );
            add_filter( 'ancora_filter_theme_options_params',			'ancora_revslider_theme_options_params' );
        }
    }
}

// Check if RevSlider installed and activated
if ( !function_exists( 'ancora_exists_revslider' ) ) {
    function ancora_exists_revslider() {
        return function_exists('rev_slider_shortcode');
    }
}


// Lists
//------------------------------------------------------------------------

// Add RevSlider in the sliders list, prepended inherit (if need)
if ( !function_exists( 'ancora_revslider_list_sliders' ) ) {
    
    function ancora_revslider_list_sliders($list=array()) {
        $list["revo"] = esc_html__("Layer slider (Revolution)", 'blessing');
        return $list;
    }
}

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'ancora_get_list_revo_sliders' ) ) {
    function ancora_get_list_revo_sliders($prepend_inherit=false) {
        global $ANCORA_GLOBALS;
        $ANCORA_GLOBALS['list_revo_sliders']='';
        if (($list = $ANCORA_GLOBALS['list_revo_sliders'])=='') {
            $list = array();
            if (ancora_exists_revslider()) {
                global $wpdb;
                $rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
                if (is_array($rows) && count($rows) > 0) {
                    foreach ($rows as $row) {
                        $list[$row->alias] = $row->title;
                    }
                }
            }
            $list = apply_filters('ancora_filter_list_revo_sliders', $list);
            if (ancora_get_theme_setting('use_list_cache')) $ANCORA_GLOBALS['list_revo_sliders'] = $list;
        }
        return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
    }
}

// Add RevSlider in the shortcodes params
if ( !function_exists( 'ancora_revslider_shortcodes_params' ) ) {
    
    function ancora_revslider_shortcodes_params($list=array()) {
        $list["revo_sliders"] = ancora_get_list_revo_sliders();
        return $list;
    }
}

// Add RevSlider in the Theme Options params
if ( !function_exists( 'ancora_revslider_theme_options_params' ) ) {
    
    function ancora_revslider_theme_options_params($list=array()) {
        $list["list_revo_sliders"] = array('$ancora_get_list_revo_sliders' => '');
        return $list;
    }
}
?>