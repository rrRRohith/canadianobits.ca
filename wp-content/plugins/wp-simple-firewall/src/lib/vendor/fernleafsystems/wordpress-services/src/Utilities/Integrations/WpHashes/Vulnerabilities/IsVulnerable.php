<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Vulnerabilities;

use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

class IsVulnerable extends WpHashes\ApiBase {

	public const API_ENDPOINT = 'vulnerable';
	public const API_VERSION = 2;

	private $type;

	private $slug;

	private $version;

	protected function getApiUrl() :string {
		return sprintf( '%s/%s/%s/%s', parent::getApiUrl(), $this->type, $this->slug, $this->version );
	}

	public function wordpress( string $version ) :bool {
		return $this->sendRequest( 'w', 'c', $version );
	}

	public function plugin( string $slug, string $version ) :bool {
		return $this->sendRequest( 'p', $slug, $version );
	}

	public function theme( string $slug, string $version ) :bool {
		return $this->sendRequest( 't', $slug, $version );
	}

	protected function sendRequest( string $type, string $slug, string $version ) :bool {
		$this->type = $type;
		$this->slug = $slug;
		$this->version = $version;
		return $this->query()[ 'vulnerable' ] ?? false;
	}
}