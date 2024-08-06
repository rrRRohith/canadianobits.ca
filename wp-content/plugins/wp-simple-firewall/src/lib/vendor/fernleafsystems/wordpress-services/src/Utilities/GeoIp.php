<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class GeoIp {

	public const URL_REDIRECTLI = 'https://api.redirect.li/v1/ip/';

	/**
	 * @var GeoIp
	 */
	protected static $oInstance = null;

	/**
	 * @var
	 */
	private $results;

	/**
	 * @return GeoIp
	 */
	public static function GetInstance() {
		if ( is_null( self::$oInstance ) ) {
			self::$oInstance = new self();
		}
		return self::$oInstance;
	}

	public function __construct() {
		$this->results = [];
	}

	/**
	 * @return string
	 */
	public function countryName( string $ip ) {
		return $this->lookupIp( $ip )[ 'countryName' ];
	}

	/**
	 * @return string - ISO2
	 */
	public function countryIso( string $ip ) {
		return $this->lookupIp( $ip )[ 'countryCode' ];
	}

	/**
	 * @return string[]
	 */
	public function lookupIp( string $ip ) {
		if ( empty( $this->results[ $ip ] ) ) {
			$this->results[ $ip ] = $this->redirectliIpLookup( $ip );
		}
		return $this->results[ $ip ];
	}

	private function redirectliIpLookup( string $ip ) :array {
		$oHttp = Services::HttpRequest();
		$data = @json_decode( $oHttp->getContent( self::URL_REDIRECTLI.$ip ), true );
		if ( empty( $data ) || !is_array( $data ) ) {
			$data = [];
		}
		return $data;
	}
}