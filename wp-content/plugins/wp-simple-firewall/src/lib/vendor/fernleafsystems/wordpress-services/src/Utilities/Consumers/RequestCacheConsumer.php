<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Consumers;

use FernleafSystems\Wordpress\Services\Utilities\Options\Transient;

trait RequestCacheConsumer {

	private static $cache;

	/**
	 * @param mixed|null $result
	 * @return $this
	 */
	protected function addCache( string $key, $result, bool $setTransient = false ) {
		$store = $this->loadCacheStore();
		$store[ $key ] = $result;
		self::$cache = $store;
		if ( $setTransient ) {
			Transient::Set( 'apto-request-cache-consumer', self::$cache, 60 );
		}
		return $this;
	}

	/**
	 * @return mixed|null
	 */
	protected function getCache( string $key ) {
		return $this->loadCacheStore()[ $key ] ?? null;
	}

	private function loadCacheStore( bool $getTransient = false ) :array {
		if ( !isset( self::$cache ) ) {
			if ( $getTransient ) {
				self::$cache = Transient::Get( 'apto-request-cache-consumer' );
			}
			if ( !is_array( self::$cache ) ) {
				self::$cache = [];
			}
		}
		return self::$cache;
	}
}