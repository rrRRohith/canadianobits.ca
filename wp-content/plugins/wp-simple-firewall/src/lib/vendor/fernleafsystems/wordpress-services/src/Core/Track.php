<?php

namespace FernleafSystems\Wordpress\Services\Core;

class Track {

	/**
	 * @var array
	 */
	protected $aFiredWpActions = [];

	public function __construct() {
		$aActions = [ 'plugins_loaded', 'init', 'admin_init', 'wp_loaded', 'wp', 'wp_head', 'shutdown' ];
		foreach ( $aActions as $sAction ) {
			add_action( $sAction, [ $this, 'trackAction' ], 0 );
		}
	}

	/**
	 * Pass null to get the state of all tracked actions as an assoc array
	 * @param string|null $sAction
	 * @return array|bool
	 */
	public function getWpActionHasFired( $sAction = null ) {
		return ( empty( $sAction ) ? $this->aFiredWpActions : isset( $this->aFiredWpActions[ $sAction ] ) );
	}

	/**
	 * @param string $sAction
	 * @return $this
	 */
	public function setWpActionHasFired( $sAction ) {
		if ( !isset( $this->aFiredWpActions ) || !is_array( $this->aFiredWpActions ) ) {
			$this->aFiredWpActions = [];
		}
		$this->aFiredWpActions[ $sAction ] = microtime();
		return $this;
	}

	/**
	 * @return $this
	 */
	public function trackAction() {
		$this->setWpActionHasFired( current_filter() );
	}
}