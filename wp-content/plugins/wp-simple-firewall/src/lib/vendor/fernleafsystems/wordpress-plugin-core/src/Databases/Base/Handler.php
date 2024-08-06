<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Utilities\Logic\ExecOnce;
use FernleafSystems\Wordpress\Plugin\Core\Databases\Common\{
	AlignTableWithSchema,
	Iterator,
	SubQueryLoader,
	TableReadyCache,
	TableSchema
};
use FernleafSystems\Wordpress\Plugin\Core\Databases\Exceptions\NoSlugProvidedException;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property bool $use_table_ready_cache
 */
abstract class Handler extends DynPropertiesClass {

	use ExecOnce;

	/**
	 * @var TableReadyCache
	 */
	private static $ReadyCache;

	/**
	 * @var bool
	 */
	private $isReady;

	/**
	 * @var TableSchema
	 */
	protected $schema;

	/**
	 * @var array
	 */
	protected $tableDefinition;

	public function __construct( array $tableDefinition ) {
		if ( empty( $tableDefinition[ 'slug' ] ) ) {
			throw new NoSlugProvidedException( 'Slug not provided in Table Definition' );
		}
		$this->tableDefinition = $tableDefinition;
	}

	/**
	 * @throws \Exception
	 */
	protected function run() {
		$this->tableInit( true );
	}

	/**
	 * @throws \Exception
	 */
	public function tableInit( bool $mayDeleteIfNotReady = false ) {

		$schema = $this->getTableSchema();

		$ready = $this->use_table_ready_cache && static::GetTableReadyCache()->isReady( $schema );

		if ( !$ready ) {
			$aligner = new AlignTableWithSchema( $schema );
			$aligner->align();
			if ( $this->tableExists() && $aligner->isAligned() ) {
				$ready = true;
				static::GetTableReadyCache()->setReady( $schema );
			}

			if ( !$ready && $mayDeleteIfNotReady ) {
				$this->tableDelete();
				$this->tableInit();
			}
		}

		$this->isReady = $ready;
	}

	private function setupTableSchema() :TableSchema {
		if ( !$this->schema instanceof TableSchema ) {

			$this->schema = ( new TableSchema() )->applyFromArray( \array_merge(
				[
					'slug'            => '',
					'table_prefix'    => '',
					'primary_key'     => 'id',
					'cols_custom'     => [],
					'cols_timestamps' => [],
					'has_updated_at'  => true,
					'has_created_at'  => true,
					'has_deleted_at'  => true,
					'col_older_than'  => 'created_at',
					'autoexpire'      => 0,
					'has_ip_col'      => false,
				],
				$this->tableDefinition
			) );

			// why this??
			$this->schema->table = $this->getTable();
		}

		return $this->schema;
	}

	public function autoCleanDb() {
	}

	public function tableCleanExpired( int $autoExpireDays ) {
		if ( $autoExpireDays > 0 ) {
			$this->deleteRowsOlderThan( Services::Request()->ts() - $autoExpireDays*DAY_IN_SECONDS );
		}
	}

	/**
	 * @param int $timestamp
	 * @return bool
	 */
	public function deleteRowsOlderThan( int $timestamp ) :bool {
		return $this->isReady() &&
			   $this->getQueryDeleter()
					->addWhereOlderThan( $timestamp, $this->getTableSchema()->col_older_than )
					->query();
	}

	public function getTable() :string {
		return $this->getTableSchema()->table;
	}

	/**
	 * @return Iterator
	 */
	public function getIterator() {
		$o = new Iterator();
		return $o->setDbH( $this );
	}

	/**
	 * @return Delete|mixed
	 */
	public function getQueryDeleter() {
		return ( new SubQueryLoader() )
			->setDbH( $this )
			->delete();
	}

	/**
	 * @return Insert|mixed
	 */
	public function getQueryInserter() {
		return ( new SubQueryLoader() )
			->setDbH( $this )
			->insert();
	}

	/**
	 * @return Select|mixed
	 */
	public function getQuerySelector() {
		return ( new SubQueryLoader() )
			->setDbH( $this )
			->select()
			->setResultsAsVo( true );
	}

	/**
	 * @return Update|mixed
	 */
	public function getQueryUpdater() {
		return ( new SubQueryLoader() )
			->setDbH( $this )
			->update();
	}

	/**
	 * @return Record|mixed
	 */
	public function getRecord() {
		return ( new SubQueryLoader() )
			->setDbH( $this )
			->record();
	}

	public function isReady() :bool {
		return (bool)$this->isReady;
	}

	public function tableDelete( bool $truncate = false ) :bool {
		$table = $this->getTable();
		$DB = Services::WpDb();
		$mResult = !$this->tableExists() ||
				   ( $truncate ? $DB->doTruncateTable( $table ) : $DB->doDropTable( $table ) );
		$DB->clearResultShowTables();
		$this->reset();
		return $mResult;
	}

	public function tableExists() :bool {
		return Services::WpDb()->tableExists( $this->getTable() );
	}

	public static function GetTableReadyCache() :TableReadyCache {
		return self::$ReadyCache ?? self::$ReadyCache = new TableReadyCache();
	}

	/**
	 * @deprecated 1.1
	 */
	protected function getReadyCache() :TableReadyCache {
		if ( !isset( self::$ReadyCache ) ) {
			self::$ReadyCache = new TableReadyCache();
		}
		return self::$ReadyCache;
	}

	public function getTableSchema() :TableSchema {
		if ( !isset( $this->schema ) ) {
			$this->setupTableSchema();
		}
		return $this->schema;
	}

	public function reset() {
		unset( $this->isReady );
		parent::reset();
	}

	public function getBaseNamespaces() :array {
		return [ __NAMESPACE__ ];
	}

	/**
	 * @deprecated 1.1
	 */
	protected function getTransientReadyKey() :string {
		return 'apto-db-ready-'.\substr( \md5( \serialize( $this->getTableSchema() ) ), 0, 10 );
	}

	/**
	 * @return Record|mixed
	 * @deprecated 1.1
	 */
	public function getVo() {
		return $this->getRecord();
	}

	/**
	 * @return $this
	 * @deprecated 1.1
	 */
	public function setAllowAutoDelete() {
		return $this;
	}

	/**
	 * @return $this
	 * @throws \Exception
	 * @deprecated 1.1
	 */
	protected function tableCreate() {
		$DB = Services::WpDb();
		$sch = $this->getTableSchema();
		if ( !$DB->tableExists( $sch->table ) ) {
			$DB->doSql( $sch->buildCreate() );
			$DB->clearResultShowTables();
		}
		return $this;
	}

	/**
	 * @deprecated 1.1
	 */
	public function tableTrimExcess( int $rowsLimit ) {
		try {
			$this->getQueryDeleter()->deleteExcess( $rowsLimit );
		}
		catch ( \Exception $e ) {
		}
		return $this;
	}
}