<?php
namespace TrxUpdater\Core\Update;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Plugins extends Base {

	/**
	 * List of plugins to be updated
	 *
	 * List of plugins (registered in TGMPA by current theme) to be updated
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @var plugins_list
	 */
	private $plugins_list;

	/**
	 * Class constructor.
	 *
	 * Initializing plugins update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $manager ) {

		parent::__construct( $manager );

		$this->plugins_list = array();

		if ( trx_updater_get_value_gp( 'trx_updater' ) > 0 ) {
			add_action( 'init', array( $this, 'remove_3rd_plugins_hooks'), 2000 );
		}

		add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ), 2000 );

		add_filter( 'wp_get_update_data', array( $this, 'add_plugins_to_update_counts' ), 10, 2 );
		add_action( 'core_upgrade_preamble', array( $this, 'add_plugins_to_update_screen' ), 9 );

	}

	/**
	 * Remove upgrade-specific hooks from 3rd-party plugins
	 *
	 * Remove upgrade-specific hooks from 3rd-party plugins to avoid break the update process
	 *
	 * Fired by `init` action with priority 2000 (after all other handlers).
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function remove_3rd_plugins_hooks() {
		global $wp_filter;
		// Remove VC hook
		// VC add filter: add_filter( 'upgrader_pre_download', array( $this, 'preUpgradeFilter' ), 10, 4 );
		$tag = 'upgrader_pre_download';
		$r = false;
		if ( ! empty( $wp_filter[ $tag ]->callbacks[10] ) && is_array( $wp_filter[ $tag ]->callbacks[10] ) ) {
			foreach( $wp_filter[ $tag ]->callbacks[10] as $k=>$v ) {
				if ( strpos( $k, 'preUpgradeFilter' ) > 0 ) {
					unset( $wp_filter[ $tag ]->callbacks[10][$k] );
				}
			}
		}
	}

	/**
	 * Edit URL of each plugin to get it from upgrade server.
	 *
	 * Substitute URLs in the plugins list to get its from upgrade server.
	 *
	 * Fired by `tgmpa_register` action with priority 2000 (after all other handlers).
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function tgmpa_register() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		if ( ! empty( $instance->plugins ) ) {
			// Modify the parameter 'source' for each registered plugin -> get plugin from our update server
			$plugins_list = $this->get_plugins_list( $instance->plugins );
			foreach( $plugins_list as $k => $v ) {
				$slug = $k;
				if ( isset( $instance->plugins[ $slug ] ) && ! empty( $instance->plugins[ $slug ]['source'] ) ) {
					$this->plugins_list[$k] = $v;
					if ( strpos( $instance->plugins[ $slug ]['source'], trx_updater_remove_protocol( $this->update_url ) ) === false ) {
						if ( ! empty( $this->theme_key ) ) {
							$instance->plugins[ $slug ]['source'] = sprintf( $this->update_url . '?action=install_plugin&src=%1$s&key=%2$s&theme_slug=%3$s&theme_name=%4$s&plugin=%5$s&domain=%6$s&rnd=%7$s',
								urlencode( $this->get_theme_market_code() ),
								urlencode( $this->theme_key ),
								urlencode( $this->theme_slug ),
								urlencode( $this->theme_name ),
								urlencode( "{$slug}/{$slug}.zip" ),
								urlencode( trx_updater_remove_protocol( get_home_url(), true ) ),
								mt_rand()
							);
						}
					}
				}
			}
			// Delete cache after the update each plugin
			if ( isset( $_GET['tgmpa-update'] ) && 'update-plugin' === $_GET['tgmpa-update'] ) {
				delete_transient( 'trx_updater_plugins_list' );
			}
		}
	}

	/**
	 * Detect plugin state
	 *
	 * Return state of the specified plugin
	 *
	 * @param string $slug	Plugin slug
	 * @return string
	 * 
	 * @since 1.0.0
	 * @access private
	 */
	private function check_plugin_state( $slug ) {
		$state = 'not installed';
		if ( is_dir( ABSPATH . 'wp-content/plugins/' . $slug . '/' ) ) {
			$state = 'installed';
			$plugins = get_option( 'active_plugins', array() );
			if ( is_multisite() ) {
				$mu_plugins = get_site_option( 'active_sitewide_plugins');
				if (is_array($mu_plugins)) {
					$plugins = array_merge($plugins, $mu_plugins);
				}
			}
			if (is_array($plugins)) {
				foreach($plugins as $p) {
					if (strpos($p, $slug . '/') !== false) {
						$state = 'active';
						break;
					}
				}
			}
		}
		return $state;
	}


	/**
	 * List of installed plugins and their versions (current and new).
	 *
	 * Return list of installed plugins and their versions (current and new). Clear cache every 12 hours.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_plugins_list( $required_plugins ) {
		$list = get_transient( 'trx_updater_plugins_list' );
		if ( ! is_array( $list ) || ! empty( $_GET['force-check'] ) ) {
			$list = $this->get_plugins_info( $required_plugins );
			if ( is_array( $list ) ) {
				set_transient( 'trx_updater_plugins_list', $list, 4 * 60 * 60 );       // Store to the cache for 4 hours
			}
		}
		return $list;
	}

	/**
	 * Retrieve info about specified plugins
	 *
	 * Retrieve info about specified plugins from the updates server
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function get_plugins_info( $required_plugins ) {
		$info = array();
		$plugins = get_plugins();
		if ( is_array( $required_plugins ) ) {
			$data = get_transient( 'trx_updater_plugins_info' );
			if ( ! is_array( $data ) || ! empty( $_GET['force-check'] ) ) {
				$list = '';
				$data = array();
				foreach ( $required_plugins as $k => $v ) {
					$list .= ( ! empty( $list ) ? ',' : '' ) . $k;
					$data[ $k ] = array(
										'version' => '0.0.1',
										'update_from' => '0.0.2',
										);
				}
				$response = trx_updater_fgc( $this->update_url . '?action=info_plugins&plugins=' . urlencode( $list ) );
				if ( !empty($response) && is_serialized($response) ) {
					$response = unserialize($response);
					if ( !empty($response['data']) && substr($response['data'], 0, 1) == '{' ) {
						$data = json_decode($response['data'], true);
					}
				}
				set_transient( 'trx_updater_plugins_info', $data, 12 * 60 * 60 );       // Store to the cache for 12 hours
			}
			if ( is_array($data) ) {
				foreach ( $required_plugins as $k => $v ) {
					$slug    = $k;
					$path    = "{$k}/{$k}.php";
					$title   = '';
					$version = '0.0.1';
					foreach ( $plugins as $p => $pv ) {
						$parts = explode( '/', $p );
						if ( $parts[0] == $k ) {
							$path    = $p;
							$title   = $pv['Title'];
							$version = $pv['Version'];
						}
					}
					// Check if this plugin can be updated:
					// if his version greater or equal to version in the field 'update_from' in the plugin's data received from the upgrade server
					// or if the field 'update_from' is absent ( any version can be updated )
					if ( ! empty( $title ) && ! empty( $data[$slug]['version'] ) && ( empty( $data[$slug]['update_from'] ) || version_compare( $version, $data[$slug]['update_from'], '>=' ) ) ) {
						$info[$k] = array(
							'title'   => $title,
							'slug'    => $slug,
							'path'    => $path,
							'icon'    => $this->get_item_icon( 'plugin', $slug, $title ),
							'version' => $version,
							'update'  => $data[$slug]['version']
						);
					}
				}
			}
		}
		return apply_filters( 'trx_updater_filter_get_plugins_info', $info );
	}

	/**
	 * Return data by slug
	 *
	 * Return a data of the specified plugin by its slug
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_data( $slug = null ) {
		return $slug === null 
					? $this->plugins_list
					: ( isset( $this->plugins_list[ $slug ] ) 
						? $this->plugins_list[ $slug ] 
						: array()
						);
	}

	/**
	 * Count new plugins
	 *
	 * Return a new plugins number
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function count_plugin_updates() {
		$update = 0;
		foreach ( $this->plugins_list as $plugin => $data ) {
			if ( ! empty( $data['update'] )
					&& ! empty( $data['version'] )
					&& version_compare( $data['update'], $data['version'], '>' )
					&& ( empty( $data['update_from'] ) || version_compare( $data['version'], $data['update_from'], '>=' ) )
			) {
				$update++;
			}
		}
		return $update;
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
	public function add_plugins_to_update_counts($update_data, $titles) {
		if ( current_user_can( 'update_plugins' ) ) {
			$update = $this->count_plugin_updates();
			if ( $update > 0 ) {
				$update_data[ 'counts' ][ 'plugins' ] += $update;
				$update_data[ 'counts' ][ 'total' ]   += $update;
				// Translators: %d: number of updates available to installed skins
				$titles['plugins']                     = sprintf( _n( '%d Plugin Update', '%d Plugin Updates', $update_data[ 'counts' ][ 'plugins' ], 'trx-updater' ), $update );
				$update_data['title']                  = esc_attr( implode( ', ', $titles ) );
			}
		}
		return $update_data;
	}

	/**
	 * Add new plugins versions to the WordPress update screen
	 *
	 * Add new plugins versions to the WordPress update screen
	 *
	 * Fired by `core_upgrade_preamble` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_plugins_to_update_screen() {
		if ( current_user_can( 'update_plugins' ) ) {
			$update = $this->count_plugin_updates();
			if ( $update == 0 ) return;
			?>
			<h2>
				<?php esc_html_e( 'Active theme components: Plugins', 'trx-updater' ); ?>
			</h2>
			<p>
				<?php esc_html_e( 'The following plugins have new versions available. Check the ones you want to update and then click &#8220;Update Plugins&#8221;.', 'trx-updater' ); ?>
			</p>
			<div class="upgrade trx_updater_upgrade trx_updater_upgrade_plugins">
				<p><input id="upgrade-theme-plugins" class="button trx_updater_upgrade_button trx_updater_upgrade_plugins_button" type="button" value="<?php esc_attr_e( 'Update Plugins', 'trx-updater' ); ?>" /></p>
				<table class="widefat updates-table" id="update-plugins-table">
					<thead>
					<tr>
						<td class="manage-column check-column"><input type="checkbox" id="theme-plugins-select-all" /></td>
						<td class="manage-column"><label for="theme-plugins-select-all"><?php esc_html_e( 'Select All', 'trx-updater' ); ?></label></td>
					</tr>
					</thead>
					<tbody class="plugins">
						<?php
						foreach ( $this->plugins_list as $slug => $data ) {
							$plugin = ! empty( $data['path'] ) ? $data['path'] : "{$slug}/{$slug}.php";
							if ( empty( $data['update'] ) || empty( $data['version'] ) || ! version_compare( $data['update'], $data['version'], '>' ) ) {
								continue;
							}
							$checkbox_id = 'checkbox_' . md5( $plugin );
							?>
							<tr>
								<td class="check-column">
									<input type="checkbox"
										name="checked[]"
										id="<?php echo esc_attr( $checkbox_id ); ?>"
										data-update-url="<?php echo esc_url( $this->get_iau_link( $slug, 'update', 'plugin' ) ); ?>"
										<?php if ( $this->check_plugin_state( $slug ) == 'active' ) { ?>
										data-activate-url="<?php echo esc_url( $this->get_iau_link( $slug, 'activate', 'plugin' ) ); ?>"
										<?php } ?>
										value="<?php echo esc_attr( $plugin ); ?>"
									/>
									<label for="<?php echo esc_attr( $checkbox_id ); ?>" class="screen-reader-text">
										<?php
										// Translators: %s: Skin name
										printf( esc_html__( 'Select %s', 'trx-updater' ), $data['title'] );
										?>
									</label>
								</td>
								<td class="plugin-title"><p>
									<?php echo $data['icon']; ?>
									<strong><?php echo esc_html( $data['title'] ); ?></strong>
									<?php
									// Translators: 1: skin version, 2: new version
									printf(
										esc_html__( 'You have version %1$s installed. Update to %2$s.', 'trx-updater' ),
										$data['version'],
										$data['update']
									);
									?>
								</p></td>
							</tr>
							<?php
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td class="manage-column check-column"><input type="checkbox" id="theme-plugins-select-all-2" /></td>
							<td class="manage-column"><label for="theme-plugins-select-all-2"><?php esc_html_e( 'Select All', 'trx-updater' ); ?></label></td>
						</tr>
					</tfoot>
				</table>
				<p><input id="upgrade-theme-plugins-2" class="button trx_updater_upgrade_button trx_updater_upgrade_plugins_button" type="button" value="<?php esc_attr_e( 'Update Plugins', 'trx-updater' ); ?>" /></p>
			</div>
			<?php
		}
	}

}
