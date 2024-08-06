<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes;

abstract class Base extends \FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\ApiBase {

	public const API_ENDPOINT = 'cshashes';
	public const API_VERSION = 2;
}