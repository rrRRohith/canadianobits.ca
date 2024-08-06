<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base\PluginThemeVersionsBase;

class Versions extends PluginThemeVersionsBase {

	use Base;

	/**
	 * @return Api
	 */
	protected function getApi() {
		return new Api();
	}

	protected function getUrlForVersion( string $version ) :string {
		return Repo::GetUrlForThemeVersion( $this->getWorkingSlug(), $version );
	}
}