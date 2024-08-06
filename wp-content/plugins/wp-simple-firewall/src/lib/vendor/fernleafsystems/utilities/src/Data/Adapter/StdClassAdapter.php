<?php

namespace FernleafSystems\Utilities\Data\Adapter;

/**
 * @deprecated 1.4
 */
trait StdClassAdapter {

	/**
	 * @var array
	 */
	private $aRaw;

	/**
	 * @param string $sProperty
	 * @return mixed
	 */
	public function __get( $sProperty ) {
		$aD = $this->getRawDataAsArray();
		return isset( $aD[ $sProperty ] ) ? $aD[ $sProperty ] : null;
	}

	/**
	 * @param string $sProperty
	 * @return bool
	 */
	public function __isset( $sProperty ) {
		return array_key_exists( $sProperty, $this->getRawDataAsArray() );
	}

	/**
	 * @param string $sProperty
	 * @param mixed  $mValue
	 * @return $this
	 */
	public function __set( $sProperty, $mValue ) {
		$aA = $this->getRawDataAsArray();
		$aA[ $sProperty ] = $mValue;
		return $this->applyFromArray( $aA );
	}

	/**
	 * @param string $sKey
	 * @return $this
	 */
	public function __unset( $sKey ) {
		$aD = $this->getRawDataAsArray();
		if ( array_key_exists( $sKey, $aD ) ) {
			unset( $aD[ $sKey ] );
			$this->applyFromArray( $aD );
		}
		return $this;
	}

	/**
	 * @param array $aDataValues associative with parameter keys and values
	 * @param array $aRestrictedKeys
	 * @return $this
	 */
	public function applyFromArray( $aDataValues, $aRestrictedKeys = [] ) {
		if ( !empty( $aRestrictedKeys ) ) {
			$aDataValues = array_intersect_key( $aDataValues, array_flip( $aRestrictedKeys ) );
		}
		$this->aRaw = $aDataValues;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function reset() {
		$this->aRaw = [];
		return $this;
	}

	/**
	 * @return \stdClass
	 * @deprecated
	 */
	public function getRawData() {
		return (object)$this->getRawDataAsArray();
	}

	/**
	 * @return array
	 */
	public function getRawDataAsArray() {
		if ( !is_array( $this->aRaw ) ) {
			$this->aRaw = [];
		}
		return $this->aRaw;
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mComparison
	 * @return bool
	 */
	public function isParam( $sKey, $mComparison ) {
		return ( $this->{$sKey} == $mComparison );
	}

	/**
	 * @param string $sKey
	 * @param array  $aDefault
	 * @return array
	 */
	public function getArrayParam( $sKey, $aDefault = [] ) {
		return is_array( $this->{$sKey} ) ? $this->{$sKey} : $aDefault;
	}

	/**
	 * @param string $sKey
	 * @param int    $nDefault
	 * @return int|float|null
	 */
	public function getNumericParam( $sKey, $nDefault = null ) {
		return is_numeric( $this->{$sKey} ) ? $this->{$sKey} : $nDefault;
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mDefault
	 * @return mixed
	 */
	public function getParam( $sKey, $mDefault = null ) {
		$mVal = $this->__get( $sKey );
		return is_null( $mVal ) ? $mDefault : $mVal;
	}

	/**
	 * @param string $sKey
	 * @param string $mDefault
	 * @return string
	 */
	public function getStringParam( $sKey, $mDefault = '' ) {
		$sVal = $this->getParam( $sKey, $mDefault );
		return ( !is_null( $sVal ) && is_string( $sVal ) ) ? trim( $sVal ) : $mDefault;
	}

	/**
	 * @param object $oRaw
	 * @return $this
	 * @deprecated use applyFromArray()
	 */
	public function setRawData( $oRaw ) {
		return $this->applyFromArray( (array)$oRaw );
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mValue
	 * @return $this
	 */
	public function setParam( $sKey, $mValue ) {
		return $this->__set( $sKey, $mValue );
	}

	/**
	 * @alias TODO remove
	 * @param string $sKey
	 * @param mixed  $mValue
	 * @return $this
	 */
	public function setRawDataItem( $sKey, $mValue ) {
		return $this->setParam( $sKey, $mValue );
	}
}