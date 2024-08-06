<?php

namespace FernleafSystems\Wordpress\Services\Core;

use Carbon\Carbon;
use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Net\RequestIpDetect;

/**
 * @property array $post
 * @property array $query
 * @property array $cookie
 * @property array $cookie_copy
 * @property array $server
 * @property array $env
 */
class Request extends DynPropertiesClass {

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var int
	 */
	private $ts;

	/**
	 * @var float
	 */
	private $startMS;

	/**
	 * @var int
	 */
	private $startTS;

	/**
	 * @var float
	 */
	private $ms;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var RequestIpDetect
	 */
	private $requestIpDetector;

	/**
	 * Request constructor.
	 */
	public function __construct() {
		$this->post = \is_array( $_POST ) ? $_POST : [];
		$this->query = \is_array( $_GET ) ? $_GET : [];
		$this->cookie_copy = \is_array( $_COOKIE ) ? $_COOKIE : [];
		$this->server = \is_array( $_SERVER ) ? $_SERVER : [];
		$this->env = \is_array( $_ENV ) ? $_ENV : [];
		$this->startTS();
		$this->ts();
	}

	public function __get( string $key ) {
		switch ( $key ) {
			case 'cookie':
				$value = \is_array( $_COOKIE ) ? $_COOKIE : [];
				break;
			default:
				$value = parent::__get( $key );
				break;
		}
		return $value;
	}

	public function getID( bool $sub = false, int $length = 10 ) :string {
		if ( empty( $this->id ) ) {
			$str = $this->ip().$this->ts().wp_rand();
			$this->id = \hash( 'sha256', $str );
			if ( empty( $this->id ) ) {
				$this->id = \hash( 'md5', $str );
			}
		}
		return ( $sub && $length > 0 && $length < \strlen( $this->id ) ) ? \substr( $this->id, 0, $length ) : $this->id;
	}

	public function getIpDetector() :RequestIpDetect {
		if ( !isset( $this->requestIpDetector ) ) {
			$this->requestIpDetector = new RequestIpDetect();
		}
		return $this->requestIpDetector;
	}

	public function ip() :string {
		return $this->getIpDetector()->getPublicRequestIP();
	}

	public function getContent() :string {
		if ( !isset( $this->content ) ) {
			$this->content = file_get_contents( 'php://input' );
		}
		return (string)$this->content;
	}

	public function getMethod() :string {
		$method = (string)$this->server( 'REQUEST_METHOD' );
		return empty( $method ) ? '' : strtolower( $method );
	}

	/**
	 * @return int
	 */
	public function mts( bool $msOnly = false ) {
		$now = $this->ts();
		if ( empty( $this->ms ) ) {
			$now = $msOnly ? 0 : $now;
		}
		else {
			$now = $msOnly ? \preg_replace( '#^\d+\.#', '', (string)$this->ms ) : $this->ms;
		}
		return $now;
	}

	public function ts( bool $update = true ) :int {
		if ( $update || empty( $this->ts ) ) {
			$this->ts = time();
			$this->ms = \function_exists( 'microtime' ) ? @\microtime( true ) : false;
		}
		return $this->ts;
	}

	public function startTS( bool $micro = false ) {
		if ( !isset( $this->startTS ) ) {
			$this->startTS = \time();
			$this->startMS = \function_exists( 'microtime' ) ? @\microtime( true ) : false;
		}
		return ( $micro && !empty( $this->startMS ) ) ? $this->startMS : $this->startTS;
	}

	/**
	 * @param bool $setTimezone - useful only when you're reporting times or displaying
	 */
	public function carbon( $setTimezone = false ) :Carbon {
		$WP = Services::WpGeneral();
		$carbon = new Carbon();
		$carbon->setTimestamp( $this->ts() );
		$carbon->setLocale( $WP->getLocaleCountry() );
		if ( $setTimezone ) {
			$TZ = $WP->getOption( 'timezone_string' );
			if ( !empty( $TZ ) ) {
				$carbon->setTimezone( $TZ );
			}
		}
		return $carbon;
	}

	/**
	 * Can't use array_merge as we can't be sure as some keys may be numeric.
	 * TODO: test to find the optimal approach for combining these arrays.
	 */
	public function getRawRequestParams( bool $includeCookies = true ) :array {
		$params = [];

		$toGather = [ $this->query, $this->post ];
		if ( $includeCookies ) {
			$toGather[] = $this->cookie_copy;
		}
		foreach ( $toGather as $bag ) {
			foreach ( $bag as $key => $value ) {
				$params[ $key ] = $value;
			}
		}
		return $params;
	}

	public function getHost() :string {
		return (string)$this->server( 'HTTP_HOST' );
	}

	public function getPath() :string {
		return $this->getUriParts()[ 'path' ];
	}

	public function getServerAddress() :string {
		return (string)$this->server( 'SERVER_ADDR' );
	}

	public function getUri() :string {
		return (string)$this->server( 'REQUEST_URI' );
	}

	public function getUriParts() :array {
		$path = $this->getUri();
		if ( strpos( $path, '?' ) !== false ) {
			[ $path, $query ] = \explode( '?', $path, 2 );
		}
		else {
			$query = '';
		}
		return [
			'path'  => $path,
			'query' => $query,
		];
	}

	public function getUserAgent() :string {
		return (string)$this->server( 'HTTP_USER_AGENT' );
	}

	public function isGet() :bool {
		return $this->getMethod() == 'get';
	}

	public function isPost() :bool {
		return $this->getMethod() == 'post';
	}

	public function countQuery() :int {
		return \count( $this->query );
	}

	public function countPost() :int {
		return \count( $this->post );
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @return mixed|null
	 */
	public function cookie( $key, $default = null ) {
		return $this->fetch( $this->cookie, $key, $default );
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @return mixed|null
	 */
	public function env( $key, $default = null ) {
		return $this->fetch( $this->env, $key, $default );
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @return mixed|null
	 */
	public function post( $key, $default = null ) {
		return $this->fetch( $this->post, $key, $default );
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @return mixed|null
	 */
	public function query( $key, $default = null ) {
		return $this->fetch( $this->query, $key, $default );
	}

	/**
	 * POST > GET > COOKIE
	 * @param string $key
	 * @param bool   $includeCookies
	 * @param null   $default
	 * @return mixed|null
	 */
	public function request( $key, $includeCookies = false, $default = null ) {
		$value = $this->post( $key );
		if ( is_null( $value ) ) {
			$value = $this->query( $key );
			if ( $includeCookies && is_null( $value ) ) {
				$value = $this->cookie( $key );
			}
		}
		return is_null( $value ) ? $default : $value;
	}

	/**
	 * @see https://github.com/ralouphie/getallheaders
	 */
	public function headers() :array {
		$headers = \function_exists( '\getallheaders' ) ? \getallheaders() : [];
		if ( empty( $headers ) ) {
			$copy_server = [
				'CONTENT_TYPE'   => 'Content-Type',
				'CONTENT_LENGTH' => 'Content-Length',
				'CONTENT_MD5'    => 'Content-Md5',
			];

			foreach ( $_SERVER as $key => $value ) {
				if ( substr( $key, 0, 5 ) === 'HTTP_' ) {
					$key = substr( $key, 5 );
					if ( !isset( $copy_server[ $key ] ) || !isset( $_SERVER[ $key ] ) ) {
						$key = str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', $key ) ) ) );
						$headers[ $key ] = $value;
					}
				}
				elseif ( isset( $copy_server[ $key ] ) ) {
					$headers[ $copy_server[ $key ] ] = $value;
				}
			}

			if ( !isset( $headers[ 'Authorization' ] ) ) {
				if ( isset( $_SERVER[ 'REDIRECT_HTTP_AUTHORIZATION' ] ) ) {
					$headers[ 'Authorization' ] = $_SERVER[ 'REDIRECT_HTTP_AUTHORIZATION' ];
				}
				elseif ( isset( $_SERVER[ 'PHP_AUTH_USER' ] ) ) {
					$basic_pass = $_SERVER[ 'PHP_AUTH_PW' ] ?? '';
					$headers[ 'Authorization' ] = 'Basic '.base64_encode( $_SERVER[ 'PHP_AUTH_USER' ].':'.$basic_pass );
				}
				elseif ( isset( $_SERVER[ 'PHP_AUTH_DIGEST' ] ) ) {
					$headers[ 'Authorization' ] = $_SERVER[ 'PHP_AUTH_DIGEST' ];
				}
			}
		}

		return $headers;
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @return mixed|null
	 */
	public function server( $key, $default = null ) {
		return $this->fetch( $this->server, $key, $default );
	}

	/**
	 * @param array  $container
	 * @param string $key
	 * @param mixed  $default
	 * @return mixed|null
	 */
	private function fetch( array $container, $key, $default = null ) {
		$value = $container[ $key ] ?? $default;
		return is_null( $value ) ? $default : $value;
	}

	public function setIpDetector( RequestIpDetect $detector ) :self {
		$this->requestIpDetector = $detector;
		return $this;
	}

	/**
	 * @return int
	 * @deprecated
	 */
	public function time() {
		return $this->ts();
	}

	/**
	 * @param bool $micro
	 * @return int
	 * @deprecated
	 */
	public function getRequestTime( $micro = false ) {
		return $this->mts( (bool)$micro );
	}

	/**
	 * @return string
	 * @deprecated
	 */
	public function getRequestPath() {
		return $this->getPath();
	}

	/**
	 * @return string
	 * @deprecated
	 */
	public function getRequestUri() {
		return $this->server( 'REQUEST_URI', '' );
	}

	/**
	 * @return array|false
	 * @deprecated
	 */
	public function getRequestUriParts() {
		return $this->getUriParts();
	}
}