<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

class ExtractLineFromFile {

	/**
	 * @param string $path
	 * @param int    $lineNum
	 * @return string
	 * @throws \Exception
	 */
	public function run( $path, $lineNum ) {

		$lines = ( new ExtractLinesFromFile() )->run( $path, [ $lineNum ] );
		if ( !isset( $lines[ $lineNum ] ) ) {
			throw new \Exception( 'Line does not exist.' );
		}

		return $lines[ $lineNum ];
	}
}