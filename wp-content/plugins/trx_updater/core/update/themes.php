<?php
namespace TrxUpdater\Core\Update;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Themes extends Base {

	/**
	 * Theme info from the upgrade server
	 *
	 * Info from the upgrade server about active theme
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @var theme_info
	 */
	private $theme;

	/**
	 * Theme parts to save while upgrade
	 *
	 * Save theme parts before upgrade
	 *
	 * @since 1.4.1
	 * @access private
	 *
	 * @var theme_parts
	 */
	private $theme_parts;

	/**
	 * Class constructor.
	 *
	 * Initializing themes update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $manager ) {

		parent::__construct( $manager );

		add_action( 'init', array( $this, 'init') );

		add_filter( 'wp_get_update_data', array( $this, 'add_theme_to_update_counts' ), 10, 2 );
		add_action( 'core_upgrade_preamble', array( $this, 'add_theme_to_update_screen' ), 8 );
		add_action( 'update-custom_update-theme', array( $this, 'update_theme' ) );
	}

	/**
	 * Init object
	 *
	 * Get current (active) theme information from upgrade server
	 *
	 * Fired by `init` action
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		$this->theme = $this->get_theme_info();
	}

	/**
	 * Retrieve info about current theme
	 *
	 * Retrieve info about current (active) theme from the updates server
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_theme_info() {
		$data = get_transient( 'trx_updater_theme_info' );
		if ( ! is_array( $data ) || ! empty( $_GET['force-check'] ) ) {
			$data = array(
						$this->theme_slug => array(
													'version' => '0.0.1',
													'update_from' => '0.0.2',
													)
						);
			$skin = $this->get_active_skin();
			$response = trx_updater_fgc( $this->update_url
											. '?action=info_theme'
											. '&theme_slug=' . urlencode( $this->theme_slug )
											. ( ! empty( $skin ) ? '&skin=' . urlencode( $skin ) : '' )
										);
			if ( !empty($response) && is_serialized($response) ) {
				$response = unserialize($response);
				if ( !empty($response['data']) && substr($response['data'], 0, 1) == '{' ) {
					$data[ $this->theme_slug ] = json_decode($response['data'], true);
				}
			}
			set_transient( 'trx_updater_theme_info', $data, 12 * 60 * 60 );       // Store to the cache for 12 hours
		}
		return apply_filters( 'trx_updater_filter_get_theme_info', array(
					'slug'        => $this->theme_slug,
					'title'       => $this->theme_name,
					'key'         => $this->theme_key,
					'version'     => $this->theme_version,
					'update'      => ! empty( $data[$this->theme_slug]['version'] ) ? $data[$this->theme_slug]['version'] : '',
					'update_from' => ! empty( $data[$this->theme_slug]['update_from'] ) ? $data[$this->theme_slug]['update_from'] : '',
					'icon'        => $this->get_item_icon( 'theme', $this->theme_slug, $this->theme_name ),
				) );
	}

	/**
	 * Return data by slug
	 *
	 * Return a data of the theme
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_data() {
		return ! empty( $this->theme ) ? $this->theme : array();
	}

	/**
	 * Count new themes
	 *
	 * Return a new plugins number
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function count_theme_updates() {
		return  ! empty( $this->theme['version'] )
				&& ! empty( $this->theme['update'] )
				&& version_compare( $this->theme['update'], $this->theme['version'], '>' )
				&& ( empty( $this->theme['update_from'] ) || version_compare( $this->theme['version'], $this->theme['update_from'], '>=' ) )
					? 1
					: 0;
	}

	/**
	 * Add new plugins count to the WordPress updates count
	 *
	 * Add new plugins count to the WordPress updates count.
	 *
	 * Fired by `wp_get_update_data` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_theme_to_update_counts($update_data, $titles) {
		if ( current_user_can( 'update_themes' ) ) {
			$update = $this->count_theme_updates();
			if ( $update > 0 ) {
				$update_data[ 'counts' ][ 'themes' ] += $update;
				$update_data[ 'counts' ][ 'total' ]  += $update;
				// Translators: %d: number of updates available to installed skins
				$titles['themes']                     = sprintf( _n( '%d Theme Update', '%d Theme Updates', $update_data[ 'counts' ][ 'themes' ], 'trx-updater' ), $update );
				$update_data['title']                 = esc_attr( implode( ', ', $titles ) );
			}
		}
		return $update_data;
	}

	/**
	 * Add new theme version to the WordPress update screen
	 *
	 * Add new theme version to the WordPress update screen
	 *
	 * Fired by `core_upgrade_preamble` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_theme_to_update_screen() {
		if ( current_user_can( 'update_themes' ) ) {
			$update = $this->count_theme_updates();
			if ( $update == 0 ) return;
			?>
			<h2>
				<?php
				// Translators: add theme name to the section title
				echo esc_html( sprintf( __( 'Active theme: "%s"', 'trx-updater' ), $this->theme_name ) );
				?>
			</h2>
			<p>
				<?php esc_html_e( 'Active theme have new version available. Check it and then click &#8220;Update Theme&#8221;.', 'trx-updater' ); ?>
			</p>
			<div class="upgrade trx_updater_upgrade trx_updater_upgrade_theme">
				<p><input id="upgrade-theme" class="button trx_updater_upgrade_button trx_updater_upgrade_theme_button" type="button" value="<?php esc_attr_e( 'Update Theme', 'trx-updater' ); ?>" /></p>
				<table class="widefat updates-table" id="update-theme-table">
					<tbody class="plugins themes">
						<?php $checkbox_id = 'checkbox_' . md5( $this->theme['slug'] ); ?>
						<tr>
							<td class="check-column">
								<input type="checkbox"
									name="checked[]"
									id="<?php echo esc_attr( $checkbox_id ); ?>"
									data-update-url="<?php echo esc_url( $this->get_iau_link( $this->theme_slug, 'update', 'theme' ) ); ?>"
									value="<?php echo esc_attr( $this->theme['slug'] ); ?>"
								/>
								<label for="<?php echo esc_attr( $checkbox_id ); ?>" class="screen-reader-text">
									<?php
									// Translators: %s: Theme name
									printf( esc_html__( 'Select %s', 'trx-updater' ), $this->theme['title'] );
									?>
								</label>
							</td>
							<td class="plugin-title"><p>
								<?php echo $this->theme['icon']; ?>
								<strong><?php echo esc_html( $this->theme['title'] ); ?></strong>
								<?php
								// Translators: 1: Theme version, 2: new version
								printf(
									esc_html__( 'You have version %1$s installed. Update to %2$s.', 'trx-updater' ),
									$this->theme['version'],
									$this->theme['update']
								);
								?>
							</p></td>
						</tr>
					</tbody>
				</table>
				<p><input id="upgrade-theme-2" class="button trx_updater_upgrade_button trx_updater_upgrade_theme_button" type="button" value="<?php esc_attr_e( 'Update Theme', 'trx-updater' ); ?>" /></p>
			</div>
			<?php
		}
	}

	/**
	 * Update theme
	 *
	 * Download theme from upgrade server and update it
	 *
	 * Fired by `update-custom_update-theme` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function update_theme() {
		$nonce = trx_updater_get_value_gp('_wpnonce');
		$theme = trx_updater_get_value_gp('theme');
		if ( ! empty( $nonce ) && ! empty( $theme ) && $theme == $this->theme_slug && wp_verify_nonce( $nonce, "update-theme_{$theme}" ) && current_user_can( 'update_themes' ) ) {
			// Prepare URL to upgrade server
			$theme_url = sprintf( $this->update_url 
									. '?action=install_theme'
									. '&src=%1$s'
									. '&key=%2$s'
									. '&theme_slug=%3$s'
									. '&theme_name=%4$s'
									. '&skin=%5$s'
									. '&domain=%6$s'
									. '&rnd=%7$s',
								urlencode( $this->get_theme_market_code() ),
								urlencode( $this->theme_key ),
								urlencode( $this->theme_slug ),
								urlencode( $this->theme_name ),
								urlencode( $this->get_active_skin() ),
								urlencode( trx_updater_remove_protocol( get_home_url(), true ) ),
								mt_rand()
							);
			// Add theme data to upgrade cache
			$this->inject_update_info( 'themes', array(
				$theme => array(
								'theme' => $theme,
								'new_version' => $this->theme['update'],
								'package' => $theme_url,
								'requires' => '4.7.0',
								'requires_php' => '5.6.0'
								)
			) );
			// Load upgrader
			if ( ! class_exists( 'Theme_Upgrader' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
			}
			$upgrader = new \Theme_Upgrader(
							new \Theme_Upgrader_Skin(
								array(
									'title'   => sprintf( __( 'Updating Theme "%s"', 'trx-updater' ), $this->theme_name ),
									'nonce'   => "update-theme_{$theme}",
									'url'     => add_query_arg( array( 'package' => $theme_url ), 'update.php?action=upgrade-theme' ),
									'theme'   => $theme,
									'type'    => 'upload',
									'package' => $theme_url
								)
							)
						);
			$this->before_theme_upgrade();
			$upgrader->upgrade( $theme );
			$this->after_theme_upgrade();
		}
	}

	/**
	 * Return active skin
	 *
	 * Return a slug of the active skin for some themes
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function get_active_skin() {
		$skin = '';
		if ( $this->theme_slug == 'topper-personal' ) {
			$skin = get_option( sprintf( 'theme_skin_%s', get_option( 'stylesheet' ) ), defined( 'TOPPER_DEFAULT_SKIN' ) ? TOPPER_DEFAULT_SKIN : '' );
		}
		return $skin;
	}

	/**
	 * Prepare current theme to upgrade
	 *
	 * Backup skins before upgrade theme
	 *
	 * @since 1.4.1
	 * @access public
	 */
	public function before_theme_upgrade() {
		if ( $this->theme_slug == 'topper-personal' ) {
			$skin_active = $this->get_active_skin();
			$skins_dir   = get_template_directory() . '/skins/';
			$skins_json  = $skins_dir . 'skins.json';
			if ( file_exists( $skins_json ) ) {
				$skins_info = json_decode( trx_updater_fgc( $skins_json ), true );
				$skins_list = glob( $skins_dir . '*', GLOB_ONLYDIR);
				if ( array( $skins_list ) ) {
					$this->theme_parts = array( 'skins' => array() );
					foreach( $skins_list as $sdir ) {
						$sname = basename( $sdir );
						if ( $sname == $skin_active ) continue;
						$rnd = str_replace('.', '', mt_rand());
						$result = wp_upload_bits( "backup-skin-{$sname}-{$rnd}.zip", 0, '' );
						if ( ! empty( $result['file'] ) ) {
							if ( trx_updater_pack_archive( $result['file'], $sdir ) ) {
								$this->theme_parts['skins'][$sname] = array(
									'backup' => $result['file'],
									'info'   => ! empty( $skins_info[$sname] ) ? $skins_info[$sname] : ''
								);
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Restore current theme parts after upgrade
	 *
	 * Restore skins after upgrade theme
	 *
	 * @since 1.4.1
	 * @access public
	 */
	public function after_theme_upgrade() {
		if ( $this->theme_slug == 'topper-personal' ) {
			if ( ! empty( $this->theme_parts['skins'] ) && is_array( $this->theme_parts['skins'] ) ) {
				$skins_dir  = get_template_directory() . '/skins/';
				$skins_json = $skins_dir . 'skins.json';
				if ( file_exists( $skins_json ) ) {
					$skins_info = json_decode( trx_updater_fgc( $skins_json ), true );
					foreach( $this->theme_parts['skins'] as $skin_name => $skin_data ) {
						if ( empty( $skins_info[$skin_name] ) && ! empty( $skin_data['info'] ) ) {
							$skins_info[$skin_name] = $skin_data['info'];
						}
						$sdir = $skins_dir . trx_updater_esc( $skin_name );
						if ( ! is_dir( $sdir ) && ! empty( $skin_data['backup'] ) && file_exists( $skin_data['backup'] ) ) {
							unzip_file( $skin_data['backup'], $sdir );
							unlink( $skin_data['backup'] );
						}
					}
					trx_updater_fpc( $skins_json, json_encode( $skins_info, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS ) );
				}
			}
		}
	}

}
