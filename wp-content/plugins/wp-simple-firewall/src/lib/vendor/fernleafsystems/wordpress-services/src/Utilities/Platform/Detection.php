<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Platform;

use FernleafSystems\Wordpress\Services\Services;

class Detection {

	public static function Apache() :string {
		$version = '';
		$raw = \function_exists( 'apache_get_version' ) ? \apache_get_version() : false;
		if ( empty( $raw ) ) {
			$raw = (string)Services::Request()->env( 'SERVER_SOFTWARE' );
		}
		if ( !empty( $raw ) && \preg_match( '#Apache/([\d.]+)\s+#i', $raw, $matches ) ) {
			$version = $matches[ 1 ];
		}
		return $version;
	}

	public static function PHP( bool $cleaned = true, bool $includeMinor = true ) :string {
		$version = (string)( \defined( 'PHP_VERSION' ) ? PHP_VERSION : \phpversion() );
		if ( $cleaned && !empty( $version ) && \preg_match( '#^[0-9]+\.[0-9]+(\.[0-9]+)?#', $version, $matches ) ) {
			$version = $matches[ 0 ];
			if ( !$includeMinor && \substr_count( $version, '.' ) === 3 ) {
				$version = \substr( $version, 0, \strrpos( $version, '.' ) );
			}
		}
		return (string)$version;
	}
}