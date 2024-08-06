<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use FernleafSystems\Wordpress\Services\Services;

class TableReadyCache {

	public const DB_STATUS_KEY = 'apto-dbs-ready-status';
	public const READY_LIFETIME = 30;

	private $status;

	private $save = false;

	public function __construct() {
		add_action( 'shutdown', [ $this, 'save' ], \PHP_INT_MIN );
	}

	public function save() {
		if ( $this->save ) {
			$status = $this->getStatus();
			\ksort( $status );
			Services::WpGeneral()->updateOption( self::DB_STATUS_KEY, $status );
		}
	}

	public function reset() {
		unset( $this->status );
		$this->save = true;
	}

	public function isReady( TableSchema $schema ) :bool {
		$lifetime = (int)\max( 1,
			apply_filters( 'apto/db/table_ready_cache_lifetime', self::READY_LIFETIME, $schema )
		);
		return ( Services::Request()->ts() - $lifetime ) < ( $this->getStatus()[ $this->uniqTableID( $schema ) ] ?? 0 );
	}

	public function setReady( TableSchema $schema, bool $isReady = true ) {
		$status = $this->getStatus();
		if ( $isReady ) {
			$status[ $this->uniqTableID( $schema ) ] = time();
		}
		else {
			unset( $status[ $this->uniqTableID( $schema ) ] );
		}
		$this->status = $status;
		$this->save = true;
	}

	private function getStatus() :array {
		if ( !isset( $this->status ) ) {
			$status = Services::WpGeneral()->getOption( self::DB_STATUS_KEY );
			$this->status = \array_filter(
				\is_array( $status ) ? $status : [],
				function ( int $ts ) {
					return ( Services::Request()->ts() - $ts ) < \WEEK_IN_SECONDS;
				}
			);
		}
		return $this->status;
	}

	private function uniqTableID( TableSchema $schema ) :string {
		$data = $schema->getRawData();
		\ksort( $data );
		return \substr( \md5( \serialize( $data ) ), 0, 10 );
	}
}