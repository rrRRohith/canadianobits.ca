<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Licenses;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Services;

/**
 * @property int    $activations_left
 * @property string $customer_email
 * @property string $checksum
 * @property string $customer_name
 * @property string $item_name
 * @property string $expires    - date string or "lifetime"
 * @property int    $expires_at - unix timestamp
 * @property int    $last_request_at
 * @property int    $last_verified_at
 * @property int    $license_limit
 * @property int    $site_count
 * @property string $license
 * @property string $payment_id
 * @property string $url
 * @property bool   $success
 * @property bool   $is_staging
 * @property bool   $has_support
 * @property string $error
 */
class EddLicenseVO extends DynPropertiesClass {

	public function __get( string $key ) {
		$value = parent::__get( $key );
		switch ( $key ) {

			case 'expires_at':
				$value = \is_numeric( $value ) ? (int)$value : $this->getExpiresAt();
				break;

			case 'success':
			case 'has_support':
			case 'is_staging':
				$value = (bool)$value;
				break;

			default:
				break;
		}
		return $value;
	}

	public function getExpiresAt() :int {
		return ( $this->expires == 'lifetime' ) ?
			\PHP_INT_MAX : (int)\strtotime( (string)$this->expires );
	}

	public function isExpired() :bool {
		return $this->getExpiresAt() < Services::Request()->ts();
	}

	public function isValid() :bool {
		return $this->isReady() && $this->success && !$this->isExpired() && $this->license == 'valid';
	}

	public function hasError() :bool {
		return !empty( $this->error );
	}

	public function hasChecksum() :bool {
		return !empty( $this->checksum );
	}

	public function isReady() :bool {
		return $this->hasChecksum();
	}

	/**
	 * Random is some point between -6 and +18 hrs.
	 * @return $this
	 */
	public function updateLastVerifiedAt( bool $addRandom = false ) {
		$this->last_verified_at = \max( $this->last_request_at, Services::Request()->ts() ) +
								  ( $addRandom ? \rand( -360, 1080 )*MINUTE_IN_SECONDS : 0 );
		return $this;
	}
}