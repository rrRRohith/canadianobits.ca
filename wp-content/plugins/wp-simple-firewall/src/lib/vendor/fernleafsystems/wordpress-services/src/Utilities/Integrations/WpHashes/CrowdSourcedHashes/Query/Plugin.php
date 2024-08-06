<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Query;

use FernleafSystems\Wordpress\Services;

class Plugin extends AssetHashesBase {

	public const TYPE = 'p';

	public function getHashesFromVO( Services\Core\VOs\Assets\WpPluginVo $VO ) :array {
		return $this->getHashes( static::TYPE, $VO->slug, $VO->Version );
	}
}