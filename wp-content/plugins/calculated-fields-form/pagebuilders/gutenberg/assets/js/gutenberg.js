jQuery(function()
	{
		(function( blocks, element ) {
			var el 			= element.createElement,
				InspectorControls = ('blockEditor' in wp) ? wp.blockEditor.InspectorControls : wp.editor.InspectorControls,
				category 	= {slug:'cp-calculated-fields-form', title : 'Calculated Fields Form'};

			/* Plugin Category */
			blocks.getCategories().push({slug: 'cpcff', title: 'Calculated Fields Form'});

			/* ICONS */
			const iconCPCFF = el('img', { width: 20, height: 20, src:  "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAABHNCSVQICAgIfAhkiAAAAGdJREFUOI1jnHnk3X8GKgAmahhCVYNYGBgYGDq3PqLIkHJvOeq5iHHQBTYLjIEcTuXecgydWx8xMDISNqDMSw7VIHTAyMjAcKdVH68hKtUX4Wzqew0d/P+PaiMhQLVYGw1swmDwZREAIzIpNydZa8YAAAAASUVORK5CYII=" } );

			const iconCPCFFV = el('img', { width: 20, height: 20, src:  "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAABHNCSVQICAgIfAhkiAAAAIhJREFUOI1jnHnk3X8GKgAmahhCVYNYkDlp1oIkaZ519D2cjeEi5aqLDMpVF3FqxiWP1Wt32/RxGoRLDmcYYbMVn0txGnS3TR9Fo3LVRbwuZcEpg2YYPkPwuohUgNcgmHfQvUmSQehhQsgwvIFNjBhegwglSGwAI9YIxQ4ueRSDkPMOqWDwFSMAJOI0MlfsCoEAAAAASUVORK5CYII=" } );

			/* Form's shortcode */
			blocks.registerBlockType( 'cpcff/form-shortcode', {
				title: 'Insert CFF',
				icon: iconCPCFF,
				category: 'cpcff',
				supports: {
					customClassName: false,
					className: false
				},
				attributes: {
					shortcode : {
						type : 'string',
						source : 'text',
						default: '[CP_CALCULATED_FIELDS id=""]'
					}
				},
				edit: function( props ) {

					function generate_shortcode()
					{
						props.setAttributes({'shortcode' : '[CP_CALCULATED_FIELDS id="'+id+'" '+additional+']'});
					};

					function set_attributes(evt)
					{
						if(evt.target.tagName == 'SELECT') // Form id
						{
							id = evt.target.value;
						}
						else // Additional attributes
						{
							additional = evt.target.value;
						}
						generate_shortcode();
					};

					function edit_form()
					{
						try
						{
							window.open(cpcff_gutenberg_editor_config.editor+id, '_blank');
						}
						catch(err){}
					};

					function get_id()
					{
						var output = '',
							shortcode = props.attributes.shortcode,
							m = shortcode.match(/\bid\s*=\s*['"]([^'"]*)['"]/i);
						if(m) output = m[1];
						return output;
					};

					function get_addtional_atts()
					{
						var output = props.attributes.shortcode;
						output = output.replace(/^\s*\[\s*CP_CALCULATED_FIELDS\s+id\s*=\s*['"][^'"]*['"]\s*/i, '').replace(/\]\s*$/,'');
						return output;
					};

					function generate_url_params()
					{
						var shortcode = wp.shortcode.next('CP_CALCULATED_FIELDS', props.attributes.shortcode),
							attrs = shortcode.shortcode.attrs.named,
							output  = attrs['id'];
						for (var i in attrs) {
							if(i == 'id') continue;
							output += '&'+encodeURIComponent(i)+'='+encodeURIComponent(attrs[i]);
						}
						return output;
					};

					// Main function code
					var focus = props.isSelected,
						options = [],
						id = get_id(),
						additional = get_addtional_atts(),
						children = [];

                    if(
                        'url' in cpcff_gutenberg_editor_config &&
                        typeof cff_gutenberg_editor_config_interval == 'undefined'
                    )
                    {
                        cff_gutenberg_editor_config_interval = setInterval(
                            function(){
                                $cff_backend_url = cpcff_gutenberg_editor_config['url'].split('?')[0];
                                jQuery.getJSON($cff_backend_url, {'cff-action': 'cff-gutenberg-editor-config'}, function(data){
                                    if(typeof data == 'object' && 'url' in data)
                                        cpcff_gutenberg_editor_config = data;
                                });
                            },
                            40000
                        );
                    }

					// Creates the options for the forms list
					for( var form_id in cpcff_gutenberg_editor_config['forms'])
					{
						var key = 'cpcff_inspector_option_'+form_id,
							config = {key: key, value: form_id};

						if( /^\s*$/.test(id)) id = form_id;
						options.push(el('option', config, cpcff_gutenberg_editor_config['forms'][form_id]));
					}
					generate_shortcode();

					if(!/^\s*$/.test(id))
					{
						children.push(
							el( 'div', {className: 'cff-iframe-container', key: 'cpcff_form_container'},
								el('div', {className: 'cff-iframe-overlay', key: 'cpcff_form_overlay'}),
								el('iframe',
									{
										key: 'cpcff_form_iframe',
										src: cpcff_gutenberg_editor_config['url']+generate_url_params(),
										height: '0',
										width: '500',
										scrolling: 'no'
									}
								)
							)
						);
					}
					else
					{
						children.push(
							el('span',
								{
									key: 'cpcff_form_required'
								},
								'Select at least a form'
							)
						);
					}

					if(!!focus)
					{
						children.push(
							el(
								InspectorControls,
								{
									key: 'cpcff_inspector'
								},
								el(
									'div',
									{
										key: 'cpcff_inspector_container',
										style:{paddingLeft:'20px',paddingRight:'20px'}
									},
									[
										el(
											'span',
											{
												key: 'cpcff_inspector_help',
												style:{fontStyle: 'italic'}
											},
											'If you need help: '
										),
										el(
											'a',
											{
												key		: 'cpcff_inspector_help_link',
												href	: 'https://cff.dwbooster.com/documentation#insertion-page',
												target	: '_blank'
											},
											'CLICK HERE'
										),
										el(
											'hr',
											{
												key : 'cpcff_inspector_separator'
											}
										),
										el(
											'label',
											{
												key : 'cpcff_inspector_forms_label'
											},
											cpcff_gutenberg_editor_config['labels']['forms']
										),
										el(
											'select',
											{
												key : 'cpcff_inspector_forms_list',
												style : {width: '100%'},
												onChange : set_attributes,
												value: id
											},
											options
										),
										el(
											'label',
											{
												key : 'cpcff_inspector_attributes_label'
											},
											cpcff_gutenberg_editor_config['labels']['attributes']
										),
										el(
											'input',
											{
												type : 'text',
												key : 'cpcff_inspector_text',
												value : get_addtional_atts(),
												onChange : set_attributes,
												style: {width:"100%"}
											}
										),
										el(
											'span',
											{
												key : 'cpcff_inspector_attributes_help',
												style:{fontStyle: 'italic'}
											},
											'variable_name="value"'
										),
										el(
											'div',
											{
												key: 'cpcff_inspector_button_container',
												style:{
													paddingTop:'20px',
													display:((cpcff_gutenberg_editor_config.is_admin) ? 'block' : 'none')
												}
											},
											el(
												'input',
												{
													type: 'button',
													key: 'cpcff_form_editor',
													value: cpcff_gutenberg_editor_config['labels']['edit_form'],
													className: 'button-primary',
													onClick: edit_form
												}
											)
										)
									]
								)
							)
						);
					}

					return [
						children
					];
				},

				save: function( props ) {
					return props.attributes.shortcode;
				}
			});

			/* variable shortcode */
			blocks.registerBlockType( 'cpcff/variable-shortcode', {
				title: 'Create var from POST, GET, SESSION, or COOKIES',
				icon: iconCPCFFV,
				category: 'cpcff',
				supports: {
					customClassName: false,
					className: false
				},
				attributes: {
					shortcode : {
						type : 'string',
						source : 'text',
						default: '[CP_CALCULATED_FIELDS_VAR name=""]'
					}
				},

				edit: function( props ) {
					var focus = props.isSelected;
					return [
						!!focus && el(
							InspectorControls,
							{
								key: 'cpcff_inspector'
							},
							el(
								'div',
								{
									key: 'cpcff_inspector_container',
									style:{paddingLeft:'20px',paddingRight:'20px'}
								},
								[
									el(
										'span',
										{
											key: 'cpcff_inspector_help',
											style:{fontStyle: 'italic'}
										},
										'If you need help: '
									),
									el(
										'a',
										{
											key		: 'cpcff_inspector_help_link',
											href	: 'https://cff.dwbooster.com/documentation#javascript-variables',
											target	: '_blank'
										},
										'CLICK HERE'
									)
								]
							)
						),
						el(
							'textarea',
							{
								key: 'cpcff_variable_shortcode',
								value: props.attributes.shortcode,
								onChange: function(evt){
									props.setAttributes({shortcode: evt.target.value});
								},
								style: {width:"100%", resize: "vertical"}
							}
						)
					];
				},

				save: function( props ) {
					return props.attributes.shortcode;
				}
			});
		} )(
			window.wp.blocks,
			window.wp.element
		);
	}
);