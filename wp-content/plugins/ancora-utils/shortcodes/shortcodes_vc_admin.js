jQuery(document).ready(function () {

	if (typeof(vc) != 'undefined' && typeof(vc.shortcode_view) != 'undefined') {

		// Hook for the Visual Composer: now it correctly edit components in the container's
		//----------------------------------------------------------------------------------
		vc.shortcode_view.prototype.deleteShortcode = function (e) {
			if (_.isObject(e)) {
				e.preventDefault();
				e.stopPropagation();
			}
            var answer = confirm(window.i18nLocale.press_ok_to_delete_section);
            if (answer === true) this.model.destroy();
        };
        vc.shortcode_view.prototype.addElement = function (e) {
			if (_.isObject(e)) {
				e.preventDefault();
				e.stopPropagation();
			}
			vc.add_element_block_view.render(this.model, !_.isObject(e) || !jQuery(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls'));
		};
		vc.shortcode_view.prototype.editElement = function (e) {
			if (_.isObject(e)) {
				e.preventDefault();
				e.stopPropagation();
			}
			vc.edit_element_block_view.render(this.model);
		};
		if (typeof(window.InlineShortcodeView)=='undefined') {
			// Backend editor
		vc.shortcode_view.prototype.clone = function (e) {
			if (_.isObject(e)) {
				e.preventDefault();
				e.stopPropagation();
			}
			vc.clone_index = vc.clone_index / 10;
			return this.cloneModel(this.model, this.model.get('parent_id'));
		};
		}

		// Text class (title, etc.)
		//--------------------------------------------------
		window.VcTrxTextView = vc.shortcode_view.extend({
			changeShortcodeParams:function (model) {
			  var params = this.model.get('params'), $wrapper;
			  window.VcTrxTextView.__super__.changeShortcodeParams.call(this, model);
				if (_.isObject(params) && _.isString(params.content)) {
					var inner = this.$el.find('> .wpb_element_wrapper > .wpb_element_title').html();
					var pos = -1;
					if ((pos = inner.lastIndexOf('</i>')) > 0)
						inner = inner.substr(0, pos+4) + ' ' + params.content.replace(/\\n/g, "<br>");
					else if ((pos = inner.lastIndexOf('</span>')) > 0)
						inner = inner.substr(0, pos+7) + ' ' + params.content.replace(/\\n/g, "<br>");
					this.$el.find('> .wpb_element_wrapper > .wpb_element_title').html(inner);
				}
			},
			changedContent: function(view) {
				window.VcTrxTextView.__super__.changedContent.call(view);
				var params = this.model.get('params');
				if (_.isObject(params) && _.isString(params.count)) {
					var inner = this.$el.find('> .wpb_element_wrapper > .wpb_element_title').html();
					var pos = -1;
					if ((pos = inner.lastIndexOf('</i>')) > 0)
						inner = inner.substr(0, pos+4) + ' ' + params.content.replace(/\\n/g, "<br>");
					else if ((pos = inner.lastIndexOf('</span>')) > 0)
						inner = inner.substr(0, pos+7) + ' ' + params.content.replace(/\\n/g, "<br>");
					this.$el.find('> .wpb_element_wrapper > .wpb_element_title').html(inner);
				}
			}
		});

		// Container class (infobox, button, etc.)
		//--------------------------------------------------
		window.VcTrxTextContainerView = vc.shortcode_view.extend({
			changeShortcodeParams:function (model) {
			  var params = this.model.get('params'), $wrapper;
			  window.VcTrxTextContainerView.__super__.changeShortcodeParams.call(this, model);
				if (_.isObject(params) && _.isString(params.content)) {
					this.$el.find('> .wpb_element_wrapper > .vc_container_for_children').html(params.content.replace(/\\n/g, "<br>"));
				}
			}
		});

		// Columns container class (columns, team, etc.)
		//--------------------------------------------------
		window.VcTrxColumnsView = vc.shortcode_view.extend({
			changeShortcodeParams:function (model) {
				var params = this.model.get('params'), $wrapper;
				window.VcTrxColumnsView.__super__.changeShortcodeParams.call(this, model);
				if (_.isObject(params) && _.isString(params.count)) {
					ancora_vc_columns_width(this.$el, params.count);
				}
			},
			changedContent: function(view) {
				window.VcTrxColumnsView.__super__.changedContent.call(view);
				var params = this.model.get('params');
				if (_.isObject(params) && _.isString(params.count)) {
					ancora_vc_columns_width(this.$el, params.count);
				}
			}
		});

		// Column item class (trx_column_item)
		//--------------------------------------------------
		window.VcTrxColumnItemView = vc.shortcode_view.extend({
			changeShortcodeParams:function (model) {
				var params = this.model.get('params'), $wrapper;
				window.VcTrxColumnItemView.__super__.changeShortcodeParams.call(this, model);
				if (_.isObject(params) && _.isString(params.span)) {
					this.$el.removeClass('trx_columns_span_2 trx_columns_span_3 trx_columns_span_4 trx_columns_span_5');
					if (params.span > 1) this.$el.addClass('trx_columns_span_'+params.span);
					ancora_vc_columns_width(this.$el.parents('.trx_sc_columns'));
				}
			},
			changedContent: function(view) {
				window.VcTrxColumnsView.__super__.changedContent.call(view);
				var params = this.model.get('params');
				if (_.isObject(params) && _.isString(params.span)) {
					this.$el.removeClass('trx_columns_span_2 trx_columns_span_3 trx_columns_span_4 trx_columns_span_5');
					if (params.span > 1) this.$el.addClass('trx_columns_span_'+params.span);
					ancora_vc_columns_width(this.$el.parents('.trx_sc_columns'));
				}
			}
		});
	
		// Accordion class - override "Add Tab" method
		//--------------------------------------------------
		if (typeof(window.VcAccordionView) != 'undefined') {
			window.VcTrxAccordionView = window.VcAccordionView.extend({
				addTab:function (e) {
					e.preventDefault();
					e.stopPropagation();
					this.adding_new_tab = true;
					var dt = new Date(),
						tab_title = window.i18nLocale.section,
						tab_id = "sc_accordion_item_"+dt.getTime()+ '_' + Math.floor(Math.random() * 11);
					vc.shortcodes.create({shortcode:'trx_accordion_item', params:{title:tab_title, id:tab_id}, parent_id:this.model.id});
				}
			});
			window.VcTrxAccordionTabView = window.VcAccordionTabView.extend({
				events:{
					'click > .vc_controls .column_delete,.wpb_trx_accordion_item > .vc_controls .vc_control-btn-delete':'deleteShortcode',
					'click > .vc_controls .column_add,.wpb_trx_accordion_item > .vc_controls .vc_control-btn-prepend':'addElement',
					'click > .vc_controls .column_edit,.wpb_trx_accordion_item > .vc_controls .vc_control-btn-edit':'editElement',
					'click > .vc_controls .column_clone,.wpb_trx_accordion_item > .vc_controls .vc_control-btn-clone':'clone',
					'click > [data-element_type] > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
				}
			});
		}
		
	
		// List class - override "Add Tab"
		//--------------------------------------------------
		if (typeof(window.VcAccordionView) != 'undefined') {
			window.VcTrxListView = window.VcAccordionView.extend({
				addTab:function (e) {
					e.preventDefault();
					e.stopPropagation();
					this.adding_new_tab = true;
					var dt = new Date(),
						tab_title = window.i18nLocale.section,
						tab_id = "sc_list_item_"+dt.getTime()+ '_' + Math.floor(Math.random() * 11);
					vc.shortcodes.create({shortcode:'trx_list_item', params:{title:tab_title, id:tab_id}, parent_id:this.model.id});
				}		
			});
			window.VcTrxListItemView = window.VcAccordionTabView.extend({
				events:{
					'click > .vc_controls .column_delete,.wpb_trx_list_item > .vc_controls .vc_control-btn-delete':'deleteShortcode',
					'click > .vc_controls .column_add,.wpb_trx_list_item > .vc_controls .vc_control-btn-prepend':'addElement',
					'click > .vc_controls .column_edit,.wpb_trx_list_item > .vc_controls .vc_control-btn-edit':'editElement',
					'click > .vc_controls .column_clone,.wpb_trx_list_item > .vc_controls .vc_control-btn-clone':'clone',
					'click > [data-element_type] > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
				}
			});
		}
	
		// Tabs class - override "Add Tab"
		//--------------------------------------------------
		if (typeof(window.VcTabsView) != 'undefined') {
			window.VcTrxTabsView = window.VcTabsView.extend({
				createAddTabButton:function () {
					var dt = new Date(),
						new_tab_button_id = "sc_tab_" + dt.getTime()+ '_' + Math.floor(Math.random() * 11);
					this.$tabs.append('<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>');
					this.$add_button = jQuery('<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>').appendTo(this.$tabs.find(".tabs_controls"));
				},
				addTab:function (e) {
					e.preventDefault();
					e.stopPropagation();
					this.adding_new_tab = true;
					var dt = new Date(),
						tab_title = window.i18nLocale.tab,
						tab_id = "sc_tab_" + dt.getTime() + '_' + Math.floor(Math.random() * 11);
					vc.shortcodes.create({shortcode:'trx_tab', params:{title:tab_title,tab_id:tab_id,id:tab_id}, parent_id:this.model.id});
				}		
			});
			window.VcTrxTabView = window.VcTabView.extend({
				render:function () {
					var params = this.model.get('params');
					window.VcTrxTabView.__super__.render.call(this);
					if (!params.tab_id) {
						var dt = new Date();
						params.tab_id = params.id ? params.id : "sc_tab_" + dt.getTime() + '_' + Math.floor(Math.random() * 11);
						this.model.save('params', params);
					}
					if (params.tab_id != params.id) {
						params.id = params.tab_id ? params.tab_id : "sc_tab_" + dt.getTime() + '_' + Math.floor(Math.random() * 11);
						this.model.save('params', params);
					}
					if (params.tab_id.substr(0,1)>='0' && params.tab_id.substr(0,1)<='9') {
						params.tab_id = 'sc_tab_'+params.tab_id;
						this.model.save('params', params);
					}
					this.id = 'tab-'+params.tab_id;
					this.$el.attr('id', this.id);
					return this;
				}
			});
		}
	
		// Toggles class - override "Add Tab"
		//--------------------------------------------------
		if (typeof(window.VcAccordionView) != 'undefined') {
			window.VcTrxTogglesView = window.VcAccordionView.extend({
				addTab:function (e) {
					this.adding_new_tab = true;
					e.preventDefault();
					var dt = new Date(),
						tab_title = window.i18nLocale.section,
						tab_id = "sc_toogles_item_"+dt.getTime()+ '_' + Math.floor(Math.random() * 11);
					vc.shortcodes.create({shortcode:'trx_toggles_item', params:{title:tab_title, id:tab_id}, parent_id:this.model.id});
				}		
			});
			window.VcTrxTogglesTabView = window.VcAccordionTabView.extend({
				events:{
					'click > .vc_controls .column_delete,.wpb_trx_toggles_item > .vc_controls .vc_control-btn-delete':'deleteShortcode',
					'click > .vc_controls .column_add,.wpb_trx_toggles_item > .vc_controls .vc_control-btn-prepend':'addElement',
					'click > .vc_controls .column_edit,.wpb_trx_toggles_item > .vc_controls .vc_control-btn-edit':'editElement',
					'click > .vc_controls .column_clone,.wpb_trx_toggles_item > .vc_controls .vc_control-btn-clone':'clone',
					'click > [data-element_type] > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
				}
			});
		}


	
		// Field "Post type" changed - refresh categories
		//--------------------------------------------------
		jQuery('body').on('click', '.vc_edit-form-tab-control .vc_edit-form-link', function () {
			var idx = jQuery(this).parent().index();
			var pt = jQuery(this).parent().parent().siblings('.vc_edit-form-tab').eq(idx).find('select.post_type');
			if (pt.length > 0) pt.trigger('change');
		});
		jQuery('body').on('change', 'select.post_type', function () {
			"use strict";
			var fld = jQuery(this);
			var cat_fld = fld.parents('.vc_edit-form-tab').find('select.cat');
			var cat_lbl = cat_fld.parent().prev();
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
					var opt_list = '';
					for (var i in rez.data.ids) {
						opt_list += '<option class="'+rez.data.ids[i]+'" value="'+rez.data.ids[i]+'">'+rez.data.titles[i]+'</option>';
					}
					cat_fld.html(opt_list);
					cat_lbl.find('span').remove();
				}
			});
		});
	}
});


// Set columns count and calculate width for each column
function ancora_vc_columns_width(columns) {
	var count = arguments[1] ? arguments[1] : 0;
	var c = '';
	if (count > 0) 
		columns.removeClass('trx_columns_count_1 trx_columns_count_2 trx_columns_count_3 trx_columns_count_4 trx_columns_count_5').addClass('trx_columns_count_'+count);
	else {
		c = columns.attr('class');
		if ((pos = c.indexOf('trx_columns_count_')) >= 0)
			count = Math.max(1, c.substr(pos+18, 1));
	}
	columns.find('> .wpb_element_wrapper > .vc_container_for_children > .trx_sc_column_item').each(function(idx) {
		var m = 1; // Margin after column
		var w = Math.floor((100-count*m)/count);		
		var c = jQuery(this).attr('class');
		if ((pos = c.indexOf('trx_columns_span_')) >= 0) {
			var span = Math.max(1, c.substr(pos+17, 1));
			w = w*span + m*(span-1);
		}
		jQuery(this).css('width', w+'%');
	});
}
