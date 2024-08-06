<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

use FernleafSystems\Wordpress\Services\Utilities\HttpRequest;
use FernleafSystems\Wordpress\Services\Utilities\Integrations\RequestVO;
use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Exceptions\ApiTokenRequiredException;

abstract class ApiBase {

	public const API_URL = 'https://wphashes.com/api/apto-wphashes';
	public const API_VERSION = 1;
	public const API_ENDPOINT = '';
	public const REQUEST_TYPE = 'GET';
	public const RESPONSE_DATA_KEY = '';
	public const REQUIRES_API_AVAILABILITY = true;
	public const TOKEN_REQUIRED = false;

	protected static $API_TOKEN = '';

	/**
	 * @var RequestVO
	 */
	private $req;

	/**
	 * @var bool
	 */
	private $useQueryCache = false;

	private $enforceTokenRequirements;

	/**
	 * @var array
	 */
	private static $QueryCache = [];

	public function __construct( ?string $apiToken = null, bool $enforceTokenRequirements = true ) {
		$this->setApiToken( $apiToken );
		$this->enforceTokenRequirements = $enforceTokenRequirements;
	}

	protected function getApiUrl() :string {
		return sprintf( '%s/v%s/%s', static::API_URL, static::API_VERSION, $this->getApiEndpoint() );
	}

	protected function getApiEndpoint() :string {
		return static::API_ENDPOINT;
	}

	protected function getQueryData() :array {
		$data = [];
		if ( $this->enforceTokenRequirements && static::TOKEN_REQUIRED ) {
			$data[ 'token' ] = static::$API_TOKEN;
		}
		return $data;
	}

	/**
	 * @return RequestVO|mixed
	 */
	protected function getRequestVO() {
		return $this->req ?? $this->req = $this->newReqVO();
	}

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}

	/**
	 * @return array|mixed|null
	 */
	public function query() {
		$data = null;

		if ( $this->isMyRouteAvailable() ) {
			$data = $this->fireRequestDecodeResponse();
			if ( \is_array( $data ) && \strlen( static::RESPONSE_DATA_KEY ) > 0 ) {
				$data = $data[ static::RESPONSE_DATA_KEY ] ?? null;
			}
		}

		return $data;
	}

	protected function isMyRouteAvailable() :bool {
		$available = !static::REQUIRES_API_AVAILABILITY;
		if ( !$available ) {
			$routes = ( new ApiAvailability() )->getAvailableRoutes();
			$available = !empty( $routes ) && \preg_match( $routes, $this->getApiEndpoint() ) === 1;
		}
		return $available;
	}

	protected function fireRequestDecodeResponse() :?array {
		$decoded = null;
		try {
			$response = $this->fireRequest();
			if ( !empty( $response ) ) {
				$decoded = \json_decode( $response, true );
			}
		}
		catch ( ApiTokenRequiredException $e ) {
		}
		return \is_array( $decoded ) ? $decoded : null;
	}

	/**
	 * @throws ApiTokenRequiredException
	 */
	protected function fireRequest() :string {
		$this->preRequest();
		switch ( static::REQUEST_TYPE ) {
			case 'POST':
				$response = $this->fireRequest_POST();
				break;
			case 'GET':
			default:
				$response = $this->fireRequest_GET();
				break;
		}
		return \trim( $response );
	}

	/**
	 * @throws ApiTokenRequiredException
	 */
	protected function preRequest() {
		if ( $this->enforceTokenRequirements && static::TOKEN_REQUIRED && empty( static::$API_TOKEN ) ) {
			throw new ApiTokenRequiredException();
		}
	}

	protected function fireRequest_GET() :string {
		$response = null;

		$url = add_query_arg( $this->getQueryData(), $this->getApiUrl() );
		$sig = md5( $url );

		if ( $this->isUseQueryCache() && isset( self::$QueryCache[ $sig ] ) ) {
			$response = self::$QueryCache[ $sig ];
		}

		if ( is_null( $response ) ) {
			$response = ( new HttpRequest() )->getContent( $url, $this->getRequestDefaults() );
			if ( $this->isUseQueryCache() ) {
				self::$QueryCache[ $sig ] = $response;
			}
		}

		return (string)$response;
	}

	protected function fireRequest_POST() :string {
		$http = new HttpRequest();
		$http->post(
			add_query_arg( $this->getQueryData(), $this->getApiUrl() ),
			array_merge( $this->getRequestDefaults(), [
				'body' => $this->getRequestVO()->getRawData()
			] )
		);
		return $http->isSuccess() ? (string)$http->lastResponse->body : '';
	}

	public function isUseQueryCache() :bool {
		return (bool)$this->useQueryCache;
	}

	/**
	 * @return $this
	 */
	public function setApiToken( ?string $token ) {
		if ( \is_string( $token ) && \preg_match( '#^[a-z0-9]{32,}$#', $token ) ) {
			static::$API_TOKEN = $token;
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setUseQueryCache( bool $useQueryCache ) {
		$this->useQueryCache = $useQueryCache;
		return $this;
	}

	protected function getRequestDefaults() :array {
		return [];
	}
}