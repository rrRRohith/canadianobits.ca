<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File\Cache;

/**
 * Trait CacheConsumer
 * @package FernleafSystems\Wordpress\Services\Utilities\File\Cache
 */
trait CacheConsumer {

	/**
	 * @var CacheDefVO
	 */
	private $oCacheDef;

	/**
	 * @return CacheDefVO
	 */
	public function getCacheDef() {
		return $this->oCacheDef;
	}

	/**
	 * @param CacheDefVO $oDef
	 * @return $this
	 */
	public function setCacheDef( $oDef ) {
		$this->oCacheDef = $oDef;
		return $this;
	}
}