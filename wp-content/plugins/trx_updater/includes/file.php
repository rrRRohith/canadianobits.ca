<?php
/**
 * Filesystem utilities
 *
 * @package ThemeREX Updater
 * @since v1.0.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );



/* Check if file/folder present in the child theme and return path (url) to it. 
   Else - path (url) to file in the main theme dir
------------------------------------------------------------------------------------- */
if (!function_exists('trx_updater_get_file_dir')) {	
	function trx_updater_get_file_dir($file, $return_url=false) {
		if ($file[0]=='/') $file = substr($file, 1);
		$theme_dir = get_template_directory().'/'.TRX_UPDATER_BASE.'/';
		$theme_url = get_template_directory_uri().'/'.TRX_UPDATER_BASE.'/';
		$child_dir = get_stylesheet_directory().'/'.TRX_UPDATER_BASE.'/';
		$child_url = get_stylesheet_directory_uri().'/'.TRX_UPDATER_BASE.'/';
		$dir = '';
		if (file_exists(($child_dir).($file)))
			$dir = ($return_url ? $child_url : $child_dir) . ($file);
		else if (file_exists(($theme_dir).($file)))
			$dir = ($return_url ? $theme_url : $theme_dir) . ($file);
		else if (file_exists(TRX_UPDATER_DIR . ($file)))
			$dir = ($return_url ? TRX_UPDATER_URL : TRX_UPDATER_DIR) . ($file);
		return apply_filters( $return_url ? 'trx_updater_get_file_url' : 'trx_updater_get_file_dir', $dir, $file );
	}
}

if (!function_exists('trx_updater_get_file_url')) {	
	function trx_updater_get_file_url($file) {
		return trx_updater_get_file_dir($file, true);
	}
}


// Include part of template with specified parameters
if (!function_exists('trx_updater_get_template_part')) {	
	function trx_updater_get_template_part($file, $args_name='', $args=array()) {
		static $fdirs = array();
		if (!is_array($file))
			$file = array($file);
		foreach ($file as $f) {
			if (!empty($fdirs[$f]) || ($fdirs[$f] = trx_updater_get_file_dir($f)) != '') { 
				if (!empty($args_name) && !empty($args))
					set_query_var($args_name, $args);
				include $fdirs[$f];
				break;
			}
		}
	}
}

// Return file extension from full name/path
if (!function_exists('trx_updater_get_file_ext')) {	
	function trx_updater_get_file_ext($file) {
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		return empty($ext) ? '' : $ext;
	}
}

// Return file name from full name/path
if (!function_exists('trx_updater_get_file_name')) {	
	function trx_updater_get_file_name($file, $without_ext=true) {
		$parts = pathinfo($file);
		return !empty($parts['filename']) && $without_ext ? $parts['filename'] : $parts['basename'];
	}
}


/* Init WP Filesystem before the plugins and theme init
------------------------------------------------------------------- */
if (!function_exists('trx_updater_init_filesystem')) {
	add_action( 'init', 'trx_updater_init_filesystem', 0);
	function trx_updater_init_filesystem() {
        if ( !function_exists('WP_Filesystem') ) {
            require_once trailingslashit(ABSPATH) . 'wp-admin/includes/file.php';
        }
		if ( is_admin() ) {
			$url = admin_url();
			$creds = false;
			// First attempt to get credentials.
			if ( function_exists('request_filesystem_credentials') && false === ( $creds = request_filesystem_credentials( $url, '', false, false, array() ) ) ) {
				// If we comes here - we don't have credentials
				// so the request for them is displaying no need for further processing
				return false;
			}
	
			// Now we got some credentials - try to use them.
			if ( ! WP_Filesystem( $creds ) ) {
				// Incorrect connection data - ask for credentials again, now with error message.
				if ( function_exists('request_filesystem_credentials') ) request_filesystem_credentials( $url, '', true, false );
				return false;
			}
			
			return true; // Filesystem object successfully initiated.
		} else {
            WP_Filesystem();
		}
		return true;
	}
}


// Put data into specified file
if (!function_exists('trx_updater_fpc')) {	
	function trx_updater_fpc($file, $data, $flag=0) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				// Attention! WP_Filesystem can't append the content to the file!
				if ($flag==FILE_APPEND && $wp_filesystem->exists($file) && strpos($file, '//')===false) {
					// If it is a existing local file (not contain '//' in the path) and we need to append data -
					// use native PHP function to prevent large consumption of memory
					return file_put_contents($file, $data, $flag);
				} else {
					// In other case (not a local file or not need to append data or file not exists)
					// That's why we have to read the contents of the file into a string,
					// add new content to this string and re-write it to the file if parameter $flag == FILE_APPEND!
					return $wp_filesystem->put_contents($file, ($flag==FILE_APPEND && $wp_filesystem->exists($file) ? $wp_filesystem->get_contents($file) : '') . $data, false);
				}
			} else {
				throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Put contents to the file "%s" failed', 'trx_updater'), $file));
			}
		}
		return false;
	}
}

// Get text from specified file
if (!function_exists('trx_updater_fgc')) {	
	function trx_updater_fgc($file, $unpack=false) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				$tmp_cont = strpos($file, '//')!==false //&& !$allow_url_fopen 
								? trx_updater_remote_get($file) 
								: $wp_filesystem->get_contents($file);
				if ($unpack && trx_updater_get_file_ext($file) == 'zip') {
					$tmp_name = 'tmp-'.rand().'.zip';
					$tmp = wp_upload_bits($tmp_name, null, $tmp_cont);
					if ($tmp['error'])
						$tmp_cont = '';
					else {
						unzip_file($tmp['file'], dirname($tmp['file']));
						$file_name = dirname($tmp['file']) . '/' . basename($file, '.zip') . '.txt';
						$tmp_cont = trx_updater_fgc($file_name);
						unlink($tmp['file']);
						unlink($file_name);
					}
				}
				return $tmp_cont;
			} else {
				throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get contents from the file "%s" failed', 'trx_updater'), $file));
			}
		}
		return '';
	}
}

// Get array with rows from specified file
if (!function_exists('trx_updater_fga')) {	
	function trx_updater_fga($file) {
		global $wp_filesystem;
		if (!empty($file)) {
			if (isset($wp_filesystem) && is_object($wp_filesystem)) {
				$file = str_replace(ABSPATH, $wp_filesystem->abspath(), $file);
				return $wp_filesystem->get_contents_array($file);
			} else {
				throw new Exception(sprintf(esc_html__('WP Filesystem is not initialized! Get rows from the file "%s" failed', 'trx_updater'), $file));
			}
		}
		return array();
	}
}

// Remove unsafe characters from file/folder path
if (!function_exists('trx_updater_esc')) {	
	function trx_updater_esc($name) {
		return str_replace(array('\\', '~', '$', ':', ';', '+', '>', '<', '|', '"', "'", '`', "\xFF", "\x0A", "\x0D", '*', '?', '^'), '/', trim($name));
	}
}

// Remove protocol from the url
if ( ! function_exists( 'trx_updater_remove_protocol' ) ) {
	function trx_updater_remove_protocol( $url, $complete = true ) {
		$pos = strpos( $url, '://' );
		if ( false !== $pos ) {
			$url = substr( $url, $pos + 1 + ( $complete ? 2 : 0 ) );
		}
		return $url;
	}
}


// Remote files
//-------------------------------------------------------

// Get text from specified file via HTTP (cURL)
if (!function_exists('trx_updater_remote_get')) {	
	function trx_updater_remote_get($file, $timeout=-1) {
		// Set timeout as half of the PHP execution time
		if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
		if (substr($file, 0, 2) == '//') $file = 'http' . ( is_ssl() ? 's' : '') . ':' . $file;
		$response = wp_remote_get($file, array(
									'method'  => 'GET',
									'timeout' => $timeout
									)
								);
		//return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
		return !is_wp_error($response) && isset($response['response']['code']) && $response['response']['code']==200
					? $response['body']
					: '';
	}
}

// Get text from specified file via HTTP (cURL)
if (!function_exists('trx_updater_remote_post')) {	
	function trx_updater_remote_post($file, $args, $timeout=-1) {
		// Set timeout as half of the PHP execution time
		if ($timeout < 1) $timeout = round( 0.5 * max(30, ini_get('max_execution_time')));
		if (substr($file, 0, 2) == '//') $file = 'http' . ( is_ssl() ? 's' : '') . ':' . $file;
		$response = wp_remote_post($file, array(
									'method'  => 'POST',
									'timeout' => $timeout,
									'body'    => $args
									)
								);
		//return wp_remote_retrieve_response_code( $response ) == 200 ? wp_remote_retrieve_body( $response ) : '';
		return !is_wp_error($response) && isset($response['response']['code']) && $response['response']['code']==200 ? $response['body'] : '';
	}
}


// Get JSON from specified url via HTTP (cURL) and return object or null
if (!function_exists('trx_updater_retrieve_json')) {	
	add_filter( 'trx_updater_filter_retrieve_json', 'trx_updater_retrieve_json' );
	function trx_updater_retrieve_json($url) {
		$data = '';
		$resp = trim( trx_updater_remote_get($url) );
		if ( in_array( substr($resp, 0, 1), array( '{', '[' ) ) ) {
			$data = json_decode($resp, true);
		}
		return $data;
	}
}


// Folders tree
//--------------------------------------

// Delete specified folder and it's subfolders
if ( ! function_exists( 'trx_updater_del_folder' ) ) {	
	function trx_updater_del_folder( $dir, $delete_root=true ) {
		$files = array();
		$dirs = array();
		$d = opendir( $dir );
		while ( ( $fname = readdir( $d ) ) !== false ) {
			if ( $fname == '.' || $fname == '..' ) {
				continue;
			}
			if ( is_dir( $dir . '/' . $fname ) ) {
				$dirs[] = $fname;
			} else {
				$files[] = $fname;
			}
		}
		closedir( $d );
		for ( $i = 0; $i < count( $files ); $i++ ) {
			@unlink( $dir . '/' . $files[ $i ] );
		}
		for ( $i = 0; $i < count( $dirs ); $i++ ) {
			trx_updater_del_folder( $dir . '/' . $dirs[ $i ] );
		}
		if ( $delete_root ) {
			@rmdir( $dir );
		}
	}
}

// Get list of the files in the specified folder
if ( ! function_exists( 'trx_updater_scan_folder' ) ) {	
	function trx_updater_scan_folder( $dir, $relative_dir = '', $allow_ext = array() ) {
		$list = array();
		$full_dir = $relative_dir . ( ! empty( $relative_dir ) && ! empty( $dir ) ? '/' : '') . $dir;
		if ( is_dir( $full_dir ) ) {
			$hdir = @opendir( $full_dir );
			if ( $hdir ) {
				while ( ( $file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( $full_dir . '/' . $file );
					if ( substr( $file, 0, 1) == '.' ) {
						continue;
					}
					if ( is_dir( $full_dir . '/' . $file ) ) {
						$list = array_merge( $list, trx_updater_scan_folder( ( ! empty( $dir ) ? $dir . '/' : '') . $file, $relative_dir, $allow_ext ) );
					} else if ( empty( $allow_ext ) || in_array( $pi['extension'], $allow_ext ) ) {
						$list[] = ( ! empty( $dir ) ? $dir . '/' : '' ) . $file;
					}
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}


// Archives
//---------------------------------

// Unpack archive to the specified folder	
if ( ! function_exists( 'trx_updater_unpack_archive' ) ) {	
	function trx_updater_unpack_archive( $arh_name, $dest_folder ) {
		if ( class_exists( 'ZipArchive' ) ) {
			$zip = new ZipArchive;
			if ( $zip->open( $arh_name ) === true ) {
				$zip->extractTo( $dest_folder );
				// Restore date of each file
				$numFiles = $zip->numFiles;
				for ( $i=0; $i < $numFiles; $i++ ) {
					$info = $zip->statIndex( $i );
					$file = $dest_folder . '/' . $info['name'];
					if ( file_exists( $file ) || is_dir( $file ) ) {
						touch( $file, $info['mtime'] );
					}
				}
				$zip->close();
			}
		}
	}
}

// Pack files from specified folder into archive
if ( ! function_exists( 'trx_updater_pack_archive' ) ) {	
	function trx_updater_pack_archive( $arh_name, $dest_folder ) {
		$rez = false;
		if ( class_exists( 'ZipArchive' ) ) {
			$zip = new ZipArchive;
			if ( $zip->open( $arh_name, ZIPARCHIVE::CREATE ) === true ) {
				if ( is_dir( $dest_folder ) ) {
					$files = trx_updater_scan_folder( '', $dest_folder );
					foreach( $files as $file ) {
						$zip->addFile( $dest_folder . '/' . $file, $file );
					}
				} else {
					$pi = pathinfo( $dest_folder );
					$zip->addFile( $dest_folder, $pi['basename'] );
				}
				$zip->close();
				$rez = true;
			}
		}
		return $rez;
	}
}
