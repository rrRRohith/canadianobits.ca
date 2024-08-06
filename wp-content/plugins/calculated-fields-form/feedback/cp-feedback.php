<?php
if ( ! class_exists( 'CP_FEEDBACK' ) ) {
	class CP_FEEDBACK {

		private $feedback_url = 'https://wordpress.dwbooster.com/licensesystem/debug-data.php';
		private $plugin_slug;
		private $plugin_file;
		private $support_link;
		private $full_support_link;

		public function __construct( $plugin_slug, $plugin_file, $support_link ) {
			$this->plugin_slug       = $plugin_slug;
			$this->plugin_file       = $plugin_file;
			$this->support_link      = $support_link;
			$this->full_support_link = $support_link . ( ( strpos( $support_link, '?' ) === false ) ? '?' : '&' ) . 'priority-support=yes';

			// To know when the plugin was installed
			if ( ! get_option( 'installed_' . $this->plugin_slug, false ) ) {
				update_option( 'installed_' . $this->plugin_slug, time() );
			}
			// Actions and filters
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
			add_action( 'wp_ajax_cp_feedback', array( $this, 'feedback_action' ) );
		} // End __construct

		public function enqueue_scripts( $hook ) {
			if ( 'plugins.php' == $hook ) {
				wp_enqueue_style( 'wp-jquery-ui-dialog' );
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-dialog' );

				add_action( 'admin_footer', array( $this, 'feedback_interface' ) );
			}
		} // End insert_admin_scripts

		public function feedback_interface() {
			// Varibles to use into the feedback interface
			$plugin_slug       = $this->plugin_slug;
			$support_link      = $this->support_link;
			$full_support_link = $this->full_support_link;

			include_once dirname( $this->plugin_file ) . '/feedback/feedback.html';
		} // End feedback_interface

		// This function is used only if explicitly accepted (opt-in) by the user
		public function feedback_action() {
			if (
				isset( $_POST['feedback_plugin'] ) &&
				$_POST['feedback_plugin'] == $this->plugin_slug &&
				isset( $_POST['_wpnonce'] ) &&
				wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'calculated-fields-form-feedback' )
			) { // phpcs:ignore WordPress.Security.NonceVerification
				$plugin_data    = get_plugin_data( $this->plugin_file );
				$plugin_version = $plugin_data['Version'];
				$time           = time() - get_option( 'installed_' . $this->plugin_slug, 0 );

				$data = array(
					'plugin'     => $plugin_data['Name'],
					'pluginv'    => $plugin_version,
					'wordpress'  => get_bloginfo( 'version' ),
					'itime'      => $time,
					'phpversion' => phpversion(),
				);

				foreach ( $_POST as $parameter => $value ) { // phpcs:ignore WordPress.Security.NonceVerification
					$data[ $parameter ] = sanitize_text_field( wp_unslash( $value ) );
				}

				if ( ! isset( $_POST['cp_feedback_anonymous'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
					$current_user    = wp_get_current_user();
					$data['email']   = $current_user->user_email;
					$data['website'] = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
					$data['url']     = get_site_url();
				}

				// Send data
				$response = wp_remote_post(
					$this->feedback_url,
					array(
						'body'      => $data,
						'sslverify' => false,
					)
				);

				wp_die(); // this is required to terminate immediately and return a proper response
			}

		} // End feedback_action

	} // End class
}
