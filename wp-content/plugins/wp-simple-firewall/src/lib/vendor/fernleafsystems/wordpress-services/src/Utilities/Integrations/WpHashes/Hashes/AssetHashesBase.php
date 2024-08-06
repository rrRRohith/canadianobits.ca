<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Hashes;

abstract class AssetHashesBase extends Base {

	public const DEFAULT_HASH_ALGO = 'md5';
	public const RESPONSE_DATA_KEY = 'hashes';
	public const TYPE = '';

	protected function getApiUrl() :string {
		$data = \array_map( '\strtolower', \array_filter( \array_merge(
			[
				'type'    => false,
				'slug'    => false,
				'version' => false,
				'locale'  => false,
				'hash'    => false,
			],
			$this->getRequestVO()->getRawData()
		) ) );
		return sprintf( '%s/%s', parent::getApiUrl(), \implode( '/', $data ) );
	}

	/**
	 * @return RequestVO
	 */
	protected function newReqVO() {
		return new RequestVO();
	}

	/**
	 * @inheritDoc
	 */
	protected function preRequest() {
		parent::preRequest();

		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		if ( empty( $req->hash ) ) {
			$this->setHashAlgo( static::DEFAULT_HASH_ALGO );
		}
		if ( empty( $req->type ) ) {
			$this->setType( static::TYPE );
		}
	}

	/**
	 * @param string $algo
	 * @return $this
	 */
	public function setHashAlgo( $algo ) {
		$this->getRequestVO()->hash = $algo;
		return $this;
	}

	/**
	 * @param string $type
	 * @return $this
	 */
	public function setType( $type ) {
		$this->getRequestVO()->type = $type;
		return $this;
	}
}