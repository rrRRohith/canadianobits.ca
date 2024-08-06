<?php
/**
 * ANCORA Framework: strings manipulations
 *
 * @package	ancora
 * @since	ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'ANCORA_MULTIBYTE' ) ) define( 'ANCORA_MULTIBYTE', function_exists('mb_strlen') ? 'UTF-8' : false );

if (!function_exists('ancora_strlen')) {
	function ancora_strlen($text) {
		return ANCORA_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('ancora_strpos')) {
	function ancora_strpos($text, $char, $from=0) {
		return ANCORA_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('ancora_strrpos')) {
	function ancora_strrpos($text, $char, $from=0) {
		return ANCORA_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('ancora_substr')) {
	function ancora_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = ancora_strlen($text)-$from;
		}
		return ANCORA_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}
// Unserialize string (try replace \n with \r\n)
if (!function_exists('ancora_unserialize')) {
    function ancora_unserialize($str) {
        if ( is_serialized($str) ) {
            try {
                $data = unserialize($str);
            } catch (Exception $e) {
                dcl($e->getMessage());
                $data = false;
            }
            if ($data===false) {
                try {
                    $data = unserialize(str_replace("\n", "\r\n", $str));
                } catch (Exception $e) {
                    dcl($e->getMessage());
                    $data = false;
                }
            }
            return $data;
        } else
            return $str;
    }
}
if (!function_exists('ancora_strtolower')) {
	function ancora_strtolower($text) {
		return ANCORA_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('ancora_strtoupper')) {
	function ancora_strtoupper($text) {
		return ANCORA_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('ancora_strtoproper')) {
	function ancora_strtoproper($text) {
		$rez = ''; $last = ' ';
		for ($i=0; $i<ancora_strlen($text); $i++) {
			$ch = ancora_substr($text, $i, 1);
			$rez .= ancora_strpos(' .,:;?!()[]{}+=', $last)!==false ? ancora_strtoupper($ch) : ancora_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('ancora_strrepeat')) {
	function ancora_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('ancora_strshort')) {
	function ancora_strshort($str, $maxlength, $add='...') {
	
	
		if ($maxlength < 0) 
			return '';
		if ($maxlength < 1 || $maxlength >= ancora_strlen($str))
			return strip_tags($str);
		$str = ancora_substr(strip_tags($str), 0, $maxlength - ancora_strlen($add));
		$ch = ancora_substr($str, $maxlength - ancora_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = ancora_strlen($str) - 1; $i > 0; $i--)
				if (ancora_substr($str, $i, 1) == ' ') break;
			$str = trim(ancora_substr($str, 0, $i));
		}
		if (!empty($str) && ancora_strpos(',.:;-', ancora_substr($str, -1))!==false) $str = ancora_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('ancora_strclear')) {
	function ancora_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (ancora_substr($text, 0, ancora_strlen($open))==$open) {
					$pos = ancora_strpos($text, '>');
					if ($pos!==false) $text = ancora_substr($text, $pos+1);
				}
				if (ancora_substr($text, -ancora_strlen($close))==$close) $text = ancora_substr($text, 0, ancora_strlen($text) - ancora_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}
?>