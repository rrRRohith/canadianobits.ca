<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use FernleafSystems\Wordpress\Plugin\Core\Databases\Base\Record;

trait RecordConsumer {

	/**
	 * @var Record
	 */
	private $dbRecord;

	/**
	 * @return Record|mixed
	 */
	public function getRecord() {
		return $this->dbRecord;
	}

	/**
	 * @param Record $record
	 * @return $this
	 */
	public function setRecord( $record ) {
		$this->dbRecord = $record;
		return $this;
	}
}