<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Code;

use FernleafSystems\Wordpress\Services\Services;

class AssessPhpFile {

	/**
	 * @throws \Exception
	 */
	public function isEmptyOfCode( string $file ) :bool {
		$this->canRun();

		$ext = \strtolower( Services::Data()->getExtension( $file ) );
		if ( !\in_array( $ext, [ 'php', 'php5', 'php7', 'phtml' ] ) ) {
			throw new \Exception( 'Not a standard PHP file.' );
		}
		if ( !Services::WpFs()->isFile( $file ) ) {
			throw new \Exception( 'File does not exist on disk.' );
		}

		$Ts = \array_values( \array_filter(
			token_get_all( $this->getRelevantContent( $file ) ),
			function ( $token ) {
				return \is_array( $token ) &&
					   !\in_array( $token[ 0 ], [ T_WHITESPACE, T_DOC_COMMENT, T_COMMENT, T_INLINE_HTML ] );
			}
		) );

		// If there is at least 1 token we assess it
		if ( !empty( $Ts ) ) {

			// If the 1st token isn't <?php
			if ( $Ts[ 0 ][ 0 ] !== T_OPEN_TAG ) {
				throw new \Exception( 'Irregular start to PHP file.' );
			}
			unset( $Ts[ 0 ] );

			$Ts = \array_values( $Ts );

			if ( \count( $Ts ) >= 3 ) {
				if ( $Ts[ 0 ][ 0 ] == T_DECLARE &&
					 $Ts[ 1 ][ 0 ] == T_STRING && $Ts[ 2 ][ 0 ] == T_LNUMBER ) {
					unset( $Ts[ 0 ], $Ts[ 1 ], $Ts[ 2 ] );

					$Ts = \array_values( $Ts );
				}
			}
		}

		return empty( $Ts );
	}

	private function printTokens( $Ts ) {
		foreach ( $Ts as $t ) {
			if ( \is_array( $t ) ) {
				echo "Line {$t[2]}: ", \token_name( $t[ 0 ] ), " ('{$t[1]}')", PHP_EOL;
			}
		}
	}

	private function getRelevantContent( $file ) :string {
		return \php_strip_whitespace( $file );
	}

	/**
	 * @throws \Exception
	 */
	private function canRun() {
		$constants = [
			'T_WHITESPACE',
			'T_DOC_COMMENT',
			'T_COMMENT',
			'T_INLINE_HTML',
			'T_OPEN_TAG',
			'T_DECLARE',
			'T_STRING',
			'T_LNUMBER',
		];
		$notDefined = \array_filter( $constants, function ( $constant ) {
			return !defined( $constant );
		} );
		if ( !empty( $notDefined ) ) {
			throw new \Exception( 'Not defined: '.implode( ', ', $notDefined ) );
		}
	}
}