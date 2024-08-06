<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

use FernleafSystems\Wordpress\Services\Services;

class WordPress extends AssetHashesBase {

	public const TYPE = 'wordpress';

	/**
	 * @param string $version
	 * @param string $locale
	 * @param string $hashAlgo
	 * @return string[]|null
	 */
	public function getHashes( $version, $locale = null, $hashAlgo = null ) {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->version = $version;
		$req->hash = $hashAlgo;
		$req->locale = strtolower( empty( $locale ) ? Services::WpGeneral()->getLocaleForChecksums() : $locale );
		return $this->query();
	}

	/**
	 * @return string[]|null
	 */
	public function getCurrent() {
		$WP = Services::WpGeneral();
		return $this->getHashes( $WP->getVersion(), $WP->getLocaleForChecksums() );
	}
}