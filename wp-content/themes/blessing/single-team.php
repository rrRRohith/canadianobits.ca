<?php
/*
Template Name: Team member
*/

get_header();

$single_style = 'single-team';

while ( have_posts() ) { the_post();

	// Move ancora_set_post_views to the javascript - counter will work under cache system
	if (ancora_get_custom_option('use_ajax_views_counter')=='no') {
        do_action('trx_utils_filter_set_post_views', get_the_ID());
	}

	ancora_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !ancora_sc_param_is_off(ancora_get_custom_option('show_sidebar_main')),
			'content' => ancora_get_template_property($single_style, 'need_content'),
			'terms_list' => ancora_get_template_property($single_style, 'need_terms')
		)
	);

}

get_footer();
?>