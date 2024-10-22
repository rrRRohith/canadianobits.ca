<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\ActionRouter\Actions;

use FernleafSystems\Wordpress\Plugin\Shield\ActionRouter\Actions\Traits\SecurityAdminNotRequired;
use FernleafSystems\Wordpress\Plugin\Shield\Modules\Plugin\Options;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Net\FindSourceFromIp;

class PluginIpDetect extends BaseAction {

	use SecurityAdminNotRequired;

	public const SLUG = 'ipdetect';

	protected function exec() {
		/** @var Options $opts */
		$opts = self::con()->getModule_Plugin()->opts();
		$opts->setOpt( 'ipdetect_at', Services::Request()->ts() );
		$source = ( new FindSourceFromIp() )->run( $this->action_data[ 'ip' ] ?? '' );
		if ( !empty( $source ) ) {
			$opts->setVisitorAddressSource( $source );
		}
		$this->response()->action_response_data = [
			'success'   => !empty( $source ),
			'message'   => empty( $source ) ? 'Could not find source' : 'IP Source Found: '.$source,
			'ip_source' => $source,
		];
	}
}