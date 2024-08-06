<?php

namespace FernleafSystems\Wordpress\Services\Core;

class Nonce {

	/**
	 * @var bool
	 */
	private $bIncludeUserId;

	/**
	 * @var string
	 */
	private $action;

	public function create() {
		if ( !$this->hasAction() ) {
			throw new \Exception( 'No action specified for nonce' );
		}
		return $this->isIncludeUserId() ? wp_create_nonce( $this->getAction() ) : $this->createNonceNoUser();
	}

	/**
	 * @param string $nonce
	 * @return false|int
	 * @throws \Exception
	 */
	public function verify( $nonce ) {
		if ( !$this->hasAction() ) {
			throw new \Exception( 'No action specified for nonce' );
		}
		return $this->isIncludeUserId() ? wp_verify_nonce( $nonce, $this->getAction() ) : $this->verifyNonceNoUser( $nonce );
	}

	/**
	 * Taken directly from wp_create_nonce() but excludes the user ID part.
	 * @return false|string
	 */
	private function createNonceNoUser() {
		$token = wp_get_session_token();
		$i = wp_nonce_tick();
		return substr( wp_hash( $i.'|'.$this->getAction().'|'.$token, 'nonce' ), -12, 10 );
	}

	/**
	 * @param $nonce
	 * @return int
	 * @throws \Exception
	 */
	private function verifyNonceNoUser( $nonce ) {
		if ( empty( $nonce ) ) {
			throw new \Exception( 'Nonce is empty' );
		}

		$token = wp_get_session_token();
		$i = wp_nonce_tick();

		// Nonce generated 0-12 hours ago.
		$expected = substr( wp_hash( $i.'|'.$this->getAction().'|'.$token, 'nonce' ), -12, 10 );
		if ( hash_equals( $expected, $nonce ) ) {
			return 1;
		}

		// Nonce generated 12-24 hours ago.
		$expected = substr( wp_hash( ( $i - 1 ).'|'.$this->getAction().'|'.$token, 'nonce' ), -12, 10 );
		if ( hash_equals( $expected, $nonce ) ) {
			return 2;
		}

		throw new \Exception( 'Nonce verification failed.' );
	}

	public function getAction() :string {
		return (string)$this->action;
	}

	public function hasAction() :bool {
		return !empty( $this->action );
	}

	public function isIncludeUserId() :bool {
		return isset( $this->bIncludeUserId ) ? (bool)$this->bIncludeUserId : true;
	}

	public function setAction( string $action ) :self {
		$this->action = $action;
		return $this;
	}

	public function setIncludeUserId( bool $use ) :self {
		$this->bIncludeUserId = $use;
		return $this;
	}
}