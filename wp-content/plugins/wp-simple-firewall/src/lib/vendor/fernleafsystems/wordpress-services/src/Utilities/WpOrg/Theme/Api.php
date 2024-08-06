<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base\ApiBase;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme\VOs\ThemeInfoVO;

/**
 * @property array $fields
 */
class Api extends ApiBase {

	use Base;

	/**
	 * @throws \Exception
	 */
	public function getInfo() :ThemeInfoVO {
		return ( new ThemeInfoVO() )->applyFromArray( $this->run( 'theme_information' ) );
	}

	/**
	 * @return ThemeInfoVO
	 * @throws \Exception
	 * @deprecated 0.1.19
	 */
	public function getThemeInfo() {
		return $this->getInfo();
	}

	/**
	 * @throws \Exception
	 */
	public function run( string $cmd ) :array {
		include_once( ABSPATH.'wp-admin/includes/theme.php' );

		$params = $this->getRawData();
		$params[ 'slug' ] = $this->getWorkingSlug();
		$params = Services::DataManipulation()->mergeArraysRecursive( $this->defaultParams(), $params );

		$key = \md5( \serialize( \array_merge( $params, [
			'cmd'      => $cmd,
			'function' => 'themes_api',
		] ) ) );

		$response = $this->getCache( $key );
		if ( $response === null ) {
			$response = \themes_api( $cmd, $params );
			$this->addCache( $key, $response );
		}

		if ( \is_wp_error( $response ) ) {
			throw new \Exception( sprintf( '[ThemesApi Error] %s', $response->get_error_message() ) );
		}

		return (array)$response;
	}

	protected function defaultParams() :array {
		return [
			'fields' => [
				'rating'   => true,
				'ratings'  => true,
				'versions' => true,
			]
		];
	}
}