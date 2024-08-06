<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Constants;

class Regex {

	public const ASSET_SLUG = '([A-Za-z0-9]+[_\-])*[A-Za-z0-9]+';
	public const ASSET_VERSION = '([0-9]+\.)*[0-9]+';
	public const BASE64 = '[A–Za-z\d+/]*={0,2}';
	public const HASH_MD5 = '[A-Fa-f\d]{32}';
	public const HASH_SHA1 = '[A-Fa-f\d]{40}';
	public const HASH_SHA256 = '[A-Fa-f\d]{64}';
	public const HASH_SHA384 = '[A-Fa-f\d]{96}';
	public const HASH_SHA512 = '[A-Fa-f\d]{128}';
}