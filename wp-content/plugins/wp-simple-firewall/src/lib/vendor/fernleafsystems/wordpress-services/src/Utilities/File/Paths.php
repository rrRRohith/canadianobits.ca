<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

class Paths {

	public static function AddExt( string $path, string $ext ) :string {
		$ext = '.'.ltrim( $ext, '.' );
		return Services::Data()->getIfStringEndsIn( $path, $ext ) ? $path : rtrim( $path, '.' ).$ext;
	}

	public static function RemoveExt( string $path ) :string {
		$extStart = strrpos( $path, '.' );
		return $extStart === false ? $path : substr( $path, 0, $extStart );
	}

	/**
	 * Includes period.
	 */
	public static function Ext( string $path ) :string {
		$extStart = strrpos( $path, '.' );
		return $extStart === false ? '' : str_replace( '.', '', substr( $path, $extStart ) );
	}
}