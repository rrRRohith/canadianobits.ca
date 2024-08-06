<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Exceptions\NotAnIpAddressOrRangeException;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities;
use FernleafSystems\Wordpress\Services\Utilities\Integrations\Ipify;
use FernleafSystems\Wordpress\Services\Utilities\Net\FindSourceFromIp;
use IPLib\Factory;

class IpUtils {

	/**
	 * @var Utilities\Net\VisitorIpDetection
	 */
	private $ipDetector;

	/**
	 * @var string[]
	 */
	private $aMyIps;

	/**
	 * It's possible to give a range for $ip to test whether it is contained with the array or ips or ranges.
	 * @throws NotAnIpAddressOrRangeException
	 */
	public static function IpIn( string $ip, array $ipsOrRanges, bool $throwException = false ) :bool {
		$in = false;
		$IP = Factory::parseRangeString( $ip );

		if ( empty( $IP ) ) {
			if ( $throwException ) {
				throw new NotAnIpAddressOrRangeException( $ip );
			}
		}
		else {
			foreach ( $ipsOrRanges as $ipOrRangeHaystack ) {
				$range = Factory::parseRangeString( $ipOrRangeHaystack );
				if ( empty( $range ) ) {
					if ( $throwException ) {
						throw new NotAnIpAddressOrRangeException( $ipOrRangeHaystack );
					}
				}
				elseif ( $range->containsRange( $IP ) ) {
					$in = true;
					break;
				}
			}
		}
		return $in;
	}

	/**
	 * Checks if an IPv4 or IPv6 address is contained in the list of given IPs or subnets.
	 * @param string       $requestIp IP to check
	 * @param string|array $ips       List of IPs or subnets (can be a string if only a single one)
	 * @return bool Whether the IP is valid
	 * @deprecated
	 */
	public static function checkIp( $requestIp, $ips ) :bool {

		if ( \method_exists( '\FernleafSystems\Wordpress\Services\Utilities\IpUtils', 'IpIn' ) ) {
			try {
				$isIP = self::IpIn( (string)$requestIp, \is_array( $ips ) ? $ips : [ $ips ] );
			}
			catch ( \Exception $e ) {
				$isIP = false;
			}
		}
		else {
			$isIP = false;

			if ( !is_array( $ips ) ) {
				$ips = [ $ips ];
			}

			$method = substr_count( $requestIp, ':' ) > 1 ? 'checkIp6' : 'checkIp4';
			foreach ( $ips as $ip ) {
				try {
					if ( self::$method( $requestIp, $ip ) ) {
						$isIP = true;
						break;
					}
				}
				catch ( \Exception $e ) {
					$isIP = false;
				}
			}
		}

		return $isIP;
	}

	/**
	 * Compares two IPv4 addresses.
	 * In case a subnet is given, it checks if it contains the request IP.
	 * @param string $requestIp IPv4 address to check
	 * @param string $ip        IPv4 address or subnet in CIDR notation
	 * @return bool Whether the IP is valid
	 */
	public static function checkIp4( $requestIp, $ip ) :bool {
		$isIP = false;

		if ( filter_var( $requestIp, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4 ) ) {

			if ( false !== \strpos( $ip, '/' ) ) {
				list( $address, $netmask ) = \explode( '/', $ip, 2 );
			}
			else {
				$address = $ip;
				$netmask = 32;
			}

			$isIP = $netmask >= 0 && $netmask <= 32
					&& ( false !== ip2long( $address ) )
					&& filter_var( $address, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4 )
					&&
					0 === substr_compare(
						sprintf( '%032b', ip2long( $requestIp ) ),
						sprintf( '%032b', ip2long( $address ) ),
						0, $netmask
					);
		}
		return $isIP;
	}

	/**
	 * Compares two IPv6 addresses.
	 * In case a subnet is given, it checks if it contains the request IP.
	 * @param string $requestIp IPv6 address to check
	 * @param string $ip        IPv6 address or subnet in CIDR notation
	 * @return bool Whether the IP is valid
	 * @throws \Exception When IPV6 support is not enabled
	 * @author David Soria Parra <dsp at php dot net>
	 * @see    https://github.com/dsp/v6tools
	 */
	public static function checkIp6( $requestIp, $ip ) :bool {
		if ( !( ( extension_loaded( 'sockets' ) && defined( 'AF_INET6' ) ) || @inet_pton( '::1' ) ) ) {
			throw new \Exception( 'Unable to check Ipv6. Check that PHP was not compiled with option "disable-ipv6".' );
		}

		if ( false !== \strpos( $ip, '/' ) ) {
			list( $address, $netmask ) = \explode( '/', $ip, 2 );

			if ( '0' === $netmask ) {
				return (bool)unpack( 'n*', @inet_pton( $address ) );
			}

			if ( $netmask < 1 || $netmask > 128 ) {
				return false;
			}
		}
		else {
			$address = $ip;
			$netmask = 128;
		}

		$bytesAddr = unpack( 'n*', inet_pton( $address ) );
		$bytesTest = unpack( 'n*', inet_pton( $requestIp ) );

		$is = false;
		if ( !empty( $bytesAddr ) && !empty( $bytesTest ) ) {
			$is = true;
			for ( $i = 1, $ceil = ceil( $netmask/16 ) ; $i <= $ceil ; ++$i ) {
				$left = $netmask - 16*( $i - 1 );
				$left = ( $left <= 16 ) ? $left : 16;
				$mask = ~( 0xffff >> $left ) & 0xffff;
				if ( ( $bytesAddr[ $i ] & $mask ) != ( $bytesTest[ $i ] & $mask ) ) {
					$is = false;
					break;
				}
			}
		}
		return $is;
	}

	public function version( string $ip ) :int {
		$IP = Factory::parseRangeString( $ip );
		if ( empty( $IP ) ) {
			throw new NotAnIpAddressOrRangeException( $ip );
		}
		return $IP->getAddressType();
	}

	/**
	 * @param string $ip
	 * @return bool|int
	 */
	public function getIpVersion( $ip ) {
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			return 4;
		}
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {
			return 6;
		}
		return false;
	}

	/**
	 * @param string $ip
	 * @return string
	 */
	public function getIpWhoisLookup( $ip ) {
		return sprintf( 'https://apps.db.ripe.net/db-web-ui/#/query?bflag&searchtext=%s#resultsSection', $ip );
	}

	/**
	 * @param string $ip
	 * @return string
	 */
	public function getIpInfo( $ip ) {
		return sprintf( 'https://redirect.li/map/?ip=%s', $ip );
	}

	/**
	 * @param string $ip
	 */
	public function getIpGeoInfo( $ip = null ) :string {
		return Services::HttpRequest()->getContent(
			sprintf( 'http://ip6.me/api/%s', empty( $ip ) ? '' : '/'.$ip )
		);
	}

	public function getIpDetector() :Utilities\Net\VisitorIpDetection {
		if ( !isset( $this->ipDetector ) ) {
			$this->ipDetector = new Utilities\Net\VisitorIpDetection();
		}
		return $this->ipDetector;
	}

	/**
	 * TODO: Switch this to use the Request::ip()
	 * @param bool $asHuman
	 * @return int|string|bool - visitor IP Address as IP2Long
	 * @deprecated 2.27
	 */
	public function getRequestIp( $asHuman = true ) {
		$ip = Services::Request()->ip();

		// If it's IPv6 we never return as long (we can't!)
		if ( !empty( $ip ) || $asHuman || $this->getIpVersion( $ip ) == 6 ) {
			return $ip;
		}

		return ip2long( $ip );
	}

	/**
	 * @param string $IP
	 */
	public function isPrivateIP( $IP ) :bool {
		return $this->isValidIp( $IP ) && !$this->isValidIp_PublicRemote( $IP );
	}

	/**
	 * @param string $IP
	 */
	public function isTrueLoopback( $IP ) :bool {
		try {
			$LB = ( $this->getIpVersion( $IP ) == 4 && $this->checkIp4( $IP, '127.0.0.0/8' ) )
				  || ( $this->getIpVersion( $IP == 6 ) && $this->checkIp6( $IP, '::1/128' ) );
		}
		catch ( \Exception $e ) {
			$LB = false;
		}
		return $LB;
	}

	public function isLoopback() :bool {
		return $this->IpIn( Services::Request()->ip(), $this->getServerPublicIPs() );
	}

	public function isSupportedIpv6() :bool {
		return ( extension_loaded( 'sockets' ) && defined( 'AF_INET6' ) ) || @inet_pton( '::1' );
	}

	/**
	 * @param string $ip
	 * @param bool   $flags
	 * @return bool
	 */
	public function isValidIp( $ip, $flags = null ) {
		return filter_var( \trim( $ip ), FILTER_VALIDATE_IP, empty( $flags ) ? 0 : $flags );
	}

	/**
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIp4Range( $ip ) {
		$range = false;
		if ( \strpos( $ip, '/' ) ) {
			list( $ip, $CIDR ) = \explode( '/', $ip );
			$range = $this->isValidIp( $ip ) && ( (int)$CIDR >= 0 && (int)$CIDR <= 32 );
		}
		return $range;
	}

	/**
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIp6Range( $ip ) {
		$bIsRange = false;
		if ( \strpos( $ip, '/' ) ) {
			list( $ip, $CIDR ) = \explode( '/', $ip );
			$bIsRange = $this->isValidIp( $ip ) && ( (int)$CIDR >= 0 && (int)$CIDR <= 128 );
		}
		return $bIsRange;
	}

	/**
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIpOrRange( $ip ) {
		return $this->isValidIp_PublicRemote( $ip ) || $this->isValidIpRange( $ip );
	}

	/**
	 * Assumes a valid IPv4 address is provided as we're only testing for a whether the IP is public or not.
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIp_PublicRange( $ip ) {
		return $this->isValidIp( $ip, FILTER_FLAG_NO_PRIV_RANGE );
	}

	/**
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIp_PublicRemote( $ip ) {
		return $this->isValidIp( $ip, ( FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) );
	}

	/**
	 * @param string $ip
	 * @return bool
	 */
	public function isValidIpRange( $ip ) :bool {
		return $this->isValidIp4Range( $ip ) || $this->isValidIp6Range( $ip );
	}

	/**
	 * @param bool $forceRefresh
	 * @return string[]
	 */
	public function getServerPublicIPs( $forceRefresh = false ) :array {
		if ( $forceRefresh || empty( $this->aMyIps ) ) {

			$IPs = Utilities\Options\Transient::Get( 'my_server_ips' );
			if ( empty( $IPs ) || !is_array( $IPs ) || empty( $IPs[ 'check_at' ] ) ) {
				$IPs = [
					'check_at' => 0,
					'hash'     => '',
					'ips'      => []
				];
			}

			$age = Services::Request()->ts() - $IPs[ 'check_at' ];
			$isExpired = ( $age > HOUR_IN_SECONDS )
						 && ( Services::Data()->getServerHash() != $IPs[ 'hash' ] || $age > WEEK_IN_SECONDS );
			if ( $forceRefresh || $isExpired ) {
				$IPs = [
					'check_at' => Services::Request()->ts(),
					'hash'     => Services::Data()->getServerHash(),
					'ips'      => \array_filter(
						( new Ipify\Api() )->getMyIps(),
						function ( $ip ) {
							return $this->isValidIp_PublicRemote( $ip );
						}
					)
				];
				Utilities\Options\Transient::Set( 'my_server_ips', $IPs, MONTH_IN_SECONDS );
			}

			$this->aMyIps = $IPs[ 'ips' ];
		}
		return \is_array( $this->aMyIps ) ? $this->aMyIps : [];
	}

	/**
	 * @param $ip
	 */
	public function determineSourceFromIp( $ip ) :?string {
		return ( new FindSourceFromIp() )->run( (string)$ip );
	}

	/**
	 * @return $this
	 */
	public function setIpDetector( Utilities\Net\VisitorIpDetection $detector ) {
		$this->ipDetector = $detector;
		return $this;
	}
}