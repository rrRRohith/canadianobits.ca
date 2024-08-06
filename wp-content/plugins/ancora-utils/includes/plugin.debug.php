<?php
/**
 * Debug utilities (for internal use only!)
 *
 * @package WordPress
 * @subpackage ThemeREX Utilities
 * @since v3.0
 */

// Don't load directly
if ( ! defined( 'TRX_UTILS_VERSION' ) ) {
	die( '-1' );
}

// Short analogs for debug functions
if (!function_exists('dcl')) {	function dcl($msg) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) echo '<br>"' . esc_html($msg) . '"<br>'; } }	// Console log - output any message on the screen
if (!function_exists('dco')) {	function dco(&$var, $lvl=-1) {	if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_utils_debug_dump_screen($var, $lvl); } }	// Console obj - output object struct. on the screen
if (!function_exists('dcs')) {	function dcs($lvl=-1) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_utils_debug_calls_stack_screen($lvl); } }	// Console stack - output calls stack on the screen
if (!function_exists('dcw')) {	function dcw($q=null) {			if (!function_exists('is_user_logged_in') || is_user_logged_in()) trx_utils_debug_dump_wp($q); } }				// Console WP - output WP is_... states on the screen
if (!function_exists('ddo')) {	function ddo(&$var, $lvl=-1) {	trx_utils_debug_dump_var($var, $lvl); } }							// Return obj - return object structure
if (!function_exists('dfl')) {	function dfl($var) {			trx_utils_debug_trace_message($var); } }							// File log - output any message into file debug.log
if (!function_exists('dfo')) {	function dfo(&$var, $lvl=-1) {	trx_utils_debug_dump_file($var, $lvl); } }							// File obj - output object structure into file debug.log
if (!function_exists('dfs')) {	function dfs($lvl=-1) { 		trx_utils_debug_calls_stack_file($lvl); } }						// File stack - output calls stack into file debug.log

// Save msg into file debug.log in the stylesheet directory
if (!function_exists('trx_utils_debug_trace_message')) {
	function trx_utils_debug_trace_message($msg) {
		trx_utils_fpc(get_stylesheet_directory().'/debug.log', date('d.m.Y H:i:s')." $msg\n", FILE_APPEND);
	}
}

// Output call stack into the current page
if (!function_exists('trx_utils_debug_calls_stack_screen')) {
	function trx_utils_debug_calls_stack_screen($level=-1) {
		$s = debug_backtrace();
		array_shift($s);
		trx_utils_debug_dump_screen($s, $level);
	}
}

// Output call stack into the debug.log
if (!function_exists('trx_utils_debug_calls_stack_file')) {
	function trx_utils_debug_calls_stack_file($level=-1) {
		$s = debug_backtrace();
		array_shift($s);
		trx_utils_debug_dump_file($s, $level);
	}
}

// Output var's dump into the current page
if (!function_exists('trx_utils_debug_dump_screen')) {
	function trx_utils_debug_dump_screen(&$var, $level=-1) {
		if ((is_array($var) || is_object($var)) && count($var))
			echo "<pre>\n".nl2br(esc_html(trx_utils_debug_dump_var($var, 0, $level)))."</pre>\n";
		else
			echo "<tt>".nl2br(esc_html(trx_utils_debug_dump_var($var, 0, $level)))."</tt>\n";
	}
}

// Output var's dump into the debug.log
if (!function_exists('trx_utils_debug_dump_file')) {
	function trx_utils_debug_dump_file(&$var, $level=-1) {
		trx_utils_debug_trace_message("\n\n".trx_utils_debug_dump_var($var, 0, $level));
	}
}

// Return var's dump as string
if (!function_exists('trx_utils_debug_dump_var')) {
	function trx_utils_debug_dump_var(&$var, $level=0, $max_level=-1)  {
		if (is_array($var)) $type="Array[".count($var)."]";
		else if (is_object($var)) $type="Object";
		else $type="";
		if ($type) {
			$rez = "$type\n";
			if ($max_level<0 || $level < $max_level) {
				for (Reset($var), $level++; list($k, $v)=each($var); ) {
					if (is_array($v) && $k==="GLOBALS") continue;
					for ($i=0; $i<$level*3; $i++) $rez .= " ";
					$rez .= $k.' => '. trx_utils_debug_dump_var($v, $level, $max_level);
				}
			}
		} else if (is_bool($var))
			$rez = ($var ? 'true' : 'false')."\n";
		else if (is_long($var) || is_float($var) || intval($var) != 0)
			$rez = $var."\n";
		else
			$rez = '"'.($var).'"'."\n";
		return $rez;
	}
}

// Output WP is_...() state into the current page
if (!function_exists('trx_utils_debug_dump_wp')) {
	function trx_utils_debug_dump_wp($query=null) {
		global $wp_query;
		if (!$query && !empty($wp_query)) $query = $wp_query;
		echo "<tt>"
			."<br>admin=".is_admin()
			."<br>mobile=".wp_is_mobile()
			.($query ? "<br>main_query=".is_main_query()."  query=".esc_html($query->is_main_query()) : '')
			."<br>query->is_posts_page=".esc_html($query->is_posts_page)
			."<br>home=".is_home().($query ? "  query=".esc_html($query->is_home()) : '')
			."<br>fp=".is_front_page().($query ? "  query=".esc_html($query->is_front_page()) : '')
			."<br>search=".is_search().($query ? "  query=".esc_html($query->is_search()) : '')
			."<br>category=".is_category().($query ? "  query=".esc_html($query->is_category()) : '')
			."<br>tag=".is_tag().($query ? "  query=".esc_html($query->is_tag()) : '')
			."<br>archive=".is_archive().($query ? "  query=".esc_html($query->is_archive()) : '')
			."<br>day=".is_day().($query ? "  query=".esc_html($query->is_day()) : '')
			."<br>month=".is_month().($query ? "  query=".esc_html($query->is_month()) : '')
			."<br>year=".is_year().($query ? "  query=".esc_html($query->is_year()) : '')
			."<br>author=".is_author().($query ? "  query=".esc_html($query->is_author()) : '')
			."<br>page=".is_page().($query ? "  query=".esc_html($query->is_page()) : '')
			."<br>single=".is_single().($query ? "  query=".esc_html($query->is_single()) : '')
			."<br>singular=".is_singular().($query ? "  query=".esc_html($query->is_singular()) : '')
			."<br>attachment=".is_attachment().($query ? "  query=".esc_html($query->is_attachment()) : '')
			."<br><br />"
			."</tt>";
	}
}
?>