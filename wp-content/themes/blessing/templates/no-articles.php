<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_no_articles_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_no_articles_theme_setup', 1 );
	function ancora_template_no_articles_theme_setup() {
		ancora_add_template(array(
			'layout' => 'no-articles',
			'mode'   => 'internal',
			'title'  => esc_html__('No articles found', 'blessing'),
			'w'		 => null,
			'h'		 => null
		));
	}
}

// Template output
if ( !function_exists( 'ancora_template_no_articles_output' ) ) {
	function ancora_template_no_articles_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php esc_html_e('No posts found', 'blessing'); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria.', 'blessing' ); ?></p>
				<p><?php echo sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'blessing'), esc_url( home_url( '/' ) ), get_bloginfo()); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'blessing'); ?></p>
				<?php echo do_shortcode('[trx_search open="fixed"]'); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>