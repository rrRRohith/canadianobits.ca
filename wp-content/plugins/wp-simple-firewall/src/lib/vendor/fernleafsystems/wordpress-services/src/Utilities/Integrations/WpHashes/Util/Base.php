<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Util;

use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

abstract class Base extends WpHashes\ApiBase {

	public const API_ENDPOINT = 'util';

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}
}