<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Encrypt\OpenSslEncryptVo;

class ReadDataFromFileEncrypted {

	/**
	 * @param string $path
	 * @param string $privateKey
	 * @return string
	 * @throws \Exception
	 */
	public function run( $path, $privateKey ) {
		$FS = Services::WpFs();
		if ( !$FS->exists( $path ) || !$FS->isFile( $path ) ) {
			throw new \Exception( 'File path does not exist: '.$path );
		}
		$rawFile = $FS->getFileContent( $path );
		if ( empty( $rawFile ) ) {
			throw new \Exception( 'Could not read data from file: '.$rawFile );
		}
		$rawData = @\json_decode( $rawFile, true );
		if ( empty( $rawData ) || !is_array( $rawData ) ) {
			throw new \Exception( 'Parsing raw data from file failed' );
		}

		$VO = ( new OpenSslEncryptVo() )->applyFromArray( $rawData );

		$data = Services::Encrypt()->openDataVo( $VO, $privateKey );
		if ( $data === false ) {
			throw new \Exception( 'Decrypting sealed data failed.' );
		}
		return $data;
	}
}