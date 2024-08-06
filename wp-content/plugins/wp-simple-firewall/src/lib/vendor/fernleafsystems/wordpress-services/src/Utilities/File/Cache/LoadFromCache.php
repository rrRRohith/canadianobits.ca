<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File\Cache;

use FernleafSystems\Wordpress\Services\Services;

class LoadFromCache extends Base {

	public function load() :bool {
		$success = false;
		$FS = Services::WpFs();

		$def = $this->getCacheDef();
		$file = $this->getCacheFile();
		$nExpireBoundary = Services::Request()
								   ->carbon()
								   ->subSeconds( $def->expiration )->timestamp;
		if ( $FS->exists( $file ) && $FS->getModifiedTime( $file ) > $nExpireBoundary ) {
			$sJson = $FS->getFileContent( $file, true );
			if ( !empty( $sJson ) ) {
				if ( $def->touch_on_load ) {
					$FS->touch( $file );
				}
				$def->data = \json_decode( $sJson, true );
				$success = \is_array( $def->data );
			}
		}
		return $success;
	}
}