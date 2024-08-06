<?php
/**
 * ANCORA Framework: messages subsystem
 *
 * @package	ancora
 * @since	ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('ancora_messages_theme_setup')) {
	add_action( 'ancora_action_before_init_theme', 'ancora_messages_theme_setup' );
	function ancora_messages_theme_setup() {
		// Core messages strings
		add_filter('ancora_action_add_scripts_inline', 'ancora_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('ancora_get_error_msg')) {
	function ancora_get_error_msg() {
		global $ANCORA_GLOBALS;
		return !empty($ANCORA_GLOBALS['error_msg']) ? $ANCORA_GLOBALS['error_msg'] : '';
	}
}

if (!function_exists('ancora_set_error_msg')) {
	function ancora_set_error_msg($msg) {
		global $ANCORA_GLOBALS;
		$msg2 = ancora_get_error_msg();
		$ANCORA_GLOBALS['error_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('ancora_get_success_msg')) {
	function ancora_get_success_msg() {
		global $ANCORA_GLOBALS;
		return !empty($ANCORA_GLOBALS['success_msg']) ? $ANCORA_GLOBALS['success_msg'] : '';
	}
}

if (!function_exists('ancora_set_success_msg')) {
	function ancora_set_success_msg($msg) {
		global $ANCORA_GLOBALS;
		$msg2 = ancora_get_success_msg();
		$ANCORA_GLOBALS['success_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('ancora_get_notice_msg')) {
	function ancora_get_notice_msg() {
		global $ANCORA_GLOBALS;
		return !empty($ANCORA_GLOBALS['notice_msg']) ? $ANCORA_GLOBALS['notice_msg'] : '';
	}
}

if (!function_exists('ancora_set_notice_msg')) {
	function ancora_set_notice_msg($msg) {
		global $ANCORA_GLOBALS;
		$msg2 = ancora_get_notice_msg();
		$ANCORA_GLOBALS['notice_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('ancora_set_system_message')) {
	function ancora_set_system_message($msg, $status='info', $hdr='') {
		update_option('ancora_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('ancora_get_system_message')) {
	function ancora_get_system_message($del=false) {
		$msg = get_option('ancora_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			ancora_del_system_message();
		return $msg;
	}
}

if (!function_exists('ancora_del_system_message')) {
	function ancora_del_system_message() {
		delete_option('ancora_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('ancora_messages_add_scripts_inline')) {
	function ancora_messages_add_scripts_inline($vars=array()) {
        // Strings for translation
        $vars["strings"] = array(
            'ajax_error' => esc_html__('Invalid server answer', 'blessing'),
            'bookmark_add' => esc_html__('Add the bookmark', 'blessing'),
            'bookmark_added' => esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'blessing'),
            'bookmark_del' => esc_html__('Delete this bookmark', 'blessing'),
            'bookmark_title' => esc_html__('Enter bookmark title', 'blessing'),
            'bookmark_exists' => esc_html__('Current page already exists in the bookmarks list', 'blessing'),
            'search_error' => esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'blessing'),
            'email_confirm' => esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'blessing'),
            'reviews_vote' => esc_html__('Thanks for your vote! New average rating is:', 'blessing'),
            'reviews_error' => esc_html__('Error saving your vote! Please, try again later.', 'blessing'),
            'error_like' => esc_html__('Error saving your like! Please, try again later.', 'blessing'),
            'error_global' => esc_html__('Global error text', 'blessing'),
            'name_empty' => esc_html__('The name can\'t be empty', 'blessing'),
            'name_long' => esc_html__('Too long name', 'blessing'),
            'email_empty' => esc_html__('Too short (or empty) email address', 'blessing'),
            'email_long' => esc_html__('Too long email address', 'blessing'),
            'email_not_valid' => esc_html__('Invalid email address', 'blessing'),
            'subject_empty' => esc_html__('The subject can\'t be empty', 'blessing'),
            'subject_long' => esc_html__('Too long subject', 'blessing'),
            'text_empty' => esc_html__('The message text can\'t be empty', 'blessing'),
            'text_long' => esc_html__('Too long message text', 'blessing'),
            'send_complete' => esc_html__("Send message complete!", 'blessing'),
            'send_error' => esc_html__('Transmit failed!', 'blessing'),
            'login_empty' => esc_html__('The Login field can\'t be empty', 'blessing'),
            'login_long' => esc_html__('Too long login field', 'blessing'),
            'login_success' => esc_html__('Login success! The page will be reloaded in 3 sec.', 'blessing'),
            'login_failed' => esc_html__('Login failed!', 'blessing'),
            'password_empty' => esc_html__('The password can\'t be empty and shorter then 4 characters', 'blessing'),
            'password_long' => esc_html__('Too long password', 'blessing'),
            'password_not_equal' => esc_html__('The passwords in both fields are not equal', 'blessing'),
            'registration_success' => esc_html__('Registration success! Please log in!', 'blessing'),
            'registration_failed' => esc_html__('Registration failed!', 'blessing'),
            'geocode_error' => esc_html__('Geocode was not successful for the following reason:', 'blessing'),
            'googlemap_not_avail' => esc_html__('Google map API not available!', 'blessing'),
            'editor_save_success' => esc_html__("Post content saved!", 'blessing'),
            'editor_save_error' => esc_html__("Error saving post data!", 'blessing'),
            'editor_delete_post' => esc_html__("You really want to delete the current post?", 'blessing'),
            'editor_delete_post_header' => esc_html__("Delete post", 'blessing'),
            'editor_delete_success' => esc_html__("Post deleted!", 'blessing'),
            'editor_delete_error' => esc_html__("Error deleting post!", 'blessing'),
            'editor_caption_cancel' => esc_html__('Cancel', 'blessing'),
            'editor_caption_close' => esc_html__('Close', 'blessing')
        );
        return $vars;
	}
}
?>