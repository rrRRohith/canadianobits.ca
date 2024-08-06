<?php

// Shortcode template
if ( ! class_exists( 'Ancora_VC_ShortCode' ) ) {
	abstract class Ancora_VC_ShortCode extends WPBakeryShortCode {

		protected $controls_css_settings = 'cc';
		protected $controls_list = array('edit', 'clone', 'delete');

		public function __construct( $settings ) {
			parent::__construct( $settings );
		}

		public function singleParamHtmlHolder( $param, $value ) {
			$output = '';
			$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
			$type = isset( $param['type'] ) ? $param['type'] : '';
			$class = isset( $param['class'] ) ? $param['class'] : '';
			if ( ! empty( $param['holder'] ) ) {
				if ( $param['holder'] == 'input' ) {
					$output .= '<' . esc_attr($param['holder']) . ' readonly="true" class="wpb_vc_param_value ' . esc_attr( ($param_name) . ' ' . ($type) . ' ' . ($class) ) . '" name="'.esc_attr($param_name).'" value="' . esc_attr($value) . '">';
				} elseif ( in_array( $param['holder'], array( 'img', 'iframe' ) ) ) {
					$output .= '<' . esc_attr($param['holder']) . ' class="wpb_vc_param_value ' . esc_attr( ($param_name) . ' ' . ($type) . ' ' . ($class) ) . '" name="' . esc_attr($param_name) . '" src="' . esc_url($value) . '">';
				} else if ( $param['holder'] !== 'hidden' ) {
					$output .= '<' . esc_attr($param['holder']) . ' class="wpb_vc_param_value ' . esc_attr( ($param_name) . ' ' . ($type) . ' ' . ($class) ) . '" name="' . esc_attr($param_name) . '">' . ($value) . '</' . esc_attr($param['holder']) . '>';
				}
			}
			if ( ! empty( $param['admin_label'] ) && $param['admin_label'] === true ) {
				$output .= '<span class="vc_admin_label admin_label_' . esc_attr($param['param_name']) . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . ($param['heading']) . '</label>: ' . ($value) . '</span>';
			}

			return $output;
		}

	}
}

// Single shortcode (audio, video, quote)
if ( ! class_exists( 'Ancora_VC_ShortCodeSingle' ) ) {
	abstract class Ancora_VC_ShortCodeSingle extends Ancora_VC_ShortCode {
	}
}

// Single shortcode without params (woocommerce_cart, checkout, etc.)
if ( ! class_exists( 'Ancora_VC_ShortCodeAlone' ) ) {
	abstract class Ancora_VC_ShortCodeAlone extends Ancora_VC_ShortCode {
		protected $controls_list = array('clone', 'delete');
	}
}

// Container shortcode (block, section, parallax)
if ( ! class_exists( 'Ancora_VC_ShortCodeContainer' ) ) {
	abstract class Ancora_VC_ShortCodeContainer extends Ancora_VC_ShortCode {
		protected $predefined_atts = array();
		protected $controls_css_settings = 'out-tc vc_controls-content-widget';
		protected $controls_list = array('add', 'edit', 'clone', 'delete');

		public function customAdminBlockParams() {
			return '';
		}

		public function mainHtmlBlockParams( $width, $i ) {
			return 'data-element_type="' . esc_attr($this->settings["base"]) . '" class="wpb_' . esc_attr($this->settings['base']) . ' ' . esc_attr($this->settings['class']) . ' wpb_sortable wpb_content_holder vc_shortcodes_container"' . ($this->customAdminBlockParams());
		}

		public function containerHtmlBlockParams( $width, $i ) {
			return 'class="wpb_column_container vc_container_for_children"';
		}

		public function getColumnControls( $controls, $extended_css = '' ) {
			return $extended_css=='bottom-controls' ? '' : $this->getColumnControlsModular($extended_css);
		}

		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';
			extract( shortcode_atts( $this->predefined_atts, $atts ) );
			$output = '';

			$column_controls = $this->getColumnControls( $this->settings( 'controls' ) );
			$column_controls_bottom = $this->getColumnControls( 'add', 'bottom-controls' );
            $count_width = is_array( $width ) ? count( $width ) : 1;
            for ( $i = 0; $i < $count_width; $i ++ ) {
				$output .= '<div ' . ($this->mainHtmlBlockParams( $width, $i )) . '>';
				$output .= $column_controls;
				$output .= '<div class="wpb_element_wrapper">';
				$output .= $this->outputTitle( $this->settings['name'] );
				if ( isset( $this->settings['params'] ) ) {
					$inner = '';
					if (is_array($this->settings['params']) && count($this->settings['params']) > 0) {
					foreach ( $this->settings['params'] as $param ) {
						$param_value = isset( ${$param['param_name']} ) ? ${$param['param_name']} : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key = key( $param_value );
							$param_value = $param_value[$first_key];
						}
						$inner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					}
					$output .= $inner;
				}
				$output .= '<div ' . ($this->containerHtmlBlockParams( $width, $i )) . '>';
				$output .= do_shortcode( shortcode_unautop( $content ) );
				$output .= '</div>';
				$output .= '</div>';
				$output .= $column_controls_bottom;
				$output .= '</div>';
			}
			return $output;
		}
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
			return  '<h4 class="wpb_element_title"><span title="'.esc_attr($title).'" class="vc_element-icon'.( !empty($icon) ? ' '.esc_attr($icon) : '' ).'"></span> '.esc_attr($title).'</h4>';
		}
	}
}


// Collection shortcode (list, testimonials)
if ( ! class_exists( 'Ancora_VC_ShortCodeCollection' ) ) {
	abstract class Ancora_VC_ShortCodeCollection extends Ancora_VC_ShortCodeContainer {
		protected $controls_css_settings = 'out-tc vc_controls-content-widget';
		protected $controls_list = array('add', 'edit', 'clone', 'delete');
	}
}

// Item shortcode in the collection (list_item)
if ( ! class_exists( 'Ancora_VC_ShortCodeItem' ) ) {
	abstract class Ancora_VC_ShortCodeItem extends Ancora_VC_ShortCode {
		protected $controls_css_settings = 'tc vc_control-container';
	}
}


// Columns shortcode (columns, team)
if ( ! class_exists( 'Ancora_VC_ShortCodeColumns' ) ) {
	abstract class Ancora_VC_ShortCodeColumns extends Ancora_VC_ShortCodeContainer {
		protected $controls_css_settings = 'out-tc vc_controls-content-widget';
		protected $controls_list = array('add', 'edit', 'clone', 'delete');
	}
}

// Accordion & Toggles shortcode
if (!class_exists('WPBakeryShortCode_VC_Accordion')) {
	require_once(vc_path_dir('SHORTCODES_DIR', 'vc-accordion.php'));
	require_once(vc_path_dir('SHORTCODES_DIR', 'vc-accordion-tab.php'));
}
if ( ! class_exists( 'Ancora_VC_ShortCodeAccordion' ) ) {
	abstract class Ancora_VC_ShortCodeAccordion extends WPBakeryShortCode_VC_Accordion {}
	abstract class Ancora_VC_ShortCodeAccordionItem extends WPBakeryShortCode_VC_Accordion_tab {}
}
if ( ! class_exists( 'Ancora_VC_ShortCodeToggles' ) ) {
	abstract class Ancora_VC_ShortCodeToggles extends Ancora_VC_ShortCodeAccordion {}
	abstract class Ancora_VC_ShortCodeTogglesItem extends Ancora_VC_ShortCodeAccordionItem {}
}


// Tabs shortcode
if (!class_exists('WPBakeryShortCode_VC_Tabs')) {
	require_once(vc_path_dir('SHORTCODES_DIR', 'vc-tabs.php'));
	require_once(vc_path_dir('SHORTCODES_DIR', 'vc-tab.php'));
}
if ( ! class_exists( 'Ancora_VC_ShortCodeTabs' ) ) {
	abstract class Ancora_VC_ShortCodeTabs extends WPBakeryShortCode_VC_Tabs {
		public function setCustomTabId( $content ) {
			return preg_replace( '/tab\_id\=\"([^\"]+)\"/', 'tab_id="sc_tab_$1_' . time() . '"', $content );
		}
	}
	abstract class Ancora_VC_ShortCodeTab extends WPBakeryShortCode_VC_Tab {
	}
}

?>