<?php
/**
 * HTML & CSS utilities
 *
 * @package ThemeREX Updater
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

// Output string with the html layout (if not empty)
// (put it between 'before' and 'after' tags)
// Attention! This string may contain layout formed in any plugin (widgets or shortcodes output) and not require escaping to prevent damage!
if ( !function_exists('trx_updater_show_layout') ) {
	function trx_updater_show_layout($str, $before='', $after='') {
		if (trim($str) != '') {
			printf("%s%s%s", $before, $str, $after);
		}
	}
}

// Return value for the style attr
if (!function_exists('trx_updater_prepare_css_value')) {
	function trx_updater_prepare_css_value($val) {
		if ($val != '') {
			$ed = substr($val, -1);
			if ('0'<=$ed && $ed<='9') $val .= 'px';
		}
		return $val;
	}
}


// Return current site protocol
if (!function_exists('trx_updater_get_protocol')) {
	function trx_updater_get_protocol() {
		return is_ssl() ? 'https' : 'http';
	}
}

// Return url without protocol
if (!function_exists('trx_updater_remove_protocol')) {
	function trx_updater_remove_protocol($url, $complete=false) {
		$url = preg_replace('/http[s]?:'.($complete ? '\\/\\/' : '').'/', '', $url);
		return $url;
	}
}

// Check if string is URL
if (!function_exists('trx_updater_is_url')) {
	function trx_updater_is_url($url) {
		return strpos($url, '://')!==false;
	}
}

// Add parameters to URL
if (!function_exists('trx_updater_add_to_url')) {
	function trx_updater_add_to_url($url, $prm) {
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



/* GET, POST and SESSION utilities
-------------------------------------------------------------------------------- */

// Strip slashes if Magic Quotes is on
if (!function_exists('trx_updater_stripslashes')) {
	function trx_updater_stripslashes($val) {
		static $magic = 0;
		if ($magic === 0) {
			$magic = version_compare(phpversion(), '5.4', '>=')
					|| (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()==1) 
					|| (function_exists('get_magic_quotes_runtime') && get_magic_quotes_runtime()==1) 
					|| strtolower(ini_get('magic_quotes_sybase'))=='on';
		}
		if (is_array($val)) {
			foreach($val as $k=>$v)
				$val[$k] = trx_updater_stripslashes($v);
		} else
			$val = $magic ? stripslashes(trim($val)) : trim($val);
		return $val;
	}
}


// Return GET or POST value
if (!function_exists('trx_updater_get_value_gp')) {
	function trx_updater_get_value_gp($name, $defa='') {
		if (isset($_GET[$name]))		$rez = $_GET[$name];
		else if (isset($_POST[$name]))	$rez = $_POST[$name];
		else							$rez = $defa;
		return trx_updater_stripslashes($rez);
	}
}


// Return GET or POST or COOKIE value
if (!function_exists('trx_updater_get_value_gpc')) {
	function trx_updater_get_value_gpc($name, $defa='') {
		if (isset($_GET[$name]))		 $rez = $_GET[$name];
		else if (isset($_POST[$name]))	 $rez = $_POST[$name];
		else if (isset($_COOKIE[$name])) $rez = $_COOKIE[$name];
		else							 $rez = $defa;
		return trx_updater_stripslashes($rez);
	}
}


// Get GET, POST, SESSION value and save it (if need)
if (!function_exists('trx_updater_get_value_gps')) {
	function trx_updater_get_value_gps($name, $defa='') {
		if (isset($_GET[$name]))		  $rez = $_GET[$name];
		else if (isset($_POST[$name]))	  $rez = $_POST[$name];
		else if (isset($_SESSION[$name])) $rez = $_SESSION[$name];
		else							  $rez = $defa;
		return trx_updater_stripslashes($rez);
	}
}
