<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services;

class Repo extends Services\Utilities\WpOrg\Base\RepoBase {

	use Base;

	public const URL_VCS_ROOT = 'https://plugins.svn.wordpress.org';
	public const URL_VCS_DOWNLOAD_VERSIONS = 'https://plugins.svn.wordpress.org/%s/tags/';
	public const URL_DOWNLOAD_SVN_FILE = 'https://plugins.svn.wordpress.org/%s/tags/%s/%s';

	/**
	 * @param string $slug
	 */
	public static function GetUrlForPlugin( $slug ) :string {
		return sprintf( '%s/%s', static::URL_VCS_ROOT, $slug );
	}

	/**
	 * @param string $slug
	 * @param string $version
	 */
	public static function GetUrlForPluginVersion( $slug, $version ) :string {
		if ( $version != 'trunk' ) {
			$version = sprintf( 'tags/%s', $version );
		}
		return sprintf( '%s/%s/', static::GetUrlForPlugin( $slug ), $version );
	}

	/**
	 * @param string $slug
	 */
	public static function GetUrlForPluginVersions( $slug ) :string {
		return static::GetUrlForPluginVersion( $slug, '' );
	}

	/**
	 * @param string $fileFragment  - relative to the working plugin directory
	 * @param string $version
	 * @param bool   $useSiteLocale - unused
	 * @throws \Exception
	 */
	public function getVcsUrlForFileAndVersion( $fileFragment, $version = null, $useSiteLocale = true ) :string {
		if ( empty( $fileFragment ) ) {
			throw new \InvalidArgumentException( 'Plugin file fragment path provided is empty' );
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
			\rtrim( static::GetUrlForPluginVersion( $this->getWorkingSlug(), $version ), '/' ),
			\ltrim( $fileFragment, '/' )
		);
	}
}