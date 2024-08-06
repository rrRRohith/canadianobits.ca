<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File\Cache;

use FernleafSystems\Wordpress\Services\Services;

class Base {

	/**
	 * @var CacheDefVO
	 */
	private $oDef;

	/**
	 * @return CacheDefVO
	 */
	public function getCacheDef() {
		return $this->oDef;
	}

	/**
	 * This can be overwritten as-needed
	 * @return string
	 */
	public function getCacheFile() {
		$oDef = $this->getCacheDef();
		return path_join( $oDef->dir, $oDef->file_fragment );
	}

	/**
	 * @param CacheDefVO $oDef
	 * @return $this
	 */
	public function setCacheDef( CacheDefVO $oDef ) {
		$this->oDef = $oDef;
		return $this;
	}

	/**
	 * @return bool
	 */
	protected function prepCacheDir() {
		return Services::WpFs()->mkdir( dirname( $this->getCacheFile() ) );
	}
}