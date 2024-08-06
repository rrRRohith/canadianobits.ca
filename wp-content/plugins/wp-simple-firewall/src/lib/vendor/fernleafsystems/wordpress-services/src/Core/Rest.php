<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

class Rest {

	/**
	 * @param array{method: string, route: string, attributes: array} $req
	 */
	public function callInternal( array $req ) :\WP_REST_Response {
		$req = \array_merge( [
			'method'     => 'GET',
			'attributes' => []
		], $req );

		$internal = new \WP_REST_Request( $req[ 'method' ], $req[ 'route' ], $req[ 'attributes' ] );

		if ( !empty( $req[ 'query_params' ] ) ) {
			$internal->set_query_params( $req[ 'query_params' ] );
		}
		if ( !empty( $req[ 'body_params' ] ) ) {
			$internal->set_body_params( $req[ 'body_params' ] );
		}
		return rest_do_request( $internal );
	}

	public function getNamespace() :?string {
		$nameSpace = null;

		$route = $this->getRoute();
		if ( !empty( $route ) ) {
			$parts = \array_filter( \explode( '/', $route ) );
			if ( !empty( $parts ) ) {
				$nameSpace = \array_shift( $parts );
			}
		}
		return $nameSpace;
	}

	/**
	 * @return string|null
	 */
	public function getRoute() {
		$route = null;

		if ( $this->isRest() ) {
			$req = Services::Request();
			$WP = Services::WpGeneral();

			$route = $req->request( 'rest_route' );
			if ( empty( $route ) && $WP->isPermalinksEnabled() ) {
				$fullUri = $WP->getHomeUrl( $req->getPath() );
				$route = \substr( $fullUri, \strlen( get_rest_url( get_current_blog_id() ) ) );
			}
		}
		return $route;
	}

	public function isRest() :bool {
		$isRest = ( \defined( 'REST_REQUEST' ) && REST_REQUEST ) || !empty( $_REQUEST[ 'rest_route' ] );

		global $wp_rewrite;
		if ( !$isRest && \function_exists( 'rest_url' ) && \is_object( $wp_rewrite ) ) {
			$restUrlBase = get_rest_url( get_current_blog_id(), '/' );
			$restPath = \trim( \parse_url( $restUrlBase, PHP_URL_PATH ), '/' );
			$requestPath = \trim( Services::Request()->getPath(), '/' );
			$isRest = !empty( $requestPath ) && !empty( $restPath ) && ( \strpos( $requestPath, $restPath ) === 0 );
		}
		return $isRest;
	}

	/**
	 * @return string|null
	 * @deprecated
	 */
	protected function getPath() {
		return $this->getRoute();
	}
}