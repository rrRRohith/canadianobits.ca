<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\ServiceProviders;

class VisitorIpDetection extends BaseIP {

	public const DEFAULT_SOURCE = 'REMOTE_ADDR';

	/**
	 * @var bool
	 */
	private $bExcludeHostIps;

	/**
	 * @var string
	 */
	private $sLastSuccessfulSource;

	/**
	 * @var string
	 */
	private $preferredSource;

	/**
	 * @var string
	 */
	private $sVisitorIP;

	/**
	 * @var string
	 */
	private $identity;

	/**
	 * @return string
	 */
	public function getIP() {
		if ( empty( $this->sVisitorIP ) ) {
			$this->runNormalDetection();
		}
		return $this->sVisitorIP;
	}

	public function getIPIdentity() :string {
		if ( empty( $this->identity ) ) {
			$this->identity = IpID::UNKNOWN;
			if ( !empty( $this->getIP() ) ) {
				try {
					$this->identity = ( new IpID( $this->getIP(), Services::Request()->getUserAgent() ) )->run()[ 0 ];
					if ( $this->identity === IpID::VISITOR ) {
						$this->identity = IpID::UNKNOWN;
					}
				}
				catch ( \Exception $e ) {
				}
			}
		}
		return $this->identity;
	}

	private function runNormalDetection() {
		$this->bExcludeHostIps = true;
		[ $theSource, $theIP ] = $this->findPotentialIpFromSources();
		if ( empty( $theSource ) || empty( $theIP ) ) {
			$this->bExcludeHostIps = false;
			[ $theSource, $theIP ] = $this->findPotentialIpFromSources();
		}
		$this->sLastSuccessfulSource = $theSource;
		$this->sVisitorIP = $theIP;
	}

	private function findPotentialIpFromSources() :array {

		$sources = $this->getSources();
		$preferred = $this->getPreferredSource();
		if ( \in_array( $preferred, $sources ) ) {
			unset( $sources[ \array_search( $preferred, $sources ) ] );
			\array_unshift( $sources, $preferred );
		}

		$theIPs = [];
		$theSource = '';
		foreach ( $sources as $maybeSource ) {
			$theIPs = $this->detectAndFilterFromSource( $maybeSource );
			if ( !empty( $theIPs ) ) {
				$theSource = $maybeSource;
				break;
			}
		}

		return [ $theSource, empty( $theIPs ) ? '': \array_shift( $theIPs ) ];
	}

	/**
	 * @param string $source
	 * @return string[]
	 */
	protected function detectAndFilterFromSource( $source ) :array {
		return $this->filterIpsByViable( $this->getIpsFromSource( $source ) );
	}

	/**
	 * @param string[] $IPs
	 * @return string[]
	 */
	private function filterIpsByViable( $IPs ) :array {
		return \array_values( \array_filter(
			$IPs,
			function ( $ip ) {
				$srvIP = Services::IP();
				return ( $srvIP->isValidIp_PublicRemote( $ip )
						 && ( !$this->bExcludeHostIps || !$srvIP->IpIn( $ip, $srvIP->getServerPublicIPs() ) )
						 && !IpID::IsIpInServiceCollection( $ip, ServiceProviders::PROVIDER_CLOUDFLARE )
				);
			}
		) );
	}

	public function getLastSuccessfulSource() :string {
		return (string)$this->sLastSuccessfulSource;
	}

	public function getPreferredSource() :string {
		return empty( $this->preferredSource ) ? self::DEFAULT_SOURCE : $this->preferredSource;
	}

	public function setPreferredSource( string $preferredSource ) :self {
		$this->preferredSource = $preferredSource;
		return $this;
	}
}