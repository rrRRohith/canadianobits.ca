<?php

namespace FernleafSystems\Wordpress\Services\Core\Upgrades;

require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
require_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );

class UpgraderSkinLegacy extends \WP_Upgrader_Skin {

	/**
	 * @var array
	 */
	private $aFeedback = [];

	public function __construct() {
		parent::__construct();
		$this->done_header = true; // prevents text output
		$this->done_footer = true; // prevents text output
	}

	/**
	 * @inheritDoc
	 */
	public function feedback( $string ) {
		// overriding this prevent automatic echo of feedback
		if ( empty( $this->aFeedback ) ) {
			$this->aFeedback = [];
		}
		$this->aFeedback[] = $string;
	}

	/**
	 * @return string[]
	 */
	public function getIcwpFeedback() {
		return \is_array( $this->aFeedback ) ? $this->aFeedback : [];
	}
}