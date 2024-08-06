<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

/**
 * Useful so we know which new line character is used to split up the lines: "\n"
 * This is preferable to just using file()
 *
 * Class GetFileAsArray
 * @package FernleafSystems\Wordpress\Services\Utilities\File
 */
class GetFileAsArray {

	/**
	 * @param string $path
	 * @param string $splitOn
	 * @return string[]
	 * @throws \Exception
	 */
	public function run( $path ) :array {
		$FS = Services::WpFs();
		if ( !$FS->isFile( $path ) ) {
			throw new \InvalidArgumentException( 'File does not exist' );
		}

		$content = $FS->getFileContent( $path );
		if ( empty( $content ) ) {
			throw new \Exception( 'File is empty' );
		}

		return \preg_split( '/\r\n|\r|\n/', $content );
	}
}