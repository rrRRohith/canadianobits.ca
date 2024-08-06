<?php
/*
 * Support for the Attachment's media folders
 */



// Register custom taxonomy
if (!function_exists('trx_utils_support_attachment_taxonomy')) {
	add_action( 'trx_utils_custom_taxonomy', 'trx_utils_support_attachment_taxonomy', 10, 2 );
	function trx_utils_support_attachment_taxonomy($name, $args=false) {
		if ($name=='media_folder') {
			if ($args===false) {
				$args = array(
					'post_type' 		=> 'attachment',
					'hierarchical' 		=> true,
					'labels' 			=> array(
						'name'              => esc_html__('Media Folders', 'ancora-utils'),
						'singular_name'     => esc_html__('Media Folder', 'ancora-utils'),
						'search_items'      => esc_html__('Search Media Folders', 'ancora-utils'),
						'all_items'         => esc_html__('All Media Folders', 'ancora-utils'),
						'parent_item'       => esc_html__('Parent Media Folder', 'ancora-utils'),
						'parent_item_colon' => esc_html__('Parent Media Folder:', 'ancora-utils'),
						'edit_item'         => esc_html__('Edit Media Folder', 'ancora-utils'),
						'update_item'       => esc_html__('Update Media Folder', 'ancora-utils'),
						'add_new_item'      => esc_html__('Add New Media Folder', 'ancora-utils'),
						'new_item_name'     => esc_html__('New Media Folder Name', 'ancora-utils'),
						'menu_name'         => esc_html__('Media Folders', 'ancora-utils'),
					),
					'show_ui'           => true,
					'show_admin_column'	=> true,
					'query_var'			=> true,
					'rewrite' 			=> array( 'slug' => 'media_folder' )
					);
			}
			register_taxonomy( $name, $args['post_type'], $args);
		}
	}
}
?>