<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Ops;

use FernleafSystems\Wordpress\Plugin\Core\Databases\Common\TableSchema;
use FernleafSystems\Wordpress\Services\Services;

class TableIndices {

	public const FIELD_COLUMN_NAME = 'Column_name';
	public const FIELD_KEY_NAME = 'Key_name';

	/**
	 * @var TableSchema
	 */
	private $schema;

	/**
	 * @var ?|array
	 */
	private $indices = null;

	public function __construct( TableSchema $table ) {
		$this->schema = $table;
	}

	/**
	 * @throws \Exception
	 */
	public function retrieve( bool $standardise = false ) :array {
		if ( $this->indices === null ) {
			$WPDB = Services::WpDb();
			if ( !$WPDB->tableExists( $this->schema->table ) ) {
				throw new \Exception( 'Table does not exist: '.$this->schema->table );
			}
			$indices = Services::WpDb()->selectCustom( sprintf( 'SHOW INDEX FROM `%s`', $this->schema->table ) );
			if ( !\is_array( $indices ) ) {
				throw new \Exception( sprintf( 'Unexpected out from "%s"', sprintf( 'SHOW INDEX FROM `%s`', $this->schema->table ) ) );
			}
			$this->indices = $indices;
		}

		return $standardise ?
			\array_map(
				function ( $index ) {
					if ( \is_array( $index ) ) {
						$standardised = [];
						foreach ( \array_keys( $index ) as $key ) {
							$standardised[ \strtolower( $key ) ] = $index[ $key ];
						}
						$index = $standardised;
					}
					return $index;
				},
				$this->indices
			)
			: $this->indices;
	}

	/**
	 * @throws \Exception
	 */
	public function retrieveGroupedBy( string $groupBy = self::FIELD_KEY_NAME ) :array {
		$grouped = [];
		$groupBy = \strtolower( $groupBy );
		foreach ( $this->retrieve( true ) as $index ) {
			if ( !isset( $grouped[ $index[ $groupBy ] ] ) ) {
				$grouped[ $index[ $groupBy ] ] = [];
			}
			$grouped[ $index[ $groupBy ] ][ $index[ \strtolower( self::FIELD_COLUMN_NAME ) ] ] = $index;
		}
		return $grouped;
	}

	/**
	 * @throws \Exception
	 */
	public function exists( array $columns, string $keyName ) :bool {
		foreach ( $columns as $column ) {
			if ( !$this->schema->hasColumn( $column ) ) {
				throw new \Exception( 'Column not defined for table: '.$column );
			}
		}

		$colsForKeyName = \array_keys( $this->retrieveGroupedBy()[ $keyName ] ?? [] );
		\sort( $columns );
		\sort( $colsForKeyName );
		return \serialize( $columns ) === \serialize( $colsForKeyName );
	}

	public function applyFromSchema() {
		foreach ( $this->schema->indices as $index ) {
			if ( !empty( $index[ 'columns' ] ) ) {
				try {
					$this->addForColumns( $index[ 'columns' ], $index[ 'key_name' ] ?? '' );
				}
				catch ( \Exception $e ) {
				}
			}
		}
	}

	/**
	 * @return bool|int|mixed
	 * @throws \Exception
	 */
	public function addForColumn( string $column, string $name = '' ) {
		return $this->addForColumns( [ $column ], $name );
	}

	/**
	 * @return bool|int|mixed
	 * @throws \Exception
	 */
	public function addForColumns( array $columns, string $keyName = '' ) {
		$keyName = \strtolower( empty( $keyName ) ? \implode( '_and_', $columns ) : $keyName );

		if ( $this->exists( $columns, $keyName ) ) {
			throw new \Exception( sprintf( 'Index already exists for "%s" with columns: %s', $keyName, \implode( ',', $columns ) ) );
		}

		$result = Services::WpDb()->doSql(
			sprintf( "CREATE INDEX `%s` ON `%s` (`%s`);", $keyName, $this->schema->table, \implode( '`,`', $columns ) )
		);

		$this->indices = null;
		return $result;
	}
}