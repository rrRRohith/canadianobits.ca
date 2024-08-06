<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Integrations\WpHashes\CrowdSourcedHashes\Submit;

use FernleafSystems\Wordpress\Services\Core\VOs\Assets;

class Submit extends BaseSubmit {

	public const REQUEST_TYPE = 'POST';

	/**
	 * @inheritDoc
	 */
	public function preRequest() {
		parent::preRequest();

		/** @var RequestVO $req */
		$req = $this->getRequestVO();
		$req->hashes = $this->hashes; // hashes are sent with a full submit
	}

	public function submitPlugin( Assets\WpPluginVo $VO ) :?array {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();

		$req->type = 'p';
		$req->slug = $VO->slug;
		$req->version = $VO->Version;

		return $this->query();
	}

	public function submitTheme( Assets\WpThemeVo $VO ) :?array {
		/** @var RequestVO $req */
		$req = $this->getRequestVO();

		$req->type = 't';
		$req->slug = $VO->stylesheet;
		$req->version = $VO->Version;

		return $this->query();
	}
}