<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Options;

use FernleafSystems\Wordpress\Services\Core\System;
use FernleafSystems\Wordpress\Services\Services;

/**
 * Remarkably, it seems that some WordPress sites can't actually store WordPress Transients.
 */
class Transient {

	/**
	 * @param string $key
	 * @param bool   $ignoreWPMS
	 * @return bool
	 */
	public static function Delete( $key, $ignoreWPMS = true ) {
		$oWP = Services::WpGeneral();
		return $oWP->canUseTransients() ?
			$oWP->deleteTransient( $key )
			: Services::WpGeneral()->deleteOption( System::PREFIX.'trans_'.$key, $ignoreWPMS );
	}

	/**
	 * @param string $key
	 * @param null   $default
	 * @param bool   $ignoreWPMS
	 * @return mixed|null
	 */
	public static function Get( $key, $default = null, $ignoreWPMS = true ) {
		$mVal = null;

		$WP = Services::WpGeneral();

		if ( $WP->canUseTransients() ) {
			$mVal = $WP->getTransient( $key );
		}
		else {
			$data = $WP->getOption( System::PREFIX.'trans_'.$key, null, $ignoreWPMS );
			if ( !empty( $data ) && \is_array( $data ) && isset( $data[ 'data' ] )
				 && isset( $data[ 'expires_at' ] ) ) {
				if ( $data[ 'expires_at' ] === 0 || Services::Request()->ts() < $data[ 'expires_at' ] ) {
					$mVal = $data[ 'data' ];
				}
			}
		}

		return \is_null( $mVal ) ? $default : $mVal;
	}

	/**
	 * @param string $key
	 * @param mixed  $data
	 * @param int    $lifeTime
	 * @param bool   $ignoreWPMS
	 * @return bool
	 */
	public static function Set( $key, $data, $lifeTime = 0, $ignoreWPMS = true ) {
		if ( is_null( $data ) ) {
			self::Delete( $key );
		}

		$oWP = Services::WpGeneral();

		if ( $oWP->canUseTransients() ) {
			return $oWP->setTransient( $key, $data, $lifeTime );
		}
		else {
			return $oWP->updateOption(
				System::PREFIX.'trans_'.$key,
				[
					'data'       => $data,
					'expires_at' => empty( $lifeTime ) ? 0 : Services::Request()->ts() + max( 0, $lifeTime ),
				],
				$ignoreWPMS
			);
		}
	}
}
