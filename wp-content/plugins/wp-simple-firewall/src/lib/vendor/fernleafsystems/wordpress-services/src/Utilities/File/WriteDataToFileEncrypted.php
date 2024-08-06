<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

class WriteDataToFileEncrypted {

	/**
	 * @param string $path
	 * @param string $data
	 * @param string $publicKey
	 * @param string $privateKeyForVerify - verify writing successful if private key supplied
	 * @throws \Exception
	 */
	public function run( $path, $data, $publicKey, $privateKeyForVerify = null ) :bool {
		$srvEncrypt = Services::Encrypt();

		$encrypted = $srvEncrypt->sealData( $data, $publicKey );
		if ( !$encrypted->success ) {
			throw new \Exception( 'Could not seal data with message: '.$encrypted->message );
		}

		$success = Services::WpFs()->putFileContent( $path, \json_encode( $encrypted->getRawData() ) );
		if ( $success && !empty( $privateKeyForVerify ) ) {
			$success = ( new ReadDataFromFileEncrypted() )->run( $path, $privateKeyForVerify ) === $data;
		}
		return $success;
	}
}