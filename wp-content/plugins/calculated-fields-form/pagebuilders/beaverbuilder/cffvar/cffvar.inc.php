<?php
require_once CP_CALCULATEDFIELDSF_BASE_PATH . '/pagebuilders/beaverbuilder/cffvar/cffvar/cffvar.php';

FLBuilder::register_module(
	'CFFVarBeaver',
	array(
		'cff-var-tab' => array(
			'title'    => __( 'Generate variable', 'calculated-fields-form' ),
			'sections' => array(
				'cff-var-section' => array(
					'title'  => __( 'Variable attributes', 'calculated-fields-form' ),
					'fields' => array(
						'var_name'      => array(
							'type'     => 'text',
							'label'    => __( 'Enter the variable name', 'calculated-fields-form' ),
							'required' => true,
						),
						'default_value' => array(
							'type'  => 'text',
							'label' => __( 'Enter the default value', 'calculated-fields-form' ),
						),
						'from'          => array(
							'type'    => 'select',
							'label'   => __( 'Generate variable from', 'calculated-fields-form' ),
							'options' => array(
								'directly' => __( 'Directly', 'calculated-fields-form' ),
								'get'      => __( 'GET parameters', 'calculated-fields-form' ),
								'post'     => __( 'POST parameters', 'calculated-fields-form' ),
								'session'  => __( 'SESSION variables', 'calculated-fields-form' ),
								'cookies'  => __( 'COOKIES variables', 'calculated-fields-form' ),
							),
						),
					),
				),
			),
		),
	)
);
