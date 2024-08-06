<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions;

class InvalidRequestParametersException extends ClientSideException {

	public const DEFAULT_ERROR_SUBCODE = 401;
}