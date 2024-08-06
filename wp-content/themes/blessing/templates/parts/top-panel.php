<?php
// WP custom header
$header_image = $header_image2 = $header_color = '';
if (($header_image = get_header_image()) == '') {
	$header_image = ancora_get_custom_option('top_panel_bg_image');
}
$header_color = apply_filters('ancora_filter_get_link_color', ancora_get_custom_option('top_panel_bg_color'));

$header_style = $top_panel_opacity!='transparent' && ($header_image!='' || $header_image2!='' || $header_color!='')
	? ' style="background: '
	  . ($header_image2!='' ? 'url('.esc_url($header_image2).') repeat center bottom' : '')
	  . ($header_image!=''  ? ($header_image2!='' ? ',' : '') . 'url('.esc_url($header_image).') repeat center top' : '')
	  . ($header_color!=''  ? ($header_color).';' : '')
	  .'"'
	: '';
?>

<div class="top_panel_fixed_wrap"></div>

<header class="top_panel_wrap bg_tint_<?php echo esc_attr($top_panel_style); ?>" <?php ancora_show_layout($header_style); ?>>


    <?php if (ancora_get_custom_option('show_menu_user')=='yes' && function_exists('ancora_reviews_theme_setup')) { ?>

        <div class="menu_user_wrap">
            <div class="content_wrap clearfix">
                <div class="menu_user_area menu_user_right menu_user_nav_area">
                    <?php require_once trx_utils_get_file_dir('includes/user-panel.php'); ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="border_bottom_grey font_086em display_none">
        <div class="content_wrap clearfix top_div">
            <div class="inline bottom">
                <?php echo wp_kses_post(ancora_get_custom_option('disclaimer')); ?>
            </div>
            <div class="inline bottom side-right">
                <?php
                if (ancora_get_custom_option('show_contact_info')=='yes') { ?>
                    <div class="menu_user_area menu_user_left menu_user_contact_area"><?php echo wp_kses_post(force_balance_tags(trim(ancora_get_custom_option('contact_info')))); ?></div>
                <?php } ?>
            </div>
            <div class="inline side-right search_s">
                <?php if (ancora_get_custom_option('show_search')=='yes') echo(do_shortcode('[trx_search open="no"]')); ?>
            </div>
        </div>
    </div>

    <div class="menu_main_wrap logo_<?php echo wp_kses_post(esc_attr(ancora_get_custom_option('logo_align'))); ?><?php echo wp_kses_post(($ANCORA_GLOBALS['logo_text'] ? ' with_text' : '')); ?>">
        <div class="content_wrap clearfix display_none">

            <div class="logo">
                <div class="logo_img">
                    <a href="<?php echo esc_url(wp_kses_post( home_url( '/' ) )); ?>">
                        <?php echo wp_kses_post(!empty($ANCORA_GLOBALS['logo_'.($logo_style)]) ? '<img src="'.esc_url($ANCORA_GLOBALS['logo_'.($logo_style)]).'" class="logo_main" alt="'.esc_attr__('img', 'blessing').'"><img src="'.esc_url($ANCORA_GLOBALS['logo_fixed']).'" class="logo_fixed" alt="'.esc_attr__('img', 'blessing').'">' : ''); ?>
                    </a>
                </div>
                <div class="contein_logo_text">
                    <a href="<?php echo esc_url(wp_kses_post( home_url( '/' ) )); ?>">
                        <?php echo wp_kses_post($ANCORA_GLOBALS['logo_text'] ? '<span class="logo_text">'.($ANCORA_GLOBALS['logo_text']).'</span>' : '<span class="logo_text">'.get_bloginfo().'</span>'); ?>
                        <?php echo wp_kses_post($ANCORA_GLOBALS['logo_slogan'] ? '<span class="logo_slogan">' . esc_html($ANCORA_GLOBALS['logo_slogan']) . '</span>' : ''); ?>
                    </a>
                </div>
            </div>

                <a href="#" class="menu_main_responsive_button icon-menu-1"></a>
                <div class="inline image side-right marg_top_2em">
                    <?php
                        if(ancora_get_custom_option('show_number_block') == 'yes') {
                            ?>
                            <div class="inline">
                                <img src="<?php
                                    $img1 = ancora_get_custom_option('number_image');
                                    if(empty($img1))  $img1 = ancora_get_file_url('skins/' . ($theme_skin) . '/images/phone.jpg');
                                    echo wp_kses_post($img1);
                                ?>" alt="'.esc_attr__('img', 'blessing').'">
                                <div class="side-right marg_null marg_top">
                                    <h4><a href="tel:<?php esc_url(ancora_show_layout(ancora_get_custom_option('contact_phone'))) ?>"><?php echo wp_kses_post(force_balance_tags(trim(ancora_get_custom_option('contact_phone')))); ?></a></h4>
                                    <span class="font_086em"><?php echo wp_kses_post(ancora_get_custom_option('text_under_number_title')); ?></span>
                                </div>
                            </div>

                        <?php
                        }
                        if(ancora_get_custom_option('show_flower_block') == 'yes') {
                            ?>
                            <div class="inline pad_left_2em">
                                <img src="<?php
                                $img1 = ancora_get_custom_option('flower_image');
                                if(empty($img1))  $img1 = ancora_get_file_url('skins/' . ($theme_skin) . '/images/flower.jpg');
                                echo wp_kses_post($img1);
                                ?>" alt="'.esc_attr__('img', 'blessing').'">
                                <div class="side-right marg_null marg_top">
                                    <h4><a href="<?php esc_url(ancora_show_layout(ancora_get_custom_option('link_under_flower_title'))) ?>"><?php echo wp_kses_post(ancora_get_custom_option('flower_title')); ?></a></h4>
                                    <span class="font_086em"><?php echo wp_kses_post(ancora_get_custom_option('text_under_flower_title')); ?></span>
                                </div>
                            </div>
                        <?php
                        }
                    ?>
                </div>
            </div>

            <nav role="navigation" class="menu_main_nav_area">
                <?php
                if (empty($ANCORA_GLOBALS['menu_main'])) $ANCORA_GLOBALS['menu_main'] = ancora_get_nav_menu('menu_main');
                if (empty($ANCORA_GLOBALS['menu_main'])) $ANCORA_GLOBALS['menu_main'] = ancora_get_nav_menu();
                ancora_show_layout($ANCORA_GLOBALS['menu_main']);
                ?>
            </nav>
        </div>

</header>
