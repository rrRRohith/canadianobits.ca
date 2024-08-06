<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_date_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_date_theme_setup', 1 );
	function ancora_template_date_theme_setup() {
		ancora_add_template(array(
			'layout' => 'date',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Timeline', 'blessing')
			));
	}
}

// Template output
if ( !function_exists( 'ancora_template_date_output' ) ) {
	function ancora_template_date_output($post_options, $post_data) {
		if (ancora_sc_param_is_on($post_options['scroll'])) ancora_enqueue_slider();
		require(ancora_get_file_dir('templates/parts/reviews-summary.php'));
		?>
		
		<div class="post_item sc_blogger_item
			<?php ancora_show_layout($post_options['number'] == $post_options['posts_on_page'] && !ancora_sc_param_is_on($post_options['loadmore']) ? ' sc_blogger_item_last' : ''); ?>"
			<?php ancora_show_layout($post_options['dir'] == 'horizontal' ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''); ?>>
			<div class="sc_blogger_date">
				<span class="day_month"><?php ancora_show_layout($post_data['post_date_part1']); ?></span>
				<span class="year"><?php ancora_show_layout($post_data['post_date_part2']); ?></span>
			</div>

			<div class="post_content">
				<h6 class="post_title sc_title sc_blogger_title">
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : ''); ?>
					<?php ancora_show_layout($post_data['post_title']); ?>
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '</a>' : ''); ?>
				</h6>
				
				<?php ancora_show_layout($reviews_summary); ?>
	
				<?php if (ancora_sc_param_is_on($post_options['info'])) { ?>
				<div class="post_info">
					<span class="post_info_item post_info_posted_by"><?php esc_html_e('by', 'blessing'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
					<span class="post_info_item post_info_counters">
						<?php ancora_show_layout($post_options['orderby']=='comments' || $post_options['counters']=='comments' ? esc_html__('Comments', 'blessing') : esc_html__('Views', 'blessing')); ?>
						<span class="post_info_counters_number"><?php ancora_show_layout($post_options['orderby']=='comments' || $post_options['counters']=='comments' ? $post_data['post_comments'] : $post_data['post_views']); ?></span>
					</span>
				</div>
				<?php } ?>

			</div>	<!-- /.post_content -->
		
		</div>		<!-- /.post_item -->

		<?php
		if ($post_options['number'] == $post_options['posts_on_page'] && ancora_sc_param_is_on($post_options['loadmore'])) {
		?>
			<div class="load_more"<?php ancora_show_layout($post_options['dir'] == 'horizontal' ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''); ?>></div>
		<?php
		}
	}
}
?>