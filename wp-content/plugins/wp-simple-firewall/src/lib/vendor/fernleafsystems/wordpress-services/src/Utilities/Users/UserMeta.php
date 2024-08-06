<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Users;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property string $prefix
 * @property int    $user_id
 * @property array  $flash_msg
 */
class UserMeta extends DynPropertiesClass {

	/**
	 * @var static[]
	 */
	private static $metas = [];

	/**
	 * @return static
	 * @throws \Exception
	 */
	public static function Load( string $prefix, int $userID = 0 ) {
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

	protected function __construct( string $prefix, int $userID = 0 ) {
		$rawStore = Services::WpUsers()->getUserMeta( $prefix.'-meta', $userID );
		$this->applyFromArray( \is_array( $rawStore ) ? $rawStore : [] );
		if ( $this->prefix !== $prefix ) {
			$this->prefix = $prefix;
		}
		if ( $this->user_id != $userID ) {
			$this->user_id = $userID;
		}
	}

	public function delete() {
		if ( $this->user_id > 0 ) {
			Services::WpUsers()->deleteUserMeta( $this->getStorageKey(), $this->user_id );
		}
	}

	public function save() {
		if ( $this->user_id > 0 ) {
			Services::WpUsers()
					->updateUserMeta( $this->getStorageKey(), $this->getRawData(), $this->user_id );
		}
	}

	public function __set( string $key, $value ) {
		parent::__set( $key, $value );
		$this->save();
	}

	public function __unset( string $key ) {
		parent::__unset( $key );
		$this->save();
	}

	protected function getStorageKey() :string {
		return $this->prefix.'-meta';
	}
}