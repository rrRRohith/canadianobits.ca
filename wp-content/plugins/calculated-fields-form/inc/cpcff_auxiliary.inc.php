<?php
/**
 * Miscellaneous operations: CPCFF_AUXILIARY class
 *
 * Metaclass with miscellanous operations used through all plugin.
 *
 * @package CFF.
 * @since 1.0.167
 */

if ( ! class_exists( 'CPCFF_AUXILIARY' ) ) {
	/**
	 * Metaclass with miscellaneous operations.
	 *
	 * Publishes miscellanous operations to be used through all plugin's sections.
	 *
	 * @since  1.0.167
	 */
	class CPCFF_AUXILIARY {

		/**
		 * Public URL of the current blog.
		 *
		 * @since 1.0.167
		 * @var string $_site_url
		 */
		private static $_site_url;

		/**
		 * URL to the WordPress of the current blog.
		 *
		 * @since 1.0.167
		 * @var string $_wp_url
		 */
		private static $_wp_url;

		/**
		 * Current URL.
		 *
		 * @var string $_current_url
		 */
		private static $_current_url;

		/**
		 * ID of the current blog.
		 *
		 * @var string $_wp_id
		 */
		private static $_wp_id;

		/**
		 * Returns the id of current blog.
		 *
		 * If the ID was read previously, uses the value stored in class property.
		 *
		 * @return int.
		 */
		public static function blog_id() {
			if ( empty( self::$_wp_id ) ) {
				self::$_wp_id = get_current_blog_id();
			}
			return self::$_wp_id;
		} // End blog_id

		/**
		 * Returns the public URL of the current blog.
		 *
		 * If the URL was read previously, uses the value stored in class property.
		 *
		 * @since 1.0.167
		 * @return string.
		 */
		public static function site_url( $no_protocol = false ) {
			if ( empty( self::$_site_url ) ) {
				$blog            = self::blog_id();
				self::$_site_url = get_home_url( $blog, '', is_ssl() ? 'https' : 'http' );
			}
			$_site_url = rtrim( self::$_site_url, '/' );
			if ( $no_protocol ) {
				$_site_url = preg_replace( '/^http(s?)\:/i', '', $_site_url );
			}
			return $_site_url;
		} // End site_url

		/**
		 * Returns the URL to the WordPress of the current blog.
		 *
		 * If the URL was read previously, uses the value stored in class property.
		 *
		 * @since 1.0.167
		 * @return string.
		 */
		public static function wp_url() {
			if ( empty( self::$_wp_url ) ) {
				$blog          = self::blog_id();
				self::$_wp_url = get_admin_url( $blog );
			}
			return rtrim( self::$_wp_url, '/' );
		} // End wp_url

		/**
		 * Returns the form editor.
		 */
		public static function editor_url() {
			return self::wp_url() . '/admin.php?page=cp_calculated_fields_form&_cpcff_nonce=' . wp_create_nonce( 'cff-form-settings' ) . '&cal=';
		} // End editor_url

		/**
		 * Returns the URL to the current post url.
		 *
		 * @return string.
		 */
		public static function wp_current_url() {
			if ( is_admin() ) {
				return self::site_url();
			}
			if ( ! empty( self::$_current_url ) ) {
				return self::$_current_url;
			}

			$protocol = ( ( ! empty( $_SERVER['HTTPS'] ) && 'off' != $_SERVER['HTTPS'] ) || ( ! empty( $_SERVER['SERVER_PORT'] ) && 443 == $_SERVER['SERVER_PORT'] ) ) ? 'https://' : 'http://';

			self::$_current_url = $protocol . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' );
			return self::$_current_url;
		} // End wp_current_url

		/**
		 * Sanitizes the value received as parameter, supporting the same posts tags
		 *
		 * @since Pro 5.0.235, Dev 5.0.279, Plat 10.0.318
		 *
		 * @params mixed $v.
		 * @return sanitized value.
		 */
		public static function sanitize( $v ) {
			 $allowed_tags = wp_kses_allowed_html( 'post' );

			add_filter(
				'safecss_filter_attr_allow_css',
				function( $allow_css, $css_test_string ) {
					if ( preg_match( '/rgb(a)?\(/i', $css_test_string ) ) {
						return true;
					}
					return $allow_css;
				},
				10,
				2
			);

			$v = wp_kses( $v, $allowed_tags );

			// the str_replace is a patch to solve an issue with the data: part in signature fields
			// that are removed by wp_kse.
			return str_replace(
				array( '"image/svg+xml;base64', '"image/png;base64' ),
				array( '"data:image/svg+xml;base64', '"data:image/png;base64' ),
				$v
			);
		} // End sanitize

		/**
		 * Removes Bom characters.
		 *
		 * @since 1.0.179
		 *
		 * @param string $str.
		 * @return string.
		 */
		public static function clean_bom( $str ) {
			$bom = pack( 'H*', 'EFBBBF' );
			return preg_replace( "/$bom/", '', $str );
		} // End clean_bom

		/**
		 * Converts some characters in a JSON string.
		 *
		 * @since 1.0.169
		 *
		 * @param string $str JSON string.
		 * @return string.
		 */
		public static function clean_json( $str ) {
			return str_replace(
				array( '	', "\n", "\r" ),
				array( ' ', '\n', '' ),
				$str
			);
		} // End clean_json

		/**
		 * Set the hook for cleanning the expired transients
		 *
		 * @since 1.0.281
		 */
		public static function clean_transients_hook() {
			add_action( 'cpcff_clean_transients', array( 'CPCFF_AUXILIARY', 'clean_transients' ) );
			if ( ! wp_next_scheduled( 'cpcff_clean_transients' ) ) {
				wp_schedule_event( time() + 5, 'daily', 'cpcff_clean_transients' );
			}
		} // End clean_transients_hook

		/**
		 * Clean the expired transients
		 *
		 * @since 1.0.281
		 */
		public static function clean_transients() {
			 global $wpdb;
			$table = $wpdb->options;

			// get current PHP time, offset by a minute to avoid clashes with other tasks
			$threshold = time() - MINUTE_IN_SECONDS;

			// delete expired transients, using the paired timeout record to find them
			$sql = "
				delete from t1, t2
				using $table t1
				join $table t2 on t2.option_name = replace(t1.option_name, '_timeout', '')
				where t1.option_name like '\_transient\_timeout\_%'
				and t1.option_value < '$threshold'
			";
			$wpdb->query( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

			// delete orphaned transient expirations
			$sql = "
				delete from $table
				where option_name like '\_transient\_timeout\_%'
				and option_value < '$threshold'
			";

			$wpdb->query( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		} // End clean_transients

		/**
		 * Decodes a JSON string.
		 *
		 * Decode a JSON string, and receive a parameter to apply strip slashes first or not.
		 *
		 * @since 1.0.169
		 *
		 * @param string $str JSON string.
		 * @param string $stripcslashes Optional. To apply a stripcslashes to the text before json_decode. Default 'unescape'.
		 * @return mixed PHP Oject or False.
		 */
		public static function json_decode( $str, $stripcslashes = 'unescape' ) {
			try {
				$str = self::clean_json( $str );
				if ( 'unescape' == $stripcslashes ) {
					$str = stripcslashes( $str );
				}
				$obj = json_decode( $str );
			} catch ( Exception $err ) {
				self::write_log( $err ); }
			return ( ! empty( $obj ) ) ? $obj : false;
		} // End unserialize

		/**
		 * Replaces recursively the elements in an array by the elements in another one.
		 *
		 * The method will use the PHP function: array_replace_recursive if exists.
		 *
		 * @since 1.0.169
		 *
		 * @param array $array1
		 * @param array $array2
		 * @return array
		 */
		public static function array_replace_recursive( $array1, $array2 ) {
			// If the array_replace_recursive function exists, use it
			if ( function_exists( 'array_replace_recursive' ) ) {
				return array_replace_recursive( $array1, $array2 );
			}
			foreach ( $array2 as $key1 => $val1 ) {
				if ( isset( $array1[ $key1 ] ) ) {
					if ( is_array( $val1 ) ) {
						foreach ( $val1 as $key2 => $val2 ) {
							$array1[ $key1 ][ $key2 ] = $val2;
						}
					} else {
						$array1[ $key1 ] = $val1;
					}
				} else {
					$array1[ $key1 ] = $val1;
				}
			}
			return $array1;
		} // End array_replace_recursive

		/**
		 * Applies stripcslashes to the array elements recursively.
		 *
		 * The method checks if parameter is an array a text. If it is an array the method is called recursively.
		 *
		 * @since 1.0.176
		 *
		 * @param mixed $v array or single value.
		 * @return mixed the array or value with the slashes stripped
		 */
		public static function stripcslashes_recursive( $v ) {
			if ( is_array( $v ) ) {
				foreach ( $v as $k => $s ) {
					$v[ $k ] = self::stripcslashes_recursive( $s );
				}
				return $v;
			} else {
				return stripcslashes( $v );
			}
		} // End stripcslashes_recursive

		public static function stripscript_recursive( $v ) {
			if ( is_array( $v ) ) {
				foreach ( $v as $k => $s ) {
					$v[ $k ] = self::stripscript_recursive( $s );
				}
				return $v;
			} else {
				return preg_replace( array( '/<\s*script\b.*\bscript\s*>/i', '/<\s*script[^>]*>/i' ), '', $v );
			}
		} // End stripscript_recursive

		/**
		 * Checks if the website is being visited by a crawler.
		 *
		 * Returns true if the website is being visited by a search engine spider,
		 * and the plugin was configure for hidding the forms front them, else false.
		 *
		 * @since 1.0.169
		 *
		 * @return bool.
		 */
		public static function is_crawler() {
			return ( isset( $_SERVER['HTTP_USER_AGENT'] ) &&
					preg_match( '/bot|crawl|slurp|spider/i', sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) ) &&
					get_option( 'CP_CALCULATEDFIELDSF_EXCLUDE_CRAWLERS', false )
				);
		} // End is_crawler

		/**
		 * Adds the attribute: property="stylesheet" to the link tag to validate the link tags into the pages' bodies.
		 *
		 * Checks if it is an stylesheet and adds the property if has not been included previously.
		 *
		 * @since 1.0.178
		 *
		 * @param string $tag the link tag.
		 * @return string.
		 */
		public static function complete_link_tag( $tag ) {
			if (
				preg_match( '/stylesheet/i', $tag ) &&
				! preg_match( '/property\s*=/i', $tag )
			) {
				return str_replace( '/>', ' property="stylesheet" />', $tag );
			}
			return $tag;
		} // End complete_link_tag

		/**
		 * Creates a new entry in the PHP Error Logs.
		 *
		 * @since 1.0.167
		 *
		 * @param mixed $log Log message, as text, array or plain object.
		 * @return void.
		 */
		public static function write_log( $log ) {
			try {
				if (
					defined( 'WP_DEBUG' ) &&
					true == WP_DEBUG
				) {
					if (
						is_array( $log ) ||
						is_object( $log )
					) {
						error_log( print_r( $log, true ) );
					} else {
						error_log( $log );
					}
				}
			} catch ( Exception $err ) {
				error_log( $err->getMessage() );
			}
		} // End write_log

	} // End CPCFF_AUXILIARY
}
