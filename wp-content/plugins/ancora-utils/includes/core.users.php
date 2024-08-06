<?php
/**
 * ANCORA Framework: Registered Users
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('ancora_users_theme_setup')) {
	add_action( 'ancora_action_before_init_theme', 'ancora_users_theme_setup' );
	function ancora_users_theme_setup() {

        // Social Login support
        add_filter( 'trx_utils_filter_social_login', 'ancora_social_login');

		if ( is_admin() ) {
			// Add extra fields in the user profile
			add_action( 'show_user_profile',		'ancora_add_fields_in_user_profile' );
			add_action( 'edit_user_profile',		'ancora_add_fields_in_user_profile' );
	
			// Save / update additional fields from profile
			add_action( 'personal_options_update',	'ancora_save_fields_in_user_profile' );
			add_action( 'edit_user_profile_update',	'ancora_save_fields_in_user_profile' );
		}

	}
}

// Return Social Login layout (if present)
if (!function_exists('ancora_social_login')) {
    function ancora_social_login($sc) {
        return ancora_get_theme_option('social_login');
    }
}


// Return (and show) user profiles links
if (!function_exists('ancora_show_user_socials')) {
	function ancora_show_user_socials($args) {
		$args = array_merge(array(
			'author_id' => 0,						// author's ID
			'allowed' => array(),					// list of allowed social
			'size' => 'small',						// icons size: tiny|small|big
			'style' => 'icons',						// style for show icons: icons|images|bg
			'echo' => true							// if true - show on page, else - only return as string
			), is_array($args) ? $args 
				: array('author_id' => $args));		// If send one number parameter - use it as author's ID
		$output = '';
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];
		$social_list = ancora_get_theme_option('social_icons');
		$list = array();
		foreach ($social_list as $soc) {
			$sn = basename($soc['icon']);
			$sn = $args['style']=='icons' ? ancora_substr($sn, ancora_strrpos($sn, '-')+1) : ancora_substr($sn, 0, ancora_strrpos($sn, '.'));
			if (($pos=ancora_strrpos($sn, '_'))!==false)
				$sn = ancora_substr($sn, 0, $pos);
			if (count($args['allowed'])==0 || in_array($sn, $args['allowed'])) {
				$link = get_the_author_meta('user_' . ($sn), $args['author_id']);
				if ($link) {
					$icon = $args['style']=='icons' || ancora_strpos($soc['icon'], $upload_url)!==false ? $soc['icon'] : ancora_get_socials_url(basename($soc['icon']));
					$list[] = array(
						'icon'	=> $icon,
						'url'	=> $link
					);
				}
			}
		}
		if (count($list) > 0) {
			$output = '<div class="sc_socials sc_socials_size_small">' . trim(ancora_prepare_socials($list, array( 'style' => $args['style'], 'size' => $args['size']))) . '</div>';
			if ($args['echo']) ancora_show_layout($output);
		}
		return $output;
	}
}

// Show additional fields in the user profile
if (!function_exists('ancora_add_fields_in_user_profile')) {
	function ancora_add_fields_in_user_profile( $user ) {
	?>
		<h3><?php _e('User Position', 'blessing'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="user_position"><?php _e('User position', 'blessing'); ?>:</label></th>
				<td><input type="text" name="user_position" id="user_position" size="55" value="<?php echo esc_attr(get_the_author_meta('user_position', $user->ID)); ?>" />
					<span class="description"><?php _e('Please, enter your position in the company', 'blessing'); ?></span>
				</td>
			</tr>
		</table>
	
		<h3><?php _e('Social links', 'blessing'); ?></h3>
		<table class="form-table">
		<?php
		$upload_info = wp_upload_dir();
		$upload_url = $upload_info['baseurl'];
		$social_list = ancora_get_theme_option('social_icons');
		foreach ($social_list as $soc) {
			$sn = basename($soc['icon']);
			$sn = ancora_substr($sn, 0, ancora_strrpos($sn, '.'));
			if (($pos=ancora_strrpos($sn, '_'))!==false)
				$sn = ancora_substr($sn, 0, $pos);
			if (!empty($sn)) {
				?>
				<tr>
					<th><label for="user_<?php echo esc_attr($sn); ?>"><?php ancora_show_layout(ancora_strtoproper($sn)); ?>:</label></th>
					<td><input type="text" name="user_<?php echo esc_attr($sn); ?>" id="user_<?php echo esc_attr($sn); ?>" size="55" value="<?php echo esc_attr(get_the_author_meta('user_'.($sn), $user->ID)); ?>" />
						<span class="description"><?php echo sprintf(__('Please, enter your %s link', 'blessing'), ancora_strtoproper($sn)); ?></span>
					</td>
				</tr>
				<?php
			}
		}
		?>
		</table>
	<?php
	}
}


// Save / update additional fields
if (!function_exists('ancora_save_fields_in_user_profile')) {
	function ancora_save_fields_in_user_profile( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;
		update_user_meta( $user_id, 'user_position', $_POST['user_position'] );
		$social_list = ancora_get_theme_option('social_icons');
		foreach ($social_list as $soc) {
			$sn = basename($soc['icon']);
			$sn = ancora_substr($sn, 0, ancora_strrpos($sn, '.'));
			if (($pos=ancora_strrpos($sn, '_'))!==false)
				$sn = ancora_substr($sn, 0, $pos);
			update_user_meta( $user_id, 'user_'.($sn), $_POST['user_'.($sn)] );
		}
	}
}
?>