<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @see     class-wp-http-requests-response.php to_array()
 * @property string $body
 * @property string $headers
 * @property array  $response
 * @property string $cookies
 * @property string $filename
 */
class WpHttpResponseVo extends DynPropertiesClass {

	/**
	 * @return int
	 */
	public function getCode() {
		return $this->response[ 'code' ];
	}
}