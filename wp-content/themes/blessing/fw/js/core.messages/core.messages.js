// Popup messages
//-----------------------------------------------------------------
jQuery(document).ready(function(){
	"use strict";

	ANCORA_GLOBALS['message_callback'] = null;
	ANCORA_GLOBALS['message_timeout'] = 5000;

	jQuery('body').on('click', '#ancora_modal_bg,.ancora_message .ancora_message_close', function (e) {
		"use strict";
		ancora_message_destroy();
		if (ANCORA_GLOBALS['message_callback']) {
			ANCORA_GLOBALS['message_callback'](0);
			ANCORA_GLOBALS['message_callback'] = null;
		}
		e.preventDefault();
		return false;
	});
});


// Warning
function ancora_message_warning(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'cancel-1';
	var delay = arguments[3] ? arguments[3] : ANCORA_GLOBALS['message_timeout'];
	return ancora_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'warning',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Success
function ancora_message_success(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'check';
	var delay = arguments[3] ? arguments[3] : ANCORA_GLOBALS['message_timeout'];
	return ancora_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'success',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Info
function ancora_message_info(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'info';
	var delay = arguments[3] ? arguments[3] : ANCORA_GLOBALS['message_timeout'];
	return ancora_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'info',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Regular
function ancora_message_regular(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'quote-1';
	var delay = arguments[3] ? arguments[3] : ANCORA_GLOBALS['message_timeout'];
	return ancora_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'regular',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Confirm dialog
function ancora_message_confirm(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var callback = arguments[2] ? arguments[2] : null;
	return ancora_message({
		msg: msg,
		hdr: hdr,
		icon: 'help-1',
		type: 'regular',
		delay: 0,
		buttons: ['Yes', 'No'],
		callback: callback
	});
}

// Modal dialog
function ancora_message_dialog(content) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var init = arguments[2] ? arguments[2] : null;
	var callback = arguments[3] ? arguments[3] : null;
	return ancora_message({
		msg: content,
		hdr: hdr,
		icon: '',
		type: 'regular',
		delay: 0,
		buttons: ['Apply', 'Cancel'],
		init: init,
		callback: callback
	});
}

// General message window
function ancora_message(opt) {
	"use strict";
	var msg = opt.msg != undefined ? opt.msg : '';
	var hdr  = opt.hdr != undefined ? opt.hdr : '';
	var icon = opt.icon != undefined ? opt.icon : '';
	var type = opt.type != undefined ? opt.type : 'regular';
	var delay = opt.delay != undefined ? opt.delay : ANCORA_GLOBALS['message_timeout'];
	var buttons = opt.buttons != undefined ? opt.buttons : [];
	var init = opt.init != undefined ? opt.init : null;
	var callback = opt.callback != undefined ? opt.callback : null;
	// Modal bg
	jQuery('#ancora_modal_bg').remove();
	jQuery('body').append('<div id="ancora_modal_bg"></div>');
	jQuery('#ancora_modal_bg').fadeIn();
	// Popup window
	jQuery('.ancora_message').remove();
	var html = '<div class="ancora_message ancora_message_' + type + (buttons.length > 0 ? ' ancora_message_dialog' : '') + '">'
		+ '<span class="ancora_message_close iconadmin-delete"></span>'
		+ (icon ? '<span class="ancora_message_icon iconadmin-'+icon+' icon-'+icon+'"></span>' : '')
		+ (hdr ? '<h2 class="ancora_message_header">'+hdr+'</h2>' : '');
	html += '<div class="ancora_message_body">' + msg + '</div>';
	if (buttons.length > 0) {
		html += '<div class="ancora_message_buttons">';
		for (var i=0; i<buttons.length; i++) {
			html += '<span class="ancora_message_button">'+buttons[i]+'</span>';
		}
		html += '</div>';
	}
	html += '</div>';
	// Add popup to body
	jQuery('body').append(html);
	var popup = jQuery('body .ancora_message').eq(0);
	// Prepare callback on buttons click
	if (callback != null) {
		ANCORA_GLOBALS['message_callback'] = callback;
		jQuery('.ancora_message_button').click(function(e) {
			"use strict";
			var btn = jQuery(this).index();
			callback(btn+1, popup);
			ANCORA_GLOBALS['message_callback'] = null;
			ancora_message_destroy();
		});
	}
	// Call init function
	if (init != null) init(popup);
	// Show (animate) popup
	var top = jQuery(window).scrollTop();
	jQuery('body .ancora_message').animate({top: top+Math.round((jQuery(window).height()-jQuery('.ancora_message').height())/2), opacity: 1}, {complete: function () {
		// Call init function
		//if (init != null) init(popup);
	}});
	// Delayed destroy (if need)
	if (delay > 0) {
		setTimeout(function() { ancora_message_destroy(); }, delay);
	}
	return popup;
}

// Destroy message window
function ancora_message_destroy() {
	"use strict";
	var top = jQuery(window).scrollTop();
	jQuery('#ancora_modal_bg').fadeOut();
	jQuery('.ancora_message').animate({top: top-jQuery('.ancora_message').height(), opacity: 0});
	setTimeout(function() { jQuery('#ancora_modal_bg').remove(); jQuery('.ancora_message').remove(); }, 500);
}
