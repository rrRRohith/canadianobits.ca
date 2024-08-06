<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base\ApiBase;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin\VOs\PluginInfoVO;

class Api extends ApiBase {

	use Base;

	/**
	 * @throws \Exception
	 */
	public function getInfo() :PluginInfoVO {
		return ( new PluginInfoVO() )->applyFromArray( $this->run( 'plugin_information' ) );
	}

	/**
	 * @throws \Exception
	 */
	public function run( string $cmd ) :array {
		include_once( ABSPATH.'wp-admin/includes/plugin-install.php' );

		$params = $this->getRawData();
		$params[ 'slug' ] = $this->getWorkingSlug();
		$params = Services::DataManipulation()->mergeArraysRecursive( $this->defaultParams(), $params );

		$key = \md5( \serialize( \array_merge( $params, [
			'cmd'      => $cmd,
			'function' => 'plugins_api',
		] ) ) );

		$response = $this->getCache( $key );
		if ( $response === null ) {
			$response = \plugins_api( $cmd, $params );
			$this->addCache( $key, $response );
		}

		if ( \is_wp_error( $response ) ) {
			throw new \Exception( sprintf( '[PluginsApi Error] %s', $response->get_error_message() ) );
		}

		return (array)$response;
	}
}