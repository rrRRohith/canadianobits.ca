	$.fbuilder.typeList.push(
		{
			id:"fpassword",
			name:"Password",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fpassword' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fpassword' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Untitled",
			ftype:"fpassword",
			predefined:"",
			predefinedClick:false,
			required:false,
			exclude:false,
			size:"medium",
			minlength:"",
			maxlength:"",
			equalTo:"",
			regExp:"",
			regExpMssg:"",
			display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield"><input class="field disabled '+this.size+'" type="password" value="'+cff_esc_attr(this.predefined)+'"/><span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
							{s:"#sSize",e:"change", l:"size", x:1},
							{s:"#sMinlength",e:"change keyup", l:"minlength", x:1},
							{s:"#sMaxlength",e:"change keyup", l:"maxlength", x:1},
							{s:"#sRegExp",e:"change keyup", l:"regExp"},
							{s:"#sRegExpMssg",e:"change keyup", l:"regExpMssg"},
							{s:"#sEqualTo",e:"change", l:"equalTo", x:1}
						],
						items = this.fBuild.getItems();
					$('.equalTo').each(function()
						{
							var str = '<option value="" '+(("" == $(this).attr("dvalue"))?"selected":"")+'></option>';
							for (var i=0;i<items.length;i++)
							{
								if (
									$.inArray(items[i].ftype, ['ftext', 'femail', 'fpassword', 'ftextds', 'femailds']) != -1 &&
									items[i].name != $(this).attr("dname")
								)
								{
									str += '<option value="'+items[i].name+'" '+((items[i].name == $(this).attr("dvalue"))?"selected":"")+'>'+cff_esc_attr(items[i].title)+'</option>';
								}
							}
							$(this).html(str);
						});
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
				},
			showSpecialDataInstance: function()
				{
					return '<div class="column width50"><label>Min length/characters</label><input type="text" name="sMinlength" id="sMinlength" value="'+cff_esc_attr(this.minlength)+'" class="large"></div><div class="column width50"><label>Max length/characters</label><input type="text" name="sMaxlength" id="sMaxlength" value="'+cff_esc_attr(this.maxlength)+'" class="large"></div><div class="clearer"></div><label style="padding-bottom:5px;">Validate against a regular expression <input type="button" onclick="window.open(\'https://cff-bundles.dwbooster.com/product/regexp\');" value="+" title="Resources" /></label><input type="text" name="sRegExp" id="sRegExp" value="'+cff_esc_attr(this.regExp)+'" class="large" /><label>Error message when the regular expression fails</label><input type="text" name="sRegExpMssg" id="sRegExpMssg" value="'+cff_esc_attr(this.regExpMssg)+'" class="large" />';
				}
	});