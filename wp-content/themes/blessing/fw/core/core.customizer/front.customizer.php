<?php
ancora_enqueue_slider();

$theme_skin = ancora_get_custom_option('theme_skin');
$color_scheme = ancora_get_custom_option('color_scheme');
if (empty($color_scheme)) $color_scheme = 'original';
$color_scheme_list = ancora_get_list_color_schemes();
$link_color = apply_filters('ancora_filter_get_link_color', ancora_get_custom_option('link_color'));
$menu_color = apply_filters('ancora_filter_get_menu_color', ancora_get_custom_option('menu_color'));
$user_color = apply_filters('ancora_filter_get_user_color', ancora_get_custom_option('user_color'));
$body_style = ancora_get_custom_option('body_style');
$bg_color 	= ancora_get_custom_option('bg_color');
$bg_pattern = ancora_get_custom_option('bg_pattern');
$bg_image 	= ancora_get_custom_option('bg_image');

$co_style = 'co_light';	
?>
<div class="custom_options_shadow"></div>

<div id="custom_options" class="custom_options <?php echo esc_attr($co_style); ?>">

	<a href="#" id="co_toggle" class="icon-params"></a>
	
	<div class="co_header">
		<div class="co_title">
			<span><?php esc_html_e('Style switcher', 'blessing'); ?></span>
			<a href="#" id="co_theme_reset" class="co_reset icon-retweet-1" title="<?php esc_html_e('Reset to defaults', 'blessing'); ?>"><?php esc_html_e('RESET', 'blessing'); ?></a>
		</div>
	</div>

	<div id="sc_custom_scroll" class="co_options sc_scroll sc_scroll_vertical">
		<div class="sc_scroll_wrapper swiper-wrapper">
			<div class="sc_scroll_slide swiper-slide">
				<input type="hidden" id="co_site_url" name="co_site_url" value="<?php echo esc_url((home_url( '/' )) . (add_query_arg(array()))); ?>" />

				<div class="co_section">
					<div class="co_label"><?php esc_html_e('Body styles', 'blessing'); ?></div>
					<div class="co_switch_box co_switch_horizontal co_switch_columns_3<?php /* co_switch_vertical|horizontal,co_switch_columns_3|4 */ ?>" data-options="body_style">
						<div class="switcher" data-value="<?php echo esc_attr($body_style); ?>"></div>
						<a href="#" data-value="boxed"><?php esc_html_e('Boxed', 'blessing'); ?></a>
						<a href="#" data-value="wide"><?php esc_html_e('Wide', 'blessing'); ?></a>
						<a href="#" data-value="fullwide"><?php esc_html_e('Fullwide', 'blessing'); ?></a>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php esc_html_e('Color scheme', 'blessing'); ?></div>
					<div id="co_scheme_list" class="co_image_check" data-options="color_scheme">
						<?php 
						foreach($color_scheme_list as $k=>$v) {
							$scheme = ancora_get_file_url('skins/'.($theme_skin).'/images/schemes/'.($k).'.jpg');
							?>
							<a href="#" id="scheme_<?php echo esc_attr($k); ?>" class="co_scheme_wrapper<?php ancora_show_layout($color_scheme==$k ? ' active' : ''); ?>" style="background-image: url(<?php echo esc_url($scheme); ?>)" data-value="<?php echo esc_attr($k); ?>"><span><?php echo esc_attr($v); ?></span></a>
							<?php
						}
						?>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php esc_html_e('Color settings', 'blessing'); ?></div>
					<div class="co_colorpic_list">
						<div class="iColorPicker" data-options="link_color" data-value="<?php echo esc_attr($link_color); ?>"><span><?php esc_html_e('Link color', 'blessing'); ?></span></div>
						<div class="iColorPicker" data-options="menu_color" data-value="<?php echo esc_attr($menu_color); ?>"><span><?php esc_html_e('Menu color', 'blessing'); ?></span></div>
						<div class="iColorPicker" data-options="user_color" data-value="<?php echo esc_attr($user_color); ?>"><span><?php esc_html_e('User color', 'blessing'); ?></span></div>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php esc_html_e('Background pattern', 'blessing'); ?></div>
					<div id="co_bg_pattern_list" class="co_image_check" data-options="bg_pattern">
						<?php
						for ($i=1; $i<=5; $i++) {
							$pattern = ancora_get_file_url('images/bg/pattern_'.intval($i).'.jpg');
							$thumb   = ancora_get_file_url('images/bg/pattern_'.intval($i).'_thumb.jpg');
							?>
							<a href="#" id="pattern_<?php echo esc_attr($i); ?>" class="co_pattern_wrapper<?php ancora_show_layout($bg_pattern==$i ? ' active' : ''); ?>" style="background-image: url(<?php echo esc_url($thumb); ?>)"><span class="co_bg_preview" style="background-image: url(<?php echo esc_url($pattern); ?>)"></span></a>
							<?php
						}
						?>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php esc_html_e('Background image', 'blessing'); ?></div>
					<div id="co_bg_images_list" class="co_image_check" data-options="bg_image">
						<?php
						for ($i=1; $i<=3; $i++) {
							$image = ancora_get_file_url('images/bg/image_'.intval($i).'.jpg');
							$thumb = ancora_get_file_url('images/bg/image_'.intval($i).'_thumb.jpg');
							?>
							<a href="#" id="pattern_<?php echo esc_attr($i); ?>" class="co_image_wrapper<?php ancora_show_layout($bg_image==$i ? ' active' : ''); ?>" style="background-image: url(<?php echo esc_url($thumb); ?>)"><span class="co_bg_preview" style="background-image: url(<?php echo esc_url($image); ?>)"></span></a>
							<?php
						}
						?>
					</div>
				</div>

			</div><!-- .sc_scroll_slide -->
		</div><!-- .sc_scroll_wrapper -->
		<div id="sc_custom_scroll_bar" class="sc_scroll_bar sc_scroll_bar_vertical sc_custom_scroll_bar"></div>
	</div><!-- .sc_scroll -->
</div><!-- .custom_options -->