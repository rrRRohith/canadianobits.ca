<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

use FernleafSystems\Wordpress\Services;

class Files extends Services\Utilities\WpOrg\Base\PluginThemeFilesBase {

	use Base;

	/**
	 * Given a full root path on the file system for a file, locate the plugin to which this file belongs.
	 * @param string $fullPath
	 * @return Services\Core\VOs\Assets\WpThemeVo|null
	 */
	public function findThemeFromFile( string $fullPath ) {
		$theTheme = null;

		$fragment = $this->getThemePathFragmentFromPath( $fullPath );

		if ( !empty( $fragment ) && \strpos( $fragment, '/' ) > 0 ) {
			$WPT = Services\Services::WpThemes();
			$dir = substr( $fragment, 0, \strpos( $fragment, '/' ) );
			foreach ( $WPT->getThemes() as $theme ) {
				if ( $dir == $theme->get_stylesheet() ) {
					$theTheme = $WPT->getThemeAsVo( $dir );
					break;
				}
			}
		}
		return $theTheme;
	}

	/**
	 * Verifies the file exists on the SVN repository for the particular version that's installed.
	 * @param string $sFullFilePath
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function isValidFileFromTheme( $sFullFilePath ) {

		$theTheme = $this->findThemeFromFile( $sFullFilePath );
		if ( !$theTheme instanceof Services\Core\VOs\Assets\WpThemeVo ) {
			throw new \InvalidArgumentException( 'Not actually a theme file.', 1 );
		}
		if ( !$theTheme->isWpOrg() ) {
			throw new \InvalidArgumentException( 'Not a WordPress.org theme.', 2 );
		}

		// if uses SVN tags, use that version. Otherwise trunk.
		return ( new Repo() )
			->setWorkingSlug( $theTheme->stylesheet )
			->setWorkingVersion( $theTheme->version )
			->existsInVcs( $this->getRelativeFilePathFromItsInstallDir( $sFullFilePath ) );
	}

	/**
	 * @param string $fullPath
	 * @return bool
	 */
	public function replaceFileFromVcs( $fullPath ) :bool {
		$tmpFile = $this->getOriginalFileFromVcs( $fullPath );
		return !empty( $tmpFile ) && Services\Services::WpFs()->move( $tmpFile, $fullPath );
	}

	/**
	 * Verifies the file exists on the SVN repository for the particular version that's installed.
	 * @param string $fullPath
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function verifyFileContents( $fullPath ) :bool {
		$tmpFile = $this->getOriginalFileFromVcs( $fullPath );
		return !empty( $tmpFile )
			   && ( new Services\Utilities\File\Compare\CompareHash() )->isEqualFiles( $tmpFile, $fullPath );
	}

	/**
	 * @param string $fullPath
	 */
	public function getOriginalFileFromVcs( $fullPath ) :?string {
		$tmpFile = null;
		$theTheme = $this->findThemeFromFile( $fullPath );
		if ( !empty( $theTheme ) ) {
			$tmpFile = ( new Repo() )
				->setWorkingSlug( $theTheme->stylesheet )
				->setWorkingVersion( $theTheme->version )
				->downloadFromVcs( $this->getRelativeFilePathFromItsInstallDir( $fullPath ) );
		}
		return $tmpFile;
	}

	/**
	 * @param string $sFile - can either be absolute, or relative to ABSPATH
	 * @return string|null - the path to the file relative to Plugins Dir.
	 */
	public function getThemePathFragmentFromPath( $sFile ) {
		$sFragment = null;

		if ( !Services\Services::WpFs()->isAbsPath( $sFile ) ) { // assume it's relative to ABSPATH
			$sFile = path_join( ABSPATH, $sFile );
		}
		$sFile = wp_normalize_path( $sFile );
		$sThemesDir = wp_normalize_path( get_theme_root() );

		if ( \strpos( $sFile, $sThemesDir ) === 0 ) {
			$sFragment = ltrim( str_replace( $sThemesDir, '', $sFile ), '/' );
		}

		return $sFragment;
	}

	/**
	 * Gets the path of the plugin file relative to its own home plugin dir. (not wp-content/plugins/)
	 * @param string $file
	 * @return string
	 */
	public function getRelativeFilePathFromItsInstallDir( $file ) {
		$relDirFragment = $this->getThemePathFragmentFromPath( $file );
		return \substr( $relDirFragment, \strpos( $relDirFragment, '/' ) + 1 );
	}
}