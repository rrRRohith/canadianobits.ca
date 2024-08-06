<?php

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\Util;

class Diff extends Base {

	public const API_ENDPOINT = 'util/diff';
	public const REQUEST_TYPE = 'POST';
	public const RESPONSE_DATA_KEY = 'diff';
	public const REQUIRES_API_AVAILABILITY = false;

	/**
	 * @param string $left
	 * @param string $right
	 * @return array|null
	 */
	public function getDiff( $left, $right ) {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->left = $left;
		$req->right = $right;
		return $this->query();
	}
}