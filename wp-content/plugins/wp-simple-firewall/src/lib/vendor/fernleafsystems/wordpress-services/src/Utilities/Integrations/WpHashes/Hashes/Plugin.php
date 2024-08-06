<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

use FernleafSystems\Wordpress\Services;

class Plugin extends PluginThemeBase {

	public const TYPE = 'plugin';

	/**
	 * @return array|null
	 */
	public function getPluginHashes( Services\Core\VOs\Assets\WpPluginVo $VO ) {
		return $this->getHashes( $VO->slug, $VO->Version );
	}

	/**
	 * @return array|null
	 * @deprecated 2.15
	 */
	public function getHashesFromVO( Services\Core\VOs\WpPluginVo $VO ) {
		return $this->getHashes( $VO->slug, $VO->Version );
	}
}