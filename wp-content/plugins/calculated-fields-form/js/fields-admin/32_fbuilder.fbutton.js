	$.fbuilder.typeList.push(
		{
			id:"fButton",
			name:"Button",
			control_category:1
		}
	);
	$.fbuilder.controls['fButton']=function(){};
	$.extend(
		$.fbuilder.controls['fButton'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			ftype:"fButton",
            sType:"button", // button, reset, calculate, print
            sValue:"button",
            sOnclick:"",
            sOnmousedown:"",
			sLoading:false,
			sMultipage:false,
			userhelp:"A description of the section goes here.",
			display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><input type="button" disabled value="'+cff_esc_attr(this.sValue)+'"><span class="uh">'+this.userhelp+'</span><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt=[
						{s:"#sValue",e:"change keyup", l:"sValue"},
						{s:"#sLoading",e:"click", l:"sLoading",f:function(el){return el.is(':checked');}},
						{s:"#sMultipage",e:"click", l:"sMultipage",f:function(el){return el.is(':checked');}},
						{s:"#sOnclick",e:"change keyup", l:"sOnclick"},
						{s:"#sOnmousedown",e:"change keyup", l:"sOnmousedown"},
						{
							s:"[name='sType']",e:"click",
							l:"sType",
							f:function(e)
							{
								var v = e.val(),
									l = $('#sLoading').closest('div'),
									p = $('#sMultipage').closest('div');
								l.hide();
								p.hide();
								if(v == 'calculate') l.show();
								if(v == 'print') p.show();
								return v;
							}
						}
					];
					$.fbuilder.controls['ffields'].prototype.editItemEvents.call(this,evt);
				},
            showSpecialDataInstance: function()
                {
                    return this._showTypeSettings()+this._showValueSettings()+this._showOnclickSettings();
                },
            _showTypeSettings: function()
                {
                    var l = ['calculate', 'print', 'reset', 'button'],
                        r  = "", v;
					for(var i = 0, h = l.length; i < h; i++)
                    {
                        v = cff_esc_attr(l[i]);
                        r += '<label class="column width20"><input type="radio" name="sType" value="'+v+'" '+((this.sType == v) ? 'CHECKED' : '')+' >'+v+'</label>';
                    }
					r += '<div class="clear"></div>';
					r += '<div '+((this.sType != 'calculate') ? 'style="display:none;"' : '')+'><label><input type="checkbox" id="sLoading" '+((this.sLoading) ? 'CHECKED' : '')+' > display "calculation in progress" indicator</label></div>';
					r += '<div '+((this.sType != 'print') ? 'style="display:none;"' : '')+'><label><input type="checkbox" id="sMultipage" '+((this.sMultipage) ? 'CHECKED' : '')+' > print all pages in multipage form</label></div>';
                    return '<label>Select button type</label>'+r+'<div class="clearer" />';
                },
            _showValueSettings: function()
                {
                    return '<label>Value</label><input type="text" class="large" name="sValue" id="sValue" value="'+cff_esc_attr(this.sValue)+'" />';
                },
            _showOnclickSettings: function()
                {
                    return '<label>OnClick event</label><textarea class="large" name="sOnclick" id="sOnclick">'+cff_esc_attr(this.sOnclick)+'</textarea><div class="clearer"><i>To transform the button into a submit button, enter the onclick event: <b>jQuery(this.form).submit();</b></i></div>'+
                    '<label>OnMouseDown event</label><textarea class="large" name="sOnmousedown" id="sOnmousedown">'+cff_esc_attr(this.sOnmousedown)+'</textarea>';
                },
            showTitle: function(){ return ''; },
            showShortLabel: function(){ return ''; }
	});