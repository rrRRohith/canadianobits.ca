<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

class ExtractLinesFromFile {

	/**
	 * @param string $path
	 * @param int[]  $lineNumbers
	 * @return string[]
	 * @throws \Exception
	 */
	public function run( $path, $lineNumbers ) :array {
		return \array_intersect_key(
			( new GetFileAsArray() )->run( $path ),
			array_flip( $lineNumbers )
		);
	}
}