<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Core\VOs\WpHttpResponseVo;

/**
 * @property string           $url
 * @property array            $requestArgs
 * @property WpHttpResponseVo $lastResponse
 * @property \WP_Error        $lastError
 */
class HttpRequest extends DynPropertiesClass {

	/**
	 * @param string $url
	 * @param array  $args
	 */
	public function get( $url, $args = [] ) :bool {
		return $this->request( $url, $args, 'GET' )->isSuccess();
	}

	/**
	 * @param array $args
	 */
	public function getContent( string $url, $args = [] ) :string {
		return $this->get( $url, $args ) ? \trim( (string)$this->lastResponse->body ) : '';
	}

	/**
	 * @param array $args
	 */
	public function post( string $url, $args = [] ) :bool {
		return $this->request( $url, $args, 'POST' )->isSuccess();
	}

	public function isSuccess() :bool {
		return $this->lastResponse instanceof WpHttpResponseVo;
	}

	/**
	 * This is provided for backward compatibility with the old requestUrl
	 * @param string $url
	 * @param array  $args
	 * @param string $method
	 * @return array|false
	 */
	public function requestUrl( $url, $args = [], $method = 'GET' ) {
		return $this->request( $url, $args, $method )->isSuccess() ?
			$this->lastResponse->getRawData() : false;
	}

	/**
	 * A helper method for making quick requests. At least a valid URL will need to be supplied.
	 * All requests default to empty data and GET
	 * @param string $url
	 * @param array  $args
	 * @param string $method
	 * @return $this
	 */
	public function request( $url = null, $args = null, $method = null ) {
		$this->resetResponses();
		try {
			if ( !empty( $url ) ) {
				$this->url = $url;
			}
			if ( \is_array( $args ) ) {
				$this->setRequestArgs( $args );
			}
			if ( !empty( $method ) ) {
				$this->setMethod( $method );
			}
			$this->lastResponse = $this->send();
		}
		catch ( \Exception $e ) {
			$this->lastError = new \WP_Error( 'odp-http-error', $e->getMessage() );
		}
		return $this;
	}

	/**
	 * @return array
	 */
	private function getRequestArgs() {
		if ( !is_array( $this->requestArgs ) ) {
			$this->requestArgs = [];
		}
		$this->requestArgs = \array_merge( [
			'method' => 'GET'
		], $this->requestArgs );
		return $this->requestArgs;
	}

	/**
	 * @throws \Exception
	 */
	private function send() :WpHttpResponseVo {
		if ( wp_http_validate_url( $this->url ) === false ) {
			throw new \Exception( 'URL is invalid' );
		}
		$mResult = wp_remote_request( $this->url, $this->getRequestArgs() );
		if ( is_wp_error( $mResult ) ) {
			throw new \Exception( $mResult->get_error_message() );
		}
		if ( !is_array( $mResult ) ) {
			throw new \Exception( 'WP Remote Request response should be an array' );
		}
		return ( new WpHttpResponseVo() )->applyFromArray( $mResult );
	}

	/**
	 * @param string $method
	 * @return $this
	 */
	public function setMethod( $method ) {
		return $this->setRequestArg( 'method', \strtoupper( $method ) );
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 * @return $this
	 */
	public function setRequestArg( $key, $value ) {
		$args = $this->getRequestArgs();
		$args[ $key ] = $value;
		return $this->setRequestArgs( $args );
	}

	/**
	 * @param array $args
	 * @return $this
	 */
	public function setRequestArgs( $args ) {
		$this->requestArgs = \is_array( $args ) ? $args : [];
		return $this;
	}

	/**
	 * @param string $url
	 * @return $this
	 */
	public function setUrl( $url ) {
		$this->url = $url;
		return $this;
	}

	/**
	 * @return $this
	 */
	private function resetResponses() {
		$this->lastResponse = null;
		$this->lastError = null;
		return $this;
	}
}