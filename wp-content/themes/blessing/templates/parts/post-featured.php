<?php
					if ($post_data['post_video']) {
						ancora_show_layout(ancora_get_video_frame($post_data['post_video'], $post_data['post_video_image'] ? $post_data['post_video_image'] : $post_data['post_thumb']));
					} else if ($post_data['post_audio']) {
						ancora_show_layout(ancora_get_audio_frame($post_data['post_audio'], $post_data['post_audio_image'] ? $post_data['post_audio_image'] : $post_data['post_thumb_url']));
					} else if ($post_data['post_thumb'] && ($post_data['post_format']!='gallery' || !$post_data['post_gallery'] || ancora_get_custom_option('gallery_instead_image')=='no')) {
						?>
						<div class="post_thumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
						<?php
						if ($post_data['post_format']=='link' && $post_data['post_url']!='')
							echo '<a class="hover_icon hover_icon_link" href="'.esc_url($post_data['post_url']).'"'.($post_data['post_url_target'] ? ' target="'.esc_attr($post_data['post_url_target']).'"' : '').'>'.($post_data['post_thumb']).'</a>';
						else if ($post_data['post_link']!='')
							echo '<a class="hover_icon hover_icon_link" href="'.esc_url($post_data['post_link']).'">'.($post_data['post_thumb']).'</a>';
						else
							ancora_show_layout($post_data['post_thumb']);
						?>
						</div>
						<?php
					} else if ($post_data['post_gallery']) {
						ancora_enqueue_slider();
						ancora_show_layout($post_data['post_gallery']);
					}
?>