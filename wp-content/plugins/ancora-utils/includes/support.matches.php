<?php
/*
 * Support for the Matches and Players
 */



// Register custom post type
if (!function_exists('trx_utils_support_matches_post_type')) {
	add_action( 'trx_utils_custom_post_type', 'trx_utils_support_matches_post_type', 10, 2 );
	function trx_utils_support_matches_post_type($name, $args=false) {
		if ($name=='matches') {
			if ($args===false) {
				$args = array(
					'label'               => esc_html__( 'Matches', 'ancora-utils' ),
					'description'         => esc_html__( 'Matches Description', 'ancora-utils' ),
					'labels'              => array(
						'name'                => esc_html__( 'Matches', 'ancora-utils' ),
						'singular_name'       => esc_html__( 'Matches', 'ancora-utils' ),
						'menu_name'           => esc_html__( 'Matches', 'ancora-utils' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'ancora-utils' ),
						'all_items'           => esc_html__( 'All Matches', 'ancora-utils' ),
						'view_item'           => esc_html__( 'View Item', 'ancora-utils' ),
						'add_new_item'        => esc_html__( 'Add New Match', 'ancora-utils' ),
						'add_new'             => esc_html__( 'Add New', 'ancora-utils' ),
						'edit_item'           => esc_html__( 'Edit Item', 'ancora-utils' ),
						'update_item'         => esc_html__( 'Update Item', 'ancora-utils' ),
						'search_items'        => esc_html__( 'Search Item', 'ancora-utils' ),
						'not_found'           => esc_html__( 'Not found', 'ancora-utils' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ancora-utils' ),
					),
					'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields'),
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'menu_icon'			  => 'dashicons-awards',
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => '52.9',
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

		} else if ($name=='players') {
			if ($args===false) {
				$args = array(
					'label'               => esc_html__( 'Players', 'ancora-utils' ),
					'description'         => esc_html__( 'Players Description', 'ancora-utils' ),
					'labels'              => array(
						'name'                => esc_html__( 'Players', 'ancora-utils' ),
						'singular_name'       => esc_html__( 'Players', 'ancora-utils' ),
						'menu_name'           => esc_html__( 'Players', 'ancora-utils' ),
						'parent_item_colon'   => esc_html__( 'Parent Item:', 'ancora-utils' ),
						'all_items'           => esc_html__( 'All Players', 'ancora-utils' ),
						'view_item'           => esc_html__( 'View Item', 'ancora-utils' ),
						'add_new_item'        => esc_html__( 'Add New Player', 'ancora-utils' ),
						'add_new'             => esc_html__( 'Add New', 'ancora-utils' ),
						'edit_item'           => esc_html__( 'Edit Item', 'ancora-utils' ),
						'update_item'         => esc_html__( 'Update Item', 'ancora-utils' ),
						'search_items'        => esc_html__( 'Search Item', 'ancora-utils' ),
						'not_found'           => esc_html__( 'Not found', 'ancora-utils' ),
						'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'ancora-utils' ),
					),
					'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields'),
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'menu_icon'			  => 'dashicons-groups',
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => '52.8',
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
		}
	}
}
		

// Register custom taxonomy
if (!function_exists('trx_utils_support_matches_taxonomy')) {
	add_action( 'trx_utils_custom_taxonomy', 'trx_utils_support_matches_taxonomy', 10, 2 );
	function trx_utils_support_matches_taxonomy($name, $args=false) {
		if ($name=='matches_group') {
			if ($args===false) {
				$args = array(
					'post_type' 		=> 'matches',
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Matches Group', 'ancora-utils' ),
						'singular_name'     => esc_html__( 'Group', 'ancora-utils' ),
						'search_items'      => esc_html__( 'Search Groups', 'ancora-utils' ),
						'all_items'         => esc_html__( 'All Groups', 'ancora-utils' ),
						'parent_item'       => esc_html__( 'Parent Group', 'ancora-utils' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'ancora-utils' ),
						'edit_item'         => esc_html__( 'Edit Group', 'ancora-utils' ),
						'update_item'       => esc_html__( 'Update Group', 'ancora-utils' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'ancora-utils' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'ancora-utils' ),
						'menu_name'         => esc_html__( 'Categories', 'ancora-utils' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'matches_group' ),
					);
			}
			register_taxonomy( $name, $args['post_type'], $args);

		} else if ($name=='players_group') {
			if ($args===false) {
				$args = array(
					'post_type' 		=> 'players',
					'hierarchical'      => true,
					'labels'            => array(
						'name'              => esc_html__( 'Players Group', 'ancora-utils' ),
						'singular_name'     => esc_html__( 'Group', 'ancora-utils' ),
						'search_items'      => esc_html__( 'Search Groups', 'ancora-utils' ),
						'all_items'         => esc_html__( 'All Groups', 'ancora-utils' ),
						'parent_item'       => esc_html__( 'Parent Group', 'ancora-utils' ),
						'parent_item_colon' => esc_html__( 'Parent Group:', 'ancora-utils' ),
						'edit_item'         => esc_html__( 'Edit Group', 'ancora-utils' ),
						'update_item'       => esc_html__( 'Update Group', 'ancora-utils' ),
						'add_new_item'      => esc_html__( 'Add New Group', 'ancora-utils' ),
						'new_item_name'     => esc_html__( 'New Group Name', 'ancora-utils' ),
						'menu_name'         => esc_html__( 'Categories', 'ancora-utils' ),
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'players_group' ),
					);
			}
			register_taxonomy( $name, $args['post_type'], $args);
		}
	}
}
?>