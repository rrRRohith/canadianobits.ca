<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Base\Traits;

use FernleafSystems\Wordpress\Services\Services;

trait FilterByIP {

	public function filterByIPHuman( string $ip ) :self {
		$rightSide = null;
		if ( empty( $ip ) ) {
			$rightSide = "''";
		}
		elseif ( Services::IP()->isValidIp( $ip ) || Services::IP()->isValidIp( inet_ntop( $ip ) ) ) {
			$rightSide = sprintf( "INET6_ATON('%s')", Services::IP()->isValidIp( $ip ) ? $ip : inet_ntop( $ip ) );
		}

		if ( !empty( $rightSide ) ) {
			$this->addRawWhere( [ '`ip`', '=', $rightSide ] );
		}
		return $this;
	}
}