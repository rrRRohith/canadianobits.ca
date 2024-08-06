fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'chart' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#chart-module',
	'toolbars'		: {
		'chart' : {
			'label' : 'Chart.js Integration',
			'buttons' : []
		}
	}
};