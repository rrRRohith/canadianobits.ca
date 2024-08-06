<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Core\Rest\Route;

trait RestRequestConsumer {

	/**
	 * @var \WP_REST_Request
	 */
	private $wpRestRequest;

	public function getWpRestRequest() :\WP_REST_Request {
		return $this->wpRestRequest;
	}

	/**
	 * @return $this
	 */
	public function setWpRestRequest( \WP_REST_Request $req ) {
		$this->wpRestRequest = $req;
		return $this;
	}
}