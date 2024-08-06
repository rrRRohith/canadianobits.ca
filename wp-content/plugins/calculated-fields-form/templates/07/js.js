fbuilderjQuery( window ).on( 'load', function(){
	var $ = fbuilderjQuery;
	$( 'form.cp_cff_minimalist' ).each(
		function()
		{
			var f = $(this);
			if($('.pbreak', f).length > 1)
			{
				var ps = $('.pbreak', f),
					t = ps.length;

				ps.each(function(i){
					var p = $(this);
					if(p.find('.wizard-progressbar').length != 0) return;
					p.prepend('<div><div class="wizard-progressbar"><div class="wizard-progressbar-value" style="width:'+((i+1)/t*100)+'%"></div></div></div>');
				});
			}
		}
	)
});