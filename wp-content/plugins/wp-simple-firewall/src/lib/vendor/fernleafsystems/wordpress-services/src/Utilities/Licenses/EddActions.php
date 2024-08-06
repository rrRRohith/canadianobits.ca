<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Licenses;

class EddActions {

	/**
	 * @param string $url
	 * @return string
	 */
	public static function CleanUrl( $url ) {
		$url = preg_replace( '#^(https?:/{1,2})?(www\.)?#', '', mb_strtolower( \trim( $url ) ) );
		if ( \strpos( $url, '?' ) ) {
			$url = \explode( '?', $url, 2 )[ 0 ];
		}
		return sanitize_text_field( trailingslashit( $url ) );
	}
}