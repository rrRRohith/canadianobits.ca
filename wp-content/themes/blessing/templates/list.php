<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_list_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_list_theme_setup', 1 );
	function ancora_template_list_theme_setup() {
		ancora_add_template(array(
			'layout' => 'list',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: List', 'blessing')
			));
	}
}

// Template output
if ( !function_exists( 'ancora_template_list_output' ) ) {
	function ancora_template_list_output($post_options, $post_data) {
		$title = '<li class="post_item sc_blogger_item post_title sc_title sc_blogger_title">'
			. '<div class="post_title sc_title sc_blogger_title">'
			. (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : '')
			. ($post_data['post_title'])
			. (!isset($post_options['links']) || $post_options['links'] ? '</a>' : '')
			. '</div>'
			. '</li>';
		ancora_show_layout($title);
	}
}
?>