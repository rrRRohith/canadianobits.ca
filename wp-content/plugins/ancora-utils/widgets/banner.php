<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'ancora_widget_banner' );

/**
 * Register our widget.
 */
function ancora_widget_banner() {
	register_widget( 'ancora_widget_banner' );
}

/**
 * banner Widget class.
 */
class ancora_widget_banner extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_banner', 'description' => __('Banner', 'ancora-utils') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'ancora_widget_banner' );

		/* Create the widget. */
		parent::__construct( 'ancora_widget_banner', __('Ancora - Banner', 'ancora-utils'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
        $link = isset($instance['link']) ? $instance['link'] : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
		$bg_image = isset($instance['bg_image']) ? $instance['bg_image'] : '';
		
		
		/* Before widget (defined by themes). */			
		echo ($before_widget);

		/* Display the widget title if one was input (before and after defined by themes). */

		//here will be displayed widget content for Footer 1st column 
		?>
		<div class="small_banner" <?php
        if ($bg_image != '') {
            echo wp_kses_post('style="background-image: url('.$bg_image.');"');
        }
        ?>>
            <h2 class="small_banner_title">
                <a href="<?php echo wp_kses_post($link);  ?>"><?php echo wp_kses_post($title);  ?></a>
            </h2>
            <div class="small_banner_text">

                <?php echo wp_kses_post($text); ?>
            </div>
		</div>

		<?php
		/* After widget (defined by themes). */
        echo wp_kses_post($after_widget);
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['link'] = strip_tags( $new_instance['link']);
		$instance['text'] = strip_tags( $new_instance['text'] );
        $instance['bg_image'] = strip_tags( $new_instance['bg_image'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'link' => '', 'text' => '', 'bg_image' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 

        $title = isset($instance['title']) ? $instance['title'] : '';
        $link = isset($instance['link']) ? $instance['link'] : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        $bg_image = isset($instance['bg_image']) ? $instance['bg_image'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e('Title:', 'ancora-utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'text' )); ?>"><?php _e('Title link', 'ancora-utils'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'link' )); ?>" value="<?php echo esc_attr($instance['link']); ?>" style="width:100%;" />
		</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'text' )); ?>"><?php _e('Description', 'ancora-utils'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'text' )); ?>" value="<?php echo esc_attr($instance['text']); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'bg_image' )); ?>"><?php _e('Background image (url):', 'ancora-utils'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'bg_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'bg_image' )); ?>" value="<?php echo esc_attr($instance['bg_image']); ?>" style="width:100%;" />
        </p>

	<?php
	}
}
?>