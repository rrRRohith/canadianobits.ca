<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base;

use FernleafSystems\Wordpress\Services;

abstract class PluginThemeFilesBase {

	/**
	 * @param string $fullPath
	 */
	public function replaceFileFromVcs( $fullPath ) :bool {
		$tmpFile = $this->getOriginalFileFromVcs( $fullPath );
		return !empty( $tmpFile ) && Services\Services::WpFs()->move( $tmpFile, $fullPath );
	}

	/**
	 * Verifies the file exists on the SVN repository for the particular version that's installed.
	 * @param string $fullPath
	 * @throws \InvalidArgumentException
	 */
	public function verifyFileContents( $fullPath ) :bool {
		$tmpFile = $this->getOriginalFileFromVcs( $fullPath );
		return !empty( $tmpFile )
			   && ( new Services\Utilities\File\Compare\CompareHash() )->isEqualFiles( $tmpFile, $fullPath );
	}

	/**
	 * @param string $fullPath
	 * @return string
	 */
	public function getOriginalFileMd5FromVcs( $fullPath ) {
		$file = $this->getOriginalFileFromVcs( $fullPath );
		return empty( $file ) ? null : \md5_file( $file );
	}

	/**
	 * @param string $fullPath
	 */
	abstract public function getOriginalFileFromVcs( $fullPath ) :?string;

	/**
	 * Gets the path of the plugin file relative to its own home plugin dir. (not wp-content/plugins/)
	 * @param string $file
	 * @return string
	 */
	abstract public function getRelativeFilePathFromItsInstallDir( $file );
}