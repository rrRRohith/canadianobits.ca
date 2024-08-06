<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs;

use FernleafSystems\Utilities\Data\Adapter\StdClassAdapter;

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
 * @deprecated
 */
abstract class WpBaseVo {

	use StdClassAdapter {
		__get as __adapterGet;
		__set as __adapterSet;
	}

	protected $bHasExtendedData = false;

	/**
	 * @param string $sProperty
	 * @return mixed
	 */
	public function __get( $sProperty ) {

		if ( empty( $this->bHasExtendedData ) && \in_array( $sProperty, $this->getExtendedDataSlugs() ) ) {
			$this->applyFromArray( \array_merge( $this->getRawDataAsArray(), $this->getExtendedData() ) );
			$this->bHasExtendedData = true;
		}

		$mVal = $this->__adapterGet( $sProperty );

		switch ( $sProperty ) {

			case 'wp_info':
				if ( is_null( $mVal ) ) {
					$mVal = $this->loadWpInfo();
					$this->wp_info = $mVal;
				}
				break;

			default:
				break;
		}

		return $mVal;
	}

	/**
	 * @return string
	 */
	abstract public function getInstallDir():string;

	/**
	 * @return bool
	 */
	public function hasUpdate() {
		$this->new_version;
		return !empty( $this->new_version ) && version_compare( $this->new_version, $this->Version, '>' );
	}

	abstract public function isWpOrg() :bool;

	/**
	 * @return array
	 */
	abstract protected function getExtendedData();

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