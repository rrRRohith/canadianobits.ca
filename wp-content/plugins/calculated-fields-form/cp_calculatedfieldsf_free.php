<?php
/*
Plugin Name: Calculated Fields Form
Plugin URI: https://cff.dwbooster.com
Description: Create forms with field values calculated based in other form field values.
Version: 1.1.128
Text Domain: calculated-fields-form
Author: CodePeople
Author URI: https://cff.dwbooster.com
License: GPL
*/

if ( ! defined( 'WP_DEBUG' ) || true != WP_DEBUG ) {
	error_reporting( E_ERROR | E_PARSE );
}

// Defining main constants
define( 'CP_CALCULATEDFIELDSF_VERSION', '1.1.128' );
define( 'CP_CALCULATEDFIELDSF_MAIN_FILE_PATH', __FILE__ );
define( 'CP_CALCULATEDFIELDSF_BASE_PATH', dirname( CP_CALCULATEDFIELDSF_MAIN_FILE_PATH ) );
define( 'CP_CALCULATEDFIELDSF_BASE_NAME', plugin_basename( CP_CALCULATEDFIELDSF_MAIN_FILE_PATH ) );

// Feedback system
require_once 'feedback/cp-feedback.php';
new CP_FEEDBACK( 'calculated-fields-form', __FILE__, 'https://cff.dwbooster.com/contact-us' );

require_once 'inc/cpcff_auxiliary.inc.php';
require_once 'config/cpcff_config.cfg.php';

require_once 'inc/cpcff_banner.inc.php';
require_once 'inc/cpcff_main.inc.php';

require_once 'inc/cpcff_trial.php';

// Global variables
CPCFF_MAIN::instance(); // Main plugin's object

add_action( 'init', 'cp_calculated_fields_form_check_posted_data', 11 );
add_action( 'init', 'cp_calculated_fields_form_direct_form_access', 1 );

// functions
// ------------------------------------------
function cp_calculated_fields_form_direct_form_access() {
	if (
		get_option( 'CP_CALCULATEDFIELDSF_DIRECT_FORM_ACCESS', CP_CALCULATEDFIELDSF_DIRECT_FORM_ACCESS ) &&
		! empty( $_GET['cff-form'] ) &&
		@intval( $_GET['cff-form'] )
	) {
		$cpcff_main = CPCFF_MAIN::instance();
		$cpcff_main->form_preview(
			array(
				'shortcode_atts' => array( 'id' => @intval( $_GET['cff-form'] ) ),
				'page_title'     => 'CFF',
				'page'           => true,
			)
		);
	}
} // End cp_calculated_fields_form_direct_form_access

function cp_calculated_fields_form_check_posted_data() {

	global $wpdb;

	$cpcff_main = CPCFF_MAIN::instance();

	if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cp_calculatedfieldsf_post_options'] ) && is_admin() && isset( $_POST['_cpcff_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_cpcff_nonce'] ) ), 'cff-form-settings' ) ) {

		cp_calculatedfieldsf_save_options();

		if (
			isset( $_POST['preview'] ) &&
			isset( $_POST['cp_calculatedfieldsf_id'] ) &&
			is_numeric( $_POST['cp_calculatedfieldsf_id'] )
		) {
			$cpcff_main->form_preview(
				array(
					'shortcode_atts' => array( 'id' => intval( $_POST['cp_calculatedfieldsf_id'] ) ),
					'page_title'     => __( 'Form Preview', 'calculated-fields-form' ),
					'wp_die'         => 1,
				)
			);
		}
		return;
	}
}

function cp_calculatedfieldsf_save_options() {
	check_admin_referer( 'cff-form-settings', '_cpcff_nonce' );
	global $wpdb;
	if ( ! defined( 'CP_CALCULATEDFIELDSF_ID' ) && isset( $_POST['cp_calculatedfieldsf_id'] ) ) {
		define( 'CP_CALCULATEDFIELDSF_ID', sanitize_text_field( wp_unslash( $_POST['cp_calculatedfieldsf_id'] ) ) );
	}

	$error_occur = false;
	if ( isset( $_POST['form_structure'] ) ) {

		$_cff_POST = $_POST;

		// Remove bom characters
		$_cff_POST['form_structure'] = CPCFF_AUXILIARY::clean_bom( $_cff_POST['form_structure'] ); // phpcs:ignore WordPress.Security.EscapeOutput

		$form_structure_obj = CPCFF_AUXILIARY::json_decode( $_cff_POST['form_structure'] );
		if ( ! empty( $form_structure_obj ) ) {
			$form_structure_obj = CPCFF_FORM::sanitize_structure( $form_structure_obj );

			global $cpcff_default_texts_array;
			$cpcff_text_array = '';

			$_cff_POST                   = CPCFF_AUXILIARY::stripcslashes_recursive( $_cff_POST );
			$_POST['form_structure'] = json_encode( $form_structure_obj );
			if ( isset( $_POST['cpcff_text_array'] ) ) {
				$_cff_POST['vs_all_texts'] = $_cff_POST['cpcff_text_array'];
			}

			$cpcff_main = CPCFF_MAIN::instance();
			$_cff_calculatedfieldsf_id = isset( $_cff_POST['cp_calculatedfieldsf_id'] ) && is_numeric( $_cff_POST['cp_calculatedfieldsf_id'] ) ? intval( $_cff_POST['cp_calculatedfieldsf_id'] ) : 0;
			if ( $cpcff_main->get_form( $_cff_calculatedfieldsf_id )->save_settings( $_cff_POST ) === false ) {
				global $cff_structure_error;
				$cff_structure_error = __( '<div class="error-text">The data cannot be stored in database because has occurred an error with the database structure. Please, go to the plugins section and Deactivate/Activate the plugin to be sure the structure of database has been checked, and corrected if needed. If the issue persist, please <a href="https://cff.dwbooster.com/contact-us">contact us</a></div>', 'calculated-fields-form' );
			}
		} else {
			$error_occur = true;
		}
	} else {
		$error_occur = true;
	}

	if ( $error_occur ) {
		global $cff_structure_error;
		$cff_structure_error = __( '<div class="error-text">The data cannot be stored in database because has occurred an error with the form structure. Please, try to save the data again. If have been copied and pasted data from external text editors, the data can contain invalid characters. If the issue persist, please <a href="https://cff.dwbooster.com/contact-us">contact us</a></div>', 'calculated-fields-form' );
	}
}
