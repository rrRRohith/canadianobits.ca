<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

class RemoveLineFromFile {

	/**
	 * @param string $path
	 * @param int    $lineNum
	 * @return string
	 * @throws \Exception
	 */
	public function run( $path, $lineNum ) {

		$lines = ( new GetFileAsArray() )->run( $path );
		if ( !\array_key_exists( $lineNum, $lines ) ) {
			throw new \Exception( 'Line does not exist.' );
		}

		$theLine = $lines[ $lineNum ];
		unset( $lines[ $lineNum ] );
		if ( !Services::WpFs()->putFileContent( $path, \implode( "\n", $lines ) ) ) {
			throw new \Exception( 'Could not write adjusted file.' );
		}

		return $theLine;
	}
}