<?php
/**
 * The Sidebar containing the main widget areas.
 */

$sidebar_show  = ancora_get_custom_option('show_sidebar_main');
$sidebar_parts = explode(' ', $sidebar_show);
$sidebar_tint  = !empty($sidebar_parts[0]) ? $sidebar_parts[0] : 'light';
$sidebar_style = !empty($sidebar_parts[1]) ? $sidebar_parts[1] : $sidebar_tint;

if (!ancora_sc_param_is_off($sidebar_show)) {
	?>
	<div class="sidebar widget_area bg_tint_<?php echo esc_attr($sidebar_tint); ?> sidebar_style_<?php echo esc_attr($sidebar_style); ?>" role="complementary">
		<?php
		do_action( 'before_sidebar' );
		global $ANCORA_GLOBALS;
		if (!empty($ANCORA_GLOBALS['reviews_markup']))
			echo '<aside class="column-1_1 widget widget_reviews">' . ($ANCORA_GLOBALS['reviews_markup']) . '</aside>';
		$ANCORA_GLOBALS['current_sidebar'] = 'main';
        $ancora_sidebar_name = ancora_get_custom_option('sidebar_main');
        if ( is_active_sidebar( $ancora_sidebar_name ) ) {
            dynamic_sidebar( $ancora_sidebar_name );
        }
		do_action( 'after_sidebar' );
		?>
	</div> <!-- /.sidebar -->
	<?php
}
?>