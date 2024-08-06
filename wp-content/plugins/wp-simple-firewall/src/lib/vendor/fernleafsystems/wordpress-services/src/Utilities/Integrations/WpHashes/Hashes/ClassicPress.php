<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

use FernleafSystems\Wordpress\Services;

class ClassicPress extends AssetHashesBase {

	public const TYPE = 'classicpress';

	/**
	 * @param string $version
	 * @param string $hashAlgo
	 * @return string[]|null
	 */
	public function getHashes( $version, $hashAlgo = null ) {
		/** @var RequestVO $oReq */
		$oReq = $this->getRequestVO();
		$oReq->version = $version;
		$oReq->hash = $hashAlgo;
		return $this->query();
	}

	/**
	 * @return string[]|null
	 */
	public function getCurrent() {
		return $this->getHashes( Services\Services::WpGeneral()->getVersion() );
	}
}