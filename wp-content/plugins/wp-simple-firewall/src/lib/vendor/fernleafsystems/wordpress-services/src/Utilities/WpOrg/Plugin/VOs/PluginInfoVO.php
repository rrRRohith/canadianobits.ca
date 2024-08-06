<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin\VOs;

use FernleafSystems\Utilities\Data\Adapter\DynProperties;

/**
 * @property string   name
 * @property string   slug
 * @property string   version
 * @property string   author                     - a href link
 * @property string   author_profile             - URL
 * @property array    contributors
 * @property string   requires
 * @property string   tested
 * @property string   requires_php
 * @property int      rating
 * @property array    ratings
 * @property int      num_ratings
 * @property int      support_threads
 * @property int      support_threads_resolved
 * @property int      active_installs
 * @property string   last_updated
 * @property string   added                      - YYYY-MM-DD
 * @property string   homepage                   - URL
 * @property array    sections
 * @property string   download_link
 * @property array    screenshots
 * @property array    tags
 * @property string[] versions                   - key: versions; value: URL to ZIP
 */
class PluginInfoVO {

	use DynProperties;

	/**
	 * @return float
	 */
	public function getNetPromoterScore() {
		$r = $this->ratings;
		return ( $r[ 5 ] - ( $r[ 1 ] + $r[ 2 ] + $r[ 3 ] ) )/max( \array_sum( $r ), 1 );
	}
}