<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Wp;

use FernleafSystems\Wordpress\Services\Utilities\HttpUtil;

class Download {

	use Base;

	public const URL_DOWNLOAD = 'https://%swordpress.org/wordpress-%s%s.zip';

	/**
	 * @param string $version
	 * @param string $locale - defaults to en_US
	 * @return string
	 * @throws \Exception
	 */
	public function version( $version, $locale = '' ) :?string {

		$locale = \strtolower( $locale );
		if ( $locale == 'en_us' ) {
			$locale = '';
		}

		$locale = \str_replace( '-', '_', $locale );

		if ( \strpos( $locale, '_' ) ) {
			[ $pt1, $pt2 ] = \explode( '_', $locale );
			$locale = $pt1.'_'.\strtoupper( $pt2 );
		}

		$url = sprintf(
			static::URL_DOWNLOAD,
			( empty( $locale ) ? '' : $locale.'.' ),
			$version,
			( empty( $locale ) ? '' : '-'.$locale )
		);

		try {
			$tmpFile = ( new HttpUtil() )->downloadUrl( $url );
		}
		catch ( \Exception $e ) {
			$tmpFile = null;
		}
		return $tmpFile;
	}
}