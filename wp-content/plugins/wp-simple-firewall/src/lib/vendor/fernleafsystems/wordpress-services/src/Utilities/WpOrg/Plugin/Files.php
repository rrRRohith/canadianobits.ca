<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services;

class Files extends Services\Utilities\WpOrg\Base\PluginThemeFilesBase {

	use Base;

	/**
	 * Given a full root path on the file system for a file, locate the plugin to which this file belongs.
	 */
	public function findPluginFromFile( string $fullPath ) :?Services\Core\VOs\Assets\WpPluginVo {
		$thePlugin = null;

		$fragment = $this->getPluginPathFragmentFromPath( $fullPath );

		if ( !empty( $fragment ) && \strpos( $fragment, '/' ) > 0 ) {
			$WPP = Services\Services::WpPlugins();
			$dir = \substr( $fragment, 0, \strpos( $fragment, '/' ) );
			foreach ( $WPP->getInstalledPluginFiles() as $pluginFile ) {
				if ( $dir == \dirname( $pluginFile ) ) {
					$thePlugin = $WPP->getPluginAsVo( $pluginFile );
					break;
				}
			}
		}
		return $thePlugin;
	}

	/**
	 * Verifies the file exists on the SVN repository for the particular version that's installed.
	 * @param string $fullFilePath
	 * @throws \InvalidArgumentException
	 */
	public function isValidFileFromPlugin( $fullFilePath ) :bool {

		$thePlugin = $this->findPluginFromFile( $fullFilePath );
		if ( !$thePlugin instanceof Services\Core\VOs\Assets\WpPluginVo ) {
			throw new \InvalidArgumentException( 'Not actually a plugin file.', 1 );
		}
		if ( !$thePlugin->isWpOrg() ) {
			throw new \InvalidArgumentException( 'Not a WordPress.org plugin.', 2 );
		}

		// if uses SVN tags, use that version. Otherwise trunk.
		return ( new Repo() )
			->setWorkingSlug( $thePlugin->slug )
			->setWorkingVersion( ( $thePlugin->svn_uses_tags ? $thePlugin->Version : 'trunk' ) )
			->existsInVcs( $this->getRelativeFilePathFromItsInstallDir( $fullFilePath ) );
	}

	/**
	 * @param string $fullPath
	 */
	public function replaceFileFromVcs( $fullPath ) :bool {
		$tmpFile = $this->getOriginalFileFromVcs( $fullPath );
		return !empty( $tmpFile ) && Services\Services::WpFs()->move( $tmpFile, $fullPath );
	}

	/**
	 * @param string $fullPath
	 */
	public function getOriginalFileFromVcs( $fullPath ) :?string {
		$tmpFile = null;
		$thePlugin = $this->findPluginFromFile( $fullPath );
		if ( !empty( $thePlugin ) ) {
			$tmpFile = ( new Repo() )
				->setWorkingSlug( $thePlugin->slug )
				->setWorkingVersion( ( $thePlugin->svn_uses_tags ? $thePlugin->Version : 'trunk' ) )
				->downloadFromVcs( $this->getRelativeFilePathFromItsInstallDir( $fullPath ) );
		}
		return $tmpFile;
	}

	/**
	 * @param string $file - can either be absolute, or relative to ABSPATH
	 * @return string|null - the path to the file, relative to Plugins Dir.
	 */
	public function getPluginPathFragmentFromPath( $file ) :?string {
		$fragment = null;

		if ( !Services\Services::WpFs()->isAbsPath( $file ) ) { // assume it's relative to ABSPATH
			$file = path_join( ABSPATH, $file );
		}
		$file = wp_normalize_path( $file );
		$pluginsDir = wp_normalize_path( WP_PLUGIN_DIR );

		if ( \strpos( $file, $pluginsDir ) === 0 ) {
			$fragment = \ltrim( \str_replace( $pluginsDir, '', $file ), '/' );
		}

		return $fragment;
	}

	/**
	 * Gets the path of the plugin file relative to its own home plugin dir. (not wp-content/plugins/)
	 * @param string $file
	 * @return string
	 */
	public function getRelativeFilePathFromItsInstallDir( $file ) {
		$relDirFragment = $this->getPluginPathFragmentFromPath( $file );
		return \substr( $relDirFragment, \strpos( $relDirFragment, '/' ) + 1 );
	}
}