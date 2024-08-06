<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Services;

class ProviderIPs extends Base {

	public const RESPONSE_DATA_KEY = 'provider_ips';

	/**
	 * @return string[][][]|null
	 */
	public function getIPs() {
		return $this->query();
	}

	protected function getApiUrl() :string {
		return parent::getApiUrl().'/provider_ips';
	}
}