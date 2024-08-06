<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base;

use FernleafSystems\Wordpress\Services\Services;

class Select extends BaseQuery {

	/**
	 * @var array
	 */
	protected $columnsToSelect;

	protected $isCount = false;

	protected $isSum = false;

	protected $isDistinct = false;

	protected $resultsAsVO;

	/**
	 * @var string
	 */
	protected $customSelect;

	/**
	 * @var string
	 */
	protected $resultFormat;

	/**
	 * @param string $col
	 * @return $this
	 */
	public function addColumnToSelect( $col ) {
		$cols = $this->getColumnsToSelect();
		$cols[] = $col;
		return $this->setColumnsToSelect( $cols );
	}

	/**
	 * @return array[]|int|string[]|Record[]|mixed
	 */
	public function all() {
		return $this->reset()->queryWithResult();
	}

	/**
	 * @param int $ID
	 * @return \stdClass
	 */
	public function byId( $ID ) {
		$items = $this->reset()
					  ->addWhereEquals( 'id', $ID )
					  ->queryWithResult();
		return \array_shift( $items );
	}

	protected function buildOrderBy() :string {
		return $this->isCount() ? '' : parent::buildOrderBy();
	}

	public function buildQuery() :string {
		return sprintf( $this->getBaseQuery(),
			$this->buildSelect(),
			$this->getDbH()->getTable(),
			$this->buildWhere(),
			$this->buildExtras()
		);
	}

	protected function buildSelect() :string {
		$cols = $this->getColumnsToSelect();

		if ( $this->isCount() ) {
			$substitute = 'COUNT(*)';
		}
		elseif ( $this->isSum() ) {
			$substitute = sprintf( 'SUM(%s)', \array_shift( $cols ) );
		}
		elseif ( $this->isDistinct() && $this->hasColumnsToSelect() ) {
			$substitute = sprintf( 'DISTINCT %s', \implode( ',', $cols ) );
		}
		elseif ( $this->hasColumnsToSelect() ) {
			$substitute = \implode( ',', $cols );
		}
		elseif ( $this->isCustomSelect() ) {
			$substitute = $this->customSelect;
		}
		else {
			$substitute = '*';
		}
		return $substitute;
	}

	public function count() :int {
		return (int)$this->setIsCount( true )->queryWithResult();
	}

	/**
	 * @return int
	 */
	public function sum() {
		return $this->setIsSum( true )->queryWithResult();
	}

	public function sumColumn( string $column ) :int {
		return (int)$this->reset()
						 ->setColumnsToSelect( [ $column ] )
						 ->sum();
	}

	/**
	 * @return Record|\stdClass|mixed|null
	 */
	public function first() {
		$r = $this->setLimit( 1 )->queryWithResult();
		return empty( $r ) ? null : \array_shift( $r );
	}

	protected function getBaseQuery() :string {
		return "SELECT %s FROM `%s` %s %s";
	}

	public function getColumnsToSelect() :array {
		return \is_array( $this->columnsToSelect ) ? $this->columnsToSelect : [];
	}

	public function getDistinctForColumn( string $col ) :array {
		return $this->reset()
					->addColumnToSelect( $col )
					->setIsDistinct( true )
					->queryWithResult();
	}

	protected function getDistinct_FilterAndSort( string $col ) :array {
		$a = \array_filter( $this->getDistinctForColumn( $col ) );
		\natcasesort( $a );
		return $a;
	}

	protected function getSelectDataFormat() :string {
		if ( $this->isResultsAsVO() ) {
			$format = ARRAY_A;
		}
		else {
			$format = \in_array( $this->resultFormat, [ OBJECT_K, ARRAY_A ] ) ? $this->resultFormat : OBJECT_K;
		}
		return $format;
	}

	protected function hasColumnsToSelect() :bool {
		return \count( $this->getColumnsToSelect() ) > 0;
	}

	public function isCount() :bool {
		return $this->isCount;
	}

	public function isSum() :bool {
		return $this->isSum;
	}

	public function isCustomSelect() :bool {
		return !empty( $this->customSelect );
	}

	public function isDistinct() :bool {
		return $this->isDistinct;
	}

	public function isResultsAsVO() :bool {
		return ( $this->resultsAsVO ?? true ) && !$this->isSum();
	}

	/**
	 * COUNT, DISTINCT, & normal SELECT
	 */
	protected function execQuerySql() :bool {

		if ( $this->isCount() || $this->isSum() ) {
			$this->lastQueryResult = $this->queryVar();
		}
		elseif ( $this->isDistinct() ) {

			$this->lastQueryResult = $this->queryDistinct();
			if ( \is_array( $this->lastQueryResult ) ) {
				$this->lastQueryResult = \array_map( function ( $record ) {
					return \array_shift( $record );
				}, $this->lastQueryResult );
			}
			else {
				$this->lastQueryResult = [];
			}
		}
		else {
			$this->lastQueryResult = $this->querySelect();

			if ( $this->isResultsAsVO() && !empty( $this->lastQueryResult ) ) {
				$this->lastQueryResult = \array_map( function ( $record ) {
					return $this->getDbH()->getRecord()->applyFromArray( $record );
				}, $this->lastQueryResult );
			}
		}

		$this->reset();
		return $this->lastQueryResult !== null;
	}

	/**
	 * @return array[]
	 */
	protected function querySelect() {
		return Services::WpDb()->selectCustom( $this->buildQuery(), $this->getSelectDataFormat() );
	}

	/**
	 * @return int
	 */
	protected function queryVar() {
		return Services::WpDb()->getVar( $this->buildQuery() );
	}

	/**
	 * @return array[]
	 */
	protected function queryDistinct() {
		return Services::WpDb()->selectCustom( $this->buildQuery() );
	}

	/**
	 * @return $this
	 */
	public function reset() {
		parent::reset();
		return $this->setIsCount( false )
					->setIsDistinct( false )
					->setGroupBy( '' )
					->setSelectResultsFormat( '' )
					->setCustomSelect( '' )
					->setColumnsToSelect( [] )
					->clearWheres();
	}

	/**
	 * @return Record|mixed|\stdClass|null
	 */
	public function selectLatestById() {
		return $this->setOrderBy( 'id' )
					->setLimit( 1 )
					->first();
	}

	/**
	 * @return Record|mixed|\stdClass|null
	 */
	public function selectFirstById() {
		return $this->setOrderBy( 'id', 'ASC' )
					->setLimit( 1 )
					->first();
	}

	/**
	 * Verifies the given columns are valid and unique
	 * @param string[] $columns
	 * @return $this
	 */
	public function setColumnsToSelect( array $columns ) {
		$this->columnsToSelect = \array_intersect(
			$this->getDbH()->getTableSchema()->getColumnNames(),
			\array_map( '\strtolower', $columns )
		);
		return $this;
	}

	public function setCustomSelect( string $select ) {
		$this->customSelect = $select;
		return $this;
	}

	public function setIsCount( bool $isCount ) {
		$this->isCount = $isCount;
		return $this;
	}

	public function setIsSum( bool $sum ) {
		$this->isSum = $sum;
		return $this;
	}

	public function setIsDistinct( bool $distinct ) {
		$this->isDistinct = $distinct;
		return $this;
	}

	public function setResultsAsVo( bool $asVO ) {
		$this->resultsAsVO = $asVO;
		return $this;
	}

	public function setSelectResultsFormat( string $format ) {
		$this->resultFormat = $format;
		return $this;
	}
}