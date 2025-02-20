<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\Rules\Responses;

use FernleafSystems\Wordpress\Plugin\Shield\ActionRouter\Actions;
use FernleafSystems\Wordpress\Plugin\Shield\Controller\Email\EmailVO;
use FernleafSystems\Wordpress\Services\Services;

class FirewallBlock extends Base {

	public const SLUG = 'firewall_block';

	public function execResponse() :void {
		$this->runBlock();
	}

	/**
	 * @throws \Exception
	 */
	private function runBlock() {
		$mod = self::con()->getModule_Firewall();

		$this->preBlock();

		remove_filter( 'wp_robots', 'wp_robots_noindex_search' );
		remove_filter( 'wp_robots', 'wp_robots_noindex_embeds' );
		Services::WpGeneral()->turnOffCache();
		nocache_headers();

		switch ( $mod->getBlockResponse() ) {
			case 'redirect_die':
				Services::WpGeneral()->wpDie( 'Firewall Triggered' );
				break;
			case 'redirect_die_message':
				self::con()->action_router->action( Actions\FullPageDisplay\DisplayBlockPage::class, [
					'render_slug' => Actions\Render\FullPage\Block\BlockFirewall::SLUG,
					'render_data' => [
						'block_meta_data' => self::con()->rules->getConditionMeta()->getRawData(),
					],
				] );
				break;
			case 'redirect_home':
				Services::Response()->redirectToHome();
				break;
			case 'redirect_404':
				Services::Response()->sendApache404();
				break;
			default:
				break;
		}
		die();
	}

	private function preBlock() {
		$mod = self::con()->getModule_Firewall();
		if ( $mod->opts()->isOpt( 'block_send_email', 'Y' ) ) {
			self::con()->fireEvent(
				$this->sendBlockEmail() ? 'fw_email_success' : 'fw_email_fail',
				[ 'audit_params' => [ 'to' => self::con()->getModule_Plugin()->getPluginReportEmail() ] ]
			);
		}
	}

	private function sendBlockEmail() :bool {
		$con = self::con();

		$blockMeta = $con->rules->getConditionMeta()->getRawData();
		$blockMeta[ 'firewall_rule_name' ] = $blockMeta[ 'match_name' ] ?? 'Unknown';

		return $con->email_con->sendVO(
			EmailVO::Factory(
				$con->getModule_Plugin()->getPluginReportEmail(),
				__( 'Firewall Block Alert', 'wp-simple-firewall' ),
				$con->action_router->render( Actions\Render\Components\Email\FirewallBlockAlert::SLUG, [
					'ip'         => $this->req->ip,
					'block_meta' => $blockMeta
				] )
			)
		);
	}
}