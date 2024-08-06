/* global jQuery:false */

jQuery(document).ready(function() {
	"use strict";
    if (typeof ANCORA_GLOBALS == 'undefined') var ANCORA_GLOBALS = {};
	ANCORA_GLOBALS['media_frame'] = null;
	ANCORA_GLOBALS['media_link'] = '';
});

function ancora_show_media_manager(el) {
	"use strict";

	ANCORA_GLOBALS['media_link'] = jQuery(el);
	// If the media frame already exists, reopen it.
	if ( ANCORA_GLOBALS['media_frame'] ) {
		ANCORA_GLOBALS['media_frame'].open();
		return false;
	}

	// Create the media frame.
	ANCORA_GLOBALS['media_frame'] = wp.media({
		// Set the title of the modal.
		title: ANCORA_GLOBALS['media_link'].data('choose'),
		// Tell the modal to show only images.
		library: {
			type: 'image'
		},
		// Multiple choise
		multiple: ANCORA_GLOBALS['media_link'].data('multiple')===true ? 'add' : false,
		// Customize the submit button.
		button: {
			// Set the text of the button.
			text: ANCORA_GLOBALS['media_link'].data('update'),
			// Tell the button not to close the modal, since we're
			// going to refresh the page when the image is selected.
			close: true
		}
	});

	// When an image is selected, run a callback.
	ANCORA_GLOBALS['media_frame'].on( 'select', function(selection) {
		"use strict";
		// Grab the selected attachment.
		var field = jQuery("#"+ANCORA_GLOBALS['media_link'].data('linked-field')).eq(0);
		var attachment = '';
		if (ANCORA_GLOBALS['media_link'].data('multiple')===true) {
			ANCORA_GLOBALS['media_frame'].state().get('selection').map( function( att ) {
				attachment += (attachment ? "\n" : "") + att.toJSON().url;
			});
			var val = field.val();
			attachment = val + (val ? "\n" : '') + attachment;
		} else {
			attachment = ANCORA_GLOBALS['media_frame'].state().get('selection').first().toJSON().url;
		}
		field.val(attachment);
		field.trigger('change');
	});

	// Finally, open the modal.
	ANCORA_GLOBALS['media_frame'].open();
	return false;
}
