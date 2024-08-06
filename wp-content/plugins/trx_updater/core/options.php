<?php
namespace TrxUpdater\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ThemeREX Updater options.
 *
 * Handling plugin's options
 *
 * @since 1.0.0
 */
class Options {

	/**
	 * Instance.
	 *
	 * Holds the class instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Options
	 */
	public static $instance = null;

	/**
	 * Clone.
	 *
	 * Disable class cloning and throw an error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object. Therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'trx-updater' ), '1.0.0' );
	}

	/**
	 * Wakeup.
	 *
	 * Disable unserializing of the class.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'trx-updater' ), '1.0.0' );
	}

	/**
	 * Instance.
	 *
	 * Ensures only one instance of this class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Initializing options.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add admin menu entry.
	 *
	 * Add link to the options page to the Appearance menu.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_menu() {
		add_theme_page(
			esc_html__('ThemeREX Updater', 'trx-updater'),	//page_title
			esc_html__('ThemeREX Updater', 'trx-updater'),	//menu_title
			'manage_options',								//capability
			'trx_updater_options',							//menu_slug
			array( $this, 'options_page' )					//callback
		);
	}

	/**
	 * Register plugin's options.
	 *
	 * Register plugin's options in the WordPress settings
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_settings() {
		register_setting( 'trx_updater_options', 'trx_updater_theme_key' );
		register_setting( 'trx_updater_options', 'trx_updater_backups_enable' );
	}

	/**
	 * Add options page.
	 *
	 * Build page with plugin's options.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function options_page() {
		?>
		<div id="wpbody">
			<div id="wpbody-content">
				<form method="post" action="options.php">
					<div class="wrap">
						<h2><?php esc_html_e("ThemeREX Updater", "trx-updater"); ?></h2>
						<table class="form-table">
							<?php settings_fields( 'trx_updater_options' ); ?>
							<tr valign="top" class="trx_updater_option_theme_key_row">
								<th scope="row"><?php esc_html_e("Theme purchase key", "trx-updater"); ?></th>
								<td>
									<input type="text" name="trx_updater_theme_key" value="<?php echo get_option('trx_updater_theme_key'); ?>" size="50" id="trx_updater_theme_key" class="trx_updater_option_field" />
									<div class="trx_updater_option_description"><?php
										echo esc_html__("Specify the purchase key of current (active) theme to enable updates for this theme and theme-specific plugins via admin menu 'Dashboard - Updates'.", "trx-updater")
											. '<br>'
											. esc_html__("You don't need to enter the purchase code if current theme is previously activated.", "trx-updater");
									?></div>
								</td>
							</tr>
							<tr valign="top" class="trx_updater_option_backups_enable_row">
								<th scope="row"><?php esc_html_e("Create backups", "trx-updater"); ?></th>
								<td>
									<label><input type="checkbox" name="trx_updater_backups_enable" value="1"<?php if ( get_option('trx_updater_backups_enable') == '1' ) echo ' checked="checked"'; ?> id="trx_updater_backups_enable" class="trx_updater_option_field" /> <?php esc_html_e('Allow backups', 'trx-updater'); ?></label>
									<div class="trx_updater_option_description"><?php
										echo esc_html__("Create backup for the previous version theme or plugin before update it.", "trx-updater");
									?></div>
								</td>
							</tr>
							<?php
							$backups_list = $this->get_option( 'backups_list' );
							if ( is_array( $backups_list ) && count( $backups_list ) > 0 ) {
								?><tr valign="top" class="trx_updater_option_backups_list_row"<?php if ( get_option('trx_updater_backups_enable') == '0' ) echo ' style="display:none;"'; ?>>
									<th scope="row"><?php esc_html_e("List of backups", "trx-updater"); ?></th>
									<td>
										<div class="trx_updater_option_checklist trx_updater_option_backups_list">
											<?php
											foreach( array('plugin', 'theme') as $type ) {
												if ( 'plugin' != $type ) {
													?><br><?php
												}
												?>
												<label><strong><?php echo 'plugin' == $type ? esc_html__( 'Plugins', 'trx-updater' ) : esc_html__( 'Themes', 'trx-updater' ); ?></strong></label>
												<?php
												foreach( $backups_list as $slug => $data ) {
													if ( $data['type'] != $type ) continue;
													?><label><input type="checkbox" name="trx_updater_backups_item_<?php echo esc_attr( $slug ); ?>" value="<?php echo esc_attr( $slug ); ?>" class="trx_updater_option_checklist_item trx_updater_backups_item" /> <?php
														echo ''
															//. '<span class="trx_updater_backups_item_type">' . esc_html( ucfirst( $data['type'] ) ) . '</span>'
															. ' <span class="trx_updater_backups_item_title">' . esc_html( $data['title'] ) . '</span>'
															. ' <span class="trx_updater_backups_item_version">' . esc_html( sprintf( __( "v.%s", 'trx-updater'), $data['version'] ) ) . '</span>'
															. ' <span class="trx_updater_backups_item_date">' . esc_html( sprintf( __( '(the backup was created on %s)', 'trx-updater' ), date( get_option('date_format') . ' ' . get_option('time_format'), $data['date'] ) ) ) . '</span>';
													?></label><?php
												}
											}
											?>
										</div>
										<div class="trx_updater_option_buttons">
											<input type="button" name="trx_updater_backups_restore" value="<?php esc_attr_e( 'Restore selected backups', 'trx-updater' ); ?>">
											<input type="button" name="trx_updater_backups_delete" value="<?php esc_attr_e( 'Delete selected backups', 'trx-updater' ); ?>">
										</div>
										<div class="trx_updater_option_description"><?php
											echo esc_html__('Mark the desired items and select the action: "Restore" - to restore saved versions of plugins and/or theme, "Delete" - to delete files with saved versions.', "trx-updater");
										?></div>
									</td>
								</tr>
								<?php
							}
							?>
						</table>
						<p class="submit"><input type="submit" class="button-primary" value="<?php esc_html_e('Save Changes', "trx-updater") ?>" /></p>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Return specified option
	 *
	 * Return specified option
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_option( $name, $default = '' ) {
		return get_option( 'trx_updater_' . $name, $default );
	}

	/**
	 * Update specified option
	 *
	 * Update specified option
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function update_option( $name, $value ) {
		update_option( 'trx_updater_' . $name, $value );
	}

}
