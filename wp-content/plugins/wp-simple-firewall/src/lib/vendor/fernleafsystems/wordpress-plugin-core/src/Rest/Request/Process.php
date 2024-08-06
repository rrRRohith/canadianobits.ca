<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Request;

use FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions\ApiException;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions\CouldNotObtainLockException;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions\InvalidRequestParametersException;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Route\RestRequestConsumer;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Route\RestRouteConsumer;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Route\RouteBase;
use FernleafSystems\Wordpress\Services\Services;

abstract class Process {

	use RestRouteConsumer;
	use RestRequestConsumer;

	/**
	 * @var RequestVO
	 */
	private $reqVO;

	/**
	 * @param RouteBase|mixed $route
	 */
	public function __construct( $route = null, \WP_REST_Request $restRequest = null ) {
		$this->setRestRoute( $route );
		if ( $restRequest instanceof \WP_REST_Request ) {
			$this->setWpRestRequest( $restRequest );
		}
	}

	public function run() :array {
		$route = $this->getRestRoute();

		$meta = $this->getResponseMeta();

		$locked = false;
		try {
			$this->verifyRequestParameters();

			if ( $route->use_lock ) {
				$locked = $this->lockStart();
			}

			// Begin processing.
			$cacher = $route->getCacheHandler();
			$cacher->setWpRestRequest( $this->getWpRestRequest() );

			$data = null;
			if ( $cacher->can_cache ) {
				$data = $cacher->getCachedResponse();
			}

			if ( \is_array( $data ) ) {
				$meta[ 'from_cache' ] = true;
			}
			else {
				$data = $this->process();
				if ( $cacher->can_cache ) {
					$cacher->storeCachedResponseData( $data );
				}
			}

			$dataKey = $this->getResponseResultsDataKey();
			$apiResponse = empty( $dataKey ) ? $data : [ $dataKey => $data ];
			$apiResponse[ 'error_code' ] = 0;
			$apiResponse[ 'http_status' ] = $this->getDefaultSuccessCode();
		}
		catch ( ApiException $e ) {
			$apiResponse = [
				'error_code'  => $e->getSubErrorCode(),
				'http_status' => $e->getCode(),
				'message'     => $e->getMessage(),
			];
		}

		$apiResponse[ 'meta' ] = $meta;

		if ( $locked ) {
			$this->lockEnd();
		}

		return $apiResponse;
	}

	protected function getDefaultSuccessCode() :int {
		return 200;
	}

	protected function postProcessResponseData( array $response ) :array {
		return $response;
	}

	/**
	 * @throws ApiException
	 */
	abstract protected function process() :array;

	/**
	 * Reviews all Query parameters and determines whether there are any extra parameters no part of the provisioned
	 * arguments. Generally there shouldn't be extras. This will terminate the request if extras are found.
	 * @throws InvalidRequestParametersException
	 */
	protected function verifyRequestParameters() :bool {
		if ( $this->getRestRoute()->strict_parameters ) {

			$req = $this->getWpRestRequest();
			$permittedParams = \array_merge( \array_keys( $req->get_attributes()[ 'args' ] ), [
				'rest_route',
				'_wpnonce'
			] );

			if ( \count( \array_diff_key( $req->get_params(), \array_flip( $permittedParams ) ) ) > 0 ) {
				throw new InvalidRequestParametersException(
					sprintf( 'Please only supply parameters that are permitted: %s',
						empty( $permittedParams ) ? 'none' : \implode( ', ', $permittedParams ) )
				);
			}
		}
		return true;
	}

	protected function getResponseResultsDataKey() :string {
		return '';
	}

	protected function getResponseBase() :array {
		return [];
	}

	protected function getResponseMeta() :array {
		return [
			'ts'          => Services::Request()->ts(),
			'api_version' => $this->getRestRoute()->getVersion(),
			'from_cache'  => false
		];
	}

	/**
	 * @return RequestVO|mixed
	 */
	protected function getRequestVO() {
		if ( !isset( $this->reqVO ) ) {
			$this->reqVO = $this->newReqVO()->applyFromArray( $this->wpRestRequest->get_params() );
		}
		return $this->reqVO;
	}

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}

	/**
	 * @throws CouldNotObtainLockException
	 */
	protected function lockStart() :bool {
		return false;
	}

	protected function lockEnd() {
	}
}