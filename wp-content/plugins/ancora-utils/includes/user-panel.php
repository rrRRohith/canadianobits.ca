<?php 
global $ANCORA_GLOBALS;
if (empty($ANCORA_GLOBALS['menu_user']))
	$ANCORA_GLOBALS['menu_user'] = ancora_get_nav_menu('menu_user');
if (empty($ANCORA_GLOBALS['menu_user'])) {
	?>
	<ul id="menu_user" class="menu_user_nav">
    <?php
} else {
	$menu = ancora_substr($ANCORA_GLOBALS['menu_user'], 0, ancora_strlen($ANCORA_GLOBALS['menu_user'])-5);
	$pos = ancora_strpos($menu, '<ul');
	if ($pos!==false) $menu = ancora_substr($menu, 0, $pos+3) . ' class="menu_user_nav"' . ancora_substr($menu, $pos+3);
	echo str_replace('class=""', '', $menu);
}
?>

<?php if (ancora_is_woocommerce_page() && ancora_get_custom_option('show_currency')=='yes') { ?>
	<li class="menu_user_currency">
		<a href="#">$</a>
		<ul>
			<li><a href="#"><b>&#36;</b> <?php esc_html_e('Dollar', 'blessing'); ?></a></li>
			<li><a href="#"><b>&euro;</b> <?php esc_html_e('Euro', 'blessing'); ?></a></li>
			<li><a href="#"><b>&pound;</b> <?php esc_html_e('Pounds', 'blessing'); ?></a></li>
		</ul>
	</li>
<?php } ?>

<?php if (ancora_exists_woocommerce() && (ancora_is_woocommerce_page() && ancora_get_custom_option('show_cart')=='shop' || ancora_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) { ?>
	<li class="menu_user_cart">
		<a href="#" class="cart_button"><span><?php esc_html_e('Cart', 'blessing'); ?></span> <b class="cart_total"><?php echo WC()->cart->get_cart_subtotal(); ?></b></a>
			<ul class="widget_area sidebar_cart sidebar"><li>
				<?php
				do_action( 'before_sidebar' );
				$ANCORA_GLOBALS['current_sidebar'] = 'cart';
				if ( ! dynamic_sidebar( 'sidebar-cart' ) ) { 
					the_widget( 'WC_Widget_Cart', 'title=&hide_if_empty=1' );
				}
				?>
			</li></ul>
	</li>
<?php } ?>

<?php if (ancora_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
	$languages = icl_get_languages('skip_missing=1');
	if (!empty($languages)) {
		$lang_list = '';
		$lang_active = '';
		foreach ($languages as $lang) {
			$lang_title = esc_attr($lang['translated_name']);	
			if ($lang['active']) {
				$lang_active = $lang_title;
			}
			$lang_list .= "\n".'<li><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
				.'<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang_title) . '" title="' . esc_attr($lang_title) . '" />'
				. ($lang_title)
				.'</a></li>';
		}
		?>
		<li class="menu_user_language">
			<a href="#"><span><?php ancora_show_layout($lang_active); ?></span></a>
			<ul><?php ancora_show_layout($lang_list); ?></ul>
		</li>
<?php
	}
}



if (ancora_get_custom_option('show_bookmarks')=='yes') {
	// Load core messages
	ancora_enqueue_messages();
	?>
	<li class="menu_user_bookmarks"><a href="#" class="bookmarks_show icon-star-1" title="<?php esc_html_e('Show bookmarks', 'blessing'); ?>"></a>
	<?php 
		$list = ancora_get_value_gpc('ancora_bookmarks', '');
		if (!empty($list)) $list = json_decode($list, true);
		?>
		<ul class="bookmarks_list">
			<li><a href="#" class="bookmarks_add icon-star-empty" title="<?php esc_html_e('Add the current page into bookmarks', 'blessing'); ?>"><?php esc_html_e('Add bookmark', 'blessing'); ?></a></li>
			<?php 
			if (!empty($list)) {
				foreach ($list as $bm) {
					echo '<li><a href="'.esc_url($bm['url']).'" class="bookmarks_item">'.($bm['title']).'<span class="bookmarks_delete icon-cancel-1" title="'.esc_html__('Delete this bookmark', 'blessing').'"></span></a></li>';
				}
			}
			?>
		</ul>
	</li>
	<?php 
}


if (ancora_get_custom_option('show_login')=='yes') {
	if ( !is_user_logged_in() ) {
		// Load core messages
		ancora_enqueue_messages();
		// Load Popup engine
		ancora_enqueue_popup();
		?>
		<li class="menu_user_register"><a href="#popup_registration" class="popup_link popup_register_link"><?php esc_html_e('Register', 'blessing'); ?></a><?php
			if (ancora_get_theme_option('show_login')=='yes') {
				require_once( trx_utils_get_file_dir('includes/register.php') );
			}?></li>
		<li class="menu_user_login"><a href="#popup_login" class="popup_link popup_login_link"><?php esc_html_e('Login', 'blessing'); ?></a><?php
			if (ancora_get_theme_option('show_login')=='yes') {
                require_once( trx_utils_get_file_dir('includes/login.php') );
			}?></li>
		<?php 
	} else {
		$current_user = wp_get_current_user();
		?>
		<li class="menu_user_controls">
			<a href="#"><?php
				$user_avatar = '';
				if ($current_user->user_email) $user_avatar = get_avatar($current_user->user_email, 16*min(2, max(1, ancora_get_theme_option("retina_ready"))));
				if ($user_avatar) {
					?><span class="user_avatar"><?php ancora_show_layout($user_avatar); ?></span><?php
				}?><span class="user_name"><?php ancora_show_layout($current_user->display_name); ?></span></a>
			<ul>
				<?php if (current_user_can('publish_posts')) { ?>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-doc-inv"><?php esc_html_e('New post', 'blessing'); ?></a></li>
				<?php } ?>
				<li><a href="<?php echo esc_url(get_edit_user_link()); ?>" class="icon icon-cog-1"><?php esc_html_e('Settings', 'blessing'); ?></a></li>
			</ul>
		</li>
		<li class="menu_user_logout"><a href="<?php echo esc_url(wp_logout_url( home_url( '/' ) )); ?>" class="icon icon-logout"><?php esc_html_e('Logout', 'blessing'); ?></a></li>
		<?php 
	}
}
?>

</ul>
