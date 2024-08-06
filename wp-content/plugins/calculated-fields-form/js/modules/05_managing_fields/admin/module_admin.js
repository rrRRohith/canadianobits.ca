fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'processing' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#managing-fields-module',
	'toolbars'		: {
		'fields' : {
			'label' : 'Managing fields',
			'buttons' : [
							{
								"value" : "getField",
								"code" : "getField(",
								"tip" : "<p>Get the field object. <strong>getField( # or fieldname# )</strong></p><p>Returns the internal representation of a field object. For example, if there is the slider field: fieldname1, to assing it a value, for example:50, enter as part of the equation associated to the calculated field the piece of code: getField(1).setVal(50);</p><p>The getField operation can be used only in the context of the equations.</p>"
							},
							{
								"value" : "GOTOFIELD",
								"code" : "GOTOFIELD(",
								"tip" : "<p>Jumps to a field in the form. <strong>GOTOPAGE( field, form object )</strong></p><p><b>field</b>, integer number corresponding to the number component in the field name or the field name (required parameter).<br><b>form object</b>, an optional parameter corresponding to the form where the field is.<br>In the context of the equation, call the operation passing only the number component in the field name,<br>Ex. <b>GOTOFIELD (2);</b><br>But if the operation is called from the onclick event of a button, the form object is required,<br>Ex. <b>GOTOFIELD (&quot;fieldname2&quot;, this.form);</b></p>"
							},
							{
								"value" : "GOTOPAGE",
								"code" : "GOTOPAGE(",
								"tip" : "<p>Jumps to a page in a multipage form. <strong>GOTOPAGE( page, form object )</strong></p><p><b>page</b>, integer corresponding to the page index, starting at zero (required parameter).<br><b>form object</b>, optional parameter corresponding to the multipage form.<br>In the context of the equation, call the operation passing only the page index,<br>Ex. <b>GOTOPAGE (2);</b><br>But if the operation is called from the onclick event of a button, the form object is required,<br>Ex. <b>GOTOPAGE (2, this.form);</b></p>"
							},
							{
								"value" : "IGNOREFIELD",
								"code" : "IGNOREFIELD(",
								"tip" : "<p>Ignore a field explicitly, similar to dependencies. <strong>IGNOREFIELD( # or fieldname#, form or form selector )</strong></p><p>Ignores the field for the equations and submission. The first parameter is required, it would be the numeric part of the field name or the field name. The second parameter would be a form object, or a selector with the form reference. If the second parameter is not passed, the plugin will apply the ignore action to the field in the first form of the page. For example: IGNOREFIELD(1); or IGNOREFIELD(&quot;fieldname1&quot;);</p>"
							},
							{
								"value" : "ACTIVATEFIELD",
								"code" : "ACTIVATEFIELD(",
								"tip" : "<p>Activates a field explicitly, similar to dependencies. <strong>ACTIVATEFIELD( # or fieldname#, form or form selector )</strong></p><p>Activates the field for the equations and submission. The first parameter is required, it would be the numeric part of the field name or the field name. The second parameter would be a form object, or a selector with the form reference. If the second parameter is not passed, the plugin will apply the activates action to the field in the first form of the page. For example: ACTIVATEFIELD(1); or ACTIVATEFIELD(&quot;fieldname1&quot;);</p>"
							},
							{
								"value" : "HIDEFIELD",
								"code" : "HIDEFIELD(",
								"tip" : "<p>Hide a field explicitly. Unlike IGNOREFIELD, this operation hides the field but does not deactivate it. The hidden fields participate in the equations and are submitted to the server. <strong>HIDEFIELD( # or fieldname#, form or form selector )</strong></p><p>The first parameter is required. It is the numeric part of the field name or the field name. The second parameter would be a form object or a selector with the form reference. If the second parameter is not passed, the plugin will hide the field in the first form on the page. For example: HIDEFIELD(1); or HIDEFIELD(&quot;fieldname1&quot;);</p>"
							},
							{
								"value" : "SHOWFIELD",
								"code" : "SHOWFIELD(",
								"tip" : "<p>Show a field explicitly. If the field was hidden by a dependency or by the IGNOREFIELD operation, it must be displayed by the ACTIVATEFIELD operation. <strong>SHOWFIELD( # or fieldname#, form or form selector )</strong></p><p>The first parameter is required. It is the numeric part of the field name or the field name. The second parameter would be a form object or a selector with the form reference. If the second parameter is not passed, the plugin will display the field in the first form on the page. For example: SHOWFIELD(1); or SHOWFIELD(&quot;fieldname1&quot;);</p>"
							},
							{
								"value" : "DISABLEEQUATIONS",
								"code" : "DISABLEEQUATIONS(",
								"tip" : "<p>Allows to disable dynamic evaluation of equations. Accepts an optional parameter: form object, jQuery object or selector. If the parameter is omitted, disables evaluation of equations on all forms on the page. Ex: DISABLEEQUATIONS();</p>"
							},
							{
								"value" : "ENABLEEQUATIONS",
								"code" : "ENABLEEQUATIONS(",
								"tip" : "<p>Allows to enable dynamic evaluation of equations. Accepts an optional parameter: form object, jQuery object or selector. If the parameter is omitted, enables evaluation of equations on all forms on the page. Ex: ENABLEEQUATIONS();</p>"
							},
							{
								"value" : "EVALEQUATIONS",
								"code" : "EVALEQUATIONS(",
								"tip" : "<p>Evaluates the form equations. Requires as parameter the form object. Ex: EVALEQUATIONS(form);</p>"
							},
							{
								"value" : "EVALEQUATION",
								"code" : "EVALEQUATION(",
								"tip" : "<p>Evaluate a specific equation. It receives two parameters, the field name (or the numeric part of the field name) and the form object. If the form object is missing, the plugin evaluates the equation in the active form or first form on the page. Ex: EVALEQUATION(&quot;fieldname1&quot;, form); or EVALEQUATION(1, form);</p>"
							},
                            {
								"value" : "COPYFIELDVALUE",
								"code" : "COPYFIELDVALUE(",
								"tip" : "<p>Copies the field value to the clipboard. Supports input and textarea tags. <strong>COPYFIELDVALUE( # or fieldname#, form or form selector )</strong></p><p>The first parameter is required, it would be the numeric part of the field name or the field name. The second parameter would be a form object, or a selector with the form reference. If the second parameter is not passed, the plugin will copy the value of the field in the first form of the page. For example: COPYFIELDVALUE(1); or COPYFIELDVALUE(&quot;fieldname1&quot;);</p>"
							},
                            {
								"value" : "PRINTFORM",
								"code" : "PRINTFORM(",
								"tip" : "<p>Print the form only. Passing the true or 1 as the PRINTFORM parameter, it prints every page in a multipage form. Ex. PRINTFORM(); or PRINTFORM(true); for printing all pages in multipage form.</p>"
							}
						]
		}
	}
};