<?php
/**
 * ANCORA Framework: return lists
 *
 * @package ancora
 * @since ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Return list of the animations
if ( !function_exists( 'ancora_get_list_animations' ) ) {
	function ancora_get_list_animations($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_animations']))
			$list = $ANCORA_GLOBALS['list_animations'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'blessing');
			$list['bounced']		= esc_html__('Bounced',		'blessing');
			$list['flash']			= esc_html__('Flash',		'blessing');
			$list['flip']			= esc_html__('Flip',		'blessing');
			$list['pulse']			= esc_html__('Pulse',		'blessing');
			$list['rubberBand']		= esc_html__('Rubber Band',	'blessing');
			$list['shake']			= esc_html__('Shake',		'blessing');
			$list['swing']			= esc_html__('Swing',		'blessing');
			$list['tada']			= esc_html__('Tada',		'blessing');
			$list['wobble']			= esc_html__('Wobble',		'blessing');
			$ANCORA_GLOBALS['list_animations'] = $list = apply_filters('ancora_filter_list_animations', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'ancora_get_list_animations_in' ) ) {
	function ancora_get_list_animations_in($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_animations_in']))
			$list = $ANCORA_GLOBALS['list_animations_in'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'blessing');
			$list['bounceIn']		= esc_html__('Bounce In',			'blessing');
			$list['bounceInUp']		= esc_html__('Bounce In Up',		'blessing');
			$list['bounceInDown']	= esc_html__('Bounce In Down',		'blessing');
			$list['bounceInLeft']	= esc_html__('Bounce In Left',		'blessing');
			$list['bounceInRight']	= esc_html__('Bounce In Right',		'blessing');
			$list['fadeIn']			= esc_html__('Fade In',				'blessing');
			$list['fadeInUp']		= esc_html__('Fade In Up',			'blessing');
			$list['fadeInDown']		= esc_html__('Fade In Down',		'blessing');
			$list['fadeInLeft']		= esc_html__('Fade In Left',		'blessing');
			$list['fadeInRight']	= esc_html__('Fade In Right',		'blessing');
			$list['fadeInUpBig']	= esc_html__('Fade In Up Big',		'blessing');
			$list['fadeInDownBig']	= esc_html__('Fade In Down Big',	'blessing');
			$list['fadeInLeftBig']	= esc_html__('Fade In Left Big',	'blessing');
			$list['fadeInRightBig']	= esc_html__('Fade In Right Big',	'blessing');
			$list['flipInX']		= esc_html__('Flip In X',			'blessing');
			$list['flipInY']		= esc_html__('Flip In Y',			'blessing');
			$list['lightSpeedIn']	= esc_html__('Light Speed In',		'blessing');
			$list['rotateIn']		= esc_html__('Rotate In',			'blessing');
			$list['rotateInUpLeft']		= esc_html__('Rotate In Down Left',	'blessing');
			$list['rotateInUpRight']	= esc_html__('Rotate In Up Right',	'blessing');
			$list['rotateInDownLeft']	= esc_html__('Rotate In Up Left',	'blessing');
			$list['rotateInDownRight']	= esc_html__('Rotate In Down Right','blessing');
			$list['rollIn']				= esc_html__('Roll In',			'blessing');
			$list['slideInUp']			= esc_html__('Slide In Up',		'blessing');
			$list['slideInDown']		= esc_html__('Slide In Down',	'blessing');
			$list['slideInLeft']		= esc_html__('Slide In Left',	'blessing');
			$list['slideInRight']		= esc_html__('Slide In Right',	'blessing');
			$list['zoomIn']				= esc_html__('Zoom In',			'blessing');
			$list['zoomInUp']			= esc_html__('Zoom In Up',		'blessing');
			$list['zoomInDown']			= esc_html__('Zoom In Down',	'blessing');
			$list['zoomInLeft']			= esc_html__('Zoom In Left',	'blessing');
			$list['zoomInRight']		= esc_html__('Zoom In Right',	'blessing');
			$ANCORA_GLOBALS['list_animations_in'] = $list = apply_filters('ancora_filter_list_animations_in', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'ancora_get_list_animations_out' ) ) {
	function ancora_get_list_animations_out($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_animations_out']))
			$list = $ANCORA_GLOBALS['list_animations_out'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'blessing');
			$list['bounceOut']		= esc_html__('Bounce Out',			'blessing');
			$list['bounceOutUp']	= esc_html__('Bounce Out Up',		'blessing');
			$list['bounceOutDown']	= esc_html__('Bounce Out Down',		'blessing');
			$list['bounceOutLeft']	= esc_html__('Bounce Out Left',		'blessing');
			$list['bounceOutRight']	= esc_html__('Bounce Out Right',	'blessing');
			$list['fadeOut']		= esc_html__('Fade Out',			'blessing');
			$list['fadeOutUp']		= esc_html__('Fade Out Up',			'blessing');
			$list['fadeOutDown']	= esc_html__('Fade Out Down',		'blessing');
			$list['fadeOutLeft']	= esc_html__('Fade Out Left',		'blessing');
			$list['fadeOutRight']	= esc_html__('Fade Out Right',		'blessing');
			$list['fadeOutUpBig']	= esc_html__('Fade Out Up Big',		'blessing');
			$list['fadeOutDownBig']	= esc_html__('Fade Out Down Big',	'blessing');
			$list['fadeOutLeftBig']	= esc_html__('Fade Out Left Big',	'blessing');
			$list['fadeOutRightBig']= esc_html__('Fade Out Right Big',	'blessing');
			$list['flipOutX']		= esc_html__('Flip Out X',			'blessing');
			$list['flipOutY']		= esc_html__('Flip Out Y',			'blessing');
			$list['hinge']			= esc_html__('Hinge Out',			'blessing');
			$list['lightSpeedOut']	= esc_html__('Light Speed Out',		'blessing');
			$list['rotateOut']		= esc_html__('Rotate Out',			'blessing');
			$list['rotateOutUpLeft']	= esc_html__('Rotate Out Down Left',	'blessing');
			$list['rotateOutUpRight']	= esc_html__('Rotate Out Up Right',		'blessing');
			$list['rotateOutDownLeft']	= esc_html__('Rotate Out Up Left',		'blessing');
			$list['rotateOutDownRight']	= esc_html__('Rotate Out Down Right',	'blessing');
			$list['rollOut']			= esc_html__('Roll Out',		'blessing');
			$list['slideOutUp']			= esc_html__('Slide Out Up',		'blessing');
			$list['slideOutDown']		= esc_html__('Slide Out Down',	'blessing');
			$list['slideOutLeft']		= esc_html__('Slide Out Left',	'blessing');
			$list['slideOutRight']		= esc_html__('Slide Out Right',	'blessing');
			$list['zoomOut']			= esc_html__('Zoom Out',			'blessing');
			$list['zoomOutUp']			= esc_html__('Zoom Out Up',		'blessing');
			$list['zoomOutDown']		= esc_html__('Zoom Out Down',	'blessing');
			$list['zoomOutLeft']		= esc_html__('Zoom Out Left',	'blessing');
			$list['zoomOutRight']		= esc_html__('Zoom Out Right',	'blessing');
			$ANCORA_GLOBALS['list_animations_out'] = $list = apply_filters('ancora_filter_list_animations_out', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'ancora_get_list_categories' ) ) {
	function ancora_get_list_categories($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_categories']))
			$list = $ANCORA_GLOBALS['list_categories'];
		else {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			foreach ($taxonomies as $cat) {
				$list[$cat->term_id] = $cat->name;
			}
			$ANCORA_GLOBALS['list_categories'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'ancora_get_list_terms' ) ) {
	function ancora_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_taxonomies_'.($taxonomy)]))
			$list = $ANCORA_GLOBALS['list_taxonomies_'.($taxonomy)];
		else {
			$list = array();
			$args = array(
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $taxonomy,
				'pad_counts'               => false );
			$taxonomies = get_terms( $taxonomy, $args );
			foreach ($taxonomies as $cat) {
				$list[$cat->term_id] = $cat->name;
			}
			$ANCORA_GLOBALS['list_taxonomies_'.($taxonomy)] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'ancora_get_list_posts_types' ) ) {
	function ancora_get_list_posts_types($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_posts_types']))
			$list = $ANCORA_GLOBALS['list_posts_types'];
		else {
			$list = array();

			// Return only theme inheritance supported post types
			$ANCORA_GLOBALS['list_posts_types'] = $list = apply_filters('ancora_filter_list_post_types', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'ancora_get_list_posts' ) ) {
	function ancora_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		global $ANCORA_GLOBALS;
		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (isset($ANCORA_GLOBALS[$hash]))
			$list = $ANCORA_GLOBALS[$hash];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'blessing');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			foreach ($posts as $post) {
				$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
			}
			$ANCORA_GLOBALS[$hash] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'ancora_get_list_users' ) ) {
	function ancora_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_users']))
			$list = $ANCORA_GLOBALS['list_users'];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'blessing');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			foreach ($users as $user) {
				$accept = true;
				if (is_array($user->roles)) {
					if (count($user->roles) > 0) {
						$accept = false;
						foreach ($user->roles as $role) {
							if (in_array($role, $roles)) {
								$accept = true;
								break;
							}
						}
					}
				}
				if ($accept) $list[$user->user_login] = $user->display_name;
			}
			$ANCORA_GLOBALS['list_users'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return sliders list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'ancora_get_list_sliders' ) ) {
	function ancora_get_list_sliders($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_sliders']))
			$list = $ANCORA_GLOBALS['list_sliders'];
		else {
			$list = array();
			$list["swiper"] = esc_html__("Posts slider (Swiper)", 'blessing');
			if (ancora_exists_revslider())
				$list["revo"] = esc_html__("Layer slider (Revolution)", 'blessing');
			$ANCORA_GLOBALS['list_sliders'] = $list = apply_filters('ancora_filter_list_sliders', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with popup engines
if ( !function_exists( 'ancora_get_list_popup_engines' ) ) {
	function ancora_get_list_popup_engines($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_popup_engines']))
			$list = $ANCORA_GLOBALS['list_popup_engines'];
		else {
			$list = array();
			$list["pretty"] = esc_html__("Pretty photo", 'blessing');
			$list["magnific"] =  esc_html__("Magnific popup", 'blessing');
			$ANCORA_GLOBALS['list_popup_engines'] = $list = apply_filters('ancora_filter_list_popup_engines', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'ancora_get_list_menus' ) ) {
	function ancora_get_list_menus($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_menus']))
			$list = $ANCORA_GLOBALS['list_menus'];
		else {
			$list = array();
			$list['default'] =  esc_html__("Default", 'blessing');
			$menus = wp_get_nav_menus();
			if ($menus) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			$ANCORA_GLOBALS['list_menus'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'ancora_get_list_sidebars' ) ) {
	function ancora_get_list_sidebars($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_sidebars'])) {
			$list = $ANCORA_GLOBALS['list_sidebars'];
		} else {
			$list = isset($ANCORA_GLOBALS['registered_sidebars']) ? $ANCORA_GLOBALS['registered_sidebars'] : array();
			$ANCORA_GLOBALS['list_sidebars'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'ancora_get_list_sidebars_positions' ) ) {
	function ancora_get_list_sidebars_positions($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_sidebars_positions']))
			$list = $ANCORA_GLOBALS['list_sidebars_positions'];
		else {
			$list = array();
			$list['left']  =  esc_html__('Left',  'blessing');
			$list['right'] =  esc_html__('Right', 'blessing');
			$ANCORA_GLOBALS['list_sidebars_positions'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'ancora_get_sidebar_class' ) ) {
	function ancora_get_sidebar_class($style, $pos) {
		return ancora_sc_param_is_off($style) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($pos);
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_body_styles' ) ) {
	function ancora_get_list_body_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_body_styles']))
			$list = $ANCORA_GLOBALS['list_body_styles'];
		else {
			$list = array();
			$list['boxed']		=  esc_html__('Boxed',		'blessing');
			$list['wide']		=  esc_html__('Wide',		'blessing');
			$list['fullwide']	=  esc_html__('Fullwide',	'blessing');
			$list['fullscreen']	=  esc_html__('Fullscreen',	'blessing');
			$ANCORA_GLOBALS['list_body_styles'] = $list = apply_filters('ancora_filter_list_body_styles', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'ancora_get_list_skins' ) ) {
	function ancora_get_list_skins($prepend_inherit=false) {
		$list = ancora_get_list_folders('skins');
        return $prepend_inherit ? ancora_array_merge(array('inherit' =>  esc_html__("Inherit", 'blessing')), $list) : $list;
    }
}

if ( !function_exists( 'ancora_get_list_folders' ) ) {
	function ancora_get_list_folders( $path ) {
		$folder_urls = glob(get_template_directory() . '/'.$path.'/*', GLOB_ONLYDIR);
		$folder_name_list = array();
		foreach ($folder_urls as $folder_url){
			preg_match("/[^\/]+$/", $folder_url, $matches);
			$folder_name_list[$matches[0]] = (ucwords($matches[0]));
		}
		return $folder_name_list;
	}
}

if ( !function_exists( 'ancora_get_currently_used_skin' ) ) {
	function ancora_get_currently_used_skin() {
		$skin = sanitize_file_name(ancora_get_custom_option('theme_skin'));
		return $skin;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'ancora_get_list_templates' ) ) {
	function ancora_get_list_templates($mode='') {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_templates_'.($mode)]))
			$list = $ANCORA_GLOBALS['list_templates_'.($mode)];
		else {
			$list = array();
			foreach ($ANCORA_GLOBALS['registered_templates'] as $k=>$v) {
				if ($mode=='' || ancora_strpos($v['mode'], $mode)!==false)
					$list[$k] = !empty($v['title']) ? $v['title'] : ancora_strtoproper($v['layout']);
			}
			$ANCORA_GLOBALS['list_templates_'.($mode)] = $list;
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_templates_blog' ) ) {
	function ancora_get_list_templates_blog($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_templates_blog']))
			$list = $ANCORA_GLOBALS['list_templates_blog'];
		else {
			$list = ancora_get_list_templates('blog');
			$ANCORA_GLOBALS['list_templates_blog'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_templates_blogger' ) ) {
	function ancora_get_list_templates_blogger($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_templates_blogger']))
			$list = $ANCORA_GLOBALS['list_templates_blogger'];
		else {
			$list = ancora_array_merge(ancora_get_list_templates('blogger'), ancora_get_list_templates('blog'));
			$ANCORA_GLOBALS['list_templates_blogger'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_templates_single' ) ) {
	function ancora_get_list_templates_single($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_templates_single']))
			$list = $ANCORA_GLOBALS['list_templates_single'];
		else {
			$list = ancora_get_list_templates('single');
			$ANCORA_GLOBALS['list_templates_single'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_article_styles' ) ) {
	function ancora_get_list_article_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_article_styles']))
			$list = $ANCORA_GLOBALS['list_article_styles'];
		else {
			$list = array();
			$list["boxed"]   = esc_html__('Boxed', 'blessing');
			$list["stretch"] = esc_html__('Stretch', 'blessing');
			$ANCORA_GLOBALS['list_article_styles'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return color schemes list, prepended inherit
if ( !function_exists( 'ancora_get_list_color_schemes' ) ) {
	function ancora_get_list_color_schemes($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_color_schemes']))
			$list = $ANCORA_GLOBALS['list_color_schemes'];
		else {
			$list = array();
			if (!empty($ANCORA_GLOBALS['color_schemes'])) {
				foreach ($ANCORA_GLOBALS['color_schemes'] as $k=>$v) {
					$list[$k] = $v['title'];
				}
			}
			$ANCORA_GLOBALS['list_color_schemes'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return button styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_button_styles' ) ) {
	function ancora_get_list_button_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_button_styles']))
			$list = $ANCORA_GLOBALS['list_button_styles'];
		else {
			$list = array();
			$list["custom"]	= esc_html__('Custom', 'blessing');
			$list["link"] 	= esc_html__('As links', 'blessing');
			$list["menu"] 	= esc_html__('As main menu', 'blessing');
			$list["user"] 	= esc_html__('As user menu', 'blessing');
			$ANCORA_GLOBALS['list_button_styles'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'ancora_get_list_post_formats_filters' ) ) {
	function ancora_get_list_post_formats_filters($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_post_formats_filters']))
			$list = $ANCORA_GLOBALS['list_post_formats_filters'];
		else {
			$list = array();
			$list["no"]      = esc_html__('All posts', 'blessing');
			$list["thumbs"]  = esc_html__('With thumbs', 'blessing');
			$list["reviews"] = esc_html__('With reviews', 'blessing');
			$list["video"]   = esc_html__('With videos', 'blessing');
			$list["audio"]   = esc_html__('With audios', 'blessing');
			$list["gallery"] = esc_html__('With galleries', 'blessing');
			$ANCORA_GLOBALS['list_post_formats_filters'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return scheme color
if (!function_exists('ancora_get_scheme_color')) {
	function ancora_get_scheme_color($clr) {
		global $ANCORA_GLOBALS;
		$scheme = ancora_get_custom_option('color_scheme');
		if (empty($scheme) || empty($ANCORA_GLOBALS['color_schemes'][$scheme])) $scheme = 'original';
		return isset($ANCORA_GLOBALS['color_schemes'][$scheme][$clr]) ? $ANCORA_GLOBALS['color_schemes'][$scheme][$clr] : '';
	}
}
// Return portfolio filters list, prepended inherit
if ( !function_exists( 'ancora_get_list_portfolio_filters' ) ) {
	function ancora_get_list_portfolio_filters($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_portfolio_filters']))
			$list = $ANCORA_GLOBALS['list_portfolio_filters'];
		else {
			$list = array();
			$list["hide"] = esc_html__('Hide', 'blessing');
			$list["tags"] = esc_html__('Tags', 'blessing');
			$list["categories"] = esc_html__('Categories', 'blessing');
			$ANCORA_GLOBALS['list_portfolio_filters'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_hovers' ) ) {
	function ancora_get_list_hovers($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_hovers']))
			$list = $ANCORA_GLOBALS['list_hovers'];
		else {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'blessing');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'blessing');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'blessing');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'blessing');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'blessing');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'blessing');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'blessing');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'blessing');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'blessing');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'blessing');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'blessing');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'blessing');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'blessing');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'blessing');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'blessing');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'blessing');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'blessing');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'blessing');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'blessing');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'blessing');
			$list['square effect1']  = esc_html__('Square Effect 1',  'blessing');
			$list['square effect2']  = esc_html__('Square Effect 2',  'blessing');
			$list['square effect3']  = esc_html__('Square Effect 3',  'blessing');

			$list['square effect5']  = esc_html__('Square Effect 5',  'blessing');
			$list['square effect6']  = esc_html__('Square Effect 6',  'blessing');
			$list['square effect7']  = esc_html__('Square Effect 7',  'blessing');
			$list['square effect8']  = esc_html__('Square Effect 8',  'blessing');
			$list['square effect9']  = esc_html__('Square Effect 9',  'blessing');
			$list['square effect10'] = esc_html__('Square Effect 10',  'blessing');
			$list['square effect11'] = esc_html__('Square Effect 11',  'blessing');
			$list['square effect12'] = esc_html__('Square Effect 12',  'blessing');
			$list['square effect13'] = esc_html__('Square Effect 13',  'blessing');
			$list['square effect14'] = esc_html__('Square Effect 14',  'blessing');
			$list['square effect15'] = esc_html__('Square Effect 15',  'blessing');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'blessing');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'blessing');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'blessing');
			$ANCORA_GLOBALS['list_hovers'] = $list = apply_filters('ancora_filter_portfolio_hovers', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'ancora_get_list_hovers_directions' ) ) {
	function ancora_get_list_hovers_directions($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_hovers_directions']))
			$list = $ANCORA_GLOBALS['list_hovers_directions'];
		else {
			$list = array();
			$list['left_to_right'] = esc_html__('Left to Right',  'blessing');
			$list['right_to_left'] = esc_html__('Right to Left',  'blessing');
			$list['top_to_bottom'] = esc_html__('Top to Bottom',  'blessing');
			$list['bottom_to_top'] = esc_html__('Bottom to Top',  'blessing');
			$list['scale_up']      = esc_html__('Scale Up',  'blessing');
			$list['scale_down']    = esc_html__('Scale Down',  'blessing');
			$list['scale_down_up'] = esc_html__('Scale Down-Up',  'blessing');
			$list['from_left_and_right'] = esc_html__('From Left and Right',  'blessing');
			$list['from_top_and_bottom'] = esc_html__('From Top and Bottom',  'blessing');
			$ANCORA_GLOBALS['list_hovers_directions'] = $list = apply_filters('ancora_filter_portfolio_hovers_directions', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'ancora_get_list_label_positions' ) ) {
	function ancora_get_list_label_positions($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_label_positions']))
			$list = $ANCORA_GLOBALS['list_label_positions'];
		else {
			$list = array();
			$list['top']	= esc_html__('Top',		'blessing');
			$list['bottom']	= esc_html__('Bottom',		'blessing');
			$list['left']	= esc_html__('Left',		'blessing');
			$list['over']	= esc_html__('Over',		'blessing');
			$ANCORA_GLOBALS['list_label_positions'] = $list = apply_filters('ancora_filter_label_positions', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return background tints list, prepended inherit
if ( !function_exists( 'ancora_get_list_bg_tints' ) ) {
	function ancora_get_list_bg_tints($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_bg_tints']))
			$list = $ANCORA_GLOBALS['list_bg_tints'];
		else {
			$list = array();
			$list['none']  = esc_html__('None',  'blessing');
			$list['light'] = esc_html__('Light','blessing');
			$list['dark']  = esc_html__('Dark',  'blessing');
			$ANCORA_GLOBALS['list_bg_tints'] = $list = apply_filters('ancora_filter_bg_tints', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return background tints list for sidebars, prepended inherit
if ( !function_exists( 'ancora_get_list_sidebar_styles' ) ) {
	function ancora_get_list_sidebar_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_sidebar_styles']))
			$list = $ANCORA_GLOBALS['list_sidebar_styles'];
		else {
			$list = array();
			$list['none']  = esc_html__('None',  'blessing');
			$list['light white'] = esc_html__('White','blessing');
			$list['light'] = esc_html__('Light','blessing');
			$list['dark']  = esc_html__('Dark',  'blessing');
			$ANCORA_GLOBALS['list_sidebar_styles'] = $list = apply_filters('ancora_filter_sidebar_styles', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'ancora_get_list_field_types' ) ) {
	function ancora_get_list_field_types($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_field_types']))
			$list = $ANCORA_GLOBALS['list_field_types'];
		else {
			$list = array();
			$list['text']     = esc_html__('Text',  'blessing');
			$list['textarea'] = esc_html__('Text Area','blessing');
			$list['password'] = esc_html__('Password',  'blessing');
			$list['radio']    = esc_html__('Radio',  'blessing');
			$list['checkbox'] = esc_html__('Checkbox',  'blessing');
			$list['button']   = esc_html__('Button','blessing');
			$ANCORA_GLOBALS['list_field_types'] = $list = apply_filters('ancora_filter_field_types', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'ancora_get_list_googlemap_styles' ) ) {
	function ancora_get_list_googlemap_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_googlemap_styles']))
			$list = $ANCORA_GLOBALS['list_googlemap_styles'];
		else {
			$list = array();
			$list['default'] = esc_html__('Default', 'blessing');
			$list['simple'] = esc_html__('Simple', 'blessing');
			$list['greyscale'] = esc_html__('Greyscale', 'blessing');
			$list['greyscale2'] = esc_html__('Greyscale 2', 'blessing');
			$list['invert'] = esc_html__('Invert', 'blessing');
			$list['dark'] = esc_html__('Dark', 'blessing');
			$list['style1'] = esc_html__('Custom style 1', 'blessing');
			$list['style2'] = esc_html__('Custom style 2', 'blessing');
			$list['style3'] = esc_html__('Custom style 3', 'blessing');
			$ANCORA_GLOBALS['list_googlemap_styles'] = $list = apply_filters('ancora_filter_googlemap_styles', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'ancora_get_list_icons' ) ) {
	function ancora_get_list_icons($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_icons']))
			$list = $ANCORA_GLOBALS['list_icons'];
		else
			$ANCORA_GLOBALS['list_icons'] = $list = ancora_parse_icons_classes(ancora_get_file_dir("css/fontello/css/fontello-codes.css"));
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'ancora_get_list_socials' ) ) {
	function ancora_get_list_socials($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_socials']))
			$list = $ANCORA_GLOBALS['list_socials'];
		else
			$ANCORA_GLOBALS['list_socials'] = $list = ancora_get_list_files("images/socials", "png");
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'ancora_get_list_flags' ) ) {
	function ancora_get_list_flags($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_flags']))
			$list = $ANCORA_GLOBALS['list_flags'];
		else
			$ANCORA_GLOBALS['list_flags'] = $list = ancora_get_list_files("images/flags", "png");
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'ancora_get_list_yesno' ) ) {
	function ancora_get_list_yesno($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_yesno']))
			$list = $ANCORA_GLOBALS['list_yesno'];
		else {
			$list = array();
			$list["yes"] = esc_html__("Yes", 'blessing');
			$list["no"]  = esc_html__("No", 'blessing');
			$ANCORA_GLOBALS['list_yesno'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'ancora_get_list_onoff' ) ) {
	function ancora_get_list_onoff($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_onoff']))
			$list = $ANCORA_GLOBALS['list_onoff'];
		else {
			$list = array();
			$list["on"] = esc_html__("On", 'blessing');
			$list["off"] = esc_html__("Off", 'blessing');
			$ANCORA_GLOBALS['list_onoff'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'ancora_get_list_showhide' ) ) {
	function ancora_get_list_showhide($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_showhide']))
			$list = $ANCORA_GLOBALS['list_showhide'];
		else {
			$list = array();
			$list["show"] = esc_html__("Show", 'blessing');
			$list["hide"] = esc_html__("Hide", 'blessing');
			$ANCORA_GLOBALS['list_showhide'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'ancora_get_list_orderings' ) ) {
	function ancora_get_list_orderings($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_orderings']))
			$list = $ANCORA_GLOBALS['list_orderings'];
		else {
			$list = array();
			$list["asc"] = esc_html__("Ascending", 'blessing');
			$list["desc"] = esc_html__("Descending", 'blessing');
			$ANCORA_GLOBALS['list_orderings'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'ancora_get_list_directions' ) ) {
	function ancora_get_list_directions($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_directions']))
			$list = $ANCORA_GLOBALS['list_directions'];
		else {
			$list = array();
			$list["horizontal"] = esc_html__("Horizontal", 'blessing');
			$list["vertical"] = esc_html__("Vertical", 'blessing');
			$ANCORA_GLOBALS['list_directions'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'ancora_get_list_floats' ) ) {
	function ancora_get_list_floats($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_floats']))
			$list = $ANCORA_GLOBALS['list_floats'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'blessing');
			$list["left"] = esc_html__("Float Left", 'blessing');
			$list["right"] = esc_html__("Float Right", 'blessing');
			$ANCORA_GLOBALS['list_floats'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'ancora_get_list_alignments' ) ) {
	function ancora_get_list_alignments($justify=false, $prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_alignments']))
			$list = $ANCORA_GLOBALS['list_alignments'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'blessing');
			$list["left"] = esc_html__("Left", 'blessing');
			$list["center"] = esc_html__("Center", 'blessing');
			$list["right"] = esc_html__("Right", 'blessing');
			if ($justify) $list["justify"] = esc_html__("Justify", 'blessing');
			$ANCORA_GLOBALS['list_alignments'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'ancora_get_list_sortings' ) ) {
	function ancora_get_list_sortings($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_sortings']))
			$list = $ANCORA_GLOBALS['list_sortings'];
		else {
			$list = array();
			$list["date"] = esc_html__("Date", 'blessing');
			$list["title"] = esc_html__("Alphabetically", 'blessing');
			$list["views"] = esc_html__("Popular (views count)", 'blessing');
			$list["comments"] = esc_html__("Most commented (comments count)", 'blessing');
			$list["author_rating"] = esc_html__("Author rating", 'blessing');
			$list["users_rating"] = esc_html__("Visitors (users) rating", 'blessing');
			$list["random"] = esc_html__("Random", 'blessing');
			$ANCORA_GLOBALS['list_sortings'] = $list = apply_filters('ancora_filter_list_sortings', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'ancora_get_list_columns' ) ) {
	function ancora_get_list_columns($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_columns']))
			$list = $ANCORA_GLOBALS['list_columns'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'blessing');
			$list["1_1"] = esc_html__("100%", 'blessing');
			$list["1_2"] = esc_html__("1/2", 'blessing');
			$list["1_3"] = esc_html__("1/3", 'blessing');
			$list["2_3"] = esc_html__("2/3", 'blessing');
			$list["1_4"] = esc_html__("1/4", 'blessing');
			$list["3_4"] = esc_html__("3/4", 'blessing');
			$list["1_5"] = esc_html__("1/5", 'blessing');
			$list["2_5"] = esc_html__("2/5", 'blessing');
			$list["3_5"] = esc_html__("3/5", 'blessing');
			$list["4_5"] = esc_html__("4/5", 'blessing');
			$list["1_6"] = esc_html__("1/6", 'blessing');
			$list["5_6"] = esc_html__("5/6", 'blessing');
			$list["1_7"] = esc_html__("1/7", 'blessing');
			$list["2_7"] = esc_html__("2/7", 'blessing');
			$list["3_7"] = esc_html__("3/7", 'blessing');
			$list["4_7"] = esc_html__("4/7", 'blessing');
			$list["5_7"] = esc_html__("5/7", 'blessing');
			$list["6_7"] = esc_html__("6/7", 'blessing');
			$list["1_8"] = esc_html__("1/8", 'blessing');
			$list["3_8"] = esc_html__("3/8", 'blessing');
			$list["5_8"] = esc_html__("5/8", 'blessing');
			$list["7_8"] = esc_html__("7/8", 'blessing');
			$list["1_9"] = esc_html__("1/9", 'blessing');
			$list["2_9"] = esc_html__("2/9", 'blessing');
			$list["4_9"] = esc_html__("4/9", 'blessing');
			$list["5_9"] = esc_html__("5/9", 'blessing');
			$list["7_9"] = esc_html__("7/9", 'blessing');
			$list["8_9"] = esc_html__("8/9", 'blessing');
			$list["1_10"]= esc_html__("1/10", 'blessing');
			$list["3_10"]= esc_html__("3/10", 'blessing');
			$list["7_10"]= esc_html__("7/10", 'blessing');
			$list["9_10"]= esc_html__("9/10", 'blessing');
			$list["1_11"]= esc_html__("1/11", 'blessing');
			$list["2_11"]= esc_html__("2/11", 'blessing');
			$list["3_11"]= esc_html__("3/11", 'blessing');
			$list["4_11"]= esc_html__("4/11", 'blessing');
			$list["5_11"]= esc_html__("5/11", 'blessing');
			$list["6_11"]= esc_html__("6/11", 'blessing');
			$list["7_11"]= esc_html__("7/11", 'blessing');
			$list["8_11"]= esc_html__("8/11", 'blessing');
			$list["9_11"]= esc_html__("9/11", 'blessing');
			$list["10_11"]= esc_html__("10/11", 'blessing');
			$list["1_12"]= esc_html__("1/12", 'blessing');
			$list["5_12"]= esc_html__("5/12", 'blessing');
			$list["7_12"]= esc_html__("7/12", 'blessing');
			$list["10_12"]= esc_html__("10/12", 'blessing');
			$list["11_12"]= esc_html__("11/12", 'blessing');
			$ANCORA_GLOBALS['list_columns'] = $list = apply_filters('ancora_filter_list_columns', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'ancora_get_list_dedicated_locations' ) ) {
	function ancora_get_list_dedicated_locations($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_dedicated_locations']))
			$list = $ANCORA_GLOBALS['list_dedicated_locations'];
		else {
			$list = array();
			$list["default"] = esc_html__('As in the post defined', 'blessing');
			$list["center"]  = esc_html__('Above the text of the post', 'blessing');
			$list["left"]    = esc_html__('To the left the text of the post', 'blessing');
			$list["right"]   = esc_html__('To the right the text of the post', 'blessing');
			$list["alter"]   = esc_html__('Alternates for each post', 'blessing');
			$ANCORA_GLOBALS['list_dedicated_locations'] = $list = apply_filters('ancora_filter_list_dedicated_locations', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'ancora_get_post_format_name' ) ) {
	function ancora_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'blessing') : esc_html__('galleries', 'blessing');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'blessing') : esc_html__('videos', 'blessing');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'blessing') : esc_html__('audios', 'blessing');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'blessing') : esc_html__('images', 'blessing');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'blessing') : esc_html__('quotes', 'blessing');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'blessing') : esc_html__('links', 'blessing');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'blessing') : esc_html__('statuses', 'blessing');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'blessing') : esc_html__('asides', 'blessing');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'blessing') : esc_html__('chats', 'blessing');
		else						$name = $single ? esc_html__('standard', 'blessing') : esc_html__('standards', 'blessing');
		return apply_filters('ancora_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'ancora_get_post_format_icon' ) ) {
	function ancora_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'picture-2';
		else if ($format=='video')	$icon .= 'video-2';
		else if ($format=='audio')	$icon .= 'musical-2';
		else if ($format=='image')	$icon .= 'picture-boxed-2';
		else if ($format=='quote')	$icon .= 'quote-2';
		else if ($format=='link')	$icon .= 'link-2';
		else if ($format=='status')	$icon .= 'agenda-2';
		else if ($format=='aside')	$icon .= 'chat-2';
		else if ($format=='chat')	$icon .= 'chat-all-2';
		else						$icon .= 'book-2';
		return apply_filters('ancora_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'ancora_get_list_fonts_styles' ) ) {
	function ancora_get_list_fonts_styles($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_fonts_styles']))
			$list = $ANCORA_GLOBALS['list_fonts_styles'];
		else {
			$list = array();
			$list['i'] = esc_html__('I','blessing');
			$list['u'] = esc_html__('U', 'blessing');
			$ANCORA_GLOBALS['list_fonts_styles'] = $list;
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'ancora_get_list_fonts' ) ) {
	function ancora_get_list_fonts($prepend_inherit=false) {
		global $ANCORA_GLOBALS;
		if (isset($ANCORA_GLOBALS['list_fonts']))
			$list = $ANCORA_GLOBALS['list_fonts'];
		else {
			$list = array();
			$list = ancora_array_merge($list, ancora_get_list_fonts_custom());
			// Google and custom fonts list:





			$list['Advent Pro'] = array('family'=>'sans-serif');
			$list['Alegreya Sans'] = array('family'=>'sans-serif');
			$list['Arimo'] = array('family'=>'sans-serif');
			$list['Asap'] = array('family'=>'sans-serif');
			$list['Averia Sans Libre'] = array('family'=>'cursive');
			$list['Averia Serif Libre'] = array('family'=>'cursive');
			$list['Bree Serif'] = array('family'=>'serif',);
			$list['Cabin'] = array('family'=>'sans-serif');
			$list['Cabin Condensed'] = array('family'=>'sans-serif');
			$list['Caudex'] = array('family'=>'serif');
			$list['Comfortaa'] = array('family'=>'cursive');
			$list['Cousine'] = array('family'=>'sans-serif');
			$list['Crimson Text'] = array('family'=>'serif');
			$list['Cuprum'] = array('family'=>'sans-serif');
			$list['Dosis'] = array('family'=>'sans-serif');
			$list['Economica'] = array('family'=>'sans-serif');
			$list['Exo'] = array('family'=>'sans-serif');
			$list['Expletus Sans'] = array('family'=>'cursive');
			$list['Karla'] = array('family'=>'sans-serif');
			$list['Lato'] = array('family'=>'sans-serif');
			$list['Lekton'] = array('family'=>'sans-serif');
			$list['Lobster Two'] = array('family'=>'cursive');
			$list['Maven Pro'] = array('family'=>'sans-serif');
			$list['Merriweather'] = array('family'=>'serif');
			$list['Montserrat'] = array('family'=>'sans-serif');
			$list['Neuton'] = array('family'=>'serif');
			$list['Noticia Text'] = array('family'=>'serif');
			$list['Old Standard TT'] = array('family'=>'serif');
			$list['Open Sans'] = array('family'=>'sans-serif');
			$list['Orbitron'] = array('family'=>'sans-serif');
			$list['Oswald'] = array('family'=>'sans-serif');
			$list['Overlock'] = array('family'=>'cursive');
			$list['Oxygen'] = array('family'=>'sans-serif');
			$list['PT Serif'] = array('family'=>'serif');
			$list['Puritan'] = array('family'=>'sans-serif');
			$list['Raleway'] = array('family'=>'sans-serif');
			$list['Roboto'] = array('family'=>'sans-serif');
			$list['Roboto Slab'] = array('family'=>'sans-serif');
			$list['Roboto Condensed'] = array('family'=>'sans-serif');
			$list['Rosario'] = array('family'=>'sans-serif');
			$list['Share'] = array('family'=>'cursive');
			$list['Signika'] = array('family'=>'sans-serif');
			$list['Signika Negative'] = array('family'=>'sans-serif');
			$list['Source Sans Pro'] = array('family'=>'sans-serif');
			$list['Tinos'] = array('family'=>'serif');
			$list['Ubuntu'] = array('family'=>'sans-serif');
			$list['Vollkorn'] = array('family'=>'serif');
			$ANCORA_GLOBALS['list_fonts'] = $list = apply_filters('ancora_filter_list_fonts', $list);
		}
		return $prepend_inherit ? ancora_array_merge(array('inherit' => esc_html__("Inherit", 'blessing')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'ancora_get_list_fonts_custom' ) ) {
	function ancora_get_list_fonts_custom($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$fonts = ancora_get_global('required_custom_fonts');
		$list = array();
		if (is_array($fonts)) {
			foreach ($fonts as $font) {
				if (($url = ancora_get_file_url('css/font-face/'.trim($font).'/stylesheet.css'))!='') {
					$list[sprintf(esc_html__('%s (uploaded font)', 'blessing'), $font)] = array('css' => $url);
				}
			}
		}
		return $list;
	}
}
?>