<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\Modules\Firewall\Rules\Build;

use FernleafSystems\Wordpress\Plugin\Shield\Modules\Firewall\ModConsumer;
use FernleafSystems\Wordpress\Plugin\Shield\Rules\{
	Build\BuildRuleCoreShieldBase,
	Conditions,
	Enum,
	Responses
};

class Firewall extends BuildRuleCoreShieldBase {

	use ModConsumer;

	public const SLUG = 'shield/firewall';

	protected function getName() :string {
		return __( 'Firewall', 'wp-simple-firewall' );
	}

	protected function getCommonAuditParamsMapping() :array {
		return \array_merge( parent::getCommonAuditParamsMapping(), [
			'name'  => 'match_name',
			'term'  => 'match_pattern',
			'param' => 'match_request_param',
			'value' => 'match_request_value',
			'scan'  => 'match_category',
			'type'  => 'match_type',
		] );
	}

	protected function getDescription() :string {
		return sprintf( __( 'Check request parameters that trigger firewall patterns.', 'wp-simple-firewall' ), $this->getName() );
	}

	protected function getConditions() :array {
		return [
			'logic'      => Enum\EnumLogic::LOGIC_AND,
			'conditions' => \array_filter( [
				[
					'conditions' => Conditions\RequestBypassesAllRestrictions::class,
					'logic'      => Enum\EnumLogic::LOGIC_INVERT
				],
				$this->opts()->isOpt( 'whitelist_admins', 'Y' ) ? [
					'conditions' => Conditions\IsUserAdminNormal::class,
					'logic'      => Enum\EnumLogic::LOGIC_INVERT,
				] : null,
				[
					'conditions' => Conditions\RequestTriggersFirewall::class,
				],
			] )
		];
	}

	protected function getResponses() :array {
		return [
			[
				'response' => Responses\EventFire::class,
				'params'   => [
					'event'            => 'firewall_block',
					'offense_count'    => 1,
					'block'            => false,
					'audit_params_map' => $this->getCommonAuditParamsMapping(),
				],
			],
			[
				'response' => Responses\FirewallBlock::class,
				'params'   => [],
			],
		];
	}
}