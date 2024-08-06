<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

class Includes {

	/**
	 * @return string
	 */
	public function getUrl_Jquery() {
		return $this->getJsUrl( 'jquery/jquery.js' );
	}

	/**
	 * @param string $sJsInclude
	 * @return string
	 */
	public function getJsUrl( $sJsInclude ) {
		return $this->getIncludeUrl( path_join( 'js', $sJsInclude ) );
	}

	/**
	 * @param string $include
	 * @return string
	 */
	public function getIncludeUrl( $include ) {
		$include = path_join( 'wp-includes', $include );
		return $this->addIncludeModifiedParam( path_join( Services::WpGeneral()->getWpUrl(), $include ), $include );
	}

	/**
	 * @param string $sIncludeHandle
	 * @param string $sAttribute
	 * @param string $sValue
	 * @return $this
	 */
	public function addIncludeAttribute( $sIncludeHandle, $sAttribute, $sValue ) {
		add_filter( 'script_loader_tag',
			function ( $tag, $sHandle ) use ( $sIncludeHandle, $sAttribute, $sValue ) {
				if ( $sHandle == $sIncludeHandle && \strpos( $tag, $sAttribute.'=' ) === false ) {
					$tag = \str_replace( ' src', sprintf( ' %s="%s" src', $sAttribute, $sValue ), $tag );
				}
				return $tag;
			},
			10, 2
		);
		return $this;
	}

	/**
	 * @param $url
	 * @param $include
	 * @return string
	 */
	public function addIncludeModifiedParam( $url, $include ) :string {
		$FS = Services::WpFs();
		$file = path_join( ABSPATH, $include );
		if ( $FS->isFile( $file ) ) {
			$url = add_query_arg( [ 'mtime' => $FS->getModifiedTime( $file ) ], $url );
		}
		return (string)$url;
	}
}