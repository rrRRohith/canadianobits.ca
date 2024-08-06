<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'ancora_widget_categories_load' );

/**
 * Register our widget.
 */
function ancora_widget_categories_load() {
	register_widget( 'ancora_widget_categories' );
}

/**
 * Categories Widget class.
 */
class ancora_widget_categories extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_subcategories', 'description' => __('Subcategories list', 'ancora-utils') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'ancora_widget_subcategories' );

		/* Create the widget. */
		parent::__construct( 'ancora_widget_subcategories', __('Ancora - Subcategories list', 'ancora-utils'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );

		$post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
		$taxonomy = ancora_get_taxonomy_categories_by_post_type($post_type);

		$c = !empty( $instance['count'] ) ? '1' : '0';
		$h = !empty( $instance['hierarchical'] ) ? '1' : '0';
		$d = !empty( $instance['dropdown'] ) ? '1' : '0';

		$root = isset($instance['root']) ? (int) $instance['root'] : 0;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => $taxonomy);

		if ($root > 0) $cat_args['child_of'] = $root;

		/* Before widget (defined by themes). */			
		echo ($before_widget);

		if ($title) echo ($before_title) . ($title) . ($after_title);
		?>			
		<div class="widget_subcategories_inner">
			<?php
			if ( $d ) {
				$cat_args['show_option_none'] = __('Select Category', 'ancora-utils');
				wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
				?>
				<script type='text/javascript'>
				/* <![CDATA[ */
					jQuery('.widget_subcategories select').change(function() {
						var dropdown = jQuery(this).get(0);
						if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
							location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
						}
					});
				/* ]]> */
				</script>
	
				<?php
			} else {
				?>
				<ul>
				<?php
				$cat_args['title_li'] = '';
				wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
				?>
				</ul>
				<?php
			}
			?>
		</div>
		<?php
		/* After widget (defined by themes). */
		echo ($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['count'] 			= !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] 	= !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] 		= !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['root'] 			= (int) $new_instance['root'];
		$instance['post_type'] 		= strip_tags( $new_instance['post_type'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'count'=>0,
			'dropdown'=>0,
			'hierarchical'=>0,
			'root' => 0,
			'post_type'=>'post'
			)
		);

		$title = $instance['title'];
		$root = (int) $instance['root'];
		$post_type = $instance['post_type'];
		$count = (bool) $instance['count'];
		$hierarchical = (bool) $instance['hierarchical'];
		$dropdown = (bool) $instance['dropdown'];
		
		$posts_types = ancora_get_list_posts_types(false);
		$categories = ancora_get_list_terms(false, ancora_get_taxonomy_categories_by_post_type($post_type));
		?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e( 'Title:', 'ancora-utils' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php _e('Post type:', 'ancora-utils'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>" style="width:100%;" onchange="ancora_admin_change_post_type(this);">
			<?php
				foreach ($posts_types as $type => $type_name) {
					echo '<option value="'.esc_attr($type).'"'.($post_type==$type ? ' selected="selected"' : '').'>'.esc_html($type_name).'</option>';
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('root')); ?>"><?php _e('Root category:', 'ancora-utils'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('root')); ?>" name="<?php echo esc_attr($this->get_field_name('root')); ?>" style="width:100%;">
				<option value="0"><?php _e('-- Any category --', 'ancora-utils'); ?></option>
			<?php
				foreach ($categories as $cat_id => $cat_name) {
					echo '<option value="'.esc_attr($cat_id).'"'.($root==$cat_id ? ' selected="selected"' : '').'>'.($cat_name).'</option>';
				}
			?>
			</select>
		</p>

		<p>
		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('dropdown')); ?>" name="<?php echo esc_attr($this->get_field_name('dropdown')); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('dropdown')); ?>"><?php _e( 'Display as dropdown', 'ancora-utils' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php _e( 'Show post counts', 'ancora-utils' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>" name="<?php echo esc_attr($this->get_field_name('hierarchical')); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>"><?php _e( 'Show hierarchy', 'ancora-utils' ); ?></label>
		</p>
		<?php
	}
}
?>