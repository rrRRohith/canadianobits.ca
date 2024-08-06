<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services\Core\VOs\Assets\WpPluginVo;
use FernleafSystems\Wordpress\Services\Services;

trait Base {

	/**
	 * @var string
	 */
	private $workingPluginSlug;

	/**
	 * @var string
	 */
	private $workingPluginVersion;

	/**
	 * @return string
	 */
	public function getWorkingSlug() {
		return $this->workingPluginSlug;
	}

	/**
	 * @return string
	 */
	public function getWorkingVersion() {
		$version = $this->workingPluginVersion;
		if ( empty( $version ) ) {
			$p = Services::WpPlugins()->getPluginAsVo( $this->getWorkingSlug() );
			if ( $p instanceof WpPluginVo ) {
				$version = $p->Version;
			}
		}
		return $version;
	}

	/**
	 * @param string $slug
	 * @return $this
	 */
	public function setWorkingSlug( $slug ) {
		$this->workingPluginSlug = $slug;
		return $this;
	}

	/**
	 * @param string $version
	 * @return $this
	 */
	public function setWorkingVersion( $version ) {
		$this->workingPluginVersion = $version;
		return $this;
	}
}