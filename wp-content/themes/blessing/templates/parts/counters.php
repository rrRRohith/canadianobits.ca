<?php
$show_all_counters = !isset($post_options['counters']);
$counters_tag = is_single() ? 'span' : 'a';

if ($show_all_counters || ancora_strpos($post_options['counters'], 'views')!==false && function_exists('ancora_reviews_theme_setup')) {
	?>
	<<?php ancora_show_layout($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo sprintf(__('Views - %s', 'blessing'), $post_data['post_views']); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><?php ancora_show_layout($post_data['post_views']); ?></<?php ancora_show_layout($counters_tag); ?>>
	<?php
}

if ($show_all_counters || ancora_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-comment-1" title="<?php echo sprintf(__('Comments - %s', 'blessing'), $post_data['post_comments']); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php ancora_show_layout($post_data['post_comments']); ?></span></a>
	<?php 
}
 
$rating = $post_data['post_reviews_'.(ancora_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || ancora_strpos($post_options['counters'], 'rating')!==false) && function_exists('ancora_reviews_theme_setup')) {
	?>
	<<?php ancora_show_layout($counters_tag); ?> class="post_counters_item post_counters_rating icon-star-1" title="<?php echo sprintf(__('Rating - %s', 'blessing'), $rating); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php ancora_show_layout($rating); ?></span></<?php ancora_show_layout($counters_tag); ?>>
	<?php
}

if ($show_all_counters || ancora_strpos($post_options['counters'], 'likes')!==false && function_exists('ancora_reviews_theme_setup')) {
	// Load core messages
	ancora_enqueue_messages();
	$likes = isset($_COOKIE['ancora_likes']) ? sanitize_text_field($_COOKIE['ancora_likes']) : '';
	$allow = ancora_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php ancora_show_layout($allow ? 'enabled' : 'disabled'); ?>" title="<?php echo esc_attr($allow ? esc_html__('Like', 'blessing') : esc_html__('Dislike', 'blessing')); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_html_e('Like', 'blessing'); ?>"
		data-title-dislike="<?php esc_html_e('Dislike', 'blessing'); ?>"><span class="post_counters_number"><?php ancora_show_layout($post_data['post_likes']); ?></span></a>
	<?php
}

if (is_single() && ancora_strpos($post_options['counters'], 'markup')!==false && function_exists('ancora_reviews_theme_setup')) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(ancora_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(ancora_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>