<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use Elliotchance\Iterator\AbstractPagedIterator;
use FernleafSystems\Wordpress\Plugin\Core\Databases\Base\Record;
use FernleafSystems\Wordpress\Plugin\Core\Databases\Base\Select;

class Iterator extends AbstractPagedIterator {

	use HandlerConsumer;

	public const PAGE_LIMIT = 50;

	/**
	 * @var Select|mixed
	 */
	private $selector;

	/**
	 * @var int
	 */
	private $totalSize;

	/**
	 * @var array
	 */
	private $customFilters = [];

	/**
	 * @return Record|mixed|null
	 */
	public function current() {
		return parent::current();
	}

	public function getCustomQueryFilters() :array {
		return \is_array( $this->customFilters ) ? $this->customFilters : [];
	}

	protected function getDefaultQueryFilters() :array {
		return [
			'orderby' => 'id',
			'order'   => 'ASC',
		];
	}

	protected function getFinalQueryFilters() :array {
		return \array_merge( $this->getDefaultQueryFilters(), $this->getCustomQueryFilters() );
	}

	/**
	 * @param int $page - always starts at 0
	 * @return array
	 */
	public function getPage( $page ) {
		$params = $this->getFinalQueryFilters();

		$this->getSelector()
			 ->setResultsAsVo( true )
			 ->setPage( $page + 1 ) // Pages start at 1, not zero.
			 ->setLimit( $this->getPageSize() )
			 ->setOrderBy( $params[ 'orderby' ], $params[ 'order' ] );

		return $this->runQuery();
	}

	/**
	 * @return int
	 */
	public function getPageSize() {
		return static::PAGE_LIMIT;
	}

	/**
	 * @return Select|mixed
	 */
	public function getSelector() {
		if ( empty( $this->selector ) ) {
			$this->selector = $this->getDbH()->getQuerySelector();
		}
		return $this->selector;
	}

	/**
	 * @return int
	 */
	public function getTotalSize() {
		if ( !isset( $this->totalSize ) ) {
			$this->totalSize = $this->runQueryCount();
		}
		return $this->totalSize;
	}

	/**
	 * @return Record[]|array
	 */
	protected function runQuery() {
		return ( clone $this->getSelector() )->queryWithResult();
	}

	protected function runQueryCount() :int {
		return ( clone $this->getSelector() )->count();
	}

	/**
	 * @param Select|mixed $selector
	 * @return $this
	 */
	public function setSelector( $selector ) {
		$this->selector = $selector;
		return $this;
	}
}