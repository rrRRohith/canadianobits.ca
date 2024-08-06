<?php
/**
 * Install/Uninstall plugin: CPCFF_INSTALLER class
 *
 * Contains the CPCFF_INSTALLER metaclass for install and uninstall the plugin.
 *
 * @package CFF
 * @since 1.0.168
 */

if ( ! class_exists( 'CPCFF_INSTALLER' ) ) {
	/**
	 * Installs/Uninstalls the plugin.
	 *
	 * Metaclass to creates the database's tables, with the predefined forms, and create the resource files.
	 *
	 * @since  1.0.168
	 */
	class CPCFF_INSTALLER {

		/**
		 * Creates the database structure and resource files in every new blog.
		 * The method is called by the 'wpmu_new_blog' hook.
		 *
		 * @param int    $blog_id Blog ID.
		 * @param int    $user_id User ID.
		 * @param string $domain  Site domain.
		 * @param string $path    Site path.
		 * @param int    $site_id Site ID. Only relevant on multi-network installs.
		 * @param array  $meta    Meta data. Used to set initial site options.
		 */
		public static function new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
			if ( is_plugin_active_for_network( 'calculated-fields-form/cp_calculatedfieldsf_free.php' ) ) {
				global $wpdb;
				$old_blog = $wpdb->blogid;
				switch_to_blog( $blog_id );
				self::_db_structure();
				switch_to_blog( $old_blog );
			}
		} // End new_blog

		/**
		 * Creates the database tables and resources in every existent blog on website.
		 *
		 * @param bool $networkwide Multisite installation.
		 */
		public static function install( $networkwide ) {
			// check if it is a network activation - if so, run the activation function for each blog id
			if (
				function_exists( 'is_multisite' ) &&
				is_multisite() &&
				$networkwide
			) {
				global $wpdb;
				$old_blog = $wpdb->blogid;

				// Get all blog ids
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::_db_structure();
				}
				switch_to_blog( $old_blog );
				return;
			}
			self::_db_structure();
		} //End install

		/**
		 * Creates a backup of the insert_in_database file.
		 */
		public static function uninstall() {        } // End uninstall

		/**
		 * Creates the database tables used by the plugin's core.
		 *
		 * Creates the database tables, alters the tables created by the free version of the plugin.
		 *
		 * @access private.
		 * @return void.
		 */
		private static function _db_structure() {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			$db_queries = array();

			// Posts table
			$db_queries[] = 'CREATE TABLE ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_POSTS_TABLE_NAME_NO_PREFIX . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				formid INT NOT NULL,
				time datetime,
				ipaddr VARCHAR(41) DEFAULT '' NOT NULL,
				notifyto VARCHAR(250) DEFAULT '' NOT NULL,
				data mediumtext,
				paypal_post mediumtext,
				paid INT DEFAULT 0 NOT NULL,
				UNIQUE KEY id (id)
				) $charset_collate;";

			// Discounts table
			$db_queries[] = 'CREATE TABLE ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				form_id mediumint(9) NOT NULL DEFAULT 1,
				code VARCHAR(250) DEFAULT '' NOT NULL,
				discount VARCHAR(250) DEFAULT '' NOT NULL,
				expires datetime,
				availability int(10) unsigned NOT NULL DEFAULT 0,
				used int(10) unsigned NOT NULL DEFAULT 0,
				UNIQUE KEY id (id)
				) $charset_collate;";

			// CHANGE ROW_FORMAT ONLY ONCE
			if ( get_option( $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE . '_ROW_FORMAT', 0 ) == 0 ) {
				update_option( $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE . '_ROW_FORMAT', 1 );
				$check_table_exists = $wpdb->get_results( 'SHOW TABLES LIKE "' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE . '"' ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				if ( count( $check_table_exists ) ) {
					$wpdb->query( 'ALTER TABLE ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE . ' ROW_FORMAT=DYNAMIC' ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				}
			}

			// Forms structures table
			$db_queries[] = 'CREATE TABLE ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				form_name VARCHAR(250) DEFAULT '' NOT NULL,
				form_structure mediumtext,
				fp_from_email VARCHAR(250) DEFAULT '' NOT NULL,
				fp_destination_emails TEXT,
				fp_subject TEXT,
				fp_inc_additional_info VARCHAR(10) DEFAULT '' NOT NULL,
				fp_return_page VARCHAR(250) DEFAULT '' NOT NULL,
				fp_message mediumtext,
				fp_emailformat VARCHAR(10) DEFAULT '' NOT NULL,
				cu_enable_copy_to_user VARCHAR(10) DEFAULT '' NOT NULL,
				cu_user_email_field TEXT DEFAULT '' NOT NULL,
				cu_subject TEXT,
				cu_message mediumtext,
				cu_emailformat VARCHAR(10) DEFAULT '' NOT NULL,
				fp_emailfrommethod VARCHAR(10) DEFAULT '' NOT NULL,
				enable_paypal_option_yes VARCHAR(250) DEFAULT '' NOT NULL,
				enable_paypal_option_no VARCHAR(250) DEFAULT '' NOT NULL,
				vs_use_validation VARCHAR(10) DEFAULT '' NOT NULL,
				vs_text_is_required VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_is_email VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_datemmddyyyy VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_dateddmmyyyy VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_number VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_digits VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_max VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_min VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_submitbtn VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_previousbtn VARCHAR(250) DEFAULT '' NOT NULL,
				vs_text_nextbtn VARCHAR(250) DEFAULT '' NOT NULL,
				vs_all_texts text DEFAULT '' NOT NULL,
				enable_paypal varchar(10) DEFAULT '' NOT NULL,
				enable_submit varchar(10) DEFAULT '' NOT NULL,
				paypal_notiemails varchar(10) DEFAULT '' NOT NULL,
				paypal_email varchar(255) DEFAULT '' NOT NULL ,
				request_cost varchar(255) DEFAULT '' NOT NULL ,
				paypal_product_name varchar(255) DEFAULT '' NOT NULL,
				currency varchar(10) DEFAULT '' NOT NULL,
				paypal_language varchar(10) DEFAULT '' NOT NULL,
				paypal_mode varchar(20) DEFAULT '' NOT NULL ,
				paypal_recurrent varchar(20) DEFAULT '' NOT NULL ,
				paypal_recurrent_setup varchar(20) DEFAULT '' NOT NULL ,
				paypal_recurrent_setup_days varchar(20) DEFAULT '' NOT NULL ,
                paypal_recurrent_times varchar(20) DEFAULT '' NOT NULL ,
                paypal_recurrent_times_field varchar(20) DEFAULT '' NOT NULL ,
				paypal_identify_prices varchar(20) DEFAULT '' NOT NULL ,
				paypal_zero_payment varchar(10) DEFAULT '' NOT NULL ,
				paypal_base_amount VARCHAR(250),
				paypal_address TINYINT DEFAULT 1 NOT NULL,
				cv_enable_captcha VARCHAR(20) DEFAULT '' NOT NULL,
				cv_width VARCHAR(20) DEFAULT '' NOT NULL,
				cv_height VARCHAR(20) DEFAULT '' NOT NULL,
				cv_chars VARCHAR(20) DEFAULT '' NOT NULL,
				cv_font VARCHAR(20) DEFAULT '' NOT NULL,
				cv_min_font_size VARCHAR(20) DEFAULT '' NOT NULL,
				cv_max_font_size VARCHAR(20) DEFAULT '' NOT NULL,
				cv_noise VARCHAR(20) DEFAULT '' NOT NULL,
				cv_noise_length VARCHAR(20) DEFAULT '' NOT NULL,
				cv_background VARCHAR(20) DEFAULT '' NOT NULL,
				cv_border VARCHAR(20) DEFAULT '' NOT NULL,
				cv_text_enter_valid_captcha VARCHAR(200) DEFAULT '' NOT NULL,
				category VARCHAR(250),
				cache longtext DEFAULT '' NOT NULL,
				UNIQUE KEY id (id)
				) $charset_collate ROW_FORMAT=DYNAMIC;";

			// Revisions table
			$db_queries[] = 'CREATE TABLE ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_REVISIONS_TABLE . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				formid mediumint(9) NOT NULL,
				time datetime,
				revision longtext NOT NULL,
				UNIQUE KEY id (id)
				) $charset_collate;";

			dbDelta( $db_queries ); // Running the queries

			// Alter table
			self::_alter_table( $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE, array( 'category' => 'VARCHAR(250)' ) );

			// Insert the predefined forms into the forms table
			self::_predefined_forms();
		} // End _db_structure

		private static function _alter_table( $table, $new_columns = array() ) {
			try {
				if ( count( $new_columns ) ) {
					global $wpdb;
					$current_columns = array();

					$columns = $wpdb->get_results( 'SHOW columns FROM `' . $table . '`' ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
					foreach ( $columns as $column ) {
						$current_columns[ $column->Field ] = $column->Field;
					}

					foreach ( $new_columns as $column_name => $column_settings ) {
						if ( ! isset( $current_columns[ $column_name ] ) ) {
							$sql = 'ALTER TABLE  `' . $table . '` ADD `' . $column_name . '` ' . $column_settings;
							$wpdb->query( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
						}
					}
				}
			} catch ( Exception $err ) {
				error_log( $err->getMessage() );}
		} // End _alter_table

		/**
		 * Inserts the predefined forms into the Forms table
		 */
		private static function _predefined_forms() {
			global $wpdb;
			$table_name = $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE;
			$count      = $wpdb->get_var( 'SELECT COUNT(id) FROM ' . $table_name ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			if ( ! $count ) {
				cpcff_init_constants();
				$values                   = array(
					'fp_from_email'                => CP_CALCULATEDFIELDSF_DEFAULT_fp_from_email,
					'fp_destination_emails'        => CP_CALCULATEDFIELDSF_DEFAULT_fp_destination_emails,
					'fp_subject'                   => CP_CALCULATEDFIELDSF_DEFAULT_fp_subject,
					'fp_inc_additional_info'       => CP_CALCULATEDFIELDSF_DEFAULT_fp_inc_additional_info,
					'fp_return_page'               => CP_CALCULATEDFIELDSF_DEFAULT_fp_return_page,
					'fp_message'                   => CP_CALCULATEDFIELDSF_DEFAULT_fp_message,
					'fp_emailformat'               => CP_CALCULATEDFIELDSF_DEFAULT_email_format,

					'cu_enable_copy_to_user'       => CP_CALCULATEDFIELDSF_DEFAULT_cu_enable_copy_to_user,
					'cu_user_email_field'          => CP_CALCULATEDFIELDSF_DEFAULT_cu_user_email_field,
					'cu_subject'                   => CP_CALCULATEDFIELDSF_DEFAULT_cu_subject,
					'cu_message'                   => CP_CALCULATEDFIELDSF_DEFAULT_cu_message,
					'cu_emailformat'               => CP_CALCULATEDFIELDSF_DEFAULT_email_format,

					'vs_use_validation'            => CP_CALCULATEDFIELDSF_DEFAULT_vs_use_validation,
					'vs_text_is_required'          => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_is_required,
					'vs_text_is_email'             => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_is_email,
					'vs_text_datemmddyyyy'         => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_datemmddyyyy,
					'vs_text_dateddmmyyyy'         => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_dateddmmyyyy,
					'vs_text_number'               => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_number,
					'vs_text_digits'               => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_digits,
					'vs_text_max'                  => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_max,
					'vs_text_min'                  => CP_CALCULATEDFIELDSF_DEFAULT_vs_text_min,
					'vs_text_submitbtn'            => 'Submit',
					'vs_text_previousbtn'          => 'Previous',
					'vs_text_nextbtn'              => 'Next',

					'enable_paypal'                => CP_CALCULATEDFIELDSF_DEFAULT_ENABLE_PAYPAL,
					'enable_submit'                => '',
					'paypal_notiemails'            => '0',
					'paypal_email'                 => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_EMAIL,
					'request_cost'                 => CP_CALCULATEDFIELDSF_DEFAULT_COST,
					'paypal_product_name'          => CP_CALCULATEDFIELDSF_DEFAULT_PRODUCT_NAME,
					'currency'                     => CP_CALCULATEDFIELDSF_DEFAULT_CURRENCY,
					'paypal_language'              => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_LANGUAGE,
					'paypal_mode'                  => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_MODE,
					'paypal_recurrent'             => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_RECURRENT,
					'paypal_recurrent_setup'       => '',
					'paypal_recurrent_setup_days'  => '15',
					'paypal_recurrent_times'       => '0',
					'paypal_recurrent_times_field' => '',
					'paypal_identify_prices'       => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_IDENTIFY_PRICES,
					'paypal_zero_payment'          => CP_CALCULATEDFIELDSF_DEFAULT_PAYPAL_ZERO_PAYMENT,

					'cv_enable_captcha'            => CP_CALCULATEDFIELDSF_DEFAULT_cv_enable_captcha,
					'cv_width'                     => CP_CALCULATEDFIELDSF_DEFAULT_cv_width,
					'cv_height'                    => CP_CALCULATEDFIELDSF_DEFAULT_cv_height,
					'cv_chars'                     => CP_CALCULATEDFIELDSF_DEFAULT_cv_chars,
					'cv_font'                      => CP_CALCULATEDFIELDSF_DEFAULT_cv_font,
					'cv_min_font_size'             => CP_CALCULATEDFIELDSF_DEFAULT_cv_min_font_size,
					'cv_max_font_size'             => CP_CALCULATEDFIELDSF_DEFAULT_cv_max_font_size,
					'cv_noise'                     => CP_CALCULATEDFIELDSF_DEFAULT_cv_noise,
					'cv_noise_length'              => CP_CALCULATEDFIELDSF_DEFAULT_cv_noise_length,
					'cv_background'                => CP_CALCULATEDFIELDSF_DEFAULT_cv_background,
					'cv_border'                    => CP_CALCULATEDFIELDSF_DEFAULT_cv_border,
					'cv_text_enter_valid_captcha'  => CP_CALCULATEDFIELDSF_DEFAULT_cv_text_enter_valid_captcha,
				);
				$values['id']             = 1;
				$values['form_name']      = 'Simple Operations';
				$values['form_structure'] = CP_CALCULATEDFIELDSF_DEFAULT_form_structure1;
				$wpdb->insert( $table_name, $values );
				$values['id']             = 2;
				$values['form_name']      = 'Calculation with Dates';
				$values['form_structure'] = CP_CALCULATEDFIELDSF_DEFAULT_form_structure2;
				$wpdb->insert( $table_name, $values );
				$values['id']             = 3;
				$values['form_name']      = 'Ideal Weight Calculator';
				$values['form_structure'] = CP_CALCULATEDFIELDSF_DEFAULT_form_structure3;
				$wpdb->insert( $table_name, $values );
				$values['id']             = 4;
				$values['form_name']      = 'Pregnancy Calculator';
				$values['form_structure'] = CP_CALCULATEDFIELDSF_DEFAULT_form_structure4;
				$wpdb->insert( $table_name, $values );
				$values['id']             = 5;
				$values['form_name']      = 'Lease Calculator';
				$values['form_structure'] = CP_CALCULATEDFIELDSF_DEFAULT_form_structure5;
				$wpdb->insert( $table_name, $values );
			}
		} // End _predefined_forms

	} // End class CPCFF_INSTALLER
}
