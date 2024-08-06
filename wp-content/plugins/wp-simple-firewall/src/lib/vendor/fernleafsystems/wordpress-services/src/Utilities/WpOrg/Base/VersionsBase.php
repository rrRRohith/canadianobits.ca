<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Base;

use FernleafSystems\Wordpress\Services;

abstract class VersionsBase {

	/**
	 * @var string[]
	 */
	private $wpVersions;

	/**
	 * @return string[]
	 */
	public function all() :array {
		if ( !isset( $this->wpVersions ) ) {
			$this->wpVersions = $this->downloadVersions();
			\usort( $this->wpVersions, '\version_compare' );
		}
		return $this->wpVersions;
	}

	/**
	 * @param string $branch - leave empty to use the current WP Version
	 * @return string
	 * @throws \Exception
	 */
	public function getLatestVersionForBranch( $branch = null ) {
		if ( empty( $branch ) ) {
			$branch = Services\Services::WpGeneral()->getVersion();
		}

		$parts = \explode( '.', $branch );
		if ( \count( $parts ) < 2 ) {
			throw new \Exception( sprintf( 'Invalid version "%s" provided.', $branch ) );
		}

		$thisBranch = $parts[ 0 ].'.'.$parts[ 1 ];

		$possible = \array_filter(
			$this->all(),
			function ( $version ) use ( $thisBranch ) {
				return \strpos( $version, $thisBranch ) === 0;
			}
		);

		return end( $possible );
	}

	/**
	 * @return string
	 */
	public function latest() {
		$v = $this->all();
		return \end( $v );
	}

	abstract protected function downloadVersions() :array;
}