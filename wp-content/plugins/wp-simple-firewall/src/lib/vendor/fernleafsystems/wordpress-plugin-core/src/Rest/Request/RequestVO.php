<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Request;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @property string $action
 * @property string $type
 */
class RequestVO extends DynPropertiesClass {

	/**
	 * @return string
	 */
	public function getCacheFileSlug() {
		$data = $this->getRawData();
		\ksort( $data );
		return \md5( \serialize( $data ) );
	}
}