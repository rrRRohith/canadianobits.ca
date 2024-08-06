<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Utilities\Data\Adapter\StdClassAdapter;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property string $prefix
 * @property int    $user_id
 * @property array  $flash_msg
 * @deprecated
 */
class PluginUserMeta {

	use StdClassAdapter {
		__set as __adapterSet;
		__unset as __adapterUnset;
	}

	/**
	 * @var PluginUserMeta[]
	 */
	private static $aMetas;

	/**
	 * @param string $sPrefix
	 * @param int    $nUserId
	 * @return PluginUserMeta
	 * @throws \Exception
	 */
	public static function Load( $sPrefix, $nUserId = 0 ) {
		if ( !is_array( self::$aMetas ) ) {
			self::$aMetas = [];
		}
		if ( empty( $nUserId ) ) {
			$nUserId = Services::WpUsers()->getCurrentWpUserId();
		}
		if ( empty( $nUserId ) ) {
			throw new \Exception( 'Attempting to get meta of non-logged in user.' );
		}

		if ( !isset( self::$aMetas[ $sPrefix.$nUserId ] ) ) {
			static::AddToCache( new static( $sPrefix, $nUserId ) );
		}

		return self::$aMetas[ $sPrefix.$nUserId ];
	}

	/**
	 * @param static $oMeta
	 */
	public static function AddToCache( $oMeta ) {
		self::$aMetas[ $oMeta->prefix.$oMeta->user_id ] = $oMeta;
	}

	/**
	 * @param string $sPrefix
	 * @param int    $nUserId
	 */
	public function __construct( $sPrefix, $nUserId = 0 ) {
		$aStore = Services::WpUsers()->getUserMeta( $sPrefix.'-meta', $nUserId );
		if ( !is_array( $aStore ) ) {
			$aStore = [];
		}
		$this->applyFromArray( $aStore );
		$this->prefix = $sPrefix;
		$this->user_id = $nUserId;
		add_action( 'shutdown', [ $this, 'save' ], 5 );
	}

	/**
	 * @return $this
	 */
	public function delete() {
		if ( $this->user_id > 0 ) {
			Services::WpUsers()->deleteUserMeta( $this->getStorageKey(), $this->user_id );
			remove_action( 'shutdown', [ $this, 'save' ], 5 );
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function save() {
		if ( $this->user_id > 0 ) {
			Services::WpUsers()->updateUserMeta(
				$this->getStorageKey(), $this->getRawDataAsArray(), $this->user_id );
		}
		return $this;
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mValue
	 * @return $this
	 */
	public function __set( $sKey, $mValue ) {
		return $this->__adapterSet( $sKey, $mValue )->save();
	}

	/**
	 * @param string $sKey
	 * @return $this
	 */
	public function __unset( $sKey ) {
		return $this->__adapterUnset( $sKey )->save();
	}

	/**
	 * @return string
	 */
	private function getStorageKey() {
		return $this->prefix.'-meta';
	}
}