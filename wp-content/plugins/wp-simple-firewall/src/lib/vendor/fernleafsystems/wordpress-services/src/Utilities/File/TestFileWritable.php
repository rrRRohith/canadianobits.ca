<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

class TestFileWritable {

	public const TEST_STRING = '/** ODP TEST STRING %s */';

	/**
	 * @param string $sPath
	 * @return bool
	 * @throws \Exception
	 */
	public function run( $sPath ) {
		if ( empty( $sPath ) ) {
			throw new \Exception( 'File path is empty' );
		}

		$oFs = Services::WpFs();
		if ( $oFs->isDir( $sPath ) ) {
			throw new \Exception( 'Path is a directory and not file-writable' );
		}

		if ( $oFs->exists( $sPath ) ) {
			$sContent = $oFs->getFileContent( $sPath );
			if ( is_null( $sContent ) ) {
				throw new \Exception( 'Could not read file contents' );
			}
		}
		else {
			$sContent = '';
		}

		{ // Insert test string and write to file
			$sTestString = sprintf( self::TEST_STRING, Services::WpGeneral()->getTimeStringForDisplay() );
			$aLines = \explode( "\n", $sContent );
			$aLines[] = $sTestString;
			$oFs->putFileContent( $sPath, \implode( "\n", $aLines ) );
		}

		{ // Re-read file contents and test for string
			$sContent = $oFs->getFileContent( $sPath );
			$bTestStringPresent = \strpos( $sContent, $sTestString ) !== false;
		}

		{ // Remove test string
			if ( $bTestStringPresent ) {
				$aLines = \explode( "\n", $sContent );
				array_pop( $aLines );
				$oFs->putFileContent( $sPath, \implode( "\n", $aLines ) );
			}
		}

		return $bTestStringPresent;
	}
}