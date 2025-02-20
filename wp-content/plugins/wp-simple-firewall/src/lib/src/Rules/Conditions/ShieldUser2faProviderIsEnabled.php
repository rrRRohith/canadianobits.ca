<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\Rules\Conditions;

use FernleafSystems\Wordpress\Plugin\Shield\Rules\{
	Enum
};
use FernleafSystems\Wordpress\Plugin\Shield\Modules\LoginGuard\Lib\TwoFactor\Provider\{
	BackupCodes,
	Email,
	GoogleAuth,
	Passkey,
	Yubikey
};
use FernleafSystems\Wordpress\Plugin\Shield\Modules\LoginGuard\Options;

class ShieldUser2faProviderIsEnabled extends ShieldUser2faBase {

	public function getName() :string {
		return __( 'Shield 2FA Provider Enabled', 'wp-simple-firewall' );
	}

	public function getDescription() :string {
		return __( 'Is a given 2FA provider enabled on the site.', 'wp-simple-firewall' );
	}

	protected function execConditionCheck() :bool {
		/** @var Options $opts */
		$opts = self::con()->getModule_LoginGuard()->opts();
		switch ( $this->p->provider ) {
			case BackupCodes::ProviderSlug():
				$match = $opts->isOpt( 'allow_backupcodes', 'Y' );
				break;
			case Email::ProviderSlug():
				$match = $opts->isEnabledEmailAuth();
				break;
			case GoogleAuth::ProviderSlug():
				$match = $opts->isEnabledGoogleAuthenticator();
				break;
			case Passkey::ProviderSlug():
				$match = $opts->isOpt( 'enable_passkeys', 'Y' );
				break;
			case Yubikey::ProviderSlug():
				$match = $opts->isEnabledYubikey();
				break;
			default:
				$match = false;
				break;
		}
		return $match;
	}

	public function getParamsDef() :array {
		$providers = $this->get2faProviderForParamDef();
		return [
			'provider' => [
				'type'        => Enum\EnumParameters::TYPE_ENUM,
				'type_enum'   => \array_keys( $providers ),
				'enum_labels' => $providers,
				'label'       => __( '2FA Provider', 'wp-simple-firewall' ),
			],
		];
	}
}