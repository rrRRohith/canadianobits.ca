<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Licenses\Keyless;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Licenses\EddLicenseVO;

/**
 * @property int    $item_id
 * @property string $install_id
 * @property string $url
 * @property string $nonce
 * @property array  $meta
 */
class Lookup extends Base {

	public const API_ACTION = 'lookup';

	public function lookup() :EddLicenseVO {
		if ( empty( $this->url ) ) {
			$this->url = Services::WpGeneral()->getHomeUrl( '', true );
		}

		$raw = $this->sendReq();
		if ( \is_array( $raw ) && $raw[ 'error_code' ] === 0 ) {
			$info = $raw[ 'license' ];
		}
		else {
			$info = [];
		}

		$lic = ( new EddLicenseVO() )->applyFromArray( $info );
		$lic->last_request_at = Services::Request()->ts();
		return $lic;
	}

	protected function getApiRequestUrl() :string {
		return sprintf( '%s/%s/%s', parent::getApiRequestUrl(), $this->item_id, $this->install_id );
	}

	/**
	 * @return string[]
	 */
	protected function getRequestBodyParamKeys() :array {
		return [
			'url',
			'nonce',
			'meta',
			'old_install_id', // Can remove this eventually
		];
	}
}