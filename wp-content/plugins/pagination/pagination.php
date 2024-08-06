<?php
/*
Plugin Name: Pagination by BestWebSoft
Plugin URI: https://bestwebsoft.com/products/wordpress/plugins/pagination/
Description: Add customizable pagination to WordPress website. Split long content to multiple pages for better navigation.
Author: BestWebSoft
Text Domain: pagination
Domain Path: /languages
Version: 1.2.2
Author URI: https://bestwebsoft.com/
License: GPLv3 or later
*/

/*  © Copyright 2021  BestWebSoft  ( https://support.bestwebsoft.com )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Add Wordpress page 'bws_panel' and sub-page of this plugin to admin-panel.
* @return void
 */
if ( ! function_exists( 'pgntn_add_admin_menu' ) ) {
	function pgntn_add_admin_menu() {
		global $submenu, $pgntn_plugin_info, $wp_version;

		$settings = add_menu_page( __( 'Pagination Settings', 'pagination' ), 'Pagination', 'manage_options', 'pagination.php', 'pgntn_settings_page', 'none' );
		add_submenu_page( 'pagination.php', __( 'Pagination Settings', 'pagination' ), __( 'Settings', 'pagination' ), 'manage_options', 'pagination.php', 'pgntn_settings_page' );
		add_submenu_page( 'pagination.php', 'BWS Panel', 'BWS Panel', 'manage_options', 'pgntn-bws-panel', 'bws_add_menu_render' );

		if ( isset( $submenu['pagination.php'] ) )
			$submenu['pagination.php'][] = array(
				'<span style="color:#d86463"> ' . __( 'Upgrade to Pro', 'pagination' ) . '</span>',
				'manage_options',
				'https://bestwebsoft.com/products/wordpress/plugins/pagination/?k=5f3235c93ef4bd001abe4efd16530be0&pn=212&v=' . $pgntn_plugin_info["Version"] . '&wp_v=' . $wp_version );

		add_action( 'load-' . $settings, 'pgntn_add_tabs' );
	}
}

/**
 * Internationalization
 */
if ( ! function_exists( 'pgntn_plugins_loaded' ) ) {
	function pgntn_plugins_loaded() {
		load_plugin_textdomain( 'pagination', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/**
 * Plugin initialization and language localization on backend and front end
 * @return void
 */
if ( ! function_exists ( 'pgntn_init' ) ) {
	function pgntn_init() {
		global $bws_plugin_info, $pgntn_plugin_info;

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		/* Add variable for bws_menu */
		if ( empty( $pgntn_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$pgntn_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version */
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $pgntn_plugin_info, '4.5' );

		pgntn_settings();
		pgntn_display();
	}
}

/**
 * Plugin initialization on backend
 * @return void
 */
if ( ! function_exists ( 'pgntn_admin_init' ) ) {
	function pgntn_admin_init() {
		global $bws_plugin_info, $pgntn_plugin_info, $pagenow, $pgntn_options;

		if ( empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '212', 'version' => $pgntn_plugin_info["Version"] );

        if ( 'plugins.php' == $pagenow ) {
            /* show banner go settings pls*/
            if ( function_exists( 'bws_plugin_banner_go_pro' ) ) {
                pgntn_settings();
            bws_plugin_banner_go_pro( $pgntn_options, $pgntn_plugin_info, 'pgntn', 'pagination', 'de97a6f81981229376108a33685eb703', '212', '//ps.w.org/pagination/assets/icon-128x128.png' );
            }
        }

    }
}

/* Add settings page in admin area */
if ( ! function_exists( 'pgntn_settings_page' ) ) {
	function pgntn_settings_page() {
        if ( ! class_exists( 'Bws_Settings_Tabs' ) )
            require_once( dirname( __FILE__ ) . '/bws_menu/class-bws-settings.php' );
		require_once( dirname( __FILE__ ) . '/includes/class-pgntn-settings.php' );
		$page = new Pgntn_Settings_Tabs( plugin_basename( __FILE__ ) ); 
		if ( method_exists( $page, 'add_request_feature' ) )
            $page->add_request_feature(); ?>
		<!-- general -->
		<div id="pgntn_settings_form" class="wrap">
			<h1><?php _e( 'Pagination Settings', 'pagination' ); ?></h1>
			<noscript><div class="error below-h2"><p><strong><?php _e( "Please enable JavaScript in your browser.", 'pagination' ); ?></strong></p></div></noscript>
			<?php $page->display_content(); ?>
		</div>
	<?php }
}

if ( ! function_exists( 'pgntn_get_options_default' ) ) {
	function pgntn_get_options_default() {
		global $pgntn_options, $pgntn_plugin_info, $pgntn_option_defaults;

		if ( ! $pgntn_plugin_info )
			$pgntn_plugin_info = get_plugin_data( __FILE__ );

		$pgntn_option_defaults = array(
			'plugin_option_version'			=> $pgntn_plugin_info["Version"],
			'display_settings_notice'		=> 1,
			'suggest_feature_banner'		=> 1,
			'first_install'					=> strtotime( "now" ),
			'where_display'					=> array( 'everywhere' ),
			'loop_position'					=> 'bottom',
			'display_info'					=> 1,
			'display_next_prev'				=> 1,
			'prev_text'						=> __( '« Previous', 'pagination' ),
			'next_text'						=> __( 'Next »', 'pagination' ),
			'show_all'						=> 0,
			'display_count_page'			=> 2,
			'display_standard_pagination'	=> array( 'posts', 'multipage' , 'comments' ),
			'additional_pagination_style'	=> '',
			'display_custom_pagination'		=> 1,
			'add_appearance'				=> 1,
			'width'							=> '60',
			'align'							=> 'left',
			'background_color'				=> '#ffffff',
			'current_background_color'		=> '#efefef',
			'text_color'					=> '#1e14ca',
			'current_text_color'			=> '#000',
			'hover_color'					=> '#000',
			'border_color'					=> '#cccccc',
			'border_width'					=> 1,
			'border_radius'					=> 0,
			'padding_left'					=> 0,
			'padding_right'					=> 0,
			'nofollow_link'					=> 0
		);

		return $pgntn_option_defaults;
	}
}

/**
 * Write plugin settings in to database
 * @return void
 */
if ( ! function_exists( 'pgntn_settings' ) ) {
	function pgntn_settings() {
		global $pgntn_options, $pgntn_plugin_info, $pgntn_option_defaults;

		if ( ! $pgntn_plugin_info )
			$pgntn_plugin_info = get_plugin_data( __FILE__ );

		$pgntn_option_defaults = pgntn_get_options_default();

		if ( ! get_option( 'pgntn_options' ) )
			add_option( 'pgntn_options', $pgntn_option_defaults );

		$pgntn_options = get_option( 'pgntn_options' );

		if ( ! isset( $pgntn_options['plugin_option_version'] ) || $pgntn_options['plugin_option_version'] != $pgntn_plugin_info["Version"] ) {
			pgntn_plugin_activate();
			$pgntn_option_defaults['display_settings_notice'] = 0;
			$pgntn_options = array_merge( $pgntn_option_defaults, $pgntn_options );
			/* show pro features */
			$pgntn_options['hide_premium_options'] = array();

			$pgntn_options['plugin_option_version'] = $pgntn_plugin_info["Version"];
			update_option( 'pgntn_options', $pgntn_options );
		}
	}
}

/**
 * Function for activation
 */
if ( ! function_exists( 'pgntn_plugin_activate' ) ) {
	function pgntn_plugin_activate() {
		/* registering uninstall hook */
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			register_uninstall_hook( __FILE__, 'pgntn_delete_options' );
			restore_current_blog();
		} else {
			register_uninstall_hook( __FILE__, 'pgntn_delete_options' );
		}
	}
}

/**
 * Include necessary css- and js-files in admin panel
 * @return void
 */
if ( ! function_exists( 'pgntn_admin_head' ) ) {
	function pgntn_admin_head() {
		wp_enqueue_style( 'pgntn_icon', plugins_url( 'css/icon.css', __FILE__ ), array( 'wp-color-picker' ) );
		if ( isset( $_REQUEST['page'] ) && 'pagination.php' == $_REQUEST['page'] ) {
			wp_enqueue_style( 'pgntn_stylesheet', plugins_url( 'css/style.css', __FILE__ ), array( 'wp-color-picker' ) );
			wp_enqueue_script( 'pgntn_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
			bws_enqueue_settings_scripts();
			bws_plugins_include_codemirror();
		}
	}
}

/**
 * Include necessary css- and js-files in front-end
 * @return void
 */
if ( ! function_exists( 'pgntn_wp_footer' ) ) {
	function pgntn_wp_footer() {
		wp_enqueue_style( 'pgntn_stylesheet', plugins_url( 'css/nav-style.css', __FILE__ ) );
		wp_enqueue_style( 'pgntn_styles', pgntn_print_style() );
	}
}

/**
 * Include styles for displaying block of page pagination
 * @return void
 */
if ( ! function_exists ( 'pgntn_print_style' ) ) {
	function pgntn_print_style() {
		global $pgntn_options; ?>
		<style type="text/css">
			<?php if ( 1 == $pgntn_options['add_appearance'] ) { ?>
				.pgntn-page-pagination {
					text-align: <?php echo $pgntn_options['align']; ?> !important;
				}
				.pgntn-page-pagination-block {
					width: <?php echo $pgntn_options['width']; ?>% !important;
					padding: 0 <?php echo $pgntn_options['padding_right'] != 0 ? $pgntn_options['padding_right'] . 'px' : '0'; ?> 0 <?php echo $pgntn_options['padding_left'] != 0 ? $pgntn_options['padding_left'] . 'px' : '0'; ?>;
					<?php if ( 'center' == $pgntn_options['align'] ) { ?>
							margin: 0 auto;
					<? } elseif ( 'right' == $pgntn_options['align'] ) { ?>
							float: right;
					<?php } ?>
				}
				.pgntn-page-pagination a {
					color: <?php echo $pgntn_options['text_color']; ?> !important;
					background-color: <?php echo $pgntn_options['background_color']; ?> !important;
					text-decoration: none !important;
					border: <?php echo 0 < intval( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] . "px solid " . $pgntn_options['border_color'] : 'none'; ?> !important;
					<?php if ( ! empty( $pgntn_options['border_radius'] ) ) { ?>
						-webkit-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						-moz-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
					<?php } ?>
				}
				.pgntn-page-pagination a:hover {
					color: <?php echo $pgntn_options['hover_color']; ?> !important;
				}
				.pgntn-page-pagination-intro,
				.pgntn-page-pagination .current {
					background-color: <?php echo $pgntn_options['current_background_color']; ?> !important;
					color: <?php echo $pgntn_options['current_text_color']; ?> !important;
					border: <?php echo 0 < intval( $pgntn_options['border_width'] ) ? $pgntn_options['border_width'] . "px solid " . $pgntn_options['border_color'] : 'none'; ?> !important;
					<?php if ( ! empty( $pgntn_options['border_radius'] ) ) { ?>
						-webkit-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						-moz-border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
						border-radius: <?php echo $pgntn_options['border_radius']; ?>px;
					<?php } ?>
				}
			<?php }
			$classes = '';
			if ( ! empty( $pgntn_options['display_standard_pagination'] ) ) {
				$hide_comments	= ( in_array( 'comments', $pgntn_options['display_standard_pagination'] ) ) ? true : false ;
				$hide_multipage	= ( in_array( 'multipage', $pgntn_options['display_standard_pagination'] ) ) ? true : false ;
				$classes		.= ( in_array( 'posts', $pgntn_options['display_standard_pagination'] ) ) ?
					'.archive #nav-above,
					.archive #nav-below,
					.search #nav-above,
					.search #nav-below,
					.blog #nav-below,
					.blog #nav-above,
					.navigation.paging-navigation,
					.navigation.pagination,
					.pagination.paging-pagination,
					.pagination.pagination,
					.pagination.loop-pagination,
					.bicubic-nav-link,
					#page-nav,
					.camp-paging,
					#reposter_nav-pages,
					.unity-post-pagination,
					.wordpost_content .nav_post_link' : '';
				$classes .= ( ! empty( $classes ) ) && ( $hide_multipage ) ? ',' : '';
				$classes .= $hide_multipage ?
					'.page-link,
					.post-nav-links,
					.page-links' : '';
				$classes .= ( ! empty( $classes ) ) && $hide_comments ? ',' : '';
				$classes .= $hide_comments ?
					'#comments .navigation,
					#comment-nav-above,
					#comment-nav-below,
					#nav-single,
					.navigation.comment-navigation,
					comment-pagination' : '';
			}
			if ( ( ! empty( $pgntn_options['additional_pagination_style'] ) ) && '1' == $pgntn_options['display_custom_pagination'] ) {
				$classes .= ! empty( $classes ) ? ',' : '';
				$classes .= $pgntn_options['additional_pagination_style'];
			}
			if ( ! empty( $classes ) ) {
				echo $classes . ' {
						display: none !important;
					}
					.single-gallery .pagination.gllrpr_pagination {
						display: block !important;
					}';
			} ?>
		</style>
	<?php }
}

/**
 * Display block of pagination
 * @return void
 */
if ( ! function_exists( 'pgntn_display' ) ) {
	function pgntn_display() {
		global $pgntn_options;
		if ( empty( $pgntn_options ) )
			$pgntn_options = get_option( 'pgntn_options' );
		if ( ! is_admin() ) {
			if ( 'top' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] )
				add_filter( 'loop_start', 'pgntn_display_with_loop' );
			if ( 'bottom' == $pgntn_options['loop_position'] || 'both' == $pgntn_options['loop_position'] )
				add_filter( 'loop_end', 'pgntn_display_with_loop_bottom' );

			if ( 'function' != $pgntn_options['loop_position'] && ( in_array( 'everywhere', $pgntn_options['where_display'] ) || in_array( 'paginated_post', $pgntn_options['where_display'] ) ) )
				add_filter( 'wp_link_pages', 'pgntn_wp_link_pages', 10, 2 );
		}
	}
}

/**
 * Display pagination block in frontend above WordPress Loop
 * @param	array	$content	list with data of posts, which needs to displating in the loop
 * @return	void
 */
if ( ! function_exists( 'pgntn_display_with_loop' ) ) {
	function pgntn_display_with_loop( $content ) {
		if ( is_feed() )
			return $content;
		global $wp_query, $pgntn_display_top;
		if ( is_main_query() && $content === $wp_query && ! $pgntn_display_top ) { /* make sure that we display block of pagination only with main loop */
			$pgntn_display_top = true;
			pgntn_nav_display( 'posts', 'top' );
		}
	}
}

/**
 * Display pagination block in frontend below WordPress Loop
 * @param	array	$content	list with data of posts, which needs to displating in the loop
 * @return	void
 */
if ( ! function_exists( 'pgntn_display_with_loop_bottom' ) ) {
	function pgntn_display_with_loop_bottom( $content ) {
		if ( is_feed() )
			return $content;
		global $wp_query, $pgntn_display_bottom;
		if ( is_main_query() && $content === $wp_query && ! $pgntn_display_bottom ) { /* make sure that we display block of pagination only with main loop */
			$pgntn_display_bottom = true;
			pgntn_nav_display( 'posts', 'bottom' );
		}
	}
}

/**
 * Display pagination block on paginated posts or pages
 * @param	string	$output	HTML output of paginated posts' page links.
 * @param	array	$args	An array of arguments.
 * @return	string	$output
 */
if ( ! function_exists( 'pgntn_wp_link_pages' ) ) {
	function pgntn_wp_link_pages( $output, $args ) {
		ob_start();
		pgntn_nav_display( 'multipage', 'bottom' );
		$pagination_output = ob_get_clean();
		return $output . $pagination_output;
	}
}

/**
 * Display pagination block in the function call
 * @param	string	$what	type of pagination ( posts, multipage, comments, custom )
 * @return void
 */
if ( ! function_exists( 'pgntn_display_pagination' ) ) {
	function pgntn_display_pagination( $what = 'posts', $custom_query = '' ) {
		pgntn_nav_display( $what, false, $custom_query );
	}
}

/**
 * Display block of pagination with the Wordpress Loop
 * @param	string	$what	type of pagination ( posts, multipage, comments )
 * @return	void
 */
if ( ! function_exists( 'pgntn_nav_display' ) ) {
	function pgntn_nav_display( $what, $position = false, $custom_query = '' ) {
		global $pgntn_options;
		if ( empty( $pgntn_options ) )
			$pgntn_options = get_option( 'pgntn_options' );
		$display_info = 1 == $pgntn_options['display_info'] ? true : false;
		$nav_settings = array(
			'show_all'	=> '1' == $pgntn_options['show_all'] ? true : false,
			'mid_size'	=> $pgntn_options['display_count_page'],
			'prev_next'	=> '1' == $pgntn_options['display_next_prev'] ? true : false,
			'prev_text'	=> $pgntn_options['prev_text'],
			'next_text'	=> $pgntn_options['next_text'],
		);
		$show_block = false;
		switch ( $what ) {
			case 'posts':
				global $wp_query;
				if (
						( in_array( 'everywhere', $pgntn_options['where_display'] ) ||
							( in_array( 'home', $pgntn_options['where_display'] ) && is_front_page() ) ||
							( in_array( 'blog', $pgntn_options['where_display'] ) && pgntn_is_blog() ) ||
							( in_array( 'archives', $pgntn_options['where_display'] ) && is_archive() ) ||
							( in_array( 'search', $pgntn_options['where_display'] ) && is_search() )
						) &&
						! empty( $wp_query->max_num_pages )
				)
					$show_block = true;

				if ( $show_block ) {
					$nav_settings['base']		= str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) );
					$nav_settings['format']		= '?paged=%#%';
					$nav_settings['current']	= max( 1, get_query_var( 'paged' ) );
					$nav_settings['total']		= $wp_query->max_num_pages;
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination<?php if ( $position ) echo ' pgntn-' . $position; ?>'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo pgntn_nofollow_link( paginate_links( $nav_settings ) ); ?>
							</div>
							<div class="clear"></div>
						</div>
					<?php }
				}
				break;
			case 'custom':
				if ( is_object( $custom_query ) && isset( $custom_query->max_num_pages ) ) {
					$nav_settings['base']		= str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) );
					$nav_settings['format']		= '?paged=%#%';
					$nav_settings['current']	= max( 1, get_query_var( 'paged' ) );
					$nav_settings['total']		= $custom_query->max_num_pages;
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination<?php if ( $position ) echo ' pgntn-' . $position; ?>'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo pgntn_nofollow_link( paginate_links( $nav_settings ) ); ?>
							</div>
							<div class="clear"></div>
						</div>
					<?php }
				}
				break;
			case 'multipage':	
				global $page, $numpages, $pgntn_custom_num_pages;
				$classes = get_body_class();

				/* Compatibility with Gallery plugin */
				if ( is_object( $custom_query ) && isset( $custom_query->max_num_pages ) && isset( $custom_query->post_id ) && isset( $custom_query->case ) && 'bws-gallery' == $custom_query->case ) {
					$pgntn_query['type'] = 'gallery';
					$pgntn_query['post_id'] = $custom_query->post_id;

					if ( isset( $custom_query->gllr_id ) ) {
						/* For Gallery shortocode */
						$pgntn_query['gllr_id'] = $custom_query->gllr_id;
					}
					$pgntn_custom_num_pages = $numpages = $custom_query->max_num_pages;
					$current_page = isset( $custom_query->current_page ) ? $custom_query->current_page : 1;
				}
				if ( $numpages > 1 && is_array( $classes ) && ! in_array( 'home', $classes ) && is_singular() ) {
					$current_page = isset( $custom_query->current_page ) ? $custom_query->current_page : intval( $page );
					if ( empty( $current_page ) )
						$current_page = 1;

					$nav_settings['current']	= $current_page;
					$nav_settings['total']		= $numpages;

					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class="pgntn-page-pagination pgntn-multipage">
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<span class='pgntn-page-pagination-intro'><?php echo __( 'Pages', 'pagination' ) . ' ( ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total'] . ' ): '; ?></span>
								<?php }
								/* display "previous" link */
								if ( 1 != $nav_settings['current'] && '1' == $pgntn_options ['display_next_prev'] ) {
									$prev_link = $nav_settings['current'] - 1;
									$pgntn_query['i'] = $prev_link;
									echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $nav_settings['prev_text'] . '</a>' );
								}

								if ( $nav_settings['show_all'] ) {
									for ( $i = 1; $i <= $nav_settings['total'] ; $i++ ) {
										if ( $i == $nav_settings['current'] ) { ?>
											<span class="page-numbers current"><?php echo $nav_settings['current']; ?></span>
										<?php } else {
											$pgntn_query['i'] = $i;
											echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $i . '</a>' );
										}
									}
								} else {
									$start_number = $nav_settings['current'] - $nav_settings['mid_size'];
									if ( $start_number < 1 )
										$start_number = 1;
									$end_number = $nav_settings['current'] + $nav_settings['mid_size'];
									if ( $end_number > $nav_settings['total'] )
										$end_number = $nav_settings['total'];

									/* display first link */
									if ( $start_number >= 2 ) {
										$pgntn_query['i'] = 1;
										echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . 1 . '</a>' );
									}
									/* display ... */
									if ( $start_number >= 3 ) { ?>
										<span class="pgntn-elipses">...</span>
									<?php }
									/* display precurrent links */
									for ( $i = $start_number; $i < $nav_settings['current'] ; $i++ ) {
										$pgntn_query['i'] = $i;
										echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $i . '</a>' );
									}
									/* display current link */ ?>
									<span class="page-numbers current"><?php echo $nav_settings['current']; ?></span>
									<?php /* display aftercurrent links */
									for ( $i = $nav_settings['current'] + 1; $i <= $end_number; $i++ ) {
										$pgntn_query['i'] = $i;
										echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $i . '</a>' );
									}
									/* display ... */
									if ( $end_number < $nav_settings['total'] - 1 ) { ?>
										<span class="pgntn-elipses">...</span>
									<?php }
									/* display last link */
									if ( $end_number < $nav_settings['total'] ) {
										$pgntn_query['i'] = $nav_settings['total'];
										echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $nav_settings['total'] . '</a>' );
									}
								}

							/* display "next" link */
							if ( $nav_settings['current'] < $nav_settings['total'] && '1' == $pgntn_options ['display_next_prev'] ) {
								$next_link = $nav_settings['current'] + 1;
								$pgntn_query['i'] = $next_link;
								echo pgntn_nofollow_link( pgntn_link_page( $pgntn_query ) . $nav_settings['next_text'] . '</a>' );
							} ?>
						</div><!-- .pgntn-page-pagination-block -->
						<div class="clear"></div>
					</div><!-- .pgntn-page-pagination -->
				<?php } 	
				}			
				break;
			case 'comments':
				global $wp_rewrite;
				$page_comments = get_comment_pages_count();
				if ( ( is_singular() || get_option( 'page_comments' ) ) && ! empty( $page_comments ) )
					$show_block = true;
				if ( $show_block ) {
					$current_page = get_query_var( 'cpage' );
					if ( ! $current_page )
						$current_page = 1;
					$nav_settings['base']		= $wp_rewrite->using_permalinks() ? user_trailingslashit( trailingslashit( get_permalink() ) . 'comment-page-%#%', 'commentpaged' ) : add_query_arg( 'cpage', '%#%' );
					$nav_settings['format']		= '';
					$nav_settings['current']	= $current_page;
					$nav_settings['total']		= $page_comments;
					$nav_settings['add_fragment'] = '#comments';
					if ( 1 < intval( $nav_settings['total'] ) ) { ?>
						<div class='pgntn-page-pagination pgntn-comments'>
							<div class="pgntn-page-pagination-block">
								<?php if ( $display_info ) {
									/* display block "Page __ of __" */ ?>
									<div class='pgntn-page-pagination-intro'><?php echo __( 'Comments Page', 'pagination' ) . ' ' . $nav_settings['current'] . ' ' . __( 'of', 'pagination' ) . ' ' . $nav_settings['total']; ?></div>
								<?php }
								echo pgntn_nofollow_link( paginate_links( $nav_settings ) ); ?>
							</div>
							<div class="clear"></div>
						</div><!-- .pgntn-page-pagination .pgntn-comments -->
					<?php }
				}
				break;

			default:
				break;
		}
	}
}

if ( ! function_exists( 'pgntn_is_blog' ) ) {
	function pgntn_is_blog() {
		if ( is_front_page() && is_home() ) {
			/* Default homepage */
			return false;
		} elseif ( is_front_page() ) {
			/* static homepage */
			return false;
		} elseif ( is_home() ) {
			/* blog page */
			return true;
		} else {
			return false;
		}
	}
}
/**
 * Add link to plugin`s settings page on page with list of all installed plugins ( on table cell with plugin title )
 * @param	$links	array	links bellow plugin title
 * @param	$file	array	relative path to the plugin`s main file
 * @return	$links	array	links bellow plugin title
 */
if ( ! function_exists( 'pgntn_plugin_action_links' ) ) {
	function pgntn_plugin_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin ) $this_plugin = plugin_basename( __FILE__ );

			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=pagination.php">' . __( 'Settings', 'pagination' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}
/**
 * Add necessary links on page with list of all installed plugins ( on table cell with plugin description )
 * @param	$links	array	links bellow plugins description
 * @param	$file	array	relative path to the plugin`s main file
 * @return	$links	array	links bellow plugins description
 */
if ( ! function_exists( 'pgntn_register_plugin_links' ) ) {
	function pgntn_register_plugin_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() )
				$links[] = '<a href="admin.php?page=pagination.php">' . __( 'Settings', 'pagination' ) . '</a>';
			$links[] = '<a href="https://support.bestwebsoft.com/hc/en-us/sections/200995139" target="_blank">' . __( 'FAQ', 'pagination' ) . '</a>';
			$links[] = '<a href="https://support.bestwebsoft.com">' . __( 'Support', 'pagination' ) . '</a>';
		}
		return $links;
	}
}

/* add help tab */
if ( ! function_exists( 'pgntn_add_tabs' ) ) {
	function pgntn_add_tabs() {
		$screen = get_current_screen();
		$args = array(
			'id'			=> 'pgntn',
			'section'		=> '200995139'
		);
		bws_help_tab( $screen, $args );
	}
}

/* add admin notices */
if ( ! function_exists ( 'pgntn_admin_notices' ) ) {
	function pgntn_admin_notices() {
		global $hook_suffix, $pgntn_plugin_info;
		if ( 'plugins.php' == $hook_suffix && ! is_network_admin() ) {
			bws_plugin_banner_to_settings( $pgntn_plugin_info, 'pgntn_options', 'pagination', 'admin.php?page=pagination.php' );
		}
		if ( isset( $_REQUEST['page'] ) && 'pagination.php' == $_REQUEST['page'] ) {
			bws_plugin_suggest_feature_banner( $pgntn_plugin_info, 'pgntn_options', 'pagination' );
		}
	}
}

/**
 * Function for delete plugin options
 * @return void
 */
if ( ! function_exists ( 'pgntn_delete_options' ) ) {
	function pgntn_delete_options() {
		global $wpdb;
		/* Delete options */
		$all_plugins = get_plugins();

		if ( ! array_key_exists( 'pagination-pro/pagination-pro.php', $all_plugins ) ) {
			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				$old_blog = $wpdb->blogid;
				/* Get all blog ids */
				$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					delete_option( 'pgntn_options' );
				}
				switch_to_blog( $old_blog );
			} else {
				delete_option( 'pgntn_options' );
			}
		}
		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

if ( ! function_exists ( 'pgntn_nofollow_link' ) ) {
	function pgntn_nofollow_link( $link ) {
		global $pgntn_options;
		if ( 1 == $pgntn_options["nofollow_link"] ) {
			$link = str_replace( '<a ', '<a rel="nofollow" ', $link );
		}
		return $link;
	}
}
if ( ! function_exists ( 'pgntn_link_page' ) ) {
	function pgntn_link_page( $query ) {
        if ( isset( $query['type'] ) && $query['type'] == 'gallery' ) {
			$i = $query['i'];
			$permalink_post = get_permalink( intval( $query['post_id'] ) );
			$post = get_post( intval( $query['post_id'] ) );
			$query_args = array();

			if ( $i == 1 ) {
				$url = $permalink_post;
			} else {
				 if ( ! get_option( 'permalink_structure' ) || in_array( $post->post_status, array( 'draft', 'pending' ), true ) ) {
					$url = add_query_arg( 'gllr_paged', $i, $permalink_post );
				} elseif ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
					$url = trailingslashit( $permalink_post ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
				} else {
					$url = trailingslashit( $permalink_post ) . 'page/' . user_trailingslashit( $i, 'single_paged' );
				}
			}

			if ( is_preview() ) {
				if ( ( 'draft' != $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
					$query_args['preview_id']    = wp_unslash( $_GET['preview_id'] );
					$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
				}
		 
				$url = get_preview_post_link( $post, $query_args, $url );
			}
			if ( isset( $query['gllr_id'] ) ) {
				$url = add_query_arg( 'gllr_id', $query['gllr_id'], $url );
			}

			return '<a href="' . esc_url( $url ) . '" class="post-page-numbers">';	
		} 	
	 	return _wp_link_page( $query['i'] );
	}
}
/**
 * Add all hooks
 */
register_activation_hook( __FILE__, 'pgntn_plugin_activate' );

add_action( 'admin_menu', 'pgntn_add_admin_menu' );
add_action( 'init', 'pgntn_init' );
add_action( 'admin_init', 'pgntn_admin_init' );
add_action( 'plugins_loaded', 'pgntn_plugins_loaded' );
/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'pgntn_plugin_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'pgntn_register_plugin_links', 10, 2 );
/* Include necessary css- and js-files */
add_action( 'admin_enqueue_scripts', 'pgntn_admin_head' );
add_action( 'wp_footer', 'pgntn_wp_footer' );
/* add admin notices */
add_action( 'admin_notices', 'pgntn_admin_notices' );
