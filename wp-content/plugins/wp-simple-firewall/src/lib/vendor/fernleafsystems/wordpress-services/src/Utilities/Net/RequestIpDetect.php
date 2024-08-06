<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\ServiceProviders;

class RequestIpDetect extends BaseIP {

	public const DEFAULT_SOURCE = 'REMOTE_ADDR';

	/**
	 * @var string
	 */
	private $preferredSource = '';

	/**
	 * @var array
	 */
	private $visitorIP;

	public function getPublicRequestIP() :string {
		return $this->getPublicRequestIPData()[ 'ip' ];
	}

	public function getPublicRequestID() :string {
		return $this->getPublicRequestIPData()[ 'ip_id' ];
	}

	public function getPublicRequestSource() :string {
		return $this->getPublicRequestIPData()[ 'source' ];
	}

	public function getPublicRequestIPData() :array {
		if ( !isset( $this->visitorIP ) ) {

			$this->visitorIP = [
				'source'  => '',
				'ip'      => '',
				'ip_id'   => IpID::UNKNOWN,
				'all_ips' => [],
			];

			// Find on the preferred source:
			$result = $this->runDetection( true );
			if ( empty( $result ) ) {
				// Find on the preferred source but allow the host IP:
				$result = $this->runDetection( true, false );
			}
			if ( empty( $result ) ) {
				// Find on any source but don't allow the host IP:
				$result = $this->runDetection( false, true );
			}
			if ( empty( $result ) ) {
				// Find on any source but allow the host IP:
				$result = $this->runDetection( false, false );
			}
			if ( empty( $result ) ) {
				// Find any IP whatsoever on the preferred:
				$result = $this->runDetection( true, true, false );
			}
			if ( empty( $result ) ) {
				// Find any IP whatsoever:
				$result = $this->runDetection( false, true, false );
			}

			if ( !empty( $result ) ) {
				// Take the first result (ideally the preferred source)
				$this->visitorIP[ 'source' ] = key( $result );
				$this->visitorIP[ 'ip' ] = current( current( $result ) );
				$this->visitorIP[ 'all_ips' ] = $result;

				try {
					$ipIDer = new IpID( $this->visitorIP[ 'ip' ], Services::Request()->getUserAgent() );
					$identity = $ipIDer->run()[ 0 ];
				}
				catch ( \Exception $e ) {
					$identity = IpID::UNKNOWN;
				}
				$this->visitorIP[ 'ip_id' ] = $identity === IpID::VISITOR ? IpID::UNKNOWN : $identity;
			}
		}
		return $this->visitorIP;
	}

	public function runDetection( bool $usePreferred = true, bool $excludeHost = true, bool $publicOnly = true, bool $excludeCloudflare = true ) :array {
		$srvIP = Services::IP();

		$potentialIPs = [];

		$preferred = $this->getPreferredSource();

		foreach ( $this->buildIPSources() as $source => $IPs ) {

			if ( $usePreferred && !empty( $preferred ) && $source !== $preferred ) {
				continue;
			}

			if ( !empty( $IPs ) ) {
				$thisSource = [];
				foreach ( $IPs as $IP ) {

					if ( $publicOnly && !$srvIP->isValidIp_PublicRemote( $IP ) ) {
						continue;
					}
					if ( $excludeHost && $srvIP->IpIn( $IP, $srvIP->getServerPublicIPs() ) ) {
						continue;
					}
					if ( $excludeCloudflare && IpID::IsIpInServiceCollection( $IP, ServiceProviders::PROVIDER_CLOUDFLARE ) ) {
						continue;
					}

					$thisSource[] = $IP;
				}

				if ( !empty( $thisSource ) ) {
					$potentialIPs[ $source ] = $thisSource;
				}
			}
		}

		return $potentialIPs;
	}

	/**
	 * Get all the IPs for each available source.
	 * @return array[]
	 */
	public function buildIPSources() :array {
		$ipSources = [];
		foreach ( $this->getSources() as $source ) {
			$ipSources[ $source ] = $this->getIpsFromSource( $source );
		}
		return $ipSources;
	}

	public function getPreferredSource() :string {
		return (string)$this->preferredSource;
	}

	public function setPreferredSource( string $preferredSource ) :self {
		$this->preferredSource = $preferredSource;
		return $this;
	}
}