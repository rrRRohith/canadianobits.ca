<?php
/**
 * HTML manipulations
 *
 * @package WordPress
 * @subpackage ThemeREX Utilities
 * @since v3.0
 */

// Don't load directly
if ( ! defined( 'TRX_UTILS_VERSION' ) ) {
	die( '-1' );
}


/* URL utilities
-------------------------------------------------------------------------------- */

// Return internal page link - if is customize mode - full url else only hash part
if (!function_exists('trx_utils_get_hash_link')) {
	function trx_utils_get_hash_link($hash) {
		if (strpos($hash, 'http')!==0) {
			if ($hash[0]!='#') $hash = '#'.$hash;
			if (is_customize_preview()) $hash = trx_utils_get_protocol().'://' . ($_SERVER["HTTP_HOST"]) . ($_SERVER["REQUEST_URI"]) . $hash;
		}
		return $hash;
	}
}

// Return current site protocol
if (!function_exists('trx_utils_get_protocol')) {
	function trx_utils_get_protocol() {
		return is_ssl() ? 'https' : 'http';
	}
}

// Add parameters to URL
if (!function_exists('trx_utils_add_to_url')) {
	function trx_utils_add_to_url($url, $prm) {
		if (is_array($prm) && count($prm) > 0) {
			$separator = strpos($url, '?')===false ? '?' : '&';
			foreach ($prm as $k=>$v) {
				$url .= $separator . urlencode($k) . '=' . urlencode($v);
				$separator = '&';
			}
		}
		return $url;
	}
}

// Set e-mail content type
// Call add_filter( 'wp_mail_content_type', 'trx_utils_set_html_content_type' ) before send mail
// and  remove_filter( 'wp_mail_content_type', 'trx_utils_set_html_content_type' ) after send mail
if (!function_exists('trx_utils_set_html_content_type')) {
	function trx_utils_set_html_content_type() {
		return 'text/html';
	}
}



/* GET, POST and SESSION utilities
-------------------------------------------------------------------------------- */

// Return GET or POST value
if (!function_exists('trx_utils_get_value_gp')) {
	function trx_utils_get_value_gp($name, $defa='') {
		$rez = $defa;
		$magic = function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1;
		if (isset($_GET[$name])) {
			$rez = $magic ? stripslashes(trim($_GET[$name])) : trim($_GET[$name]);
		} else if (isset($_POST[$name])) {
			$rez = $magic ? stripslashes(trim($_POST[$name])) : trim($_POST[$name]);
		}
		return $rez;
	}
}

// Return GET or POST or COOKIE value
if (!function_exists('trx_utils_get_value_gpc')) {
	function trx_utils_get_value_gpc($name, $defa='') {
		$rez = $defa;
		$magic = function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1;
		if (isset($_GET[$name])) {
			$rez = $magic ? stripslashes(trim($_GET[$name])) : trim($_GET[$name]);
		} else if (isset($_POST[$name])) {
			$rez = $magic ? stripslashes(trim($_POST[$name])) : trim($_POST[$name]);
		} else if (isset($_COOKIE[$name])) {
			$rez = $magic ? stripslashes(trim($_COOKIE[$name])) : trim($_COOKIE[$name]);
		}
		return $rez;
	}
}


// Get GET, POST, SESSION value and save it (if need)
if (!function_exists('trx_utils_get_value_gps')) {
	function trx_utils_get_value_gps($name, $defa='') {
		$rez = $defa;
		if (isset($_GET[$name])) {
			$rez = stripslashes(trim($_GET[$name]));
		} else if (isset($_POST[$name])) {
			$rez = stripslashes(trim($_POST[$name]));
		} else if (isset($_SESSION[$name])) {
			$rez = stripslashes(trim($_SESSION[$name]));
		}
		return $rez;
	}
}

// Save value into session
if (!function_exists('trx_utils_set_session_value')) {
	function trx_utils_set_session_value($name, $value) {
		if (!session_id()) session_start();
		$_SESSION[$name] = $value;
	}
}

// Delete value from session
if (!function_exists('trx_utils_del_session_value')) {
	function trx_utils_del_session_value($name) {
		if (!session_id()) session_start();
		unset($_SESSION[$name]);
	}
}


// Show content with the html layout (if not empty)
if ( !function_exists('trx_utils_show_layout') ) {
	function trx_utils_show_layout($str, $before='', $after='') {
		if (!empty($str)) {
			printf("%s%s%s", $before, $str, $after);
		}
	}
}
?>