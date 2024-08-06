<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;

class BaseIP {

	/**
	 * @return string[]
	 */
	public function getIpsFromSource( string $source ) :array {
		return \array_unique( \array_filter(
			\array_map( '\trim', \explode( ',', (string)Services::Request()->server( $source ) ) ),
			function ( $ip ) {
				if ( \substr_count( $ip, ':' ) === 1 ) { // "IP:PORT"
					$ip = \substr( $ip, 0, \strpos( $ip, ':' ) );
				}
				return \filter_var( $ip, \FILTER_VALIDATE_IP ) !== false;
			}
		) );
	}

	/**
	 * @return string[]
	 */
	public function getSources() :array {
		return [
			'REMOTE_ADDR',
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_REAL_IP',
			'HTTP_X_SUCURI_CLIENTIP',
			'HTTP_INCAP_CLIENT_IP',
			'HTTP_X_SP_FORWARDED_IP',
			'HTTP_FORWARDED',
			'HTTP_CLIENT_IP'
		];
	}

	/**
	 * @return string[]
	 * @deprecated
	 */
	public function getIpSourceOptions() :array {
		return [
			'REMOTE_ADDR',
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_REAL_IP',
			'HTTP_X_SUCURI_CLIENTIP',
			'HTTP_INCAP_CLIENT_IP',
			'HTTP_X_SP_FORWARDED_IP',
			'HTTP_FORWARDED',
			'HTTP_CLIENT_IP'
		];
	}
}