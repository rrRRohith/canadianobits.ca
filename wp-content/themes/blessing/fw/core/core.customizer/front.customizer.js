// Customization panel

jQuery(document).ready(function() {
	"use strict";

	// Open/close panel
	if (jQuery('#custom_options').length > 0) {

		jQuery('#co_toggle').click(function(e) {
			"use strict";
			var co = jQuery('#custom_options').eq(0);
			if (co.hasClass('opened')) {
				co.removeClass('opened');
				jQuery('body').removeClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeOut(500);
			} else {
				co.addClass('opened');
				jQuery('body').addClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeIn(500);
			}
			e.preventDefault();
			return false;
		});
		jQuery('.custom_options_shadow').click(function(e) {
			"use strict";
			jQuery('#co_toggle').trigger('click');
			e.preventDefault();
			return false;
		});

		// First open custom panel
		if (ANCORA_GLOBALS['demo_time'] > 0) {
			if (ancora_get_cookie('ancora_custom_options_demo') != 1 ){
				setTimeout(function() { jQuery("#co_toggle").trigger('click'); }, ANCORA_GLOBALS['demo_time']);
				ancora_set_cookie('ancora_custom_options_demo', '1', 1);
			}
		}

		ancora_custom_options_reset(!ANCORA_GLOBALS['remember_visitors_settings']);

		jQuery('#custom_options #co_theme_reset').click(function (e) {
			"use strict";
			jQuery('#custom_options .co_section').each(function () {
				"use strict";
				jQuery(this).find('div[data-options]').each(function() {
					var opt = jQuery(this).data('options');
					if (ANCORA_GLOBALS['remember_visitors_settings'])
						ancora_del_cookie(opt);
					else
						ancora_custom_options_remove_option_from_url(opt);
				});
			});
			ancora_custom_options_show_loader();
			//window.location.reload();
			window.location.href = jQuery('#co_site_url').val();
			e.preventDefault();
			return false;
		});

		// Switcher
		var swither = jQuery("#custom_options .co_switch_box:not(.inited)" )
		if (swither.length > 0) {
			swither.each(function() {
				jQuery(this).addClass('inited');
				ancora_custom_options_switcher(jQuery(this));
			});
			jQuery("#custom_options .co_switch_box a" ).click(function(e) {
				"use strict";
				var value = jQuery(this).data('value');
				var wrap = jQuery(this).parent('.co_switch_box');
				var options = wrap.data('options');
				wrap.find('.switcher').data('value', value);
				if (ANCORA_GLOBALS['remember_visitors_settings']) ancora_set_cookie(options, value, 1);
				ancora_custom_options_reset(true);
				ancora_custom_options_switcher(wrap);
				ancora_custom_options_apply_settings(options, value);
				e.preventDefault();
				return false;
			});
		}

		// ColorPicker
		ancora_color_picker();
		jQuery('#custom_options .iColorPicker').each(function() {
			"use strict";
			jQuery(this).css('backgroundColor', jQuery(this).data('value'));
		});

		jQuery('#custom_options .iColorPicker').click(function (e) {
			"use strict";
			ancora_color_picker_show(null, jQuery(this), function(fld, clr) {
				"use strict";
				var val = fld.data('value');
				var options = fld.data('options');
				fld.css('backgroundColor', clr);
				if (ANCORA_GLOBALS['remember_visitors_settings']) ancora_set_cookie(options, clr, 1);
				if (options == 'bg_color') {
					if (ANCORA_GLOBALS['remember_visitors_settings'])  {
						ancora_del_cookie('bg_image');
						ancora_del_cookie('bg_pattern');
					}
				}
				ancora_custom_options_reset(true);
				ancora_custom_options_apply_settings(options, clr);
			});
		});
		
		// Color scheme
		jQuery('#custom_options #co_scheme_list a').click(function(e) {
			"use strict";
			jQuery('#custom_options #co_scheme_list .co_scheme_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.data('value');
			if (ANCORA_GLOBALS['remember_visitors_settings'])  {
				ancora_set_cookie('color_scheme', val, 1);
			}
			ancora_custom_options_reset(true);
			ancora_custom_options_apply_settings('color_scheme', val);
			e.preventDefault();
			return false;
		});
		
		// Background patterns
		jQuery('#custom_options #co_bg_pattern_list a').click(function(e) {
			"use strict";
			jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			if (ANCORA_GLOBALS['remember_visitors_settings'])  {
				ancora_del_cookie('bg_color');
				ancora_del_cookie('bg_image');
				ancora_set_cookie('bg_pattern', val, 1);
			}
			ancora_custom_options_reset(true);
			ancora_custom_options_apply_settings('bg_pattern', val);
			if (jQuery("#custom_options .co_switch_box .switcher").data('value') != 'boxed') {
				ANCORA_GLOBALS['co_add_params'] = {'bg_pattern': val};
				jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			}
			e.preventDefault();
			return false;
		});

		// Background images
		jQuery('#custom_options #co_bg_images_list a').click(function(e) {
			"use strict";
			jQuery('#custom_options #co_bg_images_list .co_image_wrapper, #custom_options #co_bg_pattern_list .co_pattern_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			if (ANCORA_GLOBALS['remember_visitors_settings'])  {
				ancora_del_cookie('bg_color');
				ancora_del_cookie('bg_pattern');
				ancora_set_cookie('bg_image', val, 1);
			}
			ancora_custom_options_reset(true);
			ancora_custom_options_apply_settings('bg_image', val);
			if (jQuery("#custom_options .co_switch_box .switcher").data('value') != 'boxed') {
				ANCORA_GLOBALS['co_add_params'] = {'bg_image': val};
				jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			}
			e.preventDefault();
			return false;
		});

		jQuery('#custom_options #co_bg_pattern_list a, #custom_options #co_bg_images_list a, .iColorPicker').hover(
			function() {
				"use strict";
				jQuery(this).addClass('current');
			},
			function() {
				"use strict";
				jQuery(this).removeClass('current');
			}
		);
	}
});

jQuery(window).resize(function () {
	"use strict";
	jQuery('#custom_options .sc_scroll').css('height',jQuery('#custom_options').height()-46);
})


// SwitchBox
function ancora_custom_options_switcher(wrap) {
	"use strict";
	var drag = wrap.find('.switcher').eq(0);
	var value = drag.data('value');
	var pos = wrap.find('a[data-value="'+value+'"]').position();
	if (pos != undefined) {
		drag.css({
			left: pos.left,
			top: pos.top
		});
	}
}

// Show Reset button
function ancora_custom_options_reset() {
	"use strict";

	var cooks = arguments[0] ? true : false;
	
	if (!cooks) {
		jQuery('#custom_options .co_section').each(function () {
			if (cooks) return;
	
			jQuery(this).find('div[data-options]').each(function() {
				var cook = ancora_get_cookie(jQuery(this).data('options'))
				if (cook != null && cook != undefined)
					cooks = true;			
			});
		});
	}
	if (cooks)
		jQuery('#custom_options').addClass('co_show_reset');			
	else
		jQuery('#custom_options').removeClass('co_show_reset');
}

// Remove specified option from URL
function ancora_custom_options_remove_option_from_url(option) {
	"use strict";
	var pos = -1, pos2 = -1, pos3 = -1;
	var loc = jQuery('#co_site_url').val();
	if (loc && (pos = loc.indexOf('?')) > 0) {
		if ((pos2 = loc.indexOf(option, pos)) > 0) {
			if ((pos3 = loc.indexOf('&', pos2)) > 0)
				loc = loc.substr(0, pos2) + loc.substr(pos3);
			else
				loc = loc.substr(0, pos2);
		}
		jQuery('#co_site_url').val(loc);
	}
}

// Show Loader
function ancora_custom_options_show_loader() {
	"use strict";
	jQuery('.custom_options_shadow').addClass('loading');
}

// Apply settings
function ancora_custom_options_apply_settings(option, val) {
	"use strict";
	if (window.ancora_skin_customizer)
		ancora_skin_customizer(option, val);
	else {
		ancora_custom_options_show_loader();
		location.reload();
	}
}
