/**
 * ANCORA Framework: Admin scripts
 *
 * @package	themerex
 * @since	themerex 1.0
 */


// Fill categories after change post type in widgets
function ancora_admin_change_post_type(fld) {
	"use strict";
	var cat_lbl = jQuery(fld).parent().next().find('label');
	cat_lbl.append('<span class="sc_refresh iconadmin-spin3 animate-spin"></span>');
	var pt = jQuery(fld).val();
	// Prepare data
	var data = {
		action: 'ancora_admin_change_post_type',
		nonce: ANCORA_GLOBALS['ajax_nonce'],
		post_type: pt
	};
	jQuery.post(ANCORA_GLOBALS['ajax_url'], data, function(response) {
		"use strict";
		var rez = JSON.parse(response);
		if (rez.error === '') {
			var cat_fld = jQuery(fld).parent().next().find('select');
			var opt_first = cat_fld.find('option').eq(0);
			var opt_list = '<option value="'+opt_first.val()+'">'+opt_first.html()+'</option>';
			for (var i in rez.data.ids) {
				opt_list += '<option value="'+rez.data.ids[i]+'">'+rez.data.titles[i]+'</option>';
			}
			cat_fld.html(opt_list);
			cat_lbl.find('span').remove();
		}
	});
	return false;
}

