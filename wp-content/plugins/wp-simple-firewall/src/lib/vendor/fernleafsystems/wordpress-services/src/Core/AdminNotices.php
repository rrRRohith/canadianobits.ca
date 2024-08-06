<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

/**
 */
class AdminNotices {

	/**
	 * @var array
	 */
	protected $aAdminNotices;

	/**
	 * @var string
	 */
	protected $sFlashMessage;

	/**
	 * @var string
	 */
	protected $sActionPrefix = '';

	public function __construct() {
		add_action( 'admin_notices', [ $this, 'onWpAdminNotices' ] );
		add_action( 'network_admin_notices', [ $this, 'onWpAdminNotices' ] );
		add_action( 'wp_loaded', [ $this, 'flushFlashMessage' ] );

		if ( Services::WpGeneral()->isAjax() ) {
			add_action( 'wp_ajax_icwp_DismissAdminNotice', [ $this, 'ajaxDismissAdminNotice' ] );
		}
	}

	public function onWpAdminNotices() {
		do_action( $this->getActionPrefix().'generate_admin_notices' );
		foreach ( $this->getNotices() as $content ) {
			echo $content;
		}
		$this->flashNotice();
	}

	public function ajaxDismissAdminNotice() {

		$bSuccess = $this->checkAjaxNonce();
		if ( $bSuccess ) {
			// Get all notices and if this notice exists, we set it to "hidden"
			$sNoticeId = sanitize_key( Services::Request()->query( 'notice_id', '' ) );
			$aNotices = apply_filters( $this->getActionPrefix().'register_admin_notices', [] );
			if ( !empty( $sNoticeId ) && \array_key_exists( $sNoticeId, $aNotices ) ) {
				$this->setAdminNoticeAsDismissed( $aNotices[ $sNoticeId ] );
			}
			$this->sendAjaxResponse( true );
		}
	}

	/**
	 * @param string $sNoticeId
	 * @return true
	 */
	public function getAdminNoticeIsDismissed( $sNoticeId ) {
		$sCurrentMetaValue = $this->getAdminNoticeMeta( $sNoticeId );
		return ( $sCurrentMetaValue == 'Y' );
	}

	/**
	 * @param string $sNoticeId
	 * @return false|string
	 */
	public function getAdminNoticeMeta( $sNoticeId ) {
		return Services::WpUsers()->getUserMeta( $this->getActionPrefix().$sNoticeId );
	}

	/**
	 * @param array $aNotice
	 */
	public function setAdminNoticeAsDismissed( $aNotice ) {
		Services::WpUsers()->updateUserMeta( $this->getActionPrefix().$aNotice[ 'id' ], 'Y' );
	}

	/**
	 * Will send ajax error response immediately upon failure
	 * @return bool
	 */
	protected function checkAjaxNonce() {

		$sNonce = Services::Request()->request( '_ajax_nonce', '' );
		if ( empty( $sNonce ) ) {
			$sMessage = 'Nonce security checking failed - the nonce value was empty.';
		}
		elseif ( wp_verify_nonce( $sNonce, 'icwp_ajax' ) === false ) {
			$sMessage = sprintf( 'Nonce security checking failed - the nonce supplied was "%s".', $sNonce );
		}
		else {
			return true; // At this stage we passed the nonce check
		}

		// At this stage we haven't returned after success so we failed the nonce check
		$this->sendAjaxResponse( false, [ 'message' => $sMessage ] );
		return false; //unreachable
	}

	/**
	 * @param       $bSuccess
	 * @param array $aData
	 */
	protected function sendAjaxResponse( $bSuccess, $aData = [] ) {
		$bSuccess ? wp_send_json_success( $aData ) : wp_send_json_error( $aData );
	}

	/**
	 * @return string
	 */
	public function getActionPrefix() {
		return $this->sActionPrefix;
	}

	/**
	 * @param string $sPrefix
	 * @return $this
	 */
	public function setActionPrefix( $sPrefix ) {
		$this->sActionPrefix = rtrim( $sPrefix, '-' ).'-';
		return $this;
	}

	/**
	 * @return array
	 */
	protected function getNotices() {
		if ( !isset( $this->aAdminNotices ) || !is_array( $this->aAdminNotices ) ) {
			$this->aAdminNotices = [];
		}
		return $this->aAdminNotices;
	}

	/**
	 * @param string $sNoticeId
	 * @param string $sNotice
	 * @return $this
	 */
	public function addAdminNotice( $sNotice, $sNoticeId = '' ) {
		if ( !empty( $sNotice ) ) {
			$aCurrentNotices = $this->getNotices();
			if ( empty( $sNoticeId ) ) {
				$sNoticeId = md5( uniqid( '', true ) );
			}
			$aCurrentNotices[ $sNoticeId ] = $sNotice;
			$this->aAdminNotices = $aCurrentNotices;
		}
		return $this;
	}

	/**
	 * Use this to add a simple message to the admin notice collection. It'll wrap it up in basic html
	 *
	 * @param string $sRawMessage
	 * @param string $sType
	 * @return $this
	 */
	public function addRawAdminNotice( $sRawMessage, $sType = 'updated' ) {
		return $this->addAdminNotice( $this->wrapAdminNoticeHtml( $sRawMessage, $sType ) );
	}

	/**
	 * Provides the basic HTML template for printing a WordPress Admin Notices
	 *
	 * @param $sNotice       - The message to be displayed.
	 * @param $sMessageClass - either error or updated
	 * @param $bPrint        - if true, will echo. false will return the string
	 * @return bool|string
	 */
	protected function wrapAdminNoticeHtml( $sNotice = '', $sMessageClass = 'updated', $bPrint = false ) {
		$sWrapper = '<div class="%s icwp-admin-notice">%s</div>';
		$sFullNotice = sprintf( $sWrapper, $sMessageClass, $sNotice );
		if ( $bPrint ) {
			echo $sFullNotice;
			return true;
		}
		else {
			return $sFullNotice;
		}
	}

	/**
	 * @param $msg
	 */
	public function addFlashMessage( string $msg ) {
		Services::Response()->cookieSet( $this->getActionPrefix().'flash', esc_attr( $msg ) );
	}

	protected function flashNotice() {
		if ( !empty( $this->sFlashMessage ) ) {
			echo $this->wrapAdminNoticeHtml( $this->sFlashMessage );
		}
	}

	public function flushFlashMessage() {
		$cookie = $this->getActionPrefix().'flash';
		$this->sFlashMessage = Services::Request()->cookie( $cookie, '' );
		if ( !empty( $this->sFlashMessage ) ) {
			$this->sFlashMessage = sanitize_text_field( $this->sFlashMessage );
		}
		Services::Response()->cookieDelete( $cookie );
	}
}