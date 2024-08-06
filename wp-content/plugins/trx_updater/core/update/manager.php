<?php
namespace TrxUpdater\Core\Update;

use TrxUpdater\Core\Update\Plugins as UpdatePlugins;
use TrxUpdater\Core\Update\Themes as UpdateThemes;
use TrxUpdater\Core\Update\Backups as UpdateBackups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Manager extends Base {

	/**
	 * Update manager for plugins.
	 *
	 * Holds the object of the plugins update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var update_plugins
	 */
	public $update_plugins;

	/**
	 * Update manager for themes.
	 *
	 * Holds the object of the themes update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var update_themes
	 */
	public $update_themes;

	/**
	 * Update manager for backups.
	 *
	 * Holds the object of the backups manager.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var backups
	 */
	public $backups;

	/**
	 * Class constructor.
	 *
	 * Initializing update manager.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		parent::__construct();

		if ( empty( $this->theme_key ) ) return;

		add_action( 'init', array( $this, 'init'), 1 );

		add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ), 1000 );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_footer', array( $this, 'localize_admin_scripts' ) );
	}

	/**
	 * Init managers
	 *
	 * Create instance of plugins and themes update managers
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		$this->update_plugins = new UpdatePlugins( $this );
		$this->update_themes  = new UpdateThemes( $this );
		$this->backups        = new UpdateBackups( $this );
	}

	/**
	 * Modify the TGMPA plugins list
	 *
	 * Add this plugin to the TGMPA and add fake plugin to the list to make 'Install plugins' menu item always
	 *
	 * Fired by `tgmpa_register` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function tgmpa_register() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		// Add self to the plugins list
		if ( empty( $instance->plugins[ 'trx_updater' ] ) ) {
			call_user_func( array( $instance, 'register' ), array(
				'name'     => __( 'ThemeREX Updater', 'trx-updater' ),
				'slug'     => 'trx_updater',
				'source'   => 'trx_updater/trx_updater.zip',
				'version'  => TRX_UPDATER_VERSION,
				'required' => false,
			) );
		}
		// Add fake plugin to the TGMPA to allow it admin menu any way
		if ( trx_updater_get_value_gp( 'trx_updater' ) > 0 ) {
			if ( ! method_exists($instance, 'is_tgmpa_complete') || $instance->is_tgmpa_complete() ) {
				call_user_func( array( $instance, 'register' ), array(
						'name'     => 'Fake plugin',
						'slug'     => 'fake-plugin',
						'source'   => 'fake-plugin/fake-plugin.zip',
						'version'  => '1.0.0',
						'required' => false,
					) );
			}
		}
	}

	/**
	 * Enqueue admin styles.
	 *
	 * Enqueue all admin styles.
	 *
	 * Fired by `admin_enqueue_scripts` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style(  'trx_updater_admin',  trx_updater_get_file_url('assets/css/trx_updater-admin.css'), array(), null );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * Enqueue all admin scripts.
	 *
	 * Fired by `admin_enqueue_scripts` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script('trx_updater_admin', trx_updater_get_file_url( 'assets/js/trx_updater-admin.js' ), array( 'jquery' ), null, true);
	}

	/**
	 * Localize admin scripts.
	 *
	 * Add variables to use its in all admin scripts.
	 *
	 * Fired by `admin_footer` and `customize_controls_print_footer_scripts` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function localize_admin_scripts() {
		// Add variables into JS
		wp_localize_script( 'trx_updater_admin', 'TRX_UPDATER_STORAGE', apply_filters( 'trx_updater_filter_localize_admin_script', array(
			// AJAX parameters
			'ajax_url'			  => esc_url( admin_url('admin-ajax.php') ),
			'ajax_nonce'		  => esc_attr( wp_create_nonce( admin_url('admin-ajax.php') ) ),
			// Admin base url
			'admin_url'			  => esc_url( admin_url() ),
			// Site base url
			'site_url'			  => esc_url( get_home_url() ),
			// Messages
			'msg_ajax_error'	  => addslashes( esc_html__('Invalid server answer!', 'trx-updater') ),
			'msg_irreversable'    => addslashes( esc_html__('Attention! This operation is irreversible!', 'trx-updater') ),
			'msg_restore_success' => addslashes( esc_html__('Selected items are successfully restored!', 'trx-updater') ),
			'msg_restore_error'   => addslashes( esc_html__('Some items are not restored!', 'trx-updater') ),
			'msg_delete_success'  => addslashes( esc_html__('Selected items are successfully deleted!', 'trx-updater') ),
			'msg_delete_error'    => addslashes( esc_html__('Some items are not deleted!', 'trx-updater') ),
			'msg_update_success'  => addslashes( esc_html__('Selected items are successfully updated!', 'trx-updater') ),
			'msg_update_error'    => addslashes( esc_html__('Some items are not updated!', 'trx-updater') ),
			'msg_update_get_key'  => addslashes( esc_html__('Enter the purchase key from your theme to update theme-specific components!', 'trx-updater') ),
			'msg_options_select'  => addslashes( esc_html__('No items are checked!', 'trx-updater') ),
			'msg_options_delete'  => addslashes( esc_html__('Are you sure you want to delete the checked backups?', 'trx-updater') ),
			'msg_options_restore' => addslashes( esc_html__('Restore previously saved versions of plugins (themes) from the checked backups?', 'trx-updater') ),
			'msg_page_reload'     => addslashes( esc_html__('Attention! The page will reload in 5 seconds to update the list of available backups!', 'trx-updater') ),
			) )
		);
	}

}
