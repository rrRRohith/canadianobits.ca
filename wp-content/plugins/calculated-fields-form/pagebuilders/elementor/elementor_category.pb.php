<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register the categories
Plugin::$instance->elements_manager->add_category(
	'calculated-fields-form-cat',
	array(
		'title' => 'Calculated Fields Form',
		'icon'  => 'fa fa-plug',
	),
	2 // position
);
