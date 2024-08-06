( function( $ ) {
	$( document ).ready( function() {
		/* display blocks to choose necessary color for elements */
		var pgntn_check = 0,
			pgntn_flag = false,
			window_width = $( window ).width();
			$( window ).resize( function() {
				window_width = $( window ).width();
			} );
		/* Color Picker */
		$( '.pgntn_color_picker' ).wpColorPicker();
		if( ! $( 'input[name="pgntn_add_appearance"]' ).is( ':checked' ) ){
			$( '.wp-color-result' ).attr( "disabled", true );
		}
		if( 350 >= window_width ) {
			$( '.iris-square' ).css( {'margin-right': '2%', 'width': '163px'} );
			$( '.iris-picker-inner' ).css( 'width', '196px' );
			$( '.iris-picker' ).css( 'width', '209px' );
			$( '.iris-palette' ).css( 'width', '17px' );
		}
		/* select or deselect all checkboxes with page types on setting page */
		$( '#pgntn_everywhere' ).click( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '.pgntn_where_display' ).attr( 'checked', true );
				$( '#pgntn_empty_page_type' ).hide();
			} else {
				$( '.pgntn_where_display' ).attr( 'checked', false );
				$( '#pgntn_empty_page_type' ).show();
			}
		} );
		$( 'input[name="pgntn_add_appearance"]' ).click( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '.pgntn_add_appearance input, .wp-color-result' ).attr( "disabled", false );
			} else {
				$( '.pgntn_add_appearance input, .wp-color-result' ).attr( "disabled", true );
			}
		} );
		$( '.pgntn_where_display' ).click( function() {
			if( $( this ).is( ':checked' ) ) {
				$( '.pgntn_where_display' ).each( function() {
					if ( $( this ).is( ':checked' ) )
						pgntn_check ++;
				} );
				if ( pgntn_check == $( '.pgntn_where_display' ).length ) {
					$( '#pgntn_everywhere' ).attr( 'checked', true );
				}
			} else {
				$( '#pgntn_everywhere' ).attr( 'checked', false );
			}
			pgntn_check = 0;
		} );
		$( '#pgntn_display_next_prev' ).change( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '#pgntn_prev_text, #pgntn_next_text' ).attr( 'disabled', false );
			} else {
				$( '#pgntn_prev_text, #pgntn_next_text' ).attr( 'disabled', true );
			}
		} );
		$( '#pgntn_show_not_all' ).click( function() {
			$( 'input[name="pgntn_display_count_page"]' ).attr( 'disabled', false );
		} );
		$( '#pgntn_show_all' ).click( function() {
			$( 'input[name="pgntn_display_count_page"]' ).attr( 'disabled', true );
		} );
		if ( "center" == $( 'input[name="pgntn_align"]:checked' ).val() ) {
			$( '.pgntn_center_padding_hide' ).hide();
		}
		$( 'input[name="pgntn_align"]' ).change( function() {
			if ( 'center' == $( this ).val() && $( this ).is( ':checked' ) ) {
				$( '.pgntn_padding' ).attr( 'disabled', true );
				$( '.pgntn_center_padding_hide' ).hide();
			} else {
				$( '.pgntn_padding' ).attr( 'disabled', false );
				$( '.pgntn_center_padding_hide' ).show();
			}
		} );
		$( 'input[name="pgntn_display_custom_pagination"]' ).change( function() {
			if ( $( this ).is( ':checked' ) ) {
				$( '#pgntn_additional_pagination_style' ).attr( 'disabled', false );
			} else {
				$( '#pgntn_additional_pagination_style' ).attr( 'disabled', true );
			}
		} );
	} );
} )( jQuery );
