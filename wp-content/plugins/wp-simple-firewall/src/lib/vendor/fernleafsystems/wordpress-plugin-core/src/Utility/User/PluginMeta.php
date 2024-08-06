<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Utility\User;

use FernleafSystems\Wordpress\Services\Services;

/**
 * @property string $prefix
 * @property int    $user_id
 * @property array  $flash_msg
 */
class PluginMeta extends \FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass {

	/**
	 * @var PluginMeta[]
	 */
	private static $metas;

	/**
	 * @param string $prefix
	 * @param int    $userID
	 * @return PluginMeta
	 * @throws \Exception
	 */
	public static function Load( string $prefix, $userID = 0 ) {
		if ( !\is_array( self::$metas ) ) {
			self::$metas = [];
		}
		if ( empty( $userID ) ) {
			$userID = Services::WpUsers()->getCurrentWpUserId();
		}
		if ( empty( $userID ) ) {
			throw new \Exception( 'Attempting to get meta of non-logged in user.' );
		}

		if ( !isset( self::$metas[ $prefix.$userID ] ) ) {
			static::AddToCache( new static( $prefix, $userID ) );
		}

		return self::$metas[ $prefix.$userID ];
	}

	/**
	 * @param static $meta
	 */
	public static function AddToCache( $meta ) {
		self::$metas[ $meta->prefix.$meta->user_id ] = $meta;
	}

	public function __construct( string $prefix, int $userID = 0 ) {
		$store = Services::WpUsers()->getUserMeta( $prefix.'-meta', $userID );
		if ( !\is_array( $store ) ) {
			$store = [];
		}
		$this->applyFromArray( $store );
		$this->prefix = $prefix;
		$this->user_id = $userID;
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
			Services::WpUsers()->updateUserMeta( $this->getStorageKey(), $this->getRawData(), $this->user_id );
		}
		return $this;
	}

	/**
	 * @param mixed $value
	 */
	public function __set( string $key, $value ) {
		parent::__set( $key, $value );
		$this->save();
	}

	public function __unset( string $key ) {
		parent::__unset( $key );
		$this->save();
	}

	private function getStorageKey() :string {
		return $this->prefix.'-meta';
	}
}