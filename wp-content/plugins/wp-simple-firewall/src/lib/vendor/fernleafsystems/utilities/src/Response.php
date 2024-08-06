<?php

namespace FernleafSystems\Utilities;

use FernleafSystems\Utilities\Data\Adapter\StdClassAdapter;

class Response {

	use StdClassAdapter;

	/**
	 * @var string
	 */
	private $sErrorCode = null;

	/**
	 * @var string
	 */
	private $sErrorText = null;

	/**
	 * @var string
	 */
	private $sMessageText = null;

	/**
	 * @var boolean
	 */
	private $bSuccessful = null;

	/**
	 * @var array
	 */
	private $aDebug = array();

	/**
	 * @return array
	 */
	public function getData() {
		return $this->getRawDataAsArray();
	}

	/**
	 * @param string $sKey
	 * @return mixed|null
	 */
	public function getDataValue( $sKey ) {
		return $this->getParam( $sKey );
	}

	/**
	 * @return array
	 */
	public function getDebug() {
		return $this->aDebug;
	}

	/**
	 * @return string
	 */
	public function getErrorCode() {
		return $this->sErrorCode;
	}

	/**
	 * @return string
	 */
	public function getErrorText() {
		return $this->sErrorText;
	}

	/**
	 * @return string
	 */
	public function getMessageText() {
		return $this->sMessageText;
	}

	/**
	 * @param array $aData
	 * @return $this
	 */
	public function setData( $aData ) {
		return $this->applyFromArray( $aData );
	}

	/**
	 * @param array $aDebug
	 * @return $this
	 */
	public function setDebug( $aDebug ) {
		$this->aDebug = $aDebug;
		return $this;
	}

	/**
	 * @param string $sCode
	 * @return $this
	 */
	public function setErrorCode( $sCode ) {
		$this->sErrorCode = $sCode;
		return $this;
	}

	/**
	 * @param string $sText
	 * @return $this
	 */
	public function setErrorText( $sText ) {
		$this->sErrorText = $sText;
		return $this;
	}

	/**
	 * @param string $sText
	 * @return $this
	 */
	public function setMessageText( $sText ) {
		$this->sMessageText = $sText;
		return $this;
	}

	/**
	 * @param boolean $bSuccess
	 * @return $this
	 */
	public function setSuccessful( $bSuccess ) {
		$this->bSuccessful = $bSuccess;
		return $this;
	}

	/**
	 * @param string $sMessage
	 * @return $this
	 */
	public function addDebug( $sMessage ) {
		$this->aDebug[] = $sMessage;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function failed() {
		return !$this->successful();
	}

	/**
	 * @return boolean
	 */
	public function successful() {
		return $this->bSuccessful;
	}
}