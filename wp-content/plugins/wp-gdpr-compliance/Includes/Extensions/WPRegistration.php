<?php

namespace WPGDPRC\Includes\Extensions;

use WPGDPRC\Includes\Helper;
use WPGDPRC\Includes\Integration;

/**
 * Class WPRegistration
 * @package WPGDPRC\Includes\Extensions
 */
class WPRegistration {
    const ID = 'wp_registration';
    /** @var null */
    private static $instance = null;

    public function addFieldMultiSite( $errors ) {
        ?>
        <p>
            <label><input type="checkbox" name="wpgdprc_consent" value="1" /> <?php echo Integration::getCheckboxText(self::ID); ?><abbr class="wpgdprc-required" title=" <?php echo Integration::getRequiredMessage(self::ID); ?> ">*</abbr></label>
        </p><br>
        <?php

            if ($errorMessage = $errors->get_error_message( 'wpgdprc_consent' )) : ?>
                <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif;
    }

	public function addField() {
		?>
        <p>
            <label><input type="checkbox" name="wpgdprc_consent" value="1" /> <?php echo Integration::getCheckboxText(self::ID); ?><abbr class="wpgdprc-required" title=" <?php echo Integration::getRequiredMessage(self::ID); ?> ">*</abbr></label>
        </p><br>
        <?php
	}

    /**
     * @param $errors
     * @param $sanitized_user_login
     * @param $user_email
     *
     * @return mixed
     */
    public function validateGDPRCheckbox($errors, $sanitized_user_login, $user_email) {
            if (!isset($_POST['wpgdprc_consent'])) {
                $errors->add('gdpr_consent_error', '<strong>ERROR</strong>: ' . Integration::getErrorMessage(self::ID));
            }
        return $errors;
    }

	/**
	 * @param $result
	 *
	 * @return mixed
	 */
	public function validateGDPRCheckboxMultisite( $result ) {
	    $wpgdprConsent = '';
	    if( !empty( $_POST['wpgdprc_consent'] ) ) {
		    $wpgdprConsent = sanitize_text_field( $_POST['wpgdprc_consent'] );
	    } elseif (empty($_POST['wpgdprc_consent'])) {
		    $result['errors']->add( 'wpgdprc_consent', Integration::getErrorMessage(self::ID), WP_GDPR_C_SLUG );
	    }
	    $result['wpgdprc_consent'] = $wpgdprConsent;
	    return $result;
    }

    /**
     * @param $user
     */
    public function logGivenGDPRConsent($user) {
        global $wpdb;
        if (is_multisite()) {
            $user = get_userdata($user);
            $userEmail = $user->user_email;
            $siteId = get_current_blog_id();
        } else {
	        $userEmail  = $_POST['user_email'];
            $siteId = null;
        }
        $wpdb->insert($wpdb->base_prefix . 'wpgdprc_log', array(
            'site_id' => $siteId,
            'plugin_id' => self::ID,
            'user' => Helper::anonymizeEmail($userEmail),
            'ip_address' => Helper::anonymizeIP(Helper::getClientIpAddress()),
            'date_created' => Helper::localDateTime(time())->format('Y-m-d H:i:s'),
            'log' => __('user has given consent when registering', WP_GDPR_C_SLUG),
            'consent_text' => Integration::getCheckboxText(self::ID)
        ));
	}

    /**
     * @return null|WPRegistration
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}