<?php
namespace TrxUpdater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * ThemeREX Updater autoloader.
 *
 * ThemeREX Updater autoloader handler class is responsible for loading the different
 * classes needed to run the plugin.
 *
 * @since 1.0.0
 */
class Autoloader {

	/**
	 * Classes map.
	 *
	 * Maps plugin classes to file names.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array Classes used by plugin.
	 */
	private static $classes_map;

	/**
	 * Classes aliases.
	 *
	 * Maps plugin classes to aliases.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array Classes aliases.
	 */
	private static $classes_aliases;

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public static function run() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * Get classes map.
	 *
	 * Retrieve the classes map.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Classes map.
	 */
	public static function get_classes_map() {
		if ( ! self::$classes_map ) {
			self::init_classes_map();
		}
		return self::$classes_map;
	}

	private static function init_classes_map() {
		self::$classes_map = array(
			'UpdateManager' => 'core/update/manager.php',
		);
	}

	/**
	 * Normalize Class Name
	 *
	 * Used to convert control names to class name,
	 * a ucwords polyfill for php versions not supporting delimiter parameter
	 *
	 * @param $string
	 * @param string $delimiter
	 *
	 * @todo Remove once we bump minimum php version to 5.6
	 * @return mixed
	 */
	private static function normalize_class_name( $string, $delimiter = ' ' ) {
		return str_replace( ' ', $delimiter, ucwords( str_replace( $delimiter, ' ', $string ) ) );
	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {
		$classes_map = self::get_classes_map();

		if ( isset( $classes_map[ $relative_class_name ] ) ) {			// Class name is alias: 'UpdateManager' -> 'core/update/manager'
			$filename = TRX_UPDATER_DIR . '/' . $classes_map[ $relative_class_name ];
		} else {														// Class name contain relative path
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);
			$filename = TRX_UPDATER_DIR . $filename . '.php';
		}
		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );

		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}
	}
}
