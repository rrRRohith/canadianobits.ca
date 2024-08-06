<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_single_standard_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_single_standard_theme_setup', 1 );
	function ancora_template_single_standard_theme_setup() {
		ancora_add_template(array(
			'layout' => 'single-standard',
			'mode'   => 'single',
			'need_content' => true,
			'need_terms' => true,
			'title'  => esc_html__('Single standard', 'blessing'),
			'thumb_title'  => esc_html__('Fullwidth image', 'blessing'),
			'w'		 => 1150,
			'h'		 => 647
		));
	}
}

// Template output
if ( !function_exists( 'ancora_template_single_standard_output' ) ) {
	function ancora_template_single_standard_output($post_options, $post_data) {
		$post_data['post_views']++;
		$avg_author = 0;
		$avg_users  = 0;
		if (!$post_data['post_protected'] && $post_options['reviews'] && ancora_get_custom_option('show_reviews')=='yes') {
			$avg_author = $post_data['post_reviews_author'];
			$avg_users  = $post_data['post_reviews_users'];
		}
		$show_title = ancora_get_custom_option('show_post_title')=='yes' && (ancora_get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));
		$title_tag = ancora_get_custom_option('show_page_top')=='yes' && ancora_get_custom_option('show_page_title')=='yes' ? 'h3' : 'h1';

		ancora_open_wrapper('<article class="'
				. join(' ', get_post_class('itemscope'
					. ' post_item post_item_single'
					. ' post_featured_' . esc_attr($post_options['post_class'])
					. ' post_format_' . esc_attr($post_data['post_format'])))
				. '"'
				. ' itemscope itemtype="//schema.org/'.($avg_author > 0 || $avg_users > 0 ? 'Review' : 'Article')
				. '">');

		if ($show_title && $post_options['location'] == 'center' && (ancora_get_custom_option('show_page_top')=='no' || ancora_get_custom_option('show_page_title')=='no')) {
			?>
			<<?php echo esc_attr($title_tag); ?> itemprop="<?php ancora_show_layout($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'name'); ?>" class="post_title entry-title"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php ancora_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
		<?php
		}

		if (!$post_data['post_protected'] && (
			!empty($post_options['dedicated']) ||
			(ancora_get_custom_option('show_featured_image')=='yes' && $post_data['post_thumb'])	
		)) {
			?>
			<section class="post_featured">
			<?php
			if (!empty($post_options['dedicated'])) {
				ancora_show_layout($post_options['dedicated']);
			} else {
				ancora_enqueue_popup();
				?>
				<div class="post_thumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
					<a class="hover_icon hover_icon_view" href="<?php echo esc_url($post_data['post_attachment']); ?>" title="<?php echo esc_attr($post_data['post_title']); ?>"><?php ancora_show_layout($post_data['post_thumb']); ?></a>
				</div>
				<?php 
			}
			?>
			</section>
			<?php
		}


		if ($show_title) {
			?>
			<<?php echo esc_attr($title_tag); ?> itemprop="<?php ancora_show_layout($avg_author > 0 || $avg_users > 0 ? 'itemReviewed' : 'name'); ?>" class="post_title entry-title"><?php ancora_show_layout($post_data['post_title']); ?></<?php echo esc_html($title_tag); ?>>
			<?php 
		}

		if (!$post_data['post_protected'] && ancora_get_custom_option('show_post_info')=='yes') {
			$info_parts = array(
                'snippets' => true,	// For singular post/page/course/team etc.
                'date' => true,
                'author' => false,
                'terms' => false,
                'counters' => true,
            );
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
			global $ANCORA_GLOBALS;
			if (function_exists('ancora_sc_reviews_placeholder') && ancora_strpos($post_data['post_content'], ancora_sc_reviews_placeholder())===false) $post_data['post_content'] = do_shortcode('[trx_reviews]') . ($post_data['post_content']);
            if(function_exists('ancora_sc_gap_wrapper')){
                ancora_show_layout(ancora_sc_gap_wrapper(ancora_sc_reviews_wrapper($post_data['post_content'])));
            } else{
                ancora_show_layout(($post_data['post_content']));
            }
			require(ancora_get_file_dir('templates/parts/single-pagination.php'));
            ?>

            <?php
			if ( ancora_get_custom_option('show_post_tags') == 'yes' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links)) {
				?>
                <div class="post_info post_info_bottom">
                    <span class="post_info_item post_info_tags"><?php esc_html_e('Categories:', 'blessing'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_links); ?></span><br>
					<span class="post_info_item post_info_tags"><?php esc_html_e('Tags:', 'blessing'); ?> <?php echo join(', ', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_links); ?></span>
                </div>
				<?php
			}
            ?>

        <?php
		} 
		if (!$post_data['post_protected'] && $post_data['post_edit_enable']) {
			require(ancora_get_file_dir('templates/parts/editor-area.php'));
		}
			
		ancora_close_wrapper();	
			
		if (!$post_data['post_protected']) {
			require(ancora_get_file_dir('templates/parts/author-info.php'));
			require(ancora_get_file_dir('templates/parts/share.php'));
		}

		$sidebar_present = !ancora_sc_param_is_off(ancora_get_custom_option('show_sidebar_main'));
		if (!$sidebar_present) ancora_close_wrapper();	
		require(ancora_get_file_dir('templates/parts/related-posts.php'));
		if ($sidebar_present) ancora_close_wrapper();		

		if (!$post_data['post_protected']) {
			require(ancora_get_file_dir('templates/parts/comments.php'));
		}

		require(ancora_get_file_dir('templates/parts/views-counter.php'));
	}
}
?>