<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\File\Compare\CompareHash;

class CoreFileHashes {

	/**
	 * @var array
	 */
	private $hashes;

	/**
	 * Filters out wp-content plugins/themes data.
	 * @return string[]
	 */
	public function getHashes() :array {
		if ( !isset( $this->hashes ) ) {
			$hashes = Services::WpGeneral()->getCoreChecksums();

			$this->hashes = \array_intersect_key(
				$hashes,
				\array_flip( \array_filter(
					\array_keys( $hashes ),
					function ( $file ) {
						return \preg_match( '#wp-content/(plugins|themes)#i', $file ) === 0;
					}
				) )
			);
		}
		return $this->hashes;
	}

	/**
	 * @param string $file
	 * @return string|null
	 */
	public function getFileHash( $file ) {
		$normalised = $this->getFileFragment( $file );
		return $this->isCoreFile( $normalised ) ? $this->getHashes()[ $normalised ] : null;
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getFileFragment( $file ) :string {
		return Services::WpFs()->getPathRelativeToAbsPath( $file );
	}

	/**
	 * @param string $file
	 * @return string
	 */
	public function getAbsolutePathFromFragment( $file ) :string {
		return wp_normalize_path( path_join( ABSPATH, $this->getFileFragment( $file ) ) );
	}

	/**
	 * @param string $file
	 * @return bool
	 */
	public function isCoreFile( $file ) :bool {
		return \array_key_exists( $this->getFileFragment( $file ), $this->getHashes() );
	}

	/**
	 * @param string $fullPath
	 * @return bool
	 */
	public function isCoreFileHashValid( $fullPath ) :bool {
		try {
			$valid = $this->isCoreFile( $fullPath )
					 && ( new CompareHash() )->isEqualFile( $fullPath, $this->getFileHash( $fullPath ) );
		}
		catch ( \Exception $e ) {
			$valid = false;
		}
		return $valid;
	}

	public function isReady() :bool {
		return \count( $this->getHashes() ) > 0;
	}
}