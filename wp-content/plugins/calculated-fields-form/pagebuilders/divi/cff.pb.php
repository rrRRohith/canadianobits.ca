<?php
class CFF_DIVI extends ET_Builder_Module {


	public $slug       = 'cff_divi';
	public $vb_support = 'on';

	public function init() {
		$this->name                   = esc_html__( 'Calculated Fields Form', 'calculated-fields-form' );
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Form', 'calculated-fields-form' ),
				),
			),
		);
	}

	public function get_fields() {
		global $wpdb;
		$options = array();
		$default = '';

		$rows = $wpdb->get_results( 'SELECT id, form_name FROM ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		foreach ( $rows as $item ) {
			$options[ $item->id ] = $item->form_name;
			if ( empty( $default ) ) {
				$default = $item->id;
			}
		}

		return array(
			'cff_form_id'    => array(
				'label'           => esc_html__( 'Select form', 'calculated-fields-form' ),
				'type'            => 'select',
				'options'         => $options,
				'default'         => $default,
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Select the form.', 'calculated-fields-form' ),
				'toggle_slug'     => 'main_content',
			),
			'cff_class_name' => array(
				'label'           => esc_html__( 'Class name', 'calculated-fields-form' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'cff_attributes' => array(
				'label'           => esc_html__( 'Additional attributes', 'calculated-fields-form' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => 'attr1="value attr1" attr1="value attr1"',
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $unprocessed_props, $content = null, $render_slug = '' ) {
		$output = '';
		$form   = @intval( $this->props['cff_form_id'] );
		if ( ! empty( $form ) ) {
			$output     = '[CP_CALCULATED_FIELDS id="' . $form . '"';
			$class_name = sanitize_text_field( $this->props['cff_class_name'] );
			if ( ! empty( $class_name ) ) {
				$output .= ' class="' . esc_attr( $class_name ) . '"';
			}

			$attributes = sanitize_text_field( $this->props['cff_attributes'] );
			if ( ! empty( $attributes ) ) {
				$output .= ' ' . $attributes;
			}

			$output .= ']';
		}
		return do_shortcode( $output );
	}
}

new CFF_DIVI();
