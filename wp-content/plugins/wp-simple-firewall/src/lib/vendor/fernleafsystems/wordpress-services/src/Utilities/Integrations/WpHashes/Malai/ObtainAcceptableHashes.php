<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Malai;

class ObtainAcceptableHashes extends Base {

	public const API_ENDPOINT = 'acceptable_hashes';
	public const REQUEST_TYPE = 'POST';

	public function getAcceptableHashes( array $hashes ) :array {
		$acceptable = [];
		if ( !empty( $hashes ) ) {
			$req = $this->getRequestVO();
			$req->hashes_sha256 = $hashes;
			$result = $this->query();
			$acceptable = ( \is_array( $result ) && !empty( $result[ 'acceptable_hashes' ] ) ) ? $result[ 'acceptable_hashes' ] : [];
		}
		return $acceptable;
	}
}