<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Route;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @property bool   $can_cache
 * @property string $request_file
 * @property bool   $is_touch
 * @property int    $expiration
 */
class RouteCache extends DynPropertiesClass {

	use RestRouteConsumer;
	use RestRequestConsumer;

	/**
	 * @param RouteBase|mixed $route
	 */
	public function __construct( $route ) {
		$this->route = $route;
	}

	public function __get( string $key ) {
		$val = parent::__get( $key );
		switch ( $key ) {
			case 'expiration':
				$val = (int)$val;
				break;
			default:
				break;
		}
		return $val;
	}

	/**
	 * @return array|null
	 */
	public function getCachedResponse() {
		return null;
	}

	public function storeCachedResponseData( array $data ) {
	}

	protected function getCacheFileFragment() :string {
		$d = $this->getWpRestRequest()->get_params();
		\ksort( $d );
		return \md5( \serialize( $d ) );
	}
}