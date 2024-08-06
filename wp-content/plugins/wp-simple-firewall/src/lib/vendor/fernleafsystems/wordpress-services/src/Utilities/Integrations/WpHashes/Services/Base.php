<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Services;

use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

abstract class Base extends WpHashes\ApiBase {

	public const API_ENDPOINT = 'services';
	public const REQUIRES_API_AVAILABILITY = false;

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}
}