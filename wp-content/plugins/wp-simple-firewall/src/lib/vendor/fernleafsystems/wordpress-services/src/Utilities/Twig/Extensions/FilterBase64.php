<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\Twig\Extensions;

use Twig\TwigFilter;

class FilterBase64 extends \Twig\Extension\AbstractExtension {

	public function getFilters() {
		return [
			new TwigFilter( 'base64_encode', '\base64_encode' ),
			new TwigFilter( 'base64_decode', '\base64_decode' )
		];
	}
}