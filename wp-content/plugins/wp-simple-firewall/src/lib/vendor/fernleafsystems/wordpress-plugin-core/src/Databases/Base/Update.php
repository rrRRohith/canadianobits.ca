<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base;

use FernleafSystems\Wordpress\Services\Services;

class Update extends Insert {

	/**
	 * @var array
	 */
	protected $updateWheres = [];

	/**
	 * @return array
	 */
	public function getUpdateData() {
		return $this->getInsertData();
	}

	public function getUpdateWheres() :array {
		return \is_array( $this->updateWheres ) ? $this->updateWheres : [];
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setUpdateData( $data ) {
		return $this->setInsertData( $data );
	}

	/**
	 * @param array $updateWheres
	 * @return $this
	 */
	public function setUpdateWheres( $updateWheres ) {
		$this->updateWheres = $updateWheres;
		return $this;
	}

	/**
	 * @param int $ID
	 * @return $this
	 */
	public function setUpdateId( $ID ) {
		$this->updateWheres = [ 'id' => $ID ];
		return $this;
	}

	/**
	 * @param Record $record
	 * @param array  $updateData
	 * @return bool
	 */
	public function updateEntry( $record, $updateData = [] ) :bool {
		return $this->updateRecord( $record, $updateData );
	}

	/**
	 * @param Record $record
	 * @param array  $updateData
	 * @return bool
	 */
	public function updateRecord( $record, $updateData = [] ) :bool {
		$success = false;

		if ( $record instanceof Record ) {

			$sch = $this->getDbH()->getTableSchema();
			$skipCols = [];
			foreach ( $updateData as $col => $value ) {

				$skipUpdate = ( $record->{$col} === $value )
							  || ( \is_numeric( $value ) && \stripos( $sch->getColumnType( $col ), 'int' ) !== false && $record->{$col} == $value );
				if ( $skipUpdate ) {
					$skipCols[] = $col;
				}
			}

			$updateData = \array_diff_key( $updateData, \array_flip( $skipCols ) );

			if ( empty( $updateData ) ) {
				$success = true;
			}
			elseif ( $this->updateById( $record->id, $updateData ) ) {
				$record->applyFromArray( \array_merge( $record->getRawData(), $updateData ) );
				$success = true;
			}
		}

		return $success;
	}

	/**
	 * @return bool true is success or no update necessary
	 */
	public function updateById( int $id, array $updateData = [] ) :bool {
		return $this->setUpdateId( $id )
					->setUpdateData( $updateData )
					->query();
	}

	protected function preQuery() :bool {
		$data = $this->getUpdateData();
		if ( !empty( $data ) && !isset( $data[ 'updated_at' ] ) && $this->getDbH()->getTableSchema()->has_updated_at ) {
			$data[ 'updated_at' ] = Services::Request()->ts();
			$this->setUpdateData( $data );
		}
		return !empty( $data );
	}

	protected function execQuerySql() :bool {
		$this->lastQueryResult = Services::WpDb()
										 ->updateRowsFromTableWhere(
											 $this->getDbH()->getTable(),
											 $this->getUpdateData(),
											 $this->getUpdateWheres()
										 );
		return (bool)$this->lastQueryResult;
	}
}