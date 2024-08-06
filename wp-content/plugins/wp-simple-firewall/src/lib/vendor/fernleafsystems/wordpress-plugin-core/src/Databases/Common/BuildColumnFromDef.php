<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use FernleafSystems\Wordpress\Services\Services;

class BuildColumnFromDef {

	public const MACROTYPE_PRIMARYID = 'primary_id';
	public const MACROTYPE_BLOB = 'blob';
	public const MACROTYPE_BLOBLONG = 'longblob';
	public const MACROTYPE_TIMESTAMP = 'timestamp';
	public const MACROTYPE_UNSIGNEDINT = 'unsigned_int';
	public const MACROTYPE_BIGINT = 'bigint';
	public const MACROTYPE_FOREIGN_KEY_ID = 'foreign_key_id';
	public const MACROTYPE_BINARYHASH = 'binary_hash';
	public const MACROTYPE_HASH = 'hash';
	public const MACROTYPE_SHA1 = 'sha1';
	public const MACROTYPE_SHA256 = 'sha256';
	public const MACROTYPE_MD5 = 'md5';
	public const MACROTYPE_IP = 'ip';
	public const MACROTYPE_META = 'meta';
	public const MACROTYPE_TEXT = 'text';
	public const MACROTYPE_URL = 'url';
	public const MACROTYPE_BOOL = 'bool';
	public const MACROTYPE_CHAR = 'char';
	public const MACROTYPE_VARCHAR = 'varchar';

	private $def;

	public function __construct( array $def ) {
		$this->setDef( $def );
	}

	public function getDef() :array {
		return $this->def;
	}

	public function setDef( array $def ) :self {
		$this->def = $def;
		return $this;
	}

	public function build() :string {
		$def = $this->buildStructure();
		if ( isset( $def[ 'default' ] )
			 && \in_array( $def[ 'type' ], [ 'char', 'varchar' ] )
			 && \preg_match( '#^[^"\'].+[^"\']$#', $def[ 'default' ] )
		) {
			$def[ 'default' ] = sprintf( "'%s'", \addslashes( $def[ 'default' ] ) );
		}
		return sprintf( '%s%s %s %s %s',
			$def[ 'type' ],
			isset( $def[ 'length' ] ) ? sprintf( '(%s)', $def[ 'length' ] ) : '',
			\implode( ' ', $def[ 'attr' ] ?? [] ),
			isset( $def[ 'default' ] ) ? sprintf( "DEFAULT %s", $def[ 'default' ] ) : '',
			isset( $def[ 'comment' ] ) ? sprintf( "COMMENT '%s'", \str_replace( "'", '', $def[ 'comment' ] ) ) : ''
		);
	}

	public function buildStructure() :array {
		$structure = Services::DataManipulation()->mergeArraysRecursive(
			Types::GetMacroTypeDef( $this->def[ 'macro_type' ] ?? '' ),
			$this->def
		);

		if ( $this->def[ 'no_length' ] ?? false ) {
			unset( $structure[ 'length' ] );
		}

		return $structure;
	}
}