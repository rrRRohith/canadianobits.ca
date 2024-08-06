<?php
/**
 * Operations for checking the compatibility with other plugins: CPCFF_COMPATIBILITY class
 *
 * @package CFF.
 * @since 1.0.370
 */

if ( ! class_exists( 'CPCFF_COMPATIBILITY' ) ) {
	class CPCFF_COMPATIBILITY {

		private static function init() {
			return array(
				array(
					'plugin' => 'Breeze - WordPress Cache Plugin',
					'check'  => 'BREEZE_VERSION',
					'type'   => 'constant',
					'mssg'   => __( 'There is active the <b>Breeze - WordPress Cache Plugin</b> plugin. If the forms are not visible, please tick the <i>"There is active an optimization plugin in WordPress"</i> and Purge the Breeze cache.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'Fast Velocity Minify',
					'check'  => 'fvm_compat_checker',
					'type'   => 'function',
					'mssg'   => __( 'There is active the <b>Fast Velocity Minify</b> plugin. If the forms are not visible, please try disabling the <i>"Disable minification on JS files"</i> or <i>"Disable JavaScript processing"</i> options in the <b>Fast Velocity Minify</b> settings.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'W3 Total Cache',
					'check'  => 'W3TC',
					'type'   => 'constant',
					'mssg'   => __( 'There is active the <b>W3 Total Cache</b> plugin. If the forms are not visible, please tick the checkbox.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'Autoptimize',
					'check'  => 'autoptimize',
					'type'   => 'function',
					'mssg'   => __( 'There is active the <b>Autoptimize</b> plugin. If the forms are not visible, please try disabling the <i>"Force JavaScript in &lt;head&gt;"</i> option in the <b>Autoptimize</b> settings, or remove the jQuery file from the <i>"Exclude scripts from Autoptimize"</i> one.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'LiteSpeed Cache',
					'check'  => 'run_litespeed_cache',
					'type'   => 'function',
					'mssg'   => __( 'There is active the <b>LiteSpeed Cache</b> plugin. If the forms are not visible, please try disabling the <i>"JS Combine"</i> option in the <b>Optimize</b> tab of <b>LiteSpeed Cache</b> settings.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'WP Rocket',
					'check'  => 'WP_ROCKET_VERSION',
					'type'   => 'constant',
					'mssg'   => __( 'There is active the <b>WP Rocket</b> plugin. If the forms are not visible, please try disabling the <i>"Combine JavaScript files"</i> option in the <b>FILE OPTIMIZATION</b> tab of <b>WP Rocket</b> settings, and remember to clear the website cache.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'SG Optimizer',
					'check'  => 'siteground_optimizer_helper',
					'type'   => 'object',
					'mssg'   => __( 'There is active the <b>SG Optimizer</b> plugin. If the forms are not visible, please try disabling the options: <i>"Minify the HTML Output"</i> and <i>"Minify JavaScript Files"</i> in the <b>SG Optimizer</b> settings, and remember to purge the website cache.', 'calculated-fields-form' ),
				),
				array(
					'plugin' => 'Hummingbird',
					'check'  => 'WPHB_VERSION',
					'type'   => 'constant',
					'mssg'   => __( 'There is active the <b>Hummingbird</b> plugin. If the forms are not visible, check the <i>"Hummingbird &gt; Asset Optimization"</i> options. Make sure that jQuery or other required scripts are not configured to load after the page loads. Remember to purge the website cache, after edit the plugin settings.', 'calculated-fields-form' ),
				),
			);
		} // End init

		private static function format_warning_mssg( $plugin ) {
			return '<div class="cff-compatibility-warning">' . $plugin['mssg'] . '</div>';
		} // End format_warning_mssg

		public static function warnings() {
			 $plugins      = self::init();
			$warning_mssgs = '';
			foreach ( $plugins as $plugin ) {
				switch ( $plugin['type'] ) {
					case 'function':
						if ( function_exists( $plugin['check'] ) ) {
							$warning_mssgs .= self::format_warning_mssg( $plugin );
						}
						break;
					case 'class':
						if ( class_exists( $plugin['check'] ) ) {
							$warning_mssgs .= self::format_warning_mssg( $plugin );
						}
						break;
					case 'object':
						if ( isset( $GLOBALS[ $plugin['check'] ] ) ) {
							$warning_mssgs .= self::format_warning_mssg( $plugin );
						}
						break;
					case 'constant':
						if ( defined( $plugin['check'] ) ) {
							$warning_mssgs .= self::format_warning_mssg( $plugin );
						}
						break;
				}
			}
			return $warning_mssgs;
		} // End blog_id

	} // End CPCFF_COMPATIBILITY
}
