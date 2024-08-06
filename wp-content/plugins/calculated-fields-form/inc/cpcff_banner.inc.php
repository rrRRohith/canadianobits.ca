<?php
global $codepeople_promote_banner_plugins; // Global variable shared by multiple plugins.
if ( empty( $codepeople_promote_banner_plugins ) ) {
	$codepeople_promote_banner_plugins = array();
}
$codepeople_promote_banner_plugins['codepeople-calculated-fields-form'] = array(
	'plugin_name' => 'Calculated Fields Form',
	'plugin_url'  => 'https://wordpress.org/support/plugin/calculated-fields-form/reviews/#new-post',
);

if ( ! function_exists( 'codepeople_add_promote_banner' ) ) {
	function codepeople_add_promote_banner( $wp_admin_bar ) {
		global $codepeople_promote_banner_plugins;
		if (
			empty( $codepeople_promote_banner_plugins ) ||
			! is_admin() ||
			! current_user_can( 'manage_options' )
		) {
			return;
		}

		$screen = get_current_screen();
		if ( 'post' == $screen->post_type || 'page' == $screen->post_type ) {
			return;
		}

		// Take action over the banner
		if ( ! empty( $_POST['codepeople_promote_banner_plugin'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$_codepeople_promote_banner_plugin = sanitize_text_field( wp_unslash( $_POST['codepeople_promote_banner_plugin'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			if ( ! empty( $codepeople_promote_banner_plugins[ $_codepeople_promote_banner_plugin ] ) ) {
				set_transient( 'codepeople_promote_banner_' . $_codepeople_promote_banner_plugin, -1, 0 );
				if (
					! empty( $_POST['codepeople_promote_banner_action'] ) && // phpcs:ignore WordPress.Security.NonceVerification
					'set-review' == $_POST['codepeople_promote_banner_action'] && // phpcs:ignore WordPress.Security.NonceVerification
					! empty( $codepeople_promote_banner_plugins[ $_codepeople_promote_banner_plugin ]['plugin_url'] )
				) {
					print '<script>document.location.href="' . esc_url( $codepeople_promote_banner_plugins[ $_codepeople_promote_banner_plugin ]['plugin_url'] ) . '";</script>';
				}
			}
		}

		$minimum_days = 86400 * 7;
		$now          = time();

		foreach ( $codepeople_promote_banner_plugins as $plugin_slug => $plugin_data ) {
			$value = get_transient( 'codepeople_promote_banner_' . $plugin_slug );
			if ( false === $value ) {
				$value = $now;
				set_transient( 'codepeople_promote_banner_' . $plugin_slug, $value, 0 );
			}

			if ( $minimum_days <= abs( $now - $value ) && 0 < $value * 1 ) {
				?>
				<style>
					#codepeople-review-banner{width:calc( 100% - 20px );width:-webkit-calc( 100% - 20px );width:-moz-calc( 100% - 20px );width:-o-calc( 100% - 20px );border:10px solid #1582AB;background:#FFF;display:table;}
					#codepeople-review-banner form{float:left; padding:0 5px;}
					#codepeople-review-banner .codepeople-review-banner-picture{width:120px;padding:10px 10px 10px 10px;float:left;text-align:center;}
					#codepeople-review-banner .codepeople-review-banner-content{float: left;padding:10px;width: calc( 100% - 160px );width: -webkit-calc( 100% - 160px );width: -moz-calc( 100% - 160px );width: -o-calc( 100% - 160px );}
					#codepeople-review-banner  .codepeople-review-banner-buttons{padding-top:20px;}
					#codepeople-review-banner  .no-thank-button,
					#codepeople-review-banner  .main-button{height: 28px;border-width:1px;border-style:solid;border-radius:5px;text-decoration: none;}
					#codepeople-review-banner  .main-button{background: #0085ba;border-color: #0073aa #006799 #006799;-webkit-box-shadow: 0 1px 0 #006799;box-shadow: 0 1px 0 #006799;color: #fff;text-decoration: none;text-shadow: 0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;}
					#codepeople-review-banner  .no-thank-button {color: #555;border-color: #cccccc;background: #f7f7f7;-webkit-box-shadow: 0 1px 0 #cccccc;box-shadow: 0 1px 0 #cccccc;vertical-align: top;}
					#codepeople-review-banner  .main-button:hover,#codepeople-review-banner  .main-button:focus{background: #008ec2;border-color: #006799;color: #fff;}
					#codepeople-review-banner  .no-thank-button:hover,
					#codepeople-review-banner  .no-thank-button:focus{background: #fafafa;border-color: #999;color: #23282d;}
					@media screen AND (max-width:760px)
					{
						#codepeople-review-banner{position:relative;top:50px;}
						#codepeople-review-banner .codepeople-review-banner-picture{display:none;}
						#codepeople-review-banner .codepeople-review-banner-content{width:calc( 100% - 20px );width:-webkit-calc( 100% - 20px );width:-moz-calc( 100% - 20px );width:-o-calc( 100% - 20px );}
					}
				</style>
				<div id="codepeople-review-banner">
					<div class="codepeople-review-banner-picture">
						<img alt="" src="https://secure.gravatar.com/avatar/c0662edcefb5a4e2ab12803856ba2358?s=150&amp;d=mm&amp;r=g" style="width:80px;">
					</div>
					<div class="codepeople-review-banner-content">
						<div class="codepeople-review-banner-text">
							<p><strong>Want to help to the development of the "<?php print esc_html( $plugin_data['plugin_name'] ); ?>" plugin?</strong> The main features of this plugin are provided free of charge. We need your help to continue developing it and adding new features. If you want to help with the development please <span style="color:#1582AB;font-weight:bold;">add a review to support it</span>. Thank you!</p>
						</div>
						<div class="codepeople-review-banner-buttons">
							<form method="post" target="_blank">
								<button class="main-button" onclick="jQuery(this).closest('[id=\'codepeople-review-banner\']').hide();">Publish a Review</button>
								<input type="hidden" name="codepeople_promote_banner_plugin" value="<?php echo esc_attr( $plugin_slug ); ?>" />
								<input type="hidden" name="codepeople_promote_banner_action" value="set-review" />
							</form>
							<form method="post">
								<button class="no-thank-button">No Thanks</button>
								<input type="hidden" name="codepeople_promote_banner_plugin" value="<?php echo esc_attr( $plugin_slug ); ?>" />
								<input type="hidden" name="codepeople_promote_banner_action" value="not-thanks" />
							</form>
							<div style="clear:both;display:block;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style="clear:both;"></div>
				</div>
				<?php
				return;
			}
		}
	}
	add_action( 'admin_bar_menu', 'codepeople_add_promote_banner' );
} // End codepeople_promote_banner block
