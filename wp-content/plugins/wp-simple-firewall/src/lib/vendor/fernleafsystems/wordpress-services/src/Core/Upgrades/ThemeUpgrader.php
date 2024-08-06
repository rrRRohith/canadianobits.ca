<?php

namespace FernleafSystems\Wordpress\Services\Core\Upgrades;

require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
require_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );

class ThemeUpgrader extends \Theme_Upgrader {

	protected $bModeOverwrite = true;

	/**
	 * @param string $package
	 * @param array  $args
	 * @return array|bool|\WP_Error
	 */
	public function install( $package, $args = [] ) {

		$defaults = [
			'clear_update_cache' => true,
		];
		$parsed_args = wp_parse_args( $args, $defaults );

		$this->init();
		$this->install_strings();

		add_filter( 'upgrader_source_selection', [ $this, 'check_package' ] );
		add_filter( 'upgrader_post_install', [ $this, 'check_parent_theme_filter' ], 10, 3 );
		add_filter( 'upgrader_clear_destination', [ $this, 'clearStatCache' ] );

		$this->run( [
			'package'           => $package,
			'destination'       => get_theme_root(),
			'clear_destination' => $this->getOverwriteMode(),
			'clear_working'     => true,
			'hook_extra'        => [
				'type'   => 'theme',
				'action' => 'install',
			],
		] );

		remove_filter( 'upgrader_source_selection', [ $this, 'check_package' ] );
		remove_filter( 'upgrader_post_install', [ $this, 'check_parent_theme_filter' ] );
		remove_filter( 'upgrader_clear_destination', [ $this, 'clearStatCache' ] );

		if ( !$this->result || is_wp_error( $this->result ) ) {
			return $this->result;
		}

		// Refresh the Theme Update information
		wp_clean_themes_cache( $parsed_args[ 'clear_update_cache' ] );

		return true;
	}

	/**
	 * This is inserted right after clearing the target directory. It seems that some systems are slow
	 * in updating filesystem "info" because we were receiving permission denied when trying to recreate
	 * the install directory.
	 * @return $this
	 */
	public function clearStatCache() {
		clearstatcache();
		sleep( 1 );
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getOverwriteMode() {
		return (bool)$this->bModeOverwrite;
	}

	/**
	 * @param bool $bOn
	 * @return $this
	 */
	public function setOverwriteMode( $bOn = true ) {
		$this->bModeOverwrite = $bOn;
		return $this;
	}
}