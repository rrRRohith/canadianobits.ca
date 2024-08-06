/* global jQuery:false */
/* global TRX_UPDATER_STORAGE:false */

jQuery( document ).ready( function() {

	"use strict";


	// Screen 'Dashboard - Update'
	//-----------------------------------------------------------

	// Update theme components from 'update-core' screen
	var need_update = false;
	jQuery( '.trx_updater_upgrade_button:not([disabled]),.trx_updater_backups_button:not([disabled])' ).on(
		'click', function(e) {
			var button  = jQuery(this),
				action = button.hasClass( 'trx_updater_upgrade_button' ) 
							? 'update' 
							: ( button.hasClass( 'trx_updater_restore_backups_button' ) 
								? 'restore'
								: ( button.hasClass( 'trx_updater_delete_backups_button' ) 
									? 'delete'
									: ''
									)
								),
				wrapper = button.parents( '.trx_updater_upgrade,.trx_updater_backups' ),
				checked = wrapper.find( 'input[name="checked[]"]:checked' );
			if ( action !== '' ) {
				if ( checked.length > 0 ) {
					if ( action == 'update' || need_update !== false || confirm( TRX_UPDATER_STORAGE['msg_options_' + action] + ( action == 'delete' ? "\n" + TRX_UPDATER_STORAGE['msg_irreversable'] : '' ) ) ) {
						if ( need_update === false ) {
							need_update = checked.length;
							wrapper.find( '.trx_updater_upgrade_button,.trx_updater_backups_button' ).attr( 'disabled', 'disabled' );
							if ( wrapper.next().hasClass( 'trx_updater_info_box' ) ) {
								wrapper.next().remove();
							}
						}
						var chk = checked.eq(0);
						if ( ! chk.next().hasClass( 'trx_updater_upgrade_status_wrap' ) ) {
							chk.hide();
							chk.after( 
								'<div class="trx_updater_upgrade_status_wrap">'
									+ '<span class="trx_updater_upgrade_status trx_updater_upgrade_status_progress"></span>'
								+ '</div>'
							);
						}
						var status = chk.next().find('.trx_updater_upgrade_status');

						// Add to URL parameter 'activate-multi' to prevent 'welcome screen' from some plugins
						var url = trx_updater_add_to_url( chk.data( action + '-url' ), { 'trx_updater': need_update, 'activate-multi': 1 } );

						// Update current plugin
						jQuery.get(url)
							.done( function(response) {
								var result = false;
								if ( action == 'update' ) {
									if ( chk.data( 'update-result' ) !== undefined ) {
										result = chk.data( 'update-result' );
									} else {
										if ( response.indexOf( '<html' ) < 0 ) {
											response = '<div>' + response + '</div>';	// Wrap response if it contain only div.wrap
										}
										result = jQuery(response).find('.wrap > iframe').length > 0
														|| jQuery(response).find('.wrap > script').text().indexOf( 'wp.updates.decrementCount(' ) > 0;
									}
									if ( chk.data( 'activate-url' ) ) {
										chk.data( 'update-url', chk.data( 'activate-url' ) );
										chk.data( 'activate-url', false );
										chk.removeAttr( 'activate-url' );
										chk.data( 'update-result', result );
									} else {
										chk.data( 'update-url', false );
										chk.removeAttr( 'update-url' );										
									}
									if ( ! chk.data( 'update-url' ) && window.wp && window.wp.updates && window.wp.updates.decrementCount ) {
										window.wp.updates.decrementCount( "plugin" );
									}
								} else {
									var rez = {};
									if ( response === '' || response === 0 ) {
										rez = { error: TRX_UPDATER_STORAGE['msg_ajax_error'] };
									} else {
										try {
											rez = JSON.parse(response);
										} catch (e) {
											rez = { error: TRX_UPDATER_STORAGE['msg_ajax_error'] };
											console.log(response);
										}
									}
									result = rez.error == '';
								}
								if ( action != 'update' || ! chk.data( 'update-url' ) ) {
									status.addClass( 'trx_updater_upgrade_status_' + ( ! result ? 'error' : 'success' ) );
								}
								setTimeout( function() { button.trigger( 'click' ); }, 10 );
							} )
							.fail( function() {
								status.addClass( 'trx_updater_upgrade_status_error' );
								chk.data( 'update-url', false );
								chk.removeAttr( 'update-url' );										
								setTimeout( function() { button.trigger( 'click' ); }, 10 );
							} )
							.always( function() {
								if ( action != 'update' || ! chk.data( 'update-url' ) ) {
									need_update--;
									chk.get(0).checked = false;
									chk.removeAttr('checked');
									status.removeClass( 'trx_updater_upgrade_status_progress' );
								}
							} );
					}
				} else {
					if ( need_update === 0 && wrapper.find( '.trx_updater_upgrade_status' ).length > 0 ) {
						wrapper.after(
							'<div class="trx_updater_info_box trx_updater_info_box_' + ( wrapper.find( '.trx_updater_upgrade_status_error' ).length > 0 ? 'error' : 'success' ) + '">'
								+ ( wrapper.find( '.trx_updater_upgrade_status_error' ).length > 0
									? TRX_UPDATER_STORAGE['msg_'+action+'_error']
									: TRX_UPDATER_STORAGE['msg_'+action+'_success']
									)
								+ '<br>' + TRX_UPDATER_STORAGE['msg_page_reload']
							+ '</div>'
						);
						wrapper.find( '.trx_updater_upgrade_button,.trx_updater_backups_button' ).removeAttr( 'disabled' );
						need_update = false;
						setTimeout( function() {
							location.reload();
						}, 5000 );
					}
				}
			}
			e.preventDefault();
			return false;
		}
	);


	// Settings page
	//----------------------------------------------------------------------

	// Show/Hide backups on checkbox changed
	jQuery( 'input[type="checkbox"][name="trx_updater_backups_enable"]' ).on(
		'change', function(e) {
			if ( jQuery(this).get(0).checked ) {
				jQuery('.trx_updater_option_backups_list_row').show();
			} else {
				jQuery('.trx_updater_option_backups_list_row').hide();
			}
			e.preventDefault();
			return false;
		}
	);

	// Restore or Delete selected backups
	jQuery( 'input[type="button"][name="trx_updater_backups_restore"],input[type="button"][name="trx_updater_backups_delete"]' ).on(
		'click', function(e) {
			var action = jQuery(this).attr('name') == 'trx_updater_backups_restore' ? 'restore' : 'delete';
			if ( confirm( TRX_UPDATER_STORAGE['msg_options_' + action] ) ) {
				var checked = trx_updater_get_checklist_values( jQuery( '.trx_updater_option_backups_list' ) );
				if ( checked.length > 0 ) {
					var td = jQuery(this).parents('td').addClass( 'trx_updater_loading' );
					jQuery
						.post(
							TRX_UPDATER_STORAGE['ajax_url'],
							{
								nonce: TRX_UPDATER_STORAGE['ajax_nonce'],
								action: 'trx_updater_' + action + '_backups',
								backups: checked.join(',')
							}
						)
						.done( function(response) {
								var rez = {};
								if (response==='' || response===0) {
									rez = { error: TRX_UPDATER_STORAGE['msg_ajax_error'] };
								} else {
									try {
										rez = JSON.parse(response);
									} catch (e) {
										rez = { error: TRX_UPDATER_STORAGE['msg_ajax_error'] };
										console.log(response);
									}
								}
								for (var i=0; i<checked.length; i++) {
									jQuery('input[type="checkbox"][name="trx_updater_backups_item_'+checked[i]+'"]').each( function() {
										jQuery(this).parent().remove();
									});
								}
								if ( jQuery( '.trx_updater_option_backups_list_row input[type="checkbox"]' ).length == 0 ) {
									jQuery( '.trx_updater_option_backups_list_row' ).hide();
								}
								td.removeClass( 'trx_updater_loading' );
								alert( ( typeof rez.error != 'undefined' && rez.error != '' ? rez.error + "\n\n" : '')
										+ ( typeof rez.success != 'undefined' && rez.success != '' ? rez.success : '')
									);
						} );
				} else {
					alert( TRX_UPDATER_STORAGE['msg_options_select'] );
				}
			}
			e.preventDefault();
			return false;
		}
	);


	// Utilities
	//-------------------------------------------------------------

	// Collect values of checkboxes inside the specified container
	function trx_updater_get_checklist_values( cont ) {
		var values = [];
		jQuery( cont ).find( 'input[type="checkbox"]:checked' ).each( function() {
			values.push( jQuery(this).val() );
		} );
		return values;
	}

	// Add/Change arguments to the url address
	function trx_updater_add_to_url(loc, prm) {
		var ignore_empty = arguments[2] !== undefined ? arguments[2] : true;
		var q = loc.indexOf('?');
		var attr = {};
		if (q > 0) {
			var qq = loc.substr(q+1).split('&');
			var parts = '';
			for (var i=0; i < qq.length; i++) {
				parts = qq[i].split('=');
				attr[parts[0]] = parts.length>1 ? parts[1] : ''; 
			}
		}
		for (var p in prm) {
			attr[p] = prm[p];
		}
		loc = (q > 0 ? loc.substr(0, q) : loc) + '?';
		var i = 0;
		for (p in attr) {
			if (ignore_empty && attr[p] === '') continue;
			loc += (i++ > 0 ? '&' : '') + p + '=' + attr[p];
		}
		return loc;
	}

} );
