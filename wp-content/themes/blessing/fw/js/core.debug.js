/**
 * ANCORA Framework: Debug utilities
 *
 * @package	themerex
 * @since	themerex 1.0
 */


function ancora_debug_object(obj) {
	"use strict";
	var html = arguments[1] ? arguments[1] : false;				// Tags decorate
	var recursive = arguments[2] ? arguments[2] : false;		// Show inner objects (arrays)
	var showMethods = arguments[3] ? arguments[3] : false;		// Show object's methods
	var level = arguments[4] ? arguments[4] : 0;				// Nesting level (for internal usage only)
	var dispStr = "";
	var addStr = "";
	if (level>0) {
		dispStr += (obj===null ? "null" : typeof(obj)) + (html ? "\n<br />" : "\n");
		addStr = replicate(html ? '&nbsp;' : ' ', level*2);
	}
	if (obj!==null) {
		for (var prop in obj) {
			if (!showMethods && typeof(obj[prop])=='function')	// || prop=='innerHTML' || prop=='outerHTML' || prop=='innerText' || prop=='outerText')
				continue;
			if (recursive && (typeof(obj[prop])=='object' || typeof(obj[prop])=='array') && obj[prop]!=obj)
				dispStr += addStr + (html ? "<b>" : "")+prop+(html ? "</b>" : "")+'='+ancora_debug_object(obj[prop], html, recursive, showMethods, level+1);
			else
				dispStr += addStr + (html ? "<b>" : "")+prop+(html ? "</b>" : "")+'='+(typeof(obj[prop])=='string' ? '"' : '')+obj[prop]+(typeof(obj[prop])=='string' ? '"' : '')+(html ? "\n<br />" : "\n");
		}
	}
	return dispStr;
}

function ancora_debug_log(s) {
	"use strict";
	if (ANCORA_GLOBALS['user_logged_in']) {
		if (jQuery('#debug_log').length == 0) {
			jQuery('body').append('<div id="debug_log"><span id="debug_log_close" onclick="jQuery(\'#debug_log\').hide();">x</span><div id="debug_log_content"></div></div>'); 
		}
		jQuery('#debug_log_content').append('<br>'+s);
		jQuery('#debug_log').show();
	}
}

if (window.dcl===undefined) function dcl(s) { "use strict"; console.log(s); }
if (window.dco===undefined) function dco(s) { "use strict"; console.log(ancora_debug_object(s)); }
if (window.dal===undefined) function dal(s) { "use strict"; if (ANCORA_GLOBALS['user_logged_in']) alert(s); }
if (window.dao===undefined) function dao(s) { "use strict"; if (ANCORA_GLOBALS['user_logged_in']) alert(ancora_debug_object(s)); }
if (window.ddl===undefined) function ddl(s) { "use strict"; ancora_debug_log(s); }
if (window.ddo===undefined) function ddo(s) { "use strict"; ancora_debug_log(ancora_debug_object(s)); }
