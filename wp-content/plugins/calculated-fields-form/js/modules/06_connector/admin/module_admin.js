fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'connector' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#connection-module',
	'toolbars'		: {
		'connector' : {
			'label' : 'Third-party Connection',
			'buttons' : [
							{
								"value" : "cffProxy",
								"code" : "cffProxy(",
								"tip" : "<p>This operation works as a proxy for third party functions. cffProxy accepts multiple parameters, where the first one must be the third party function, and the other parameters would be pass as the parameters of this third party function. cffProxy pass as the last parameter of the third party function a callback function. From the third party function should be called this callback function, passing to it the result of third party function. <strong>cffProxy( function(callback){ callback(123);})</strong></p>"
							}
						]
		}
	}
};