<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Services\{
	IPs,
	ProviderIPs
};
use FernleafSystems\Wordpress\Services\Utilities\Net\IpID;
use FernleafSystems\Wordpress\Services\Utilities\Options\Transient;

class ServiceProviders {

	// Must reflect the keys in the service providers api
	public const PROVIDER_BING = 'bing';
	public const PROVIDER_CLOUDFLARE = 'cloudflare';
	public const PROVIDER_DUCKDUCKGO = 'duckduckgo';
	public const PROVIDER_GTMETRIX = 'gtmetrix';
	public const PROVIDER_ICONTROLWP = 'icontrolwp';
	public const PROVIDER_MANAGEWP = 'managewp';
	public const PROVIDER_NODEPING = 'nodeping';
	public const PROVIDER_PAYPALIPN = 'paypal_ipn';
	public const PROVIDER_PINGDOM = 'pingdom';
	public const PROVIDER_SHIELD = 'shield';
	public const PROVIDER_STATUSCAKE = 'statuscake';
	public const PROVIDER_STRIPE = 'stripe';
	public const PROVIDER_UPTIMEROBOT = 'uptimerobot';
	public const TYPES_CRAWLERS = 'crawlers';
	public const TYPES_SERVICES = 'services';

	private $providers;

	public function clearProviders() :void {
		Transient::Delete( 'apto_provider_ips' );
	}

	/**
	 * @return array[][]
	 */
	public function getProviders() :array {
		if ( !isset( $this->providers ) ) {
			$IPs = Transient::Get( 'apto_provider_ips' );
			if ( empty( $IPs ) || !\is_array( $IPs ) ) {
				$IPs = ( new ProviderIPs() )->getIPs();
				if ( empty( $IPs ) ) { // fallback
					$raw = Services::Data()->readFileWithInclude( Services::DataDir( 'service_providers.json' ) );
					if ( !empty( $raw ) ) {
						$IPs = \json_decode( $raw, true );
					}
				}
				Transient::Set( 'apto_provider_ips', $IPs, DAY_IN_SECONDS );
			}
			$this->providers = \is_array( $IPs ) ? $IPs : [];
		}
		return $this->providers;
	}

	public function getProviders_Flat() :array {
		$result = [];
		foreach ( \array_keys( $this->getProviders() ) as $category ) {
			$result = \array_merge( $result, $this->getProviders()[ $category ] );
		}
		return $result;
	}

	public function getProviderInfo( string $slug ) :array {
		return $this->getProviders_Flat()[ $slug ] ?? [];
	}

	public function getProviderName( string $slug ) :string {
		return $this->getProviderInfo( $slug )[ 'name' ] ?? 'Unknown';
	}

	public function getProvidersOfType( string $type ) :array {
		return \array_keys( \array_filter(
			$this->getProviders_Flat(),
			function ( array $provider ) use ( $type ) {
				return \in_array( $type, $provider[ 'type' ] ?? [] );
			}
		) );
	}

	public function getSearchProviders() :array {
		return $this->getProvidersOfType( 'search' );
	}

	public function getUptimeProviders() :array {
		return $this->getProvidersOfType( 'uptime' );
	}

	public function getWpSiteManagementProviders() :array {
		return $this->getProvidersOfType( 'wp_site_management' );
	}

	/**
	 * @return string[]
	 */
	public function getAllCrawlerUseragents() :array {
		$agents = [];
		foreach ( $this->getProviders()[ 'crawlers' ] ?? [] as $crawler ) {
			$agents = \array_merge( $agents, $crawler[ 'agents' ] ?? [] );
		}
		return $agents;
	}

	/**
	 * @return string[][][]|null
	 * @deprecated 2.26
	 */
	protected function getAllServiceIPs() {
		$IPs = Transient::Get( 'serviceips_all' );
		if ( empty( $IPs ) ) {
			$IPs = ( new IPs() )->getIPs();
			$IPs = Transient::Set( 'serviceips_all', $IPs, \WEEK_IN_SECONDS );
		}
		return $IPs;
	}

	/**
	 * @param string $slug
	 * @param bool   $flatList
	 * @return string[][]|string[]
	 * @deprecated 2.26
	 */
	public function getIpsForSlug( $slug, $flatList = false ) :array {
		$all = $this->getAllServiceIPs();
		$IPs = empty( $all[ $slug ] ) ? [ 4 => [], 6 => [] ] : $all[ $slug ];
		return $flatList ? \array_merge( $IPs[ 4 ], $IPs[ 6 ] ) : $IPs;
	}

	/**
	 * @param string $ip
	 * @deprecated 2.26
	 */
	public function isIp_Cloudflare( $ip ) :bool {
		return IpID::IsIpInServiceCollection( $ip, self::PROVIDER_CLOUDFLARE );
	}

	/**
	 * @param string     $ip
	 * @param string[][] $collection
	 * @return bool
	 * @deprecated 2.26
	 */
	public function isIpInCollection( $ip, array $collection ) :bool {
		try {
			$version = Services::IP()->getIpVersion( $ip );
			$exists = $version !== false && Services::IP()->IpIn( $ip, $collection[ $version ] );
		}
		catch ( \Exception $e ) {
			$exists = false;
		}
		return $exists;
	}

	/**
	 * @return array[][]
	 * @deprecated 2.26
	 */
	public static function GetProviderIPs() :array {
		return Services::ServiceProviders()->getProviders();
	}
}