<?php
/**
 * Actions required to include the forms in the AMP pages: CPCFF_AMP class
 *
 * @package CFF.
 * @since 1.0.230
 */

if ( ! class_exists( 'CPCFF_AMP' ) ) {
	/**
	 * Class that defines the operations to display the foms in AMP pages.
	 *
	 * @since  1.0.170
	 */
	class CPCFF_AMP {

		/**
		 * Main plugin object
		 */
		private $_main_obj;

		public function __construct( $main_obj ) {
			$this->_main_obj = $main_obj;
			add_action( 'init', array( $this, 'amp_init' ) ); // for amp pages.
		} // End __construct

		/**
		 * Loads the form's preview in AMP pages.
		 *
		 * @return void.
		 */
		public function amp_init() {
			if (
				! empty( $_GET['cff-amp-form'] ) &&
				get_option( 'CP_CALCULATEDFIELDSF_AMP', CP_CALCULATEDFIELDSF_AMP )
			) {
				$atts       = $this->_params_to_attrs();
				$page_title = ( ! empty( $atts['page_title'] ) ) ? $atts['page_title'] : '';
				print '<!DOCTYPE html><html ' .
				( ( function_exists( 'is_rtl' ) && is_rtl() ) ? 'dir="rtl"' : '' ) .
				'>' .
				'<head>' .
				'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' .
				'<meta name="viewport" content="width=device-width">' .
				'<title>' . esc_html( $page_title ) . '</title>';

				// Patch for editor preview
				if ( empty( $_GET['cff-editor-preview'] ) ) {
					print '<style>' .
					'body{background:#FFF;overflow:hidden;margin:0;}' .
					'html, body {height:100%;position:relative;min-height:100%;display:block;}' .
					'#fbuilder{' . $this->_get_styles() . 'box-sizing:border-box!important;}' . // phpcs:ignore WordPress.Security.EscapeOutput
					'</style>';
				}

				global  $wp_styles, $wp_scripts;
				if ( ! empty( $wp_scripts ) ) {
					$wp_scripts->reset();
				}
				$message = $this->_main_obj->public_form( $atts );
				// Patch for editor preview
				if ( empty( $_GET['cff-editor-preview'] ) ) {
					$message = preg_replace( '/<form\s+/i', '<form target="_parent" ', $message, 1 );
					$message = preg_replace(
						'/<\/form>/i',
						'</form><pre style="display:none !important;"><script>try{
                        document.addEventListener("DOMContentLoaded",
                        function(){fbuilderjQuery(document).one("showHideDepEvent", function(){window.parent.postMessage({sentinel: "amp",type:"embed-size",height: document.body.scrollHeight+25}, "*");});});}catch(err){console.log(err);}</script></pre>',
						$message,
						1
					);
				}
				ob_start();
				if ( ! empty( $wp_styles ) ) {
					$wp_styles->do_items();
				}
				if ( ! empty( $wp_scripts ) ) {
					$wp_scripts->do_items();
				}
				if ( class_exists( 'Error' ) ) {
					try {
						wp_footer(); } catch ( Error $err ) {
							error_log( $err->getMessage() );
						}
				}
				$message .= ob_get_contents();
				ob_end_clean();

				// Patch for editor preview
				if ( ! empty( $_GET['cff-editor-preview'] ) ) {
					$message .= '<script type="text/javascript">
					window.addEventListener("load",
					function() {
						var frameEl = window.frameElement;
						if(frameEl && typeof fbuilderjQuery != "undefined")
							frameEl.height = fbuilderjQuery("form").outerHeight(true) + 25;
					}, false);
					</script>';
				}
				print '</head>' .
				'<body>' .
				$message . // phpcs:ignore WordPress.Security.EscapeOutput
				'</body>' .
				'</html>';
				remove_all_actions( 'shutdown' );
				exit;
			}
		} // End amp_init

		/**
		 * Checks if the page is AMP or not
		 *
		 * Checks first for the existence of functions: "is_amp_endpoint" or "ampforwp_is_amp_endpoint",
		 * and if they don't exists, checks the URL.
		 *
		 * @return bool.
		 */
		public function is_amp() {
			if ( ! get_option( 'CP_CALCULATEDFIELDSF_AMP', CP_CALCULATEDFIELDSF_AMP ) ) {
				return false;
			}
			if ( ! empty( $_REQUEST['isamp'] ) ) {
				return true;
			}
			if ( empty( $_GET['non-amp'] ) ) {
				if ( function_exists( 'ampforwp_is_amp_endpoint' ) ) {
					return ampforwp_is_amp_endpoint();
				} elseif ( function_exists( 'is_amp_endpoint' ) ) {
					return is_amp_endpoint();
				}
			}
			return false;
		} // End is_amp

		/**
		 * Returns an iframe tag for loading the a webpage with the form only, specially useful for AMP pages.
		 *
		 * @return string, the iframe tag's structure for loading a page with the form.
		 */
		public function get_iframe( $atts ) {
			$url    = CPCFF_AUXILIARY::site_url();
			$url    = preg_replace( '/^http\:/i', 'https:', $url );
			$url   .= ( strpos( $url, '?' ) === false ) ? '?' : '&';
			$url   .= 'cff-amp-form=' . ( ( ! empty( $atts['id'] ) ) ? $atts['id'] : '' );
			$height = '';
			$width  = '';
			foreach ( $atts as $attr_name => $attr_value ) {
				if ( 'amp_iframe_height' == $attr_name ) {
					$height = $attr_value;
				} elseif ( 'amp_iframe_width' == $attr_name ) {
					$width = $attr_value;
				} elseif ( 'id' != $attr_name ) {
					$url .= '&cff-form-attr-' . $attr_name . '=' . $attr_value;
				}
			}

			if ( empty( $height ) ) {
				$height = 320;
			} else {
				$url .= '&cff-form-height=' . $height;
			}
			if ( empty( $width ) ) {
				$width = 500;
			}

			$url .= '&non-amp=1';

			add_action( 'amp_post_template_css', array( $this, 'amp_css' ) );
			add_filter( 'amp_post_template_data', array( $this, 'amp_iframe' ) );

			return '<amp-iframe id="cff-form-iframe" src="' . esc_attr( esc_url( $url ) ) . '" layout="responsive" resizable sandbox="allow-popups allow-forms allow-top-navigation allow-modals allow-scripts" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"><amp-img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOmNjPSJodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9ucyMiIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBpZD0ic3ZnOCIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMTMuMjI5MTY3IDEzLjIyOTE2NyIgaGVpZ2h0PSI1MCIgd2lkdGg9IjUwIj48ZGVmcyBpZD0iZGVmczIiIC8+PG1ldGFkYXRhIGlkPSJtZXRhZGF0YTUiPjxyZGY6UkRGPjxjYzpXb3JrIHJkZjphYm91dD0iIj48ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD48ZGM6dHlwZSByZGY6cmVzb3VyY2U9Imh0dHA6Ly9wdXJsLm9yZy9kYy9kY21pdHlwZS9TdGlsbEltYWdlIiAvPjxkYzp0aXRsZT48L2RjOnRpdGxlPjwvY2M6V29yaz48L3JkZjpSREY+PC9tZXRhZGF0YT48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0yODMuNzcwODMpIiBpZD0ibGF5ZXIxIiAvPjwvc3ZnPg==" placeholder layout="responsive" width="50" height="50" /><div overflow tabindex=0 role=button style="bottom:0;border-bottom:2px dotted #ccc; width:100%;"><div aria-label="' . esc_attr__( 'Click to expand', 'calculated-fields-form' ) . '" style="margin-bottom:10px;margin-left:50%;transform:translate(-50%);padding:10px 20px;background:#666;color:white;border-radius:5px;display:inline-block;">' . esc_html( __( 'Click to expand', 'calculated-fields-form' ) ) . '</div></div></amp-iframe>';
		}

		/**
		 * Includes the CSS rules for the amp version of form
		 *
		 * @param object, template.
		 */
		public function amp_css( $template ) {
			print '#cff-form-iframe{margin:0;}';
		} // End amp_css

		/**
		 * Checks if the amp-iframe.js was included, and includes it if not.
		 *
		 * @param $data, associative array.
		 * @return $data, associative array.
		 */
		public function amp_iframe( $data ) {
			if ( empty( $data['amp_component_scripts']['amp-iframe'] ) ) {
				$data['amp_component_scripts']['amp-iframe'] = 'https://cdn.ampproject.org/v0/amp-iframe-0.1.js';
			}
			return $data;
		} // End amp_iframe

		/**
		 * Converts the URL parameters related with the form in the redirection process required for load the forms into the amp-frames
		 *
		 * The parameter cff-amp-form is converted in the id attribute,
		 * and the parameteres with the name:  cff-form-attr-<param>, are converted in the attributes <param>
		 *
		 * @return array $attrs.
		 */
		private function _params_to_attrs() {
			$attrs = array();
			if ( ! empty( $_GET ) ) {
				foreach ( $_GET as $param => $value ) {
					if ( 'cff-amp-form' == $param ) {
						$attrs['id'] = @intval( $value );
					} elseif ( preg_match( '/^cff\-form\-attr\-/i', $param ) ) {
						$param           = preg_replace( '/^cff\-form\-attr\-/i', '', $param );
						$param           = sanitize_text_field( $param );
						$attrs[ $param ] = sanitize_text_field( $value );
					}
				}
			}
			return $attrs;
		} // End _params_to_attrs

		/**
		 * Reads the form height from the URL parameter cff-form-height, returns 500 by default.
		 *
		 * @return int.
		 */
		private function _get_styles() {
			return ( ! empty( $_GET['cff-form-height'] ) && is_numeric( $_GET['cff-form-height'] ) && ( $height = intval( $_GET['cff-form-height'] ) ) !== 0 ) ? 'overflow-x:hidden;overflow-y:auto;height:' . $height . 'px;padding:5px 32px 5px 5px;' : ''; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
		}
	}
}
