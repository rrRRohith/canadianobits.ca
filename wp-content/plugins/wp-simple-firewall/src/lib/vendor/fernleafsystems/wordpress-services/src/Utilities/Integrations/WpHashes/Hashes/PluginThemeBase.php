<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

abstract class PluginThemeBase extends AssetHashesBase {

	/**
	 * @param string $slug
	 * @param string $version
	 * @param string $hashAlgo
	 * @return array|null
	 */
	public function getHashes( $slug, $version, $hashAlgo = null ) {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->slug = $slug;
		$req->version = $version;
		$req->hash = $hashAlgo;
		return $this->query();
	}
}