<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Net;

use FernleafSystems\Wordpress\Services\Services;

class FindSourceFromIp extends BaseIP {

	public function run( string $ip ) :?string {
		$theSource = null;
		foreach ( $this->getSources() as $source ) {
			try {
				if ( Services::IP()->IpIn( $ip, $this->getIpsFromSource( $source ) ) ) {
					$theSource = $source;
					break;
				}
			}
			catch ( \Exception $e ) {
			}
		}
		return $theSource;
	}
}