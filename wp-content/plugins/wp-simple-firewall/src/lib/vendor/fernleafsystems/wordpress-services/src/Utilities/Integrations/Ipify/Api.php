<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\Ipify;

use FernleafSystems\Wordpress\Services\Services;

class Api {

	public const IpifyEndpoint4 = 'https://api.ipify.org';
	public const IpifyEndpoint6 = 'https://api64.ipify.org';

	/**
	 * @return string[]
	 */
	public function getMyIps() {
		return \array_unique( \array_filter( [
			$this->getMyIp4(),
			$this->getMyIp6(),
			Services::Request()->getServerAddress()
		] ) );
	}

	public function getMyIp4() :string {
		return $this->sendReq( static::IpifyEndpoint4 );
	}

	public function getMyIp6() :string {
		return $this->sendReq( static::IpifyEndpoint6 );
	}

	/**
	 * @param string $endpoint
	 */
	protected function sendReq( $endpoint ) :string {
		return \trim( Services::HttpRequest()->getContent( $endpoint ) );
	}
}