<?php
namespace TrxUpdater\Core\Update;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base {

	/**
	 * Update URL
	 *
	 * URL to send request to download archive with new version of the theme or plugin
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var update_url
	 */
	protected $update_url;

	/**
	 * Current theme slug
	 *
	 * Slug of the current (active) theme
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var theme_slug
	 */
	protected $theme_slug;

	/**
	 * Current theme name
	 *
	 * Name of the current (active) theme
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var theme_name
	 */
	protected $theme_name;

	/**
	 * Current theme version
	 *
	 * Version of the current (active) theme
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var theme_version
	 */
	protected $theme_version;

	/**
	 * Current theme purchase key
	 *
	 * Purchase key of the current (active) theme
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var theme_key
	 */
	protected $theme_key;

	/**
	 * Current theme directory
	 *
	 * Directory of the current (active) theme
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var theme_dir
	 */
	protected $theme_dir;

	/**
	 * Plugin's options
	 *
	 * Holder for plugin's options object
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var options
	 */
	protected $options;

	/**
	 * Update manager
	 *
	 * Holder for update manager object
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var manager
	 */
	protected $manager;

	/**
	 * Class constructor.
	 *
	 * Initializing update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $manager = null ) {
		$theme               = wp_get_theme( get_option( 'template' ) );
		$this->manager       = $manager;
		$this->options       = \TrxUpdater\Core\Options::instance();
		$this->update_url    = 'http://upgrade.themerex.net/upgrade.php';
		$this->theme_slug    = get_option( 'template' );
		$this->theme_name    = $theme->name;
		$this->theme_version = $theme->Version;
		$this->theme_key     = $this->get_theme_activation_code();
		$this->theme_dir     = trailingslashit( get_template_directory() );
		$this->plugins_dir   = trailingslashit( dirname( TRX_UPDATER_DIR ) );
	}

	/**
	 * Return theme activation code
	 *
	 * Return theme activation code (entered by user in the theme activation process)
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_theme_activation_code() {
		$template = get_option( 'template' );
		return $this->options->get_option( 'theme_key' ) != ''
					? $this->options->get_option( 'theme_key' )
					: apply_filters( 'trx_updater_filter_theme_purchase_key',
						get_option( sprintf( 'trx_addons_theme_%s_activated', $template ) ) == 1
							? get_option( sprintf( 'purchase_code_%s', $template ) )
							: get_option( sprintf( '%s_theme_code_activation', $template ) )
						);
	}


	/**
	 * Return theme market code
	 *
	 * Return theme market code to check purchase key
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_theme_market_code() {
		return apply_filters( 'trx_addons_filter_get_theme_data', '*', 'theme_pro_key' );
	}


	/**
	 * Return url for install, update or activate plugin
	 *
	 * Return url for install, update or activate plugin (by slug)
	 *
	 * @param string $slug	Plugin or theme name
	 * @param string $state 'install|activate|update' - action to do with item
	 * @param string $type	'plugin|theme' - type of the item
	 * @return bool
	 * 
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_iau_link( $slug, $state, $type = 'plugin' ) {
		$nonce = '';
		if ( ! empty( $slug ) ) {
			$use_tgmpa = false;
			if ( $type == 'plugin' ) {
				if ( class_exists( 'TGM_Plugin_Activation' ) ) {
					$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
					$use_tgmpa = true;
				}
			} 
			if ( $state == 'install' ) {
				if ( $use_tgmpa  ) {
					$nonce    = wp_nonce_url(
						add_query_arg(
							array(
								'tgmpa-install' => 'install-' . $type,
								$type           => urlencode( $slug ),
							),
							$instance->get_tgmpa_url()
						),
						'tgmpa-install',
						'tgmpa-nonce'
					);
				} else {
					$nonce = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-' . $type,
								'from'   => 'import',
								$type    => urlencode( $slug ),
							),
							network_admin_url( 'update.php' )
						),
						'install-' . $type . '_' . trim( $slug )
					);
				}
			} else if ( $state == 'update' ) {
				if ( $use_tgmpa  ) {
					$nonce    = wp_nonce_url(
						add_query_arg(
							array(
								'tgmpa-update' => 'update-' . $type,
								$type           => urlencode( $slug ),
							),
							$instance->get_tgmpa_url()
						),
						'tgmpa-update',
						'tgmpa-nonce'
					);
				} else {
					$nonce = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'update-' . $type,
								'from'   => 'import',
								$type    => urlencode( $slug ),
							),
							network_admin_url( 'update.php' )
						),
						'update-' . $type . '_' . trim( $slug )
					);
				}
			} elseif ( $state == 'activate' ) {
				if ( $use_tgmpa  ) {
					$nonce    = wp_nonce_url(
						add_query_arg(
							array(
								'tgmpa-activate' => 'activate-' . $type,
								$type            => urlencode( $slug ),
							),
							$instance->get_tgmpa_url()
						),
						'tgmpa-activate',
						'tgmpa-nonce'
					);
				} else {
					$plugin_link = $slug . '/' . $slug . '.php';
					$nonce       = add_query_arg(
						array(
							'action'        => 'activate',
							'plugin'        => rawurlencode( $plugin_link ),
							'plugin_status' => 'all',
							'paged'         => '1',
							'_wpnonce'      => wp_create_nonce( 'activate-' . $type . '_' . $plugin_link ),
						),
						network_admin_url( 'plugins.php' )
					);
				}
			}
		}
		return $nonce;
	}

	/**
	 * Inject theme update info to the WordPress cache
	 *
	 * Add theme info to the transient with update data for plugins, themes, etc.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function inject_update_info( $type, $info ) {
		$repo_updates = get_site_transient( 'update_' . $type );

		if ( ! is_object( $repo_updates ) ) {
			$repo_updates = new \stdClass;
		}

		foreach ( $info as $slug => $data ) {
			if ( $type == 'plugins' ) {
				if ( empty( $repo_updates->response[ $slug ] ) ) {
					$repo_updates->response[ $slug ] = new \stdClass;
				}
				$repo_updates->response[ $slug ]->slug        = $slug;
				$repo_updates->response[ $slug ]->new_version = $data['new_version'];
				$repo_updates->response[ $slug ]->package     = $data['package'];
				if ( ! empty( $data['url'] ) ) {
					$repo_updates->response[ $slug ]->url = $data['url'];
				}
				if ( ! empty( $data['plugin'] ) ) {
					$repo_updates->response[ $slug ]->plugin = $data['plugin'];
				}
				if ( ! empty( $data['theme'] ) ) {
					$repo_updates->response[ $slug ]->theme = $data['theme'];
				}
			} else {
				$repo_updates->response[ $slug ] = $data;
			}
		}
		set_site_transient( 'update_' . $type, $repo_updates );
	}

	/**
	 * Return theme or plugin icon
	 *
	 * Return theme or plugin icon to display it in the update screen.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_item_icon( $type, $slug, $title ) {
		$icon = '';
		if ( $type == 'plugin' ) {
			$icon    = 'plugins/' . sanitize_file_name( $slug ) . '/' . sanitize_file_name( $slug ) . '.png';
			$icon2x  = 'plugins/' . sanitize_file_name( $slug ) . '/' . sanitize_file_name( $slug ) . '@2x.png';
			$icon    = file_exists( trailingslashit( get_template_directory() ) . $icon2x )
						? '<img src="' . esc_url( trailingslashit( get_template_directory_uri() ) . $icon2x ) . '" width="85" class="updates-table-screenshot" alt="' . esc_attr( $title ) . '">'
						: ( file_exists( trailingslashit( get_template_directory() ) . $icon )
							? '<img src="' . esc_url( trailingslashit( get_template_directory_uri() ) . $icon ) . '" width="85" class="updates-table-screenshot" alt="' . esc_attr( $title ) . '">'
							: '' );
		} else if ( $type == 'theme' ) {
			$theme_dir = trailingslashit( get_option('stylesheet') == $slug 
											? get_template_directory()
											: trailingslashit( get_theme_root( $slug ) ) . $slug
										);
			$theme_url = trailingslashit( get_option('stylesheet') == $slug
											? get_template_directory_uri()
											: str_replace( '/' . get_option('stylesheet'), '/' . $slug, get_template_directory_uri() )
										); 
			$theme_screen = file_exists( $theme_dir . 'screenshot.jpg' )
							? $theme_url . 'screenshot.jpg'
							: ( file_exists( $theme_dir . 'screenshot.png' )
								? $theme_url . 'screenshot.png'
								: ''
								);
			if ( ! empty( $theme_screen ) ) {
				$icon = '<img class="updates-table-screenshot" src="' . esc_url( $theme_screen ) . '" alt="' . esc_attr( $title ) . '">';
			}
		}
		return ! empty( $icon ) ? $icon : '<span class="dashicons dashicons-admin-plugins"></span>';
	}

}
