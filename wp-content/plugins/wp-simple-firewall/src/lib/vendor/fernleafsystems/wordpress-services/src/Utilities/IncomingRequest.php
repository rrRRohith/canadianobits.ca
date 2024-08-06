<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class IncomingRequest {

	/**
	 * @return array{version:string, url:string}
	 */
	public static function ParseWpFromUA( ?string $UA = null ) :?array {
		$matched = \preg_match(
			'#WordPress/(\d[.\d]{2,});\s+(https?://\S+)#i',
			\trim( \is_null( $UA ) ? Services::Request()->getUserAgent() : '' ),
			$matches
		);
		return $matched ? [
			'version' => $matches[ 1 ],
			'url'     => \mb_strtolower( $matches[ 2 ] ),
		] : null;
	}
}