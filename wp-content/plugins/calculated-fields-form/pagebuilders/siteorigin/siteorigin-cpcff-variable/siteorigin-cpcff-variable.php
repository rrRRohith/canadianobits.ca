<?php
/*
Widget Name: Calculated Fields Form Variable Shortcode
Description: Insert a javascript generator shortcode on page.
Documentation: https://cff.dwbooster.com/documentation#javascript-variables
*/

class SiteOrigin_CFF_Variable_Shortcode extends SiteOrigin_Widget {

	public function __construct() {
		parent::__construct(
			'siteorigin-cff-variable-shortcode',
			__( 'Calculated Fields Form, Variable Shortcode', 'calculated-fields-form' ),
			array(
				'description'   => __( 'Shortcode to generate a javascript variable from the url parameters (GET or POST), session variables, cookies, or define it directly', 'calculated-fields-form' ),
				'panels_groups' => array( 'calculated-fields-form' ),
				'help'          => 'https://cff.dwbooster.com/documentation#javascript-variables',
			),
			array(),
			array(
				'name'          => array(
					'type'    => 'text',
					'label'   => __( 'Variable name', 'calculated-fields-form' ),
					'default' => '',
				),
				'from'          => array(
					'type'    => 'select',
					'label'   => __( 'Generate variable from', 'calculated-fields-form' ),
					'default' => '',
					'options' => array(
						''               => __( 'Any source', 'calculated-fields-form' ),
						'from="get"'     => __( 'GET parameter', 'calculated-fields-form' ),
						'from="post"'    => __( 'POST parameter', 'calculated-fields-form' ),
						'from="session"' => __( 'Session variable', 'calculated-fields-form' ),
						'from="cookie"'  => __( 'Cookie', 'calculated-fields-form' ),
					),
				),
				'default_value' => array(
					'type'    => 'text',
					'label'   => __( 'Default value (used when variables are generated from a source)', 'calculated-fields-form' ),
					'default' => '',
				),
				'value'         => array(
					'type'    => 'text',
					'label'   => __( 'Value (value of the variable when it is generated directly)', 'calculated-fields-form' ),
					'default' => '',
				),
			),
			plugin_dir_path( __FILE__ )
		);
	} // End __construct

	public function get_template_name( $instance ) {
		return 'siteorigin-cff-variable-shortcode';
	} // End get_template_name

	public function get_style_name( $instance ) {
		return '';
	} // End get_style_name

} // End Class SiteOrigin_CFF_Variable_Shortcode

// Registering the widget
siteorigin_widget_register( 'siteorigin-cff-variable-shortcode', __FILE__, 'SiteOrigin_CFF_Variable_Shortcode' );
