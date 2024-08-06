<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\File;

use FernleafSystems\Wordpress\Services\Services;

class ConvertLineEndings {

	public function dosToLinux( string $content ) :string {
		return str_replace( [ "\r\n", "\r" ], "\n", $content );
	}

	public function fileDosToLinux( string $path ) :string {
		return $this->dosToLinux( (string)Services::WpFs()->getFileContent( $path ) );
	}

	public function linuxToDos( string $content ) :string {
		return str_replace( "\n", "\r\n", $this->dosToLinux( $content ) );
	}

	public function fileLinuxToDos( string $path ) :string {
		return $this->linuxToDos( (string)Services::WpFs()->getFileContent( $path ) );
	}
}