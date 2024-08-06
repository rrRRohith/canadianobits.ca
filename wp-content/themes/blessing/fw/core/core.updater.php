<?php
/**
 * ANCORA Framework: update notifier
 *
 * @package	ancora
 * @since	ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('ancora_updater_theme_setup')) {
	add_action( 'ancora_action_before_init_theme', 'ancora_updater_theme_setup' );
	function ancora_updater_theme_setup() {

		if ( ancora_get_theme_option('admin_update_notifier')=='no' ) return;
	}
}
if (!function_exists('ancora_updater_after_theme_setup')) {
	add_action( 'ancora_action_after_init_theme', 'ancora_updater_after_theme_setup' );		// Fire this action after load theme options
	function ancora_updater_after_theme_setup() {

		if ( ancora_get_theme_option('admin_update_notifier')=='no' ) return;

		// Notifier settings
	    global $ANCORA_GLOBALS;
		$ANCORA_GLOBALS['update_notifier_options'] = apply_filters('ancora_filter_update_notifier', array(
			'theme_name'	=> '-not-set-',
			'theme_folder'	=> '-not-set-',
			'xml_url'		=> ancora_get_protocol().'://themerex.net/!updates/',		// Folder URL to the remote notifier XML file containing the latest version of the theme and changelog (file name must be equal with theme folder name)
			'cache_interval'=> 21600								// The time interval (in seconds) for the remote XML cache in the database (21600 seconds = 6 hours)
		));
	}
}

// Adds an update notification to the WordPress Dashboard menu
if (!function_exists('ancora_update_notifier_menu')) {
	
	function ancora_update_notifier_menu() {
		if (function_exists('simplexml_load_string')) {					// Stop if simplexml_load_string function isn't available
			global $ANCORA_GLOBALS;
			$xml = ancora_get_latest_theme_version($ANCORA_GLOBALS['update_notifier_options']['cache_interval']);	// Get the latest remote XML file on our server
			$theme_data = wp_get_theme();
			if( (string) $xml->latest > (string) $theme_data->get('Version') ) { // Compare current theme version with the remote XML version
			}
		}	
	}
}

// The notifier page
if (!function_exists('ancora_update_notifier')) {
	function ancora_update_notifier() {
		global $ANCORA_GLOBALS;
		$xml = ancora_get_latest_theme_version($ANCORA_GLOBALS['update_notifier_options']['cache_interval']);	// Get the latest remote XML file on our server
		$theme_data = wp_get_theme();
	?>

		<div class="wrap">
		
			<div id="icon-tools" class="icon32"></div>
			<h2><?php ancora_show_layout($ANCORA_GLOBALS['update_notifier_options']['theme_name']); ?> <?php esc_html_e('Theme Updates', 'blessing'); ?></h2>
			<div id="message" class="updated below-h2"><p><strong><?php echo sprintf(__('There is a new version of the %s theme available.', 'blessing'), $ANCORA_GLOBALS['update_notifier_options']['theme_name']); ?></strong> <?php echo sprintf(__('You have version %s installed. Update to version %s.', 'blessing'), $theme_data->get('Version'), $xml->latest); ?></p></div>
	
			<div><img alt="'.esc_attr__('img', 'blessing').'" style="margin: 0 0 20px 0; border: 1px solid #ddd;" src="<?php echo esc_url(ancora_get_file_url('/screenshot.png')); ?>" /></div>
			
			<div id="theme_update_instructions">
				<h3><?php esc_html_e('Update Download and Instructions', 'blessing'); ?></h3>
				<p><?php echo sprintf(__('<strong>Please note:</strong> make a backup of the Theme inside your WordPress installation folder <strong>/wp-content/themes/%s/</strong>', 'blessing'), $ANCORA_GLOBALS['update_notifier_options']['theme_folder']); ?></p>
				<p><?php esc_html_e('To update the Theme, login to <a href="//www.themeforest.net/">ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.' ,'blessing'); ?></p>
				<p><?php echo sprintf(__("Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/%s/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).", 'blessing'), $ANCORA_GLOBALS['update_notifier_options']['theme_folder']); ?></p>
				<p><?php esc_html_e("If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.", 'blessing'); ?></p>
			</div>
			
			<h3 class="theme_update_changelog_title"><?php esc_html_e('Changelog', 'blessing'); ?></h3>
			<div class="theme_update_changelog"><?php ancora_show_layout($xml->changelog); ?></div>
	
		</div>
		
	<?php } 
}


// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
if (!function_exists('ancora_get_latest_theme_version')) {
	function ancora_get_latest_theme_version($interval) {
		global $ANCORA_GLOBALS;
		$notifier_file_url = ($ANCORA_GLOBALS['update_notifier_options']['xml_url']) . ($ANCORA_GLOBALS['update_notifier_options']['theme_folder']);
		$db_cache_field = 'ancora_notifier_cache';
		$db_cache_field_last_updated = 'ancora_notifier_cache_last_updated';
		$last = get_option( $db_cache_field_last_updated );
		$now = time();
		// check the cache
		if ( !$last ||  $now - $last > $interval ) {
			// cache doesn't exist, or is old, so refresh it
			$fn = array(
				'init'  => join('_', array('curl', 'init')),
				'opt'   => join('_', array('curl', 'setopt')),
				'exec'  => join('_', array('curl', 'exec')),
				'close' => join('_', array('curl', 'close'))
			);
			if( function_exists($fn['init']) ) {
				$ch = $fn['init']($notifier_file_url);
				$fn['opt']($ch, CURLOPT_RETURNTRANSFER, true);
				$fn['opt']($ch, CURLOPT_HEADER, 0);
				$fn['opt']($ch, CURLOPT_TIMEOUT, 10);
				$cache = $fn['exec']($ch);
				$fn['close']($ch);
			} else {
				$cache = ancora_fgc($notifier_file_url);
			}
			update_option( $db_cache_field_last_updated, time() );
			if ($cache) {			
				update_option( $db_cache_field, $cache );
				$notifier_data = $cache;
			}  else
				$notifier_data = get_option( $db_cache_field );
		} else {
			// cache file is fresh enough, so read from it
			$notifier_data = get_option( $db_cache_field );
		}
		
		// Let's see if the $xml data was returned as we expected it to.
		// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
		if( strpos((string)$notifier_data, '<notifier>') === false ) {
			$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
		}
		
		// Load the remote XML data into a variable and return it
		$xml = simplexml_load_string($notifier_data); 
		
		return $xml;
	}
}
?>