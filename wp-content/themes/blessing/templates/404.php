<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_404_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_404_theme_setup', 1 );
	function ancora_template_404_theme_setup() {
		ancora_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			),
			'w'		 => null,
			'h'		 => null
			));
	}
}

// Template output
if ( !function_exists( 'ancora_template_404_output' ) ) {
	function ancora_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<h1 class="page_title"><?php esc_html_e( '404', 'blessing' ); ?></h1>
				<h4 class="page_subtitle"><?php esc_html_e('This Page Could Not Be Found!', 'blessing'); ?></h4>
				<p class="page_description"><?php echo sprintf( __('Can\'t find what you need? Take a moment<br> and do a search below or start from our <a href="%s">homepage</a>.', 'blessing'), esc_url( home_url( '/' ) ) ); ?></p>
				<div class="page_search"><?php if (function_exists('ancora_require_shortcode')) echo do_shortcode('[trx_search style="flat" open="fixed" title="'.esc_html__('To search type and hit enter', 'blessing').'"]'); ?></div>
			</div>
		</article>
		<?php
	}
}
?>