<?php declare( strict_types=1 );

namespace FernleafSystems\Utilities\Data\Response;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @property bool   $success
 * @property bool   $failed
 * @property mixed  $error_code
 * @property string $error_text
 * @property string $msg_text
 * @property array  $debug
 */
class StdResponse extends DynPropertiesClass {

	public function addDebug( string $msg ) :self {
		$debug = $this->debug;
		$debug[] = $msg;
		$this->debug = $debug;
		return $this;
	}

	public function __get( string $key ) {
		$value = parent::__get( $key );
		switch ( $key ) {
			case 'failed':
				$value = !$this->success;
				break;
			case 'success':
				$value = (bool)$value;
				break;
			case 'error_text':
			case 'msg_text':
				$value = (string)$value;
				break;
			case 'debug':
				$value = is_array( $value ) ? $value : [];
				break;
			default:
				break;
		}
		return $value;
	}
}