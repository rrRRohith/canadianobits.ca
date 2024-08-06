<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

class Comments {

	/**
	 * @param string $sAuthorEmail
	 * @return bool
	 */
	public function countApproved( $sAuthorEmail ) {
		$nCount = 0;

		if ( Services::Data()->validEmail( $sAuthorEmail ) ) {
			$oDb = Services::WpDb();
			$sQuery = sprintf(
				"SELECT COUNT(*) FROM %s
				WHERE
					comment_author_email = '%s'
					AND comment_approved = 1 ",
				$oDb->getTable_Comments(),
				esc_sql( $sAuthorEmail )
			);
			$nCount = (int)$oDb->getVar( $sQuery );
		}

		return $nCount;
	}

	/**
	 * @param int $nId
	 * @return \WP_Comment|false
	 */
	public function getById( $nId ) {
		return \WP_Comment::get_instance( $nId );
	}

	/**
	 * @return bool
	 */
	public function getIfCommentsMustBePreviouslyApproved() {
		return ( Services::WpGeneral()->getOption( 'comment_whitelist' ) == 1 );
	}

	/**
	 * @param \WP_Post|null $oPost - queries the current post if null
	 * @return bool
	 */
	public function isCommentsOpen( $oPost = null ) {
		if ( is_null( $oPost ) || !is_a( $oPost, 'WP_Post' ) ) {
			global $post;
			$oPost = $post;
		}
		$bOpen = is_a( $oPost, '\WP_Post' )
				 && comments_open( $oPost->ID )
				 && get_post_status( $oPost ) != 'trash';
		return $bOpen;
	}

	/**
	 * @return bool
	 */
	public function isCommentsOpenByDefault() {
		return Services::WpGeneral()->getOption( 'default_comment_status' ) === 'open';
	}

	/**
	 * @param string $sAuthorEmail
	 * @return bool
	 */
	public function isCommentAuthorPreviouslyApproved( $sAuthorEmail ) {
		return $this->countApproved( $sAuthorEmail ) > 0;
	}

	/**
	 * @return bool
	 */
	public function isCommentSubmission() {
		$oReq = Services::Request();
		$nPostId = $oReq->post( 'comment_post_ID' );
		return $oReq->isPost() && !empty( $nPostId ) && is_numeric( $nPostId )
			   && Services::WpPost()->isCurrentPage( 'wp-comments-post.php' );
	}

	/**
	 * @return bool
	 */
	public function getCommentSubmissionEmail() {
		$sEmail = $this->isCommentSubmission() ? \trim( (string)Services::Request()->query( 'email', '' ) ) : '';
		return Services::Data()->validEmail( $sEmail ) ? $sEmail : null;
	}

	/**
	 * @return array
	 */
	public function getCommentSubmissionComponents() {
		return [
			'comment_post_ID',
			'author',
			'email',
			'url',
			'comment',
			'comment_parent',
		];
	}
}