<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Query;

use FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Base;

abstract class AssetHashesBase extends Base {

	public const DEFAULT_HASH_ALGO = 'sha1';
	public const RESPONSE_DATA_KEY = 'hashes';

	protected function getApiUrl() :string {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		return sprintf( '%s/%s/%s/%s', parent::getApiUrl(), $req->type, $req->slug, $req->version );
	}

	public function getHashes( string $type, string $slug, string $version ) :array {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->type = $type;
		$req->slug = \trim( sanitize_key( $slug ), '-_' );
		$req->version = \trim( $version, 'v' );
		$result = $this->query();
		return \is_array( $result ) ? $result : [];
	}

	protected function getRequestDefaults() :array {
		$defs = parent::getRequestDefaults();
		$defs[ 'timeout' ] = 10;
		return $defs;
	}
}