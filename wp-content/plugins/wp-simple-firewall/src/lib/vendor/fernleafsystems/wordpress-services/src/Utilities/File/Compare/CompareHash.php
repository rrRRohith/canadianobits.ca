<?php

namespace FernleafSystems\Wordpress\Services\Utilities\File\Compare;

use FernleafSystems\Wordpress\Services\Services;

class CompareHash {

	/**
	 * @param string $path
	 * @param string $hashToCompare
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFileMd5( $path, $hashToCompare ) :bool {
		if ( !Services::WpFs()->isFile( $path ) ) {
			throw new \InvalidArgumentException( 'File does not exist on disk to compare' );
		}
		if ( !\is_string( $hashToCompare ) ) {
			throw new \InvalidArgumentException( 'Provided user hash was not a string' );
		}
		return $this->isEqualFile( $path, $hashToCompare, 'md5' );
	}

	/**
	 * @param string $path
	 * @param string $hashToCompare
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFileSha1( $path, $hashToCompare ) :bool {
		if ( !Services::WpFs()->isFile( $path ) ) {
			throw new \InvalidArgumentException( 'File does not exist on disk to compare' );
		}
		if ( !\is_string( $hashToCompare ) ) {
			throw new \InvalidArgumentException( 'Provided user hash was not a string' );
		}
		return $this->isEqualFile( $path, $hashToCompare, 'sha1' );
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFile( string $path, string $hashToCompare, string $algo = null ) :bool {
		if ( !Services::WpFs()->isFile( $path ) ) {
			throw new \InvalidArgumentException( 'File does not exist on disk to compare' );
		}

		if ( empty( $algo ) ) {
			$length = \strlen( $hashToCompare );
			if ( $length === 40 ) {
				$algo = 'sha1';
			}
			elseif ( $length === 64 ) {
				$algo = 'sha256';
			}
			elseif ( $length === 32 ) {
				$algo = 'md5';
			}
			else {
				throw new \Exception( "Algo not provided and couldn't be detected." );
			}
		}

		$data = Services::DataManipulation();
		return \hash_equals( \hash_file( $algo, $path ), $hashToCompare )
			   || \hash_equals( \hash( $algo, $data->convertLineEndingsDosToLinux( $path ) ), $hashToCompare )
			   || \hash_equals( \hash( $algo, $data->convertLineEndingsLinuxToDos( $path ) ), $hashToCompare );
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFiles( string $path1, string $path2, string $algo = 'sha1' ) :bool {
		if ( !Services::WpFs()->isFile( $path2 ) ) {
			throw new \InvalidArgumentException( 'File does not exist on disk to compare' );
		}

		$possibleHashes = [
			function () use ( $path2 ) {
				return Services::WpFs()->getFileContent( $path2 );
			},
			function () use ( $path2 ) {
				return Services::DataManipulation()->convertLineEndingsDosToLinux( $path2 );
			},
			function () use ( $path2 ) {
				return Services::DataManipulation()->convertLineEndingsDosToLinux( $path2 );
			},
		];

		$equals = false;
		foreach ( $possibleHashes as $possibleHashFunc ) {
			if ( $this->isEqualFile( $path1, \hash( $algo, $possibleHashFunc() ), $algo ) ) {
				$equals = true;
				break;
			}
		}

		return $equals;
	}

	/**
	 * @param string $path1
	 * @param string $path2
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFilesMd5( $path1, $path2 ) :bool {
		return $this->isEqualFiles( $path1, $path2, 'md5' );
	}

	/**
	 * @param string $path1
	 * @param string $path2
	 * @throws \InvalidArgumentException
	 */
	public function isEqualFilesSha1( $path1, $path2 ) :bool {
		return $this->isEqualFiles( $path1, $path2 );
	}
}