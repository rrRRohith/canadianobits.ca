<?php
$name          = sanitize_text_field( $instance['name'] );
$from          = sanitize_text_field( $instance['from'] );
$default_value = sanitize_text_field( $instance['default_value'] );
$value         = sanitize_text_field( $instance['value'] );
$shortcode     = '';
if ( ! empty( $name ) ) {
	$shortcode .= '[CP_CALCULATED_FIELDS_VAR name="' . esc_attr( $name ) . '"';
	if ( ! empty( $from ) ) {
		$shortcode .= ' ' . $from;
	}
	if ( ! empty( $default_value ) ) {
		$shortcode .= ' default_value="' . esc_attr( $default_value ) . '"';
	}
	if ( ! empty( $value ) ) {
		$shortcode .= ' value="' . esc_attr( $value ) . '"';
	}
	$shortcode .= ']';
}
print $shortcode; // phpcs:ignore WordPress.Security.EscapeOutput
