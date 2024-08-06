<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class HttpUtil {

	/**
	 * @var string[]
	 */
	private $downloads;

	public function __construct() {
		$this->downloads = [];
		add_action( 'shutdown', [ $this, 'deleteDownloads' ] );
	}

	public function deleteDownloads() {
		$FS = Services::WpFs();
		foreach ( $this->downloads as $file ) {
			if ( $FS->exists( $file ) ) {
				$FS->deleteFile( $file );
			}
		}
	}

	/**
	 * @param string $url
	 * @param array  $validResponseCodes
	 * @return $this
	 * @throws \Exception
	 */
	public function checkUrl( $url, $validResponseCodes = [ 200, 304 ] ) {
		$request = new HttpRequest();
		if ( !$request->get( $url ) ) {
			throw new \Exception( $request->lastError->get_error_message() );
		}

		if ( !in_array( $request->lastResponse->getCode(), $validResponseCodes ) ) {
			throw new \Exception( 'Head Request Failed. Likely the version does not exist.' );
		}

		return $this;
	}

	/**
	 * @param string $url
	 * @throws \Exception
	 */
	public function downloadUrl( $url ) :string {
		/** @var string|\WP_Error $file */
		$file = download_url( $url );
		if ( is_wp_error( $file ) ) {
			throw new \Exception( $file->get_error_message() );
		}
		if ( !\realpath( $file ) ) {
			throw new \Exception( 'Downloaded file could not be found' );
		}
		$this->downloads[] = $file;
		return $file;
	}
}