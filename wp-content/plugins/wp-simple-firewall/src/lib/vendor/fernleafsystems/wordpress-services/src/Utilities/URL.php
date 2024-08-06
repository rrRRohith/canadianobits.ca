<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

class URL {

	public static function AddParam( string $url, string $param, $value ) :string {
		return self::Build( $url, [ $param => $value ] );
	}

	public static function Build( string $url, array $data = [], bool $urlEncodeIt = true, bool $urlEncodeRaw = true ) :string {
		if ( $urlEncodeIt ) {
			$data = $urlEncodeRaw ? \array_map( '\rawurlencode_deep', $data ) : \array_map( '\urlencode_deep', $data );
		}
		return add_query_arg( $data, $url );
	}

	public static function RemoveParam( string $url, string $param ) :string {
		return remove_query_arg( $param, $url );
	}

	public static function RemoveParams( string $url, array $params ) :string {
		return remove_query_arg( $params, $url );
	}
}