<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

class Obfuscate {

	public static function Email( string $email ) :string {
		[ $left, $right ] = \explode( '@', $email, 2 );
		return \substr( $left, 0, 1 ).'****'.\substr( $left, -1, 1 )
			   .'@'.
			   \substr( $right, 0, 1 ).'****'.\substr( $right, \strrpos( $right, '.' ) );
	}
}