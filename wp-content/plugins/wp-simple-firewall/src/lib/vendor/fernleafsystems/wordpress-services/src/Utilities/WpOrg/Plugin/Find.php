<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services\Core\VOs\Assets\WpPluginVo;
use FernleafSystems\Wordpress\Services\Services;

class Find {

	/**
	 * These must align with the keys in plugins.json[identifiers]
	 */
	public const BUDDYBOSS = 'buddyboss';
	public const BUDDYPRESS = 'buddypress';
	public const CALDERA_FORMS = 'calderaforms';
	public const CONTACT_FORM_7 = 'contactform7';
	public const CLASSIFIED_LISTING = 'classifiedlisting';
	public const EASY_DIGITAL_DOWNLOADS = 'easydigitaldownloads';
	public const ELEMENTOR_PRO = 'elementorpro';
	public const FLUENT_FORMS = 'fluentforms';
	public const FORMIDABLE_FORMS = 'formidableforms';
	public const FORMINATOR = 'forminator';
	public const GRAVITY_FORMS = 'gravityforms';
	public const GROUNDHOGG = 'groundhogg';
	public const HAPPY_FORMS = 'happyforms';
	public const KALI_FORMS = 'kaliforms';
	public const LEARNPRESS = 'learnpress';
	public const LIFTERLMS = 'lifterlms';
	public const MEMBERPRESS = 'memberpress';
	public const NINJA_FORMS = 'ninjaforms';
	public const PAID_MEMBER_SUBSCRIPTIONS = 'paidmembersubscriptions';
	public const PROFILE_BUILDER = 'profilebuilder';
	public const PROFILEPRESS = 'profilepress';
	public const RESTRICT_CONTENT_PRO = 'restrictcontentpro';
	public const SITEGROUND_OPTIMIZER = 'sgcachepress';
	public const SUPER_FORMS = 'superforms';
	public const SUPPORT_CANDY = 'supportcandy';
	public const ULTIMATE_MEMBER = 'ultimatemember';
	public const W3_TOTAL_CACHE = 'w3totalcache';
	public const WEFORMS = 'weforms';
	public const WOOCOMMERCE = 'woocommerce';
	public const WORDFENCE = 'wordfence';
	public const WP_FORMS = 'wpforms';
	public const WP_FORO = 'wpforo';
	public const WP_MEMBERS = 'wpmembers';
	public const WP_UMBRELLA = 'wpumbrella';

	private $plugins;

	public function isPluginActive( string $plugin ) :bool {
		$found = !empty( $this->findPlugin( $plugin ) );
		if ( !$found ) {
			foreach ( $this->getPluginIdentifiers( $plugin )[ 'constants' ] ?? [] as $constant ) {
				if ( defined( $constant ) ) {
					$found = true;
					break;
				}
			}
		}
		return $found;
	}

	public function findPlugin( string $plugin ) :?string {
		$identifiers = $this->getPluginIdentifiers( $plugin );

		$plugin = $this->fromClasses( $identifiers[ 'classes' ] ?? [] );
		if ( empty( $plugin ) ) {
			$plugin = $this->fromFunctions( $identifiers[ 'functions' ] ?? [] );
		}

		return empty( $plugin ) ? null : $plugin->file;
	}

	public function fromClasses( array $classes ) :?WpPluginVo {
		$file = null;
		if ( !empty( $classes ) ) {
			foreach ( $classes as $class ) {
				if ( @\class_exists( $class ) ) {
					try {
						$ref = new \ReflectionClass( $class );
						$file = $ref->getFileName();
					}
					catch ( \ReflectionException $e ) {
					}
				}

				if ( !empty( $file ) ) {
					break;
				}
			}
		}

		return empty( $file ) ? null : ( new Files() )->findPluginFromFile( $file );
	}

	public function fromFunctions( array $functions ) :?WpPluginVo {
		$file = null;
		if ( !empty( $functions ) ) {
			foreach ( $functions as $function ) {
				if ( @\function_exists( $function ) ) {
					try {
						$ref = new \ReflectionFunction( $function );
						$file = $ref->getFileName();
					}
					catch ( \ReflectionException $e ) {
					}
				}

				if ( !empty( $file ) ) {
					break;
				}
			}
		}

		return empty( $file ) ? null : ( new Files() )->findPluginFromFile( $file );
	}

	public function getPluginIdentifiers( string $plugin ) :array {
		if ( !isset( $this->plugins ) ) {
			$raw = Services::Data()->readFileWithInclude( Services::DataDir( 'plugins.json' ) );
			if ( empty( $raw ) ) {
				$raw = Services::WpFs()->getFileContent( $raw );
			}
			$this->plugins = empty( $raw ) ? [] : \json_decode( $raw, true );
		}
		return $this->plugins[ $plugin ][ 'identifiers' ] ?? [];
	}
}