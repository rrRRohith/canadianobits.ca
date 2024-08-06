<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base;

use FernleafSystems\Wordpress\Services\Services;

class Delete extends BaseQuery {

	private $isSoftDelete = false;

	private $allowEmptyWhere = false;

	protected function execQuerySql() :bool {
		$success = false;
		if ( $this->isSoftDelete && $this->getDbH()->getTableSchema()->hasColumn( 'deleted_at' ) ) {

			$updateWheres = [];
			foreach ( $this->getRawWheres() as $where ) {
				$updateWheres[ $where[ 0 ] ] = $where[ 2 ];
			}

			$updater = $this->getDbH()
							->getQueryUpdater()
							->setUpdateWheres( $updateWheres )
							->setUpdateData( [ 'deleted_at' => Services::Request()->ts(), ] );
			$success = $updater->query();
			$this->lastQueryResult = $updater->getLastQueryResult();
		}
		elseif ( empty( $this->buildWhere() ) && !$this->allowEmptyWhere ) {
			error_log( sprintf( 'Attempt to DELETE with empty WHERE with query: "%s"', $this->buildQuery() ) );
		}
		else {
			$success = parent::execQuerySql();
		}
		return $success;
	}

	public function all() :bool {
		return $this->query();
	}

	/**
	 * @param int $id
	 */
	public function deleteById( $id ) :bool {
		return $this->reset()
					->addWhereEquals( 'id', (int)$id )
					->query();
	}

	/**
	 * @param Record $record
	 * @return bool
	 * @deprecated
	 */
	public function deleteEntry( $record ) {
		return $this->deleteRecord( $record );
	}

	/**
	 * @param Record $record
	 */
	public function deleteRecord( $record ) :bool {
		return $this->deleteById( $record->id );
	}

	/**
	 * NOTE: Does not reset() before query, so may be customized with where.
	 * @param int    $maxEntries
	 * @param string $orderByColumn
	 * @param bool   $oldestFirst
	 * @return int
	 * @throws \Exception
	 */
	public function deleteExcess( $maxEntries, $orderByColumn = 'created_at', $oldestFirst = true ) {
		if ( $maxEntries === null ) {
			throw new \Exception( 'Max Entries not specified for table excess delete.' );
		}

		// The same WHEREs should apply
		$toDelete = $this->getDbH()
						 ->getQuerySelector()
						 ->setRawWheres( $this->getRawWheres() )
						 ->count() - $maxEntries;

		$countDeleted = ( $toDelete > 0 ) ?
			$this->setOrderBy( $orderByColumn, $oldestFirst ? 'ASC' : 'DESC' )
				 ->setLimit( $toDelete )
				 ->queryWithResult()
			: 0;
		return (int)$countDeleted;
	}

	protected function getBaseQuery() :string {
		return "DELETE FROM `%s` %s %s";
	}

	/**
	 * Offset never applies to DELETE
	 */
	protected function buildOffsetPhrase() :string {
		return '';
	}

	public function getDynamicWheres() :array {
		return [];
	}

	public function setIsHardDelete() {
		$this->isSoftDelete = false;
		return $this;
	}

	public function setIsSoftDelete() {
		$this->isSoftDelete = true;
		return $this;
	}

	public function setAllowEmptyWheres( bool $allow ) {
		$this->allowEmptyWhere = $allow;
		return $this;
	}
}