<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Enum;

trait EnumValues {

	public static function Values() :array {
		return \array_map( fn( \UnitEnum $enum ) => $enum->value, static::cases() );
	}
}