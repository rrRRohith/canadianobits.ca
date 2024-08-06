<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Cp;

use FernleafSystems\Wordpress\Services;

class Files extends Services\Utilities\WpOrg\Wp\Files {

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
}