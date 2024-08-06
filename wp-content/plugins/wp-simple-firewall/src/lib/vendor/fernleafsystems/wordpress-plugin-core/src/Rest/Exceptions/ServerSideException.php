<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions;

class ServerSideException extends ApiException {

	public const DEFAULT_ERROR_CODE = 500;
}