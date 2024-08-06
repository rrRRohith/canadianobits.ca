<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Cp;

use FernleafSystems\Wordpress\Services;

class Repo extends Services\Utilities\WpOrg\Base\RepoBase {

	public const URL_VCS_ROOT = 'https://raw.githubusercontent.com/ClassicPress/ClassicPress-release';
	public const URL_VCS_ROOT_IL8N = self::URL_VCS_ROOT;
	public const URL_VCS_VERSIONS = 'https://api.github.com/repos/ClassicPress/ClassicPress-release/releases';
	public const URL_VCS_VERSION = 'https://github.com/ClassicPress/ClassicPress-release/releases/tag';

	/**
	 * @param string $sVersion
	 * @return string
	 */
	public static function GetUrlForVersion( $sVersion ) {
		return sprintf( '%s/%s', static::URL_VCS_VERSION, $sVersion );
	}

	/**
	 * @param string $version
	 */
	public static function GetUrlForFiles( $version ) :string {
		return sprintf( '%s/%s', static::URL_VCS_ROOT, $version );
	}

	/**
	 * @return string
	 */
	public static function GetUrlForVersions() {
		return static::URL_VCS_VERSIONS;
	}

	/**
	 * @param string $fileFragment
	 * @param string $version
	 * @param bool   $useSiteLocale
	 */
	public function downloadFromVcs( $fileFragment, $version = null, $useSiteLocale = true ) :?string {
		$file = parent::downloadFromVcs( $fileFragment, $version, $useSiteLocale );
		if ( $useSiteLocale && empty( $file ) ) {
			$file = parent::downloadFromVcs( $fileFragment, $version, false );
		}
		return $file;
	}

	/**
	 * @param string $fileFragment
	 * @param string $version - leave empty to use the current version
	 * @param bool   $useSiteLocale
	 */
	public function existsInVcs( $fileFragment, $version = null, $useSiteLocale = true ) :bool {
		return parent::existsInVcs( $fileFragment, $version, $useSiteLocale )
			   || ( $useSiteLocale && parent::existsInVcs( $fileFragment, $version, false ) );
	}

	/**
	 * @param string $fileFragment
	 * @param string $version
	 * @param bool   $useSiteLocale - not yet used for ClassicPress
	 */
	public function getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale = true ) :string {
		if ( empty( $version ) ) {
			$version = Services\Services::WpGeneral()->getVersion();
		}
		return sprintf( '%s/%s', static::GetUrlForFiles( $version ), \ltrim( $fileFragment, '/' ) );
	}
}