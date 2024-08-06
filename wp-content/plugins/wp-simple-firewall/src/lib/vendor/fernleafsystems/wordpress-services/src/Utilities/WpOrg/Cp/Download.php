<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Cp;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\HttpUtil;

class Download {

	/**
	 * @param string $version
	 * @throws \Exception
	 */
	public function version( $version ) :?string {
		$tmpFile = null;
		try {
			$url = $this->getZipDownloadUrl( $version );
			if ( !empty( $version ) ) {
				$tmpFile = ( new HttpUtil() )->downloadUrl( $url );
			}
		}
		catch ( \Exception $e ) {
		}
		return $tmpFile;
	}

	/**
	 * @return string|null
	 */
	private function getZipDownloadUrl( string $versionToFind ) {
		$url = null;
		$versions = @\json_decode( Services::HttpRequest()->getContent( Repo::GetUrlForVersions() ), true );

		if ( \is_array( $versions ) ) {
			foreach ( $versions as $version ) {
				if ( $version[ 'tag_name' ] == $versionToFind ) {
					$url = $version[ 'zipball_url' ];
					break;
				}
			}
		}

		return $url;
	}
}