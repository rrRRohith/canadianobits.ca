	$.fbuilder.controls[ 'fcontainer' ]=function(){};
	$.extend(
		$.fbuilder.controls[ 'fcontainer' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			fields:[],
			columns:1,
			rearrange:0,
			editItemEvents:function()
				{
					var evt=[
						{s:"#sColumns",e:"change", l:"columns"},
						{s:"#sRearrange",e:"click", l:"rearrange",f:function(el){return el.is(":checked");}}
					];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showShortLabel:function(){ return ''; },
			showUserhelp:function(){ return ''; },
			showSpecialDataInstance: function()
				{
					var cStr = '';
					for( var i = 0, h = 12; i < h; i++ )
					{
						cStr += '<option value="'+(i+1)+'" '+( ( this.columns == (i+1) ) ? 'SELECTED' : '' )+'>'+(i+1)+' column'+( ( i ) ? 's' : '' )+'</option>';
					}
					return '<div><label>Columns</label><select name="sColumns" id="sColumns">' + cStr + '</select> <input type="button" class="eq_btn button-secondary" onclick="window.open(\'https://cff.dwbooster.com/documentation#container-fields\');" value="?" title="Tutorial"><div class="clearer"><span class="uh">Shown in columns the fields into the container.</span></div></div>'+
					'<div><label><input name="sRearrange" id="sRearrange" type="checkbox" '+((this.rearrange) ? 'CHECKED' : '')+'> Rearrange</label> <span class="uh">Rearrange the fields in the container.</span></div>';
				},
			remove : function()
				{
					var fieldsIndex = this.fBuild.getFieldsIndex();
					for( var i = this.fields.length - 1, h = 0; i >= h; i-- )
					{
						this.fBuild.removeItem( fieldsIndex[this.fields[ i ]] );
					}
				},
			duplicateItem: function( currentField, newField )
				{
					for( var i = 0, h = this.fields.length; i < h; i++ )
					{
						if( this.fields[ i ] == currentField )
						{
							this.fields.splice( i+1, 0, newField );
							return;
						}
					}
				},
			addItem: function( newField, afterField )
				{
					if( typeof afterField != 'undefined' )
					{
						for( var i = 0, h = this.fields.length; i < h; i++ )
						{
							if( this.fields[ i ] == afterField )
							{
								this.fields.splice( i+1, 0, newField );
								return;
							}
						}
					}
					this.fields.push( newField );
				},
			after_show:function()
				{
					var me  = this,
						e   = $( '#field' + me.form_identifier + '-' + me.index + ' .fieldscontainer' ),
						tmp = [],
						items = me.fBuild.getItems(),
						fieldsIndex = me.fBuild.getFieldsIndex();

					for( var i = 0, h = me.fields.length; i < h; i++ )
					{
						if( typeof fieldsIndex[ me.fields[ i ] ] != 'undefined' )
						{
							// Assign the parent
							items[ fieldsIndex[ me.fields[ i ] ] ][ 'parent' ] = me.name;

							var f 	= $( '.' + me.fields[ i ] );
							if( f.length )
							{
								f.detach().appendTo( e );
								tmp.push( me.fields[ i ] );
							}
						}
					}
					me.fields = tmp;

					e.sortable(
						{
							'connectWith': '.ui-sortable',
							'items': '.fields',
							'placeholder': 'ui-state-highlight',
							'tolerance': 'pointer',
							'update': function( event, ui )
									{
                                        var p = ui.item.parents('.fields');
										if( p.length && $(this ).parents( '.fields' ).attr( 'id' ) == p.attr( 'id' ) )
										{
											var index = ui.item.index(), field, old_index;
                                            if(ui.item.hasClass('cff-button-drag')) // It is  an new control
                                            {
                                                ui.item = $('.'+window['cff_form'].fBuild.addItem(ui.item.data('control'), -3).name);
                                            }

                                            // receive or or changing the ordering in the fieldscontainer
                                            field = /((fieldname)|(separator))\d+/.exec(ui.item.attr('class'))[0];

                                            old_index = $.inArray(field, me.fields);
                                            if(old_index != -1) me.fields.splice(old_index,1);

											me.fields.splice(index,0,field);
											$.fbuilder.reloadItems();
                                            $('.'+/((fieldname)|(separator))\d+/.exec(ui.item.attr('class'))[0]).click();
										}
										else
										{
											// remove
											var index = $.inArray( me.fBuild.getItems()[ ui.item.attr( 'id' ).replace( 'field-', '' ) ].name, me.fields );
											if( index != -1 ) me.fields.splice( index, 1 );
										}
									}
						}
					);
				},
        columnsSticker: function()
            {
                var c = this.columns, s = '<div class="sticker">';
                for(var i = 0; i<c; i++)
                    s += '<i class="sticker-'+c+'"></i>';
                s += '</div>';
                return s;
            }
	});