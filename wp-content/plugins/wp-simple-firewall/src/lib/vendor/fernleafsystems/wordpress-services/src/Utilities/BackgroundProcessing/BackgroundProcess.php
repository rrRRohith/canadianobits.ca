<?php

namespace FernleafSystems\Wordpress\Services\Utilities\BackgroundProcessing;

use FernleafSystems\Wordpress\Services\Services;

abstract class BackgroundProcess extends \WP_Background_Process {

	/**
	 * @var int
	 */
	private $expirationInterval;

	/**
	 * Expired Cron_hook_identifier
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $expired_cron_hook_identifier;

	/**
	 * @param string $action
	 * @param string $prefix
	 */
	public function __construct( $action = '', $prefix = 'apto' ) {
		$this->setPrefix( $prefix )
			 ->setAction( $action );

		parent::__construct();

		$this->expired_cron_hook_identifier = $this->identifier.'_expired_cron';
		add_action( $this->expired_cron_hook_identifier, [ $this, 'handleExpiredItems' ] );
	}

	/**
	 * @return array|\WP_Error
	 */
	public function dispatch() {
		// A cron that automatically cleans up expired items
		$this->scheduleExpiredCleanup();

		return parent::dispatch();
	}

	/**
	 * Overrides base to simply 'return' instead of exit() this healthcheck
	 */
	public function handle_cron_healthcheck() {
		if ( $this->is_process_running() ) {
			// Background process already running.
			return;
		}

		if ( $this->is_queue_empty() ) {
			// No data to process.
			$this->clear_scheduled_event();
			return;
		}

		$this->handle();
	}

	/**
	 * By default the full data of the processing item is post'ed in the request. We don't need/want that.
	 * @return array
	 */
	protected function get_post_args() {
		$args = parent::get_post_args();

		if ( isset( $args[ 'body' ] ) ) {
			$args[ 'body' ] = '';
		}

		return $args;
	}

	protected function time_exceeded() {
		return !Services::WpGeneral()->isWpCli() && parent::time_exceeded();
	}

	protected function scheduleExpiredCleanup() {
		$nExpiration = $this->getExpirationInterval();
		if ( $nExpiration > 0 ) {

			function_exists( 'wp_unschedule_hook' ) ?
				wp_unschedule_hook( $this->expired_cron_hook_identifier )
				: wp_clear_scheduled_hook( $this->expired_cron_hook_identifier );

			if ( !wp_next_scheduled( $this->expired_cron_hook_identifier ) ) {
				wp_schedule_single_event(
					Services::Request()->carbon()->addSeconds( $nExpiration )->timestamp,
					$this->expired_cron_hook_identifier
				);
			}
		}
	}

	public function handleExpiredItems() {
		// override to handle expired items according to Expiration Interval
	}

	public function getExpirationInterval() :int {
		return (int)$this->expirationInterval;
	}

	/**
	 * @param int $action
	 * @return $this
	 */
	public function setAction( $action ) {
		if ( !empty( $action ) ) {
			$this->action = $action;
		}
		return $this;
	}

	/**
	 * @param int $expirationInterval - seconds
	 * @return $this
	 */
	public function setExpirationInterval( $expirationInterval ) {
		$this->expirationInterval = $expirationInterval;
		return $this;
	}

	/**
	 * @param string $prefix
	 * @return $this
	 */
	public function setPrefix( $prefix ) {
		if ( !empty( $prefix ) ) {
			$this->prefix = $prefix;
		}
		return $this;
	}
}