<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Utilities\Data\Adapter\DynPropertiesClass;
use FernleafSystems\Wordpress\Services\Services;
use Html2Text\Html2Text;

/**
 * @property string $to_email
 * @property string $to_name
 * @property string $from_email
 * @property string $from_name
 * @property string $subject
 * @property array  $content
 * @property bool   $wrap_content
 * @property bool   $wrap_subject
 * @property bool   $is_html
 * @property bool   $is_success  whether the last email sent was successful (according to WP)
 */
class Email extends DynPropertiesClass {

	public function __construct() {
	}

	/**
	 * @param string $line
	 * @return $this
	 */
	public function addContentLine( $line ) {
		$content = $this->getContentBody();
		$content[] = $line;
		return $this->setContentBody( $content );
	}

	/**
	 * @return $this
	 */
	public function addContentNewLine() {
		return $this->addContentLine( "\r\n" );
	}

	/**
	 * @param $bAdd - true to add, false to remove
	 * @return $this
	 */
	protected function emailFilters( $bAdd ) {
		if ( $bAdd ) {
			add_action( 'phpmailer_init', [ $this, 'onPhpMailerInit' ], PHP_INT_MAX );
			add_filter( 'wp_mail_from', [ $this, 'filterMailFrom' ], 100 );
			add_filter( 'wp_mail_from_name', [ $this, 'filterMailFromName' ], 100 );
			add_filter( 'wp_mail_content_type', [ $this, 'filterMailContentType' ], 100, 0 );
		}
		else {
			remove_action( 'phpmailer_init', [ $this, 'onPhpMailerInit' ], PHP_INT_MAX );
			remove_filter( 'wp_mail_from', [ $this, 'filterMailFrom' ], 100 );
			remove_filter( 'wp_mail_from_name', [ $this, 'filterMailFromName' ], 100 );
			remove_filter( 'wp_mail_content_type', [ $this, 'filterMailContentType' ], 100 );
		}
		return $this;
	}

	/**
	 * Ensures HTML emails are correctly formated to contain plain text content also.
	 * @param \PHPMailer $mailer
	 */
	public function onPhpMailerInit( $mailer ) {
		if ( strcasecmp( $mailer->ContentType, 'text/html' ) == 0 && empty( $mailer->AltBody ) ) {
			try {
				$mailer->AltBody = Html2Text::convert( $mailer->Body );
			}
			catch ( \Exception $oE ) {
			}
		}
	}

	/**
	 * @return $this
	 */
	public function send() {
		// Add our filters for From.
		$this->emailFilters( true );
		$this->is_success = wp_mail(
			$this->getTo(),
			$this->getSubject(),
			$this->getMessageBody()
		);
		return $this->emailFilters( false )
					->resetPhpMailer();
	}

	/**
	 * @return $this
	 */
	public function resetPhpMailer() {
		global $phpmailer;
		$phpmailer = null;
		return $this;
	}

	/**
	 * @return string
	 */
	protected function getMessageBody() {
		$body = $this->getContentBody();
		if ( $this->isWrapContentBody() ) {
			$body = \array_merge(
				$this->getContentHeader(),
				[ '' ],
				$body,
				[ '' ],
				$this->getContentFooter()
			);
		}
		$body = \implode( ( $this->isHtml() ? '<br />' : "\r\n" ), $body );
		if ( $this->isHtml() ) {
			$body = '<html><body>'.$body.'</body></html>';
		}
		return $body;
	}

	protected function getContentHeader() :array {
		return [ sprintf( __( 'Hi%s' ), empty( $this->to_name ) ? '' : ' '.$this->to_name ).',' ];
	}

	protected function getContentBody() :array {
		return \is_array( $this->content ) ? $this->content : [];
	}

	protected function getContentFooter() :array {
		$url = Services::WpGeneral()->getHomeUrl();
		return [
			'----',
			sprintf( __( 'Email sent from %s' ), sprintf( '<a href="%s">%s</a>', $url, $url ) ),
			__( 'Note: Email delays are caused by website hosting and email providers.' ),
			sprintf( __( 'Time Sent: %s' ), Services::WpGeneral()->getTimeStampForDisplay() )
		];
	}

	protected function getSubject() :string {
		$subject = (string)$this->subject;
		if ( $this->isWrapSubject() ) {
			$subject = sprintf( '[%s] %s', Services::WpGeneral()->getSiteName(), $subject );
		}
		return wp_specialchars_decode( $subject );
	}

	/**
	 * @return string
	 */
	protected function getTo() {
		return Services::Data()->validEmail( $this->to_email ) ? $this->to_email
			: Services::WpGeneral()->getSiteAdminEmail();
	}

	protected function isHtml() :bool {
		return !isset( $this->is_html ) || $this->is_html;
	}

	protected function isWrapContentBody() :bool {
		return !isset( $this->wrap_content ) || $this->wrap_content;
	}

	/**
	 * Whether to wrap the given email subject with a prefix that indicate the source site
	 */
	protected function isWrapSubject() :bool {
		return !isset( $this->wrap_subject ) || $this->wrap_subject;
	}

	/**
	 * @param array $content
	 * @return Email
	 */
	public function setContentBody( $content ) {
		if ( is_string( $content ) ) {
			$content = [ $content ];
		}
		$this->content = $content;
		return $this;
	}

	public function filterMailContentType() :string {
		return $this->isHtml() ? 'text/html' : 'text/plain';
	}

	/**
	 * @param string $from
	 * @return string
	 */
	public function filterMailFrom( $from ) {
		return Services::Data()->validEmail( $this->from_email ) ? $this->from_email : $from;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function filterMailFromName( $name ) {
		return $this->from_name ? $this->from_name : $name;
	}

	/**
	 * @param bool $wrap
	 * @return $this
	 */
	public function setIsWrapBodyContent( $wrap ) {
		$this->wrap_content = (bool)$wrap;
		return $this;
	}

	/**
	 * @param string $subject
	 * @return $this
	 */
	public function setSubject( $subject ) {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @param string $email
	 * @return $this
	 */
	public function setToEmail( $email ) {
		$this->to_email = $email;
		return $this;
	}
}