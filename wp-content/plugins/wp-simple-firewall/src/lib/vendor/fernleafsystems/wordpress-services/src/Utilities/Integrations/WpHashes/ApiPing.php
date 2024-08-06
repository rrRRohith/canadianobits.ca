<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes;

class ApiPing extends ApiBase {

	public const API_ENDPOINT = 'ping';

	public function ping() :bool {
		$r = $this->query();
		return \is_array( $r ) && isset( $r[ 'pong' ] ) && $r[ 'pong' ] == 'ping';
	}
}