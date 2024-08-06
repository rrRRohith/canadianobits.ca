<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class Data {

	/**
	 * @param string $path
	 * @param string $ext
	 * @return string
	 * @deprecated
	 */
	public function addExtensionToFilePath( $path, $ext ) :string {
		return File\Paths::AddExt( (string)$path, (string)$ext );
	}

	/**
	 * @param string $haystack
	 * @param string $needle
	 */
	public function getIfStringEndsIn( $haystack, $needle, bool $ignoreCase = false ) :bool {
		return \preg_match( sprintf( '#%s$#%s', preg_quote( $needle, '#' ), $ignoreCase ? 'i' : '' ), $haystack ) > 0;
	}

	/**
	 * @param string $path
	 */
	public function getExtension( $path ) :string {
		return File\Paths::Ext( (string)$path );
	}

	/**
	 * Use this to reliably read the contents of any file that doesn't have executable
	 * PHP Code.
	 * Why use this? In the name of naive security, silly web hosts can prevent reading the contents of
	 * non-PHP files so we simply put the content we want to have read into a php file and then "include" it.
	 * @param string $file
	 * @return string
	 */
	public function readFileWithInclude( string $file ) {
		ob_start();
		include( $file );
		return ob_get_clean();
	}

	/**
	 * @param string $file
	 * @return string
	 * @deprecated
	 */
	public function readFileContentsUsingInclude( string $file ) {
		ob_start();
		include( $file );
		return ob_get_clean();
	}

	public function urlStripQueryPart( $url ) :string {
		return preg_replace( '#\s?\?.*$#', '', $url );
	}

	/**
	 * @param string $sUrl
	 * @return string
	 */
	public function urlStripSchema( $sUrl ) {
		return preg_replace( '#^((http|https):)?//#i', '', $sUrl );
	}

	/**
	 * @param string $url
	 */
	public function isValidWebUrl( $url ) :bool {
		$url = \trim( $this->urlStripQueryPart( $url ) );
		return \filter_var( $url, FILTER_VALIDATE_URL )
			   && \in_array( \parse_url( $url, PHP_URL_SCHEME ), [ 'http', 'https' ] );
	}

	/**
	 * @param string $url
	 * @return bool
	 */
	public function verifyUrl( $url ) :bool {
		try {
			$valid = $this->isValidWebUrl( $url ) && ( new HttpUtil() )->checkUrl( $url );
		}
		catch ( \Exception $e ) {
			$valid = false;
		}
		return $valid;
	}

	/**
	 * @param string $email
	 */
	public function validEmail( $email ) :bool {
		return !empty( $email ) && is_email( $email );
	}

	/**
	 * @param string $sRawList
	 * @return array
	 */
	public function extractCommaSeparatedList( $sRawList = '' ) {

		$aRawList = [];
		if ( empty( $sRawList ) ) {
			return $aRawList;
		}

		$aRawList = \array_map( '\trim', \preg_split( '/\r\n|\r|\n/', $sRawList ) );
		$aNewList = [];
		$bHadStar = false;
		foreach ( $aRawList as $sRawLine ) {

			if ( empty( $sRawLine ) ) {
				continue;
			}
			$sRawLine = \str_replace( ' ', '', $sRawLine );
			$aParts = \explode( ',', $sRawLine, 2 );
			// we only permit 1x line beginning with *
			if ( $aParts[ 0 ] == '*' ) {
				if ( $bHadStar ) {
					continue;
				}
				$bHadStar = true;
			}
			elseif ( \count( $aParts ) == 1 || empty( $aParts[ 1 ] ) ) { // there was no comma in this line in the first place
				\array_unshift( $aParts, '*' );
			}

			$aParams = empty( $aParts[ 1 ] ) ? [] : \explode( ',', $aParts[ 1 ] );
			$aNewList[ $aParts[ 0 ] ] = $aParams;
		}
		return $aNewList;
	}

	public static function Clean_Ip( $raw ) :string {
		$raw = \preg_replace( '/[a-z\s]/i', '', $raw );
		$raw = \str_replace( '.', 'PERIOD', $raw );
		$raw = \str_replace( '-', 'HYPEN', $raw );
		$raw = \str_replace( ':', 'COLON', $raw );
		$raw = \preg_replace( '/[^a-z0-9]/i', '', $raw );
		$raw = \str_replace( 'PERIOD', '.', $raw );
		$raw = \str_replace( 'HYPEN', '-', $raw );
		return \str_replace( 'COLON', ':', $raw );
	}

	/**
	 * Taken from http://www.phacks.net/detecting-search-engine-bot-and-web-spiders/
	 */
	public static function IsSearchEngineBot() {

		$sUserAgent = Services::Request()->server( 'HTTP_USER_AGENT' );
		if ( empty( $sUserAgent ) ) {
			return false;
		}

		$sBots = 'Googlebot|bingbot|Twitterbot|Baiduspider|ia_archiver|R6_FeedFetcher|NetcraftSurveyAgent'
				 .'|Sogou web spider|Yahoo! Slurp|facebookexternalhit|PrintfulBot|msnbot|UnwindFetchor|urlresolver|Butterfly|TweetmemeBot';

		return ( \preg_match( "/$sBots/", $sUserAgent ) > 0 );
	}

	/**
	 * @param $sRawKeys
	 * @return array
	 */
	public static function CleanYubikeyUniqueKeys( $sRawKeys ) {
		$keys = \explode( "\n", $sRawKeys );
		foreach ( $keys as $nIndex => $sUsernameKey ) {
			if ( empty( $sUsernameKey ) ) {
				unset( $keys[ $nIndex ] );
				continue;
			}
			$aParts = \array_map( '\trim', \explode( ',', $sUsernameKey ) );
			if ( empty( $aParts[ 0 ] ) || empty( $aParts[ 1 ] ) || \strlen( $aParts[ 1 ] ) < 12 ) {
				unset( $keys[ $nIndex ] );
				continue;
			}
			$aParts[ 1 ] = \substr( $aParts[ 1 ], 0, 12 );
			$keys[ $nIndex ] = [ $aParts[ 0 ] => $aParts[ 1 ] ];
		}
		return $keys;
	}

	/**
	 * Strength can be 1, 3, 7, 15
	 *
	 * @param int  $nLength
	 * @param int  $nStrength
	 * @param bool $bIgnoreAmb
	 *
	 * @return string
	 */
	public static function GenerateRandomString( $nLength = 10, $nStrength = 7, $bIgnoreAmb = true ) {
		$aChars = [ 'abcdefghijkmnopqrstuvwxyz' ];

		if ( $nStrength & 2 ) {
			$aChars[] = '023456789';
		}

		if ( $nStrength & 4 ) {
			$aChars[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		}

		if ( $nStrength & 8 ) {
			$aChars[] = '$%^&*#';
		}

		if ( !$bIgnoreAmb ) {
			$aChars[] = 'OOlI1';
		}

		$sPassword = '';
		$sCharset = \implode( '', $aChars );
		for ( $i = 0 ; $i < $nLength ; $i++ ) {
			$sPassword .= $sCharset[ ( \rand()%\strlen( $sCharset ) ) ];
		}
		return $sPassword;
	}

	/**
	 * @return string
	 */
	public static function GenerateRandomLetter() {
		$sAtoZ = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$nRandomInt = rand( 0, ( \strlen( $sAtoZ ) - 1 ) );
		return $sAtoZ[ $nRandomInt ];
	}

	/**
	 * @return string|null
	 */
	public static function GetScriptName() {
		$sScriptName = Services::Request()->server( 'SCRIPT_NAME' );
		return !empty( $sScriptName ) ? $sScriptName : Services::Request()->server( 'PHP_SELF' );
	}

	/**
	 * @param array  $theArray
	 * @param string $key The array key to fetch
	 * @param mixed  $mDefault
	 * @return mixed|null
	 */
	public static function ArrayFetch( $theArray, $key, $mDefault = null ) {
		return $theArray[ $key ] ?? $mDefault;
	}

	/**
	 * Effectively validates and IP Address.
	 *
	 * @param string $ip
	 * @return int|false
	 */
	public function getIpAddressVersion( $ip ) {

		if ( \filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			return 4;
		}
		if ( \filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {
			return 6;
		}
		return false;
	}

	public function getPhpVersion() :string {
		return (string)( defined( 'PHP_VERSION' ) ? \PHP_VERSION : phpversion() );
	}

	/**
	 * Cleans out any of the junk that can appear in a PHP version and returns just the 5.4.45
	 * e.g. 5.4.45-0+deb7u5
	 */
	public function getPhpVersionCleaned( bool $excludeMinor = false ) :string {
		$version = $this->getPhpVersion();
		if ( \preg_match( '#^[0-9]+\.[0-9]+(\.[0-9]+)?#', $version, $matches ) ) {
			$version = $matches[ 0 ];
		}
		return $excludeMinor ? \substr( $version, 0, \strrpos( $version, '.' ) ) : $version;
	}

	public function getPhpVersionIsAtLeast( string $atLeast ) :bool {
		return (bool)\version_compare( $this->getPhpVersion(), $atLeast, '>=' );
	}

	public function getPhpSupportsNamespaces() :bool {
		return $this->getPhpVersionIsAtLeast( '5.3' );
	}

	public function getCanOpensslSign() :bool {
		return \function_exists( '\base64_decode' )
			   && \function_exists( '\openssl_sign' )
			   && \function_exists( '\openssl_verify' )
			   && \defined( 'OPENSSL_ALGO_SHA1' );
	}

	/**
	 * @param array $arr
	 */
	public function convertArrayToStdClass( $arr ) :\stdClass {
		$obj = new \stdClass();
		if ( !empty( $arr ) && \is_array( $arr ) ) {
			foreach ( $arr as $sKey => $mValue ) {
				$obj->{$sKey} = $mValue;
			}
		}
		return $obj;
	}

	/**
	 * @param array $aSubjectArray
	 * @param mixed $mValue
	 * @param int   $nDesiredPosition
	 * @return array
	 */
	public function setArrayValueToPosition( $aSubjectArray, $mValue, $nDesiredPosition ) {

		if ( $nDesiredPosition < 0 ) {
			return $aSubjectArray;
		}

		$nMaxPossiblePosition = \count( $aSubjectArray ) - 1;
		if ( $nDesiredPosition > $nMaxPossiblePosition ) {
			$nDesiredPosition = $nMaxPossiblePosition;
		}

		$nPosition = \array_search( $mValue, $aSubjectArray );
		if ( $nPosition !== false && $nPosition != $nDesiredPosition ) {

			// remove existing and reset index
			unset( $aSubjectArray[ $nPosition ] );
			$aSubjectArray = \array_values( $aSubjectArray );

			// insert and update
			// http://stackoverflow.com/questions/3797239/insert-new-item-in-array-on-any-position-in-php
			\array_splice( $aSubjectArray, $nDesiredPosition, 0, $mValue );
		}

		return $aSubjectArray;
	}

	/**
	 * Taken from: http://stackoverflow.com/questions/1755144/how-to-validate-domain-name-in-php
	 *
	 * @param string $domain
	 */
	public function isValidDomainName( $domain ) :bool {
		$domain = \trim( $domain );
		return ( \preg_match( "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain ) //valid chars check
				 && \preg_match( "/^.{1,253}$/", $domain ) //overall length check
				 && \preg_match( "/^[^.]{1,63}(\.[^.]{1,63})*$/", $domain ) );//length of each label
	}

	public function isWindows() :bool {
		return \strtoupper( \substr( PHP_OS, 0, 3 ) ) === 'WIN';
	}

	/**
	 * @param string $sStringContent
	 * @param string $sFilename
	 * @deprecated
	 */
	public function downloadStringAsFile( $sStringContent, $sFilename ) {
		Services::Response()->downloadStringAsFile( $sStringContent, $sFilename );
	}

	/**
	 * @param string $sRequestedUrl
	 * @param string $sBaseUrl
	 * @deprecated
	 */
	public function doSendApache404( $sRequestedUrl, $sBaseUrl ) {
		Services::Response()->sendApache404( $sRequestedUrl, $sBaseUrl );
	}

	/**
	 * @param      $sKey
	 * @param      $mValue
	 * @param int  $nExpireLength
	 * @param null $sPath
	 * @param null $sDomain
	 * @param bool $bSsl
	 * @return bool
	 * @deprecated
	 */
	public function setCookie( $sKey, $mValue, $nExpireLength = 3600, $sPath = null, $sDomain = null, $bSsl = null ) {
		return Services::Response()->cookieSet( $sKey, $mValue, $nExpireLength, $sPath, $sDomain, $bSsl );
	}

	/**
	 * @param string $sKey
	 * @return bool
	 * @deprecated
	 */
	public function setDeleteCookie( $sKey ) {
		return Services::Response()->cookieDelete( $sKey );
	}

	/**
	 * Will strip everything from a URL except Scheme+Host and requires that Scheme+Host be present
	 * @param $url
	 * @return false|string
	 * @deprecated
	 */
	public function validateSimpleHttpUrl( $url ) {
		$validated = false;

		$url = \trim( $this->urlStripQueryPart( $url ) );
		if ( \filter_var( $url, FILTER_VALIDATE_URL ) ) { // we have a scheme+host
			if ( \in_array( \parse_url( $url, PHP_URL_SCHEME ), [ 'http', 'https' ] ) ) {
				$validated = \rtrim( $url, '/' );
			}
		}

		return $validated;
	}

	public function getServerHash() :string {
		return \md5( \serialize(
			\array_values( \array_intersect_key(
				$_SERVER,
				\array_flip( [
					'SERVER_SOFTWARE',
					'SERVER_SIGNATURE',
					'PATH',
					'DOCUMENT_ROOT',
					'SERVER_ADDR',
					'SERVER_NAME',
				] )
			) )
		) );
	}
}