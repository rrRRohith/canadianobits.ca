	$.fbuilder.typeList.push(
		{
			id:"fPageBreak",
			name:"Page break",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fPageBreak' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fPageBreak' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Page Break",
			ftype:"fPageBreak",
			display:function()
				{
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><div class="section_break"></div><label>'+this.title+'</label><span class="uh">'+this.userhelp+'</span><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this);
				},
			showTitle: function(){
                if(!$('[name="cff-progress-bar"]').length)
                    return '<br /><a href="https://cff-bundles.dwbooster.com/product/progress-bar" target="_blank">Include a progress bar on the form with links to the form pages</a>';
                return '';
            },
			showName: function(){ return ''; },
			showShortLabel: function(){ return ''; },
			showUserhelp: function(){ return ''; },
			showCsslayout: function(){ return ''; }
	});