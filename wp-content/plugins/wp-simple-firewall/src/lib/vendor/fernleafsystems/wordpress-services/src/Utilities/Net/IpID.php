<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Options\Transient;

class IpID {

	public const UNKNOWN = 'unknown';
	public const LOOPBACK = 'loopback';
	public const VISITOR = 'visitor';
	public const THIS_SERVER = 'server';

	/**
	 * @var string
	 */
	private $ip;

	/**
	 * @var string|null
	 */
	private $agent;

	private $ignoreUserAgentInChecks = false;

	private $verifyDNS = true;

	public function __construct( string $ip, $agent = null ) {
		$this->ip = $ip;
		$this->agent = $agent;
	}

	public function setIgnoreUserAgent( bool $ignore = true ) :self {
		$this->ignoreUserAgentInChecks = $ignore;
		return $this;
	}

	/**
	 * @return string[]
	 * @throws \Exception
	 */
	public function run() :array {
		$srvIP = Services::IP();
		if ( !$srvIP->isValidIp( $this->ip ) ) {
			throw new \Exception( "A valid IP address was not provided." );
		}

		$theSlug = null;
		$theName = null;

		if ( $srvIP->isTrueLoopback( $this->ip ) ) {
			$theSlug = self::LOOPBACK;
			$theName = 'Loopback';
		}
		elseif ( $srvIP->IpIn( $this->ip, $srvIP->getServerPublicIPs() ) ) {
			$theSlug = self::THIS_SERVER;
			$theName = 'This Server';
		}
		else {
			$bots = Services::ServiceProviders()->getProviders();
			if ( empty( $bots[ 'services' ] ) || empty( $bots[ 'crawlers' ] ) ) {
				throw new \Exception( 'Could not request Provider IPs' );
			}

			foreach ( [ 'services', 'crawlers' ] as $type ) {
				foreach ( $bots[ $type ] as $slug => $provider ) {
					// For "services" we don't need to verify the agent as the IPs are fixed.
					if ( self::IsIpInProviderCollection( $this->ip, $provider ) ) {
						$theSlug = $slug;
						$theName = $provider[ 'name' ];
						break;
					}
				}
			}

			if ( empty( $theSlug ) ) {
				foreach ( $bots[ 'crawlers' ] as $slug => $crawler ) {
					if ( $this->checkCrawler( $slug, $crawler ) ) {
						$theSlug = $slug;
						$theName = $crawler[ 'name' ];
						break;
					}
				}
			}

			if ( empty( $theSlug ) ) {
				if ( $srvIP->IpIn( $this->ip, [ Services::Request()->ip() ] ) ) {
					$theSlug = self::VISITOR;
					$theName = 'You';
				}
				else {
					$theSlug = self::UNKNOWN;
					$theName = 'Unknown';
				}
			}
		}

		return [ $theSlug, $theName ];
	}

	public static function IsIpInProviderCollection( string $ip, array $collection ) :bool {
		$isOfService = false;

		if ( !empty( $collection[ 'ips' ] ) ) {
			$srvIP = Services::IP();
			$version = $srvIP->getIpVersion( $ip );
			if ( !empty( $version ) ) {
				$ips = $collection[ 'ips' ][ $version ] ?? [];
				try {
					$isOfService = $srvIP->IpIn( $ip, \is_array( $ips ) ? $ips : [] );
				}
				catch ( \Exception $e ) {
				}
			}
		}
		return $isOfService;
	}

	public static function IsIpInServiceCollection( string $ip, string $service ) :bool {
		$isOfService = false;
		$bots = Services::ServiceProviders()->getProviders();
		if ( !empty( $bots ) && !empty( $bots[ 'services' ] ) && !empty( $bots[ 'services' ][ $service ] ) ) {
			$isOfService = self::IsIpInProviderCollection( $ip, $bots[ 'services' ][ $service ] );
		}
		return $isOfService;
	}

	/**
	 * @since 2.26 - we use a single transient to store all crawler IPs and we keep each IP for 2 weeks.
	 */
	private function checkCrawler( string $crawlerSlug, array $crawlerSpec ) :bool {
		$now = Services::Request()->ts();

		$crawlerIPs = Transient::Get( 'apto_crawlerips' );
		if ( !\is_array( $crawlerIPs ) ) {
			$crawlerIPs = [];
		}
		if ( empty( $crawlerIPs[ $crawlerSlug ] ) ) {
			$crawlerIPs[ $crawlerSlug ] = [];
		}

		$updateIpStorage = false;
		if ( \array_key_exists( $this->ip, $crawlerIPs[ $crawlerSlug ] ) ) {
			$updateIpStorage = $now - $crawlerIPs[ $crawlerSlug ][ $this->ip ] > 60;
		}
		elseif ( $this->verifyDNS && ( $this->ignoreUserAgentInChecks || $this->verifyAgent( $crawlerSpec ) ) ) {
			// Only verify IP if the UserAgent is provided.
			if ( ( new VerifyHostToIP() )->run( $this->ip, $crawlerSpec[ 'host_pattern' ] ) ) {
				$updateIpStorage = true;
				$crawlerIPs[ $crawlerSlug ][ $this->ip ] = $now;
			}
		}

		if ( $updateIpStorage ) {
			// First clean all crawlers of stale IPs.
			foreach ( \array_keys( $crawlerIPs ) as $slug ) {
				$crawlerIPs[ $slug ] = \array_filter(
					$crawlerIPs[ $slug ],
					function ( int $ts ) use ( $now ) {
						return ( $now - $ts ) < \WEEK_IN_SECONDS*2;
					}
				);
			}
			Transient::Set( 'apto_crawlerips', $crawlerIPs, defined( '\MONTH_IN_SECONDS' ) ? \MONTH_IN_SECONDS : \WEEK_IN_SECONDS*4 );
		}

		return \array_key_exists( $this->ip, $crawlerIPs[ $crawlerSlug ] );
	}

	public function setVerifyDNS( bool $verify = true ) :self {
		$this->verifyDNS = $verify;
		return $this;
	}

	private function verifyAgent( array $data ) :bool {
		$agentValid = false;

		if ( empty( $data[ 'agents' ] ) ) {
			$agentValid = true; // since we can't verify agents where there are none to test.
		}
		elseif ( !empty( $this->agent ) ) {
			foreach ( $data[ 'agents' ] as $agent ) {
				if ( \stripos( $this->agent, $agent ) !== false ) {
					$agentValid = true;
					break;
				}
			}
		}

		return $agentValid;
	}
}