fbuilderjQuery = ( typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'datetime' ] = {
	'prefix' : '',
	'callback' : function()
		{
			fbuilderjQuery[ 'fbuilder' ][ 'extend_window' ]( fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'datetime' ][ 'prefix' ], CF_DATETIME );
		},
	
	'validator' : function( v )
		{
			if( /^\s*((\d{4}[\/\-\.]\d{1,2}[\/\-\.]\d{1,2})|(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{4}))?\s*(\d{1,2}\s*:\s*\d{1,2}(\s*:\s*\d{1,2})?(\s*[ap]m)?)?\s*$/i.test( v ) ) 
			{
				return true;
			}	
			return false;
		}
};