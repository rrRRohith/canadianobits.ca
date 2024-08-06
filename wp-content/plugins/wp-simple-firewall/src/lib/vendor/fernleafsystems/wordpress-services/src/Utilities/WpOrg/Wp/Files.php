<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Wp;

use FernleafSystems\Wordpress\Services;

class Files {

	/**
	 * @param string $filePath
	 * @throws \InvalidArgumentException
	 */
	public function getOriginalFileFromVcs( $filePath ) :?string {
		if ( !Services\Services::CoreFileHashes()->isCoreFile( $filePath ) ) {
			throw new \InvalidArgumentException( 'File provided is not actually a core file.' );
		}
		return ( new Repo() )->downloadFromVcs(
			Services\Services::WpFs()->getPathRelativeToAbsPath( $filePath )
		);
	}

	/**
	 * @param string $filePath
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function replaceFileFromVcs( $filePath ) {
		$sTmp = $this->getOriginalFileFromVcs( $filePath );
		return !empty( $sTmp )
			   && Services\Services::WpFs()->move(
				$sTmp,
				Services\Services::CoreFileHashes()->getAbsolutePathFromFragment( $filePath )
			);
	}
}