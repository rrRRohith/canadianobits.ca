<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File\Cache;

use FernleafSystems\Wordpress\Services\Services;

class StoreToCache extends Base {

	/**
	 * @return bool
	 */
	public function store() :bool {
		$success = false;
		$def = $this->getCacheDef();
		if ( \is_array( $def->data ) && $this->prepCacheDir() ) {
			$success = Services::WpFs()->putFileContent(
				$this->getCacheFile(),
				json_encode( $def->data ),
				true
			);
		}
		return $success;
	}
}