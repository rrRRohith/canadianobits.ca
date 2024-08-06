<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Consumers;

trait WpUserConsumer {

	/**
	 * @var \WP_User
	 */
	private $user;

	public function getWpUser() :\WP_User {
		return $this->user;
	}

	/**
	 * @return $this
	 */
	public function setWpUser( \WP_User $user ) {
		$this->user = $user;
		return $this;
	}
}