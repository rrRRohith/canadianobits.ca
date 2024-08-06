<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'ancora_exists_visual_composer' ) ) {
	function ancora_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'ancora_vc_is_frontend' ) ) {
	function ancora_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
?>