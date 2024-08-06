<?php
/**
 * Plugin Name: ThemeREX Updater
 * Description: Allow updates theme-specific plugins and theme core
 * Plugin URI: https://themerex.net/?utm_source=wp-plugins&utm_campaign=plugin-uri&utm_medium=wp-dash
 * Author: ThemeREX
 * Version: 1.4.1
 * Author URI: https://themerex.net/?utm_source=trx_updater&utm_campaign=author-uri&utm_medium=wp-dash
 *
 * Text Domain: trx-updater
 *
 * @package ThemeREX Updater
 * @category Core
 *
 * ThemeREX Updater is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * ThemeREX Updater is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'TRX_UPDATER_VERSION', '1.4.1' );

define( 'TRX_UPDATER_FILE', __FILE__ );
define( 'TRX_UPDATER_BASE', plugin_basename( TRX_UPDATER_FILE ) );
define( 'TRX_UPDATER_DIR', plugin_dir_path( TRX_UPDATER_FILE ) );
define( 'TRX_UPDATER_URL', plugins_url( '/', TRX_UPDATER_FILE ) );

add_action( 'plugins_loaded', 'trx_updater_load_plugin_textdomain' );

require TRX_UPDATER_DIR . 'includes/file.php';
require TRX_UPDATER_DIR . 'includes/html.php';

require TRX_UPDATER_DIR . 'core/plugin.php';

/**
 * Load ThemeREX Updater textdomain.
 *
 * Load gettext translate for ThemeREX Updater text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function trx_updater_load_plugin_textdomain() {
	static $loaded = false;
	if ( $loaded ) return true;
	$domain = 'trx-updater';
	if ( is_textdomain_loaded( $domain ) && !is_a( $GLOBALS['l10n'][ $domain ], 'NOOP_Translations' ) ) return true;
	$loaded = true;
	load_plugin_textdomain( $domain, false, TRX_UPDATER_DIR . '/languages' );
}
