<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs\Assets;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\WpOrg\Theme;

/**
 * @property string                      $theme        - the stylesheet
 * @property string                      $stylesheet   - the stylesheet
 * @property \WP_Theme                   $wp_theme
 * @property Theme\VOs\ThemeInfoVO|false $wp_info      - wp.org theme info
 * @property string                      $new_version
 * @property string                      $url
 * @property string                      $package
 * @property string                      $requires
 * @property string                      $requires_php
 * @property bool                        $is_child
 * @property bool                        $is_inactive_child
 * @property bool                        $is_parent
 *
 * Dynamic Properties:
 * @property string                      $slug         (alias for Stylesheet)
 * @property WpThemeVo|null              $parent_theme
 * @property WpThemeVo|null              $child_theme
 */
class WpThemeVo extends WpBaseVo {

	/**
	 * WpPluginVo constructor.
	 * @param string $stylesheet - the name of the theme folder.
	 * @throws \Exception
	 */
	public function __construct( string $stylesheet ) {
		$WPT = Services::WpThemes();
		$t = $WPT->getTheme( $stylesheet );
		if ( empty( $t ) ) {
			throw new \Exception( sprintf( 'Theme file %s does not exist', $stylesheet ) );
		}
		$this->wp_theme = $t;
		$this->stylesheet = $stylesheet;
		$this->active = $WPT->isActive( $stylesheet );
		$this->is_child = $this->active && $WPT->isActiveThemeAChild();
		$this->is_parent = !$this->active && $WPT->isActiveParent( $stylesheet );
	}

	public function __get( string $key ) {
		$WPT = Services::WpThemes();

		$value = parent::__get( $key );

		if ( \in_array( $key, $this->getWpThemeKeys() ) ) {
			$value = $this->wp_theme->get( $key );
		}
		else {
			switch ( $key ) {

				case 'asset_type':
					$value = 'theme';
					break;

				case 'slug':
				case 'unique_id':
					$value = $this->stylesheet;
					break;

				case 'version':
					if ( is_null( $value ) ) {
						$value = $this->Version;
					}
					break;

				case 'child_theme':
					$value = $this->is_parent ? $WPT->getThemeAsVo( $this->wp_theme->get_stylesheet() ) : null;
					break;

				case 'parent_theme':
					$value = $this->is_child ? $WPT->getThemeAsVo( $this->wp_theme->get_template() ) : null;
					break;

				default:
					break;
			}
		}

		return $value;
	}

	/**
	 * @return string[]
	 */
	private function getWpThemeKeys() :array {
		return [
			'Name',
			'ThemeURI',
			'Description',
			'Author',
			'AuthorURI',
			'Version',
			'Template',
			'Status',
			'Tags',
			'TextDomain',
			'DomainPath',
		];
	}

	public function getInstallDir() :string {
		return wp_normalize_path( trailingslashit( $this->wp_theme->get_stylesheet_directory() ) );
	}

	public function isWpOrg() :bool {
		$this->wp_info;
		return !empty( $this->wp_info );
	}

	protected function getExtendedData() :array {
		return Services::WpThemes()->getExtendedData( $this->stylesheet );
	}

	/**
	 * @inheritDoc
	 */
	protected function getExtendedDataSlugs() :array {
		return \array_merge( parent::getExtendedDataSlugs(), [
			'theme',
			'package',
			'requires',
			'requires_php',
			'url',
		] );
	}

	/**
	 * @return false|Theme\VOs\ThemeInfoVO
	 */
	protected function loadWpInfo() {
		$info = false;
		try {
			// TODO: Edge-case - inactive Child Themes
			if ( !$this->is_child ) {
				$info = ( new Theme\Api() )
					->setWorkingSlug( $this->stylesheet )
					->getInfo();
			}
		}
		catch ( \Exception $e ) {
		}
		return $info;
	}
}