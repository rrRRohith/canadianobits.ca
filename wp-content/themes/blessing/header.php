<?php
/**
 * The Header for our theme.
 */

global $ANCORA_GLOBALS;

// Theme init - don't remove next row! Load custom options
ancora_core_init_theme();

$theme_skin = sanitize_file_name(ancora_get_custom_option('theme_skin'));
$blog_style = ancora_get_custom_option(is_singular() && !ancora_get_global('blog_streampage') ? 'single_style' : 'blog_style');
$body_style  = ancora_get_custom_option('body_style');
$logo_style = ancora_get_custom_option('top_panel_style');
$article_style = ancora_get_custom_option('article_style');
$top_panel_style = ancora_get_custom_option('top_panel_style');
$top_panel_opacity = ancora_get_custom_option('top_panel_opacity');
$top_panel_position = ancora_get_custom_option('top_panel_position');
$video_bg_show  = ancora_get_custom_option('show_video_bg')=='yes' && (ancora_get_custom_option('video_bg_youtube_code')!='' || ancora_get_custom_option('video_bg_url')!='');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	wp_head();
	?>
</head>

<?php
	$class = $style = '';
	if ($body_style=='boxed' || ancora_get_custom_option('load_bg_image')=='always') {
		$customizer = ancora_get_theme_option('show_theme_customizer') == 'yes';
		if ($customizer && ($img = (int) ancora_get_value_gpc('bg_image', 0)) > 0)
			$class = 'bg_image_'.($img);
		else if ($customizer && ($img = (int) ancora_get_value_gpc('bg_pattern', 0)) > 0)
			$class = 'bg_pattern_'.($img);
		else if ($customizer && ($img = ancora_get_value_gpc('bg_color', '')) != '')
        $style = 'background-color: '.($img).';';
		else {
			if (($img = ancora_get_custom_option('bg_custom_image')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', ancora_get_custom_option('bg_custom_image_position')) . ' no-repeat fixed;';
			else if (($img = ancora_get_custom_option('bg_custom_pattern')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = ancora_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = ancora_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = ancora_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
	}
?>

<body <?php body_class() ?>>
<?php wp_body_open(); ?>
	<?php ancora_show_layout(ancora_get_custom_option('gtm_code')); ?>

	<?php do_action( 'before' ); ?>

	<?php
    if (function_exists('ancora_require_shortcode')) {
        if (ancora_get_custom_option('menu_toc_home')=='yes') echo do_shortcode( '[trx_anchor id="toc_home" title="'.__('Home', 'blessing').'" description="'.__('{Return to Home} - |navigate to home page of the site', 'blessing').'" icon="icon-home-1" separator="yes" url="'.esc_url( home_url( '/' ) ).'"]' );
        if (ancora_get_custom_option('menu_toc_top')=='yes') echo do_shortcode( '[trx_anchor id="toc_top" title="'.__('To Top', 'blessing').'" description="'.__('{Back to top} - |scroll to top of the page', 'blessing').'" icon="icon-angle-double-up" separator="yes"]' );
    }
    ?>

	<div class="body_wrap">

		<?php
		if ($video_bg_show) {
			$youtube = ancora_get_custom_option('video_bg_youtube_code');
			$video   = ancora_get_custom_option('video_bg_url');
			$overlay = ancora_get_custom_option('video_bg_overlay')=='yes';
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php ancora_show_layout($overlay ? ' video_bg_overlay' : ''); ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo esc_attr($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			// Top panel and Slider
			if (in_array($top_panel_position, array('above', 'over'))) { require_once( ancora_get_file_dir('templates/parts/top-panel.php') ); }
			require_once( ancora_get_file_dir('templates/parts/slider.php') );
			if ($top_panel_position == 'below') { require_once( ancora_get_file_dir('templates/parts/top-panel.php') ); }

			// User custom header
			if (ancora_get_custom_option('show_user_header') == 'yes') {
				$user_header = ancora_strclear(ancora_get_custom_option('user_header_content'), 'p');
				if (!empty($user_header)) {
					$user_header = ancora_substitute_all($user_header);
					?>
					<div class="user_header_wrap"><?php ancora_show_layout($user_header); ?></div>
					<?php
				}
			}

			// Top of page section: page title and breadcrumbs
			$header_style = '';
			if ($top_panel_style=='light') {
				$header_image2 = get_header_image();
				$header_color = ancora_get_custom_option('show_page_top') == 'yes' ? apply_filters('ancora_filter_get_link_color', ancora_get_custom_option('top_panel_bg_color')) : '';
				if (empty($header_image2) && file_exists(ancora_get_file_dir('skins/'.($theme_skin).'/images/top_bg.jpg'))) {
					$header_image2 = ancora_get_file_url('skins/'.($theme_skin).'/images/top_bg.jpg');
				}
				if ($header_image2!='' || $header_color != '') {
					$header_style = ' style="' . ($header_image2!='' ? 'background-image: url('.esc_url($header_image2).'); background-repeat: repeat-x; background-position: center top;' : '') . ($header_color ? ';' : '') . '"';
				}
			}
			if (ancora_get_custom_option('show_page_top') == 'yes') {
				$show_title = ancora_get_custom_option('show_page_title')=='yes';
				$show_breadcrumbs = ancora_get_custom_option('show_breadcrumbs')=='yes';
				?>
                <?php if(!is_home()){ ?>
				<div class="page_top_wrap<?php ancora_show_layout(($show_title ? ' page_top_title' : '') . ($show_breadcrumbs ? ' page_top_breadcrumbs' : '')); ?>"<?php ancora_show_layout($header_style); ?>>
					<div class="content_wrap">
                        <?php if ($show_breadcrumbs) { ?>
                            <div class="breadcrumbs">
                                <?php if (!is_404()) ancora_show_breadcrumbs(); ?>
                            </div>
                        <?php } ?>
                        <?php if ($show_title) { ?>
                            <h1 class="page_title"><?php echo wp_kses_post(ancora_get_blog_title()); ?></h1>
                        <?php } ?>
					</div>
				</div>
                <?php } ?>
			<?php
			}
			?>

			<div class="page_content_wrap"<?php echo (ancora_get_custom_option('show_page_top') == 'no' ? ' ' . trim($header_style) : ''); ?>>

				<?php
				// Content and sidebar wrapper
				if ($body_style!='fullscreen') ancora_open_wrapper('<div class="content_wrap">');
				
				// Main content wrapper
				ancora_open_wrapper('<div class="content">');
				?>