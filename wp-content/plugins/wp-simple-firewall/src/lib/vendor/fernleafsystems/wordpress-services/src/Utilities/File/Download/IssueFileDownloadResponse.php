<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\File\Download;

class IssueFileDownloadResponse {

	private $filename;

	private $headers;

	public function __construct( string $filename, array $headers = [] ) {
		$this->filename = $filename;
		$this->headers = $this->normaliseHeaders( $headers );
	}

	/**
	 * @param string|\Generator $content
	 */
	public function fromString( string $content, array $headers = [] ) :void {
		$headers[ 'Content-length' ] = \strlen( $content );
		$this->preContentHeaders( $headers );
		echo $content;
		die();
	}

	/**
	 * @param string|\Generator $contentGenerator
	 */
	public function fromGenerator( \Generator $contentGenerator, string $chunkSeparator = "\n", array $headers = [] ) :void {
		$this->preContentHeaders( $headers );
		foreach ( $contentGenerator as $line ) {
			echo $line.$chunkSeparator;
		}
		die();
	}

	private function preContentHeaders( array $headers = [] ) {
		foreach ( \array_merge( $this->defaultHeaders(), $this->headers, $this->normaliseHeaders( $headers ) ) as $key => $value ) {
			\header( sprintf( '%s: %s', $key, $value ) );
		}
	}

	private function defaultHeaders() :array {
		return [
			'Content-type'              => 'application/octet-stream; charset=utf-8',
			'Content-disposition'       => sprintf( 'attachment; filename="%s" filename*="%s"', $this->filename, $this->filename ),
			'Content-transfer-encoding' => 'binary',
		];
	}

	private function normaliseHeaders( array $headers ) :array {
		$normal = [];
		foreach ( $headers as $key => $value ) {
			$normal[ \ucfirst( \strtolower( $key ) ) ] = \trim( (string)$value );
		}
		return $normal;
	}
}