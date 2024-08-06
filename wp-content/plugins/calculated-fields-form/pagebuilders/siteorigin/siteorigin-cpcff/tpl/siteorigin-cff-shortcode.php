<?php
$form       = trim( $instance['form'] );
$class_name = sanitize_text_field( $instance['class_name'] );
$attrs      = sanitize_text_field( $instance['attrs'] );
$shortcode  = '';
if ( @intval( $form ) ) {
	$shortcode .= '[CP_CALCULATED_FIELDS id="' . esc_attr( $form ) . '"';
	if ( ! empty( $class_name ) ) {
		$shortcode .= ' class="' . esc_attr( $class_name ) . '"';
	}
	if ( ! empty( $attrs ) ) {
		$shortcode .= ' ' . $attrs;
	}
	$shortcode .= ']';
}
print $shortcode; // phpcs:ignore WordPress.Security.EscapeOutput
