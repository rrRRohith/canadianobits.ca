<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Utilities\File\ConvertLineEndings;

class DataManipulation {

	/**
	 * @param string $path
	 * @return string
	 */
	public function convertLineEndingsDosToLinux( $path ) :string {
		return ( new ConvertLineEndings() )->fileDosToLinux( $path );
	}

	/**
	 * @param string $path
	 * @return string
	 */
	public function convertLineEndingsLinuxToDos( $path ) :string {
		return ( new ConvertLineEndings() )->fileLinuxToDos( $path );
	}

	/**
	 * @param array $toConvert
	 */
	public function convertArrayToJavascriptDataString( $toConvert ) :string {
		$asJS = '';
		foreach ( $toConvert as $key => $value ) {
			$asJS .= sprintf( "'%s':'%s',", $key, $value );
		}
		return \trim( $asJS, ',' );
	}

	/**
	 * @param array $array
	 * @return \stdClass
	 */
	public function convertArrayToStdClass( $array ) :\stdClass {
		$object = new \stdClass();
		if ( !empty( $array ) && \is_array( $array ) ) {
			foreach ( $array as $key => $mValue ) {
				$object->{$key} = $mValue;
			}
		}
		return $object;
	}

	/**
	 * @param \stdClass $stdClass
	 * @return array
	 */
	public function convertStdClassToArray( $stdClass ) {
		return \json_decode( \json_encode( $stdClass ), true );
	}

	/**
	 * @param array    $array
	 * @param callable $callable
	 */
	public function arrayMapRecursive( $array, $callable ) :array {
		$mapped = [];
		foreach ( $array as $key => $value ) {
			if ( \is_array( $value ) ) {
				$mapped[ $key ] = $this->arrayMapRecursive( $value, $callable );
			}
			else {
				$mapped[ $key ] = \call_user_func( $callable, $value );
			}
		}
		return $mapped;
	}

	/**
	 * @param mixed $args,...
	 * @return array
	 */
	public function mergeArraysRecursive( $args ) {
		$aArgs = \array_values( \array_filter( \func_get_args(), 'is_array' ) );
		switch ( \count( $aArgs ) ) {

			case 0:
				$result = [];
				break;

			case 1:
				$result = \array_shift( $aArgs );
				break;

			case 2:
				[ $result, $aArray2 ] = $aArgs;
				foreach ( $aArray2 as $key => $Value ) {
					if ( !isset( $result[ $key ] ) ) {
						$result[ $key ] = $Value;
					}
					elseif ( !\is_array( $result[ $key ] ) || !\is_array( $Value ) ) {
						$result[ $key ] = $Value;
					}
					else {
						$result[ $key ] = $this->mergeArraysRecursive( $result[ $key ], $Value );
					}
				}
				break;

			default:
				$result = \array_shift( $aArgs );
				foreach ( $aArgs as $aArg ) {
					$result = $this->mergeArraysRecursive( $result, $aArg );
				}
				break;
		}

		return $result;
	}

	/**
	 * note: employs strict search comparison
	 * @param array $theArray
	 * @param mixed $mValue
	 * @param bool  $bFirstOnly - set true to only remove the first element found of this value
	 * @return array
	 */
	public function removeFromArrayByValue( $theArray, $mValue, $bFirstOnly = false ) :array {
		$keys = [];

		if ( $bFirstOnly ) {
			$mKey = \array_search( $mValue, $theArray, true );
			if ( $mKey !== false ) {
				$keys[] = $mKey;
			}
		}
		else {
			$keys = \array_keys( $theArray, $mValue, true );
		}

		foreach ( $keys as $mKey ) {
			unset( $theArray[ $mKey ] );
		}

		return $theArray;
	}

	/**
	 * @param array $aSubjectArray
	 * @param mixed $mValue
	 * @param int   $nDesiredPosition
	 * @return array
	 */
	public function setArrayValueToPosition( $aSubjectArray, $mValue, $nDesiredPosition ) {

		if ( $nDesiredPosition < 0 ) {
			return $aSubjectArray;
		}

		$nMaxPossiblePosition = \count( $aSubjectArray ) - 1;
		if ( $nDesiredPosition > $nMaxPossiblePosition ) {
			$nDesiredPosition = $nMaxPossiblePosition;
		}

		$nPosition = \array_search( $mValue, $aSubjectArray );
		if ( $nPosition !== false && $nPosition != $nDesiredPosition ) {

			// remove existing and reset index
			unset( $aSubjectArray[ $nPosition ] );
			$aSubjectArray = \array_values( $aSubjectArray );

			// insert and update
			// http://stackoverflow.com/questions/3797239/insert-new-item-in-array-on-any-position-in-php
			\array_splice( $aSubjectArray, $nDesiredPosition, 0, $mValue );
		}

		return $aSubjectArray;
	}

	/**
	 * @param array $theArray
	 * @return array
	 */
	public function shuffleArray( $theArray ) :array {
		$keys = \array_keys( $theArray );
		\shuffle( $keys );
		return \array_merge( \array_flip( $keys ), $theArray );
	}
}