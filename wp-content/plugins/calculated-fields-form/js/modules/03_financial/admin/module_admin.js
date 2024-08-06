fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'financial' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#financial-module',
	'toolbars'		: {
		'finance' : {
			'label' : 'Financial functions',
			'buttons' : []
		}
	}
};