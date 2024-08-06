<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base;

use FernleafSystems\Wordpress\Services\Services;

class Insert extends BaseQuery {

	/**
	 * @var array
	 */
	protected $insertData;

	/**
	 * @var bool
	 */
	private $isIgnore = false;

	/**
	 * @var bool
	 */
	private $useWpDbHelper = false;

	public function buildQuery() :string {
		return sprintf( $this->getBaseQuery(),
			$this->getInsertModifier(),
			$this->getDbH()->getTableSchema()->table,
			$this->getColumnsForQuery(),
			$this->getValuesForQuery()
		);
	}

	protected function getBaseQuery() :string {
		return "INSERT %s INTO `%s` (%s) VALUES (%s)";
	}

	public function getInsertData() :array {
		return \array_intersect_key(
			\is_array( $this->insertData ) ? $this->insertData : [],
			\array_flip( $this->getDbH()->getTableSchema()->getColumnNames() )
		);
	}

	protected function getColumnsForQuery() :string {
		return '`'.\implode( '`,`',\array_keys( $this->getInsertData() ) ).'`';
	}

	protected function getValuesForQuery() :string {
		return "'".\implode( "','", \array_map( function ( $value ) {
				return esc_sql( $value );
			}, $this->getInsertData() ) )."'";
	}

	public function getInsertModifier() :string {
		return $this->isIgnore ? 'IGNORE' : '';
	}

	/**
	 * @param Record|mixed $record
	 */
	public function insert( $record ) :bool {
		return $this->setInsertData( $record->getRawData() )->query();
	}

	/**
	 * Verifies insert data keys against actual table columns
	 * @return $this
	 */
	public function setInsertData( array $data ) {
		$this->insertData = \array_intersect_key(
			$data,
			\array_flip( $this->getDbH()->getTableSchema()->getColumnNames() )
		);
		return $this;
	}

	/**
	 * @return $this
	 * @throws \Exception
	 */
	protected function verifyInsertData() {
		$schema = $this->getDbH()->getTableSchema();

		$baseData = [];
		if ( $schema->has_created_at ) {
			$baseData[ 'created_at' ] = Services::Request()->ts();
		}
		if ( $schema->has_updated_at ) {
			$baseData[ 'updated_at' ] = Services::Request()->ts();
		}

		return $this->setInsertData( \array_merge( $baseData, $this->getInsertData() ) );
	}

	protected function execQuerySql() :bool {
		return $this->useWpDbHelper ? $this->queryWithWpDbInsertHelper() : parent::execQuerySql();
	}

	protected function preQuery() :bool {
		$this->verifyInsertData();
		return true;
	}

	public function queryWithWpDbInsertHelper() :bool {
		try {
			$this->lastQueryResult = Services::WpDb()
											 ->insertDataIntoTable(
												 $this->getDbH()->getTable(),
												 $this->getInsertData()
											 );
			$success = (bool)$this->lastQueryResult;
		}
		catch ( \Exception $e ) {
			$success = false;
		}
		return $success;
	}

	/**
	 * Offset never applies
	 */
	protected function buildOffsetPhrase() :string {
		return '';
	}

	public function setIgnore( bool $ignore = true ) {
		$this->isIgnore = $ignore;
		return $this;
	}

	public function setUseHelper( bool $useHelper = true ) {
		$this->useWpDbHelper = $useHelper;
		return $this;
	}
}