<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Request;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Core\Request;
use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\Net\IpID;

/**
 * @property Request         $request
 * @property \Carbon\Carbon  $carbon
 * @property \Carbon\Carbon  $carbon_tz
 *
 * @property string          $ip
 * @property bool            $ip_is_public
 * @property string          $ip_id
 * @property bool            $is_server_loopback
 *
 * @property string          $rest_api_root
 * @property \WP_REST_Server $rest_server
 *
 * @property string          $method
 * @property string          $path
 * @property string          $host
 * @property string          $script_name
 * @property string          $useragent
 *
 * @property string          $wp_locale
 * @property bool            $wp_is_admin
 * @property bool            $wp_is_networkadmin
 * @property bool            $wp_is_ajax
 * @property bool            $wp_is_cron
 * @property bool            $wp_is_debug
 * @property bool            $wp_is_wpcli
 * @property bool            $wp_is_xmlrpc
 * @property bool            $wp_is_permalinks_enabled
 */
class ThisRequest extends DynPropertiesClass {

	public function __construct( array $params = [] ) {
		$req = $this->request = $params[ 'request' ] ?? clone Services::Request();
		unset( $params[ 'request' ] );

		$WP = Services::WpGeneral();

		$this->request = $req;
		$this->carbon = $req->carbon();
		$this->carbon_tz = $req->carbon( true );

		$this->ip = $req->ip();
		$this->ip_is_public = !empty( $this->ip ) && Services::IP()->isValidIp_PublicRemote( $this->ip );
		try {
			$this->ip_id = ( new IpID( $this->ip, $this->useragent ) )->run()[ 0 ];
		}
		catch ( \Exception $e ) {
			$this->ip_id = IpID::UNKNOWN;
		}
		$this->is_server_loopback = \in_array( $this->ip_id, [ IpID::LOOPBACK, IpID::THIS_SERVER ] );

		$this->method = $req->getMethod();

		$this->path = empty( $req->getPath() ) ? '/' : $req->getPath();
		$this->useragent = $req->getUserAgent();
		$this->host = $this->determineHost();
		$possible = \array_values( \array_unique( \array_map( '\basename', \array_filter( [
			$req->server( 'SCRIPT_NAME' ),
			$req->server( 'SCRIPT_FILENAME' ),
			$req->server( 'PHP_SELF' )
		] ) ) ) );
		$this->script_name = empty( $possible ) ? '' : \current( $possible );

		$this->wp_locale = $WP->getLocale();
		$this->wp_is_admin = is_network_admin() || is_admin();
		$this->wp_is_networkadmin = is_network_admin();
		$this->wp_is_ajax = $WP->isAjax();
		$this->wp_is_cron = $WP->isCron();
		$this->wp_is_debug = $WP->isDebug();
		$this->wp_is_wpcli = $WP->isWpCli();
		$this->wp_is_xmlrpc = $WP->isXmlrpc();
		$this->wp_is_permalinks_enabled = $WP->isPermalinksEnabled();

		$this->applyFromArray( \array_merge( $this->getRawData(), $params ) );
		$this->setupRest();
	}

	protected function determineHost() :string {
		$host = (string)\wp_parse_url( Services::WpGeneral()->getWpUrl(), \PHP_URL_HOST );
		if ( empty( $host ) ) {
			$host = (string)\wp_parse_url( Services::WpGeneral()->getHomeUrl(), \PHP_URL_HOST );
		}
		// Fallback only, as it's not as secure as WP's URL, but it's WordPress. Who feakin' knows.
		if ( empty( $host ) ) {
			foreach ( [ 'HTTP_HOST', 'SERVER_NAME', 'SCRIPT_URI' ] as $item ) {
				$host = \parse_url( (string)$this->request->server( $item ), \PHP_URL_HOST );
				if ( !empty( $host ) ) {
					break;
				}
			}
		}
		return \trim( $host );
	}

	protected function setupRest() {
		add_action( 'init', function () {
			if ( !isset( $this->rest_api_root ) ) {
				$this->rest_api_root = rest_url();
			}
		}, -10 );
		add_action( 'rest_api_init', function ( $wp_rest_server = null ) {
			$this->rest_server = $wp_rest_server instanceof \WP_REST_Server ? $wp_rest_server : null;
		}, 0 );
	}
}