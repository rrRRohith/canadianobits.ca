<?php
//####################################################
//#### Inheritance system (for internal use only) #### 
//####################################################

// Add item to the inheritance settings
if ( !function_exists( 'ancora_add_theme_inheritance' ) ) {
	function ancora_add_theme_inheritance($options, $append=true) {
		global $ANCORA_GLOBALS;
		if (!isset($ANCORA_GLOBALS["inheritance"])) $ANCORA_GLOBALS["inheritance"] = array();
		$ANCORA_GLOBALS['inheritance'] = $append
			? ancora_array_merge($ANCORA_GLOBALS['inheritance'], $options)
			: ancora_array_merge($options, $ANCORA_GLOBALS['inheritance']);
	}
}



// Return inheritance settings
if ( !function_exists( 'ancora_get_theme_inheritance' ) ) {
	function ancora_get_theme_inheritance($key = '') {
		global $ANCORA_GLOBALS;
		return $key ? $ANCORA_GLOBALS['inheritance'][$key] : $ANCORA_GLOBALS['inheritance'];
	}
}



// Detect inheritance key for the current mode
if ( !function_exists( 'ancora_detect_inheritance_key' ) ) {
	function ancora_detect_inheritance_key() {
		static $inheritance_key = '';
		if (!empty($inheritance_key)) return $inheritance_key;
		$key = apply_filters('ancora_filter_detect_inheritance_key', '');
		global $ANCORA_GLOBALS;
		if (empty($ANCORA_GLOBALS['pre_query'])) $inheritance_key = $key;
		return $key;
	}
}


// Return key for override parameter
if ( !function_exists( 'ancora_get_override_key' ) ) {
	function ancora_get_override_key($value, $by) {
		$key = '';
		$inheritance = ancora_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v[$by]) && in_array($value, $v[$by])) {
					$key = $by=='taxonomy' 
						? $value
						: (!empty($v['override']) ? $v['override'] : $k);
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for categories) by post_type from inheritance array
if ( !function_exists( 'ancora_get_taxonomy_categories_by_post_type' ) ) {
	function ancora_get_taxonomy_categories_by_post_type($value) {
		$key = '';
		$inheritance = ancora_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy']) ? $v['taxonomy'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for tags) by post_type from inheritance array
if ( !function_exists( 'ancora_get_taxonomy_tags_by_post_type' ) ) {
	function ancora_get_taxonomy_tags_by_post_type($value) {
		$key = '';
		$inheritance = ancora_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy_tags']) ? $v['taxonomy_tags'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}
?>