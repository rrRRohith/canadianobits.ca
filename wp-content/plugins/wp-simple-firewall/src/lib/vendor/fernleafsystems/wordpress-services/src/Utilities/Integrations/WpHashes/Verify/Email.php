<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Verify;

class Email extends Base {
	public const TOKEN_REQUIRED = true;

	/**
	 * @return array|null
	 */
	public function getEmailVerification( string $email ) {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->action = 'email';
		$req->address = $email;
		return $this->query();
	}

	protected function getApiUrl() :string {
		$data = \array_map( 'rawurlencode', \array_filter( \array_merge(
			[
				'action'  => false,
				'address' => false,
			],
			$this->getRequestVO()->getRawData()
		) ) );
		return sprintf( '%s/%s', parent::getApiUrl(), \implode( '/', $data ) );
	}
}