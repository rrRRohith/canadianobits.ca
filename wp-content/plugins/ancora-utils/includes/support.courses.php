<?php
/*
 * Support for the Courses and Lessons
 */



// Register custom post type
if (!function_exists('trx_utils_support_courses_post_type')) {
	add_action( 'trx_utils_custom_post_type', 'trx_utils_support_courses_post_type', 10, 2 );
	function trx_utils_support_courses_post_type($name, $args=false) {
		
		if ($name=='courses') {

			if ($args===false) {
				$args = array(
					'label'               => __( 'Course item', 'ancora-utils' ),
					'description'         => __( 'Course Description', 'ancora-utils' ),
					'labels'              => array(
						'name'                => _x( 'Courses', 'Post Type General Name', 'ancora-utils' ),
						'singular_name'       => _x( 'Course item', 'Post Type Singular Name', 'ancora-utils' ),
						'menu_name'           => __( 'Courses', 'ancora-utils' ),
						'parent_item_colon'   => __( 'Parent Item:', 'ancora-utils' ),
						'all_items'           => __( 'All Courses', 'ancora-utils' ),
						'view_item'           => __( 'View Item', 'ancora-utils' ),
						'add_new_item'        => __( 'Add New Course item', 'ancora-utils' ),
						'add_new'             => __( 'Add New', 'ancora-utils' ),
						'edit_item'           => __( 'Edit Item', 'ancora-utils' ),
						'update_item'         => __( 'Update Item', 'ancora-utils' ),
						'search_items'        => __( 'Search Item', 'ancora-utils' ),
						'not_found'           => __( 'Not found', 'ancora-utils' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'ancora-utils' ),
					),
					'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields'),
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'menu_icon'			  => 'dashicons-format-chat',
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => '52.5',
					'can_export'          => true,
					'has_archive'         => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'query_var'           => true,
					'capability_type'     => 'page',
					'rewrite'             => true
					);
			}
			register_post_type( $name, $args );
			trx_utils_add_rewrite_rules($name);

		} else if ($name=='lesson') {

			if ($args===false) {
				$args = array(
					'label'               => __( 'Lesson', 'ancora-utils' ),
					'description'         => __( 'Lesson Description', 'ancora-utils' ),
					'labels'              => array(
						'name'                => _x( 'Lessons', 'Post Type General Name', 'ancora-utils' ),
						'singular_name'       => _x( 'Lesson', 'Post Type Singular Name', 'ancora-utils' ),
						'menu_name'           => __( 'Lessons', 'ancora-utils' ),
						'parent_item_colon'   => __( 'Parent Item:', 'ancora-utils' ),
						'all_items'           => __( 'All lessons', 'ancora-utils' ),
						'view_item'           => __( 'View Item', 'ancora-utils' ),
						'add_new_item'        => __( 'Add New lesson', 'ancora-utils' ),
						'add_new'             => __( 'Add New', 'ancora-utils' ),
						'edit_item'           => __( 'Edit Item', 'ancora-utils' ),
						'update_item'         => __( 'Update Item', 'ancora-utils' ),
						'search_items'        => __( 'Search Item', 'ancora-utils' ),
						'not_found'           => __( 'Not found', 'ancora-utils' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'ancora-utils' ),
					),
					'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'menu_icon'			  => 'dashicons-format-chat',
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => '52.6',
					'can_export'          => true,
					'has_archive'         => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'capability_type'     => 'page'
					);
			}
			register_post_type( $name, $args );
		}
	}
}
		

// Register custom taxonomy
if (!function_exists('trx_utils_support_courses_taxonomy')) {
	add_action( 'trx_utils_custom_taxonomy', 'trx_utils_support_courses_taxonomy', 10, 2 );
	function trx_utils_support_courses_taxonomy($name, $args=false) {
		
		if ($name=='courses_group') {

			if ($args===false) {
				$args = array(
					'post_type' 		=> 'courses',
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => _x( 'Courses Groups', 'taxonomy general name', 'ancora-utils' ),
						'singular_name'     => _x( 'Courses Group', 'taxonomy singular name', 'ancora-utils' ),
						'search_items'      => __( 'Search Groups', 'ancora-utils' ),
						'all_items'         => __( 'All Groups', 'ancora-utils' ),
						'parent_item'       => __( 'Parent Group', 'ancora-utils' ),
						'parent_item_colon' => __( 'Parent Group:', 'ancora-utils' ),
						'edit_item'         => __( 'Edit Group', 'ancora-utils' ),
						'update_item'       => __( 'Update Group', 'ancora-utils' ),
						'add_new_item'      => __( 'Add New Group', 'ancora-utils' ),
						'new_item_name'     => __( 'New Group Name', 'ancora-utils' ),
						'menu_name'         => __( 'Courses Groups', 'ancora-utils' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'courses_group' )
					);
			}
			register_taxonomy( $name, $args['post_type'], $args);

		} else if ($name=='courses_tag') {

			if ($args===false) {
				$args = array(
					'post_type' 		=> 'courses',
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => _x( 'Courses Tags', 'taxonomy general name', 'ancora-utils' ),
						'singular_name'     => _x( 'Courses Tag', 'taxonomy singular name', 'ancora-utils' ),
						'search_items'      => __( 'Search Tags', 'ancora-utils' ),
						'all_items'         => __( 'All Tags', 'ancora-utils' ),
						'parent_item'       => __( 'Parent Tag', 'ancora-utils' ),
						'parent_item_colon' => __( 'Parent Tag:', 'ancora-utils' ),
						'edit_item'         => __( 'Edit Tag', 'ancora-utils' ),
						'update_item'       => __( 'Update Tag', 'ancora-utils' ),
						'add_new_item'      => __( 'Add New Tag', 'ancora-utils' ),
						'new_item_name'     => __( 'New Tag Name', 'ancora-utils' ),
						'menu_name'         => __( 'Courses Tags', 'ancora-utils' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'courses_tag' )
				);
			}
			register_taxonomy( $name, $args['post_type'], $args);
		}
	}
}
?>