<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use FernleafSystems\Wordpress\Services\Services;

class CreateTable {

	/**
	 * @var TableSchema
	 */
	private $schema;

	public function __construct( TableSchema $tableSchema ) {
		$this->schema = $tableSchema;
	}

	public function buildCreateSQL() :string {
		return sprintf(
			'CREATE TABLE `%s` (
                %s
			) %s;',
			$this->schema->table,
			\implode( ", \n", $this->buildCreateBody() ),
			Services::WpDb()->getCharCollate()
		);
	}

	public function buildCreateBody() :array {
		return \array_merge(
			$this->buildColumns(),
			$this->buildPrimaryKey(),
			$this->buildForeignKeys()
		);
	}

	public function buildColumns() :array {
		$cols = [];
		foreach ( $this->schema->enumerateColumns() as $col => $def ) {
			$cols[] = sprintf( '%s %s', $col, $def );
		}
		return $cols;
	}

	public function buildPrimaryKey() :array {
		return [ sprintf( 'PRIMARY KEY  (%s)', $this->schema->getPrimaryKeyColumnName() ) ];
	}

	public function buildForeignKeys() :array {
		$WPDB = Services::WpDb();
		$fKeys = [];
		foreach ( $this->schema->getColumnsDefs() as $col => $def ) {
			$fk = $def[ 'foreign_key' ] ?? null;
			if ( !empty( $fk ) ) {
				$fKeys[] = sprintf( 'FOREIGN KEY (%s) REFERENCES %s(%s) %s %s',
					$col,
					sprintf( '%s%s', ( $fk[ 'wp_prefix' ] ?? true ) ? $WPDB->getPrefix() : '', $fk[ 'ref_table' ] ),
					$fk[ 'ref_col' ],
					( $fk[ 'cascade_delete' ] ?? true ) ? 'ON DELETE CASCADE' : '',
					( $fk[ 'cascade_update' ] ?? true ) ? 'ON UPDATE CASCADE' : ''
				);
			}
		}
		return $fKeys;
	}
}