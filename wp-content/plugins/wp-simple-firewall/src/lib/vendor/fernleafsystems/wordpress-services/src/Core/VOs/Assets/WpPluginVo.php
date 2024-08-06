<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs\Assets;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

/**
 * @property string                  PluginURI
 * @property bool                    Network
 * @property string                  Title
 * @property string                  AuthorName
 * Extended Properties:
 * @property string                  $id
 * @property string                  $slug
 * @property string                  $plugin
 * @property string                  $new_version
 * @property string                  $url
 * @property string                  $package      - the update package URL
 * Custom Properties:
 * @property string                  $file
 * @property bool                    $svn_uses_tags
 * @property Plugin\VOs\PluginInfoVO $wp_info
 */
class WpPluginVo extends WpBaseVo {

	/**
	 * WpPluginVo constructor.
	 * @param string $baseFile
	 * @throws \Exception
	 */
	public function __construct( string $baseFile ) {
		$WPP = Services::WpPlugins();
		$p = $WPP->getPlugin( $baseFile );
		if ( empty( $p ) ) {
			throw new \Exception( sprintf( 'Plugin file %s does not exist', $baseFile ) );
		}
		$this->applyFromArray( $p );
		$this->file = $baseFile;
		$this->active = $WPP->isActive( $baseFile );
	}

	public function __get( string $key ) {

		$value = parent::__get( $key );

		switch ( $key ) {

			case 'asset_type':
				$value = 'plugin';
				break;

			case 'slug':
				if ( empty( $value ) ) {
					$value = dirname( $this->file );
				}
				break;

			case 'unique_id':
				$value = $this->file;
				break;

			case 'version':
				$value = $this->Version;
				break;

			case 'svn_uses_tags':
				if ( is_null( $value ) ) {
					$value = ( new Plugin\Versions() )
						->setWorkingSlug( $this->slug )
						->exists( $this->Version );
					$this->svn_uses_tags = $value;
				}
				break;

			default:
				break;
		}

		return $value;
	}

	public function getInstallDir() :string {
		return wp_normalize_path( trailingslashit( dirname( path_join( WP_PLUGIN_DIR, $this->file ) ) ) );
	}

	public function isWpOrg() :bool {
		$this->id; // loads the data
		return \strpos( (string)$this->id, 'w.org/' ) === 0;
	}

	protected function getExtendedData() :array {
		return Services::WpPlugins()->getExtendedData( $this->file );
	}

	/**
	 * @return string[]
	 */
	protected function getExtendedDataSlugs() :array {
		return \array_merge( parent::getExtendedDataSlugs(), [
			'id',
			'slug',
			'plugin',
			'package',
			'url',
		] );
	}

	/**
	 * @return false|Plugin\VOs\PluginInfoVO
	 */
	protected function loadWpInfo() {
		try {
			$info = ( new Plugin\Api() )
				->setWorkingSlug( $this->slug )
				->getInfo();
		}
		catch ( \Exception $e ) {
			$info = false;
		}
		return $info;
	}
}