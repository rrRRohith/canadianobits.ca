<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Route;

trait RestRouteConsumer {

	/**
	 * @var RouteBase|mixed
	 */
	private $route;

	/**
	 * @return RouteBase|mixed
	 */
	public function getRestRoute() {
		return $this->route;
	}

	/**
	 * @param RouteBase|mixed $route
	 */
	public function setRestRoute( $route ) {
		$this->route = $route;
		return $this;
	}
}