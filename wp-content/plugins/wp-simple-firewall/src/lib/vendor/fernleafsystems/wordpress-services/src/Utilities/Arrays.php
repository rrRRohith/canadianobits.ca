<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

class Arrays {

	public static function SetAllValuesTo( array $arrayToSet, $value ) :array {
		return \array_fill_keys( \array_keys( $arrayToSet ), $value );
	}

	public static function RandomPluck( array $array, int $num = 1 ) :array {
		$num = \min( \count( $array ), \max( 1, $num ) );
		$rand = \array_rand( $array, $num );
		return \array_intersect_key( $array, \array_flip( $num > 1 ? $rand : [ $rand ] ) );
	}

	public static function MFU( array...$arrays ) :array {
		return self::Merge( 'fu', $arrays );
	}

	public static function MFUV( array...$arrays ) :array {
		return self::Merge( 'fuv', $arrays );
	}

	public static function Merge( string $flags, array...$arrays ) :array {
		$flags = \strtolower( $flags );
		$a = \array_merge( $arrays );
		if ( \str_contains( $flags, 'f' ) ) {
			$a = \array_filter( $a );
		}
		if ( \str_contains( $flags, 'u' ) ) {
			$a = \array_unique( $a );
		}
		if ( \str_contains( $flags, 'v' ) ) {
			$a = \array_values( $a );
		}
		return $a;
	}
}