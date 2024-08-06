<?php

namespace FernleafSystems\Wordpress\Services;

use Pimple\Container;

class Services {

	/**
	 * @var Container
	 */
	protected static $oDic;

	/**
	 * @var Services The reference to *Singleton* instance of this class
	 */
	private static $oInstance;

	protected static $services;

	protected static $aItems;

	public static function GetInstance() :Services {
		if ( null === static::$oInstance ) {
			static::$oInstance = new static();
		}
		return static::$oInstance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->registerAll();
		// initiate these early
		self::CustomHooks();
		self::ThisRequest();
		self::WpCron();
	}

	public function registerAll() {
		self::$oDic = new Container();
		self::$oDic[ 'service_data' ] = function () {
			return new Utilities\Data();
		};
		self::$oDic[ 'service_corefilehashes' ] = function () {
			return new Core\CoreFileHashes();
		};
		self::$oDic[ 'service_email' ] = function () {
			return new Utilities\Email();
		};
		self::$oDic[ 'service_datamanipulation' ] = function () {
			return new Utilities\DataManipulation();
		};
		self::$oDic[ 'service_customhooks' ] = function () {
			return new Core\CustomHooks();
		};
		self::$oDic[ 'service_nonce' ] = function () {
			return new Core\Nonce();
		};
		self::$oDic[ 'service_request' ] = function () {
			return new Core\Request();
		};
		self::$oDic[ 'service_thisrequest' ] = function () {
			return new Request\ThisRequest();
		};
		self::$oDic[ 'service_response' ] = function () {
			return new Core\Response();
		};
		self::$oDic[ 'service_rest' ] = function () {
			return new Core\Rest();
		};
		self::$oDic[ 'service_httprequest' ] = function () {
			return new Utilities\HttpRequest();
		};
		self::$oDic[ 'service_render' ] = function () {
			return new Utilities\Render();
		};
		self::$oDic[ 'service_respond' ] = function () {
			return new Core\Respond();
		};
		self::$oDic[ 'service_serviceproviders' ] = function () {
			return new Utilities\ServiceProviders();
		};
		self::$oDic[ 'service_includes' ] = function () {
			return new Core\Includes();
		};
		self::$oDic[ 'service_ip' ] = function () {
			return new Utilities\IpUtils();
		};
		self::$oDic[ 'service_encrypt' ] = function () {
			return new Utilities\Encrypt\OpenSslEncrypt();
		};
		self::$oDic[ 'service_geoip' ] = function () {
			return new Utilities\GeoIp();
		};
		self::$oDic[ 'service_wpadminnotices' ] = function () {
			return new Core\AdminNotices();
		};
		self::$oDic[ 'service_wpcomments' ] = function () {
			return new Core\Comments();
		};
		self::$oDic[ 'service_wpcron' ] = function () {
			return new Core\Cron();
		};
		self::$oDic[ 'service_wpdb' ] = function () {
			return new Core\Db();
		};
		self::$oDic[ 'service_wpfs' ] = function () {
			return new Core\Fs();
		};
		self::$oDic[ 'service_wpgeneral' ] = function () {
			return new Core\General();
		};
		self::$oDic[ 'service_wpplugins' ] = function () {
			return new Core\Plugins();
		};
		self::$oDic[ 'service_wpthemes' ] = function () {
			return new Core\Themes();
		};
		self::$oDic[ 'service_wppost' ] = function () {
			return new Core\Post();
		};
		self::$oDic[ 'service_wptrack' ] = function () {
			return new Core\Track();
		};
		self::$oDic[ 'service_wpusers' ] = function () {
			return new Core\Users();
		};
	}

	public static function CustomHooks() :Core\CustomHooks {
		return self::getObj( __FUNCTION__ );
	}

	public static function Data() :Utilities\Data {
		return self::getObj( __FUNCTION__ );
	}

	public static function Email() :Utilities\Email {
		return self::getObj( __FUNCTION__ );
	}

	public static function DataManipulation() :Utilities\DataManipulation {
		return self::getObj( __FUNCTION__ );
	}

	public static function CoreFileHashes() :Core\CoreFileHashes {
		return self::getObj( __FUNCTION__ );
	}

	public static function Includes() :Core\Includes {
		return self::getObj( __FUNCTION__ );
	}

	public static function Encrypt() :Utilities\Encrypt\OpenSslEncrypt {
		return self::getObj( __FUNCTION__ );
	}

	public static function GeoIp() :Utilities\GeoIp {
		return self::getObj( __FUNCTION__ );
	}

	public static function HttpRequest() :Utilities\HttpRequest {
		return self::getObj( __FUNCTION__ );
	}

	public static function IP() :Utilities\IpUtils {
		return self::getObj( __FUNCTION__ );
	}

	public static function Nonce() :Core\Nonce {
		return self::getObj( __FUNCTION__ );
	}

	public static function Render( string $templatePath = '' ) :Utilities\Render {
		/** @var Utilities\Render $render */
		$render = self::getObj( __FUNCTION__ );
		if ( !empty( $templatePath ) ) {
			$render->setTemplateRoot( $templatePath );
		}
		return ( clone $render );
	}

	public static function ThisRequest() :Request\ThisRequest {
		return self::getObj( __FUNCTION__ );
	}

	public static function Request() :Core\Request {
		return self::getObj( __FUNCTION__ );
	}

	public static function Response() :Core\Response {
		return self::getObj( __FUNCTION__ );
	}

	public static function Rest() :Core\Rest {
		return self::getObj( __FUNCTION__ );
	}

	public static function Respond() :Core\Respond {
		return self::getObj( __FUNCTION__ );
	}

	public static function ServiceProviders() :Utilities\ServiceProviders {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpAdminNotices() :Core\AdminNotices {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpComments() :Core\Comments {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpCron() :Core\Cron {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpDb() :Core\Db {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpFs() :Core\Fs {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpGeneral() :Core\General {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpPlugins() :Core\Plugins {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpThemes() :Core\Themes {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpPost() :Core\Post {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpTrack() :Core\Track {
		return self::getObj( __FUNCTION__ );
	}

	public static function WpUsers() :Core\Users {
		return self::getObj( __FUNCTION__ );
	}

	public static function DataDir( string $path = '' ) :string {
		$dir = path_join( __DIR__, 'Data' );
		return empty( $path ) ? $dir : path_join( $dir, $path );
	}

	protected static function getObj( $keyFunction ) {
		$fullKey = 'service_'.\strtolower( $keyFunction );
		if ( !isset( self::$services ) ) {
			self::$services = self::$aItems ?? [];
		}
		if ( !isset( self::$services[ $fullKey ] ) ) {
			self::$services[ $fullKey ] = self::$oDic[ $fullKey ];
		}
		return self::$services[ $fullKey ];
	}
}