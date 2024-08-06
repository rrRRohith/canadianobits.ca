<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'ancora_template_test_theme_setup' ) ) {
	add_action( 'ancora_action_before_init_theme', 'ancora_template_test_theme_setup', 1 );
	function ancora_template_test_theme_setup() {
		ancora_add_template(array(
			'layout' => 'test_3',
			'template' => 'test',
			'mode'   => 'blog',
			'need_isotope' => false,
			'need_columns' => true,
			'title'  => esc_html__('Test tile /3 columns/', 'blessing'),
			'thumb_title'  => esc_html__('Test image', 'blessing'),
			'w'		 => 350,
			'h'		 => 350
		));
	}
}

// Template output
if ( !function_exists( 'ancora_template_test_output' ) ) {
	function ancora_template_test_output($post_options, $post_data) {
		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(4, empty($parts[1]) ? $post_options['columns_count'] : (int) $parts[1]));
        if(function_exists('ancora_sc_in_shortcode_blogger')){
            $tag = ancora_sc_in_shortcode_blogger(true) ? 'div' : 'article';
        } else{
            $tag = 'article';
        }
		if ($columns > 1) {
			?>
			<div class="<?php echo 'column-1_'.esc_attr($columns); ?> column_padding_bottom">
			<?php
		}
		?>
			<<?php ancora_show_layout($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['layout']); ?>
				 <?php echo ' post_format_'.esc_attr($post_data['post_format']) 
					. ($post_options['number']%2==0 ? ' even' : ' odd') 
					. ($post_options['number']==0 ? ' first' : '') 
					. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
				?>">
				
				<?php
				if ($show_title) {
					if (!isset($post_options['links']) || $post_options['links']) {
						?>
						<h4 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php ancora_show_layout($post_data['post_title']); ?></a></h4>
						<?php
					} else {
						?>
						<h4 class="post_title"><?php ancora_show_layout($post_data['post_title']); ?></h4>
						<?php
					}
				}
				?>
				
				<?php if ($post_data['post_video'] || $post_data['post_audio'] || $post_data['post_thumb'] ||  $post_data['post_gallery']) { ?>
					<div class="post_featured">
						<?php require(ancora_get_file_dir('templates/parts/post-featured.php')); ?>
					</div>
				<?php } ?>

				<div class="post_content isotope_item_content">
					
					<?php
					if (!$post_data['post_protected'] && $post_options['info']) {
						$info_parts = array('counters'=>false, 'terms'=>false, 'author' => false);
						require(ancora_get_file_dir('templates/parts/post-info.php'));
					}
					?>

					<div class="post_descr">
						<?php
						if ($post_data['post_protected']) {
							ancora_show_layout($post_data['post_excerpt']);
						} else {
							if ($post_data['post_excerpt']) {
								echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(ancora_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : ancora_get_custom_option('post_excerpt_maxlength_masonry'))).'</p>';
							}
							if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('READ MORE', 'blessing');
							if (!ancora_sc_param_is_off($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
								echo do_shortcode('[trx_button link="'.esc_url($post_data['post_link']).'"]'.($post_options['readmore']).'[/trx_button]');
							}
						}
						?>
					</div>

				</div>				<!-- /.post_content -->
			</<?php ancora_show_layout($tag); ?>>	<!-- /.post_item -->
		<?php
		if ($columns > 1) {
			?>
			</div>
			<?php
		}
	}
}
?>