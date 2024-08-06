<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\PluginUserMeta;

class Users {

	public function count( $networkID = null ) :int {
		if ( !\function_exists( '\get_user_count' ) ) {
			$include = ABSPATH.WPINC.'/ms-functions.php';
			if ( Services::WpFs()->isFile( $include ) ) {
				require_once $include;
			}
		}
		return \function_exists( '\get_user_count' ) ? (int)get_user_count( $networkID ) : 0;
	}

	/**
	 * @param \WP_User|int $userID -user ID
	 */
	public function deleteUserMeta( string $key, $userID = null ) :bool {
		if ( empty( $userID ) ) {
			$userID = $this->getCurrentWpUserId();
		}
		elseif ( $userID instanceof \WP_User ) {
			$userID = $userID->ID;
		}

		return $userID > 0 && delete_user_meta( $userID, $key );
	}

	public function exists( string $usernameOrEmail ) :bool {
		return ( $this->getUserByEmail( $usernameOrEmail ) instanceof \WP_User )
			   || ( $this->getUserByUsername( $usernameOrEmail ) instanceof \WP_User );
	}

	/**
	 * @param array $loginUrlParams
	 */
	public function forceUserRelogin( $loginUrlParams = [] ) {
		$this->logoutUser();
		Services::Response()->redirectToLogin( $loginUrlParams );
	}

	/**
	 * @param \WP_User|int $user
	 */
	public function getAdminUrl_ProfileEdit( $user = null ) :string {
		if ( $user instanceof \WP_User ) {
			$uid = $user->ID;
		}
		elseif ( is_numeric( $user ) ) {
			$uid = $user;
		}
		else {
			$uid = null;
		}

		return Services::WpGeneral()->getAdminUrl(
			is_null( $uid ) ? 'profile.php' : 'user-edit.php?user_id='.$uid
		);
	}

	/**
	 * @param array $args
	 * @return \WP_User[]
	 */
	public function getAllUsers( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'blog_id' => 0,
				//					'fields' => array(
				//						'ID',
				//						'user_login',
				//						'user_email',
				//						'user_pass',
				//					)
			]
		);
		return \function_exists( 'get_users' ) ? get_users( $args ) : [];
	}

	public function getAllUserLoginUsernames() :array {
		return \array_map(
			function ( $user ) {
				return $user->user_login;
			},
			$this->getAllUsers( [ 'fields' => [ 'user_login' ] ] )
		);
	}

	/**
	 * @return int
	 */
	public function getCurrentUserLevel() {
		$user = $this->getCurrentWpUser();
		return ( $user instanceof \WP_User ) ? $user->get( 'user_level' ) : -1;
	}

	public function getLevelToRoleMap() :array {
		return [
			0 => 'subscriber',
			1 => 'contributor',
			2 => 'author',
			3 => 'editor',
			8 => 'administrator'
		];
	}

	/**
	 * @param bool $bSlugsOnly
	 * @return string[]|array[]
	 */
	public function getAvailableUserRoles( $bSlugsOnly = true ) {
		require_once( ABSPATH.'wp-admin/includes/user.php' );
		return $bSlugsOnly ? \array_keys( get_editable_roles() ) : get_editable_roles();
	}

	public function canSaveMeta() :bool {
		$can = false;
		try {
			if ( $this->isUserLoggedIn() ) {
				$key = 'icwp-flag-can-store-user-meta';
				if ( $this->getUserMeta( $key ) == 'icwp' ) {
					$can = true;
				}
				else {
					$can = (bool)$this->updateUserMeta( $key, 'icwp' );
				}
			}
		}
		catch ( \Exception $e ) {
		}
		return $can;
	}

	/**
	 * @return null|\WP_User
	 */
	public function getCurrentWpUser() {
		return $this->isUserLoggedIn() ? wp_get_current_user() : null;
	}

	/**
	 * @return int - 0 if not logged in or can't get the current User
	 */
	public function getCurrentWpUserId() {
		return $this->isUserLoggedIn() ? $this->getCurrentWpUser()->ID : 0;
	}

	/**
	 * @return null|string
	 */
	public function getCurrentWpUsername() {
		return $this->isUserLoggedIn() ? $this->getCurrentWpUser()->user_login : null;
	}

	/**
	 * @param string $email
	 * @return \WP_User|null
	 */
	public function getUserByEmail( string $email ) {
		return $this->getUserBy( 'email', $email );
	}

	/**
	 * @param int $id
	 * @return \WP_User|null
	 */
	public function getUserById( $id ) {
		return $this->getUserBy( 'id', $id );
	}

	/**
	 * @param $username
	 * @return null|\WP_User
	 */
	public function getUserByUsername( string $username ) {
		return $this->getUserBy( 'login', $username );
	}

	/**
	 * @param string $byKey
	 * @param mixed  $value
	 * @return null|\WP_User
	 */
	public function getUserBy( $byKey, $value ) {
		$user = \function_exists( 'get_user_by' ) ? get_user_by( $byKey, $value ) : null;
		return empty( $user ) ? null : $user;
	}

	/**
	 * @param string            $key    should be already prefixed
	 * @param \WP_User|int|null $userID - if omitted get for current user
	 * @return false|string
	 */
	public function getUserMeta( $key, $userID = null ) {
		if ( empty( $userID ) ) {
			$userID = $this->getCurrentWpUserId();
		}
		elseif ( $userID instanceof \WP_User ) {
			$userID = $userID->ID;
		}

		$mResult = false;
		if ( $userID > 0 ) {
			$mResult = get_user_meta( $userID, $key, true );
		}
		return $mResult;
	}

	/**
	 * @param \WP_User $user
	 * @return string|null
	 * @see wp-login.php
	 */
	public function getPasswordResetUrl( $user ) {
		$url = null;

		$key = get_password_reset_key( $user );
		if ( !is_wp_error( $key ) ) {
			$url = add_query_arg(
				[
					'action' => 'rp',
					'key'    => $key,
					'login'  => $user->user_login,
				],
				wp_login_url()
			);
		}

		return $url;
	}

	/**
	 * @param \WP_User|null $user
	 * @return bool
	 */
	public function isUserAdmin( $user = null ) {
		if ( empty( $user ) ) {
			$user = $this->getCurrentWpUser();
		}
		return user_can( $user, 'manage_options' );
	}

	public function isProfilePage() :bool {
		return \defined( 'IS_PROFILE_PAGE' ) && IS_PROFILE_PAGE;
	}

	public function isUserLoggedIn() :bool {
		return \function_exists( 'is_user_logged_in' ) && is_user_logged_in();
	}

	public function isAppPasswordAuth() :bool {
		return did_action( 'application_password_did_authenticate' ) > 0;
	}

	/**
	 * @param string $prefix
	 * @param int    $userID
	 * @return PluginUserMeta
	 * @throws \Exception
	 */
	public function metaVoForUser( string $prefix, $userID = null ) {
		return PluginUserMeta::Load( $prefix, $userID );
	}

	/**
	 * Fires the WordPress logout functions.  If $bQuiet is true, it'll manually
	 * call the WordPress logout code, so as not to fire any other logout actions
	 * We might want to be "quiet" so as not to fire out own action hooks.
	 * @param bool $doQuiet
	 */
	public function logoutUser( $doQuiet = false ) {
		if ( $doQuiet ) {
			wp_destroy_current_session();
			wp_clear_auth_cookie();
			wp_set_current_user( 0 );
		}
		else {
			wp_logout();
		}
	}

	/**
	 * Updates the user meta data for the current (or supplied user ID)
	 * @param string       $key
	 * @param mixed        $mValue
	 * @param \WP_User|int $userID -user ID
	 * @return bool
	 */
	public function updateUserMeta( string $key, $mValue, $userID = null ) {
		if ( empty( $userID ) ) {
			$userID = $this->getCurrentWpUserId();
		}
		elseif ( $userID instanceof \WP_User ) {
			$userID = $userID->ID;
		}
		return $userID > 0 ? update_user_meta( $userID, $key, $mValue ) : false;
	}

	/**
	 * @param string $username
	 * @return bool
	 */
	public function setUserLoggedIn( string $username ) {
		$user = $this->getUserByUsername( $username );
		$success = $user instanceof \WP_User;
		if ( $success ) {
			wp_clear_auth_cookie();
			wp_set_current_user( $user->ID, $user->user_login );
			wp_set_auth_cookie( $user->ID, true );
			do_action( 'wp_login', $user->user_login, $user );
		}
		return $success;
	}
}