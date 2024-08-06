<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Autoloading;

class FindClassFromNamespaceRoots {

	public static function Find( string $class, array $roots, bool $beInstantiable = true, bool $throwEx = true ) :string {
		$theClass = '';

		$roots = \array_map( function ( $root ) {
			return rtrim( $root, '\\' ).'\\';
		}, $roots );

		foreach ( $roots as $NS ) {
			$maybe = $NS.$class;
			if ( @\class_exists( $maybe ) ) {
				try {
					if ( !$beInstantiable || ( new \ReflectionClass( $maybe ) )->isInstantiable() ) {
						$theClass = $maybe;
						break;
					}
				}
				catch ( \ReflectionException $e ) {
					continue;
				}
			}
		}

		if ( $throwEx && empty( $theClass ) ) {
			throw new \Exception( sprintf( 'Could not find class for element "%s".', $class ) );
		}

		return $theClass;
	}
}