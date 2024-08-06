<?php

namespace FernleafSystems\Wordpress\Services\Core;

class CustomHooks {

	public const HOOK_PREFIX = 'odp_';

	public function __construct() {
		add_action( 'upgrader_process_complete', [ $this, 'onUpgraderProcessComplete' ], 100, 2 );
	}

	/**
	 * 'install', 'update'
	 * 'plugin', 'theme', 'translation', or 'core'
	 * @param \WP_Upgrader $upgrader
	 * @param array        $options
	 */
	public function onUpgraderProcessComplete( $upgrader, $options ) {
		if ( !empty( $options[ 'type' ] ) && !empty( $options[ 'action' ] ) ) {
			// e.g. odp_plugin_install_complete
			$hookName = static::HOOK_PREFIX.$options[ 'type' ].'_'.$options[ 'action' ].'_complete';
			do_action( $hookName, $upgrader, $options );
		}
	}
}