<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Submit;

abstract class BaseSubmit extends \FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Base {

	public const API_ENDPOINT = 'cshashes/submit';

	protected $hashes;

	public function setHashes( array $hashes ) {
		$this->hashes = $hashes;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function preRequest() {
		parent::preRequest();

		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->hash = \sha1( \json_encode( $this->hashes ) );
	}

	protected function getApiUrl() :string {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		return sprintf( '%s/%s', parent::getApiUrl(), $req->hash );
	}
}