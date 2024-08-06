<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base;

use FernleafSystems\Wordpress\Services;

abstract class RepoBase {

	/**
	 * @param string $fileFragment
	 * @param string $version
	 * @param bool   $useSiteLocale
	 */
	public function downloadFromVcs( $fileFragment, $version = null, $useSiteLocale = true ) :?string {
		$url = $this->getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale );
		try {
			$tmpFile = ( new Services\Utilities\HttpUtil() )
				->checkUrl( $url )
				->downloadUrl( $url );
		}
		catch ( \Exception $e ) {
			$tmpFile = null;
		}
		return $tmpFile;
	}

	/**
	 * @param string $fileFragment
	 * @param string $version
	 * @param bool   $useSiteLocale
	 */
	public function getContentFromVcs( $fileFragment, $version = null, $useSiteLocale = true ) :?string {
		$url = $this->getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale );
		try {
			$downloadedFile = ( new Services\Utilities\HttpUtil() )
				->checkUrl( $url )
				->downloadUrl( $url );
			$content = Services\Services::WpFs()->getFileContent( $downloadedFile );
		}
		catch ( \Exception $e ) {
			$content = null;
		}
		return $content;
	}

	/**
	 * @param string $fileFragment  - path relative to the root dir of the object being tested. E.g. ABSPATH for
	 *                              WordPress or the plugin dir if it's a plugin.
	 * @param string $version       - leave empty to use the current version
	 * @param bool   $useSiteLocale
	 */
	public function existsInVcs( $fileFragment, $version = null, $useSiteLocale = true ) :bool {
		try {
			( new Services\Utilities\HttpUtil() )->checkUrl(
				$this->getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale )
			);
			$exists = true;
		}
		catch ( \Exception $e ) {
			$exists = false;
		}
		return $exists;
	}

	/**
	 * @param string $fileFragment
	 * @param string $version
	 * @param bool   $useSiteLocale
	 * @return string
	 */
	abstract public function getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale = true ) :string;
}