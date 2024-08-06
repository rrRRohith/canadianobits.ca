<?php
/*
 * Support for the Testimonials
 */



// Register custom post type
if (!function_exists('trx_utils_support_testimonials_post_type')) {
	add_action( 'trx_utils_custom_post_type', 'trx_utils_support_testimonials_post_type', 10, 2 );
	function trx_utils_support_testimonials_post_type($name, $args=false) {
		if ($name=='testimonial') {
			if ($args===false) {
				$args = array(
					'label'               => esc_html__( 'Testimonial', 'ancora-utils' ),
					'description'         => esc_html__( 'Testimonial Description', 'ancora-utils' ),
					'labels'              => array(
						'name'                => esc_html__( 'Testimonials', 'ancora-utils' ),
						'singular_name'       => esc_html__( 'Testimonial', 'ancora-utils' ),
						'menu_name'           => esc_html__( 'Testimonials', 'ancora-utils' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'ancora-utils' ),
						'all_items'           => esc_html__( 'All Testimonials', 'ancora-utils' ),
						'view_item'           => esc_html__( 'View Item', 'ancora-utils' ),
						'add_new_item'        => esc_html__( 'Add New Testimonial', 'ancora-utils' ),
						'add_new'             => esc_html__( 'Add New', 'ancora-utils' ),
						'edit_item'           => esc_html__( 'Edit Item', 'ancora-utils' ),
						'update_item'         => esc_html__( 'Update Item', 'ancora-utils' ),
						'search_items'        => esc_html__( 'Search Item', 'ancora-utils' ),
						'not_found'           => esc_html__( 'Not found', 'ancora-utils' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ancora-utils' ),
					),
					'supports'            => array( 'title', 'editor', 'author', 'thumbnail'),
					'hierarchical'        => false,
					'public'              => false,
					'show_ui'             => true,
					'menu_icon'			  => 'dashicons-cloud',
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => '52.4',
					'can_export'          => true,
					'has_archive'         => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'capability_type'     => 'page',
					);
			}
			register_post_type( $name, $args );
		}
	}
}
		

// Register custom taxonomy
if (!function_exists('trx_utils_support_testimonials_taxonomy')) {
	add_action( 'trx_utils_custom_taxonomy', 'trx_utils_support_testimonials_taxonomy', 10, 2 );
	function trx_utils_support_testimonials_taxonomy($name, $args=false) {
		if ($name=='testimonial_group') {
			if ($args===false) {
				$args = array(
					'post_type' 		=> 'testimonial',
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Testimonials Group', 'ancora-utils' ),
						'singular_name'     => esc_html__( 'Group', 'ancora-utils' ),
						'search_items'      => esc_html__( 'Search Groups', 'ancora-utils' ),
						'all_items'         => esc_html__( 'All Groups', 'ancora-utils' ),
						'parent_item'       => esc_html__( 'Parent Group', 'ancora-utils' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'ancora-utils' ),
						'edit_item'         => esc_html__( 'Edit Group', 'ancora-utils' ),
						'update_item'       => esc_html__( 'Update Group', 'ancora-utils' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'ancora-utils' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'ancora-utils' ),
						'menu_name'         => esc_html__( 'Testimonial Group', 'ancora-utils' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'testimonial_group' )
					);
			}
			register_taxonomy( $name, $args['post_type'], $args);
		}
	}
}
?>