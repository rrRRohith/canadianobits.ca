<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\File\Search;

use FernleafSystems\Wordpress\Services\Utilities\Arrays;

class SearchFile {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var bool
	 */
	public $caseSensitive = true;

	/**
	 * @throws \Exception
	 */
	public function __construct( string $file, bool $caseSensitive = true ) {
		if ( !file_exists( $file ) ) {
			throw new \Exception( "File doesn't exist." );
		}
		if ( !is_readable( $file ) ) {
			throw new \Exception( "File not readable." );
		}
		$openedFile = fopen( $file, 'r' );
		if ( !is_resource( $openedFile ) ) {
			throw new \Exception( "File can't be opened for reading." );
		}
		fclose( $openedFile );

		$this->file = $file;
		$this->caseSensitive = $caseSensitive;
	}

	public function exists( string $needle ) :bool {
		return $this->findFirst( $needle ) >= 0;
	}

	public function findFirst( string $needle ) :int {
		$finds = $this->findAll( $needle, 1 );
		return empty( $finds ) ? -1 : \array_pop( $finds );
	}

	public function findAll( string $needle, int $limit = 0 ) :array {
		return $this->multipleFindAll( [ $needle ], $limit )[ $needle ];
	}

	public function multipleExists( array $needles ) :array {
		return \array_map(
			function ( array $finds ) {
				return \count( $finds ) > 0;
			},
			$this->multipleFindFirst( $needles )
		);
	}

	public function multipleFindFirst( array $needles ) :array {
		return $this->multipleFindAll( $needles, 1 );
	}

	public function multipleFindAll( array $needles, int $limit = 0 ) :array {
		$openedFile = fopen( $this->file, 'r' );

		$needles = \array_map( 'strval', $needles );

		$theLines = Arrays::SetAllValuesTo( \array_flip( $needles ), [] );
		$num = -1;
		while ( !feof( $openedFile ) ) {
			$num++;

			$line = fgets( $openedFile );
			if ( is_string( $line ) ) {

				foreach ( $needles as $needleKey => $needle ) {

					if ( $this->caseSensitive ? ( \strpos( $line, $needle ) !== false ) : ( stripos( $line, $needle ) !== false ) ) {
						$theLines[ $needle ][] = $num;
						if ( !empty( $limit ) && \count( $theLines[ $needle ] ) === $limit ) {
							unset( $needles[ $needleKey ] );
						}
					}
				}

				if ( empty( $needles ) ) {
					break;
				}
			}
		}
		fclose( $openedFile );

		return $theLines;
	}
}