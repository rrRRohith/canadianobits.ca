<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Licenses\Keyless;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\HttpRequest;

/**
 * @property string      $lookup_url_stub
 * @property string      $request_method
 * @property int         $timeout
 * @property HttpRequest $last_http_req
 */
abstract class Base extends DynPropertiesClass {

	public const DEFAULT_URL_STUB = 'https://api.getshieldsecurity.com/wp-json/apto-keyless';
	public const API_ACTION = '';
	public const API_VERSION = '2';

	/**
	 * @return array|null
	 */
	protected function sendReq() {
		$req = Services::HttpRequest();

		$bodyParams = \array_intersect_key(
			$this->getRawData(),
			\array_flip( $this->getRequestBodyParamKeys() )
		);

		$reqParams = [
			'timeout' => $this->timeout,
		];

		switch ( $this->request_method ) {

			case 'post':
				$reqParams[ 'body' ] = $bodyParams;
				$reqSuccess = $req->post( $this->getApiRequestUrl(), $reqParams );
				break;

			case 'get':
			default:
				// Doing it in the ['body'] on some sites fails with the params not passed through to query string.
				// if they're not using the newer WP Request() class. WP 4.6+
				$reqSuccess = $req->get(
					add_query_arg( $bodyParams, $this->getApiRequestUrl() ),
					$reqParams
				);
				break;
		}

		if ( $reqSuccess ) {
			$response = empty( $req->lastResponse->body ) ? [] : @json_decode( $req->lastResponse->body, true );
		}
		else {
			$response = null;
		}

		$this->last_http_req = $req;
		return $response;
	}

	protected function getApiRequestUrl() :string {
		return sprintf( '%s/v%s/%s', $this->lookup_url_stub, static::API_VERSION, static::API_ACTION );
	}

	/**
	 * @return string[]
	 */
	protected function getRequestBodyParamKeys() :array {
		return [];
	}

	/**
	 * @inheritDoc
	 */
	public function __get( string $key ) {

		$value = parent::__get( $key );

		switch ( $key ) {

			case 'request_method':
				if ( empty( $value ) ) {
					$value = 'get';
				}
				$value = strtolower( $value );
				break;

			case 'lookup_url_stub':
				if ( empty( $value ) ) {
					$value = static::DEFAULT_URL_STUB;
				}
				$value = rtrim( $value, '/' );
				break;

			case 'timeout':
				if ( empty( $value ) || !is_numeric( $value ) ) {
					$value = 60;
				}
				break;

			default:
				break;
		}

		return $value;
	}
}