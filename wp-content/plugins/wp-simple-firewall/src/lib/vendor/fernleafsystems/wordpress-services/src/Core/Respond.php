<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Utilities\Response;
use FernleafSystems\Wordpress\Services\Services;

class Respond {

	/**
	 * @var Response
	 */
	protected $oResponse;

	public function send() {
		if ( Services::WpGeneral()->isAjax() ) {
			$this->sendAjax();
		}
		else {
			// render?
		}
		die();
	}

	/**
	 */
	public function sendAjax() {
		$response = $this->getResponse();
		$data = $response->getData();

		$sMessage = $response->getMessageText();
		if ( empty( $data[ 'message' ] ) && !empty( $sMessage ) ) {
			$data[ 'message' ] = $sMessage;
		}
		wp_send_json( $data, null );
	}

	/**
	 * @return Response
	 */
	public function getResponse() {
		return $this->oResponse;
	}

	/**
	 * @param Response $oResponse
	 * @return $this
	 */
	public function setResponse( $oResponse ) {
		$this->oResponse = $oResponse;
		return $this;
	}
}