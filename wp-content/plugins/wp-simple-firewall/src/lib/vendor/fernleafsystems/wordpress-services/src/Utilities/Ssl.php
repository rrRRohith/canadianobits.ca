<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

class Ssl {

	/**
	 * @var array
	 */
	private static $cache;

	public function __construct() {
		self::$cache = [];
	}

	public function isEnvSupported() :bool {
		$functions = [
			'stream_context_create',
			'stream_socket_client',
			'stream_context_get_params',
			'openssl_x509_parse',
		];

		$available = true;
		foreach ( $functions as $f ) {
			$available = $available && \function_exists( $f ) && \is_callable( $f );
		}

		return $available;
	}

	/**
	 * @param string $host
	 * @return array
	 * @throws \Exception
	 */
	public function getCertDetailsForDomain( $host ) {
		if ( !$this->isEnvSupported() ) {
			throw new \Exception( 'The environment does not support this' );
		}

		if ( \filter_var( $host, FILTER_VALIDATE_URL ) ) {
			$host = parse_url( $host, PHP_URL_HOST );
		}

		if ( empty( self::$cache[ $host ] ) ) {
			$context = stream_context_create(
				[
					'ssl' => [
						'capture_peer_cert' => true,
						'verify_peer'       => true,
						'verify_peer_name'  => true,
					]
				]
			);

			$socketClient = @stream_socket_client(
				sprintf( 'ssl://%s:443', $host ),
				$errno, $errstr, 3,
				STREAM_CLIENT_CONNECT,
				$context
			);

			if ( !is_resource( $socketClient ) ) {
				throw new \Exception( 'Stream Socket client failed to retrieve SSL Cert resource.' );
			}

			$responseParams = stream_context_get_params( $socketClient );
			if ( empty( $responseParams[ 'options' ][ 'ssl' ][ 'peer_certificate' ] ) ) {
				throw new \Exception( 'Peer Certificate field was empty in the response.' );
			}
			self::$cache[ $host ] = openssl_x509_parse( $responseParams[ 'options' ][ 'ssl' ][ 'peer_certificate' ] );
		}

		if ( empty( self::$cache[ $host ] ) ) {
			throw new \Exception( 'Parsing certificate failed.' );
		}

		return self::$cache[ $host ];
	}

	/**
	 * @param string $host
	 * @return int
	 */
	public function getExpiresAt( $host ) {
		$expiresAt = 0;
		try {
			$cert = $this->getCertDetailsForDomain( $host );
			if ( !empty( $cert[ 'validTo_time_t' ] ) ) {
				$expiresAt = $cert[ 'validTo_time_t' ];
			}
		}
		catch ( \Exception $e ) {
		}
		return $expiresAt;
	}
}