<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;
use FernleafSystems\Wordpress\Services\Utilities\Options\TestCanUseTransients;
use FernleafSystems\Wordpress\Services\Utilities\URL;

class General {

	/**
	 * @var string
	 */
	protected $sWpVersion;

	public function canUseTransients() :bool {
		return ( new TestCanUseTransients() )->run();
	}

	/**
	 * @return null|string
	 */
	public function findWpLoad() {
		return $this->findWpCoreFile( 'wp-load.php' );
	}

	/**
	 * @param $sFilename
	 * @return null|string
	 */
	public function findWpCoreFile( $sFilename ) {
		$sLoaderPath = __DIR__;
		$nLimiter = 0;
		$nMaxLimit = \count( \explode( DIRECTORY_SEPARATOR, \trim( $sLoaderPath, DIRECTORY_SEPARATOR ) ) );
		$bFound = false;

		do {
			if ( @is_file( $sLoaderPath.DIRECTORY_SEPARATOR.$sFilename ) ) {
				$bFound = true;
				break;
			}
			$sLoaderPath = realpath( $sLoaderPath.DIRECTORY_SEPARATOR.'..' );
			$nLimiter++;
		} while ( $nLimiter < $nMaxLimit );

		return $bFound ? $sLoaderPath.DIRECTORY_SEPARATOR.$sFilename : null;
	}

	/**
	 * @param string $sRedirect
	 * @return bool
	 */
	public function doForceRunAutomaticUpdates( $sRedirect = '' ) {

		$lock_name = 'auto_updater.lock'; //ref: /wp-admin/includes/class-wp-upgrader.php
		delete_option( $lock_name );
		if ( !defined( 'DOING_CRON' ) ) {
			define( 'DOING_CRON', true ); // this prevents WP from disabling plugins pre-upgrade
		}

		// does the actual updating
		wp_maybe_auto_update();

		if ( !empty( $sRedirect ) ) {
			Services::Response()->redirect( network_admin_url( $sRedirect ) );
		}
		return true;
	}

	/**
	 * @param \stdClass|string $mItem
	 * @param string           $context from plugin|theme
	 * @return string
	 */
	public function getFileFromAutomaticUpdateItem( $mItem, $context = 'plugin' ) {
		if ( \is_object( $mItem ) && isset( $mItem->{$context} ) ) { // WP 3.8.2+
			$mItem = $mItem->{$context};
		}
		elseif ( !\is_string( $mItem ) ) { // WP pre-3.8.2
			$mItem = '';
		}
		return $mItem;
	}

	public function isRunningAutomaticUpdates() :bool {
		return (bool)get_option( 'auto_updater.lock' );
	}

	public function isDebug() :bool {
		return \defined( 'WP_DEBUG' ) && WP_DEBUG;
	}

	/**
	 * Clears any WordPress caches
	 */
	public function doBustCache() {
		global $_wp_using_ext_object_cache, $wp_object_cache;
		$_wp_using_ext_object_cache = false;
		if ( !empty( $wp_object_cache ) ) {
			@$wp_object_cache->flush();
		}
	}

	/**
	 * @return array
	 * @see wp_redirect_admin_locations()
	 */
	public function getAutoRedirectLocations() :array {
		return [ 'wp-admin', 'dashboard', 'admin', 'login', 'wp-login.php' ];
	}

	/**
	 * @return string[]
	 */
	public function getCoreChecksums() :array {
		return $this->isClassicPress() ? $this->getCoreChecksums_CP() : $this->getCoreChecksums_WP();
	}

	/**
	 * @return string[]
	 */
	private function getCoreChecksums_CP() :array {
		$data = ( new Hashes\ClassicPress() )->getCurrent();
		return \is_array( $data ) ? $data : [];
	}

	/**
	 * @return string[]
	 */
	private function getCoreChecksums_WP() :array {
		include_once( ABSPATH.'/wp-admin/includes/update.php' );
		if ( \function_exists( 'get_core_checksums' ) ) { // if it's loaded, we use it.
			$data = get_core_checksums( $this->getVersion(), $this->getLocaleForChecksums() );
		}
		else {
			$data = ( new Hashes\WordPress() )->getCurrent();
		}
		return \is_array( $data ) ? $data : [];
	}

	public function getAdminUrl( string $path = '', bool $wpmsOnly = false ) :string {
		return $wpmsOnly ? network_admin_url( $path ) : admin_url( $path );
	}

	public function ajaxURL() :string {
		return $this->getAdminUrl( 'admin-ajax.php' );
	}

	public function getAdminUrl_Plugins( bool $wpmsOnly = false ) :string {
		return $this->getAdminUrl( 'plugins.php', $wpmsOnly );
	}

	public function getAdminUrl_Settings( bool $wpmsOnly = false ) :string {
		return $this->getAdminUrl( 'options-general.php', $wpmsOnly );
	}

	public function getAdminUrl_Themes( bool $bWpmsOnly = false ) :string {
		return $this->getAdminUrl( 'themes.php', $bWpmsOnly );
	}

	public function getAdminUrl_Updates( bool $bWpmsOnly = false ) :string {
		return $this->getAdminUrl( 'update-core.php', $bWpmsOnly );
	}

	public function getHomeUrl( string $path = '', bool $wpms = false ) :string {
		$url = $wpms ? network_home_url( $path ) : home_url( $path );
		if ( empty( $url ) ) {
			remove_all_filters( $wpms ? 'network_home_url' : 'home_url' );
			$url = $wpms ? network_home_url( $path ) : home_url( $path );
		}
		return $url;
	}

	public function getWpUrl( string $path = '' ) :string {
		$url = network_site_url( $path );
		if ( empty( $url ) ) {
			remove_all_filters( 'site_url' );
			remove_all_filters( 'network_site_url' );
			$url = network_site_url( $path );
		}
		return $url;
	}

	public function getUrl_AdminPage( string $slug, bool $wpmsOnly = false ) :string {
		$sUrl = sprintf( 'admin.php?page=%s', $slug );
		return $wpmsOnly ? network_admin_url( $sUrl ) : admin_url( $sUrl );
	}

	/**
	 * @param string $separator
	 * @return string
	 */
	public function getLocale( $separator = '_' ) {
		$locale = get_locale();
		return \is_string( $separator ) ? \str_replace( '_', $separator, $locale ) : $locale;
	}

	public function getLocaleCountry() :string {
		$locale = $this->getLocale();
		$nSep = \strpos( $locale, '_' );
		return $nSep ? \substr( $locale, 0, $nSep ) : $locale;
	}

	public function getLocaleForChecksums() :string {
		global $wp_local_package;
		return empty( $wp_local_package ) ? 'en_US' : $wp_local_package;
	}

	/**
	 * @param int $ts
	 * @return string
	 */
	public function getTimeStampForDisplay( $ts = null ) :string {
		$ts = empty( $ts ) ? Services::Request()->ts() : $ts;
		return date_i18n( DATE_RFC2822, $this->getTimeAsGmtOffset( $ts ) );
	}

	/**
	 * @param string $type - plugins, themes
	 * @return array
	 */
	public function getWordpressUpdates( string $type = 'plugins' ) {
		$current = $this->getTransient( 'update_'.$type );
		return ( isset( $current->response ) && \is_array( $current->response ) ) ? $current->response : [];
	}

	/**
	 * @param string $sKey
	 * @return mixed
	 */
	public function getTransient( $sKey ) {
		// TODO: Handle multisite

		if ( \function_exists( 'get_site_transient' ) ) {
			$mResult = get_site_transient( $sKey );
			if ( empty( $mResult ) ) {
				remove_all_filters( 'pre_site_transient_'.$sKey );
				$mResult = get_site_transient( $sKey );
			}
		}
		elseif ( version_compare( $this->getVersion(), '2.7.9', '<=' ) ) {
			$mResult = get_option( $sKey );
		}
		elseif ( version_compare( $this->getVersion(), '2.9.9', '<=' ) ) {
			$mResult = apply_filters( 'transient_'.$sKey, get_option( '_transient_'.$sKey ) );
		}
		else {
			$mResult = apply_filters( 'site_transient_'.$sKey, get_option( '_site_transient_'.$sKey ) );
		}
		return $mResult;
	}

	/**
	 * @return string|null
	 */
	public function getPath_WpConfig() {
		$FS = Services::WpFs();
		$sMain = path_join( ABSPATH, 'wp-config.php' );
		$sSec = path_join( ABSPATH.'..', 'wp-config.php' );
		return $FS->exists( $sMain ) ? $sMain : ( $FS->exists( $sSec ) ? $sSec : null );
	}

	public function isClassicPress() :bool {
		return \function_exists( 'classicpress_version' );
	}

	public function isMaintenanceMode() :bool {
		$bMaintenance = false;
		$sFile = ABSPATH.'.maintenance';
		if ( Services::WpFs()->exists( $sFile ) ) {
			include( $sFile );
			if ( isset( $upgrading ) && ( Services::Request()->ts() - $upgrading ) < 600 ) {
				$bMaintenance = true;
			}
		}
		return $bMaintenance;
	}

	public function isPermalinksEnabled() :bool {
		return $this->getOption( 'permalink_structure' ) ? true : false;
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mValue
	 * @param int    $nExpire
	 * @return bool
	 */
	public function setTransient( $sKey, $mValue, $nExpire = 0 ) {
		return set_site_transient( $sKey, $mValue, $nExpire );
	}

	/**
	 * @param $sKey
	 * @return bool
	 */
	public function deleteTransient( $sKey ) {

		if ( version_compare( $this->getVersion(), '2.7.9', '<=' ) ) {
			$bResult = delete_option( $sKey );
		}
		elseif ( \function_exists( 'delete_site_transient' ) ) {
			$bResult = delete_site_transient( $sKey );
		}
		elseif ( version_compare( $this->getVersion(), '2.9.9', '<=' ) ) {
			$bResult = delete_option( '_transient_'.$sKey );
		}
		else {
			$bResult = delete_option( '_site_transient_'.$sKey );
		}
		return $bResult;
	}

	public function getDirUploads() :string {
		$dirParts = wp_get_upload_dir();
		$hasUploads = \is_array( $dirParts )
					  && !empty( $dirParts[ 'basedir' ] )
					  && Services::WpFs()->exists( $dirParts[ 'basedir' ] );
		return $hasUploads ? $dirParts[ 'basedir' ] : '';
	}

	/**
	 * TODO: Create ClassicPress override class for this stuff
	 * @param bool $bIgnoreClassicpress if true returns the $wp_version regardless of ClassicPress or not
	 * @return string
	 */
	public function getVersion( $bIgnoreClassicpress = false ) {

		if ( empty( $this->sWpVersion ) ) {
			$sVersionContents = file_get_contents( ABSPATH.WPINC.'/version.php' );

			if ( \preg_match( '/wp_version\s=\s\'([^(\'|")]+)\'/i', $sVersionContents, $aMatches ) ) {
				$this->sWpVersion = $aMatches[ 1 ];
			}
			else {
				global $wp_version;
				$this->sWpVersion = $wp_version;
			}
		}

		if ( $bIgnoreClassicpress || !$this->isClassicPress() ) {
			$version = $this->sWpVersion;
		}
		else {
			$version = \classicpress_version();
			preg_match( '#^(\d+(?:\.\d)+)(.*)$#', $version, $matches );
			if ( !empty( $matches[ 2 ] ) ) {
				$version = $matches[ 1 ];
			}
		}

		return $version;
	}

	public function getWordpressIsAtLeastVersion( string $version, bool $ignoreCP = true ) :bool {
		return version_compare( $this->getVersion( $ignoreCP ), $version, '>=' );
	}

	/**
	 * @param string $sPluginBaseFilename
	 * @return bool
	 * @deprecated
	 */
	public function getIsPluginAutomaticallyUpdated( $sPluginBaseFilename ) {
		return Services::WpPlugins()->isPluginAutomaticallyUpdated( $sPluginBaseFilename );
	}

	public function getUrl_CurrentAdminPage() :string {

		$page = Services::WpPost()->getCurrentPage();
		$url = self_admin_url( $page );

		//special case for plugin admin pages.
		if ( $page == 'admin.php' ) {
			$sSubPage = Services::Request()->query( 'page' );
			if ( !empty( $sSubPage ) ) {
				$aQueryArgs = [
					'page' => $sSubPage,
				];
				$url = add_query_arg( $aQueryArgs, $url );
			}
		}
		return $url;
	}

	/**
	 * @param string
	 * @return string
	 */
	public function getIsPage_Updates() {
		return Services::WpPost()->isCurrentPage( 'update.php' );
	}

	public function getLoginUrl() :string {
		return wp_login_url();
	}

	public function getLostPasswordUrl() :string {
		$url = wp_lostpassword_url();
		if ( !\is_string( $url ) ) {
			error_log( "You have a plugin/theme that is affecting 'wp_lostpassword_url()' and not returning a valid string." );
		}
		return URL::Build( $this->getLoginUrl(), [ 'action' => 'lostpassword' ] );
	}

	/**
	 * @param string $termOrSlug
	 */
	public function getDoesWpSlugExist( $termOrSlug ) :bool {
		return Services::WpPost()->getDoesWpPostSlugExist( $termOrSlug ) || term_exists( $termOrSlug );
	}

	public function getSiteName() :string {
		return \function_exists( 'get_bloginfo' ) ? get_bloginfo( 'name' ) : 'WordPress Site';
	}

	public function getSiteAdminEmail() :string {
		return \function_exists( 'get_bloginfo' ) ? get_bloginfo( 'admin_email' ) : '';
	}

	/**
	 * @return string
	 */
	public function getCookieDomain() {
		return defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : false;
	}

	public function getCookiePath() :string {
		return \defined( 'COOKIEPATH' ) ? COOKIEPATH : '/';
	}

	public function isApplicationPasswordApiRequest() :bool {
		return (bool)apply_filters( 'application_password_is_api_request',
			$this->isXmlrpc() || ( \defined( 'REST_REQUEST' ) && REST_REQUEST ) );
	}

	public function isAjax() :bool {
		return \function_exists( 'wp_doing_ajax' ) ? wp_doing_ajax() : \defined( 'DOING_AJAX' ) && DOING_AJAX;
	}

	public function isCron() :bool {
		return \function_exists( 'wp_doing_cron' ) ? wp_doing_cron() : \defined( 'DOING_CRON' ) && DOING_CRON;
	}

	public function isMobile() :bool {
		return \function_exists( 'wp_is_mobile' ) && wp_is_mobile();
	}

	public function isWpCli() :bool {
		return \defined( 'WP_CLI' ) && WP_CLI;
	}

	public function isXmlrpc() :bool {
		return \defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST;
	}

	public function isLoginUrl() :bool {
		$path = @\parse_url( $this->getLoginUrl(), PHP_URL_PATH );
		return !empty( $path ) && \trim( Services::Request()->getPath(), '/' ) == \trim( $path, '/' );
	}

	public function isLoginRequest() :bool {
		$req = Services::Request();
		return $req->isPost()
			   && $this->isLoginUrl()
			   && !is_null( $req->post( 'log' ) )
			   && !is_null( $req->post( 'pwd' ) );
	}

	public function isRegisterRequest() :bool {
		$req = Services::Request();
		return $req->isPost()
			   && $this->isLoginUrl()
			   && !\is_null( $req->post( 'user_login' ) )
			   && !\is_null( $req->post( 'user_email' ) );
	}

	public function isMultisite() :bool {
		return \function_exists( 'is_multisite' ) && is_multisite();
	}

	public function isMultisite_SubdomainInstall() :bool {
		return $this->isMultisite() && defined( 'SUBDOMAIN_INSTALL' ) && SUBDOMAIN_INSTALL;
	}

	/**
	 * @param string $sKey
	 * @param string $sValue
	 * @return bool
	 */
	public function addOption( $sKey, $sValue ) {
		return $this->isMultisite() ? add_site_option( $sKey, $sValue ) : add_option( $sKey, $sValue );
	}

	/**
	 * @param string $sKey
	 * @param        $sValue
	 * @param bool   $ignoreWPMS
	 * @return bool
	 */
	public function updateOption( $sKey, $sValue, $ignoreWPMS = false ) {
		return ( $this->isMultisite() && !$ignoreWPMS ) ? update_site_option( $sKey, $sValue ) : update_option( $sKey, $sValue );
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mDefault
	 * @param bool   $bIgnoreWPMS
	 * @return mixed
	 */
	public function getOption( $sKey, $mDefault = false, $bIgnoreWPMS = false ) {
		return ( $this->isMultisite() && !$bIgnoreWPMS ) ? get_site_option( $sKey, $mDefault ) : get_option( $sKey, $mDefault );
	}

	/**
	 * @param string $sKey
	 * @param bool   $bIgnoreWPMS
	 * @return bool
	 */
	public function deleteOption( $sKey, $bIgnoreWPMS = false ) {
		return ( $this->isMultisite() && !$bIgnoreWPMS ) ? delete_site_option( $sKey ) : delete_option( $sKey );
	}

	public function getCurrentWpAdminPage() :string {
		$req = Services::Request();
		$script = $req->server( 'SCRIPT_NAME' );
		if ( empty( $script ) ) {
			$script = $req->server( 'PHP_SELF' );
		}
		if ( is_admin() && !empty( $script ) && \basename( $script ) == 'admin.php' ) {
			$current = $req->query( 'page' );
		}
		return empty( $current ) ? '' : $current;
	}

	/**
	 * @param int|null $ts
	 * @param bool     $bShowTime
	 * @param bool     $bShowDate
	 * @return string
	 */
	public function getTimeStringForDisplay( $ts = null, $bShowTime = true, $bShowDate = true ) {
		$ts = empty( $ts ) ? Services::Request()->ts() : $ts;

		$fullTimeString = $bShowTime ? $this->getTimeFormat() : '';
		if ( empty( $fullTimeString ) ) {
			$fullTimeString = $bShowDate ? $this->getDateFormat() : '';
		}
		else {
			$fullTimeString = $bShowDate ? ( $fullTimeString.' '.$this->getDateFormat() ) : $fullTimeString;
		}
		return date_i18n( $fullTimeString, $this->getTimeAsGmtOffset( $ts ) );
	}

	/**
	 * @param null $ts
	 * @return int|null
	 */
	public function getTimeAsGmtOffset( $ts = null ) {

		$timezoneOffset = wp_timezone_override_offset();
		if ( $timezoneOffset === false ) {
			$timezoneOffset = $this->getOption( 'gmt_offset' );
			if ( empty( $timezoneOffset ) ) {
				$timezoneOffset = 0;
			}
		}

		$ts = empty( $ts ) ? Services::Request()->ts() : $ts;
		return $ts + ( $timezoneOffset*HOUR_IN_SECONDS );
	}

	public function getTimeFormat() :string {
		$format = $this->getOption( 'time_format' );
		return empty( $format ) ? 'H:i' : $format;
	}

	public function getDateFormat() :string {
		$format = $this->getOption( 'date_format' );
		return empty( $format ) ? 'F j, Y' : $format;
	}

	/**
	 * @return false|\WP_Automatic_Updater
	 */
	public function getWpAutomaticUpdater() {
		if ( !isset( $this->oWpAutomaticUpdater ) ) {
			require_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );
			$this->oWpAutomaticUpdater = new \WP_Automatic_Updater();
		}
		return $this->oWpAutomaticUpdater;
	}

	public function getIfAutoUpdatesInstalled() :bool {
		return (int)did_action( 'automatic_updates_complete' ) > 0;
	}

	public function canCoreUpdateAutomatically() :bool {
		$can = false;

		$thisV = $this->getVersion();
		if ( \preg_match( '#^[\d]+(\.[\d]){1,2}+$#', $thisV ) ) {
			if ( \substr_count( $thisV, '.' ) == 1 ) {
				$thisV .= '.0';
			}
			$aParts = \explode( '.', $thisV );
			$aParts[ 2 ]++;
			global $required_php_version, $required_mysql_version;
			$future_minor_update = (object)[
				'current'       => \implode( '.', $aParts ),
				'version'       => $thisV,
				'php_version'   => $required_php_version,
				'mysql_version' => $required_mysql_version,
			];
			$can = $this->getWpAutomaticUpdater()->should_update( 'core', $future_minor_update, ABSPATH );
		}
		return $can;
	}

	/**
	 * @return array|false
	 */
	public function getCoreUpdates() {
		include_once( ABSPATH.'wp-admin/includes/update.php' );
		return get_core_updates();
	}

	/**
	 * See: /wp-admin/update-core.php core_upgrade_preamble()
	 * @return bool
	 */
	public function hasCoreUpdate() :bool {
		$aUpdates = $this->getCoreUpdates();
		return ( isset( $aUpdates[ 0 ]->response ) && 'latest' != $aUpdates[ 0 ]->response );
	}

	/**
	 * Flushes the Rewrite rules and forces a re-commit to the .htaccess where applicable
	 */
	public function resavePermalinks() {
		/** @var \WP_Rewrite $wp_rewrite */
		global $wp_rewrite;
		if ( \is_object( $wp_rewrite ) ) {
			$wp_rewrite->flush_rules();
		}
	}

	public function turnOffCache() :bool {
		foreach ( [ 'DONOTCACHEPAGE', 'DONOTCACHEOBJECT', 'DONOTCACHEDB' ] as $constant ) {
			if ( !\defined( $constant ) ) {
				\define( $constant, true );
			}
		}
		if ( \function_exists( 'wpfc_exclude_current_page' ) ) {
			/** WP Fastest */
			wpfc_exclude_current_page();
		}

		return \defined( 'DONOTCACHEPAGE' ) && DONOTCACHEPAGE;
	}

	/**
	 * @param string $msg
	 * @param string $title
	 * @param bool   $turnOffCachePage
	 */
	public function wpDie( $msg, $title = '', bool $turnOffCachePage = true ) {
		if ( $turnOffCachePage ) {
			$this->turnOffCache();
		}
		wp_die( $msg, $title );
	}
}