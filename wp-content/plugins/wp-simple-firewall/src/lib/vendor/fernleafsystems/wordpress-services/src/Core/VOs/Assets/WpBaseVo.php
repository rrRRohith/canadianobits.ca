<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs\Assets;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;

/**
 * @property string Name
 * @property string Version
 * @property string Description
 * @property string Author
 * @property string AuthorURI
 * @property string TextDomain
 * @property string DomainPath
 * @property bool   $active
 * @property string $version      - alias for Version
 * @property string $unique_id    - alias for file/stylesheet
 * @property string $asset_type   - plugin or theme
 * @property mixed  $wp_info      - Plugin/Theme API Info
 */
abstract class WpBaseVo extends DynPropertiesClass {

	protected $extendedDataLoaded = false;

	public function __get( string $key ) {

		if ( empty( $this->extendedDataLoaded ) && \in_array( $key, $this->getExtendedDataSlugs() ) ) {
			$this->applyFromArray( \array_merge( $this->getRawData(), $this->getExtendedData() ) );
			$this->extendedDataLoaded = true;
		}

		$value = parent::__get( $key );

		switch ( $key ) {

			case 'wp_info':
				if ( is_null( $value ) ) {
					$value = $this->loadWpInfo();
					$this->wp_info = $value;
				}
				break;

			default:
				break;
		}

		return $value;
	}

	abstract public function getInstallDir() :string;

	public function hasUpdate() :bool {
		$this->new_version;
		return !empty( $this->new_version ) && version_compare( $this->new_version, $this->Version, '>' );
	}

	abstract public function isWpOrg() :bool;

	abstract protected function getExtendedData() :array;

	/**
	 * @return string[]
	 */
	protected function getExtendedDataSlugs() :array {
		return [
			'new_version',
		];
	}

	/**
	 * @return mixed|false
	 */
	abstract protected function loadWpInfo();
}