/* global jQuery:false */
/* global TRX_UTILS_GLOBALS:false */

jQuery(document).ready(function(){

	"use strict";

	// Hide/Show pages list on change import_posts
	jQuery('#trx_importer_form .trx_importer_item_posts').on('change', function() {
		var demo_set = jQuery('#trx_importer_form [name="demo_set"]:checked').val();
		if (jQuery(this).get(0).checked && demo_set=='part') 
			jQuery('.trx_importer_part_pages').show();
		else
			jQuery('.trx_importer_part_pages').hide();
	});

	// Change demo type
	jQuery('.trx_importer_demo_type input[type="radio"]').on('change', function() {
		var type = jQuery(this).val();
		// Refresh list of the pages
		var data = {
			ajax_nonce: TRX_UTILS_GLOBALS['ajax_nonce'],
			action: 'trx_utils_importer_get_list_pages',
			demo_type: type
		};
		jQuery.post(TRX_UTILS_GLOBALS['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: TRX_UTILS_GLOBALS['ajax_error']+':<br>'+response };
				console.log(response);
			}
			if (rez.error === '') {
				var html = '';
				for (var id in rez.data) {
					html += '<label>'
							+ '<input class="trx_importer_pages" type="checkbox" value="'+id+'" name="import_pages_'+id+'" id="import_pages_'+id+'" />'
							+ ' ' + rez.data[id]
							+ '</label>';
				}
				if (html != '') jQuery('.trx_importer_part_pages').html(html);
			}
		});
	});

	// Change demo set
	jQuery('.trx_importer_demo_set input[type="radio"]').on('change', function() {
		var set = jQuery(this).val();
// Confirm about full installation
        if (set == 'full' && !confirm(TRX_UTILS_GLOBALS['msg_importer_full_alert'])) {
            var obj = jQuery(this).parents('.trx_importer_demo_set');
            setTimeout(function() {
                obj.find('input[type="radio"]').removeAttr('checked').get(0).checked = true;
            }, 1);
            return;
        }
        // Check all components if full installation is checked and uncheck otherwise
        jQuery('.trx_importer_advanced_settings > label > input[type="checkbox"]').each(function() {
            this.checked = set == 'full' || jQuery(this).attr('id') == 'import_posts';
            jQuery(this).trigger('change');
        });
        // Show/hide description of the set
        jQuery(this).parents('form')
            .find('.trx_importer_description:not(.trx_importer_description_both)').slideUp()
            .end()
            .find('.trx_importer_description_'+set).slideDown();
        // Show/hide set items
        jQuery(this).parents('form').find('[data-set-'+set+'="1"]').parent().show();
        jQuery(this).parents('form').find('[data-set-'+set+'="0"]').removeAttr('checked').parent().hide();
        jQuery(this).parents('form').find('.trx_importer_item_posts').trigger('change');
    });
    jQuery('.trx_importer_demo_set input[type="radio"]:checked').trigger('change');

    // Show/Hide advanced settings
    jQuery('.trx_importer_advanced_settings_title').on('click', function(e) {
        var wrap = jQuery(this).parent();
        if (wrap.hasClass('trx_importer_advanced_settings_opened')) {
            jQuery('.trx_importer_advanced_settings').slideUp();
            wrap.removeClass('trx_importer_advanced_settings_opened');
        } else {
            jQuery('.trx_importer_advanced_settings').slideDown();
            wrap.addClass('trx_importer_advanced_settings_opened');
        }
        e.preventDefault();
        return false;
    });
	
	// Start import
	jQuery('.trx_importer_section').on('click', '.trx_buttons input[type="button"]', function() {
		var steps = [];
		var demo_type = jQuery('#trx_importer_form [name="demo_type"]:checked').val();
		var demo_set = jQuery('#trx_importer_form [name="demo_set"]:checked').val();
		var demo_parts = '', demo_pages = '';
		jQuery(this).parents('form').find('input[type="checkbox"].trx_importer_item').each(function() {
			var name = jQuery(this).attr('name');
			// Collect parts to be imported
			if (jQuery(this).get(0).checked) {
				demo_parts += (demo_parts ? ',' : '') + name.substr(7); // Remove 'import_' from name - save only slug
				// Collect pages to be import
				if (demo_set=='part' && name == 'import_posts') {
					jQuery('.trx_importer_part_pages input[type="checkbox"]').each(function() {
						if (jQuery(this).get(0).checked) {
							demo_pages += (demo_pages ? ',' : '') + jQuery(this).val();
						}
					});
				}
				var step = {
					action: name,
					data: {
						demo_type: demo_type,
						demo_set: demo_set,
						demo_parts: demo_parts,
						demo_pages: demo_pages,
						start_from_id: 0
					}
				};
				steps.push(step);
			} else
				jQuery('#trx_importer_progress .'+name).hide();
		});
		steps.unshift({
			action: 'import_start',
			data: { 
				demo_type: demo_type,
				demo_set: demo_set,
				demo_parts: demo_parts
			}
		});
		steps.push({
			action: 'import_end',
			data: { 
				demo_type: demo_type,
				demo_set: demo_set,
				demo_parts: demo_parts
			}
		});
		// Start banners rotator
		jQuery('.trx_exporter_section').hide();
		jQuery('.trx_banners_section').show();
		trx_utils_banners_rotator();
		// Start import
		jQuery('#trx_importer_form').hide();
		jQuery('#trx_importer_progress').fadeIn();
		TRX_UTILS_GLOBALS['importer_error_messages'] = '';
		TRX_UTILS_GLOBALS['importer_ignore_errors'] = true;
		trx_utils_importer_do_action(steps, 0);
	});
	
	// Call specified action (step)
	function trx_utils_importer_do_action(steps, idx) {
		if ( !jQuery('#trx_importer_progress .'+steps[idx].action+' .import_progress_status').hasClass('step_in_progress') )
			jQuery('#trx_importer_progress .'+steps[idx].action+' .import_progress_status').addClass('step_in_progress').html('0%');
		// AJAX query params
		var data = {
			ajax_nonce: TRX_UTILS_GLOBALS['ajax_nonce'],
			action: 'trx_utils_importer_start_import',
			importer_action: steps[idx].action
		};
		// Additional params depend current step
		for (var i in steps[idx].data)
			data[i] = steps[idx].data[i];
		// Send request to server
		jQuery.post(TRX_UTILS_GLOBALS['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: TRX_UTILS_GLOBALS['ajax_error']+':<br>'+response };
				console.log(response);
			}
			if (rez.error === '' || TRX_UTILS_GLOBALS['importer_ignore_errors']) {
				if (rez.error !== '') 
					TRX_UTILS_GLOBALS['importer_error_messages'] += '<p class="error_message">' + rez.error + '</p>';
				var action = rez.action;
				if (rez.result === null || rez.result >= 100) {
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').html('');
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').removeClass('step_in_progress').addClass('step_complete'+(rez.error ? ' step_complete_with_error' : ''));
					idx++;
				} else {
					jQuery('#trx_importer_progress .'+action+' .import_progress_status').html(rez.result + '%');
					steps[idx].data['start_from_id'] = (typeof rez.start_from_id != 'undefined') ? rez.start_from_id : 0;
					steps[idx].data['attempt'] = (typeof rez.attempt != 'undefined') ? rez.attempt : 0;
				}
				// Do next action
				if (idx < steps.length) {
					trx_utils_importer_do_action(steps, idx);
				} else {
					if (TRX_UTILS_GLOBALS['importer_error_messages']) {
						jQuery('#trx_importer_progress').removeClass('notice-info').addClass('notice-error').append('<h4>' + TRX_UTILS_GLOBALS['msg_importer_error'] + '</h4>' + TRX_UTILS_GLOBALS['importer_error_messages']);
					} else {
						jQuery('#trx_importer_progress').removeClass('notice-info').addClass('notice-success');
						jQuery('.trx_importer_progress_complete').show();
					}
				}
			} else {
				// Add Error block above Import section
				jQuery('#trx_importer_progress').removeClass('notice-info').addClass('notice-error').css({'paddingTop': '1em', 'paddingBottom': '1em'}).html(rez.error);
			}
		});
	}
	
	
	// Rotate banners
	function trx_utils_banners_rotator() {
		var banners = jQuery('.trx_banners_item');
		if (banners.length == 0) return;
		var active = jQuery('.trx_banners_item_active').index(),
			next = (active + 1) % banners.length,
			duration = 20000;
		if (active >= 0) {
			banners.eq(active).fadeOut(function() {
				jQuery(this).removeClass('trx_banners_item_active');
				banners.eq(next).fadeIn().addClass('trx_banners_item_active');
			});
		} else {
			banners.eq(next).fadeIn().addClass('trx_banners_item_active');
		}
		if (!isNaN(banners.eq(next).data('duration'))) {
			duration = Math.max(1000, Math.min(60000, Number(banners.eq(next).data('duration'))));
		}
		setTimeout(trx_utils_banners_rotator, duration);
	}

});
