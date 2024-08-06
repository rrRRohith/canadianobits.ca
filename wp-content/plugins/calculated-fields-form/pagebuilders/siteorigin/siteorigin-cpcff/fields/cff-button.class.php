<?php
/**
 * Class CFF_Button
 */
class SiteOrigin_Widget_Field_CFF_Button extends SiteOrigin_Widget_Field_Base {

	protected function render_field( $value, $instance ) {
		if ( current_user_can( 'manage_options' ) ) {
			$url = CPCFF_AUXILIARY::editor_url();
			?>
			<input type="button" name="cff-button-edit-form" class="button-primary" value="<?php echo esc_attr( __( 'Edit form', 'calculated-fields-form' ) ); ?>"   />
			<script>
			if(typeof jQuery != 'undefined')
			{
				jQuery(document).on('click', '[name="cff-button-edit-form"]', function(){
					window.open(
						'<?php print esc_url( $url ); ?>'+jQuery('select[id*="widget-siteorigin-cff-shortcode"]:visible').val(),
						'_blank'
					);
				});
			}
			</script>
			<?php
		}
	}

	protected function sanitize_field_input( $value, $instance ) {}
	protected function add_label_classes( $label_classes ) {}
	protected function render_field_label( $value, $instance ) {}
	protected function render_before_field( $value, $instance ) {}
	protected function render_after_field( $value, $instance ) {}
}
