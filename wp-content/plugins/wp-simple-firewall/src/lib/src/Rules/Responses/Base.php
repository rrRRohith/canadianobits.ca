<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Plugin\Shield\Rules\Responses;

abstract class Base extends \FernleafSystems\Wordpress\Plugin\Shield\Rules\Common\BaseConditionResponse {

	public const SLUG = '';

	/**
	 * @throws \Exception
	 */
	abstract public function execResponse() :void;

	public function isTerminating() :bool {
		return false;
	}

	/**
	 * @deprecated 18.6
	 */
	public function setConditionTriggerMeta( array $meta ) :self {
		$this->conditionTriggerMeta = $meta;
		return $this;
	}
}