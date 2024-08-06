<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

class Html {

	/**
	 * @param string $href
	 * @param string $txt
	 * @param string $target
	 * @param array  $args
	 */
	public function href( $href, $txt, $target = '_blank', $args = [] ) :string {
		foreach ( $args as $key => $value ) {
			$args[ $key ] = sprintf( '%s="%s"', $key, $value );
		}
		return sprintf(
			'<a href="%s" target="%s"%s>%s</a>',
			$href, $target, ( empty( $args ) ? '' : ' '.implode( ' ', $args ) ), $txt
		);
	}
}