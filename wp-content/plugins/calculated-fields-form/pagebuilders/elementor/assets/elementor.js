jQuery(function(){
	try
	{
		elementor.channels.editor.on('cff_open_form_editor', function(){
			try
			{
				if(typeof cp_calculatedfieldsf_elementor != 'undefined')
				{
					window.open(
						cp_calculatedfieldsf_elementor.url+jQuery('[data-setting="form"] option:selected').attr('value'),
						'_blank'
					);
				}
			}
			catch(err){}
		});
	}
	catch(err){}
});