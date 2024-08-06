<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Verify;

use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

abstract class Base extends WpHashes\ApiBase {

	public const API_ENDPOINT = 'verify';
	public const RESPONSE_DATA_KEY = 'verification';
	public const REQUIRES_API_AVAILABILITY = false;

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}
}