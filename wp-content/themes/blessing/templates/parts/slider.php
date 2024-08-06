<?php
if (ancora_get_custom_option('show_slider')=='yes') {
	$slider = ancora_get_custom_option('slider_engine');
	$slider_alias = $slider_ids = $slider_html = '';

	if ($slider == 'revo' && ancora_exists_revslider()) {
		$slider_alias = ancora_get_custom_option('slider_alias');
		if (!empty($slider_alias)) $slider_html = do_shortcode('[rev_slider '.esc_attr($slider_alias).']');

	}  else if ($slider == 'swiper') {
		$slider_pagination = ancora_get_custom_option("slider_pagination");
		$slider_alias = ancora_get_custom_option("slider_category");
		$slider_orderby = ancora_get_custom_option("slider_orderby");
		$slider_order = ancora_get_custom_option("slider_order");
		$slider_count = $slider_ids = ancora_get_custom_option("slider_posts");

		if (ancora_strpos($slider_ids, ',')!==false) {
			$slider_alias = '';
			$slider_count = 0;
		} else {
			$slider_ids = '';
			if (empty($slider_count)) $slider_count = 3;
		}

		$slider_interval = ancora_get_custom_option("slider_interval");

		if ($slider_count > 0 || !empty($slider_ids)) {
			$slider_html = do_shortcode('[trx_slider'
							. ' custom="no"'
							. ' crop="no"'
							. ' controls="0"'
							. ' engine="'.esc_attr($slider).'"'
							. ' height="'.max(100, ancora_get_custom_option('slider_height')).'"'
							. ' titles="'.esc_attr(ancora_get_custom_option("slider_infobox")).'"'
							. ($slider_interval		? ' interval="'.esc_attr($slider_interval).'"' : '') 
							. ($slider_alias		? ' cat="'.esc_attr($slider_alias).'"' : '') 
							. ($slider_ids			? ' ids="'.esc_attr($slider_ids).'"' : '') 
							. ($slider_count		? ' count="'.esc_attr($slider_count).'"' : '') 
							. ($slider_orderby		? ' orderby="'.esc_attr($slider_orderby).'"' : '') 
							. ($slider_order		? ' order="'.esc_attr($slider_order).'"' : '') 
							. ($slider_pagination	? ' pagination="'.esc_attr($slider_pagination).'"' : '') 
							. '][/trx_slider]');
		}
	}

	// if slider selected
	if (!empty($slider_html)) {
		?>
		<section class="slider_wrap slider_<?php echo esc_attr(ancora_get_custom_option('slider_display')); ?> slider_engine_<?php echo esc_attr($slider); ?> slider_alias_<?php echo esc_attr($slider_alias); ?>">
			<?php ancora_show_layout($slider_html); ?>
		</section>
		<?php 
	}
}
?>