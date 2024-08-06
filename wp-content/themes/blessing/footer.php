<?php
/**
 * The template for displaying the footer.
 */

global $ANCORA_GLOBALS;

				ancora_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (ancora_get_custom_option('body_style')!='fullscreen') ancora_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
            // Google map
            if ( ancora_get_custom_option('show_googlemap')=='yes' ) {

                $map_address = ancora_get_custom_option('googlemap_address');
                $map_description = ancora_get_custom_option('googlemap_description');
                $map_latlng  = ancora_get_custom_option('googlemap_latlng');
                $map_zoom    = ancora_get_custom_option('googlemap_zoom');
                $map_style   = ancora_get_custom_option('googlemap_style');
                $map_height  = ancora_get_custom_option('googlemap_height');
                if (!empty($map_address) || !empty($map_latlng)) {
                    echo do_shortcode('[trx_googlemap'
                        . (!empty($map_address) ? ' address="'.esc_attr($map_address).'"' : '')
                        . (!empty($map_description) ? ' description="'.esc_attr($map_description).'"' : '')
                        . (!empty($map_latlng)  ? ' latlng="'.esc_attr($map_latlng).'"' : '')
                        . (!empty($map_style)   ? ' style="'.esc_attr($map_style).'"' : '')
                        . (!empty($map_zoom)    ? ' zoom="'.esc_attr($map_zoom).'"' : '')
                        . (!empty($map_height)  ? ' height="'.esc_attr($map_height).'"' : '')
                        . ']');
                }
            }
			// User custom footer
			if (ancora_get_custom_option('show_user_footer') == 'yes') {
				$user_footer = ancora_strclear(ancora_get_custom_option('user_footer_content'), 'p');
				if (!empty($user_footer)) {
					$user_footer = ancora_substitute_all($user_footer);
					?>
					<footer class="user_footer_wrap"><?php ancora_show_layout($user_footer); ?></footer>
					<?php
				}
			}

            // Additional footer sidebar
            $footer_show  = ancora_get_custom_option('show_sidebar_footer2');
            $footer_parts = explode(' ', $footer_show);
            $footer_tint  = !empty($footer_parts[0]) ? $footer_parts[0] : 'dark';
            $footer_style = !empty($footer_parts[1]) ? $footer_parts[1] : $footer_tint;
            if (!ancora_sc_param_is_off($footer_show)) {
                $ANCORA_GLOBALS['current_sidebar'] = 'footer';
                ?>
                <footer class="footer_wrap bg_tint_<?php echo esc_attr($footer_tint); ?> footer_style_<?php echo esc_attr($footer_style); ?> widget_area">
                    <div class="content_wrap">
                        <div class="columns_wrap">
                            <?php
                            do_action( 'before_sidebar' );
                            if ( is_active_sidebar( ancora_get_custom_option('sidebar_footer2') ) ) { //remove it so SB can work
                                $ancora_sidebar_name = ancora_get_custom_option('sidebar_footer2');
                                if ( is_active_sidebar( $ancora_sidebar_name ) ) {
                                    dynamic_sidebar( $ancora_sidebar_name );
                                }
                            }
                            do_action( 'after_sidebar' );
                            ?>
                        </div>	<!-- /.columns_wrap -->
                    </div>	<!-- /.content_wrap -->
                </footer>	<!-- /.footer_wrap -->
            <?php
            }

			// Footer sidebar
			$footer_show  = ancora_get_custom_option('show_sidebar_footer');
			$footer_parts = explode(' ', $footer_show);
			$footer_tint  = !empty($footer_parts[0]) ? $footer_parts[0] : 'dark';
			$footer_style = !empty($footer_parts[1]) ? $footer_parts[1] : $footer_tint;
			if (!ancora_sc_param_is_off($footer_show)) {
				$ANCORA_GLOBALS['current_sidebar'] = 'footer';
				?>
				<footer class="footer_wrap bg_tint_<?php echo esc_attr($footer_tint); ?> footer_style_<?php echo esc_attr($footer_style); ?> widget_area">
					<div class="content_wrap">
						<div class="columns_wrap">
						<?php
						do_action( 'before_sidebar' );
                        $ancora_sidebar_name = ancora_get_custom_option('sidebar_footer');
                        if ( is_active_sidebar( $ancora_sidebar_name ) ) {
                            dynamic_sidebar( $ancora_sidebar_name );
                        }
						do_action( 'after_sidebar' );
						?>
						</div>	<!-- /.columns_wrap -->
					</div>	<!-- /.content_wrap -->
				</footer>	<!-- /.footer_wrap -->
			<?php
			}

			// Footer Testimonials stream
			$show = ancora_get_custom_option('show_testimonials_in_footer');
			if (!ancora_sc_param_is_off($show)) {
				$count = max(1, ancora_get_custom_option('testimonials_count'));
				$data = do_shortcode('[trx_testimonials count="'.esc_attr($count).'"][/trx_testimonials]');
				if ($data) {
					$bg_image = ancora_get_custom_option('testimonials_bg_image');
					$bg_color = apply_filters('ancora_filter_get_menu_color', ancora_get_custom_option('testimonials_bg_color'));
					$bg_overlay = max(0, min(1, ancora_get_custom_option('testimonials_bg_overlay')));
					if ($bg_overlay > 0) {
						$rgb = ancora_hex2rgb($bg_color);
						$over_color = 'rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.(float)$bg_overlay.')';
					}
					?>
					<footer class="testimonials_wrap sc_section bg_tint_<?php echo esc_attr($show); ?>" style="<?php ancora_show_layout(($bg_image ? 'background-image: url('.esc_url($bg_image).');' : '') . ($bg_color ? 'background-color:'.esc_attr($bg_color).';' : '')); ?>">
						<div class="sc_section_overlay" data-bg_color="<?php echo esc_attr($bg_color); ?>" data-overlay="<?php echo esc_attr($bg_overlay); ?>"<?php ancora_show_layout($bg_overlay > 0 ? ' style="background-color:'. esc_attr($over_color).';"' : ''); ?>>
							<div class="content_wrap"><?php ancora_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Footer Twitter stream
			$show = ancora_get_custom_option('show_twitter_in_footer');
			if (!ancora_sc_param_is_off($show)) {
				$count = max(1, ancora_get_custom_option('twitter_count'));
				$data = do_shortcode('[trx_twitter count="'.esc_attr($count).'"]');
				if ($data) {
					$bg_image = ancora_get_custom_option('twitter_bg_image');
					$bg_color = apply_filters('ancora_filter_get_link_color', ancora_get_custom_option('twitter_bg_color'));
					$bg_overlay = max(0, min(1, ancora_get_custom_option('twitter_bg_overlay')));
					if ($bg_overlay > 0) {
						$rgb = ancora_hex2rgb($bg_color);
						$over_color = 'rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.(float)$bg_overlay.')';
					}
					?>
					<footer class="twitter_wrap sc_section bg_tint_<?php echo esc_attr($show); ?>" style="<?php ancora_show_layout(($bg_image ? 'background-image: url('.esc_url($bg_image).');' : '') . ($bg_color ? 'background-color:'.esc_url($bg_color).';' : '')); ?>">
						<div class="sc_section_overlay" data-bg_color="<?php echo esc_attr($bg_color); ?>" data-overlay="<?php echo esc_attr($bg_overlay); ?>"<?php ancora_show_layout($bg_overlay > 0 ? ' style="background-color:'. esc_attr($over_color).';"' : ''); ?>>
							<div class="content_wrap"><?php ancora_show_layout($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}

			// Footer contacts
			if (($contacts_style = ancora_get_custom_option('show_contacts_in_footer')) != 'hide'  ) {
				$address_1 = ancora_get_theme_option('contact_address_1');
				$address_2 = ancora_get_theme_option('contact_address_2');
				$phone = ancora_get_theme_option('contact_phone');
				$fax = ancora_get_theme_option('contact_fax');
				if (!empty($address_1) || !empty($address_2) || !empty($phone) || !empty($fax)) {
					?>
					<footer class="contacts_wrap bg_tint_<?php echo esc_attr($contacts_style); ?> contacts_style_<?php echo esc_attr($contacts_style); ?>">
						<div class="content_wrap">
							    <div class="logo">
								    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php ancora_show_layout($ANCORA_GLOBALS['logo_footer'] ? '<img src="'.esc_url($ANCORA_GLOBALS['logo_footer']).'" alt="'.esc_attr__('img', 'blessing').'">' : ''); ?><?php ancora_show_layout($ANCORA_GLOBALS['logo_text'] ? '<span class="logo_text">'.($ANCORA_GLOBALS['logo_text']).'</span>' : ''); ?></a>
    							</div>
							<div class="contacts_address">
								<address class="address_right">
									<?php echo esc_html__('Phone:', 'blessing') . ' ' . ($phone); ?><br>
									<?php echo esc_html__('Fax:', 'blessing') . ' ' . ($fax); ?>
								</address>
								<address class="address_left">
									<?php ancora_show_layout($address_2); ?><br>
									<?php ancora_show_layout($address_1); ?>
								</address>
							</div>
							<?php echo do_shortcode('[trx_socials size="big"][/trx_socials]'); ?>
						</div>	<!-- /.content_wrap -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}

			// Copyright area
			if (ancora_get_custom_option('show_copyright_in_footer')=='yes') {
			?> 
				<div class="copyright_wrap bottom_cont">
					<div class="content_wrap">
						<?php ancora_show_layout(do_shortcode(str_replace(array('{{Y}}', '{Y}'), date('Y'), ancora_get_custom_option('footer_copyright')))); ?>
					</div>
				</div>
			<?php } ?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->

<?php
if (ancora_get_custom_option('show_theme_customizer')=='yes') {
	require_once( ancora_get_file_dir('core/core.customizer/front.customizer.php') );
}
?>

<div class="custom_html_section">
<?php ancora_show_layout(ancora_get_custom_option('custom_code')); ?>
</div>

<?php ancora_show_layout(ancora_get_custom_option('gtm_code2')); ?>

<?php wp_footer(); ?>

</body>
</html>