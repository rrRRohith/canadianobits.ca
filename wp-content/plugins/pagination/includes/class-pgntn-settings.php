<?php
/**
 * Displays the content on the plugin settings page
 */

if ( ! class_exists( 'Pgntn_Settings_Tabs' ) ) {
	class Pgntn_Settings_Tabs extends Bws_Settings_Tabs {
		/**
		 * Constructor.
		 *
		 * @access public
		 *
		 * @see Bws_Settings_Tabs::__construct() for more information on default arguments.
		 *
		 * @param string $plugin_basename
		 */
		public function __construct( $plugin_basename ) {
			global $pgntn_options, $pgntn_plugin_info;

			$tabs = array(
				'settings'		=> array( 'label' => __( 'Settings', 'pagination' ) ),
				'misc'			=> array( 'label' => __( 'Misc', 'pagination' ) ),
				'custom_code'	=> array( 'label' => __( 'Custom Code', 'pagination' ) ),
				'license'		=> array( 'label' => __( 'License Key', 'pagination' ) )
			);

			parent::__construct( array(
				'plugin_basename'	=> $plugin_basename,
				'plugins_info'		=> $pgntn_plugin_info,
				'prefix'			=> 'pgntn',
				'default_options'	=> pgntn_get_options_default(),
				'options'			=> $pgntn_options,
				'is_network_options'=> is_network_admin(),
				'tabs'				=> $tabs,
				'wp_slug'			=> 'pagination',
                'doc_link'			=> 'https://bestwebsoft.com/documentation/pagination/pagination-user-guide/',
				'link_key'			=> '5f3235c93ef4bd001abe4efd16530be0',
				'link_pn'			=> '212'
			) );

			add_action( get_parent_class( $this ) . '_display_metabox', array( $this, 'display_metabox' ) );
		}

		/**
		 * Save plugin options to the database
		 * @access public
		 * @param void
		 * @return array The action results
		 */
		public function save_options() {
			global $wpdb;

			$message = $notice = $error = '';
			$array_classes = array();
			$plugin_basename = plugin_basename( __FILE__ );

			if ( isset( $_REQUEST['pgntn_where_display'] ) ) {
				$this->options['where_display'] = array();
				foreach( $_REQUEST['pgntn_where_display'] as $this->position ) {
					$this->options['where_display'][] = $this->position;
				}
			} else {
				$this->options['where_display'] = array();
			}
			if ( isset( $_REQUEST['pgntn_display_standard_pagination'] ) ) {
				$this->options['display_standard_pagination'] = array();
				foreach( $_REQUEST['pgntn_display_standard_pagination'] as $this->position )
					$this->options['display_standard_pagination'][] = $this->position;
			} else {
				$this->options['display_standard_pagination'] = array();
			}

			$this->options['loop_position']	= isset( $_REQUEST['pgntn_loop_position'] ) && in_array( $_REQUEST['pgntn_loop_position'], array( 'top', 'bottom', 'both', 'function' ) ) ? $_REQUEST['pgntn_loop_position'] : 'bottom';

			$this->options['display_count_page']			= isset( $_REQUEST['pgntn_display_count_page'] ) ? intval( $_REQUEST['pgntn_display_count_page'] ) : $this->options['display_count_page'];
            $this->options['show_all']                      = 0 >= $this->options['display_count_page'] ? 1 : 0;
			$this->options['display_info']					= isset( $_REQUEST['pgntn_display_info'] ) ? 1 : 0;
			$this->options['display_next_prev']				= isset( $_REQUEST['pgntn_display_next_prev'] ) ? 1 : 0;
			$this->options['prev_text']						= isset( $_REQUEST['pgntn_prev_text'] ) ? stripslashes( sanitize_text_field( $_REQUEST['pgntn_prev_text'] ) ) : $this->options['prev_text'];
			$this->options['next_text']						= isset( $_REQUEST['pgntn_next_text'] ) ? stripslashes( sanitize_text_field( $_REQUEST['pgntn_next_text'] ) ) : $this->options['next_text'];
			$this->options['additional_pagination_style']	= isset( $_REQUEST['pgntn_additional_pagination_style'] ) ? stripslashes( sanitize_text_field( $_REQUEST ['pgntn_additional_pagination_style'] ) ) : $this->options['additional_pagination_style'];
			$this->options['display_custom_pagination']		= isset( $_REQUEST['pgntn_display_custom_pagination'] ) ? 1 : 0;
			$this->options['padding_left']					= isset( $_REQUEST['pgntn_padding_left'] ) ? intval( $_REQUEST['pgntn_padding_left'] ) : $this->options['padding_left'];
			$this->options['padding_right']					= isset( $_REQUEST['pgntn_padding_right'] ) ? intval( $_REQUEST['pgntn_padding_right'] ) : $this->options['padding_right'];
			$this->options['nofollow_link']					= isset( $_REQUEST['pgntn_nofollow_attribute'] ) ? 1 : 0;
			$this->options['add_appearance']				= isset( $_REQUEST['pgntn_add_appearance'] ) ? 1 : 0;
			
			if ( $this->options['add_appearance'] ) {
				$this->options['width']							= isset( $_REQUEST['pgntn_width'] ) ? intval( $_REQUEST['pgntn_width'] ) : $this->options['width'];
				$this->options['align']							= isset( $_REQUEST['pgntn_align'] ) ? $_REQUEST['pgntn_align'] : $this->options['align'];
				$this->options['background_color']				= isset( $_REQUEST['pgntn_background_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_background_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_background_color'] ) ? $_REQUEST['pgntn_background_color'] : $this->options['background_color'] );
				$this->options['current_background_color']		= isset( $_REQUEST['pgntn_current_background_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_current_background_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_current_background_color'] ) ? $_REQUEST['pgntn_current_background_color'] : $this->options['current_background_color'] );
				$this->options['text_color']					= isset( $_REQUEST['pgntn_text_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_text_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_text_color'] ) ? $_REQUEST['pgntn_text_color'] : $this->options['text_color'] );
				$this->options['current_text_color']			= isset( $_REQUEST['pgntn_current_text_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_current_text_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_current_text_color'] ) ? $_REQUEST['pgntn_current_text_color'] : $this->options['current_text_color'] );
				$this->options['border_color']					= isset( $_REQUEST['pgntn_border_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_border_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_border_color'] ) ? $_REQUEST['pgntn_border_color'] : $this->options['border_color'] );
				$this->options['hover_color']					= isset( $_REQUEST['pgntn_hover_color'] ) && function_exists( 'sanitize_hex_color' ) ? sanitize_hex_color( $_REQUEST['pgntn_hover_color'] ) : ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $_REQUEST['pgntn_hover_color'] ) ? $_REQUEST['pgntn_hover_color'] : $this->options['hover_color'] );
				$this->options['border_width']					= isset( $_REQUEST['pgntn_border_width'] ) ? intval( $_REQUEST['pgntn_border_width'] ) : $this->options['border_width'];
				$this->options['border_radius']					= isset( $_REQUEST['pgntn_border_radius'] ) ? intval( $_REQUEST['pgntn_border_radius'] ) : $this->options['border_radius'];
			}

            if ( empty( $this->options['where_display'] ) ) {
                    $notice = __ ( 'Choose some page types to display plugin`s pagination in frontend of your site.', 'pagination' );
            }

			if ( empty( $notice ) ) {
				update_option( 'pgntn_options', $this->options );
				$message = __( 'Settings saved.', 'pagination' );
			}

			return compact( 'message', 'notice', 'error' );
		}

		public function tab_settings() {
			global $wp_version;

			if ( ! $this->all_plugins ) {
				if ( ! function_exists( 'get_plugins' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}
				$this->all_plugins = get_plugins();
			} ?>

			<h3 class="bws_tab_label"><?php _e( 'Pagination Settings', 'pagination' ); ?></h3>
			<?php $this->help_phrase(); ?>
			<hr>
			<table class="form-table">
            <div class="bws_tab_sub_label"><?php _e( 'General', 'pagination' ); ?></div>
				<tr>
					<th scope="row"><?php _e( 'Add Pagination to', 'pagination' ); ?></th>
					<td>
						<fieldset>
							<input type="checkbox" id="pgntn_everywhere" value="everywhere" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
							<label for="pgntn_everywhere"><strong><?php _e( 'All pages', 'pagination' ); ?></strong></label><br />
							<input type="checkbox" id="pgntn_on_home" class="pgntn_where_display" value="home" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) || in_array( 'home', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
							<label for="pgntn_on_home"><?php _e( 'Home', 'pagination' ); ?></label><br />
							<input type="checkbox" id="pgntn_on_blog" class="pgntn_where_display" value="blog" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) || in_array( 'blog', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
							<label for="pgntn_on_blog"><?php _e( 'Blog', 'pagination' ); ?></label><br />
							<input type="checkbox" id="pgntn_on_archives" class="pgntn_where_display" value="archives" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) || in_array( 'archives', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
							<label for="pgntn_on_archives"><?php _e( 'Archive (by categories, date, tags etc.)', 'pagination' ); ?></label><br />
							<input type="checkbox" id="pgntn_on_search" class="pgntn_where_display" value="search" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) || in_array( 'search', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
                            <label for="pgntn_on_search"><?php _e( 'Search results', 'pagination' ); ?></label><br />
							<input type="checkbox" id="pgntn_on_paginated_post" class="pgntn_where_display" value="paginated_post" name="pgntn_where_display[]"<?php if ( in_array( 'everywhere', $this->options['where_display'] ) || in_array( 'paginated_post', $this->options['where_display'] ) ) echo ' checked="checked"'; ?> />
							<label for="pgntn_on_paginated_post"><?php _e( 'Paginated posts/pages', 'pagination' ); ?></label><br />
                            <?php if ( ! $this->hide_pro_tabs ) { ?>
                                <div class="bws_pro_version_bloc">
                                    <div class="bws_pro_version_table_bloc">
                                        <button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'pagination' ); ?>"></button>
                                        <div class="bws_table_bg"></div>
                                        <table class="form-table bws_pro_version">
                                            <tr valign="top">
                                            	<label>
		                                            <input disabled="disabled" type="checkbox" value="paginated_divi" name="pgntn_where_display[]" />
		                                            <?php _e( 'Paginated Divi modules', 'pagination' ); ?>
		                                        </label>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php $this->bws_pro_block_links(); ?>
                                </div>
                            <?php } ?>
						</fieldset>
					</td>
				</tr>
                <tr>
                    <th scope="row"><?php _e( 'Hide Standard Pagination for', 'pagination' ); ?>
                    </th>
                    <td>
                        <fieldset class="pgntn_input">
                            <input<?php echo $this->change_permission_attr; ?> id="pgntn_display_posts_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='posts' <?php if ( ( ! empty( $this->options['display_standard_pagination'] ) ) && in_array( 'posts', $this->options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> />
                            <label for="pgntn_display_posts_pagination"><?php _e( 'Posts', 'pagination' ); ?></label><br />
                            <input<?php echo $this->change_permission_attr; ?> id="pgntn_display_multipage_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='multipage' <?php if ( ( ! empty( $this->options['display_standard_pagination'] ) ) && in_array( 'multipage', $this->options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> />
                            <label for="pgntn_display_multipage_pagination"><?php _e( 'Paginated posts/pages', 'pagination' ); ?></label><br />
                            <input<?php echo $this->change_permission_attr; ?> id="pgntn_display_comments_pagination" name='pgntn_display_standard_pagination[]' type='checkbox' value='comments' <?php if ( ( ! empty( $this->options['display_standard_pagination'] ) ) && in_array( 'comments', $this->options['display_standard_pagination'] ) ) echo 'checked="checked"'; ?> />
                            <label for="pgntn_display_comments_pagination"><?php _e( 'Comments', 'pagination' ); ?></label>
                            <br/><span class="bws_info"> <?php _e( 'Used for standard WordPress themes or themes, which use standard CSS-classes to display pagination blocks.', 'pagination' ); ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e( 'Hide Custom Pagination', 'pagination' ); ?>
                    </th>
                    <td>
                        <fieldset>
                            <label>
                                <input<?php echo $this->change_permission_attr; ?> id="pgntn_display_custom_pagination" class="bws_option_affect" data-affect-show=".pgntn_input_custom" name='pgntn_display_custom_pagination' type='checkbox' value='1' <?php checked( 1, $this->options['display_custom_pagination'] ); ?> />
                            </label>
                            <span class="bws_info"> <?php _e(
                                    __( 'Enable to add one (or more comma-separated) CSS-classes or ID of blocks which you would like to hide.', 'pagination' ) ); ?></span>
                            <div class="pgntn_input_custom">
                            <label>
                                <input<?php echo $this->change_permission_attr; ?> type="text" maxlength='250' value="<?php echo $this->options['additional_pagination_style']; ?>" id="pgntn_additional_pagination_style" class="pgntn_input_custom" name="pgntn_additional_pagination_style" <?php disabled( 0, $this->options['display_custom_pagination'] ); ?>/>
                            </label>
                            <br />
                            <span class="bws_info"> <?php _e(
                                    __( 'Example', 'pagination' ) . ':<br />
							<code>#nav_block</code><br />' .
                                    __( "or", 'pagination' ) . '<br />
							<code>.pagination</code><br />' .
                                    __( "or", 'pagination' ) . '<br />
							<code>#nav_block, .pagination</code>'
                                ); ?></span>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e( 'Nofollow Link', 'pagination' ); ?></th>
                    <td>
                        <fieldset>
                            <input<?php echo $this->change_permission_attr; ?> type="checkbox" name="pgntn_nofollow_attribute" id="pgntn_nofollow_attribute" <?php checked( $this->options['nofollow_link'] ); ?> />
                            <span class="bws_info"><?php _e( 'Enable to add a rel="nofollow" attribute to your anchor (aka link) tags to help Google bots identify such links (recommended).', 'pagination' ); ?></span>
                        </fieldset>
                    </td>
                </tr>
			</table>
			<?php if ( ! $this->hide_pro_tabs ) { ?>
				<div class="bws_pro_version_bloc">
					<div class="bws_pro_version_table_bloc">
						<button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'pagination' ); ?>"></button>
						<div class="bws_table_bg"></div>
						<table class="form-table bws_pro_version">
							<tr valign="top">
								<th scope="row"><?php _e( 'Pagination Type', 'pagination' ); ?></th>
								<td>
									<fieldset>
										<label>
											<input disabled="disabled" type="radio" value="numeric" name="pgntn_type" checked="checked" /><?php _e( 'Numeric', 'pagination' ); ?>
										</label><br />
										<label>
											<input disabled="disabled" type="radio" value="load-more" name="pgntn_type" /><?php _e( '"Load More" button', 'pagination' ); ?>
											<br/><span class="bws_info"> <?php _e( 'A single AJAX button.', 'pagination' ); ?></span>
										</label><br />
										<label>
											<input disabled="disabled" type="radio" value="infinite-scroll" name="pgntn_type" /><?php _e( 'Infinite scroll', 'pagination' ); ?>
											<br/><span class="bws_info"> <?php _e( 'An option that loads content continuously as the user scrolls down the page.', 'pagination' ); ?></span>
                                        </label><br />
                                        <label>
                                            <input disabled="disabled" type="radio" value="continue" name="pgntn_type" /> <?php _e( 'Next/Previous buttons', 'pagination' ); ?>
                                        </label>
                                    </fieldset>
								</td>
							</tr>
						</table>
					</div>
					<?php $this->bws_pro_block_links(); ?>
				</div>
			<?php } ?>
			<table class="form-table">
                <div class="bws_tab_sub_label pgntn_type_numeric_label"><?php _e( 'Numeric Pagination', 'pagination' ); ?></div>
				<tr valign="top">
					<th scope="row"><?php _e( 'Pagination Position', 'pagination' ); ?></th>
					<td>
						<select name="pgntn_loop_position">
							<option value="top"<?php echo "top" == $this->options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'Above content', 'pagination' ); ?></option>
							<option value="bottom"<?php echo "bottom" == $this->options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'Below content', 'pagination' ); ?></option>
							<option value="both"<?php echo "both" == $this->options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'Above & below content', 'pagination' ); ?></option>
							<option value="function"<?php echo "function" == $this->options['loop_position'] ? ' selected="selected"' : "";?>><?php _e( 'Custom function position', 'pagination' ); ?></option>
						<select>
                        <br/><span class="bws_info"><?php _e( 'Select pagination position in the main content.', 'pagination' ); ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for ="pgntn_display_info"><?php _e( "Current (Total) Page Count", 'pagination' ); ?></label></th>
					<td>
						<input type="checkbox" value="1" id="pgntn_display_info" name="pgntn_display_info"<?php echo 1 == $this->options ['display_info'] ? ' checked="checked"' : ''; ?> />
                        <span class="bws_info"><?php _e( 'Enable to display current page and total page count (for example, Page 3 of 7).', 'pagination' ); ?></span>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for ="pgntn_display_next_prev"><?php _e( 'Next & Previous Buttons', 'pagination' ); ?></label></th>
					<td>
						<input type="checkbox" value="1" id="pgntn_display_next_prev" class="bws_option_affect" data-affect-show=".pgntn_links_text" name="pgntn_display_next_prev"<?php echo 1 == $this->options ['display_next_prev'] ? ' checked="checked"' : ''; ?> />
                        <span class="bws_info"><?php _e( 'Enable to display next and previous page buttons.', 'pagination' ); ?></span>
                        <br />
						<div class="pgntn_links_text">
                            <br /><span class="bws_info"><?php _e( 'Previous', 'pagination' ); ?></span><br /><input type="text" maxlength='250' value="<?php echo $this->options ['prev_text']; ?>"<?php echo 0 == $this->options ['display_next_prev'] ? 'disabled="disabled"' : ''; ?> name="pgntn_prev_text" id="pgntn_prev_text" />
                        </div>
                        <div class="pgntn_links_text">
                            <span class="bws_info"><?php _e( 'Next', 'pagination' ); ?></span><br /><input type="text" maxlength='250' value="<?php echo $this->options ['next_text']; ?>"<?php echo 0 == $this->options ['display_next_prev'] ? 'disabled="disabled"' : ''; ?> name="pgntn_next_text" id="pgntn_next_text" />
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e( 'Page Range', 'pagination' ); ?></th>
					<td>
                        <input type="number" min="0" step="1" value="<?php echo $this->options['display_count_page']; ?>"<?php echo 0 == $this->options['show_all'] ; ?> id="pgntn_display_count_page" name="pgntn_display_count_page" />
                        <br/><span class="bws_info"><?php _e( 'The number of page links/buttons to show before and after the current page (set to "0" if you want to display all buttons).', 'pagination' ); ?></span>
					</td>
				</tr>
			</table>
            <div class="bws_tab_sub_label pgntn_add_appearance_checkbox"><?php _e( 'Custom Styles', 'pagination' ); ?></div>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e( 'Custom Pagination Style', 'pagination' ); ?></th>
                    <td>
                        <input type="checkbox" value="1" class="bws_option_affect" data-affect-show=".pgntn_add_appearance" <?php checked( $this->options['add_appearance'] ); ?> name="pgntn_add_appearance" />
                        <span class="bws_info"><?php _e( 'Enable to apply custom CSS styles for pagination.', 'pagination' ); ?></span>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Page Pagination Block width', 'pagination' ); ?></th>
                    <td>
                        <input type="number" step="1" min="0" max="100" value="<?php echo $this->options['width']; ?>" id="pgntn_width" name="pgntn_width" <?php disabled( $this->options['add_appearance'], 0 ); ?> /><span class="bws_info">%</span>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Pagination Align', 'pagination' ); ?></th>
                    <td>
                        <fieldset>
                            <input type="radio" value="left" <?php checked( $this->options['align'], 'left' ); ?> id="pgntn_align_left" name="pgntn_align" <?php disabled( $this->options['add_appearance'], 0 ); ?> />
                            <label for="pgntn_align_left"><?php _e( 'Left', 'pagination' ); ?></label><br />
                            <input type="radio" value="center" <?php checked( $this->options['align'], 'center' ); ?> id="pgntn_align_center" name="pgntn_align" <?php disabled( $this->options['add_appearance'], 0 ); ?> /> <label for="pgntn_align_center"><?php _e( 'Center', 'pagination' ); ?></label><br />
                            <input type="radio" value="right" <?php checked( $this->options['align'], 'right' ); ?> id="pgntn_align_right" name="pgntn_align" <?php disabled( $this->options['add_appearance'], 0 ); ?> />
                            <label for="pgntn_align_right"><?php _e( 'Right', 'pagination' ); ?></label>
                        </fieldset>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance pgntn_center_padding_hide">
                    <th scope="row"><?php _e( 'Left Padding', 'pagination' ); ?></th>
                    <td>
                        <input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $this->options['padding_left'] ) ? $this->options['padding_left'] : '0'; ?>" id="pgntn_padding_left" class="pgntn_padding" name="pgntn_padding_left"<?php echo ( 'center' == $this->options['align'] || 0 == $this->options['add_appearance'] ) ? ' disabled="disabled"': '';?> />&nbsp;<span class="bws_info">px</span>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance pgntn_center_padding_hide">
                    <th scope="row"><?php _e( 'Right Padding', 'pagination' ); ?></th>
                    <td>
                        <input type="number" step="1" min="0" max="10000" value="<?php echo ! empty( $this->options['padding_right'] ) ? $this->options['padding_right'] : '0'; ?>" id="pgntn_padding_right" class="pgntn_padding" name="pgntn_padding_right"<?php echo ( 'center' == $this->options['align'] || 0 == $this->options['add_appearance'] ) ? ' disabled="disabled"': '';?> />&nbsp;<span class="bws_info">px</span>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Background Color', 'pagination' ); ?></th>
                    <td>
                        <input type="text" value="<?php echo $this->options['background_color']; ?>" name="pgntn_background_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['background_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Background Color for Current Page', 'pagination' ); ?> </th>
                    <td>
                        <input type="text" value="<?php echo $this->options['current_background_color']; ?>" name="pgntn_current_background_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['current_background_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Text Color for Page', 'pagination' ); ?></th>
                    <td>
                        <input type="text" value="<?php echo $this->options['text_color']; ?>" name="pgntn_text_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['text_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Text Color for Current Page', 'pagination' ); ?> </th>
                    <td>
                        <input type="text" value="<?php echo $this->options['current_text_color']; ?>" name="pgntn_current_text_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['current_text_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Hover Color', 'pagination' ); ?></th>
                    <td>
                        <input type="text" value="<?php echo $this->options['hover_color']; ?>" name="pgntn_hover_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['hover_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Border Color', 'pagination' ); ?></th>
                    <td>
                        <input type="text" value="<?php echo $this->options['border_color']; ?>" name="pgntn_border_color" class="pgntn_color_picker" data-default-color="<?php echo $this->default_options['border_color']; ?>"<?php disabled( $this->options['add_appearance'], 0 ); ?> />
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Border Width', 'pagination' ); ?></th>
                    <td>
                        <input type="number" step="1" min="0" max="100" value="<?php echo ! empty( $this->options['border_width'] ) ? $this->options['border_width'] : '0'; ?>" id="pgntn_border_width" name="pgntn_border_width"<?php disabled( $this->options['add_appearance'], 0 ); ?> />&nbsp;<span class="bws_info">px</span>
                    </td>
                </tr>
                <tr class="pgntn_add_appearance">
                    <th scope="row"><?php _e( 'Border Radius', 'pagination' ); ?></th>
                    <td>
                        <input type="number" step="1" min="0" max="100" value="<?php echo ! empty( $this->options['border_radius'] ) ? $this->options['border_radius'] : '0'; ?>" id="pgntn_border_radius" name="pgntn_border_radius" <?php disabled( $this->options['add_appearance'], 0 ); ?> />&nbsp;<span class="bws_info">px</span>
                    </td>
                </tr>
            </table>
		<?php }

		/**
		 * Display custom metabox
		 * @access public
		 * @param void
		 * @return array The action results
		 */
		public function display_metabox() { ?>
			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Pagination', 'pagination' ); ?>
				</h3>
				<div class="inside">
					<?php _e( 'If you would like to display pagination block in a different place on your site, add the following strings into the file', 'pagination' ); ?>&nbsp;<i>index.php</i>&nbsp;<?php _e( 'of your theme', 'pagination' ); ?>:<br />
					<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'posts' );</code>
				</div>
				<div class="inside">
					<?php _e( 'If you would like to display pagination block for paginated posts or pages in a different place on your site, add the following strings into the appropriate templates source code of your theme', 'pagination' ); ?>:<br />
					<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'multipage' );</code>
				</div>
				<div class="inside">
					<?php _e( 'Paste this into the comments template if you want to display pagination for comments', 'pagination' ); ?>:<br/>
					<code>if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'comments' );</code>
				</div>
			</div>
		<?php }
	}
}
