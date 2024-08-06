<?php
class CFFVarBeaver extends FLBuilderModule {
	public function __construct() {
		 $modules_dir = dirname( __FILE__ ) . '/';
		$modules_url  = plugins_url( '/', __FILE__ ) . '/';

		parent::__construct(
			array(
				'name'            => __( 'Create variable', 'calculated-fields-form' ),
				'description'     => __( 'Create javascript variable', 'fl-builder' ),
				'group'           => __( 'Calculated Fields Form', 'calculated-fields-form' ),
				'category'        => __( 'Calculated Fields Form', 'calculated-fields-form' ),
				'dir'             => $modules_dir,
				'url'             => $modules_url,
				'partial_refresh' => true,
			)
		);

		$this->add_css( 'cff-var', $this->url . 'css/cffvar.css' );
	}
}
