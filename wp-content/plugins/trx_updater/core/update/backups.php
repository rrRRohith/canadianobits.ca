<?php
namespace TrxUpdater\Core\Update;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Backups extends Base {

	/**
	 * Class constructor.
	 *
	 * Initializing backups manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $manager ) {

		parent::__construct( $manager );

		// Create backup
		add_filter( 'upgrader_package_options', array( $this, 'backup_package_callback' ) );

		// Delete or Restore backup via Update Screen (one by one)
		add_action( 'core_upgrade_preamble', array( $this, 'add_backups_to_update_screen' ), 20 );
		add_action( 'update-custom_delete-backup', array( $this, 'delete_backup_callback' ) );
		add_action( 'update-custom_restore-backup', array( $this, 'restore_backup_callback' ) );

		// Delete or Restore backups from options (comma separated lists allowed)
		add_action('wp_ajax_trx_updater_delete_backups', array( $this, 'delete_backups_callback' ) );
		add_action('wp_ajax_trx_updater_restore_backups', array( $this, 'restore_backups_callback' ) );
	}


	/**
	 * Return URL for the restore or delete backup action
	 *
	 * Return nonce URL for the restore or delete backup action
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function get_backup_link( $slug, $action ) {
		return wp_nonce_url(
					add_query_arg(
						array(
							'action' => $action . '-backup',
							'backup' => urlencode( $slug ),
						),
						network_admin_url( 'update.php' )
					),
					$action . '-backup_' . trim( $slug )
				);
	}


	/**
	 * Add list of backups to the WordPress update screen
	 *
	 * Add list of available backups to the WordPress update screen
	 *
	 * Fired by `core_upgrade_preamble` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_backups_to_update_screen() {
		if ( (int) $this->options->get_option('backups_enable') == 1 && current_user_can( 'update_themes' ) && current_user_can( 'update_plugins' ) ) {
	
			$backups_list = $this->options->get_option( 'backups_list' );
	
			if ( is_array( $backups_list ) && count( $backups_list ) > 0 ) {
				$installed = get_plugins();
				$plugins   = array();
				foreach ( $installed as $p => $pv ) {
					$parts = explode( '/', $p );
					$plugins[ $parts[0] ] = $pv;
				}
				?>
				<h2>
					<?php
					esc_html_e( 'List of backups', 'trx-updater' );
					?>
				</h2>
				<p>
					<?php esc_html_e( 'You have a previously created backups available. Check it and then click &#8220;Restore selected backups&#8221; to return to the previous version of the plugin or the theme. If you click &#8220;Delete selected backups&#8221; - checked backups will be deleted.', 'trx-updater' ); ?>
				</p>
				<div class="upgrade trx_updater_backups">
					<p>
						<input id="upgrade-restore-backups" class="button trx_updater_backups_button trx_updater_restore_backups_button" type="button" value="<?php esc_attr_e( 'Restore selected backups', 'trx-updater' ); ?>" />
						<input id="upgrade-delete-backups" class="button trx_updater_backups_button trx_updater_delete_backups_button" type="button" value="<?php esc_attr_e( 'Delete selected backups', 'trx-updater' ); ?>" />
					</p>
					<table class="widefat updates-table" id="update-backups-table">
						<thead>
						<tr>
							<td class="manage-column check-column"><input type="checkbox" id="backups-select-all" /></td>
							<td class="manage-column"><label for="backups-select-all"><?php esc_html_e( 'Select All', 'trx-updater' ); ?></label></td>
						</tr>
						</thead>
						<tbody class="plugins backups">
							<?php
							foreach( array('plugin', 'theme') as $type ) {
								?>
								<tr>
									<td class="plugin-title" colspan="2">
										<strong><?php echo 'plugin' == $type ? esc_html__( 'Plugins', 'trx-updater' ) : esc_html__( 'Themes', 'trx-updater' ); ?></strong>
									</td>
								</tr>
								<?php
								foreach( $backups_list as $slug => $data ) {
									if ( $data['type'] != $type ) continue;
									$checkbox_id = 'checkbox_' . md5( $slug );
									?>
									<tr>
										<td class="check-column">
											<input type="checkbox"
												name="checked[]"
												id="<?php echo esc_attr( $checkbox_id ); ?>"
												data-restore-url="<?php echo esc_url( $this->get_backup_link( $slug, 'restore' ) ); ?>"
												data-delete-url="<?php echo esc_url( $this->get_backup_link( $slug, 'delete' ) ); ?>"
												value="<?php echo esc_attr( $slug ); ?>"
											/>
											<label for="<?php echo esc_attr( $checkbox_id ); ?>" class="screen-reader-text">
												<?php
												// Translators: %s: Theme name
												printf( esc_html__( 'Select %s', 'trx-updater' ), $data['title'] );
												?>
											</label>
										</td>
										<td class="plugin-title"><p>
											<?php echo $this->get_item_icon( $data['type'], $slug, $data['title'] ); ?>
											<strong><?php echo esc_html( $data['title'] ); ?></strong>
											<?php
											if ( $data['type'] == 'theme' ) {
												$theme = wp_get_theme( $slug );
											}
											// Translators: 1: Theme version, 2: backup version
											printf(
												esc_html__( 'You have version %1$s installed. Revert to %2$s from the backup archive.', 'trx-updater' ),
												$data['type'] == 'plugin'
													? $plugins[ $slug ]['Version']
													: ( $theme->exists() ? $theme->get( 'Version' ) : '???' ),
												$data['version']
											);
											?>
										</p></td>
									</tr>
									<?php
								}
							}
							?>
						</tbody>
						<tfoot>
						<tr>
							<td class="manage-column check-column"><input type="checkbox" id="backups-select-all-2" /></td>
							<td class="manage-column"><label for="backups-select-all-2"><?php esc_html_e( 'Select All', 'trx-updater' ); ?></label></td>
						</tr>
						</tfoot>
					</table>
					<p>
						<input id="upgrade-restore-backups-2" class="button trx_updater_backups_button trx_updater_restore_backups_button" type="button" value="<?php esc_attr_e( 'Restore selected backups', 'trx-updater' ); ?>" />
						<input id="upgrade-delete-backups-2" class="button trx_updater_backups_button trx_updater_delete_backups_button" type="button" value="<?php esc_attr_e( 'Delete selected backups', 'trx-updater' ); ?>" />
					</p>
				</div>
				<?php
			}
		}
	}





	/**
	 * Callback to backup plugin or theme before WordPress update it
	 *
	 * Create backup of the plugin before WordPress download it
	 *
	 * Fired by `upgrader_package_options` filter
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function backup_package_callback( $options ) {
		if ( (int) $this->options->get_option( 'backups_enable' ) == 1 ) {
			$type = ! empty( $options['hook_extra']['plugin'] )
						? 'plugin' 
						: ( ! empty( $options['hook_extra']['theme'] ) ? 'theme' : 'unsupported' );
			if ( $type == 'plugin' && current_user_can( 'update_plugins' ) ) {
				$plugins = get_plugins();
				$plugin = $options['hook_extra']['plugin'];
				if ( ! empty( $plugins[ $plugin ]['Name'] ) && ! empty( $plugins[ $plugin ]['Version'] ) ) {
					$slug = dirname( $plugin );
					$this->create_backup(
								$slug,
								trailingslashit( $options['destination'] )  . $slug,
								array(
									'type'    => 'plugin',
									'title'   => $plugins[ $plugin ]['Name'],
									'version' => $plugins[ $plugin ]['Version'],
								)
					);
				}
			} else if ( $type == 'theme' && current_user_can( 'update_themes' ) ) {
				$slug = $options['hook_extra']['theme'];
				$theme = wp_get_theme( $slug );
				if ( $theme->exists() ) {
					$this->create_backup(
								$slug,
								trailingslashit( $options['destination'] )  . $slug,
								array(
									'type'    => 'theme',
									'title'   => $theme->get( 'Name' ),
									'version' => $theme->get( 'Version' ),
								)
					);
				}
			}
		}
		return $options;
	}

	/**
	 * Create backup for specified package (plugin or theme)
	 *
	 * Create archive with backup of the specified package in the folder 'uploads'
	 *
	 * @since 1.0.0
	 * @access private
	 */
	public function create_backup( $slug, $dir, $data=array() ) {
		if ( (int) $this->options->get_option( 'backups_enable' ) == 1 ) {
			$rnd = str_replace('.', '', mt_rand());
			$result = wp_upload_bits( "backup-{$data['type']}-{$slug}-{$rnd}.zip", 0, '' );
			if ( ! empty( $result['file'] ) ) {
				$backups_list = $this->options->get_option( 'backups_list' );
				if ( ! empty( $backups_list[ $slug ] ) ) {
					if ( !empty( $backups_list[ $slug ]['backup'] ) && file_exists( $backups_list[ $slug ]['backup'] ) ) {
						unlink( $backups_list[ $slug ]['backup'] );
					}
				} else if ( ! is_array( $backups_list ) ) {
					$backups_list = array();
				}
				if ( trx_updater_pack_archive( $result['file'], $dir ) ) {
					$backups_list[ $slug ] = array(
						'backup'  => $result['file'],
						'dir'     => $dir,
						'date'	  => time(),
						'title'   => $data['title'],
						'slug'    => $slug,
						'type'    => $data['type'],
						'version' => $data['version'],
					);
					$this->options->update_option( 'backups_list', $backups_list );
				}
			}
		}
	}





	/**
	 * Delete single backup callback (from Update screen)
	 *
	 * Delete single theme or plugin from backup via WordPress update screen
	 *
	 * Fired by `update-custom_delete-backup` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function delete_backup_callback() {
		$slug = trx_updater_get_value_gp('backup');
		if ( ! wp_verify_nonce( trx_updater_get_value_gp('_wpnonce'), "delete-backup_{$slug}" ) || ! current_user_can( 'update_themes' ) || ! current_user_can( 'update_plugins' ) ) {
			die();
		}
		$response = array(
			'error' => '',
			'success' => '',
		);
		$this->delete_backup( $slug, $response );
		echo json_encode($response);
		die();
	}

	/**
	 * Delete comma separated list of backups callback (from options page)
	 *
	 * Delete specified backups (archives and list entries)
	 *
	 * Fired by `wp_ajax_trx_updater_delete_backups` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function delete_backups_callback() {
		if ( !wp_verify_nonce( trx_updater_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || ! current_user_can( 'update_themes' ) || ! current_user_can( 'update_plugins' ) ) {
			die();
		}
		$response = array(
			'error' => '',
			'success' => '',
		);
		if ( empty( $_REQUEST['backups'] ) ) {
			$response['error'] = esc_html__( 'List of backups to delete is not specified!', 'trx_addons' );
		} else {
			$backups = array_map( 'trim', explode( ',', $_REQUEST['backups'] ) );
			foreach( $backups as $slug ) {
				$this->delete_backup( $slug, $response );
			}
		}
		echo json_encode($response);
		die();
	}

	/**
	 * Delete one backup
	 *
	 * Delete specified backup (archive and list entry)
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function delete_backup( $slug, &$response ) {
		$result = false;
		$backups_list = $this->options->get_option( 'backups_list' );
		if ( ! isset( $backups_list[ $slug ] ) ) {
			$response['error'] .= ( ! empty( $response['error'] ) ? "\n" : '' ) . sprintf( __( '"%s" is not found in the backups list!', 'trx-updater' ), $slug );
		} else {
			if ( ! empty( $backups_list[ $slug ]['backup'] ) ) {
				if ( file_exists( $backups_list[ $slug ]['backup'] ) ) {
					unlink( $backups_list[ $slug ]['backup'] );
					$result = true;
					$response['success'] .= ( ! empty( $response['success'] ) ? "\n" : '' )
											. sprintf(
													__( '"%s" is deleted!', 'trx-updater' ),
													! empty( $backups_list[ $slug ]['title'] )
														? $backups_list[ $slug ]['title']
														: $slug
												);
				} else {
					$response['error'] .= ( ! empty( $response['error'] ) ? "\n" : '' )
											. sprintf(
													__( 'Archive of "%s" is not found! List entry "%s" is deleted', 'trx-updater' ),
													$backups_list[ $slug ]['backup'],
													! empty( $backups_list[ $slug ]['title'] )
														? $backups_list[ $slug ]['title']
														: $slug
												);
				}
			}
			unset( $backups_list[ $slug ] );
			$this->options->update_option( 'backups_list', $backups_list );
		}
		return $result;
	}





	/**
	 * Restore single backup callback (from Update screen)
	 *
	 * Restore single theme or plugin from backup via WordPress update screen
	 *
	 * Fired by `update-custom_restore-backup` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function restore_backup_callback() {
		$slug = trx_updater_get_value_gp('backup');
		if ( ! wp_verify_nonce( trx_updater_get_value_gp('_wpnonce'), "restore-backup_{$slug}" ) || ! current_user_can( 'update_themes' ) || ! current_user_can( 'update_plugins' ) ) {
			die();
		}
		$response = array(
			'error' => '',
			'success' => '',
		);
		$this->restore_backup( $slug, $response );
		echo json_encode($response);
		die();
	}

	/**
	 * Restore backups callback (from options page)
	 *
	 * Restore comma separated list of backups and delete archives and list entries if success
	 *
	 * Fired by `wp_ajax_trx_updater_restore_backups` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function restore_backups_callback() {
		if ( !wp_verify_nonce( trx_updater_get_value_gp('nonce'), admin_url('admin-ajax.php') ) || ! current_user_can( 'update_themes' ) || ! current_user_can( 'update_plugins' ) ) {
			die();
		}
		$response = array(
			'error' => '',
			'success' => '',
		);
		if ( empty( $_REQUEST['backups'] ) ) {
			$response['error'] = esc_html__( 'List of backups to restore is not specified!', 'trx_addons' );
		} else {
			$backups = array_map( 'trim', explode( ',', $_REQUEST['backups'] ) );
			foreach( $backups as $slug ) {
				$this->restore_backup( $slug, $response );
			}
		}
		echo json_encode($response);
		die();
	}


	/**
	 * Restore specified backup by slug
	 *
	 * Restore specified backup from archives and delete archives and list entries if success
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function restore_backup( $slug, &$response ) {
		$result = false;
		$backups_list = $this->options->get_option( 'backups_list' );
		if ( ! isset( $backups_list[ $slug ] ) ) {
			$response['error'] .= ( ! empty( $response['error'] ) ? "\n" : '' ) . sprintf( __( '"%s" is not found in the backups list!', 'trx-updater' ), $slug );
		} else {
			if ( ! empty( $backups_list[ $slug ]['backup'] ) ) {
				if ( file_exists( $backups_list[ $slug ]['backup'] ) ) {
					if ( is_dir( $backups_list[ $slug ]['dir'] ) ) {
						// Clear folder
						trx_updater_del_folder( $backups_list[ $slug ]['dir'], false );
						// Unzip files
						unzip_file( $backups_list[ $slug ]['backup'], $backups_list[ $slug ]['dir'] );
						// Delete archive
						unlink( $backups_list[ $slug ]['backup'] );
						$result = true;
						$response['success'] .= ( ! empty( $response['success'] ) ? "\n" : '' )
												. sprintf(
														__( '"%s" is restored!', 'trx-updater' ),
														! empty( $backups_list[ $slug ]['title'] )
															? $backups_list[ $slug ]['title']
															: $slug
													);
					} else {
						$response['error'] .= ( ! empty( $response['error'] ) ? "\n" : '' )
												. sprintf(
														__( 'Destination folder with "%s" is not found! Perhaps the plugin has been removed.', 'trx-updater' ),
														! empty( $backups_list[ $slug ]['title'] )
															? $backups_list[ $slug ]['title']
															: $slug
													);

					}
				} else {
					$response['error'] .= ( ! empty( $response['error'] ) ? "\n" : '' )
											. sprintf(
													__( 'Archive of "%s" is not found! List entry is deleted', 'trx-updater' ),
													! empty( $backups_list[ $slug ]['title'] )
														? $backups_list[ $slug ]['title']
														: $slug
												);
				}
			}
			unset( $backups_list[ $slug ] );
			$this->options->update_option( 'backups_list', $backups_list );
		}
		return $result;
	}

}
