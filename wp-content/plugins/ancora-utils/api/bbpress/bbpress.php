<?php
/**
 * Plugin support: BBPress and BuddyPress
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if BBPress and BuddyPress is installed and activated
if ( !function_exists( 'trx_utils_exists_bbpress' ) ) {
	function trx_utils_exists_bbpress() {
		return class_exists( 'BuddyPress' ) || class_exists( 'bbPress' );
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_utils_bbpress_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_required_plugins',	'trx_utils_bbpress_importer_required_plugins', 10, 2 );
	function trx_utils_bbpress_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'bbpress')!==false && !trx_utils_exists_bbpress() )
			$not_installed .= '<br>' . esc_html__('BBPress or BuddyPress', 'ancora-utils');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_utils_bbpress_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_utils_filter_importer_options',	'trx_utils_bbpress_importer_set_options' );
	function trx_utils_bbpress_importer_set_options($options=array()) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $options['required_plugins']) ) {
			$options['additional_options'][] = 'bp-active-components';
			$options['additional_options'][] = 'bp-pages';
			$options['additional_options'][] = 'widget_bp_%';
			$options['additional_options'][] = 'bp-deactivated-components';
			$options['additional_options'][] = 'bb-config-location';
			$options['additional_options'][] = 'bp-xprofile-base-group-name';
			$options['additional_options'][] = 'bp-xprofile-fullname-field-name';
			$options['additional_options'][] = 'hide-loggedout-adminbar';
			$options['additional_options'][] = 'bp-disable-account-deletion';
			$options['additional_options'][] = 'bp-disable-avatar-uploads';
			$options['additional_options'][] = 'bp-disable-cover-image-uploads';
			$options['additional_options'][] = 'bp-disable-profile-sync';
			$options['additional_options'][] = 'bp_restrict_group_creation';
			$options['additional_options'][] = 'bp-disable-group-avatar-uploads';
			$options['additional_options'][] = 'bp-disable-group-cover-image-uploads';
			$options['additional_options'][] = 'bp-disable-blogforum-comments';
			$options['additional_options'][] = '_bp_enable_heartbeat_refresh';
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_bbpress'] = str_replace('name.ext', 'bbpress.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_utils_bbpress_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_params',	'trx_utils_bbpress_importer_show_params', 10, 1 );
	function trx_utils_bbpress_importer_show_params($importer) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'bbpress',
				'title' => esc_html__('Import BBPress and BuddyPress', 'ancora-utils'),
				'part' => 0
			));
		}
	}
}

// Clear tables
if ( !function_exists( 'trx_utils_bbpress_importer_clear_tables' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_clear_tables',	'trx_utils_bbpress_importer_clear_tables', 10, 2 );
	function trx_utils_bbpress_importer_clear_tables($importer, $clear_tables) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			if (strpos($clear_tables, 'bbpress')!==false) {
				if ($importer->options['debug']) dfl(__('Clear BBPress and BuddyPress tables', 'ancora-utils'));
				// Check if BuddyPress and BBPress tables are exists and recreate it (if need)
				global $wpdb;
				$activity = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_activity"), ARRAY_A )) == 1;
				$friends  = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_friends"), ARRAY_A )) == 1;
				$groups   = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_groups"), ARRAY_A )) == 1;
				$messages = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_messages_messages"), ARRAY_A )) == 1;
				$blog     = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_user_blogs"), ARRAY_A )) == 1;
				$notify   = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_notifications"), ARRAY_A )) == 1;
				$extended = count($wpdb->get_results( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."bp_xprofile_data"), ARRAY_A )) == 1;
				if ($activity==0 || $friends==0 || $groups==0 || $messages==0 || $blog==0 || $notify==0 || $extended==0) {
					$bp = buddypress();
					if (!function_exists('dbDelta')) {
						require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					}
					require_once $bp->plugin_dir . '/bp-core/admin/bp-core-admin-schema.php';
					if ($activity==0 && function_exists('bp_core_install_activity_streams'))	bp_core_install_activity_streams();
					if ($friends==0 && function_exists('bp_core_install_friends'))				bp_core_install_friends();
					if ($groups==0 && function_exists('bp_core_install_groups'))				bp_core_install_groups();
					if ($messages==0 && function_exists('bp_core_install_private_messaging'))	bp_core_install_private_messaging();
					if ($blog==0 && function_exists('bp_core_install_blog_tracking'))			bp_core_install_blog_tracking();
					if ($notify==0 && function_exists('bp_core_install_notifications'))			bp_core_install_notifications();
					if ($extended==0 && function_exists('bp_core_install_extended_profiles'))	bp_core_install_extended_profiles();
					bp_core_maybe_install_signups();
				}
			}
		}
	}
}

// Import posts
if ( !function_exists( 'trx_utils_bbpress_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import',	'trx_utils_bbpress_importer_import', 10, 2 );
	function trx_utils_bbpress_importer_import($importer, $action) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			if ( $action == 'import_bbpress' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('bbpress', esc_html__('BBPress and BuddyPress data', 'ancora-utils'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_utils_bbpress_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_utils_filter_importer_import_row', 'trx_utils_bbpress_importer_check_row', 9, 4);
	function trx_utils_bbpress_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'bbpress')===false) return $flag;
		static $bbpress_pt_list = false;
		if ( trx_utils_exists_bbpress() ) {
			if ($table == 'posts') {
				if ($bbpress_pt_list === false) {
					$bbpress_pt_list = array();
					if (function_exists('bbp_get_forum_post_type'))	$bbpress_pt_list[] = bbp_get_forum_post_type();
					if (function_exists('bbp_get_topic_post_type'))	$bbpress_pt_list[] = bbp_get_topic_post_type();
					if (function_exists('bbp_get_reply_post_type'))	$bbpress_pt_list[] = bbp_get_reply_post_type();
					if (function_exists('bp_get_email_post_type'))	$bbpress_pt_list[] = bp_get_email_post_type();
				}
				$flag = in_array($row['post_type'], $bbpress_pt_list);
			}
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_utils_bbpress_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_import_fields',	'trx_utils_bbpress_importer_import_fields', 10, 1 );
	function trx_utils_bbpress_importer_import_fields($importer) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'bbpress', 
				'title' => esc_html__('BBPress and BuddyPress data', 'ancora-utils')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_utils_bbpress_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export',	'trx_utils_bbpress_importer_export', 10, 1 );
	function trx_utils_bbpress_importer_export($importer) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			trx_utils_fpc((TRX_UTILS_PLUGIN_DIR . 'importer/export/bbpress.txt'), serialize( array(
				'bp_activity'			=> $importer->export_dump("bp_activity"),
				'bp_activity_meta'		=> $importer->export_dump("bp_activity_meta"),
				'bp_friends'			=> $importer->export_dump("bp_friends"),
				'bp_groups'				=> $importer->export_dump("bp_groups"),
				'bp_groups_groupmeta'	=> $importer->export_dump("bp_groups_groupmeta"),
				'bp_groups_members'		=> $importer->export_dump("bp_groups_members"),
				'bp_messages_messages'	=> $importer->export_dump("bp_messages_messages"),
				'bp_messages_meta'		=> $importer->export_dump("bp_messages_meta"),
				'bp_messages_notices'	=> $importer->export_dump("bp_messages_notices"),
				'bp_messages_recipients'=> $importer->export_dump("bp_messages_recipients"),
				'bp_user_blogs'			=> $importer->export_dump("bp_user_blogs"),
				'bp_user_blogs_blogmeta'=> $importer->export_dump("bp_user_blogs_blogmeta"),
				'bp_notifications'		=> $importer->export_dump("bp_notifications"),
				'bp_notifications_meta'	=> $importer->export_dump("bp_notifications_meta"),
				'bp_xprofile_data'		=> $importer->export_dump("bp_xprofile_data"),
				'bp_xprofile_fields'	=> $importer->export_dump("bp_xprofile_fields"),
				'bp_xprofile_groups'	=> $importer->export_dump("bp_xprofile_groups"),
				'bp_xprofile_meta'		=> $importer->export_dump("bp_xprofile_meta")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_utils_bbpress_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_utils_action_importer_export_fields',	'trx_utils_bbpress_importer_export_fields', 10, 1 );
	function trx_utils_bbpress_importer_export_fields($importer) {
		if ( trx_utils_exists_bbpress() && in_array('bbpress', $importer->options['required_plugins']) ) {
			$importer->show_exporter_fields(array(
				'slug'	=> 'bbpress',
				'title' => esc_html__('BBPress and BuddyPress', 'ancora-utils')
				)
			);
		}
	}
}
?>