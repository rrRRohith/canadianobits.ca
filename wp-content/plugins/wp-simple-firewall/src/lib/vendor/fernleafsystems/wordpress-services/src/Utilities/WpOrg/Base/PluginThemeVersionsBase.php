<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base;

use FernleafSystems\Wordpress\Services\Utilities\Consumers\RequestCacheConsumer;
use FernleafSystems\Wordpress\Services\Utilities\HttpUtil;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

abstract class PluginThemeVersionsBase {

	use RequestCacheConsumer;

	/**
	 * @return string[]
	 */
	public function all() :array {
		$versions = \array_filter( \array_keys( $this->allVersionsUrls() ) );
		usort( $versions, 'version_compare' );
		return $versions;
	}

	/**
	 * @return string[]
	 */
	public function allVersionsUrls() :array {
		$versions = [];
		$slug = $this->getWorkingSlug();
		if ( !empty( $slug ) ) {
			try {
				$info = $this->getApi()
							 ->setWorkingSlug( $slug )
							 ->getInfo();
				$versions = $info->versions ?? [];
			}
			catch ( \Exception $e ) {
			}
		}
		return \is_array( $versions ) ? $versions : [];
	}

	/**
	 * @return Plugin\Api|Theme\Api
	 */
	abstract protected function getApi();

	/**
	 * @return string
	 */
	abstract protected function getWorkingSlug();

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function latest() {
		return $this->getApi()
					->setWorkingSlug( $this->getWorkingSlug() )
					->getInfo()->version;
	}

	/**
	 * @param string $version
	 * @param bool   $verifyUrl
	 * @return bool
	 */
	public function exists( $version, $verifyUrl = false ) {

		$url = $this->getUrlForVersion( $version );
		$cacheKey = md5( serialize( [
			'url'      => $url,
			'function' => 'version_exists'
		] ) );
		$exists = $this->getCache( $cacheKey );

		if ( is_null( $exists ) ) {
			$exists = \in_array( $version, $this->all() );
			if ( $exists && $verifyUrl ) {
				try {
					( new HttpUtil() )->checkUrl( $url );
				}
				catch ( \Exception $e ) {
					$exists = false;
				}
			}
			$this->addCache( $cacheKey, $exists );
		}

		return $exists;
	}

	abstract protected function getUrlForVersion( string $version );
}