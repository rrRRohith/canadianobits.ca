<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Consumers;

use FernleafSystems\Wordpress\Services\Core\VOs\Assets\WpPluginVo;

trait PluginConsumer {

	/**
	 * @var WpPluginVo
	 */
	private $oWorkingPlugin;

	/**
	 * @return WpPluginVo
	 */
	public function getWorkingPlugin() {
		return $this->oWorkingPlugin;
	}

	public function hasWorkingPlugin() :bool {
		return $this->oWorkingPlugin instanceof WpPluginVo;
	}

	/**
	 * @param WpPluginVo $plugin
	 * @return $this
	 */
	public function setWorkingPlugin( $plugin ) {
		$this->oWorkingPlugin = $plugin;
		return $this;
	}
}