<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

use FernleafSystems\Wordpress\Services\Services;

trait Base {

	/**
	 * @var string
	 */
	private $workingSlug;

	/**
	 * @var string
	 */
	private $workingVersion;

	/**
	 * @return string
	 */
	public function getWorkingSlug() {
		return $this->workingSlug;
	}

	/**
	 * @return string
	 */
	public function getWorkingVersion() {
		$version = $this->workingVersion;
		if ( empty( $version ) ) {
			$theme = Services::WpThemes()->getTheme( $this->getWorkingSlug() );
			if ( $theme instanceof \WP_Theme ) {
				$version = $theme->get( 'Version' );
			}
		}
		return $version;
	}

	/**
	 * @param string $slug
	 * @return $this
	 */
	public function setWorkingSlug( $slug ) {
		$this->workingSlug = $slug;
		return $this;
	}

	/**
	 * @param string $version
	 * @return $this
	 */
	public function setWorkingVersion( $version ) {
		$this->workingVersion = $version;
		return $this;
	}
}