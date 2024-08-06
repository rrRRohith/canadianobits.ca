<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services\Utilities\HttpUtil;

class Download {

	use Base;

	/**
	 * @param string $version
	 * @return string|null
	 */
	public function getDownloadUrlForVersion( $version ) {
		$all = ( new Versions() )
			->setWorkingSlug( $this->getWorkingSlug() )
			->allVersionsUrls();

		if ( empty( $all[ $version ] ) ) {
			$url = null;
		}
		else {
			$url = add_query_arg( [
				'nostats' => '1'
			], $all[ $version ] );
		}

		return $url;
	}

	/**
	 * @throws \Exception
	 */
	public function latest() :?string {
		$url = ( new Versions() )
			->setWorkingSlug( $this->getWorkingSlug() )
			->latest();
		return empty( $url ) ? null : ( new HttpUtil() )->downloadUrl( $url );
	}

	/**
	 * @param string $version
	 * @throws \Exception
	 */
	public function version( $version ) :?string {
		$url = $this->getDownloadUrlForVersion( $version );
		return empty( $url ) ? null : ( new HttpUtil() )->downloadUrl( $url );
	}
}