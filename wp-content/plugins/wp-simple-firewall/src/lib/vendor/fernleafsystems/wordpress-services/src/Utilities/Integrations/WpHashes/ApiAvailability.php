<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

use FernleafSystems\Wordpress\Services\Utilities\Options\Transient;

class ApiAvailability extends ApiBase {

	public const API_ENDPOINT = 'availability';
	public const API_VERSION = 2;
	public const REQUIRES_API_AVAILABILITY = false;

	public function getAvailableRoutes() :string {
		$routes = Transient::Get( 'apto-wphashes-api-available-routes' );
		if ( !\is_string( $routes ) ) {
			$result = $this->query();
			$routes = ( \is_array( $result ) && isset( $result[ 'routes_regex' ] ) ) ? $result[ 'routes_regex' ] : '';
			Transient::Set( 'apto-wphashes-api-available-routes', $routes, \MINUTE_IN_SECONDS*5 );
		}
		return $routes;
	}
}