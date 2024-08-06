<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities;

class Uuid {

	/**
	 * https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid/15875555#15875555
	 */
	public function V4() :string {
		try {
			$uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
		}
		catch ( \Exception $e ) {
			try {
				$randomData = \random_bytes( 16 );
				$randomData[ 6 ] = chr( ord( $randomData[ 6 ] ) & 0x0f | 0x40 ); // set version to 0100
				$randomData[ 8 ] = chr( ord( $randomData[ 8 ] ) & 0x3f | 0x80 ); // set bits 6-7 to 10
				$uuid = vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split( bin2hex( $randomData ), 4 ) );
			}
			catch ( \Exception $e ) {
				// This is complete nonsense as we only need something that "looks like" a UUID4 for now.
				// https://stackoverflow.com/questions/11384589/what-is-the-correct-regex-for-matching-values-generated-by-uuid-uuid4-hex
				$pool = 'abcdef0123456789';
				$uuid = '';
				for ( $i = 0 ; $i < 32 ; $i++ ) {
					if ( $i === 12 ) {
						$char = '4';
					}
					elseif ( $i === 16 ) {
						$char = \substr( '89ab', wp_rand( 0, 3 ), 1 );;
					}
					else {
						$char = \substr( $pool, wp_rand( 0, \strlen( $pool ) - 1 ), 1 );
					}
					$uuid .= $char;
				}
			}
		}
		return $uuid;
	}

	/**
	 * ^[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}\Z
	 */
	public function convert32CharsToUUID4( string $base ) :string {
		return \vsprintf( '%s%s-%s-%s-%s-%s%s%s', \str_split( $base, 4 ) );
	}
}