fbuilderjQuery(function(){
	var $ = fbuilderjQuery;
	$(document)
	.on(
		'mouseover',
		'.cp_cff_11 input,.cp_cff_11 textarea,.cp_cff_11 select,.cp_cff_11 .slider-container',
		function()
		{
			$(this).closest( '.fields' ).addClass('cff-highlight');
		}
	)
	.on(
		'mouseout',
		'.cp_cff_11 input,.cp_cff_11 textarea,.cp_cff_11 select,.cp_cff_11 .slider-container',
		function()
		{
			$(this).closest( '.fields' ).removeClass('cff-highlight');
		}
	);
});