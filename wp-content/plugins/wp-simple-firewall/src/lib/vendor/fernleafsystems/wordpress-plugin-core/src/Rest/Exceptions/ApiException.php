<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Exceptions;

class ApiException extends \Exception {

	public const DEFAULT_ERROR_CODE = 500;
	public const DEFAULT_ERROR_SUBCODE = 1;

	private $subErrorCode;

	public function __construct( $message = '', $code = 0, int $subCode = 0, \Throwable $previous = null ) {
		parent::__construct( $message, empty( $code ) ? static::DEFAULT_ERROR_CODE : $code, $previous );
		$this->subErrorCode = $subCode;
	}

	public function getSubErrorCode() :int {
		return empty( $this->subErrorCode ) ? static::DEFAULT_ERROR_SUBCODE : $this->subErrorCode;
	}
}