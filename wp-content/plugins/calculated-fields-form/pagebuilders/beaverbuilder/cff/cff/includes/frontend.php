<?php
$form = @intval( $settings->form_id );
if ( ! empty( $form ) ) {
	$output = '[CP_CALCULATED_FIELDS id="' . $form . '"';

	$class_name = sanitize_text_field( $settings->class_name );
	if ( ! empty( $class_name ) ) {
		$output .= ' class="' . esc_attr( $class_name ) . '"';
	}

	$attributes = sanitize_text_field( $settings->attributes );
	if ( ! empty( $attributes ) ) {
		$output .= ' ' . $attributes;
	}

	$output .= ']';
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
}
