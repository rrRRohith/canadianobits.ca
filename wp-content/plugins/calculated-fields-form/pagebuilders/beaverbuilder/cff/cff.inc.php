<?php
require_once CP_CALCULATEDFIELDSF_BASE_PATH . '/pagebuilders/beaverbuilder/cff/cff/cff.php';

// Get the forms list
global $wpdb;
$options = array();
$default = '';

$rows = $wpdb->get_results( 'SELECT id, form_name FROM ' . $wpdb->prefix . CP_CALCULATEDFIELDSF_FORMS_TABLE ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
$url  = CPCFF_AUXILIARY::editor_url();
foreach ( $rows as $item ) {
	$options[ $item->id ] = $item->form_name;
	if ( empty( $default ) ) {
		$default = $item->id;
	}
}

FLBuilder::register_module(
	'CFFBeaver',
	array(
		'cff-form-tab' => array(
			'title'    => __( 'Select the form and enter the additional attributes', 'calculated-fields-form' ),
			'sections' => array(
				'cff-form-section' => array(
					'title'  => __( 'Form information', 'calculated-fields-form' ),
					'fields' => array(
						'form_id'     => array(
							'type'    => 'select',
							'label'   => __( 'Select form', 'calculated-fields-form' ),
							'options' => $options,
							'default' => $default,
						),
						'class_name'  => array(
							'type'  => 'text',
							'label' => __( 'Class name', 'calculated-fields-form' ),
						),
						'attributes'  => array(
							'type'  => 'text',
							'label' => __( 'Additional attributes', 'calculated-fields-form' ),
						),
						'form_editor' => array(
							'type'    => 'raw',
							'preview' => 'none',
							'content' => '<button style="float:right;" class="fl-builder-button fl-builder-button-small" title="' . esc_attr( __( 'Edit form', 'calculated-fields-form' ) ) . '" onclick="window.open(\'' . esc_attr( $url ) . '\'+document.getElementsByName(\'form_id\')[0].value);">' . esc_attr( __( 'Edit form', 'calculated-fields-form' ) ) . '</button>',
						),
					),
				),
			),
		),
	)
);
