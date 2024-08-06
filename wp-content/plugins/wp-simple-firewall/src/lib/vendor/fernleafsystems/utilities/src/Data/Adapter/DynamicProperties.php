<?php

namespace FernleafSystems\Utilities\Data\Adapter;

/**
 * @deprecated
 */
trait DynamicProperties {

	private $raw = [];

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get( string $key ) {
		$data = $this->getRawData();
		return $data[ $key ] ?? null;
	}

	public function __isset( string $key ) :bool {
		return array_key_exists( $key, $this->getRawData() );
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 * @return $this
	 */
	public function __set( string $key, $value ) :self {
		$data = $this->getRawData();
		$data[ $key ] = $value;
		return $this->applyFromArray( $data );
	}

	/**
	 * @param string $key
	 * @return $this
	 */
	public function __unset( string $key ) {
		$data = $this->getRawData();
		if ( array_key_exists( $key, $data ) ) {
			unset( $data[ $key ] );
			$this->applyFromArray( $data );
		}
		return $this;
	}

	public function applyFromArray( $data, array $restrictedKeys = [] ) :self {
		if ( !empty( $restrictedKeys ) ) {
			$data = array_intersect_key( $data, array_flip( $restrictedKeys ) );
		}
		$this->raw = $data;
		return $this;
	}

	public function reset() :self {
		$this->raw = [];
		return $this;
	}

	public function getRawData() :array {
		return is_array( $this->raw ) ? $this->raw : [];
	}

	/**
	 * @return array
	 * @deprecated
	 */
	public function getRawDataAsArray() :array {
		return $this->getRawData();
	}
}