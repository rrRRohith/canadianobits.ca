<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Wp;

use FernleafSystems\Wordpress\Services;

class Versions extends Services\Utilities\WpOrg\Base\VersionsBase {

	/**
	 * @param string $version
	 * @param bool   $isVerifyUrl
	 */
	public function exists( $version, $isVerifyUrl = false ) :bool {
		$exists = \in_array( $version, $this->all() );
		if ( $exists && $isVerifyUrl ) {
			try {
				( new Services\Utilities\HttpUtil() )->checkUrl( Repo::GetUrlForVersion( $version ) );
			}
			catch ( \Exception $e ) {
				$exists = false;
			}
		}
		return $exists;
	}

	protected function downloadVersions() :array {
		$data = ( new Services\Utilities\HttpRequest() )->getContent( 'https://api.wordpress.org/core/stable-check/1.0/' );
		return empty( $data ) ? $this->downloadVersionsAlt() : \array_keys( \json_decode( \trim( $data ), true ) );
	}

	protected function downloadVersionsAlt() :array {
		$versions = [];
		$svnVersionsContent = Services\Services::HttpRequest()->getContent( Repo::GetUrlForVersions() );

		if ( !empty( $svnVersionsContent ) ) {
			$oSvnDom = new \DOMDocument();
			$oSvnDom->loadHTML( $svnVersionsContent );

			foreach ( $oSvnDom->getElementsByTagName( 'a' ) as $oElem ) {
				/** @var \DOMElement $oElem */
				$sHref = $oElem->getAttribute( 'href' );
				if ( $sHref != '../' && !filter_var( $sHref, FILTER_VALIDATE_URL ) ) {
					$versions[] = \trim( $sHref, '/' );
				}
			}
		}

		return $versions;
	}
}