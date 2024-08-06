fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'url' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#url-module',
	'toolbars'		: {
		'url' : {
			'label' : 'URLs and Parameters',
			'buttons' : [
							{
								"value" : "getURL",
								"code" : "getURL()",
								"tip" : "<p>Returns the current URL. <strong>getURL()</strong></p>"
							},
							{
								"value" : "getURLProtocol",
								"code" : "getURLProtocol()",
								"tip" : "<p>Returns the current URL protocol in lowercase. <strong>getURLProtocol()</strong> returns <strong>https:</strong></p>"
							},
							{
								"value" : "getBaseURL",
								"code" : "getBaseURL()",
								"tip" : "<p>Returns the base URL of the current page. <strong>getBaseURL()</strong></p>"
							},
							{
								"value" : "getURLHash",
								"code" : "getURLHash()",
								"tip" : "<p>Returns # followed by the fragment identifier of the current page URL, or empty text. getURLHash accepts an optional parameter to removes the hash (#) symbol.<br>Ex. https://www.website.com/page#position<br><strong>getURLHash()</strong> returns <strong>#position</strong><br><strong>getURLHash(true)</strong> returns <strong>position</strong></p>"
							},
							{
								"value" : "getURLPath",
								"code" : "getURLPath()",
								"tip" : "<p>Returns the initial / symbol followed by the path of the current page URL, or empty text. getURLPath accepts an optional parameter to removes the leading and trailing slash (/) symbols.<br>Ex. https://www.website.com/pages/page1/<br><strong>getURLPath()</strong> returns <strong>/pages/page1/</strong><br><strong>getURLPath(true)</strong> returns <strong>pages/page1</strong></p>"
							},
							{
								"value" : "getURLParameters",
								"code" : "getURLParameters()",
								"tip" : "<p>Returns a plain object with the URLs parameters. The operation accepts an URL as optional parameter. <strong>getURLParameters()</strong></p>"
							},
							{
								"value" : "getURLParameter",
								"code" : "getURLParameter(",
								"tip" : "<p>Returns the value of an URL parameter. The operation accepts two parameters: the parameter name and the dafault value. The default value would be returned if the URL parameter does not exist. If not default value is passed as parameter, and the URL parameter does not exist, the operation returns null. <strong>getURLParameter(parameter_name, default_value)</strong> the default_value is optional.</p>"
							},
							{
								"value" : "getReferrer",
								"code" : "getReferrer()",
								"tip" : "<p>Returns the referrer URL or null.</p>"
							},
							{
								"value" : "generateURL",
								"code" : "generateURL(",
								"tip" : "<p>Generates an URL given their components. The operation accepts three parameters: the base URL (required parameter), a plain object for the URL parameters (optional parameter), a text with the hash (optional parameter). <strong>generateURL(&quot;http://www.website.com&quot;, {&quot;param1&quot;:&quot;value1&quot;, &quot;param2&quot;:&quot;value2&quot;}, &quot;bookmark&quot;)</strong> returns the URL <strong>http://www.website.com?param1=value1&param2=value2#bookmark</strong></p>"
							},
							{
								"value" : "redirectToURL",
								"code" : "redirectToURL(",
								"tip" : "<p>Redirects the user. The operation accepts two parameters: the URL and a plain object for the parameters. <strong>redirectToURL(url, object)</strong> the object is optional.</p>"
							},

						]
		}
	}
};