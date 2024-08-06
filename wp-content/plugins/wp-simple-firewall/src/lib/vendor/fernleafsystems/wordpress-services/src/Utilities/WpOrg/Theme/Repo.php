<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

use FernleafSystems\Wordpress\Services;

class Repo extends Services\Utilities\WpOrg\Base\RepoBase {

	use Base;
	public const URL_VCS_ROOT = 'https://themes.svn.wordpress.org';

	/**
	 * @param string $slug
	 * @return string
	 */
	public static function GetUrlForTheme( $slug ) {
		return sprintf( '%s/%s', static::URL_VCS_ROOT, $slug );
	}

	/**
	 * @param string $slug
	 * @param string $version
	 */
	public static function GetUrlForThemeVersion( $slug, $version ) :string {
		return sprintf( '%s/%s', static::GetUrlForTheme( $slug ), $version );
	}

	/**
	 * @param string $slug
	 */
	public static function GetUrlForThemeVersions( $slug ) :string {
		return static::GetUrlForThemeVersion( $slug, '' );
	}

	/**
	 * @param string $fileFragment  - relative to the working plugin directory
	 * @param string $version
	 * @param bool   $useSiteLocale - unused
	 * @throws \Exception
	 */
	public function getVcsUrlForFileAndVersion( $fileFragment, $version = null, $useSiteLocale = true ) :string {
		if ( empty( $fileFragment ) ) {
			throw new \InvalidArgumentException( 'Theme file fragment path provided is empty' );
		}
		if ( empty( $version ) ) {
			$version = $this->getWorkingVersion();
		}
		if ( empty( $version ) ) {
			$version = ( new Versions() )
				->setWorkingSlug( $this->getWorkingSlug() )
				->latest();
		}

		return sprintf( '%s/%s',
			static::GetUrlForThemeVersion( $this->getWorkingSlug(), $version ), ltrim( $fileFragment, '/' ) );
	}
}