<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Plugin\Core\Rest\Route\RouteBase;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property bool   $publish
 * @property string $limited_hosts - regex
 * @property array  $route_defs
 */
abstract class RestHandler extends DynPropertiesClass {

	/**
	 * @var RouteBase[]
	 */
	private $routes;

	public function __construct( array $config = [] ) {
		$this->applyFromArray( $config );
	}

	public function applyFromArray( $data, array $restrictedKeys = [] ) {
		return parent::applyFromArray( \array_merge( $this->getConfigDefaults(), $data ), $restrictedKeys );
	}

	public function init() {
		$this->preInit();
		if ( $this->isPublishRoutes() ) {
			foreach ( $this->buildRoutes() as $route ) {
				$route->register_routes();
			}
		}
	}

	protected function preInit() {
	}

	/**
	 * @return RouteBase[]
	 */
	protected function buildRoutes() :array {
		$routeClasses = [];
		$routes = $this->enumRoutes();
		foreach ( $routes as $routeSlug => $routeClass ) {
			$routeClasses[ $routeSlug ] = new $routeClass( $this->route_defs[ $routeSlug ] ?? [] );
		}
		return $routeClasses;
	}

	/**
	 * @return string[]
	 */
	protected function enumRoutes() :array {
		return [];
	}

	/**
	 * @return RouteBase[]
	 */
	public function getRoutes() :array {
		if ( !isset( $this->routes ) ) {
			$this->routes = $this->buildRoutes();
		}
		return $this->routes;
	}

	protected function isPublishRoutes() :bool {
		$publish = $this->publish ?? true;

		$host = \strtolower( Services::Request()->getHost() );
		if ( $publish && !empty( $host ) && !empty( $this->limited_hosts ) ) {
			$publish = \preg_match( sprintf( '#%s#i', $this->limited_hosts ), $host );
		}

		return (bool)$publish;
	}

	protected function getConfigDefaults() :array {
		return [
			'publish'       => false,
			'limited_hosts' => '',
			'route_defs'    => [],
		];
	}
}