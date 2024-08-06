<?php

namespace FernleafSystems\Utilities\Data\Adapter;

trait DynProperties {

	private $raw = [];

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get( string $key ) {
		return $this->raw[ $key ] ?? null;
	}

	public function __isset( string $key ) :bool {
		return array_key_exists( $key, $this->raw );
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function __set( string $key, $value ) {
		$this->raw[ $key ] = $value;
	}

	/**
	 * @param string $key
	 */
	public function __unset( string $key ) {
		unset( $this->raw[ $key ] );
	}

	public function applyFromArray( array $data, array $restrictedKeys = [] ) {
		if ( !empty( $restrictedKeys ) ) {
			$data = array_intersect_key( $data, array_flip( $restrictedKeys ) );
		}
		$this->raw = $data;
		return $this;
	}

	public function reset() {
		$this->raw = [];
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