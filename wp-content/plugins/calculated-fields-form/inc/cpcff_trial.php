<?php
/**
 * Allows to install the trial version of Professional distribution: CPCFF_TRIAL class
 *
 * @package CFF.
 * @since 1.1.14
 */

if ( ! class_exists( 'CPCFF_TRIAL' ) ) {
	class CPCFF_TRIAL {

		/**
		 * Main plugin object
		 */
		private $_main_obj;
		private $_url = 'https://wordpress.dwbooster.com/trial/get.php';

		public function __construct() {
			 add_action( 'admin_init', array( $this, 'init' ) );
		} // End __construct

		/**
		 * Install TRIAL
		 *
		 * @return void.
		 */
		public function init() {
			if ( ! empty( $_GET['cff-install-trial'] ) && current_user_can( 'manage_options' ) ) {
				$this->_install_plugin();
			}
		} // End init

		private function _install_plugin() {
			try {
				$response = wp_remote_get(
					$this->_url . '?action=check',
					array(
						'body'      => array( 'u' => CPCFF_AUXILIARY::site_url() ),
						'sslverify' => false,
					)
				);
				if ( ! is_wp_error( $response ) ) {
					$body = wp_remote_retrieve_body( $response );
					if ( 'ok' != $body ) {
						update_option( 'cff-t-t', $body );
					} else {
						include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
						wp_cache_flush();
						$installer = new Plugin_Upgrader();
						$installed = $installer->install( $this->_url, array( 'overwrite_package' => true ) );
						if ( $installed ) {
							update_option( 'cff-t-d', time() );
							print '<script>document.location.href="' . esc_js( remove_query_arg( 'cff-install-trial', false ) ) . '#cff-upgrade-frame";</script>';
							exit;
						}
					}
				}
			} catch ( Exception $err ) {
				print esc_html( $err->getMessage() );
				exit;
			}
		} // End _install_plugin
	} // End Class CPCFF_TRIAL

	new CPCFF_TRIAL();
}
