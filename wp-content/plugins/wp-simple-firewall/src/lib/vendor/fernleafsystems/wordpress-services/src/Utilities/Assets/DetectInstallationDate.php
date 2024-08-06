<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Assets;

use FernleafSystems\Wordpress\Services\Core\VOs\Assets\{
	WpPluginVo,
	WpThemeVo
};
use FernleafSystems\Wordpress\Services\Services;

class DetectInstallationDate {

	public function plugin( WpPluginVo $asset ) :int {
		return $this->detectFromDir( $asset->getInstallDir() );
	}

	public function theme( WpThemeVo $asset ) :int {
		return $this->detectFromDir( $asset->getInstallDir() );
	}

	private function detectFromDir( string $dir ) :int {
		$FS = Services::WpFs();
		$time = $FS->getModifiedTime( $dir );
		foreach ( $FS->getFilesInDir( $dir ) as $fileInfo ) {
			$time = min( $time, $fileInfo->getMTime() );
		}
		return $time;
	}
}
