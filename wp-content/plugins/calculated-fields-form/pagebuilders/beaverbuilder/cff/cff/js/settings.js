(function($){
	function cffCallback(evt)
	{
		if('fbuilderjQuery' in window)
		{
			delete fbuilderjQuery.fbuilderGeneratorFlag;
			fbuilderjQuery.fbuilderjQueryGenerator();
		}
	};
	$( '.fl-builder-content' ).on( 'fl-builder.preview-rendered', cffCallback );
	$( '.fl-builder-content' ).on( 'fl-builder.layout-rendered', cffCallback );

})(jQuery)