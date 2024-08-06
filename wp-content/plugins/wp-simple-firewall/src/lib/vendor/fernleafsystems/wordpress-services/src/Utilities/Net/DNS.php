<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;

class DNS {

	private static $Forward = [];

	private static $Reverse = [];

	public static function Forward( string $hostname ) :string {
		if ( !isset( self::$Forward[ $hostname ] ) ) {
			self::$Forward[ $hostname ] = @\gethostbyname( $hostname ); // returns hostname on failure
		}
		return self::$Forward[ $hostname ];
	}

	public static function Reverse( string $ip ) :string {
		if ( !isset( self::$Reverse[ $ip ] ) ) {
			self::$Reverse[ $ip ] = (string)@\gethostbyaddr( $ip ); // returns the ip or false on failure
		}
		return self::$Reverse[ $ip ];
	}

	public static function Resolves( string $ipHost ) :bool {
		$ipHost = \trim( $ipHost );
		if ( !empty( $ipHost ) ) {
			$resolved = Services::IP()->isValidIp( $ipHost ) ? self::Reverse( $ipHost ) : self::Forward( $ipHost );
			$resolves = !empty( $resolved ) && $resolved !== $ipHost;
		}
		else {
			$resolves = false;
		}
		return $resolves;
	}
}