<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\Modules\SecurityAdmin\Lib\SecurityAdmin\Ops;

use FernleafSystems\Wordpress\Plugin\Shield\Modules\SecurityAdmin\ModConsumer;
use FernleafSystems\Wordpress\Services\Services;

class ToggleSecAdminStatus {

	use ModConsumer;

	public function turnOn() :bool {
		return $this->toggle( true );
	}

	public function turnOff() :bool {
		return $this->toggle( false );
	}

	private function toggle( bool $onOrOff ) :bool {
		$sessionCon = self::con()->getModule_Plugin()->getSessionCon();
		$current = $sessionCon->current();
		if ( $current->valid ) {
			$sessionCon->updateSessionParameter( $current, 'secadmin_at', $onOrOff ? Services::Request()->ts() : 0 );
			self::con()->this_req->is_security_admin = $onOrOff;
		}
		return $current->valid;
	}
}