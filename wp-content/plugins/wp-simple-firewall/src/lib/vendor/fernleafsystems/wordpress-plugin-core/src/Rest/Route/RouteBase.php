<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Route;

use FernleafSystems\Utilities\Data\Adapter\DynProperties;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Request\Process;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property bool       $registered
 * @property array      $authorization
 * @property bool       $use_lock
 * @property bool       $strict_parameters
 * @property string     $version
 * @property bool       $response_include_params
 * @property string[]   $methods
 * @property RouteCache $routeCache
 */
abstract class RouteBase extends \WP_REST_Controller {

	use DynProperties;

	public const ROUTE_METHOD = \WP_REST_Server::READABLE;

	public function __construct( array $params = [] ) {
		$this->applyFromArray( \array_merge( $this->getConfigDefaults(), $params ) );
	}

	/**
	 * https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#examples
	 */
	public function register_routes() {
		if ( !isset( $this->registered ) ) {
			$this->registered = true;
			if ( $this->isReady() ) {
				register_rest_route(
					$this->buildNamespace(),
					$this->buildRoutePath(),
					[ $this->buildRouteDefs() ]
				);
			}
		}
	}

	/**
	 * @param array[] $args
	 * @return array[]
	 */
	protected function applyRouteDefaults( array $args ) :array {
		return \array_map(
			function ( $arg ) {

				$arg[ 'validate_callback' ] = function ( $value, $request, $reqArgKey ) {
					return $this->validateRequestArg( $value, $request, $reqArgKey );
				};

				$arg[ 'sanitize_callback' ] = function ( $value, $request, $reqArgKey ) {
					return $this->sanitizeRequestArg( $value, $request, $reqArgKey );
				};

				return $arg;
			},
			$args
		);
	}

	public function buildRouteDefs() :array {
		return [
			'methods'             => $this->getRouteMethods(),
			'callback'            => function ( \WP_REST_Request $req ) {
				return $this->executeApiRequest( $req );
			},
			'permission_callback' => function ( \WP_REST_Request $req ) {
				return $this->verifyPermission( $req );
			},
			'args'                => $this->applyRouteDefaults( $this->getRouteArgs() ),
		];
	}

	public function getCacheHandler() :RouteCache {
		if ( !isset( $this->routeCache ) ) {
			$this->routeCache = new RouteCache( $this );
		}
		return $this->routeCache;
	}

	protected function buildNamespace() :string {
		return sprintf( '%s/v%s', $this->getNamespace(), $this->getVersion() );
	}

	protected function getNamespace() :string {
		return 'aptoweb';
	}

	public function getVersion() :string {
		return $this->version ?? '1';
	}

	public function buildRoutePath() :string {
		return '/'.trim( sprintf( '%s/%s',
				trim( $this->getRoutePathPrefix(), '/' ),
				trim( $this->getRoutePath(), '/' )
			), '/' );
	}

	abstract public function getRoutePath() :string;

	public function getRoutePathPrefix() :string {
		return '';
	}

	abstract protected function getRequestProcessorClass() :string;

	/**
	 * @return Process|mixed
	 */
	protected function getRequestProcessor() {
		$processorClass = $this->getRequestProcessorClass();
		return new $processorClass( $this );
	}

	/**
	 * @return array[]
	 */
	protected function getRouteArgs() :array {
		return \array_merge( $this->getRouteArgsDefaults(), $this->getRouteArgsCustom() );
	}

	protected function getRouteArgSchema( string $key ) :array {
		return [];
	}

	/**
	 * @return array[]
	 */
	protected function getRouteArgsCustom() :array {
		return [];
	}

	/**
	 * @return array[][]
	 */
	protected function getRouteArgsDefaults() :array {
		return [];
	}

	protected function getRouteSlug() :string {
		return \strtolower( ( new \ReflectionClass( $this ) )->getShortName() );
	}

	public function getRouteMethods() :array {
		return $this->methods ?? \array_map( '\trim', \explode( ',', static::ROUTE_METHOD ) );
	}

	public function getWorkingDir() :string {
		return '';
	}

	protected function isReady() :bool {
		return true;
	}

	/**
	 * @return Process|mixed
	 */
	protected function processRequest( \WP_REST_Request $req ) :array {
		return $this->getRequestProcessor()
					->setWpRestRequest( $req )
					->run();
	}

	protected function executeApiRequest( \WP_REST_Request $req ) :\WP_REST_Response {

		$data = $this->processRequest( $req );
		if ( $this->response_include_params ) {
			$data[ 'meta' ][ 'params' ] = $req->get_params();
		}
		$data = $this->adjustApiResponse( $data, $req );

		$response = new \WP_REST_Response();

		if ( $data[ 'error_code' ] === 0 ) {
			$response->set_status( $data[ 'http_status' ] ?? 200 );
			$response->header( 'Cache-Control', 'public, max-age='.$this->getCacheHandler()->expiration );
		}
		else {
			$response->set_status( $data[ 'http_status' ] ?? 500 );
			$response->header( 'Cache-Control', 'no-cache, must-revalidate' );
		}
		unset( $data[ 'http_status' ] );

		$response->set_data( $data );

		$this->finalAdjustApiResponse( $response, $req );
		return $response;
	}

	protected function adjustApiResponse( array $response, \WP_REST_Request $req ) :array {
		return $response;
	}

	protected function finalAdjustApiResponse( \WP_REST_Response $response, \WP_REST_Request $req ) {
	}

	/**
	 * @param string|mixed     $value
	 * @param \WP_REST_Request $request
	 * @param string           $reqArgKey
	 * @return \WP_Error|mixed
	 */
	protected function sanitizeRequestArg( $value, \WP_REST_Request $request, string $reqArgKey ) {
		try {
			$value = rest_sanitize_request_arg( $value, $request, $reqArgKey );
			if ( !is_wp_error( $value ) ) {
				$value = $this->customSanitizeRequestArg( $value, $request, $reqArgKey );
			}
		}
		catch ( \Exception $e ) {
			$value = new \WP_Error( 400, $e->getMessage() );
		}
		return $value;
	}

	/**
	 * @param string|mixed $value
	 * @return \WP_Error|bool
	 */
	protected function validateRequestArg( $value, \WP_REST_Request $request, string $reqArgKey ) {
		try {
			$valid = rest_validate_request_arg( $value, $request, $reqArgKey );
			if ( $valid === true ) { // retain WP_ERROR info
				$valid = $this->customValidateRequestArg( $value, $request, $reqArgKey );
			}
		}
		catch ( \Exception $e ) {
			$valid = new \WP_Error( 400, $e->getMessage() );
		}
		return $valid;
	}

	/**
	 * @param mixed            $value
	 * @param \WP_REST_Request $request
	 * @param string           $reqArgKey
	 * @return \WP_Error|mixed
	 * @throws \Exception
	 */
	protected function customSanitizeRequestArg( $value, \WP_REST_Request $request, string $reqArgKey ) {
		return $value;
	}

	/**
	 * @param string|mixed $value
	 * @return \WP_Error|true
	 * @throws \Exception
	 */
	protected function customValidateRequestArg( $value, \WP_REST_Request $request, string $reqArgKey ) {
		return true;
	}

	/**
	 * @return bool|\WP_Error
	 */
	protected function verifyPermission( \WP_REST_Request $req ) {
		$srvIP = Services::IP();
		$ip = Services::Request()->ip();

		$authorized = true;
		$auth = \is_array( $this->authorization ) ? $this->authorization : [];

		if ( !empty( $auth[ 'user_cap' ] ) ) {

			if ( !Services::WpUsers()->isUserLoggedIn() ) {
				$authorized = new \WP_Error( 403, 'You must be logged-in to access this resource.' );
			}
			elseif ( !current_user_can( $auth[ 'user_cap' ] ) ) {
				$authorized = new \WP_Error( 403, "You don't have permission to access this resource." );
			}
		}

		// Rest API routes may be called internally via WP-CLI. This should always be permitted and so
		// IP-based restrictions should only ever be applied when there's a valid IP.
		if ( !Services::WpGeneral()->isWpCli() ) {

			$authIPs = $auth[ 'ips' ] ?? [];
			$reverseDomains = (array)( $auth[ 'reverse_domains' ] ?? [] );

			if ( !empty( $authIPs ) || !empty( $reverseDomains ) ) {

				if ( !$srvIP->isValidIp( $ip ) ) {
					new \WP_Error( 403, 'A valid IP address is required to access this resource.', [ 'ip' => $ip ] );
				}

				try {
					if ( !empty( $authIPs ) && !$srvIP->IpIn( $ip, \is_array( $authIPs ) ? $authIPs : [] ) ) {
						$authorized = new \WP_Error( 403, "Your IP address isn't permitted to access this resource." );
					}
				}
				catch ( \Exception $e ) {
				}

				if ( !empty( $reverseDomains ) ) {
					$reqHost = \gethostbyaddr( $ip );
					if ( empty( $reqHost ) ) {
						$authorized = new \WP_Error( 403, "Your IP address isn't permitted to access this resource." );
					}
					else {
						foreach ( $reverseDomains as $rDomain ) {
							if ( empty( \preg_match( sprintf( '#%s$#i', \preg_quote( $rDomain, '#' ) ), $reqHost ) ) ) {
								$authorized = new \WP_Error( 403, "Your IP address isn't permitted to access this resource." );
								break;
							}
						}
					}
				}
			}
		}

		return $authorized;
	}

	protected function getConfigDefaults() :array {
		return [
			'response_include_params' => false,
			'strict_parameters'       => true,
			'use_lock'                => false,
			'authorization'           => [],
		];
	}
}