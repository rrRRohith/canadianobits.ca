<?php
/**
 * ANCORA Shortcodes
*/


// ---------------------------------- [trx_accordion] ---------------------------------------

add_shortcode ('trx_accordion', 'ancora_sc_accordion');

/*
[trx_accordion style="1" counter="off" initial="1"]
	[trx_accordion_item title="Accordion Title 1"]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 2"]Proin dignissim commodo magna at luctus. Nam molestie justo augue, nec eleifend urna laoreet non.[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 3 with custom icons" icon_closed="icon-check-2" icon_opened="icon-delete-2"]Curabitur tristique tempus arcu a placerat.[/trx_accordion_item]
[/trx_accordion]
*/
function ancora_sc_accordion($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "1",
		"initial" => "1",
		"counter" => "off",
		"icon_closed" => "icon-ok",
		"icon_opened" => "icon-ok",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$style = max(1, min(2, $style));
	$initial = max(0, (int) $initial);
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_accordion_counter'] = 0;
	$ANCORA_GLOBALS['sc_accordion_show_counter'] = ancora_sc_param_is_on($counter);
	$ANCORA_GLOBALS['sc_accordion_icon_closed'] = empty($icon_closed) || ancora_sc_param_is_inherit($icon_closed) ? "icon-plus-2" : $icon_closed;
	$ANCORA_GLOBALS['sc_accordion_icon_opened'] = empty($icon_opened) || ancora_sc_param_is_inherit($icon_opened) ? "icon-minus-2" : $icon_opened;
	wp_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_accordion sc_accordion_style_'.esc_attr($style)
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. (ancora_sc_param_is_on($counter) ? ' sc_show_counter' : '')
			. '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. ' data-active="' . ($initial-1) . '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
			. do_shortcode($content)
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_accordion', $atts, $content);
}


add_shortcode ('trx_accordion_item', 'ancora_sc_accordion_item');

function ancora_sc_accordion_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"icon_closed" => "",
		"icon_opened" => "",
		"title" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_accordion_counter']++;
	if (empty($icon_closed) || ancora_sc_param_is_inherit($icon_closed)) $icon_closed = $ANCORA_GLOBALS['sc_accordion_icon_closed'] ? $ANCORA_GLOBALS['sc_accordion_icon_closed'] : "icon-plus-2";
	if (empty($icon_opened) || ancora_sc_param_is_inherit($icon_opened)) $icon_opened = $ANCORA_GLOBALS['sc_accordion_icon_opened'] ? $ANCORA_GLOBALS['sc_accordion_icon_opened'] : "icon-minus-2";
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_accordion_item' 
			. (!empty($class) ? ' '.esc_attr($class) : '')
			. ($ANCORA_GLOBALS['sc_accordion_counter'] % 2 == 1 ? ' odd' : ' even')
			. ($ANCORA_GLOBALS['sc_accordion_counter'] == 1 ? ' first' : '')
			. '">'
			. '<h5 class="sc_accordion_title">'
			. (!ancora_sc_param_is_off($icon_closed) ? '<span class="sc_accordion_icon sc_accordion_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
			. (!ancora_sc_param_is_off($icon_opened) ? '<span class="sc_accordion_icon sc_accordion_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
			. ($ANCORA_GLOBALS['sc_accordion_show_counter'] ? '<span class="sc_items_counter">'.($ANCORA_GLOBALS['sc_accordion_counter']).'</span>' : '')
			. ($title)
			. '</h5>'
			. '<div class="sc_accordion_content"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. '>'
				. do_shortcode($content) 
			. '</div>'
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_accordion_item', $atts, $content);
}

// ---------------------------------- [/trx_accordion] ---------------------------------------






// ---------------------------------- [trx_anchor] ---------------------------------------

add_shortcode ("trx_anchor", "ancora_sc_anchor");
						
/*
[trx_anchor id="unique_id" description="Anchor description" title="Short Caption" icon="icon-class"]
*/

function ancora_sc_anchor($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"title" => "",
		"description" => '',
		"icon" => '',
		"url" => "",
		"separator" => "no",
		// Common params
		"id" => ""
    ), $atts)));
	$output = $id 
		? '<a name="'.esc_attr($id).'" id="'.esc_attr($id).'"'
			. ' class="sc_anchor"' 
			. ' title="' . ($title ? esc_attr($title) : '') . '"'
			. ' data-description="' . ($description ? esc_attr(str_replace(array("{", "}", "|"), array("<i>", "</i>", "<br>"), $description))   : ''). '"'
			. ' data-icon="' . ($icon ? $icon : '') . '"' 
			. ' data-url="' . ($url ? esc_attr($url) : '') . '"' 
			. ' data-separator="' . (ancora_sc_param_is_on($separator) ? 'yes' : 'no') . '"'
			. '></a>'
		: '';
	return apply_filters('ancora_shortcode_output', $output, 'trx_anchor', $atts, $content);
}
// ---------------------------------- [/trx_anchor] ---------------------------------------





// ---------------------------------- [trx_audio] ---------------------------------------

add_shortcode ("trx_audio", "ancora_sc_audio");

/*
[trx_audio url="http://trex2.themerex.dnw/wp-content/uploads/2014/12/Dream-Music-Relax.mp3" image="http://trex2.themerex.dnw/wp-content/uploads/2014/10/post_audio.jpg" title="Insert Audio Title Here" author="Lily Hunter" controls="show" autoplay="off"]
*/

function ancora_sc_audio($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"title" => "",
		"author" => "",
        "style" => "",
		"image" => "",
		"mp3" => '',
		"wav" => '',
		"src" => '',
		"url" => '',
		"align" => '',
		"controls" => "",
		"autoplay" => "",
		"frame" => "on",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => '',
		"height" => '',
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	if ($src=='' && $url=='' && isset($atts[0])) {
		$src = $atts[0];
	}
	if ($src=='') {
		if ($url) $src = $url;
		else if ($mp3) $src = $mp3;
		else if ($wav) $src = $wav;
	}
	if ($image > 0) {
		$attach = wp_get_attachment_image_src( $image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$image = $attach[0];
	}
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$data = ($title != ''  ? ' data-title="'.esc_attr($title).'"'   : '')
			. ($author != '' ? ' data-author="'.esc_attr($author).'"' : '')
			. ($image != ''  ? ' data-image="'.esc_url($image).'"'   : '')
			. ($align && $align!='none' ? ' data-align="'.esc_attr($align).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '');
	$audio = '<audio'
		. ($id ? ' id="'.esc_attr($id).'"' : '')
		. ' class="sc_audio' . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
		. ' src="'.esc_url($src).'"'
		. (ancora_sc_param_is_on($controls) ? ' controls="controls"' : '')
		. (ancora_sc_param_is_on($autoplay) && is_single() ? ' autoplay="autoplay"' : '')
		. ' width="'.esc_attr($width).'" height="'.esc_attr($height).'"'
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
		. ($data)
		. '></audio>';
	if ( ancora_get_custom_option('substitute_audio')=='no') {
		if (ancora_sc_param_is_on($frame)) $audio = ancora_get_audio_frame($audio, $image, $s);
	} else {
		if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
			$audio = ancora_substitute_audio($audio, false);
		}
	}
	if (ancora_get_theme_option('use_mediaelement')=='yes')
		wp_enqueue_script('wp-mediaelement');
	return apply_filters('ancora_shortcode_output', $audio, 'trx_audio', $atts, $content);
}
// ---------------------------------- [/trx_audio] ---------------------------------------





// ---------------------------------- [trx_blogger] ---------------------------------------

add_shortcode ('trx_blogger', 'ancora_sc_blogger');

/*
[trx_blogger id="unique_id" ids="comma_separated_list" cat="id|slug" orderby="date|views|comments" order="asc|desc" count="5" descr="0" dir="horizontal|vertical" style="regular|date|image_large|image_medium|image_small|accordion|list" border="0"]
*/
global $ANCORA_GLOBALS;
$ANCORA_GLOBALS['sc_blogger_busy'] = false;

function ancora_sc_blogger($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger(true)) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "regular",
		"filters" => "no",
		"post_type" => "post",
		"ids" => "",
		"cat" => "",
		"count" => "3",
		"columns" => "",
		"offset" => "",
		"orderby" => "date",
		"order" => "desc",
		"only" => "no",
		"descr" => "",
		"readmore" => "",
		"loadmore" => "no",
		"location" => "default",
		"dir" => "horizontal",
		"hover" => ancora_get_theme_option('hover_style'),
		"hover_dir" => ancora_get_theme_option('hover_dir'),
		"scroll" => "no",
		"controls" => "no",
		"rating" => "no",
		"info" => "no",
		"links" => "yes",
		"date_format" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	$width  = ancora_prepare_css_value($width);
	$height = ancora_prepare_css_value($height);
	
	global $post, $ANCORA_GLOBALS;

	$ANCORA_GLOBALS['sc_blogger_busy'] = true;
	$ANCORA_GLOBALS['sc_blogger_counter'] = 0;

	if (empty($id)) $id = "sc_blogger_".str_replace('.', '', mt_rand());
	
	if ($style=='date' && empty($date_format)) $date_format = 'd.m+Y';

	if (!empty($ids)) {
		$posts = explode(',', str_replace(' ', '', $ids));
		$count = count($posts);
	}
	
	if ($descr == '') $descr = ancora_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : ''));

	if (!ancora_sc_param_is_off($scroll)) {
		ancora_enqueue_slider();
		if (empty($id)) $id = 'sc_blogger_'.str_replace('.', '', mt_rand());
	}
	
	$class = apply_filters('ancora_filter_blog_class',
				'sc_blogger'
				. ' layout_'.esc_attr($style)
				. ' template_'.esc_attr(ancora_get_template_name($style))
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ' ' . esc_attr(ancora_get_template_property($style, 'container_classes'))
				. ' sc_blogger_' . ($dir=='vertical' ? 'vertical' : 'horizontal')
				. (ancora_sc_param_is_on($scroll) && ancora_sc_param_is_on($controls) ? ' sc_scroll_controls sc_scroll_controls_type_top sc_scroll_controls_'.esc_attr($dir) : '')
				. ($descr == 0 ? ' no_description' : ''),
				array('style'=>$style, 'dir'=>$dir, 'descr'=>$descr)
	);

	$container = apply_filters('ancora_filter_blog_container', ancora_get_template_property($style, 'container'), array('style'=>$style, 'dir'=>$dir));
	$container_start = $container_end = '';
	if (!empty($container)) {
		$container = explode('%s', $container);
		$container_start = !empty($container[0]) ? $container[0] : '';
		$container_end = !empty($container[1]) ? $container[1] : '';
	}

	$output = ($style=='list' ? '<ul' : '<div')
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="'.esc_attr($class).'"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. '>'
		. ($container_start)
		. ($dir=='horizontal' && $columns > 1 && ancora_get_template_property($style, 'need_columns') ? '<div class="columns_wrap">' : '')
		. (ancora_sc_param_is_on($scroll)
			? '<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_'.esc_attr($dir).' sc_slider_noresize swiper-slider-container scroll-container"'
				. ' style="'.($dir=='vertical' ? 'height:'.($height != '' ? $height : "230px").';' : 'width:'.($width != '' ? $width.';' : "100%;")).'"'
				. '>'
				. '<div class="sc_scroll_wrapper swiper-wrapper">' 
					. '<div class="sc_scroll_slide swiper-slide">' 
			: '');

	if (ancora_get_template_property($style, 'need_isotope')) {
		if (!ancora_sc_param_is_off($filters))
			$output .= '<div class="isotope_filters"></div>';
		if ($columns<1) $columns = ancora_substr($style, -1);
		$output .= '<div class="isotope_wrap" data-columns="'.max(1, min(4, $columns)).'">';
	}

	$args = array(
		'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
		'posts_per_page' => $count,
		'ignore_sticky_posts' => true,
		'order' => $order=='asc' ? 'asc' : 'desc',
		'orderby' => 'date',
	);

	if ($offset > 0 && empty($ids)) {
		$args['offset'] = $offset;
	}

	$args = ancora_query_add_sort_order($args, $orderby, $order);
	if (!ancora_sc_param_is_off($only)) $args = ancora_query_add_filters($args, $only);
	$args = ancora_query_add_posts_and_cats($args, $ids, $post_type, $cat);

	$query = new WP_Query( $args );

	$flt_ids = array();

	while ( $query->have_posts() ) { $query->the_post();

		$ANCORA_GLOBALS['sc_blogger_counter']++;

		$args = array(
			'layout' => $style,
			'show' => false,
			'number' => $ANCORA_GLOBALS['sc_blogger_counter'],
			'add_view_more' => false,
			'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
			// Additional options to layout generator
			"location" => $location,
			"descr" => $descr,
			"readmore" => $readmore,
			"loadmore" => $loadmore,
			"reviews" => ancora_sc_param_is_on($rating),
			"dir" => $dir,
			"scroll" => ancora_sc_param_is_on($scroll),
			"info" => ancora_sc_param_is_on($info),
			"links" => ancora_sc_param_is_on($links),
			"orderby" => $orderby,
			"columns_count" => $columns,
			"date_format" => $date_format,
			// Get post data
			'strip_teaser' => false,
			'content' => ancora_get_template_property($style, 'need_content'),
			'terms_list' => !ancora_sc_param_is_off($filters) || ancora_get_template_property($style, 'need_terms'),
			'filters' => ancora_sc_param_is_off($filters) ? '' : $filters,
			'hover' => $hover,
			'hover_dir' => $hover_dir
		);
		$post_data = ancora_get_post_data($args);
		$output .= ancora_show_post_layout($args, $post_data);
	
		if (!ancora_sc_param_is_off($filters)) {
			if ($filters == 'tags') {			// Use tags as filter items
				if (!empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms)) {
					foreach ($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms as $tag) {
						$flt_ids[$tag->term_id] = $tag->name;
					}
				}
			}
		}

	}

	wp_reset_postdata();

	// Close isotope wrapper
	if (ancora_get_template_property($style, 'need_isotope'))
		$output .= '</div>';

	// Isotope filters list
	if (!ancora_sc_param_is_off($filters)) {
		$filters_list = '';
		if ($filters == 'categories') {			// Use categories as filter items
			$taxonomy = ancora_get_taxonomy_categories_by_post_type($post_type);
			$portfolio_parent = $cat ? max(0, ancora_get_parent_taxonomy_by_property($cat, 'show_filters', 'yes', true, $taxonomy)) : 0;
			$args2 = array(
				'type'			=> $post_type,
				'child_of'		=> $portfolio_parent,
				'orderby'		=> 'name',
				'order'			=> 'ASC',
				'hide_empty'	=> 1,
				'hierarchical'	=> 0,
				'exclude'		=> '',
				'include'		=> '',
				'number'		=> '',
				'taxonomy'		=> $taxonomy,
				'pad_counts'	=> false
			);
			$portfolio_list = get_categories($args2);
			if (count($portfolio_list) > 0) {
				$filters_list .= '<a href="#" data-filter="*" class="theme_button active">'.__('All', 'ancora-utils').'</a>';
				foreach ($portfolio_list as $cat) {
					$filters_list .= '<a href="#" data-filter=".flt_'.esc_attr($cat->term_id).'" class="theme_button">'.($cat->name).'</a>';
				}
			}
		} else {								// Use tags as filter items
			if (count($flt_ids) > 0) {
				$filters_list .= '<a href="#" data-filter="*" class="theme_button active">'.__('All', 'ancora-utils').'</a>';
				foreach ($flt_ids as $flt_id=>$flt_name) {
					$filters_list .= '<a href="#" data-filter=".flt_'.esc_attr($flt_id).'" class="theme_button">'.($flt_name).'</a>';
				}
			}
		}
		if ($filters_list) {
			$output .= '<script type="text/javascript">'
				. 'jQuery(document).ready(function () {'
					. 'jQuery("#'.esc_attr($id).' .isotope_filters").append("'.addslashes($filters_list).'");'
				. '});'
				. '</script>';
		}
	}
	$output	.= (ancora_sc_param_is_on($scroll)
			? '</div></div><div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.esc_attr($dir).' '.esc_attr($id).'_scroll_bar"></div></div>'
				. (!ancora_sc_param_is_off($controls) ? '<div class="sc_scroll_controls_wrap"><a class="sc_scroll_prev" href="#"></a><a class="sc_scroll_next" href="#"></a></div>' : '')
			: '')
		. ($dir=='horizontal' && $columns > 1 && ancora_get_template_property($style, 'need_columns') ? '</div>' : '')
		. ($container_end)
		. ($style == 'list' ? '</ul>' : '</div>');

	// Add template specific scripts and styles
	do_action('ancora_action_blog_scripts', $style);
	
	$ANCORA_GLOBALS['sc_blogger_busy'] = false;
	
	return apply_filters('ancora_shortcode_output', $output, 'trx_blogger', $atts, $content);
}

function ancora_sc_in_shortcode_blogger($from_blogger = false) {
	if (!$from_blogger) return false;
	global $ANCORA_GLOBALS;
	return $ANCORA_GLOBALS['sc_blogger_busy'];
}
// ---------------------------------- [/trx_blogger] ---------------------------------------





// ---------------------------------- [trx_br] ---------------------------------------

add_shortcode ("trx_br", "ancora_sc_br");
						
/*
[trx_br clear="left|right|both"]
*/

function ancora_sc_br($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		"clear" => ""
    ), $atts)));
	$output = in_array($clear, array('left', 'right', 'both', 'all')) 
		? '<div class="clearfix" style="clear:' . str_replace('all', 'both', $clear) . '"></div>'
		: '<br />';
	return apply_filters('ancora_shortcode_output', $output, 'trx_br', $atts, $content);
}
// ---------------------------------- [/trx_br] ---------------------------------------



// ---------------------------------- [trx_button] ---------------------------------------


add_shortcode ('trx_button', 'ancora_sc_button');

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/
function ancora_sc_button($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"type" => "square",
		"style" => "filled",
		"size" => "small",
		"icon" => "",
		"color" => "",
		"bg_color" => "",
		"bg_style" => "link",
		"link" => "",
		"target" => "",
		"align" => "",
		"rel" => "",
		"popup" => "no",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height)
		. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
		. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
	if (ancora_sc_param_is_on($popup)) ancora_enqueue_popup('magnific');
	$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
		. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
		. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. ' class="sc_button button-hover sc_button_' . esc_attr($type)
				. ' sc_button_style_' . esc_attr($style) 
				. ' sc_button_bg_' . esc_attr($bg_style)
				. ' sc_button_size_' . esc_attr($size)
				. ($align && $align!='none' ? ' align'.esc_attr($align) : '')
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
				. (ancora_sc_param_is_on($popup) ? ' popup_link' : '')
				. '"'
		. ($id ? ' id="'.esc_attr($id).'"' : '') 
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
        . ' data-text="'.do_shortcode($content). '"'
		. '>'
		. do_shortcode($content)
		. '</a>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_button', $atts, $content);
}

// ---------------------------------- [/trx_button] ---------------------------------------





// ---------------------------------- [trx_chat] ---------------------------------------

add_shortcode('trx_chat', 'ancora_sc_chat');

/*
[trx_chat id="unique_id" link="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_chat]
[trx_chat id="unique_id" link="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_chat]
...
*/
function ancora_sc_chat($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"photo" => "",
		"title" => "",
		"link" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	$title = $title=='' ? $link : $title;
	if (!empty($photo)) {
		if ($photo > 0) {
			$attach = wp_get_attachment_image_src( $photo, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$photo = $attach[0];
		}
		$photo = ancora_get_resized_image_tag($photo, 75, 75);
	}
	$content = do_shortcode($content);
	if (ancora_substr($content, 0, 2)!='<p') $content = '<p>' . ($content) . '</p>';
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_chat' . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
				. '<div class="sc_chat_inner">'
					. ($photo ? '<div class="sc_chat_avatar">'.($photo).'</div>' : '')
					. ($title == '' ? '' : ('<div class="sc_chat_title">' . ($link!='' ? '<a href="'.esc_url($link).'">' : '') . ($title) . ($link!='' ? '</a>' : '') . '</div>'))
					. '<div class="sc_chat_content">'.($content).'</div>'
				. '</div>'
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_chat', $atts, $content);
}

// ---------------------------------- [/trx_chat] ---------------------------------------




// ---------------------------------- [trx_columns] ---------------------------------------


add_shortcode('trx_columns', 'ancora_sc_columns');

/*
[trx_columns id="unique_id" count="number"]
	[trx_column_item id="unique_id" span="2 - number_columns"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/trx_column_item]
	[trx_column_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/trx_column_item]
	[trx_column_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/trx_column_item]
	[trx_column_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/trx_column_item]
[/trx_columns]
*/
function ancora_sc_columns($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"count" => "2",
		"fluid" => "no",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	$count = max(1, min(12, (int) $count));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_columns_counter'] = 1;
	$ANCORA_GLOBALS['sc_columns_after_span2'] = false;
	$ANCORA_GLOBALS['sc_columns_after_span3'] = false;
	$ANCORA_GLOBALS['sc_columns_after_span4'] = false;
	$ANCORA_GLOBALS['sc_columns_count'] = $count;
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="columns_wrap sc_columns'
				. ' columns_' . (ancora_sc_param_is_on($fluid) ? 'fluid' : 'nofluid')
				. ' sc_columns_count_' . esc_attr($count)
				. (!empty($class) ? ' '.esc_attr($class) : '') 
			. '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
				. do_shortcode($content)
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_columns', $atts, $content);
}


add_shortcode('trx_column_item', 'ancora_sc_column_item');

function ancora_sc_column_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"span" => "1",
		"align" => "",
		"color" => "",
		"bg_color" => "",
		"bg_image" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => ""
	), $atts)));
	$css .= ($align !== '' ? 'text-align:' . esc_attr($align) . ';' : '') 
		. ($color !== '' ? 'color:' . esc_attr($color) . ';' : '');
	$span = max(1, min(11, (int) $span));
	global $ANCORA_GLOBALS;
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="column-'.($span > 1 ? esc_attr($span) : 1).'_'.esc_attr($ANCORA_GLOBALS['sc_columns_count']).' sc_column_item sc_column_item_'.esc_attr($ANCORA_GLOBALS['sc_columns_counter'])
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($ANCORA_GLOBALS['sc_columns_counter'] % 2 == 1 ? ' odd' : ' even')
				. ($ANCORA_GLOBALS['sc_columns_counter'] == 1 ? ' first' : '')
				. ($span > 1 ? ' span_'.esc_attr($span) : '') 
				. ($ANCORA_GLOBALS['sc_columns_after_span2'] ? ' after_span_2' : '')
				. ($ANCORA_GLOBALS['sc_columns_after_span3'] ? ' after_span_3' : '')
				. ($ANCORA_GLOBALS['sc_columns_after_span4'] ? ' after_span_4' : '')
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. '>'
				. ($bg_color!=='' || $bg_image !== '' ? '<div class="sc_column_item_inner" style="'
						. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
						. ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
						. '">' : '')
					. do_shortcode($content)
				. ($bg_color!=='' || $bg_image !== '' ? '</div>' : '')
				. '</div>';
	$ANCORA_GLOBALS['sc_columns_counter'] += $span;
	$ANCORA_GLOBALS['sc_columns_after_span2'] = $span==2;
	$ANCORA_GLOBALS['sc_columns_after_span3'] = $span==3;
	$ANCORA_GLOBALS['sc_columns_after_span4'] = $span==4;
	return apply_filters('ancora_shortcode_output', $output, 'trx_column_item', $atts, $content);
}

// ---------------------------------- [/trx_columns] ---------------------------------------


// ---------------------------------- [trx_contact_form] ---------------------------------------

add_shortcode("trx_contact_form", "ancora_sc_contact_form");

/*
[trx_contact_form id="unique_id" title="Contact Form" description="Mauris aliquam habitasse magna."]
*/

function ancora_sc_contact_form($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"custom" => "no",
		"action" => "",
		"title" => "",
		"description" => "",
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	if (empty($id)) $id = "sc_contact_form_".str_replace('.', '', mt_rand());
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width);
    static $cnt = 0;
    $cnt++;
    $privacy = trx_utils_get_privacy_text();
	// Load core messages
	ancora_enqueue_messages();
	//wp_enqueue_script( 'form-contact', ancora_get_file_url('js/_form_contact.js'), array('jquery'), null, true );
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_contact_form_id'] = $id;
	$ANCORA_GLOBALS['sc_contact_form_counter'] = 0;
	$content = do_shortcode($content);
	$output = '<div ' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. 'class="sc_contact_form sc_contact_form_'.($content != '' && ancora_sc_param_is_on($custom) ? 'custom' : 'standard')
				. (!empty($align) && !ancora_sc_param_is_off($align) ? ' align'.esc_attr($align) : '')
				. (!empty($class) ? ' '.esc_attr($class) : '') 
				. '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
		. ($title ? '<h2 class="sc_contact_form_title">' . ($title) . '</h2>' : '')
		. ($description ? '<p class="sc_contact_form_description">' . ($description) . '</p>' : '')
		. '<form' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' data-formtype="'.($content ? 'custom' : 'contact').'" method="post" action="' . esc_url($action ? $action : admin_url('admin-ajax.php')) . '">'
		. ($content != '' && ancora_sc_param_is_on($custom)
			? $content 
			: '<div class="sc_contact_form_info">'
					.'<div class="sc_contact_form_item sc_contact_form_field label_over"><label class="required" for="sc_contact_form_username">' . __('Name', 'ancora-utils') . '</label><input id="sc_contact_form_username" type="text" name="username" placeholder="' . __('Name *', 'ancora-utils') . '"></div>'
					. '<div class="sc_contact_form_item sc_contact_form_field label_over"><label class="required" for="sc_contact_form_email">' . __('E-mail', 'ancora-utils') . '</label><input id="sc_contact_form_email" type="text" name="email" placeholder="' . __('E-mail *', 'ancora-utils') . '"></div>'
					.'<div class="sc_contact_form_item sc_contact_form_field label_over"><label class="required" for="sc_contact_form_subj">' . __('Subject', 'ancora-utils') . '</label><input id="sc_contact_form_subj" type="text" name="subject" placeholder="' . __('Subject', 'ancora-utils') . '"></div>'
				.'</div>'
				.'<div class="sc_contact_form_item sc_contact_form_message label_over"><label class="required" for="sc_contact_form_message">' . __('Message', 'ancora-utils') . '</label><textarea id="sc_contact_form_message" name="message" placeholder="' . __('Message', 'ancora-utils') . '"></textarea></div>'
            . ((!empty($privacy)) ? '<div class="sc_form_field sc_form_field_checkbox">
                  <input type="checkbox" id="i_agree_privacy_policy_sc_form_' . esc_attr($cnt) . '" name="i_agree_privacy_policy" class="sc_form_privacy_checkbox" value="1">
                  <label for="i_agree_privacy_policy_sc_form_' . esc_attr($cnt) . '">' . $privacy . '</label></div>' : '')
            .'<div class="sc_contact_form_item sc_contact_form_button"><button class="button-hover" data-text="'.__('SEND MESSAGE', 'ancora-utils').'" ' . (!empty($privacy) ? ' disabled="disabled"' : '') . '>'.__('SEND MESSAGE', 'ancora-utils').'</button></div>'
			)
		.'<div class="result sc_infobox"></div>'
		.'</form>'
		.'</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_contact_form', $atts, $content);
}


add_shortcode('trx_form_item', 'ancora_sc_contact_form_item');

function ancora_sc_contact_form_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"type" => "text",
		"name" => "",
		"value" => "",
		"checked" => "",
		"align" => "",
		"label" => "",
		"label_position" => "top",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_contact_form_counter']++;
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
    static $cnt = 0;
    $cnt++;
    $privacy = trx_utils_get_privacy_text();
	if (empty($id)) $id = ($ANCORA_GLOBALS['sc_contact_form_id']).'_'.($ANCORA_GLOBALS['sc_contact_form_counter']);
	$label = $type!='button' && $type!='submit' && $label ? '<label for="' . esc_attr($id) . '"' . (ancora_sc_param_is_on($checked) ? ' class="selected"' : '') . '>' . esc_attr($label) . '</label>' : $label;
	$output = '<div class="sc_contact_form_item sc_contact_form_item_'.esc_attr($type)
					.' sc_contact_form_'.($type == 'textarea' ? 'message' : ($type == 'button' || $type == 'submit' ? 'button' : 'field'))
					.' label_'.esc_attr($label_position)
					.($class ? ' '.esc_attr($class) : '')
					.($align && $align!='none' ? ' align'.esc_attr($align) : '')
				.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. '>'
		. ($type!='button' && $type!='submit' && ($label_position=='top' || $label_position=='left') ? $label : '')
		. ($type == 'textarea' 
			? '<textarea id="' . esc_attr($id) . '" name="' . esc_attr($name ? $name : $id) . '">' . esc_attr($value) . '</textarea>'
			: ($type=='button' || $type=='submit' 
				? '<button id="' . esc_attr($id) . '" class="button-hover" data-text="'.($label ? $label : $value).'">'.($label ? $label : $value).'</button>'
				: '<input type="'.($type ? $type : 'text').'" id="' . esc_attr($id) . '" name="' . esc_attr($name ? $name : $id) . '" placeholder="' . esc_attr($value) . '"'
					. (ancora_sc_param_is_on($checked) ? ' checked="checked"' : '') . '>'
				)
			)
		. ($type!='button' && $type!='submit' && $label_position=='bottom' ? $label : '')
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_form_item', $atts, $content);
}


// AJAX Callback: Send contact form data
if ( !function_exists( 'sc_contact_form_send' ) ) {
	function ancora_sc_contact_form_send() {
		global $_REQUEST;
	
		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
			die();
	
		$response = array('error'=>'');
		if (!($contact_email = ancora_get_theme_option('contact_email')) && !($contact_email = ancora_get_theme_option('admin_email')))
			$response['error'] = __('Unknown admin email!', 'ancora-utils');
		else {
			$type = ancora_substr($_REQUEST['type'], 0, 7);
			parse_str($_POST['data'], $post_data);

			if ($type=='contact') {
				$user_name	= ancora_strshort($post_data['username'],	100);
				$user_email	= ancora_strshort($post_data['email'],	100);
				$user_subj	= ancora_strshort($post_data['subject'],	100);
				$user_msg	= ancora_strshort($post_data['message'],	ancora_get_theme_option('message_maxlength_contacts'));
		
				$subj = sprintf(__('Site %s - Contact form message from %s', 'ancora-utils'), get_bloginfo('site_name'), $user_name);
				$msg = "\n".__('Name:', 'ancora-utils')   .' '.esc_html($user_name)
					.  "\n".__('E-mail:', 'ancora-utils') .' '.esc_html($user_email)
					.  "\n".__('Subject:', 'ancora-utils').' '.esc_html($user_subj)
					.  "\n".__('Message:', 'ancora-utils').' '.esc_html($user_msg);

			} else {

				$subj = sprintf(__('Site %s - Custom form data', 'ancora-utils'), get_bloginfo('site_name'));
				$msg = '';
				foreach ($post_data as $k=>$v)
					$msg .= "\n{$k}: $v";
			}

			$msg .= "\n\n............. " . get_bloginfo('site_name') . " (" . home_url() . ") ............";

			$mail = ancora_get_theme_option('mail_function') == 'mail' ? 'mail' : 'wp_mail';
			if (is_email($contact_email) && !@$mail($contact_email, $subj, $msg)) {
				$response['error'] = __('Error send message!', 'ancora-utils');
			}
		
			echo json_encode($response);
			die();
		}
	}
}

// ---------------------------------- [/trx_contact_form] ---------------------------------------




// ---------------------------------- [trx_content] ---------------------------------------

add_shortcode('trx_content', 'ancora_sc_content');

/*
[trx_content id="unique_id" class="class_name" style="css-styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_content]
*/

function ancora_sc_content($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values('!'.($top), '', '!'.($bottom));
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
		. ' class="sc_content content_wrap' . ($class ? ' '.esc_attr($class) : '') . '"'
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '').'>' 
		. do_shortcode($content) 
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_content', $atts, $content);
}
// ---------------------------------- [/trx_content] ---------------------------------------





// ---------------------------------- [trx_countdown] ---------------------------------------

add_shortcode("trx_countdown", "ancora_sc_countdown");

//[trx_countdown date="" time=""]
function ancora_sc_countdown($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"date" => "",
		"time" => "",
		"style" => "1",
		"align" => "center",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts)));
	if (empty($id)) $id = "sc_countdown_".str_replace('.', '', mt_rand());
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	if (empty($interval)) $interval = 1;
	wp_enqueue_script( 'ancora-jquery-plugin-script', ancora_get_file_url('js/countdown/jquery.plugin.js'), array('jquery'), null, true );
	wp_enqueue_script( 'ancora-countdown-script', ancora_get_file_url('js/countdown/jquery.countdown.js'), array('jquery'), null, true );
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
		. ' class="sc_countdown sc_countdown_style_' . esc_attr(max(1, min(2, $style))) . (!empty($align) && $align!='none' ? ' align'.esc_attr($align) : '') . (!empty($class) ? ' '.esc_attr($class) : '') .'"'
		. ($css ? ' style="'.esc_attr($css).'"' : '')
		. ' data-date="'.esc_attr(empty($date) ? date('Y-m-d') : $date).'"'
		. ' data-time="'.esc_attr(empty($time) ? '00:00:00' : $time).'"'
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. '>'
			. '<div class="sc_countdown_item sc_countdown_days">'
				. '<span class="sc_countdown_digits"><span></span><span></span><span></span></span>'
				. '<span class="sc_countdown_label">'.__('Days', 'ancora-utils').'</span>'
			. '</div>'
			. '<div class="sc_countdown_separator">:</div>'
			. '<div class="sc_countdown_item sc_countdown_hours">'
				. '<span class="sc_countdown_digits"><span></span><span></span></span>'
				. '<span class="sc_countdown_label">'.__('Hours', 'ancora-utils').'</span>'
			. '</div>'
			. '<div class="sc_countdown_separator">:</div>'
			. '<div class="sc_countdown_item sc_countdown_minutes">'
				. '<span class="sc_countdown_digits"><span></span><span></span></span>'
				. '<span class="sc_countdown_label">'.__('Minutes', 'ancora-utils').'</span>'
			. '</div>'
			. '<div class="sc_countdown_separator">:</div>'
			. '<div class="sc_countdown_item sc_countdown_seconds">'
				. '<span class="sc_countdown_digits"><span></span><span></span></span>'
				. '<span class="sc_countdown_label">'.__('Seconds', 'ancora-utils').'</span>'
			. '</div>'
			. '<div class="sc_countdown_placeholder hide"></div>'
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_countdown', $atts, $content);
}
// ---------------------------------- [/trx_countdown] ---------------------------------------



						


// ---------------------------------- [trx_dropcaps] ---------------------------------------

add_shortcode('trx_dropcaps', 'ancora_sc_dropcaps');

//[trx_dropcaps id="unique_id" style="1-6"]paragraph text[/trx_dropcaps]
function ancora_sc_dropcaps($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "1",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$style = min(4, max(1, $style));
	$content = do_shortcode($content);
	$output = ancora_substr($content, 0, 1) == '<'
		? $content 
		: '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_dropcaps sc_dropcaps_style_' . esc_attr($style) . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ($css ? ' style="'.esc_attr($css).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>' 
				. '<span class="sc_dropcaps_item">' . trim(ancora_substr($content, 0, 1)) . '</span>' . trim(ancora_substr($content, 1))
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_dropcaps', $atts, $content);
}
// ---------------------------------- [/trx_dropcaps] ---------------------------------------


// ---------------------------------- [trx_quote] ---------------------------------------


add_shortcode('trx_quote', 'ancora_sc_quote');

/*
[trx_quote id="unique_id" cite="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/quote]
*/
function ancora_sc_quote($atts, $content=null){
    if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
        // Individual params
        "title" => "",
        "cite" => "",
        "style" => "1",
        // Common params
        "id" => "",
        "class" => "",
        "animation" => "",
        "css" => "",
        "width" => "",
        "top" => "",
        "bottom" => "",
        "left" => "",
        "right" => ""
    ), $atts)));
    $css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width);
    $style = min(4, max(1, $style));
    $cite_param = $cite != '' ? ' cite="'.esc_attr($cite).'"' : '';
    $title = $title=='' ? $cite : $title;
    $content = do_shortcode($content);
    if (ancora_substr($content, 0, 2)!='<p') $content = '<p>' . ($content) . '</p>';
    $output = '<blockquote'
        . ($id ? ' id="'.esc_attr($id).'"' : '') . ($cite_param)
        . ' class="sc_quote'. (!empty($class) ? ' '.esc_attr($class) : '').' sc_quote_style_'. esc_attr($style) .'"'
        . (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
        . ($css!='' ? ' style="'.esc_attr($css).'"' : '')
        . '>'
        . ($content)
        . ($title == '' ? '' : ('<p class="sc_quote_title">' . ($cite!='' ? '<a href="'.esc_url($cite).'">' : '') . ($title) . ($cite!='' ? '</a>' : '') . '</p>'))
        .'</blockquote>';
    return apply_filters('ancora_shortcode_output', $output, 'trx_quote', $atts, $content);
}

// ---------------------------------- [/trx_quote] ---------------------------------------


// ---------------------------------- [trx_emailer] ---------------------------------------

add_shortcode("trx_emailer", "ancora_sc_emailer");

//[trx_emailer group=""]
function ancora_sc_emailer($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"group" => "",
		"open" => "yes",
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	// Load core messages
	ancora_enqueue_messages();
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_emailer' . ($align && $align!='none' ? ' align' . esc_attr($align) : '') . (ancora_sc_param_is_on($open) ? ' sc_emailer_opened' : '') . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
				. ($css ? ' style="'.esc_attr($css).'"' : '') 
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. '>'
			. '<form class="sc_emailer_form">'
			. '<input type="text" class="sc_emailer_input" name="email" value="" placeholder="'.__('Please, enter you email address.', 'ancora-utils').'">'
			. '<a href="#" class="sc_emailer_button icon-mail-1" title="'.__('Submit', 'ancora-utils').'" data-group="'.($group ? $group : __('E-mailer subscription', 'ancora-utils')).'"></a>'
			. '</form>'
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_emailer', $atts, $content);
}
// ---------------------------------- [/trx_emailer] ---------------------------------------





// ---------------------------------- [trx_gap] ---------------------------------------

add_shortcode("trx_gap", "ancora_sc_gap");
						
//[trx_gap]Fullwidth content[/trx_gap]

function ancora_sc_gap($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	$output = ancora_sc_gap_start() . do_shortcode($content) . ancora_sc_gap_end();
	return apply_filters('ancora_shortcode_output', $output, 'trx_gap', $atts, $content);
}

function ancora_sc_gap_start() {
	return '<!-- #TRX_GAP_START# -->';
}

function ancora_sc_gap_end() {
	return '<!-- #TRX_GAP_END# -->';
}

function ancora_sc_gap_wrapper($str) {
    // Move VC row and column and wrapper inside gap
    // Old VC wrappers
    $str_new = preg_replace('/(<div\s+class="[^"]*vc_row[^>]*>)[\r\n\s]*(<div\s+class="[^"]*vc_col[^>]*>)[\r\n\s]*(<div\s+class="[^"]*wpb_wrapper[^>]*>)[\r\n\s]*('.ancora_sc_gap_start().')/i', '\\4\\1\\2\\3', $str);
    if ($str_new != $str) $str_new = preg_replace('/('.ancora_sc_gap_end().')[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)/i', '\\2\\3\\4\\1', $str_new);
    // New VC wrappers
    $str_new = preg_replace('/(<div\s+class="[^"]*vc_row[^>]*>)[\r\n\s]*(<div\s+class="[^"]*vc_col[^>]*>)[\r\n\s]*(<div\s+class="[^"]*vc_col[^>]*>)[\r\n\s]*(<div\s+class="[^"]*wpb_wrapper[^>]*>)[\r\n\s]*('.ancora_sc_gap_start().')/i', '\\5\\1\\2\\3\\4', $str);
    if ($str_new != $str) $str_new = preg_replace('/('.ancora_sc_gap_end().')[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)/i', '\\2\\3\\4\\5\\1', $str_new);
    // Gap layout
    return str_replace(
        array(
            ancora_sc_gap_start(),
            ancora_sc_gap_end()
        ),
        array(
            ancora_close_all_wrappers(false) . '<div class="sc_gap">',
            '</div>' . ancora_open_all_wrappers(false)
        ),
        $str_new
    );
}
// ---------------------------------- [/trx_gap] ---------------------------------------






// ---------------------------------- [trx_googlemap] ---------------------------------------

add_shortcode("trx_googlemap", "ancora_sc_google_map");

//[trx_googlemap id="unique_id" address="your_address" width="width_in_pixels_or_percent" height="height_in_pixels"]
function ancora_sc_google_map($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"address" => "",
		"latlng" => "",
        "description" => "",
		"zoom" => 16,
		"style" => 'default',
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"animation" => "",
		"width" => "100%",
		"height" => "400",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	if (empty($id)) $id = 'sc_googlemap_'.str_replace('.', '', mt_rand());
	if (empty($address) && empty($latlng)) {
		$latlng = ancora_get_custom_option('googlemap_latlng');
		if (empty($latlng))	$address = ancora_get_custom_option('googlemap_address');
	}
	if (empty($style)) $style = ancora_get_custom_option('googlemap_style');

    // Google map
    if ( ancora_get_custom_option('show_googlemap')=='yes' && ancora_get_theme_option('api_google') != ''){
        $api_key = ancora_get_theme_option('api_google');
        wp_enqueue_script( 'googlemap', ancora_get_protocol().'://maps.google.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
    }

    $api_key = ancora_get_theme_option('api_google');
    if (ancora_get_theme_option('api_google') != ''){
        wp_enqueue_script( 'googlemap', ancora_get_protocol().'://maps.google.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
        wp_enqueue_script( 'ancora-googlemap-script', trx_utils_get_file_url('includes/core.googlemap.js'), array(), null, true );
    }
    if (ancora_get_theme_option('api_google') != ''){
	$output = '<div id="'.esc_attr($id).'"'
		. ' class="sc_googlemap'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. ' data-address="'.esc_attr($address).'"'
        . ' data-description="'.esc_attr($description).'"'
		. ' data-latlng="'.esc_attr($latlng).'"'
		. ' data-zoom="'.esc_attr($zoom).'"'
		. ' data-style="'.esc_attr($style).'"'
		. ' data-point="'.esc_attr(ancora_get_custom_option('googlemap_marker')).'"'
		. '></div>';
    } else {
        $output = '<div class="sc_googlemap" ' . ($css!='' ? ' style="'.esc_attr($css).'"' : '') . '><iframe src="https://maps.google.com/maps?t=m&output=embed&iwloc=near&z='.esc_attr($zoom > 0 ? $zoom : 14).'&q='
            . esc_attr(!empty($address) ? urlencode($address) : '')
            . ( !empty($latlng)
                ? ( !empty($address) ? '@' : '' ) . str_replace(' ', '', $latlng)
                : ''
            )
            . '" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"'
            . ' aria-label="' . esc_attr(!empty($title) ? $title : '') . '"></iframe></div>';
        }
	return apply_filters('ancora_shortcode_output', $output, 'trx_googlemap', $atts, $content);
}
// ---------------------------------- [/trx_googlemap] ---------------------------------------





// ---------------------------------- [trx_hide] ---------------------------------------


add_shortcode('trx_hide', 'ancora_sc_hide');

/*
[trx_hide selector="unique_id"]
*/
function ancora_sc_hide($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"selector" => "",
		"hide" => "on",
		"delay" => 0
    ), $atts)));
	$selector = trim(chop($selector));
	$output = $selector == '' ? '' : 
		'<script type="text/javascript">
			jQuery(document).ready(function() {
				'.($delay>0 ? 'setTimeout(function() {' : '').'
				jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
				'.($delay>0 ? '},'.($delay).');' : '').'
			});
		</script>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_hide', $atts, $content);
}
// ---------------------------------- [/trx_hide] ---------------------------------------





// ---------------------------------- [trx_highlight] ---------------------------------------

add_shortcode('trx_highlight', 'ancora_sc_highlight');

/*
[trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_highlight]
*/
function ancora_sc_highlight($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"color" => "",
		"bg_color" => "",
		"font_size" => "",
		"type" => "1",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
    ), $atts)));
	$css .= ($color != '' ? 'color:' . esc_attr($color) . ';' : '')
		.($bg_color != '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
		.($font_size != '' ? 'font-size:' . esc_attr(ancora_prepare_css_value($font_size)) . '; line-height: 1em;' : '');
	$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.esc_attr($type) : ''). (!empty($class) ? ' '.esc_attr($class) : '').'"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>' 
			. do_shortcode($content) 
			. '</span>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_highlight', $atts, $content);
}
// ---------------------------------- [/trx_highlight] ---------------------------------------





// ---------------------------------- [trx_icon] ---------------------------------------


add_shortcode('trx_icon', 'ancora_sc_icon');

/*
[trx_icon id="unique_id" style='round|square' icon='' color="" bg_color="" size="" weight=""]
*/
function ancora_sc_icon($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"icon" => "",
		"color" => "",
		"bg_color" => "",
		"bg_shape" => "",
		"bg_style" => "",
		"font_size" => "",
		"font_weight" => "",
		"align" => "",
		"link" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$css2 = ($font_weight != '' && $font_weight != 'inherit' ? 'font-weight:'. esc_attr($font_weight).';' : '')
		. ($font_size != '' ? 'font-size:' . esc_attr(ancora_prepare_css_value($font_size)) . '; line-height: ' . (!$bg_shape || ancora_sc_param_is_inherit($bg_shape) ? '1' : '1.2') . 'em;' : '')
		. ($color != '' ? 'color:'.esc_attr($color).';' : '')
		. ($bg_color != '' ? 'background-color:'.esc_attr($bg_color).';border-color:'.esc_attr($bg_color).';' : '')
	;
	$output = $icon!='' 
		? ($link ? '<a href="'.esc_url($link).'"' : '<span') . ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_icon '.esc_attr($icon)
				. ($bg_shape && !ancora_sc_param_is_inherit($bg_shape) ? ' sc_icon_shape_'.esc_attr($bg_shape) : '')
				. ($bg_style && !ancora_sc_param_is_inherit($bg_style) ? ' sc_icon_bg_'.esc_attr($bg_style) : '')
				. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
				. (!empty($class) ? ' '.esc_attr($class) : '')
			.'"'
			.($css || $css2 ? ' style="'.($css ? 'display:block;' : '') . ($css) . ($css2) . '"' : '')
			.'>'
			.($link ? '</a>' : '</span>')
		: '';
	return apply_filters('ancora_shortcode_output', $output, 'trx_icon', $atts, $content);
}

// ---------------------------------- [/trx_icon] ---------------------------------------





// ---------------------------------- [trx_image] ---------------------------------------


add_shortcode('trx_image', 'ancora_sc_image');

/*
[trx_image id="unique_id" src="image_url" width="width_in_pixels" height="height_in_pixels" title="image's_title" align="left|right"]
*/
function ancora_sc_image($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"title" => "",
		"align" => "",
		"shape" => "square",
		"src" => "",
		"url" => "",
		"icon" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values('!'.($top), '!'.($right), '!'.($bottom), '!'.($left), $width, $height);
	$src = $src!='' ? $src : $url;
	if ($src > 0) {
		$attach = wp_get_attachment_image_src( $src, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$src = $attach[0];
	}
	if (!empty($width) || !empty($height)) {
		$w = !empty($width) && strlen(intval($width)) == strlen($width) ? $width : null;
		$h = !empty($height) && strlen(intval($height)) == strlen($height) ? $height : null;
		if ($w || $h) $src = ancora_get_resized_image_url($src, $w, $h);
	}
	$output = empty($src) ? '' : ('<figure' . ($id ? ' id="'.esc_attr($id).'"' : '')
		. ' class="sc_image ' . ($align && $align!='none' ? ' align' . esc_attr($align) : '') . (!empty($shape) ? ' sc_image_shape_'.esc_attr($shape) : '') . (!empty($class) ? ' '.esc_attr($class) : '') . (!empty($title) ? ' title_approve ' : '').'"'
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
		. '>'
			. '<div style="padding: 0.4em; padding-bottom: 0;"><img src="'.esc_url($src).'" alt="" /></div>'
			. (trim($title) || (trim($icon) && $icon!='none') ? '<figcaption><span'.($icon ? ' class="'.esc_attr($icon).'"' : '').'></span> ' . ($title) . '</figcaption>' : '')
		. '</figure>');
	return apply_filters('ancora_shortcode_output', $output, 'trx_image', $atts, $content);
}

// ---------------------------------- [/trx_image] ---------------------------------------






// ---------------------------------- [trx_infobox] ---------------------------------------

add_shortcode('trx_infobox', 'ancora_sc_infobox');

/*
[trx_infobox id="unique_id" style="regular|info|success|error|result" static="0|1"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_infobox]
*/
function ancora_sc_infobox($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "regular",
		"closeable" => "no",
		"icon" => "",
		"color" => "",
		"bg_color" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left)
		. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
		. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) .';' : '');
	if (empty($icon)) {
		if ($icon=='none')
			$icon = '';
		else if ($style=='regular')
			$icon = 'icon-cog-2';
		else if ($style=='success')
			$icon = 'icon-check-2';
		else if ($style=='error')
			$icon = 'icon-alert-2';
		else if ($style=='info')
			$icon = 'icon-info-2';
	}
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_infobox sc_infobox_style_' . esc_attr($style) 
				. (ancora_sc_param_is_on($closeable) ? ' sc_infobox_closeable' : '')
				. (!empty($class) ? ' '.esc_attr($class) : '') 
				. ($icon!='' && !ancora_sc_param_is_inherit($icon) ? ' sc_infobox_iconed '. esc_attr($icon) : '')
				. '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
			. do_shortcode($content) 
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_infobox', $atts, $content);
}

// ---------------------------------- [/trx_infobox] ---------------------------------------





// ---------------------------------- [trx_line] ---------------------------------------


add_shortcode('trx_line', 'ancora_sc_line');

/*
[trx_line id="unique_id" style="none|solid|dashed|dotted|double|groove|ridge|inset|outset" top="margin_in_pixels" bottom="margin_in_pixels" width="width_in_pixels_or_percent" height="line_thickness_in_pixels" color="line_color's_name_or_#rrggbb"]
*/
function ancora_sc_line($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "solid",
		"color" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width)
		.($height !='' ? 'border-top-width:' . esc_attr($height) . 'px;' : '')
		.($style != '' ? 'border-top-style:' . esc_attr($style) . ';' : '')
		.($color != '' ? 'border-top-color:' . esc_attr($color) . ';' : '');
	$output = '<div' . ($id ? ' id="'.esc_attr($id) . '"' : '') 
			. ' class="sc_line' . ($style != '' ? ' sc_line_style_'.esc_attr($style) : '') . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '></div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_line', $atts, $content);
}

// ---------------------------------- [/trx_line] ---------------------------------------





// ---------------------------------- [trx_list] ---------------------------------------

add_shortcode('trx_list', 'ancora_sc_list');

/*
[trx_list id="unique_id" style="arrows|iconed|ol|ul"]
	[trx_list_item id="unique_id" title="title_of_element"]Et adipiscing integer.[/trx_list_item]
	[trx_list_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in.[/trx_list_item]
	[trx_list_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer.[/trx_list_item]
	[trx_list_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus.[/trx_list_item]
[/trx_list]
*/
function ancora_sc_list($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "ul",
		"icon" => "icon-angle-right",
		"icon_color" => "",
		"color" => "",
        "boxed_icon" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left)
		. ($color !== '' ? 'color:' . esc_attr($color) .';' : '');
	if (trim($style) == '' || (trim($icon) == '' && $style=='iconed')) $style = 'ul';
    if ($style == 'arrows' && trim($icon) == '') $icon = 'icon-right-open-big';
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_list_counter'] = 0;
	$ANCORA_GLOBALS['sc_list_icon'] = empty($icon) || ancora_sc_param_is_inherit($icon) ? "icon-angle-right" : $icon;
	$ANCORA_GLOBALS['sc_list_icon_color'] = $icon_color;
	$ANCORA_GLOBALS['sc_list_style'] = $style;
	$output = '<' . ($style=='ol' ? 'ol' : 'ul')
			. ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_list '. esc_attr($boxed_icon) . ' sc_list_style_' . esc_attr($style) . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
			. do_shortcode($content)
			. '</' .($style=='ol' ? 'ol' : 'ul') . '>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_list', $atts, $content);
}


add_shortcode('trx_list_item', 'ancora_sc_list_item');

function ancora_sc_list_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"color" => "",
		"icon" => "",
		"icon_color" => "",
		"title" => "",
		"link" => "",
		"target" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_list_counter']++;
	$css .= $color !== '' ? 'color:' . esc_attr($color) .';' : '';
	if (trim($icon) == '' || ancora_sc_param_is_inherit($icon)) $icon = $ANCORA_GLOBALS['sc_list_icon'];
	if (trim($color) == '' || ancora_sc_param_is_inherit($icon_color)) $icon_color = $ANCORA_GLOBALS['sc_list_icon_color'];
	$output = '<li' . ($id ? ' id="'.esc_attr($id).'"' : '') 
		. ' class="sc_list_item'
		. (!empty($class) ? ' '.esc_attr($class) : '')
		. ($ANCORA_GLOBALS['sc_list_counter'] % 2 == 1 ? ' odd' : ' even')
		. ($ANCORA_GLOBALS['sc_list_counter'] == 1 ? ' first' : '')
		. '"' 
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
		. ($title ? ' title="'.esc_attr($title).'"' : '') 
		. '>' 
		. (!empty($link) ? '<a href="'.esc_url($link).'"' . (!empty($target) ? ' target="'.esc_attr($target).'"' : '') . '>' : '')
		. ($ANCORA_GLOBALS['sc_list_style']=='iconed' && $icon!='' ? '<span class="sc_list_icon '.esc_attr($icon).'"'.($icon_color !== '' ? ' style="color:'.esc_attr($icon_color).';"' : '').'></span>' : '')
        . ($ANCORA_GLOBALS['sc_list_style']=='arrows' && $icon!='' ? '<span class="sc_list_icon '.esc_attr($icon).'"'.($icon_color !== '' ? ' style="color:'.esc_attr($icon_color).';"' : '').'></span>' : '')
		. do_shortcode($content)
		. (!empty($link) ? '</a>': '')
		. '</li>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_list_item', $atts, $content);
}

// ---------------------------------- [/trx_list] ---------------------------------------






// ---------------------------------- [trx_number] ---------------------------------------


add_shortcode('trx_number', 'ancora_sc_number');

/*
[trx_number id="unique_id" value="400"]
*/
function ancora_sc_number($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"value" => "",
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_number' 
				. (!empty($align) ? ' align'.esc_attr($align) : '') 
				. (!empty($class) ? ' '.esc_attr($class) : '') 
				. '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>';
	for ($i=0; $i < ancora_strlen($value); $i++) {
		$output .= '<span class="sc_number_item">' . trim(ancora_substr($value, $i, 1)) . '</span>';
	}
	$output .= '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_number', $atts, $content);
}

// ---------------------------------- [/trx_number] ---------------------------------------





// ---------------------------------- [trx_parallax] ---------------------------------------


add_shortcode('trx_parallax', 'ancora_sc_parallax');

/*
[trx_parallax id="unique_id" style="light|dark" dir="up|down" image="" color='']Content for parallax block[/trx_parallax]
*/
function ancora_sc_parallax($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"gap" => "no",
		"dir" => "up",
		"speed" => 0.3,
		"color" => "",
		"bg_tint" => "light",
		"bg_color" => "",
		"bg_image" => "",
		"bg_image_x" => "",
		"bg_image_y" => "",
		"bg_video" => "",
		"bg_video_ratio" => "16:9",
		"bg_overlay" => "",
		"bg_texture" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts)));
	if ($bg_video!='') {
		$info = pathinfo($bg_video);
		$ext = !empty($info['extension']) ? $info['extension'] : 'mp4';
		$bg_video_ratio = empty($bg_video_ratio) ? "16:9" : str_replace(array('/','\\','-'), ':', $bg_video_ratio);
		$ratio = explode(':', $bg_video_ratio);
		$bg_video_width = !empty($width) && ancora_substr($width, -1) >= '0' && ancora_substr($width, -1) <= '9'  ? $width : 1280;
		$bg_video_height = round($bg_video_width / $ratio[0] * $ratio[1]);
		if (ancora_get_theme_option('use_mediaelement')=='yes')
			wp_enqueue_script('wp-mediaelement');
	}
	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}
	$bg_image_x = $bg_image_x!='' ? str_replace('%', '', $bg_image_x).'%' : "50%";
	$bg_image_y = $bg_image_y!='' ? str_replace('%', '', $bg_image_y).'%' : "50%";
	$speed = ($dir=='down' ? -1 : 1) * abs($speed);
	if ($bg_overlay > 0) {
		if ($bg_color=='') $bg_color = ancora_get_theme_bgcolor();
		$rgb = ancora_hex2rgb($bg_color);
	}
	$css .= ancora_get_css_position_from_values($top, '!'.($right), $bottom, '!'.($left), $width, $height)
		. ($color !== '' ? 'color:' . esc_attr($color) . ';' : '')
		. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
		;
	$output = (ancora_sc_param_is_on($gap) ? ancora_sc_gap_start() : '')
		. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_parallax' 
				. ($bg_video!='' ? ' sc_parallax_with_video' : '') 
				. ($bg_tint!='' ? ' bg_tint_'.esc_attr($bg_tint) : '') 
				. (!empty($class) ? ' '.esc_attr($class) : '') 
				. '"' 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. ' data-parallax-speed="'.esc_attr($speed).'"'
			. ' data-parallax-x-pos="'.esc_attr($bg_image_x).'"'
			. ' data-parallax-y-pos="'.esc_attr($bg_image_y).'"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
		. ($bg_video!='' 
			? '<div class="sc_video_bg_wrapper"><video class="sc_video_bg"'
				. ' width="'.esc_attr($bg_video_width).'" height="'.esc_attr($bg_video_height).'" data-width="'.esc_attr($bg_video_width).'" data-height="'.esc_attr($bg_video_height).'" data-ratio="'.esc_attr($bg_video_ratio).'" data-frame="no"'
				. ' preload="metadata" autoplay="autoplay" loop="loop" src="'.esc_attr($bg_video).'"><source src="'.esc_url($bg_video).'" type="video/'.esc_attr($ext).'"></source></video></div>' 
			: '')
		. '<div class="sc_parallax_content" style="' . ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . '); background-position:'.esc_attr($bg_image_x).' '.esc_attr($bg_image_y).';' : '').'">'
		. ($bg_overlay>0 || $bg_texture!=''
			? '<div class="sc_parallax_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
				. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
					. (ancora_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
					. '"'
					. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
					. '>' 
			: '')
		. do_shortcode($content)
		. ($bg_overlay > 0 || $bg_texture!='' ? '</div>' : '')
		. '</div>'
		. '</div>'
		. (ancora_sc_param_is_on($gap) ? ancora_sc_gap_end() : '');
	return apply_filters('ancora_shortcode_output', $output, 'trx_parallax', $atts, $content);
}
// ---------------------------------- [/trx_parallax] ---------------------------------------




// ---------------------------------- [trx_popup] ---------------------------------------

add_shortcode('trx_popup', 'ancora_sc_popup');

/*
[trx_popup id="unique_id" class="class_name" style="css_styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_popup]
*/
function ancora_sc_popup($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	ancora_enqueue_popup('magnific');
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_popup mfp-with-anim mfp-hide' . ($class ? ' '.esc_attr($class) : '') . '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>' 
			. do_shortcode($content) 
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_popup', $atts, $content);
}
// ---------------------------------- [/trx_popup] ---------------------------------------






// ---------------------------------- [trx_price] ---------------------------------------


add_shortcode('trx_price', 'ancora_sc_price');

/*
[trx_price id="unique_id" currency="$" money="29.99" period="monthly"]

*/
function ancora_sc_price($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"money" => "",
		"currency" => "$",
		"period" => "",
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$output = '';
	if (!empty($money)) {
		$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
		$m = explode('.', str_replace(',', '.', $money));
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_price'
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'
			. '<span class="sc_price_currency">'.($currency).'</span>'
			. '<span class="sc_price_money">'.($m[0]).'</span>'
			. (!empty($m[1]) ? '<span class="sc_price_info">' : '')
			. (!empty($m[1]) ? '<span class="sc_price_penny">'.($m[1]).'</span>' : '')
			. (!empty($period) ? '<span class="sc_price_period">'.($period).'</span>' : (!empty($m[1]) ? '<span class="sc_price_period_empty"></span>' : ''))
			. (!empty($m[1]) ? '</span>' : '')
			. '</div>';
	}
	return apply_filters('ancora_shortcode_output', $output, 'trx_price', $atts, $content);
}

// ---------------------------------- [/trx_price] ---------------------------------------





// ---------------------------------- [trx_price_block] ---------------------------------------

add_shortcode('trx_price_block', 'ancora_sc_price_block');

/*
[trx_price id="unique_id" currency="$" money="29.99" period="monthly"]

*/
function ancora_sc_price_block($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => 1,
		"title" => "",
		"link" => "",
		"link_text" => "",
		"icon" => "",
		"money" => "",
		"currency" => "$",
		"period" => "",
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$output = '';
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	if ($money) $money = do_shortcode('[trx_price money="'.esc_attr($money).'" period="'.esc_attr($period).'"'.($currency ? ' currency="'.esc_attr($currency).'"' : '').']');
	$content = do_shortcode($content);
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_price_block sc_price_block_style_'.max(1, min(3, $style))
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. '>'
			. (!empty($title) ? '<div class="sc_price_block_title">'.($title).'</div>' : '')
			. '<div class="sc_price_block_money">'
				. (!empty($icon) ? '<div class="sc_price_block_icon '.esc_attr($icon).'"></div>' : '')
				. ($money)
			. '</div>'
			. (!empty($content) ? '<div class="sc_price_block_description">'.($content).'</div>' : '')
			. (!empty($link_text) ? '<div class="sc_price_block_link">'.do_shortcode('[trx_button link="'.($link ? esc_url($link) : '#').'"]'.($link_text).'[/trx_button]').'</div>' : '')
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_price_block', $atts, $content);
}

// ---------------------------------- [/trx_price_block] ---------------------------------------


// ---------------------------------- [trx_reviews] ---------------------------------------

add_shortcode("trx_reviews", "ancora_sc_reviews");
						
/*
[trx_reviews]
*/

function ancora_sc_reviews($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"align" => "right",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$output = ancora_sc_param_is_off(ancora_get_custom_option('show_sidebar_main'))
		? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_reviews'
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '')
						. ($class ? ' '.esc_attr($class) : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
					. '>'
				. trim(ancora_sc_reviews_placeholder())
				. '</div>'
		: '';
	return apply_filters('ancora_shortcode_output', $output, 'trx_reviews', $atts, $content);
}

function ancora_sc_reviews_placeholder() {
	return '<!-- #TRX_REVIEWS_PLACEHOLDER# -->';
}
	
function ancora_sc_reviews_wrapper($str) {
	$placeholder = ancora_sc_reviews_placeholder();
	if (ancora_strpos($str, $placeholder)!==false) {
		global $ANCORA_GLOBALS;
		if (!empty($ANCORA_GLOBALS['reviews_markup'])) {
			$str = str_replace($placeholder, $ANCORA_GLOBALS['reviews_markup'],	$str);
			$ANCORA_GLOBALS['reviews_markup'] = '';
		}
	}
	return $str;
}

// ---------------------------------- [/trx_reviews] ---------------------------------------




// ---------------------------------- [trx_search] ---------------------------------------


add_shortcode('trx_search', 'ancora_sc_search');

/*
[trx_search id="unique_id" open="yes|no"]
*/
function ancora_sc_search($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "regular",
		"open" => "fixed",
		"ajax" => "",
		"title" => __('Search ...', 'ancora-utils'),
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	if (empty($ajax)) $ajax = ancora_get_theme_option('use_ajax_search');
	// Load core messages
	ancora_enqueue_messages();
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="search_wrap search_style_'.esc_attr($style)
					. (!ancora_sc_param_is_off($open) ? ' search_opened' : '')
					. ($open=='fixed' ? ' search_fixed' : '')
					. (ancora_sc_param_is_on($ajax) ? ' search_ajax' : '')
					. ($class ? ' '.esc_attr($class) : '')
					. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. ' title="' . __('Open/close search form', 'ancora-utils') . '">
					<a href="#" class="search_icon icon-search-2"></a>

					<div class="search_form_wrap">
						<form role="search" method="get" class="search_form" action="' . esc_url( home_url( '/' ) ) . '">
							<button type="submit" class="search_submit" data-text="' .  esc_attr__('Search', 'ancora-utils') . '" title="' . __('Start search', 'ancora-utils') . '"> ' . esc_html__('Search', 'ancora-utils') . '</button>
							<input type="text" class="search_field" placeholder="' . esc_attr($title) . '" value="' . esc_attr(get_search_query()) . '" name="s" title="'.esc_attr($title).'" />
						</form>
					</div>

					<div class="search_results widget_area bg_tint_light"><a class="search_results_close icon-delete-2"></a><div class="search_results_content"></div></div>

			</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_search', $atts, $content);
}

// ---------------------------------- [/trx_search] ---------------------------------------




// ---------------------------------- [trx_section] and [trx_block] ---------------------------------------

add_shortcode('trx_section', 'ancora_sc_section');
add_shortcode('trx_block', 'ancora_sc_section');

/*
[trx_section id="unique_id" class="class_name" style="css-styles" dedicated="yes|no"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_section]
*/

global $ANCORA_GLOBALS;
$ANCORA_GLOBALS['sc_section_dedicated'] = '';

function ancora_sc_section($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"dedicated" => "no",
		"align" => "none",
		"columns" => "none",
		"pan" => "no",
		"scroll" => "no",
		"scroll_dir" => "horizontal",
		"scroll_controls" => "no",
		"color" => "",
		"bg_tint" => "",
		"bg_color" => "",
		"bg_image" => "",
		"bg_overlay" => "",
		"bg_texture" => "",
		"font_size" => "",
		"font_weight" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}

	if ($bg_overlay > 0) {
		if ($bg_color=='') $bg_color = ancora_get_theme_bgcolor();
		$rgb = ancora_hex2rgb($bg_color);
	}

	$css .= ancora_get_css_position_from_values('!'.($top), '!'.($right), '!'.($bottom), '!'.($left))
		.($color !== '' ? 'color:' . esc_attr($color) . ';' : '')
		.($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
		.($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
		.(!ancora_sc_param_is_off($pan) ? 'position:relative;' : '')
		.($font_size != '' ? 'font-size:' . esc_attr(ancora_prepare_css_value($font_size)) . '; line-height: 1.3em;' : '')
		.($font_weight != '' && $font_weight != 'inherit' ? 'font-weight:' . esc_attr($font_weight) . ';' : '');
	$css_dim = ancora_get_css_position_from_values('', '', '', '', $width, $height);
	if ($bg_image == '' && $bg_color == '' && $bg_overlay==0 && $bg_texture==0 && ancora_strlen($bg_texture)<2) $css .= $css_dim;
	
	$width  = ancora_prepare_css_value($width);
	$height = ancora_prepare_css_value($height);

	if ((!ancora_sc_param_is_off($scroll) || !ancora_sc_param_is_off($pan)) && empty($id)) $id = 'sc_section_'.str_replace('.', '', mt_rand());

	if (!ancora_sc_param_is_off($scroll)) ancora_enqueue_slider();

	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_section' 
				. ($class ? ' ' . esc_attr($class) : '') 
				. ($bg_tint ? ' bg_tint_' . esc_attr($bg_tint) : '') 
				. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
				. (!empty($columns) && $columns!='none' ? ' column-'.esc_attr($columns) : '') 
				. (ancora_sc_param_is_on($scroll) && !ancora_sc_param_is_off($scroll_controls) ? ' sc_scroll_controls sc_scroll_controls_'.esc_attr($scroll_dir).' sc_scroll_controls_type_'.esc_attr($scroll_controls) : '')
				. '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
            . ($css!='' ? ' style="'.esc_attr($css).' '. ($css_dim).'"' : '').'>'
			. ($bg_image !== '' || $bg_color !== '' || $bg_overlay>0 || $bg_texture>0 || ancora_strlen($bg_texture)>2
				? '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
					. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
						. (ancora_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
						. '"'
						. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
						. '>'
						. '<div class="sc_section_content">'
				: '')
			. (ancora_sc_param_is_on($scroll)
				? '<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_'.esc_attr($scroll_dir).' swiper-slider-container scroll-container"'
					. ' style="'.($height != '' ? 'height:'.esc_attr($height).';' : '') . ($width != '' ? 'width:'.esc_attr($width).';' : '').'"'
					. '>'
					. '<div class="sc_scroll_wrapper swiper-wrapper">' 
					. '<div class="sc_scroll_slide swiper-slide">' 
				: '')
			. (ancora_sc_param_is_on($pan)
				? '<div id="'.esc_attr($id).'_pan" class="sc_pan sc_pan_'.esc_attr($scroll_dir).'">' 
				: '')
			. do_shortcode($content)
			. (ancora_sc_param_is_on($pan) ? '</div>' : '')
			. (ancora_sc_param_is_on($scroll)
				? '</div></div><div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.esc_attr($scroll_dir).' '.esc_attr($id).'_scroll_bar"></div></div>'
					. (!ancora_sc_param_is_off($scroll_controls) ? '<div class="sc_scroll_controls_wrap"><a class="sc_scroll_prev" href="#"></a><a class="sc_scroll_next" href="#"></a></div>' : '')
				: '')
			. ($bg_image !== '' || $bg_color !== '' || $bg_overlay > 0 || $bg_texture>0 || ancora_strlen($bg_texture)>2 ? '</div></div>' : '')
		. '</div>';
	if (ancora_sc_param_is_on($dedicated)) {
	    global $ANCORA_GLOBALS;
		if ($ANCORA_GLOBALS['sc_section_dedicated']=='') {
			$ANCORA_GLOBALS['sc_section_dedicated'] = $output;
		}
		$output = '';
	}
	return apply_filters('ancora_shortcode_output', $output, 'trx_section', $atts, $content);
}

function ancora_sc_clear_dedicated_content() {
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_section_dedicated'] = '';
}

function ancora_sc_get_dedicated_content() {
	global $ANCORA_GLOBALS;
	return $ANCORA_GLOBALS['sc_section_dedicated'];
}
// ---------------------------------- [/trx_section] ---------------------------------------





// ---------------------------------- [trx_skills] ---------------------------------------


add_shortcode('trx_skills', 'ancora_sc_skills');

/*
[trx_skills id="unique_id" type="bar|pie|arc|counter" dir="horizontal|vertical" layout="rows|columns" count="" max_value="100" align="left|right"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
	[trx_skills_item title="Scelerisque pid" value="50%"]
[/trx_skills]
*/
function ancora_sc_skills($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"max_value" => "100",
		"type" => "bar",
		"layout" => "",
		"dir" => "",
		"pie_compact" => "on",
		"pie_cutout" => 0,
		"style" => "1",
		"columns" => "",
		"align" => "",
		"color" => "",
		"bg_color" => "",
		"border_color" => "",
		"title" => "",
		"subtitle" => __("Skills", 'ancora-utils'),
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
    global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_skills_counter'] = 0;
	$ANCORA_GLOBALS['sc_skills_columns'] = 0;
	$ANCORA_GLOBALS['sc_skills_height']  = 0;
	$ANCORA_GLOBALS['sc_skills_type']    = $type;
	$ANCORA_GLOBALS['sc_skills_pie_compact'] = $pie_compact;
	$ANCORA_GLOBALS['sc_skills_pie_cutout']  = max(0, min(100, $pie_cutout));
	$ANCORA_GLOBALS['sc_skills_color']   = $color;
	$ANCORA_GLOBALS['sc_skills_bg_color']= $bg_color;
	$ANCORA_GLOBALS['sc_skills_border_color']= $border_color;
	$ANCORA_GLOBALS['sc_skills_legend']  = '';
	$ANCORA_GLOBALS['sc_skills_data']    = '';
	ancora_enqueue_diagram($type);
	if ($type!='arc') {
		if ($layout=='' || ($layout=='columns' && $columns<1)) $layout = 'rows';
		if ($layout=='columns') $ANCORA_GLOBALS['sc_skills_columns'] = $columns;
		if ($type=='bar') {
			if ($dir == '') $dir = 'horizontal';
			if ($dir == 'vertical' && $height < 1) $height = 300;
		}
	}
	if (empty($id)) $id = 'sc_skills_diagram_'.str_replace('.','',mt_rand());
	if ($max_value < 1) $max_value = 100;
	if ($style) {
		$style = max(1, min(4, $style));
		$ANCORA_GLOBALS['sc_skills_style'] = $style;
	}
	$ANCORA_GLOBALS['sc_skills_max'] = $max_value;
	$ANCORA_GLOBALS['sc_skills_dir'] = $dir;
	$ANCORA_GLOBALS['sc_skills_height'] = ancora_prepare_css_value($height);
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width, $height);
	$content = do_shortcode($content);
	$output = ($type!='arc' && ($type!='pie' || !ancora_sc_param_is_on($pie_compact)) && $title!='' ? '<h3 class="sc_skills_title">'.($title).'</h3>' : '')
			. '<div id="'.esc_attr($id).'"' 
				. ' class="sc_skills sc_skills_' . esc_attr($type) 
					. ($type=='bar' ? ' sc_skills_'.esc_attr($dir) : '') 
					. ($type=='pie' ? ' sc_skills_compact_'.esc_attr($pie_compact) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. ' data-type="'.esc_attr($type).'"'
				. ' data-subtitle="'.esc_attr($subtitle).'"'
				. ($type=='bar' ? ' data-dir="'.esc_attr($dir).'"' : '')
			. '>'
				. ($layout == 'columns' ? '<div class="columns_wrap sc_skills_'.esc_attr($layout).' sc_skills_columns_'.esc_attr($columns).'">' : '')
				. ($type=='arc' 
					? ('<div class="sc_skills_legend">'.($title!='' ? '<h6 class="sc_skills_title">'.($title).'</h6>' : '').($ANCORA_GLOBALS['sc_skills_legend']).'</div>'
						. '<div id="'.esc_attr($id).'_diagram" class="sc_skills_arc_canvas"></div>'
						. '<div class="sc_skills_data" style="display:none;">' . ($ANCORA_GLOBALS['sc_skills_data']) . '</div>'
					  )
					: '')
				. ($type=='pie' && ancora_sc_param_is_on($pie_compact)
					? ('<div class="sc_skills_legend">'.($title!='' ? '<h6 class="sc_skills_title">'.($title).'</h6>' : '').($ANCORA_GLOBALS['sc_skills_legend']).'</div>'
						. '<div id="'.esc_attr($id).'_pie" class="sc_skills_item">'
							. '<canvas id="'.esc_attr($id).'_pie" class="sc_skills_pie_canvas"></canvas>'
							. '<div class="sc_skills_data" style="display:none;">' . ($ANCORA_GLOBALS['sc_skills_data']) . '</div>'
						. '</div>'
					  )
					: '')
				. ($content)
				. ($layout == 'columns' ? '</div>' : '')
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_skills', $atts, $content);
}


add_shortcode('trx_skills_item', 'ancora_sc_skills_item');

function ancora_sc_skills_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"title" => "",
		"value" => "",
		"color" => "",
		"bg_color" => "",
		"border_color" => "",
		"style" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_skills_counter']++;
	$ed = ancora_substr($value, -1)=='%' ? '%' : '';
	$value = str_replace('%', '', $value);
	if ($ANCORA_GLOBALS['sc_skills_max'] < $value) $ANCORA_GLOBALS['sc_skills_max'] = $value;
	$percent = round($value / $ANCORA_GLOBALS['sc_skills_max'] * 100);
	$start = 0;
	$stop = $value;
	$steps = 100;
	$step = max(1, round($ANCORA_GLOBALS['sc_skills_max']/$steps));
	$speed = mt_rand(10,40);
	$animation = round(($stop - $start) / $step * $speed);
	$title_block = '<div class="sc_skills_info"><div class="sc_skills_label">' . ($title) . '</div></div>';
	$old_color = $color;
	if (empty($color)) $color = $ANCORA_GLOBALS['sc_skills_color'];
	if (empty($color)) $color = ancora_get_custom_option('link_color');
	$color = apply_filters('ancora_filter_get_link_color', $color);
	if (empty($bg_color)) $bg_color = $ANCORA_GLOBALS['sc_skills_bg_color'];
	if (empty($bg_color)) $bg_color = '#f4f7f9';
	if (empty($border_color)) $border_color = $ANCORA_GLOBALS['sc_skills_border_color'];
	if (empty($border_color)) $border_color = '#ffffff';
	if (empty($style)) $style = $ANCORA_GLOBALS['sc_skills_style'];
	$style = max(1, min(4, $style));
	$output = '';
	if ($ANCORA_GLOBALS['sc_skills_type'] == 'arc' || ($ANCORA_GLOBALS['sc_skills_type'] == 'pie' && ancora_sc_param_is_on($ANCORA_GLOBALS['sc_skills_pie_compact']))) {
		if ($ANCORA_GLOBALS['sc_skills_type'] == 'arc' && empty($old_color)) {
			$rgb = ancora_hex2rgb($color);
			$color = 'rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.(1 - 0.1*($ANCORA_GLOBALS['sc_skills_counter']-1)).')';
		}
		$ANCORA_GLOBALS['sc_skills_legend'] .= '<div class="sc_skills_legend_item"><span class="sc_skills_legend_marker" style="background-color:'.esc_attr($color).'"></span><span class="sc_skills_legend_title">' . ($title) . '</span><span class="sc_skills_legend_value">' . ($value) . '</span></div>';
		$ANCORA_GLOBALS['sc_skills_data'] .= '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="'.esc_attr($ANCORA_GLOBALS['sc_skills_type']).'"'
			. ($ANCORA_GLOBALS['sc_skills_type']=='pie'
				? ( ' data-start="'.esc_attr($start).'"'
					. ' data-stop="'.esc_attr($stop).'"'
					. ' data-step="'.esc_attr($step).'"'
					. ' data-steps="'.esc_attr($steps).'"'
					. ' data-max="'.esc_attr($ANCORA_GLOBALS['sc_skills_max']).'"'
					. ' data-speed="'.esc_attr($speed).'"'
					. ' data-duration="'.esc_attr($animation).'"'
					. ' data-color="'.esc_attr($color).'"'
					. ' data-bg_color="'.esc_attr($bg_color).'"'
					. ' data-border_color="'.esc_attr($border_color).'"'
					. ' data-cutout="'.esc_attr($ANCORA_GLOBALS['sc_skills_pie_cutout']).'"'
					. ' data-easing="easeOutCirc"'
					. ' data-ed="'.esc_attr($ed).'"'
					)
				: '')
			. '><input type="hidden" class="text" value="'.esc_attr($title).'" /><input type="hidden" class="percent" value="'.esc_attr($percent).'" /><input type="hidden" class="color" value="'.esc_attr($color).'" /></div>';
	} else {
		$output .= ($ANCORA_GLOBALS['sc_skills_columns'] > 0 ? '<div class="sc_skills_column column-1_'.esc_attr($ANCORA_GLOBALS['sc_skills_columns']).'">' : '')
				. ($ANCORA_GLOBALS['sc_skills_type']=='bar' && $ANCORA_GLOBALS['sc_skills_dir']=='horizontal' ? $title_block : '')
				. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_skills_item' . ($style ? ' sc_skills_style_'.esc_attr($style) : '') 
						. (!empty($class) ? ' '.esc_attr($class) : '')
						. ($ANCORA_GLOBALS['sc_skills_counter'] % 2 == 1 ? ' odd' : ' even')
						. ($ANCORA_GLOBALS['sc_skills_counter'] == 1 ? ' first' : '')
						. '"'
					. ($ANCORA_GLOBALS['sc_skills_height'] !='' || $css ? ' style="height: '.esc_attr($ANCORA_GLOBALS['sc_skills_height']).';'.($css).'"' : '')
				. '>';
		if (in_array($ANCORA_GLOBALS['sc_skills_type'], array('bar', 'counter'))) {
			$output .=
                '<div class="sc_skills_count"' . ($ANCORA_GLOBALS['sc_skills_type']=='bar' && $color ? ' style="background-color:' . esc_attr($color) . '; border-color:' . esc_attr($color) . '"' : '') . '>'
				. '</div>'
                . '<div class="sc_skills_total"'
                . ' data-start="'.esc_attr($start).'"'
                . ' data-stop="'.esc_attr($stop).'"'
                . ' data-step="'.esc_attr($step).'"'
                . ' data-max="'.esc_attr($ANCORA_GLOBALS['sc_skills_max']).'"'
                . ' data-speed="'.esc_attr($speed).'"'
                . ' data-duration="'.esc_attr($animation).'"'
                . ' data-ed="'.esc_attr($ed).'">'
                . ($start) . ($ed)
                .'</div>';
		} else if ($ANCORA_GLOBALS['sc_skills_type']=='pie') {
			if (empty($id)) $id = 'sc_skills_canvas_'.str_replace('.','',mt_rand());
			$output .= '<canvas id="'.esc_attr($id).'"></canvas>'
				. '<div class="sc_skills_total"'
					. ' data-start="'.esc_attr($start).'"'
					. ' data-stop="'.esc_attr($stop).'"'
					. ' data-step="'.esc_attr($step).'"'
					. ' data-steps="'.esc_attr($steps).'"'
					. ' data-max="'.esc_attr($ANCORA_GLOBALS['sc_skills_max']).'"'
					. ' data-speed="'.esc_attr($speed).'"'
					. ' data-duration="'.esc_attr($animation).'"'
					. ' data-color="'.esc_attr($color).'"'
					. ' data-bg_color="'.esc_attr($bg_color).'"'
					. ' data-border_color="'.esc_attr($border_color).'"'
					. ' data-cutout="'.esc_attr($ANCORA_GLOBALS['sc_skills_pie_cutout']).'"'
					. ' data-easing="easeOutCirc"'
					. ' data-ed="'.esc_attr($ed).'">'
					. ($start) . ($ed)
				.'</div>';
		}
		$output .= 
				  ($ANCORA_GLOBALS['sc_skills_type']=='counter' ? $title_block : '')
				. '</div>'
				. ($ANCORA_GLOBALS['sc_skills_type']=='bar' && $ANCORA_GLOBALS['sc_skills_dir']=='vertical' || $ANCORA_GLOBALS['sc_skills_type'] == 'pie' ? $title_block : '')
				. ($ANCORA_GLOBALS['sc_skills_columns'] > 0 ? '</div>' : '');
	}
	return apply_filters('ancora_shortcode_output', $output, 'trx_skills_item', $atts, $content);
}

// ---------------------------------- [/trx_skills] ---------------------------------------






// ---------------------------------- [trx_slider] ---------------------------------------

add_shortcode('trx_slider', 'ancora_sc_slider');

/*
[trx_slider id="unique_id" engine="revo|royal|flex|swiper|chop" alias="revolution_slider_alias|royal_slider_id" titles="no|slide|fixed" cat="id|slug" count="posts_number" ids="comma_separated_id_list" offset="" width="" height="" align="" top="" bottom=""]
[trx_slider_item src="image_url"]
[/trx_slider]
*/

function ancora_sc_slider($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"engine" => ancora_get_custom_option('substitute_slider_engine'),
		"custom" => "no",
		"alias" => "",
		"post_type" => "post",
		"ids" => "",
		"cat" => "",
		"count" => "0",
		"offset" => "",
		"orderby" => "date",
		"order" => 'desc',
		"controls" => "no",
		"pagination" => "no",
		"titles" => "no",
		"descriptions" => ancora_get_custom_option('slider_info_descriptions'),
		"links" => "no",
		"align" => "",
		"interval" => "",
		"date_format" => "",
		"crop" => "yes",
		"autoheight" => "no",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	if (empty($width) && $pagination!='full') $width = "100%";
	if (empty($height) && ($pagination=='full' || $pagination=='over')) $height = 250;
	if (!empty($height) && ancora_sc_param_is_on($autoheight)) $autoheight = "off";
	if (empty($interval)) $interval = mt_rand(5000, 10000);
	
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_slider_engine'] = $engine;
	$ANCORA_GLOBALS['sc_slider_width']  = ancora_prepare_css_value($width);
	$ANCORA_GLOBALS['sc_slider_height'] = ancora_prepare_css_value($height);
	$ANCORA_GLOBALS['sc_slider_links']  = ancora_sc_param_is_on($links);
	$ANCORA_GLOBALS['sc_slider_bg_image'] = false;
	$ANCORA_GLOBALS['sc_slider_crop_image'] = $crop;

	if (empty($id)) $id = "sc_slider_".str_replace('.', '', mt_rand());
	
	$ms = ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$ws = ancora_get_css_position_from_values('', '', '', '', $width);
	$hs = ancora_get_css_position_from_values('', '', '', '', '', $height);

	$css .= (!in_array($pagination, array('full', 'over')) ? $ms : '') . ($hs) . ($ws);
	
	if ($engine!='swiper' && in_array($pagination, array('full', 'over'))) $pagination = 'yes';
	
	$output = (in_array($pagination, array('full', 'over')) 
				? '<div class="sc_slider_pagination_area sc_slider_pagination_'.esc_attr($pagination)
						. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
						. '"'
					. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
					. (($ms).($hs) ? ' style="'.esc_attr(($ms).($hs)).'"' : '') 
					.'>' 
				: '')
			. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_slider sc_slider_' . esc_attr($engine)
				. ($engine=='swiper' ? ' swiper-slider-container' : '')
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. (ancora_sc_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
				. ($hs ? ' sc_slider_height_fixed' : '')
				. (ancora_sc_param_is_on($controls) ? ' sc_slider_controls' : ' sc_slider_nocontrols')
				. (ancora_sc_param_is_on($pagination) ? ' sc_slider_pagination' : ' sc_slider_nopagination')
				. (!in_array($pagination, array('full', 'over')) && $align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
				. '"'
			. (!in_array($pagination, array('full', 'over')) && !ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. (!empty($width) && ancora_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
			. (!empty($height) && ancora_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
			. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
		. '>';

	ancora_enqueue_slider($engine);

	if ($engine=='revo') {
		if (ancora_exists_revslider() && !empty($alias))
			$output .= do_shortcode('[rev_slider '.esc_attr($alias).']');
		else
			$output = '';
	} else if ($engine=='swiper') {
		
		$caption = '';

		$output .= '<div class="slides'
			.($engine=='swiper' ? ' swiper-wrapper' : '').'"'
			.($engine=='swiper' && $ANCORA_GLOBALS['sc_slider_bg_image'] ? ' style="'.esc_attr($hs).'"' : '')
			.'>';

		$content = do_shortcode($content);
		
		if (ancora_sc_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
	
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
		
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
	
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
	
			$args = ancora_query_add_sort_order($args, $orderby, $order);
			$args = ancora_query_add_filters($args, 'thumbs');
			$args = ancora_query_add_posts_and_cats($args, $ids, $post_type, $cat);

			$query = new WP_Query( $args );

			$post_number = 0;
			$pagination_items = '';
			$show_image 	= 1;
			$show_types 	= 0;
			$show_date 		= 1;
			$show_author 	= 0;
			$show_links 	= 0;
			$show_counters	= 'views';	//comments | rating
			
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$post_id = get_the_ID();
				$post_type = get_post_type();
				$post_title = get_the_title();
				$post_link = get_permalink();
				$post_date = get_the_date(!empty($date_format) ? $date_format : 'd.m.y');
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
				if (ancora_sc_param_is_on($crop)) {
					$post_attachment = $ANCORA_GLOBALS['sc_slider_bg_image']
						? ancora_get_resized_image_url($post_attachment, !empty($width) && (float) $width.' ' == $width.' ' ? $width : null, !empty($height) && (float) $height.' ' == $height.' ' ? $height : null)
						: ancora_get_resized_image_tag($post_attachment, !empty($width) && (float) $width.' ' == $width.' ' ? $width : null, !empty($height) && (float) $height.' ' == $height.' ' ? $height : null);
				} else if (!$ANCORA_GLOBALS['sc_slider_bg_image']) {
					$post_attachment = '<img src="'.esc_url($post_attachment).'" alt="">';
				}
				$post_accent_color = '';
				$post_category = '';
				$post_category_link = '';

				if (in_array($pagination, array('full', 'over'))) {
					$old_output = $output;
					$output = '';
					require(ancora_get_file_dir('templates/parts/widgets-posts.php'));
					$pagination_items .= $output;
					$output = $old_output;
				}
				$output .= '<div' 
					. ' class="'.esc_attr($engine).'-slide"'
					. ' data-style="'.esc_attr(($ws).($hs)).'"'
					. ' style="'
						. ($ANCORA_GLOBALS['sc_slider_bg_image'] ? 'background-image:url(' . esc_url($post_attachment) . ');' : '') . ($ws) . ($hs)
						. '"'
					. '>' 
					. (ancora_sc_param_is_on($links) ? '<a href="'.esc_url($post_link).'" title="'.esc_attr($post_title).'">' : '')
					. (!$ANCORA_GLOBALS['sc_slider_bg_image'] ? $post_attachment : '')
					;
				$caption = $engine=='swiper' ? '' : $caption;
				if (!ancora_sc_param_is_off($titles)) {
					$post_hover_bg  = ancora_get_custom_option('link_color', null, $post_id);
					$post_bg = '';
					if ($post_hover_bg!='' && !ancora_is_inherit_option($post_hover_bg)) {
						$rgb = ancora_hex2rgb($post_hover_bg);
						$post_hover_ie = str_replace('#', '', $post_hover_bg);
						$post_bg = "background-color: rgba({$rgb['r']},{$rgb['g']},{$rgb['b']},0.8);";
					}
					$caption .= '<div class="sc_slider_info' . ($titles=='fixed' ? ' sc_slider_info_fixed' : '') . ($engine=='swiper' ? ' content-slide' : '') . '"'.($post_bg!='' ? ' style="'.esc_attr($post_bg).'"' : '').'>';
					$post_descr = ancora_get_post_excerpt();
					if (ancora_get_custom_option("slider_info_category")=='yes') { // || empty($cat)) {
						// Get all post's categories
						$post_tax = ancora_get_taxonomy_categories_by_post_type($post_type);
						if (!empty($post_tax)) {
							$post_terms = ancora_get_terms_by_post_id(array('post_id'=>$post_id, 'taxonomy'=>$post_tax));
							if (!empty($post_terms[$post_tax])) {
								if (!empty($post_terms[$post_tax]->closest_parent)) {
									$post_category = $post_terms[$post_tax]->closest_parent->name;
									$post_category_link = $post_terms[$post_tax]->closest_parent->link;
									//$post_accent_color = ancora_taxonomy_get_inherited_property($post_tax, $post_terms[$post_tax]->closest_parent->term_id, 'link_color');
								}
								/*
								if ($post_accent_color == '' && !empty($post_terms[$post_tax]->terms)) {
									for ($i = 0; $i < count($post_terms[$post_tax]->terms); $i++) {
										$post_accent_color = ancora_taxonomy_get_inherited_property($post_tax, $post_terms[$post_tax]->terms[$i]->term_id, 'link_color');
										if ($post_accent_color != '') break;
									}
								}
								*/
								if ($post_category!='') {
									$caption .= '<div class="sc_slider_category"'.(ancora_substr($post_accent_color, 0, 1)=='#' ? ' style="background-color: '.esc_attr($post_accent_color).'"' : '').'><a href="'.esc_url($post_category_link).'">'.($post_category).'</a></div>';
								}
							}
						}
					}
					$output_reviews = '';
					if (ancora_get_custom_option('show_reviews')=='yes' && ancora_get_custom_option('slider_info_reviews')=='yes') {
						$avg_author = ancora_reviews_marks_to_display(get_post_meta($post_id, 'reviews_avg'.((ancora_get_theme_option('reviews_first')=='author' && $orderby != 'users_rating') || $orderby == 'author_rating' ? '' : '2'), true));
						if ($avg_author > 0) {
							$output_reviews .= '<div class="sc_slider_reviews post_rating reviews_summary blog_reviews' . (ancora_get_custom_option("slider_info_category")=='yes' ? ' after_category' : '') . '">'
								. '<div class="criteria_summary criteria_row">' . trim(ancora_reviews_get_summary_stars($avg_author, false, false, 5)) . '</div>'
								. '</div>';
						}
					}
					if (ancora_get_custom_option("slider_info_category")=='yes') $caption .= $output_reviews;
					$caption .= '<h3 class="sc_slider_subtitle"><a href="'.esc_url($post_link).'">'.($post_title).'</a></h3>';
					if (ancora_get_custom_option("slider_info_category")!='yes') $caption .= $output_reviews;
					if ($descriptions > 0) {
						$caption .= '<div class="sc_slider_descr">'.trim(ancora_strshort($post_descr, $descriptions)).'</div>';
					}
					$caption .= '</div>';
				}
				$output .= ($engine=='swiper' ? $caption : '') . (ancora_sc_param_is_on($links) ? '</a>' : '' ) . '</div>';
			}
			wp_reset_postdata();
		}

		$output .= '</div>';
		if ($engine=='swiper') {
			if (ancora_sc_param_is_on($controls))
				$output .= '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>';
			if (ancora_sc_param_is_on($pagination))
				$output .= '<div class="sc_slider_pagination_wrap"></div>';
		}
	
	} else
		$output = '';
	
	if (!empty($output)) {
		$output .= '</div>';
		if ($pagination_items) {
			$output .= '
				<div class="sc_slider_pagination widget_area"'.($hs ? ' style="'.esc_attr($hs).'"' : '').'>
					<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_vertical swiper-slider-container scroll-container"'.($hs ? ' style="'.esc_attr($hs).'"' : '').'>
						<div class="sc_scroll_wrapper swiper-wrapper">
							<div class="sc_scroll_slide swiper-slide">
								'.($pagination_items).'
							</div>
						</div>
						<div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_vertical"></div>
					</div>
				</div>';
			$output .= '</div>';
		}
	}

	return apply_filters('ancora_shortcode_output', $output, 'trx_slider', $atts, $content);
}


add_shortcode('trx_slider_item', 'ancora_sc_slider_item');

function ancora_sc_slider_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"src" => "",
		"url" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$src = $src!='' ? $src : $url;
	if ($src > 0) {
		$attach = wp_get_attachment_image_src( $src, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$src = $attach[0];
	}

	if ($src && ancora_sc_param_is_on($ANCORA_GLOBALS['sc_slider_crop_image'])) {
		$image = $ANCORA_GLOBALS['sc_slider_bg_image']
			? ancora_get_resized_image_url($src, !empty($ANCORA_GLOBALS['sc_slider_width']) && ancora_strpos($ANCORA_GLOBALS['sc_slider_width'], '%')===false ? $ANCORA_GLOBALS['sc_slider_width'] : null, !empty($ANCORA_GLOBALS['sc_slider_height']) && ancora_strpos($ANCORA_GLOBALS['sc_slider_height'], '%')===false ? $ANCORA_GLOBALS['sc_slider_height'] : null)
			: ancora_get_resized_image_tag($src, !empty($ANCORA_GLOBALS['sc_slider_width']) && ancora_strpos($ANCORA_GLOBALS['sc_slider_width'], '%')===false ? $ANCORA_GLOBALS['sc_slider_width'] : null, !empty($ANCORA_GLOBALS['sc_slider_height']) && ancora_strpos($ANCORA_GLOBALS['sc_slider_height'], '%')===false ? $ANCORA_GLOBALS['sc_slider_height'] : null);
	} else if ($src && !$ANCORA_GLOBALS['sc_slider_bg_image']) {
		$src = '<img src="'.esc_url($src).'" alt="">';
	}

	$css .= ($ANCORA_GLOBALS['sc_slider_bg_image'] ? 'background-image:url(' . esc_url($src) . ');' : '')
			. (!empty($ANCORA_GLOBALS['sc_slider_width'])  ? 'width:'  . esc_attr($ANCORA_GLOBALS['sc_slider_width'])  . ';' : '')
			. (!empty($ANCORA_GLOBALS['sc_slider_height']) ? 'height:' . esc_attr($ANCORA_GLOBALS['sc_slider_height']) . ';' : '');

	$content = do_shortcode($content);

	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '').' class="'.esc_attr($ANCORA_GLOBALS['sc_slider_engine']).'-slide' . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ($css ? ' style="'.esc_attr($css).'"' : '')
			.'>' 
			. ($src && ancora_sc_param_is_on($ANCORA_GLOBALS['sc_slider_links']) ? '<a href="'.esc_url($src).'">' : '')
			. ($src && !$ANCORA_GLOBALS['sc_slider_bg_image'] ? $src : $content)
			. ($src && ancora_sc_param_is_on($ANCORA_GLOBALS['sc_slider_links']) ? '</a>' : '')
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_slider_item', $atts, $content);
}
// ---------------------------------- [/trx_slider] ---------------------------------------





// ---------------------------------- [trx_socials] ---------------------------------------


add_shortcode('trx_socials', 'ancora_sc_socials');

/*
[trx_socials id="unique_id" size="small"]
	[trx_social_item name="facebook" url="profile url" icon="path for the icon"]
	[trx_social_item name="twitter" url="profile url"]
[/trx_socials]
*/
function ancora_sc_socials($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"size" => "small",	// tiny | small | large
		"socials" => "",
		"custom" => "no",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_social_icons'] = false;
	if (!empty($socials)) {
		$allowed = explode('|', $socials);
		$list = array();
		for ($i=0; $i<count($allowed); $i++) {
			$s = explode('=', $allowed[$i]);
			if (!empty($s[1])) {
				$list[] = array(
					'icon'	=> $s[0],
					'url'	=> $s[1]
					);
			}
		}
		if (count($list) > 0) $ANCORA_GLOBALS['sc_social_icons'] = $list;
	} else if (ancora_sc_param_is_off($custom))
		$content = do_shortcode($content);
	if ($ANCORA_GLOBALS['sc_social_icons']===false) $ANCORA_GLOBALS['sc_social_icons'] = ancora_get_custom_option('social_icons');
	$output = ancora_prepare_socials($ANCORA_GLOBALS['sc_social_icons']);
	$output = $output
		? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_socials sc_socials_size_' . esc_attr($size) . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>' 
			. ($output)
			. '</div>'
		: '';
	return apply_filters('ancora_shortcode_output', $output, 'trx_socials', $atts, $content);
}



add_shortcode('trx_social_item', 'ancora_sc_social_item');

function ancora_sc_social_item($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"name" => "",
		"url" => "",
		"icon" => ""
    ), $atts)));
	global $ANCORA_GLOBALS;
	if (!empty($name) && empty($icon) && file_exists(ancora_get_socials_dir($name.'.png')))
		$icon = ancora_get_socials_url($name.'.png');
	if (!empty($icon) && !empty($url)) {
		if ($ANCORA_GLOBALS['sc_social_icons']===false) $ANCORA_GLOBALS['sc_social_icons'] = array();
		$ANCORA_GLOBALS['sc_social_icons'][] = array(
			'icon' => $icon,
			'url' => $url
		);
	}
	return '';
}

// ---------------------------------- [/trx_socials] ---------------------------------------





// ---------------------------------- [trx_table] ---------------------------------------


add_shortcode('trx_table', 'ancora_sc_table');

/*
[trx_table id="unique_id" style="1"]
Table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/
[/trx_table]
*/
function ancora_sc_table($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"align" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "100%"
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width);
	$content = str_replace(
				array('<p><table', 'table></p>', '><br />'),
				array('<table', 'table>', '>'),
				html_entity_decode($content, ENT_COMPAT, 'UTF-8'));
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_table' 
				. (!empty($align) && $align!='none' ? ' align'.esc_attr($align) : '') 
				. (!empty($class) ? ' '.esc_attr($class) : '') 
				. '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			.'>' 
			. do_shortcode($content) 
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_table', $atts, $content);
}

// ---------------------------------- [/trx_table] ---------------------------------------






// ---------------------------------- [trx_tabs] ---------------------------------------

add_shortcode("trx_tabs", "ancora_sc_tabs");

/*
[trx_tabs id="unique_id" tab_names="Planning|Development|Support" style="1|2" initial="1 - num_tabs"]
	[trx_tab]Randomised words which don't look even slightly believable. If you are going to use a passage. You need to be sure there isn't anything embarrassing hidden in the middle of text established fact that a reader will be istracted by the readable content of a page when looking at its layout.[/trx_tab]
	[trx_tab]Fact reader will be distracted by the <a href="#" class="main_link">readable content</a> of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have evolved over. There are many variations of passages of Lorem Ipsum available, but the majority.[/trx_tab]
	[trx_tab]Distracted by the  readable content  of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have  evolved over.  There are many variations of passages of Lorem Ipsum available.[/trx_tab]
[/trx_tabs]
*/
function ancora_sc_tabs($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"initial" => "1",
		"scroll" => "no",
		"style" => "1",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width);

	if (!ancora_sc_param_is_off($scroll)) ancora_enqueue_slider();
	if (empty($id)) $id = 'sc_tabs_'.str_replace('.', '', mt_rand());

	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_tab_counter'] = 0;
	$ANCORA_GLOBALS['sc_tab_scroll'] = $scroll;
	$ANCORA_GLOBALS['sc_tab_height'] = ancora_prepare_css_value($height);
	$ANCORA_GLOBALS['sc_tab_id']     = $id;
	$ANCORA_GLOBALS['sc_tab_titles'] = array();

	$content = do_shortcode($content);

	$sc_tab_titles = $ANCORA_GLOBALS['sc_tab_titles'];

	$initial = max(1, min(count($sc_tab_titles), (int) $initial));

	$tabs_output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_tabs sc_tabs_style_'.esc_attr($style) . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
						. ' data-active="' . ($initial-1) . '"'
						. '>'
					.'<ul class="sc_tabs_titles">';
	$titles_output = '';
	for ($i = 0; $i < count($sc_tab_titles); $i++) {
		$classes = array('sc_tabs_title');
		if ($i == 0) $classes[] = 'first';
		else if ($i == count($sc_tab_titles) - 1) $classes[] = 'last';
		$titles_output .= '<li class="'.join(' ', $classes).'">'
							. '<a href="#'.esc_attr($sc_tab_titles[$i]['id']).'" class="theme_button" id="'.esc_attr($sc_tab_titles[$i]['id']).'_tab">' . ($sc_tab_titles[$i]['title']) . '</a>'
							. '</li>';
	}

	wp_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
	wp_enqueue_script('jquery-effects-fade', false, array('jquery','jquery-effects-core'), null, true);

	$tabs_output .= $titles_output
		. '</ul>' 
		. ($content)
		.'</div>';
	return apply_filters('ancora_shortcode_output', $tabs_output, 'trx_tabs', $atts, $content);
}


add_shortcode("trx_tab", "ancora_sc_tab");

function ancora_sc_tab($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"tab_id" => "",		// get it from VC
		"title" => "",		// get it from VC
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
    ), $atts)));
    global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_tab_counter']++;
	if (empty($id))
		$id = !empty($tab_id) ? $tab_id : ($ANCORA_GLOBALS['sc_tab_id']).'_'.($ANCORA_GLOBALS['sc_tab_counter']);
	$sc_tab_titles = $ANCORA_GLOBALS['sc_tab_titles'];
	if (isset($sc_tab_titles[$ANCORA_GLOBALS['sc_tab_counter']-1])) {
		$sc_tab_titles[$ANCORA_GLOBALS['sc_tab_counter']-1]['id'] = $id;
		if (!empty($title))
			$sc_tab_titles[$ANCORA_GLOBALS['sc_tab_counter']-1]['title'] = $title;
	} else {
		$sc_tab_titles[] = array(
			'id' => $id,
			'title' => $title
		);
	}
	$ANCORA_GLOBALS['sc_tab_titles'] = $sc_tab_titles;
	$output = '<div id="'.esc_attr($id).'"'
				.' class="sc_tabs_content' 
					. ($ANCORA_GLOBALS['sc_tab_counter'] % 2 == 1 ? ' odd' : ' even')
					. ($ANCORA_GLOBALS['sc_tab_counter'] == 1 ? ' first' : '')
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>' 
			. (ancora_sc_param_is_on($ANCORA_GLOBALS['sc_tab_scroll'])
				? '<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_vertical" style="height:'.($ANCORA_GLOBALS['sc_tab_height'] != '' ? $ANCORA_GLOBALS['sc_tab_height'] : '200px').';"><div class="sc_scroll_wrapper swiper-wrapper"><div class="sc_scroll_slide swiper-slide">'
				: '')
			. do_shortcode($content) 
			. (ancora_sc_param_is_on($ANCORA_GLOBALS['sc_tab_scroll'])
				? '</div></div><div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_vertical '.esc_attr($id).'_scroll_bar"></div></div>' 
				: '')
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_tab', $atts, $content);
}
// ---------------------------------- [/trx_tabs] ---------------------------------------






// ---------------------------------- [trx_team] ---------------------------------------


add_shortcode('trx_team', 'ancora_sc_team');

/*
[trx_team id="unique_id" style="normal|big"]
	[trx_team_item user="user_login"]
[/trx_team]
*/
function ancora_sc_team($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => 1,
		"columns" => 3,
		"custom" => "no",
		"ids" => "",
		"cat" => "",
		"count" => 3,
		"offset" => "",
		"orderby" => "date",
		"order" => "desc",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$count = max(1, (int) $count);
	$columns = max(1, min(4, (int) $columns));
	if (ancora_sc_param_is_off($custom) && $count < $columns) $columns = $count;
	global $ANCORA_GLOBALS;
	$style = max(1, min(2, $style));
	$ANCORA_GLOBALS['sc_team_style'] = $style;
	$ANCORA_GLOBALS['sc_team_columns'] = $columns;
	$ANCORA_GLOBALS['sc_team_counter'] = 0;
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_team sc_team_style_'.esc_attr($style).(!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
				. '>'
				. '<div class="sc_columns columns_wrap">';

	$content = do_shortcode($content);
		
	if (ancora_sc_param_is_on($custom) && $content) {
		$output .= $content;
	} else {
		global $post;
	
		if (!empty($ids)) {
			$posts = explode(',', $ids);
			$count = count($posts);
		}
		
		$args = array(
			'post_type' => 'team',
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'order' => $order=='asc' ? 'asc' : 'desc',
		);
	
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
	
		$args = ancora_query_add_sort_order($args, $orderby, $order);
		$args = ancora_query_add_posts_and_cats($args, $ids, 'team', $cat, 'team_group');

		$query = new WP_Query( $args );

		$post_number = 0;
			
		while ( $query->have_posts() ) { 
			$query->the_post();
			$post_number++;
			$post_id = get_the_ID();
			$name = get_the_title();	//apply_filters('the_title', get_the_title());
			$descr = get_the_excerpt();	//apply_filters('the_excerpt', get_the_excerpt());
			$post_meta = get_post_meta($post_id, 'team_data', true);
			$position = $post_meta['team_member_position'];
			$link = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : get_permalink($post_id);
			$email = $post_meta['team_member_email'];
			$photo = wp_get_attachment_url(get_post_thumbnail_id($post_id));
			if (empty($photo)) {
				if (!empty($email))
					$photo = get_avatar($email, 350*min(2, max(1, ancora_get_theme_option("retina_ready"))));
			} else {
				$photo = ancora_get_resized_image_tag($photo, 350, 290);
			}
			$socials = '';
			$soc_list = $post_meta['team_member_socials'];
			if (is_array($soc_list) && count($soc_list)>0) {
				$soc_str = '';
				foreach ($soc_list as $sn=>$sl) {
					if (!empty($sl))
						$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
				}
				if (!empty($soc_str))
					$socials = do_shortcode('[trx_socials socials="'.esc_attr($soc_str).'"][/trx_socials]');
			}
			$output .= 	'<div class="column-1_'.esc_attr($columns) . '">'
							. '<div' . ($id ? ' id="'.esc_attr(($id).'_'.($post_number)).'"' : '') 
									. ' class="sc_team_item sc_team_item_' . esc_attr($post_number) 
										. ($post_number % 2 == 1 ? ' odd' : ' even') 
										. ($post_number == 1 ? ' first' : '') 
									. '">'
								. '<div class="sc_team_item_avatar">'
									. ($photo)
									. ($style==2 
										? '<div class="sc_team_item_hover"><div class="sc_team_item_socials">' . ($socials) . '</div></div>'
										: '')
								. '</div>'
								. '<div class="sc_team_item_info">'
									. '<h6 class="sc_team_item_title">' . ($link ? '<a href="'.esc_url($link).'">' : '') . ($name) . ($link ? '</a>' : '') . '</h6>'
									. '<div class="sc_team_item_position">' . ($position) . '</div>'
									. ($style==1 
										? '<div class="sc_team_item_description">' . ($descr) . '</div>' . ($socials)
										: '')
								. '</div>'
							. '</div>'
						. '</div>';
		}
		wp_reset_postdata();
	}

	$output .= '</div>'
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_team', $atts, $content);
}


add_shortcode('trx_team_item', 'ancora_sc_team_item');

function ancora_sc_team_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"user" => "",
		"member" => "",
		"name" => "",
		"position" => "",
		"photo" => "",
		"email" => "",
		"link" => "",
		"socials" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_team_counter']++;
	$descr = trim(chop(do_shortcode($content)));
	if (!empty($socials)) $socials = do_shortcode('[trx_socials socials="'.esc_attr($socials).'"][/trx_socials]');
	if (!empty($user) && $user!='none' && ($user_obj = get_user_by('login', $user)) != false) {
		$meta = get_user_meta($user_obj->ID);
		if (empty($email))		$email = $user_obj->data->user_email;
		if (empty($name))		$name = $user_obj->data->display_name;
		if (empty($position))	$position = isset($meta['user_position'][0]) ? $meta['user_position'][0] : '';
		if (empty($descr))		$descr = isset($meta['description'][0]) ? $meta['description'][0] : '';
		if (empty($socials))	$socials = ancora_show_user_socials(array('author_id'=>$user_obj->ID, 'echo'=>false));
	}
	if (!empty($member) && $member!='none' && ($member_obj = (intval($member) > 0 ? get_post($member, OBJECT) : get_page_by_title($member, OBJECT, 'team'))) != null) {
		if (empty($name))		$name = $member_obj->post_title;
		if (empty($descr))		$descr = $member_obj->post_excerpt;
		$post_meta = get_post_meta($member_obj->ID, 'team_data', true);
		if (empty($position))	$position = $post_meta['team_member_position'];
		if (empty($link))		$link = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : get_permalink($member_obj->ID);
		if (empty($email))		$email = $post_meta['team_member_email'];
		if (empty($photo)) 		$photo = wp_get_attachment_url(get_post_thumbnail_id($member_obj->ID));
		if (empty($socials)) {
			$socials = '';
			$soc_list = $post_meta['team_member_socials'];
			if (is_array($soc_list) && count($soc_list)>0) {
				$soc_str = '';
				foreach ($soc_list as $sn=>$sl) {
					if (!empty($sl))
						$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
				}
				if (!empty($soc_str))
					$socials = do_shortcode('[trx_socials socials="'.esc_attr($soc_str).'"][/trx_socials]');
			}
		}
	}
	if (empty($photo)) {
		if (!empty($email)) $photo = get_avatar($email, 350*min(2, max(1, ancora_get_theme_option("retina_ready"))));
	} else {
		if ($photo > 0) {
			$attach = wp_get_attachment_image_src( $photo, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$photo = $attach[0];
		}
		$photo = ancora_get_resized_image_tag($photo, 350, 392);
	}
	$output = !empty($name) && !empty($position) 
		? '<div class="column-1_'.esc_attr($ANCORA_GLOBALS['sc_team_columns'])
						. (!empty($class) ? ' '.esc_attr($class) : '') 
					. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
					. '>'
				. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_team_item sc_team_item_' . esc_attr($ANCORA_GLOBALS['sc_team_counter'])
							. ($ANCORA_GLOBALS['sc_team_counter'] % 2 == 1 ? ' odd' : ' even')
							. ($ANCORA_GLOBALS['sc_team_counter'] == 1 ? ' first' : '')
						. '">'
					. '<div class="sc_team_item_avatar">'
						. ($photo)
						. ($ANCORA_GLOBALS['sc_team_style']==2
							? '<div class="sc_team_item_hover"><div class="sc_team_item_socials">' . ($socials) . '</div></div>'
							: '')
					. '</div>'
					. '<div class="sc_team_item_info">'
						. '<h4 class="sc_team_item_title">' . ($link ? '<a href="'.esc_url($link).'">' : '') . ($name) . ($link ? '</a>' : '') . '</h6>'
						. '<div class="sc_team_item_position">' . ($position) . '</div>'
						. ($ANCORA_GLOBALS['sc_team_style']==1
							? '<div class="sc_team_item_description">' . ($descr) . '</div>' . ($socials)
							: '')
					. '</div>'
				. '</div>'
			. '</div>'
		: '';
	return apply_filters('ancora_shortcode_output', $output, 'trx_team_item', $atts, $content);
}

// ---------------------------------- [/trx_team] ---------------------------------------






// ---------------------------------- [trx_testimonials] ---------------------------------------


add_shortcode('trx_testimonials', 'ancora_sc_testimonials');

/*
[trx_testimonials id="unique_id" style="1|2|3"]
	[trx_testimonials_item user="user_login"]Testimonials text[/trx_testimonials_item]
	[trx_testimonials_item email="" name="" position="" photo="photo_url"]Testimonials text[/trx_testimonials]
[/trx_testimonials]
*/

function ancora_sc_testimonials($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"controls" => "yes",
		"interval" => "",
		"autoheight" => "no",
		"align" => "",
		"custom" => "no",
		"ids" => "",
		"cat" => "",
		"count" => "3",
		"offset" => "",
		"orderby" => "date",
		"order" => "desc",
		"bg_tint" => "",
		"bg_color" => "",
		"bg_image" => "",
		"bg_overlay" => "",
		"bg_texture" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	if (empty($id)) $id = "sc_testimonials_".str_replace('.', '', mt_rand());
	if (empty($width)) $width = "100%";
	if (!empty($height) && ancora_sc_param_is_on($autoheight)) $autoheight = "no";
	if (empty($interval)) $interval = mt_rand(5000, 10000);

	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}

	if ($bg_overlay > 0) {
		if ($bg_color=='') $bg_color = ancora_get_theme_bgcolor();
		$rgb = ancora_hex2rgb($bg_color);
	}
	
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_testimonials_width']  = ancora_prepare_css_value($width);
	$ANCORA_GLOBALS['sc_testimonials_height'] = ancora_prepare_css_value($height);
	
	$ms = ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$ws = ancora_get_css_position_from_values('', '', '', '', $width);
	$hs = ancora_get_css_position_from_values('', '', '', '', '', $height);

	$css .= ($ms) . ($hs) . ($ws);
	
	ancora_enqueue_slider('swiper');

	$output = ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || ancora_strlen($bg_texture)>2
				? '<div class="sc_testimonials_wrap sc_section'
						. ($bg_tint ? ' bg_tint_' . esc_attr($bg_tint) : '') 
						. '"'
					.' style="'
						. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
						. ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
						. '"'
					. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
					. '>'
					. '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
							. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
								. (ancora_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
								. '"'
								. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
								. '>' 
				: '')
			. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_testimonials sc_slider_swiper swiper-slider-container sc_slider_nopagination'
				. (ancora_sc_param_is_on($controls) ? ' sc_slider_controls' : ' sc_slider_nocontrols')
				. (ancora_sc_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
				. ($hs ? ' sc_slider_height_fixed' : '')
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
				. '"'
			. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && !ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. (!empty($width) && ancora_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
			. (!empty($height) && ancora_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
			. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
		. '>'
		. '<div class="slides swiper-wrapper">';

	$content = do_shortcode($content);
		
	if (ancora_sc_param_is_on($custom) && $content) {
		$output .= $content;
	} else {
		global $post;
	
		if (!empty($ids)) {
			$posts = explode(',', $ids);
			$count = count($posts);
		}
		
		$args = array(
			'post_type' => 'testimonial',
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'order' => $order=='asc' ? 'asc' : 'desc',
		);
	
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
	
		$args = ancora_query_add_sort_order($args, $orderby, $order);
		$args = ancora_query_add_posts_and_cats($args, $ids, 'testimonial', $cat, 'testimonial_group');

		$query = new WP_Query( $args );

		$post_number = 0;
			
		while ( $query->have_posts() ) { 
			$query->the_post();
			$post_number++;
			$post_id = get_the_ID();
			$post_title = get_the_title();
			$post_meta = get_post_meta($post_id, 'testimonial_data', true);
			$author = $post_meta['testimonial_author'];
			$link = $post_meta['testimonial_link'];
			$email = $post_meta['testimonial_email'];
			$content = apply_filters('the_content', get_the_content());
			$photo = wp_get_attachment_url(get_post_thumbnail_id($post_id));
			if (empty($photo)) {
				if (!empty($email))
					$photo = get_avatar($email, 70*min(2, max(1, ancora_get_theme_option("retina_ready"))));
			} else {
				$photo = ancora_get_resized_image_tag($photo, 70, 70);
			}

			$output .= '<div class="swiper-slide" data-style="'.esc_attr(($ws).($hs)).'" style="'.esc_attr(($ws).($hs)).'">'
						. '<div class="sc_testimonial_item">'
							. ($photo ? '<div class="sc_testimonial_avatar">'.($photo).'</div>' : '')
							. '<div class="sc_testimonial_content">' . ($content) . '</div>'
							. ($author ? '<div class="sc_testimonial_author">' . ($link ? '<a href="'.esc_url($link).'">'.($author).'</a>' : $author) . '</div>' : '')
						. '</div>'
					. '</div>';
		}
		wp_reset_postdata();
	}

	$output .= '</div>';
	if (ancora_sc_param_is_on($controls))
		$output .= '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>';

	$output .= '</div>'
				. ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || ancora_strlen($bg_texture)>2
					?  '</div></div>'
					: '');
	return apply_filters('ancora_shortcode_output', $output, 'trx_testimonials', $atts, $content);
}


add_shortcode('trx_testimonials_item', 'ancora_sc_testimonials_item');

function ancora_sc_testimonials_item($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"author" => "",
		"link" => "",
		"photo" => "",
		"email" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => "",
    ), $atts)));
    global $ANCORA_GLOBALS;
	if (empty($photo)) {
		if (!empty($email))
			$photo = get_avatar($email, 70*min(2, max(1, ancora_get_theme_option("retina_ready"))));
	} else {
		if ($photo > 0) {
			$attach = wp_get_attachment_image_src( $photo, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$photo = $attach[0];
		}
		$photo = ancora_get_resized_image_tag($photo, 70, 70);
	}

	$css2 = (!empty($ANCORA_GLOBALS['sc_testimonials_width'])  ? 'width:'  . esc_attr($ANCORA_GLOBALS['sc_testimonials_width'])  . ';' : '')
			. (!empty($ANCORA_GLOBALS['sc_testimonials_height']) ? 'height:' . esc_attr($ANCORA_GLOBALS['sc_testimonials_height']) . ';' : '');

	$content = do_shortcode($content);

	$output = '<div class="swiper-slide"' . ($css2 ? ' data-style="'.esc_attr($css2).'" style="'.esc_attr($css2).'"' : '') . '>'
			. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '').' class="sc_testimonial_item' . (!empty($class) ? ' '.esc_attr($class) : '') . '"' . ($css ? ' style="'.esc_attr($css).'"' : '') . '>'
				. ($photo ? '<div class="sc_testimonial_avatar">'.($photo).'</div>' : '')
				. '<div class="sc_testimonial_content">' . ($content) . '</div>'
				. ($author ? '<div class="sc_testimonial_author">' . ($link ? '<a href="'.esc_url($link).'">'.($author).'</a>' : $author) . '</div>' : '')
			. '</div>'
		. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_testimonials_item', $atts, $content);
}

// ---------------------------------- [/trx_testimonials] ---------------------------------------


// ---------------------------------- [trx_testim] ---------------------------------------


add_shortcode('trx_testim', 'ancora_sc_testim');

/*
[trx_tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/
function ancora_sc_testim($atts, $content=null){
    if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
        // Individual params
        "text" => "",
    ), $atts)));
    $output = '<div class="testim">'
        . do_shortcode($content)
        . '</div>';
    return apply_filters('ancora_shortcode_output', $output, 'trx_testim', $atts, $content);
}
// ---------------------------------- [/trx_testim] ---------------------------------------


// ---------------------------------- [trx_title] ---------------------------------------


add_shortcode('trx_title', 'ancora_sc_title');

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/
function ancora_sc_title($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"type" => "1",
		"style" => "regular",
		"align" => "",
		"font_weight" => "",
		"font_size" => "",
        "fig_border" => "",
		"color" => "",
		"icon" => "",
		"image" => "",
		"picture" => "",
		"image_size" => "small",
		"position" => "left",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left, $width)
		.($align && $align!='none' && $align!='inherit' ? 'text-align:' . esc_attr($align) .';' : '')
		.($color ? 'color:' . esc_attr($color) .';' : '')
		.($font_weight && $font_weight != 'inherit' ? 'font-weight:' . esc_attr($font_weight) .';' : '')
		.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
		;
	$type = min(6, max(1, $type));
	if ($picture > 0) {
		$attach = wp_get_attachment_image_src( $picture, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$picture = $attach[0];
	}
	$pic = $style!='iconed' 
		? '' 
		: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
			.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
			.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(ancora_strpos($image, 'http:')!==false ? $image : ancora_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
			.'</span>';
	$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_title sc_title_'.esc_attr($style)
				.($align && $align!='none' && $align!='inherit' ? ' sc_align_' . esc_attr($align) : '')
				.(!empty($class) ? ' '.esc_attr($class) : '')
                .esc_attr(' '.$fig_border)
				.'"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. '>'
				. ($pic)
				. ($style=='divider' ? '<span class="sc_title_divider_before"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
				. do_shortcode($content) 
				. ($style=='divider' ? '<span class="sc_title_divider_after"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
			. '</h' . esc_attr($type) . '>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_title', $atts, $content);
}

// ---------------------------------- [/trx_title] ---------------------------------------






// ---------------------------------- [trx_toggles] ---------------------------------------


add_shortcode('trx_toggles', 'ancora_sc_toggles');

function ancora_sc_toggles($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"style" => "1",
		"counter" => "off",
		"icon_closed" => "icon-plus-2",
		"icon_opened" => "icon-minus-2",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_toggle_counter'] = 0;
	$ANCORA_GLOBALS['sc_toggle_style']   = max(1, min(2, $style));
	$ANCORA_GLOBALS['sc_toggle_show_counter'] = ancora_sc_param_is_on($counter);
	$ANCORA_GLOBALS['sc_toggles_icon_closed'] = empty($icon_closed) || ancora_sc_param_is_inherit($icon_closed) ? "icon-plus-2" : $icon_closed;
	$ANCORA_GLOBALS['sc_toggles_icon_opened'] = empty($icon_opened) || ancora_sc_param_is_inherit($icon_opened) ? "icon-minus-2" : $icon_opened;
	wp_enqueue_script('jquery-effects-slide', false, array('jquery','jquery-effects-core'), null, true);
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_toggles sc_toggles_style_'.esc_attr($style)
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. (ancora_sc_param_is_on($counter) ? ' sc_show_counter' : '')
				. '"'
			. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_toggles', $atts, $content);
}


add_shortcode('trx_toggles_item', 'ancora_sc_toggles_item');

//[trx_toggles_item]
function ancora_sc_toggles_item($atts, $content=null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts( array(
		// Individual params
		"title" => "",
		"open" => "",
		"icon_closed" => "",
		"icon_opened" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
	), $atts)));
	global $ANCORA_GLOBALS;
	$ANCORA_GLOBALS['sc_toggle_counter']++;
	if (empty($icon_closed) || ancora_sc_param_is_inherit($icon_closed)) $icon_closed = $ANCORA_GLOBALS['sc_toggles_icon_closed'] ? $ANCORA_GLOBALS['sc_toggles_icon_closed'] : "icon-plus-2";
	if (empty($icon_opened) || ancora_sc_param_is_inherit($icon_opened)) $icon_opened = $ANCORA_GLOBALS['sc_toggles_icon_opened'] ? $ANCORA_GLOBALS['sc_toggles_icon_opened'] : "icon-minus-2";
	$css .= ancora_sc_param_is_on($open) ? 'display:block;' : '';
	$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_toggles_item'.(ancora_sc_param_is_on($open) ? ' sc_active' : '')
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. ($ANCORA_GLOBALS['sc_toggle_counter'] % 2 == 1 ? ' odd' : ' even')
				. ($ANCORA_GLOBALS['sc_toggle_counter'] == 1 ? ' first' : '')
				. '">'
				. '<h5 class="sc_toggles_title'.(ancora_sc_param_is_on($open) ? ' ui-state-active' : '').'">'
				. (!ancora_sc_param_is_off($icon_closed) ? '<span class="sc_toggles_icon sc_toggles_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
				. (!ancora_sc_param_is_off($icon_opened) ? '<span class="sc_toggles_icon sc_toggles_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
				. ($ANCORA_GLOBALS['sc_toggle_show_counter'] ? '<span class="sc_items_counter">'.($ANCORA_GLOBALS['sc_toggle_counter']).'</span>' : '')
				. ($title) 
				. '</h5>'
				. '<div class="sc_toggles_content"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					.'>' 
					. do_shortcode($content) 
				. '</div>'
			. '</div>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_toggles_item', $atts, $content);
}

// ---------------------------------- [/trx_toggles] ---------------------------------------





// ---------------------------------- [trx_tooltip] ---------------------------------------


add_shortcode('trx_tooltip', 'ancora_sc_tooltip');

/*
[trx_tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/
function ancora_sc_tooltip($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"title" => "",
		// Common params
		"id" => "",
		"class" => "",
		"css" => ""
    ), $atts)));
	$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_tooltip_parent'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. '>'
					. do_shortcode($content)
					. '<span class="sc_tooltip">' . ($title) . '</span>'
				. '</span>';
	return apply_filters('ancora_shortcode_output', $output, 'trx_tooltip', $atts, $content);
}
// ---------------------------------- [/trx_tooltip] ---------------------------------------






// ---------------------------------- [trx_twitter] ---------------------------------------


add_shortcode('trx_twitter', 'ancora_sc_twitter');

/*
[trx_twitter id="unique_id" user="username" consumer_key="" consumer_secret="" token_key="" token_secret=""]
*/

function ancora_sc_twitter($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"user" => "",
		"consumer_key" => "",
		"consumer_secret" => "",
		"token_key" => "",
		"token_secret" => "",
		"count" => "3",
		"controls" => "yes",
		"interval" => "",
		"autoheight" => "no",
		"align" => "",
		"bg_tint" => "",
		"bg_color" => "",
		"bg_image" => "",
		"bg_overlay" => "",
		"bg_texture" => "",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	$twitter_username = $user ? $user : ancora_get_theme_option('twitter_username');
	$twitter_consumer_key = $consumer_key ? $consumer_key : ancora_get_theme_option('twitter_consumer_key');
	$twitter_consumer_secret = $consumer_secret ? $consumer_secret : ancora_get_theme_option('twitter_consumer_secret');
	$twitter_token_key = $token_key ? $token_key : ancora_get_theme_option('twitter_token_key');
	$twitter_token_secret = $token_secret ? $token_secret : ancora_get_theme_option('twitter_token_secret');
	$twitter_count = max(1, $count ? $count : intval(ancora_get_theme_option('twitter_count')));

	if (empty($id)) $id = "sc_testimonials_".str_replace('.', '', mt_rand());
	if (empty($width)) $width = "100%";
	if (!empty($height) && ancora_sc_param_is_on($autoheight)) $autoheight = "no";
	if (empty($interval)) $interval = mt_rand(5000, 10000);

	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}

	if ($bg_overlay > 0) {
		if ($bg_color=='') $bg_color = ancora_get_theme_bgcolor();
		$rgb = ancora_hex2rgb($bg_color);
	}
	
	$ms = ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$ws = ancora_get_css_position_from_values('', '', '', '', $width);
	$hs = ancora_get_css_position_from_values('', '', '', '', '', $height);

	$css .= ($ms) . ($hs) . ($ws);

	$output = '';

	if (!empty($twitter_consumer_key) && !empty($twitter_consumer_secret) && !empty($twitter_token_key) && !empty($twitter_token_secret)) {
		$data = ancora_get_twitter_data(array(
			'mode'            => 'user_timeline',
			'consumer_key'    => $twitter_consumer_key,
			'consumer_secret' => $twitter_consumer_secret,
			'token'           => $twitter_token_key,
			'secret'          => $twitter_token_secret
			)
		);
		if ($data && isset($data[0]['text'])) {
			ancora_enqueue_slider('swiper');
			$output = ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || ancora_strlen($bg_texture)>2
					? '<div class="sc_twitter_wrap sc_section'
							. ($bg_tint ? ' bg_tint_' . esc_attr($bg_tint) : '') 
							. ($align && $align!='none' && $align!='inherit' ? ' align' . esc_attr($align) : '')
							. '"'
						.' style="'
							. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
							. ($bg_image !== '' ? 'background-image:url('.esc_url($bg_image).');' : '')
							. '"'
						. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
						. '>'
						. '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
								. ' style="' 
									. ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
									. (ancora_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
									. '"'
									. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
									. '>' 
					: '')
					. '<div class="sc_twitter sc_slider_swiper sc_slider_nopagination swiper-slider-container"'
							. (ancora_sc_param_is_on($controls) ? ' sc_slider_controls' : ' sc_slider_nocontrols')
							. (ancora_sc_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
							. ($hs ? ' sc_slider_height_fixed' : '')
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && $align && $align!='none' && $align!='inherit' ? ' align' . esc_attr($align) : '')
							. '"'
						. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && !ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
						. (!empty($width) && ancora_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
						. (!empty($height) && ancora_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
						. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
						. '>'
						. '<div class="slides swiper-wrapper">';
			$cnt = 0;
			foreach ($data as $tweet) {
				if (ancora_substr($tweet['text'], 0, 1)=='@') continue;
					$output .= '<div class="swiper-slide" data-style="'.esc_attr(($ws).($hs)).'" style="'.esc_attr(($ws).($hs)).'">'
								. '<div class="sc_twitter_item">'
									. '<span class="sc_twitter_icon icon-twitter"></span>'
									. '<div class="sc_twitter_content">'
										. '<a href="' . esc_url('https://twitter.com/'.($twitter_username)).'" class="sc_twitter_author" target="_blank">@' . esc_html($tweet['user']['screen_name']) . '</a> '
										. force_balance_tags(ancora_prepare_twitter_text($tweet))
									. '</div>'
								. '</div>'
							. '</div>';
				if (++$cnt >= $twitter_count) break;
			}
			$output .= '</div>'
					. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '</div>'
				. ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || ancora_strlen($bg_texture)>2
					?  '</div></div>'
					: '');
		}
	}
	return apply_filters('ancora_shortcode_output', $output, 'trx_twitter', $atts, $content);
}

// ---------------------------------- [/trx_twitter] ---------------------------------------

						


// ---------------------------------- [trx_video] ---------------------------------------

add_shortcode("trx_video", "ancora_sc_video");

//[trx_video id="unique_id" url="http://player.vimeo.com/video/20245032?title=0&amp;byline=0&amp;portrait=0" width="" height=""]
function ancora_sc_video($atts, $content = null) {
	if (ancora_sc_in_shortcode_blogger()) return '';
	extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"url" => '',
		"src" => '',
		"image" => '',
		"ratio" => '16:9',
		"autoplay" => 'off',
		"align" => '',
		"bg_image" => '',
		"bg_top" => '',
		"bg_bottom" => '',
		"bg_left" => '',
		"bg_right" => '',
		"frame" => "on",
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => '',
		"height" => '',
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	if (empty($autoplay)) $autoplay = 'off';
	
	$ratio = empty($ratio) ? "16:9" : str_replace(array('/','\\','-'), ':', $ratio);
	$ratio_parts = explode(':', $ratio);
	if (empty($height) && empty($width)) $width='100%';
	$ed = ancora_substr($width, -1);
	if (empty($height) && !empty($width) && $ed!='%') {
		$height = round($width / $ratio_parts[0] * $ratio_parts[1]);
	}
	if (!empty($height) && empty($width)) {
		$width = round($height * $ratio_parts[0] / $ratio_parts[1]);
	}
	$css .= ancora_get_css_position_from_values($top, $right, $bottom, $left);
	$css_dim = ancora_get_css_position_from_values('', '', '', '', $width, $height);
	$css_bg = ancora_get_css_paddings_from_values($bg_top, $bg_right, $bg_bottom, $bg_left);

	if ($src=='' && $url=='' && isset($atts[0])) {
		$src = $atts[0];
	}
	$url = $src!='' ? $src : $url;
	if ($image!='' && ancora_sc_param_is_off($image))
		$image = '';
	else {
		if (ancora_sc_param_is_on($autoplay) && is_single())
			$image = '';
		else {
			if ($image > 0) {
				$attach = wp_get_attachment_image_src( $image, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$image = $attach[0];
			}
			if ($bg_image) {
				$thumb_sizes = ancora_get_thumb_sizes(array(
					'layout' => 'grid_3'
				));
				if (!is_single() || !empty($image)) $image = ancora_get_resized_image_url(empty($image) ? get_the_ID() : $image, $thumb_sizes['w'], $thumb_sizes['h'], null, false, false, false);
			} else
				if (!is_single() || !empty($image)) $image = ancora_get_resized_image_url(empty($image) ? get_the_ID() : $image, $ed!='%' ? $width : null, $height);
			if (empty($image) && (!is_single() || ancora_sc_param_is_off($autoplay)))
				$image = ancora_get_video_cover_image($url);
		}
	}
	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}
	if ($bg_image) {
		$css_bg .= $css . 'background-image: url('.esc_url($bg_image).');';
		$css = $css_dim;
	} else {
		$css .= $css_dim;
	}

	$url = ancora_get_video_player_url($src!='' ? $src : $url);
	
	$video = '<video' . ($id ? ' id="' . esc_attr($id) . '"' : '') 
		. ' class="sc_video'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
		. ' src="' . esc_url($url) . '"'
		. ' width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"' 
		. ' data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '"' 
		. ' data-ratio="'.esc_attr($ratio).'"'
		. ($image ? ' poster="'.esc_attr($image).'" data-image="'.esc_attr($image).'"' : '') 
		. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
		. ($align && $align!='none' ? ' data-align="'.esc_attr($align).'"' : '')
		. ($bg_image ? ' data-bg-image="'.esc_attr($bg_image).'"' : '') 
		. ($css_bg!='' ? ' data-style="'.esc_attr($css_bg).'"' : '') 
		. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
		. (($image && ancora_get_theme_option('substitute_video')=='yes') || (ancora_sc_param_is_on($autoplay) && is_single()) ? ' autoplay="autoplay"' : '')
		. ' controls="controls" loop="loop"'
		. '>'
		. '</video>';
	if (ancora_get_custom_option('substitute_video')=='no') {
		if (ancora_sc_param_is_on($frame)) $video = ancora_get_video_frame($video, $image, $css, $css_bg);
	} else {
		if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
			$video = ancora_substitute_video($video, $width, $height, false);
		}
	}
	if (ancora_get_theme_option('use_mediaelement')=='yes')
		wp_enqueue_script('wp-mediaelement');
	return apply_filters('ancora_shortcode_output', $video, 'trx_video', $atts, $content);
}
// ---------------------------------- [/trx_video] ---------------------------------------






// ---------------------------------- [trx_zoom] ---------------------------------------

add_shortcode('trx_zoom', 'ancora_sc_zoom');

/*
[trx_zoom id="unique_id" border="none|light|dark"]
*/
function ancora_sc_zoom($atts, $content=null){
	if (ancora_sc_in_shortcode_blogger()) return '';
    extract(ancora_sc_html_decode(shortcode_atts(array(
		// Individual params
		"effect" => "zoom",
		"src" => "",
		"url" => "",
		"over" => "",
		"align" => "",
		"bg_image" => "",
		"bg_top" => '',
		"bg_bottom" => '',
		"bg_left" => '',
		"bg_right" => '',
		// Common params
		"id" => "",
		"class" => "",
		"animation" => "",
		"css" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts)));

	wp_enqueue_script( 'ancora-elevate-zoom-script', ancora_get_file_url('js/jquery.elevateZoom.js'), array(), null, true );

	$css .= ancora_get_css_position_from_values('!'.($top), '!'.($right), '!'.($bottom), '!'.($left));
	$css_dim = ancora_get_css_position_from_values('', '', '', '', $width, $height);
	$css_bg = ancora_get_css_paddings_from_values($bg_top, $bg_right, $bg_bottom, $bg_left);
	$width  = ancora_prepare_css_value($width);
	$height = ancora_prepare_css_value($height);
	if (empty($id)) $id = 'sc_zoom_'.str_replace('.', '', mt_rand());
	$src = $src!='' ? $src : $url;
	if ($src > 0) {
		$attach = wp_get_attachment_image_src( $src, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$src = $attach[0];
	}
	if ($over > 0) {
		$attach = wp_get_attachment_image_src( $over, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$over = $attach[0];
	}
	if ($effect=='lens' && ((int) $width > 0 && ancora_substr($width, -2, 2)=='px') || ((int) $height > 0 && ancora_substr($height, -2, 2)=='px')) {
		if ($src)
			$src = ancora_get_resized_image_url($src, (int) $width > 0 && ancora_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && ancora_substr($height, -2, 2)=='px' ? (int) $height : null);
		if ($over)
			$over = ancora_get_resized_image_url($over, (int) $width > 0 && ancora_substr($width, -2, 2)=='px' ? (int) $width : null, (int) $height > 0 && ancora_substr($height, -2, 2)=='px' ? (int) $height : null);
	}
	if ($bg_image > 0) {
		$attach = wp_get_attachment_image_src( $bg_image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$bg_image = $attach[0];
	}
	if ($bg_image) {
		$css_bg .= $css . 'background-image: url('.esc_url($bg_image).');';
		$css = $css_dim;
	} else {
		$css .= $css_dim;
	}
	$output = empty($src) 
			? '' 
			: (
				(!empty($bg_image) 
					? '<div class="sc_zoom_wrap'
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
							. '"'
						. (!ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
						. ($css_bg!='' ? ' style="'.esc_attr($css_bg).'"' : '') 
						. '>' 
					: '')
				.'<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_zoom' 
							. (empty($bg_image) && !empty($class) ? ' '.esc_attr($class) : '') 
							. (empty($bg_image) && $align && $align!='none' ? ' align'.esc_attr($align) : '')
							. '"'
						. (empty($bg_image) && !ancora_sc_param_is_off($animation) ? ' data-animation="'.esc_attr(ancora_sc_get_animation_classes($animation)).'"' : '')
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. '>'
						. '<img src="'.esc_url($src).'"' . ($css_dim!='' ? ' style="'.esc_attr($css_dim).'"' : '') . ' data-zoom-image="'.esc_url($over).'" alt="" />'
				. '</div>'
				. (!empty($bg_image) 
					? '</div>' 
					: '')
			);
	return apply_filters('ancora_shortcode_output', $output, 'trx_zoom', $atts, $content);
}
// ---------------------------------- [/trx_zoom] ---------------------------------------
?>