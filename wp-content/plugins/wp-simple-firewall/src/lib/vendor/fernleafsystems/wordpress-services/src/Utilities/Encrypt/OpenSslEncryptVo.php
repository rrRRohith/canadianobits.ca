<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Encrypt;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @property bool             $success
 * @property int              $result
 * @property string           $cipher
 * @property ?string          $iv
 * @property string           $message
 * @property bool             $json_encoded
 * @property string           $sealed_data
 * @property string           $sealed_password
 * @property OpenSslEncryptVo $rc4_fallback
 */
class OpenSslEncryptVo extends DynPropertiesClass {

	/**
	 * @inheritDoc
	 */
	public function __get( string $key ) {

		$value = parent::__get( $key );

		switch ( $key ) {

			case 'sealed_data':
			case 'sealed_password':
				$value = \base64_decode( $value );
				break;

			case 'cipher':
				if ( empty( $value ) ) {
					$value = 'rc4'; // The default
				}
				break;

			default:
				break;
		}

		return $value;
	}

	/**
	 * @inheritDoc
	 */
	public function __set( string $key, $value ) {

		switch ( $key ) {

			case 'sealed_data':
			case 'sealed_password':
				$value = base64_encode( $value );
				break;

			default:
				break;
		}

		parent::__set( $key, $value );
	}
}