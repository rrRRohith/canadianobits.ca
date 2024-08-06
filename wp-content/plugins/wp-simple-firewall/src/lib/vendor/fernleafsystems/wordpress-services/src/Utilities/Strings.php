<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

class Strings {

	public static function CamelToSnake( string $string ) :string {
		return \strtolower( \preg_replace( '#(?<!^)[A-Z]#', '_$0', $string ) );
	}

	public static function SnakeToCamel( string $string ) :string {
		return \lcfirst( \implode( '_', \array_map( '\ucfirst', \explode( '_', \trim( $string, '_' ) ) ) ) );
	}
}