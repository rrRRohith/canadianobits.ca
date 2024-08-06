<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Malai;

abstract class Base extends \FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\ApiBase {

	public const API_VERSION = 2;
	public const TOKEN_REQUIRED = true;

	protected function getApiEndpoint() :string {
		return 'malai/malware/'.static::API_ENDPOINT;
	}
}