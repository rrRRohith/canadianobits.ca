<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Core\Upgrades;
use FernleafSystems\Wordpress\Services\Core\VOs\Assets;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\URL;

class Plugins {

	/**
	 * @var Assets\WpPluginVo[]
	 */
	private $loadedVOs = [];

	/**
	 * @param string $file
	 * @param bool   $bNetworkWide
	 * @return null|\WP_Error
	 */
	public function activate( $file, $bNetworkWide = false ) {
		return activate_plugin( $file, '', $bNetworkWide );
	}

	public function urlActivate( string $file, bool $networkWide = false ) :string {
		$params = [
			'_wpnonce' => wp_create_nonce( 'activate-plugin_'.$file ),
			'action'   => 'activate',
			'plugin'   => $file,
		];
		if ( $networkWide ) {
			$params[ 'networkwide' ] = 1;
		}
		return URL::Build( network_admin_url( 'plugins.php' ), $params );
	}

	public function urlDeactivate( string $file ) :string {
		return URL::Build( network_admin_url( 'plugins.php' ), [
			'_wpnonce' => wp_create_nonce( 'deactivate-plugin_'.$file ),
			'action'   => 'deactivate',
			'plugin'   => $file,
		] );
	}

	/**
	 * @param string $file
	 * @param bool   $bNetworkWide
	 * @return null|\WP_Error
	 */
	protected function activateQuietly( $file, $bNetworkWide = false ) {
		return activate_plugin( $file, '', $bNetworkWide, true );
	}

	/**
	 * @param string $file
	 * @param bool   $bNetworkWide
	 */
	public function deactivate( $file, $bNetworkWide = false ) {
		deactivate_plugins( $file, '', $bNetworkWide );
	}

	/**
	 * @param string $file
	 * @param bool   $bNetworkWide
	 */
	protected function deactivateQuietly( $file, $bNetworkWide = false ) {
		deactivate_plugins( $file, true, $bNetworkWide );
	}

	/**
	 * @param string $file
	 * @param bool   $bNetworkWide
	 * @return bool
	 */
	public function delete( $file, $bNetworkWide = false ) {
		if ( !$this->isInstalled( $file ) ) {
			return false;
		}

		if ( $this->isActive( $file ) ) {
			$this->deactivate( $file, $bNetworkWide );
		}
		$this->uninstall( $file );

		// delete the folder
		$sPluginDir = dirname( $file );
		if ( $sPluginDir == '.' ) { //it's not within a sub-folder
			$sPluginDir = $file;
		}
		$sPath = path_join( WP_PLUGIN_DIR, $sPluginDir );
		return Services::WpFs()->deleteDir( $sPath );
	}

	/**
	 * @param string $url
	 * @param bool   $bOverwrite
	 * @return array
	 */
	public function install( $url, $bOverwrite = true ) {

		$oSkin = Services::WpGeneral()->getWordpressIsAtLeastVersion( '5.3' ) ?
			new Upgrades\UpgraderSkin()
			: new Upgrades\UpgraderSkinLegacy();
		$oUpgrader = new \Plugin_Upgrader( $oSkin );
		add_filter( 'upgrader_package_options', function ( $aOptions ) use ( $bOverwrite ) {
			$aOptions[ 'clear_destination' ] = $bOverwrite;
			return $aOptions;
		} );

		$mResult = $oUpgrader->install( $url );

		return [
			'successful'  => $mResult === true,
			'feedback'    => $oSkin->getIcwpFeedback(),
			'plugin_info' => $oUpgrader->plugin_info(),
			'errors'      => is_wp_error( $mResult ) ? $mResult->get_error_messages() : [ 'no errors' ]
		];
	}

	/**
	 * @param $slug
	 * @return array|bool
	 */
	public function installFromWpOrg( $slug ) {
		include_once( ABSPATH.'wp-admin/includes/plugin-install.php' );

		$api = plugins_api( 'plugin_information', [
			'slug'   => $slug,
			'fields' => [
				'sections' => false,
			],
		] );

		if ( !is_wp_error( $api ) ) {
			return $this->install( $api->download_link );
		}
		return false;
	}

	public function reinstall( string $file, bool $useBackup = false ) :bool {
		$success = false;

		if ( $this->isInstalled( $file ) ) {

			$slug = $this->getSlug( $file );
			if ( !empty( $slug ) ) {

				$dir = \dirname( path_join( WP_PLUGIN_DIR, $file ) );
				$backupDir = WP_PLUGIN_DIR.'/../'.\basename( $dir ).'bak'.\time();
				if ( $useBackup ) {
					\rename( $dir, $backupDir );
				}

				$installResult = $this->installFromWpOrg( $slug );
				$success = (bool)$installResult[ 'successful' ];
				if ( $success ) {
					wp_update_plugins(); //refreshes our update information
					if ( $useBackup ) {
						Services::WpFs()->deleteDir( $backupDir );
					}
				}
				elseif ( $useBackup ) {
					Services::WpFs()->deleteDir( $dir );
					\rename( $backupDir, $dir );
				}
			}
		}
		return $success;
	}

	/**
	 * @param string $file
	 * @return array
	 */
	public function update( $file ) {
		require_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );

		$wasActive = $this->isActive( $file );

		$upgraderSkin = new \Automatic_Upgrader_Skin();
		$mResult = ( new \Plugin_Upgrader( $upgraderSkin ) )->bulk_upgrade( [ $file ] );

		$success = false;
		if ( \is_array( $mResult ) && isset( $mResult[ $file ] ) ) {
			$mResult = \array_shift( $mResult );
			$success = !empty( $mResult ) && \is_array( $mResult );
		}

		if ( $wasActive && !$this->isActive( $file ) ) {
			$this->activate( $file );
		}

		return [
			'successful' => $success,
			'feedback'   => $upgraderSkin->get_upgrade_messages(),
			'errors'     => is_wp_error( $mResult ) ? $mResult->get_error_messages() : [ 'no errors' ]
		];
	}

	/**
	 * @param string $file
	 * @return true
	 */
	public function uninstall( $file ) {
		return uninstall_plugin( $file );
	}

	/**
	 * @return bool|null
	 */
	protected function checkForUpdates() {

		if ( \class_exists( 'WPRC_Installer' ) && \method_exists( 'WPRC_Installer', 'wprc_update_plugins' ) ) {
			\WPRC_Installer::wprc_update_plugins();
			return true;
		}
		elseif ( \function_exists( 'wp_update_plugins' ) ) {
			return ( wp_update_plugins() !== false );
		}
		return null;
	}

	protected function clearUpdates() {
		$oWp = Services::WpGeneral();
		$sKey = 'update_plugins';
		$oResponse = Services::WpGeneral()->getTransient( $sKey );
		if ( !is_object( $oResponse ) ) {
			$oResponse = new \stdClass();
		}
		$oResponse->last_checked = 0;
		$oWp->setTransient( $sKey, $oResponse );
	}

	/**
	 * @param string $sValueToCompare
	 * @param string $sKey
	 * @return null|string
	 */
	public function findPluginBy( $sValueToCompare, $sKey = 'Name' ) {
		$sFilename = null;

		if ( !empty( $sValueToCompare ) ) {
			foreach ( $this->getPlugins() as $sBaseFileName => $aPluginData ) {
				if ( isset( $aPluginData[ $sKey ] ) && $sValueToCompare == $aPluginData[ $sKey ] ) {
					$sFilename = $sBaseFileName;
				}
			}
		}

		return $sFilename;
	}

	/**
	 * @param string $dirName
	 * @return string|null
	 */
	public function findPluginFileFromDirName( $dirName ) {
		$theFile = null;
		if ( !empty( $dirName ) ) {
			foreach ( $this->getInstalledPluginFiles() as $file ) {
				if ( \strpos( $file, $dirName.'/' ) === 0 ) {
					$theFile = $file;
					break;
				}
			}
		}
		return $theFile;
	}

	/**
	 * @param string $file - plugin base file, e.g. wp-folder/wp-plugin.php
	 * @return string
	 */
	public function getInstallationDir( $file ) {
		return wp_normalize_path( dirname( path_join( WP_PLUGIN_DIR, $file ) ) );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getLinkPluginActivate( $file ) {
		return add_query_arg( [
			'action'   => 'activate',
			'plugin'   => urlencode( $file ),
			'_wpnonce' => wp_create_nonce( 'activate-plugin_'.$file )
		], self_admin_url( 'plugins.php' ) );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getLinkPluginDeactivate( $file ) {
		return add_query_arg( [
			'action'   => 'deactivate',
			'plugin'   => urlencode( $file ),
			'_wpnonce' => wp_create_nonce( 'deactivate-plugin_'.$file )
		], self_admin_url( 'plugins.php' ) );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getLinkPluginUpgrade( $file ) {
		return add_query_arg( [
			'action'   => 'upgrade-plugin',
			'plugin'   => urlencode( $file ),
			'_wpnonce' => wp_create_nonce( 'upgrade-plugin_'.$file )
		], self_admin_url( 'update.php' ) );
	}

	/**
	 * @param string $file
	 * @return array|null
	 */
	public function getPlugin( $file ) {
		return $this->isInstalled( $file ) ? $this->getPlugins()[ $file ] : null;
	}

	public function getPluginAsVo( string $file, bool $reload = false ) :?Assets\WpPluginVo {
		if ( !\is_array( $this->loadedVOs ) ) {
			$this->loadedVOs = [];
		}
		try {
			if ( $reload || !isset( $this->loadedVOs[ $file ] ) ) {
				$this->loadedVOs[ $file ] = new Assets\WpPluginVo( $file );
			}
		}
		catch ( \Exception $e ) {
		}
		return $this->loadedVOs[ $file ] ?? null;
	}

	/**
	 * @param string $file
	 * @return null|\stdClass
	 */
	public function getPluginDataAsObject( $file ) {
		$plugin = $this->getPlugin( $file );
		return \is_null( $plugin ) ? null : Services::DataManipulation()->convertArrayToStdClass( $plugin );
	}

	/**
	 * @param string $file
	 * @return int
	 */
	public function getActivePluginLoadPosition( $file ) {
		$position = \array_search( $file, $this->getActivePlugins() );
		return ( $position === false ) ? -1 : $position;
	}

	public function getActivePlugins() :array {
		$WP = Services::WpGeneral();
		$active = $WP->getOption( $WP->isMultisite() ? 'active_sitewide_plugins' : 'active_plugins' );
		return \is_array( $active ) ? $active : [];
	}

	public function getInstalledBaseFiles() :array {
		return \array_keys( $this->getPlugins() );
	}

	/**
	 * @return string[]
	 */
	public function getInstalledPluginFiles() :array {
		return \array_keys( $this->getPlugins() );
	}

	/**
	 * @return string[]
	 */
	public function getInstalledWpOrgPluginFiles() {
		return \array_keys( \array_filter(
			$this->getPluginsAsVo(),
			function ( $plugin ) {
				return $plugin->isWpOrg();
			}
		) );
	}

	/**
	 * @return array[]
	 */
	public function getPlugins() :array {
		if ( !\function_exists( 'get_plugins' ) ) {
			require_once( ABSPATH.'wp-admin/includes/plugin.php' );
		}
		return \function_exists( 'get_plugins' ) ? get_plugins() : [];
	}

	/**
	 * @return Assets\WpPluginVo[]
	 */
	public function getPluginsAsVo() :array {
		$plugins = [];
		foreach ( $this->getInstalledPluginFiles() as $pluginFile ) {
			$plugins[ $pluginFile ] = $this->getPluginAsVo( $pluginFile );
		}
		return $plugins;
	}

	/**
	 * @return \stdClass[] - keys are plugin base files
	 */
	public function getAllExtendedData() {
		$data = Services::WpGeneral()->getTransient( 'update_plugins' );
		return \array_merge(
			( isset( $data->no_update ) && \is_array( $data->no_update ) ) ? $data->no_update : [],
			( isset( $data->response ) && \is_array( $data->response ) ) ? $data->response : []
		);
	}

	/**
	 * @param string $baseFile
	 * @return array
	 */
	public function getExtendedData( $baseFile ) :array {
		$ext = [];
		$data = $this->getAllExtendedData();
		if ( !empty( $data[ $baseFile ] ) ) {
			$ext = \is_array( $data[ $baseFile ] ) ? $data[ $baseFile ]
				: Services::DataManipulation()->convertStdClassToArray( $data[ $baseFile ] );
		}
		return \is_array( $ext ) ? $ext : [];
	}

	public function getAllSlugs() :array {
		$slugs = [];

		foreach ( $this->getAllExtendedData() as $basename => $data ) {
			if ( isset( $data->slug ) ) {
				$slugs[ $basename ] = $data->slug;
			}
		}

		return $slugs;
	}

	/**
	 * @param $baseName
	 * @return string
	 */
	public function getSlug( $baseName ) {
		$info = $this->getExtendedData( $baseName );
		return $info[ 'slug' ] ?? '';
	}

	/**
	 * @param string $baseName
	 * @return bool
	 * @deprecated 1.1.17
	 */
	public function isWpOrg( $baseName ) {
		return $this->getPluginAsVo( $baseName )->isWpOrg();
	}

	/**
	 * @param string $file
	 * @return \stdClass|null
	 */
	public function getUpdateInfo( $file ) {
		return $this->getUpdates()[ $file ] ?? null;
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getUpdateNewVersion( $file ) {
		$info = $this->getUpdateInfo( $file );
		return ( !\is_null( $info ) && isset( $info->new_version ) ) ? $info->new_version : '';
	}

	/**
	 * @param bool $bForceUpdateCheck
	 * @return array
	 */
	public function getUpdates( $bForceUpdateCheck = false ) {
		if ( $bForceUpdateCheck ) {
			$this->clearUpdates();
			$this->checkForUpdates();
		}
		$aUpdates = Services::WpGeneral()->getWordpressUpdates();
		return \is_array( $aUpdates ) ? $aUpdates : [];
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getUrl_Activate( $file ) :string {
		return $this->getUrl_Action( $file, 'activate' );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getUrl_Deactivate( $file ) :string {
		return $this->getUrl_Action( $file, 'deactivate' );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getUrl_Upgrade( $file ) :string {
		return add_query_arg( [
			'action'   => 'upgrade-plugin',
			'plugin'   => urlencode( $file ),
			'_wpnonce' => wp_create_nonce( 'upgrade-plugin_'.$file )
		], self_admin_url( 'update.php' ) );
	}

	/**
	 * @param string $file
	 * @param string $action
	 * @return string
	 */
	protected function getUrl_Action( $file, $action ) :string {
		return add_query_arg( [
			'action'   => $action,
			'plugin'   => urlencode( $file ),
			'_wpnonce' => wp_create_nonce( $action.'-plugin_'.$file )
		], self_admin_url( 'plugins.php' ) );
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	public function isActive( $file ) :bool {
		return $this->isInstalled( $file ) && is_plugin_active( $file );
	}

	/**
	 * @param string $file The full plugin file.
	 * @return bool
	 */
	public function isInstalled( $file ) :bool {
		return \in_array( $file, $this->getInstalledPluginFiles() );
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	public function isPluginAutomaticallyUpdated( $file ) {
		$updater = Services::WpGeneral()->getWpAutomaticUpdater();
		if ( !$updater ) {
			return false;
		}

		// Due to a change in the filter introduced in version 3.8.2
		if ( Services::WpGeneral()->getWordpressIsAtLeastVersion( '3.8.2' ) ) {
			$mPluginItem = new \stdClass();
			$mPluginItem->plugin = $file;
		}
		else {
			$mPluginItem = $file;
		}

		return $updater->should_update( 'plugin', $mPluginItem, WP_PLUGIN_DIR );
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	public function isUpdateAvailable( $file ) :bool {
		return !is_null( $this->getUpdateInfo( $file ) );
	}

	/**
	 * @param string $file
	 * @param int    $nDesiredPosition
	 */
	public function setActivePluginLoadPosition( $file, $nDesiredPosition = 0 ) {
		$WP = Services::WpGeneral();
		$oData = Services::DataManipulation();

		$aActive = $oData->setArrayValueToPosition(
			$WP->getOption( 'active_plugins' ),
			$file,
			$nDesiredPosition
		);
		$WP->updateOption( 'active_plugins', $aActive );

		if ( $WP->isMultisite() ) {
			$aActive = $oData
				->setArrayValueToPosition( $WP->getOption( 'active_sitewide_plugins' ), $file, $nDesiredPosition );
			$WP->updateOption( 'active_sitewide_plugins', $aActive );
		}
	}

	/**
	 * @param string $file
	 */
	public function setActivePluginLoadFirst( $file ) {
		$this->setActivePluginLoadPosition( $file );
	}

	/**
	 * @param string $file
	 */
	public function setActivePluginLoadLast( $file ) {
		$this->setActivePluginLoadPosition( $file, 1000 );
	}
}