<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Wp;

use FernleafSystems\Wordpress\Services;

class Repo extends Services\Utilities\WpOrg\Base\RepoBase {

	public const URL_VCS_ROOT = 'https://core.svn.wordpress.org';
	public const URL_VCS_ROOT_IL8N = 'https://i18n.svn.wordpress.org';

	/**
	 * @param string $version
	 * @param bool   $useLocale
	 */
	public static function GetUrlForVersion( $version, $useLocale = true ) :string {
		return sprintf(
			'%s/tags/%s',
			$useLocale ? static::URL_VCS_ROOT_IL8N : static::URL_VCS_ROOT,
			$useLocale ? $version.'/dist' : $version
		);
	}

	public static function GetUrlForVersions() :string {
		return static::GetUrlForVersion( '' );
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
	 * @param bool   $useSiteLocale
	 */
	public function getVcsUrlForFileAndVersion( $fileFragment, $version, $useSiteLocale = true ) :string {
		if ( empty( $version ) ) {
			$version = Services\Services::WpGeneral()->getVersion();
		}
		return sprintf( '%s/%s', static::GetUrlForVersion( $version, $useSiteLocale ), \ltrim( $fileFragment, '/' ) );
	}
}