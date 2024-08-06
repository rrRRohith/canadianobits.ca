<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_single_portfolio_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_single_portfolio_theme_setup', 1 );
	function ancora_template_single_portfolio_theme_setup() {
		ancora_add_template(array(
			'layout' => 'single-portfolio',
			'mode'   => 'single',
			'need_content' => true,
			'need_terms' => true,
			'title'  => esc_html__('Portfolio item', 'blessing'),
			'thumb_title'  => esc_html__('Fullsize image', 'blessing'),
			'w'		 => 1150,
			'h'		 => null,
			'h_crop' => 455
		));
	}
}

// Template output
if ( !function_exists( 'ancora_template_single_portfolio_output' ) ) {
	function ancora_template_single_portfolio_output($post_options, $post_data) {
		$post_data['post_views']++;
		$avg_author = 0;
		$avg_users  = 0;
		if (!$post_data['post_protected'] && $post_options['reviews'] && ancora_get_custom_option('show_reviews')=='yes') {
			$avg_author = $post_data['post_reviews_author'];
			$avg_users  = $post_data['post_reviews_users'];
		}
		$show_title = ancora_get_custom_option('show_post_title')=='yes' && (ancora_get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));

		ancora_open_wrapper('<article class="'
				. join(' ', get_post_class('itemscope'
					. ' post_item'
					. ' post_featured_' . esc_attr($post_options['post_class'])
					. ' post_format_' . esc_attr($post_data['post_format'])))
				. '"'
				. ' itemscope itemtype="//schema.org/'.($avg_author > 0 || $avg_users > 0 ? 'Review' : 'Article')
				. '">');

		require(ancora_get_file_dir('templates/parts/prev-next-posts.php'));

		if ($show_title) {
			?>
			<h1 itemprop="<?php ancora_show_layout($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'name'); ?>" class="post_title entry-title"><?php ancora_show_layout($post_data['post_title']); ?></h1>
			<?php
		}

		if (!$post_data['post_protected'] && ancora_get_custom_option('show_post_info')=='yes') {
			require(ancora_get_file_dir('templates/parts/post-info.php'));
		}
        if (function_exists('ancora_reviews_theme_setup')) {
            require(ancora_get_file_dir('templates/parts/reviews-block.php'));
        }

		ancora_open_wrapper('<section class="post_content'.(!$post_data['post_protected'] && $post_data['post_edit_enable'] ? ' '.esc_attr('post_content_editor_present') : '').'" itemprop="'.($avg_author > 0 || $avg_users > 0 ? 'reviewBody' : 'articleBody').'">');
			
		// Post content
		if ($post_data['post_protected']) { 
			ancora_show_layout($post_data['post_excerpt']);
			echo get_the_password_form(); 
		} else {
			if (function_exists('ancora_sc_reviews_placeholder') && ancora_strpos($post_data['post_content'], ancora_sc_reviews_placeholder())===false) $post_data['post_content'] = do_shortcode('[trx_reviews]') . ($post_data['post_content']);
            if(function_exists('ancora_sc_gap_wrapper')){
                ancora_show_layout(ancora_sc_gap_wrapper(ancora_sc_reviews_wrapper($post_data['post_content'])));
            } else{
                ancora_show_layout(($post_data['post_content']));
            }
			require(ancora_get_file_dir('templates/parts/single-pagination.php'));
			if ( ancora_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
				?>
				<div class="post_info">
					<span class="post_info_item post_info_tags"><?php esc_html_e('in', 'blessing'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
				</div>
				<?php
			} 
		}

		if (!$post_data['post_protected'] && $post_data['post_edit_enable']) {
			require(ancora_get_file_dir('templates/parts/editor-area.php'));
		}

		ancora_close_wrapper();	

		if (!$post_data['post_protected']) {
			require(ancora_get_file_dir('templates/parts/author-info.php'));
			require(ancora_get_file_dir('templates/parts/share.php'));
			require(ancora_get_file_dir('templates/parts/related-posts.php'));
			require(ancora_get_file_dir('templates/parts/comments.php'));
		}
	
		ancora_close_wrapper();	

		require(ancora_get_file_dir('templates/parts/views-counter.php'));
	}
}
?>