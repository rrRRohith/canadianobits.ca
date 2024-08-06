<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

use FernleafSystems\Wordpress\Services;

class Theme extends PluginThemeBase {

	public const TYPE = 'theme';

	/**
	 * @return array|null
	 */
	public function getThemeHashes( Services\Core\VOs\Assets\WpThemeVo $VO ) {
		return $this->getHashes( $VO->stylesheet, $VO->Version );
	}

	/**
	 * @return array|null
	 * @deprecated 2.15
	 */
	public function getHashesFromVO( Services\Core\VOs\WpThemeVo $oVO ) {
		return $this->getHashes( $oVO->stylesheet, $oVO->version );
	}
}