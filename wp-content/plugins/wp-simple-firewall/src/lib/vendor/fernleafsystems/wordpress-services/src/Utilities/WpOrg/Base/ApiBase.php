<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Utilities\Consumers\RequestCacheConsumer;

/**
 * @property array $fields
 */
abstract class ApiBase extends DynPropertiesClass {

	use RequestCacheConsumer;

	/**
	 * @return array[]
	 */
	protected function defaultParams() :array {
		return [];
	}
}