<?php declare( strict_types=1 );

namespace FernleafSystems\Utilities\Data;

class CaptureOutput {

	public static function Capture( callable $func, array $args = [] ) :string {
		ob_start();
		empty( $args ) ? call_user_func( $func ) : call_user_func_array( $func, $args );
		$out = ob_get_clean();
		return is_string( $out ) ? $out : 'No output from capture';
	}
}