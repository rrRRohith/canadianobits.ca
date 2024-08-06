<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Query;

use FernleafSystems\Wordpress\Services;

class Theme extends AssetHashesBase {

	public const TYPE = 't';

	public function getHashesFromVO( Services\Core\VOs\Assets\WpThemeVo $VO ) :array {
		return $this->getHashes( static::TYPE, $VO->stylesheet, $VO->version );
	}
}