<?php
namespace TrxUpdater;

use TrxUpdater\Core\Update\Manager as UpdateManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ThemeREX Updater plugin.
 *
 * The main plugin handler class is responsible for initializing ThemeREX Updater.
 * The class registers and all the components required to run the plugin.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Update manager.
	 *
	 * Holds the object of the update manager.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @var update_manager
	 */
	private $update_manager;

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
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
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

			/**
			 * ThemeREX Updater loaded.
			 *
			 * Fires when plugin was fully loaded and instantiated.
			 *
			 * @since 1.0.0
			 */
			do_action( 'trx_updater/loaded' );
		}

		return self::$instance;
	}

	/**
	 * Init.
	 *
	 * Initialize Plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		if ( function_exists( 'tgmpa' ) ) {
			$this->update_manager = new UpdateManager();

			/**
			 * Plugin init.
			 *
			 * Fires on plugin init, after ThemeREX Updater has finished loading but
			 * before any headers are sent.
			 *
			 * @since 1.0.0
			 */
			do_action( 'trx_updater/init' );
		}
	}

	/**
	 * Register autoloader.
	 *
	 * ThemeREX Updater autoloader loads all the classes needed to run the plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function register_autoloader() {
		require TRX_UPDATER_DIR . '/core/autoloader.php';
		Autoloader::run();
	}

	/**
	 * Plugin constructor.
	 *
	 * Initializing ThemeREX Updater plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() {
		$this->register_autoloader();
		
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	final public static function get_title() {
		return __( 'ThemeREX Updater', 'trx-updater' );
	}
}

Plugin::instance();
