<?php
if (!defined('WFWAF_VERSION') || defined('WFWAF_RULES_LOADED')) {
	exit('Access denied');
}
/*
	This file is generated automatically. Any changes made will be lost.
*/

$this->failScores['sqli'] = 100;
$this->failScores['xss'] = 100;
$this->failScores['rce'] = 100;

$this->variables['sqliRegex'] = new wfWAFRuleVariable($this, 'sqliRegex', '/(?:[^\\w<]|\\/\\*\\![0-9]*|^)(?:
@@HOSTNAME|
ALTER|ANALYZE|ASENSITIVE|
BEFORE|BENCHMARK|BETWEEN|BIGINT|BINARY|BLOB|
CALL|CASE|CHANGE|CHAR|CHARACTER|CHAR_LENGTH|COLLATE|COLUMN|CONCAT|CONDITION|CONSTRAINT|CONTINUE|CONVERT|CREATE|CROSS|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|CURRENT_USER|CURSOR|
DATABASE|DATABASES|DAY_HOUR|DAY_MICROSECOND|DAY_MINUTE|DAY_SECOND|DECIMAL|DECLARE|DEFAULT|DELAYED|DELETE|DESCRIBE|DETERMINISTIC|DISTINCT|DISTINCTROW|DOUBLE|DROP|DUAL|DUMPFILE|
EACH|ELSE|ELSEIF|ELT|ENCLOSED|ESCAPED|EXISTS|EXIT|EXPLAIN|EXTRACTVALUE|
FETCH|FLOAT|FLOAT4|FLOAT8|FORCE|FOREIGN|FROM|FULLTEXT|
GRANT|GROUP|HAVING|HEX|HIGH_PRIORITY|HOUR_MICROSECOND|HOUR_MINUTE|HOUR_SECOND|
IFNULL|IGNORE|INDEX|INFILE|INNER|INOUT|INSENSITIVE|INSERT|INTERVAL|ISNULL|ITERATE|
JOIN|KILL|LEADING|LEAVE|LIMIT|LINEAR|LINES|LOAD|LOAD_FILE|LOCALTIME|LOCALTIMESTAMP|LOCK|LONG|LONGBLOB|LONGTEXT|LOOP|LOW_PRIORITY|
MASTER_SSL_VERIFY_SERVER_CERT|MATCH|MAXVALUE|MEDIUMBLOB|MEDIUMINT|MEDIUMTEXT|MID|MIDDLEINT|MINUTE_MICROSECOND|MINUTE_SECOND|MODIFIES|
NATURAL|NO_WRITE_TO_BINLOG|NULL|NUMERIC|OPTION|ORD|ORDER|OUTER|OUTFILE|
PRECISION|PRIMARY|PRIVILEGES|PROCEDURE|PROCESSLIST|PURGE|
RANGE|READ_WRITE|REGEXP|RELEASE|REPEAT|REQUIRE|RESIGNAL|RESTRICT|RETURN|REVOKE|RLIKE|ROLLBACK|
SCHEMA|SCHEMAS|SECOND_MICROSECOND|SELECT|SENSITIVE|SEPARATOR|SHOW|SIGNAL|SLEEP|SMALLINT|SPATIAL|SPECIFIC|SQLEXCEPTION|SQLSTATE|SQLWARNING|SQL_BIG_RESULT|SQL_CALC_FOUND_ROWS|SQL_SMALL_RESULT|STARTING|STRAIGHT_JOIN|SUBSTR|
TABLE|TERMINATED|TINYBLOB|TINYINT|TINYTEXT|TRAILING|TRANSACTION|TRIGGER|
UNDO|UNHEX|UNION|UNLOCK|UNSIGNED|UPDATE|UPDATEXML|USAGE|USING|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|
VALUES|VARBINARY|VARCHAR|VARCHARACTER|VARYING|WHEN|WHERE|WHILE|WRITE|YEAR_MONTH|ZEROFILL)(?=[^\\w]|$)/ix');
$this->variables['xssRegex'] = new wfWAFRuleVariable($this, 'xssRegex', '/(?:
#tags
(?:\\<|\\+ADw\\-|\\xC2\\xBC)\\/?(script|iframe|svg|object|embed|applet|link|style|meta|base|\\/\\/|\\?xml\\-stylesheet)(?:[^\\w]|\\xC2\\xBE)|
#protocols
(?:^|[^\\w])(?:(?:(?:\\s|(?:&\\#(?:x0*(?:[0-9a-f]{1,2})|0*(?:[0-9]{1,2}));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6a|4a)|0*(?:106|74));?|j)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e))(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:72|52)|0*(?:114|82));?|r)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6f|4f)|0*(?:111|79));?|o)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:64|44)|0*(?:100|68));?|d)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?!(?:&\\#(?:x0*3a|0*58);?|&colon;?|\\:)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*2f|0*47);?|\\/)(?:(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:&\\#(?:x0*(?:6e|4e)|0*(?:110|78));?|n)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)|(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)|(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)|(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)?(?:&\\#(?:x0*(?:6a|4a)|0*(?:106|74));?|j)(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)|(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)|(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*2b|0*43);?|\\+)(?:&\\#(?:x0*(?:78|58)|0*(?:120|88));?|x)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l))(?:(?:&\\#(?:x0*3b|0*59);?|;)(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:72|52)|0*(?:114|82));?|r)(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:&\\#(?:x0*3d|0*61);?|=)[\\-a-z0-9]+)?(?:(?:&\\#(?:x0*3b|0*59);?|;)(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*36|0*54);?|6)(?:&\\#(?:x0*34|0*52);?|4))?(?:&\\#(?:x0*2c|0*44);?|,)))(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*3a|0*58);?|&colon|\\:)|
#css expression
(?:^|[^\\w])(?:(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*78|\\\\0*58|x)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*70|\\\\0*50|p)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*72|\\\\0*52|r)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*73|\\\\0*53|s)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*73|\\\\0*53|s)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n))[^\\w]*?(?:\\\\0*28|\\()|
#css properties
(?:^|[^\\w])(?:(?:(?:\\\\0*62|\\\\0*42|b)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*68|\\\\0*48|h)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*61|\\\\0*41|a)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*76|\\\\0*56|v)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*72|\\\\0*52|r)(?:\\/\\*.*?\\*\\/)*)|(?:(?:\\\\0*2d|\\\\0*2d|-)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6d|\\\\0*4d|m)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*7a|\\\\0*5a|z)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*2d|\\\\0*2d|-)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*62|\\\\0*42|b)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*64|\\\\0*44|d)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*67|\\\\0*47|g)(?:\\/\\*.*?\\*\\/)*))[^\\w]*(?:\\\\0*3a|\\\\0*3a|:)[^\\w]*(?:\\\\0*75|\\\\0*55|u)(?:\\\\0*72|\\\\0*52|r)(?:\\\\0*6c|\\\\0*4c|l)|
#properties
(?:^|[^\\w])(?:on(?:abort|activate|active|addsourcebuffer|addstream|addtrack|afterprint|afterscriptexecute|afterupdate|alerting|animationcancel|animationend|animationiteration|animationstart|antennaavailablechange|appinstalled|audioend|audioprocess|audiostart|autocomplete|autocompleteerror|auxclick|beforeactivate|beforecopy|beforecut|beforedeactivate|beforeeditfocus|beforeinput|beforeinstallprompt|beforematch|beforepaste|beforeprint|beforescriptexecute|beforetoggle|beforeunload|beforeupdate|beforexrselect|begin|beginevent|blocked|blur|bounce|boundary|broadcast|busy|cached|callschanged|cancel|canplay|canplaythrough|cardstatechange|cellchange|cfstatechange|change|chargingchange|chargingtimechange|checkboxstatechange|checking|click|close|command|commandupdate|compassneedscalibration|complete|compositionend|compositionstart|compositionupdate|connect|connected|connecting|connectioninfoupdate|contactchange|contentvisibilityautostatechange|contextlost|contextmenu|contextrestored|controllerchange|controlselect|copy|cuechange|currentchannelchanged|currentsourcechanged|cut|data|dataavailable|datachange|datachannel|dataerror|datasetchanged|datasetcomplete|dblclick|deactivate|delivered|deliveryerror|deliverysuccess|devicechange|devicelight|devicemotion|deviceorientation|deviceproximity|dialing|disabled|dischargingtimechange|disconnected|disconnecting|domattrmodified|domcharacterdatamodified|domcontentloaded|dommenuitemactive|dommenuiteminactive|dommousescroll|domnodeinserted|domnodeinsertedintodocument|domnoderemoved|domnoderemovedfromdocument|domsubtreemodified|downloading|drag|dragdrop|dragend|dragenter|dragexit|dragleave|dragover|dragstart|drain|drop|durationchange|eitbroadcasted|emptied|enabled|encrypted|end|ended|endevent|enter|enterpictureinpicture|error|errorupdate|exit|failed|fetch|filterchange|finish|focus|focusin|focusout|formchange|formdata|forminput|frequencychange|fullscreenchange|fullscreenerror|gamepadconnected|gamepaddisconnected|gesturechange|gestureend|gesturestart|gotpointercapture|hashchange|headphoneschange|held|help|holding|icccardlockerror|iccinfochange|icecandidate|iceconnectionstatechange|icegatheringstatechange|identityresult|idpassertionerror|idpvalidationerror|inactive|incoming|input|install|invalid|isolationchange|keydown|keypress|keystatuschange|keyup|languagechange|layoutcomplete|leavepictureinpicture|levelchange|load|loaded|loadeddata|loadedmetadata|loadend|loading|loadingdone|loadingerror|loadstart|localized|losecapture|lostpointercapture|mark|mediacomplete|mediaerror|message|messageerror|midimessage|mousedown|mouseenter|mouseleave|mousemove|mouseout|mouseover|mouseup|mousewheel|move|moveend|movestart|mozaudioavailable|mozbrowseractivitydone|mozbrowserasyncscroll|mozbrowseraudioplaybackchange|mozbrowsercaretstatechanged|mozbrowserclose|mozbrowsercontextmenu|mozbrowserdocumentfirstpaint|mozbrowsererror|mozbrowserfindchange|mozbrowserfirstpaint|mozbrowsericonchange|mozbrowserloadend|mozbrowserloadstart|mozbrowserlocationchange|mozbrowsermanifestchange|mozbrowsermetachange|mozbrowseropensearch|mozbrowseropentab|mozbrowseropenwindow|mozbrowserresize|mozbrowserscroll|mozbrowserscrollareachanged|mozbrowserscrollviewchange|mozbrowsersecuritychange|mozbrowserselectionstatechanged|mozbrowsershowmodalprompt|mozbrowsertitlechange|mozbrowserusernameandpasswordrequired|mozbrowservisibilitychange|mozfullscreenchange|mozfullscreenerror|mozgamepadbuttondown|mozgamepadbuttonup|mozinterruptbegin|mozinterruptend|mozmousepixelscroll|mozorientation|mozpointerlockchange|mozpointerlockerror|mozscrolledareachanged|moztimechange|mscontentzoom|msgesturechange|msgesturedoubletap|msgestureend|msgesturehold|msgesturerestart|msgesturestart|msgesturetap|msgotpointercapture|msinertiastart|mslostpointercapture|msmanipulationstatechanged|msneedkey|mspointercancel|mspointerdown|mspointerenter|mspointerhover|mspointerleave|mspointermove|mspointerout|mspointerover|mspointerup|mute|negotiationneeded|nodecreate|nomatch|notificationclick|noupdate|obsolete|offline|online|open|orientationchange|outofsync|overconstrained|overflow|page|pagehide|pageshow|paste|pause|peeridentity|peerinfoupdat|play|playing|pointercancel|pointerdown|pointerenter|pointerleave|pointerlockchange|pointerlockerror|pointermove|pointerout|pointerover|pointerrawupdate|pointerup|popstate|popuphidden|popuphiding|popupshowing|popupshown|progress|propertychange|push|pushsubscriptionchange|radiostatechange|ratechange|readystatechange|received|rejectionhandled|removesourcebuffer|removestream|removetrack|repeat|repeatevent|reset|resize|resizeend|resizestart|resourcetimingbufferfull|result|resume|resuming|retrieving|reverse|rowdelete|rowenter|rowexit|rowinserted|rowsdelete|rowsinserted|scanningstatechanged|scroll|scrollend|search|securitypolicyviolation|seek|seeked|seeking|select|selectionchange|selectstart|sending|sent|sessionavailable|sessionconnect|settingchange|shippingaddresschange|shippingoptionchange|show|signalingstatechange|slotchange|smartcard|sort|soundend|soundstart|sourceclose|sourceended|sourceopen|speakerforcedchange|speechend|speechstart|stalled|start|started|statechange|statuschange|stkcommand|stksessionend|stop|storage|submit|success|suspend|svgabort|svgerror|svgload|svgresize|svgscroll|svgunload|svgzoom|synchrestored|timeerror|timeout|timer|timeupdate|toggle|tonechange|touchcancel|touchend|touchenter|touchleave|touchmove|touchstart|trackchange|transitioncancel|transitionend|transitionrun|transitionstart|underflow|unhandledrejection|unload|unmute|update|updateend|updatefound|updateready|updatestart|upgradeneeded|urlflip|userproximity|ussdreceived|valuechange|versionchange|visibilitychange|voicechange|voiceschanged|volumechange|vrdisplayactivate|vrdisplayblur|vrdisplayconnect|vrdisplayconnected|vrdisplaydeactivate|vrdisplaydisconnect|vrdisplaydisconnected|vrdisplayfocus|vrdisplaypresentchange|waiting|waitingforkey|webglcontextcreationerror|webglcontextlost|webglcontextrestored|webkitanimationend|webkitanimationiteration|webkitanimationstart|webkitfullscreenchange|webkitfullscreenerror|webkitmouseforcechanged|webkitmouseforcedown|webkitmouseforceup|webkitmouseforcewillbegin|webkittransitionend|webkitwillrevealbottom|wheel|writeend|zoom)|formaction|data\\-bind|ev:event)[^\\w]
)/ix');

$this->blacklistedParams['request.queryString[action]'][] = '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i';
$this->blacklistedParams['request.queryString[img]'][] = '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i';
$this->blacklistedParams['request.body[action]'][] = '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i';
$this->blacklistedParams['request.body[img]'][] = '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i';
$this->blacklistedParams['request.body[nsextt]'][] = '/.*/';
$this->blacklistedParams['request.fileNames[Filedata]'][] = '/\\/uploadify\\.php$/i';
$this->blacklistedParams['request.fileNames[yiw_contact]'][] = '/.*/';
$this->blacklistedParams['request.fileNames[filename]'][] = '/\\/license\\.php$/i';
$this->blacklistedParams['request.fileNames[update_file]'][] = '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php$/i';
$this->blacklistedParams['request.fileNames[Filedata]'][] = '/tiny_mce[\\/]+plugins[\\/]+tinybrowser[\\/]+upload_file\\.php$/i';
$this->blacklistedParams['request.fileNames[upload]'][] = '/elfinder[\\/]+php[\\/]+connector\\.minimal\\.php$/i';

$this->whitelistedParams['request.body[excerpt]'][] = '/.*/';
$this->whitelistedParams['request.body[comment]'][] = array (
  'url' => '/wp-comments-post\\.php$/i',
  'rules' => 
  array (
    0 => '3',
    1 => '12',
    2 => '146',
  ),
);
$this->whitelistedParams['request.body[content]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[data]'][] = array(
'url' => '/\\/wp-admin\\/admin-ajax\\.php$/i',
'rules' => array (
  0 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'notMatch', '/^(?:nopriv_)?wpgdprc_process_action$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^(?:nopriv_)?wpgdprc_process_action$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'elementor_js_log', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'elementor_js_log', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))))
);
$this->whitelistedParams['request.body[params][files]'][] = array (
  'url' => '/\\/wp\\-load\\.php$/i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.queryString[s]'][] = array (
  'url' => '/\\/wp-admin\\/(?:network\\/)?(?:plugin(?:s|-install)|edit)\\.php$/i',
  'rules' => 
  array (
    0 => '3',
    1 => '9',
    2 => '12',
    3 => '13',
  ),
);
$this->whitelistedParams['request.body[whitelistedPath]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[whitelistedParam]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[oldWhitelistedPath]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[oldWhitelistedParam]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[newWhitelistedPath]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[newWhitelistedParam]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[bannedURLs]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[scan_include_extra]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[newcontent]'][] = '/\\/wp-admin\\/(?:network\\/)?(?:(?:plugin|theme)-editor|admin-ajax)\\.php$/i';
$this->whitelistedParams['request.body[widget-text]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[widget-custom_html]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.queryString[_wp_http_referer]'][] = '/.{0,1}/';
$this->whitelistedParams['request.body[content]'][] = array (
  'url' => '#wp\\-json\\/wp\\/v2\\/posts\\/#',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[content]'][] = array (
  'url' => '#wp\\-json\\/wp\\/v2\\/pages\\/#',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[_wp_http_referer]'][] = array (
  'url' => '/.*/',
  'rules' => 
  array (
    0 => '13',
  ),
);
$this->whitelistedParams['request.queryString[plugin]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.queryString[action]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.queryString[checked]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.body[action]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.body[checked]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.body[submit]'][] = '/\\/wp-admin\\/(?:network\\/)?plugins\\.php$/i';
$this->whitelistedParams['request.body[blogname]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[blogdescription]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[siteurl]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[home]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[admin_email]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[moderation_keys]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[blacklist_keys]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[permalink_structure]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[category_base]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[tag_base]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.queryString[s]'][] = '/\\/wp-admin\\/edit-comments\\.php$/i';
$this->whitelistedParams['request.body[pwd]'][] = '/\\/wp-login\\.php$/i';
$this->whitelistedParams['request.body[redirect_to]'][] = '/\\/wp-login\\.php$/i';
$this->whitelistedParams['request.queryString[s]'][] = '/\\/wp-admin\\/network\\/(?:user|site)s\\.php$/i';
$this->whitelistedParams['request.body[blog]'][] = '/\\/wp-admin\\/network\\/site-new\\.php$/i';
$this->whitelistedParams['request.body[deletedWhitelistedPath]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[deletedWhitelistedParam]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[itsec_global][log_location]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[itsec_backup][location]'][] = '/\\/wp-admin\\/options\\.php$/i';
$this->whitelistedParams['request.body[dir]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[sql_query]'][] = '/(?:lint|import)\\.php$/i';
$this->whitelistedParams['request.body[divi_integration_body]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[divi_integration_head]'][] = '/\\/wp-admin\\/admin-ajax\\.php$/i';
$this->whitelistedParams['request.body[modules]'][] = array(
'url' => '/\\/wp-admin\\/admin-ajax\\.php$/i',
'rules' => array (
  0 => '3',
  1 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'et_fb_get_shortcode_from_fb_object', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'et_fb_ajax_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'currentUserIs', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))))
);
$this->whitelistedParams['request.body[fl_builder_data][settings][html]'][] = array(
'url' => '/.*/',
'rules' => array (
  0 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'currentUserIs', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))))
);
$this->whitelistedParams['request.body[partials]'][] = array(
'url' => '/.*/',
'rules' => array (
  0 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))))
);
$this->whitelistedParams['request.body[code]'][] = array(
'url' => '/\\/wp\\-load\\.php$/i',
'rules' => array (
  0 => '3',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'ZXhlYw', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^define\\(\\s*\'DONOTCACHEDB\',\\s*true\\s*\\);\\s*if\\s*\\(\\s*function_exists\\(\\s*\'vp_ai_ping_get\'\\s*\\)\\s*\\)\\s*return\\s*vp_ai_ping_get\\(\\);\\s*else\\s*return\\s*\\$this->ai_ping_get\\(\\);$#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'code'), array (
)))))))
);
$this->whitelistedParams['request.body[files]'][] = array (
  'url' => '/\\/vp\\-restore\\-helper\\-[a-zA-Z0-9]+\\.php$/i',
  'rules' => 
  array (
    0 => '3',
    1 => '9',
  ),
);
$this->whitelistedParams['request.body[actions]'][] = array(
'url' => '/\\/wp-admin\\/admin-ajax\\.php$/i',
'rules' => array (
  0 => '3',
  1 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'currentUserIs', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))))
);
$this->whitelistedParams['request.body[ihaf_insert_header]'][] = array (
  'url' => '#wp\\-admin/+options\\-general\\.php$#i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[ihaf_insert_body]'][] = array (
  'url' => '#wp\\-admin/+options\\-general\\.php$#i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[ihaf_insert_footer]'][] = array (
  'url' => '#wp\\-admin/+options\\-general\\.php$#i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[media-placeholder_resp_svg]'][] = array (
  'url' => '#wp\\-admin/+admin\\.php#i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.body[customized]'][] = array(
'url' => '#.*#',
'rules' => array (
  0 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))))
);
$this->whitelistedParams['request.body[live_editor_panels_data]'][] = array(
'url' => '/.*/',
'rules' => array (
  0 => '9',
),
'conditional' => new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'currentUserIs', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))))
);
$this->whitelistedParams['request.queryString[xwp-content-rel-to-we-plugin-dir]'][] = array (
  'url' => '/.*/',
  'rules' => 
  array (
    0 => '12',
  ),
);
$this->whitelistedParams['request.body[options][modules][ga_code]'][] = array (
  'url' => '#wp\\-admin/+options\\-general.php$#i',
  'rules' => 
  array (
    0 => '9',
  ),
);
$this->whitelistedParams['request.fileNames'][] = array (
  'url' => '#importbuddy\\.php$#i',
  'rules' => 
  array (
    0 => '76',
  ),
);

$this->rules[512] = wfWAFRule::create($this, 512, NULL, 'auth-bypass', '100', 'CVE-2022-40684 FortiOS FortiProxy Auth Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^/api/v2/(cmdb|monitor)/#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[513] = wfWAFRule::create($this, 513, NULL, 'rce', '100', 'CVE-2022-42889: Apache Commons Text RCE', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\$\\{(script|dns|url):#i', array(wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawbody', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[375] = wfWAFRule::create($this, 375, NULL, 'security-scanner', '100', 'Common vulnerability scanner User-Agents', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'cyberscan.io', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'UT-Dorkbot/1.0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Nuclei - Open-source project (github.com/projectdiscovery/nuclei)', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#OpenVAS#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#WhiteHat Security#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^Punkspider#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#Greenbone OS#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^WPScan#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'multipart/form-data; boundary=--Qualys', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Content-Type'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Mozilla/5.0 (compatible; Detectify)', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#virusdie-sdsnetwork#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
))))));
$this->rules[662] = wfWAFRule::create($this, 662, NULL, 'obji', '100', 'Generic Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|;|{|})(?:O|C):\\d+:"(?!stdClass")[^"]+":/', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#/wp-json/autonami/v1/wc-add-to-cart#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#/autonami/v1/wc-add-to-cart#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))));
$this->rules[465] = wfWAFRule::create($this, 465, NULL, 'rce', '100', 'VMWare vCenter 6.5-7.0 SSRF and RCE CVE-2021-21972 and CVE-2021-21973', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/ui/vropspluginui/rest/services/#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/ui/resources/.+\\.jsp#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[468] = wfWAFRule::create($this, 468, NULL, 'rce', '100', 'CVE-2016-6277', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/cgi-bin/;.+#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[470] = wfWAFRule::create($this, 470, NULL, 'rce', '100', 'log4j CVE-2021-44228', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\$\\{[\\w\\$\\{\\}:\\-]{0,50}j[\\w\\$\\{\\}:\\-]{0,50}n[\\w\\$\\{\\}:\\-]{0,50}d[\\w\\$\\{\\}:\\-]{0,50}i[\\w\\$\\{\\}:\\-]{0,50}:[\\w\\$\\{\\}:\\-]{0,50}l[\\w\\$\\{\\}:\\-]{0,50}d[\\w\\$\\{\\}:\\-]{0,50}a[\\w\\$\\{\\}:\\-]{0,50}p[\\w\\$\\{\\}:\\-]{0,50}:[\\w\\$\\{\\}:\\-]{0,50}\\/#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
))))));
$this->rules[471] = wfWAFRule::create($this, 471, NULL, 'rce', '100', 'VMWare vSphere RCE CVE-2021-21985', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/ui/h5-vsan/rest/proxy/service/&vsanProviderUtils_setVmodlHelper/#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[472] = wfWAFRule::create($this, 472, NULL, 'rce', '100', 'Sharepoint RCE CVE-2019-0604', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#_layouts/\\d+/Picker\\.aspx#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[473] = wfWAFRule::create($this, 473, NULL, 'traversal', '100', 'Grafana Directory Traversal CVE-2021-43798', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^(\\/\\w+)?/public/plugins/\\w+\\/\\.\\.\\/#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[474] = wfWAFRule::create($this, 474, NULL, 'rce', '100', 'F5 BigIP RCE CVE-2020-5902', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/tmui/login.jsp/..;/#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[490] = wfWAFRule::create($this, 490, NULL, 'rce', '100', 'CVE-2022-1388 - F5 BIG IP RCE', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-F5-Auth-Token'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-F5-Auth-Token'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^\\/mgmt\\/tm\\/#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[500] = wfWAFRule::create($this, 500, NULL, 'discovery-and-probing', '100', 'Readme.txt and debug.log scans', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/(readme\\.txt|debug\\.log)$#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[501] = wfWAFRule::create($this, 501, NULL, 'discovery-and-probing', '100', 'wp-config.php back-up probing', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp-config\\.#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[506] = wfWAFRule::create($this, 506, NULL, 'discovery-and-probing', '100', 'WordPress New Install File Probing', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp-admin\\/install\\.php#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[508] = wfWAFRule::create($this, 508, NULL, 'rce', '100', 'CVE-2021-31166 Remote Use After Free in Windows Remote Management', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#doar-e, ?ftw, ?imo, ?,#', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Accept-Encoding'), array (
))))));
$this->rules[511] = wfWAFRule::create($this, 511, NULL, 'rce', '100', 'Exchange Proxy(Not?)Shell CVE-2022–41040 and CVE-2022–41082', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/autodiscover\\/autodiscover\\.json#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#Powershell#', array(wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[554] = wfWAFRule::create($this, 554, NULL, 'privesc', '100', 'Universal Privilege Escalation Detection Rule', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^administrator|editor|shop_manager|manage_options|promote_users|unfiltered_html|install_plugins|install_themes$#i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#(?:role|cap)#i',
  ),
)),
wfWAFRuleComparisonSubject::create($this, 'request.jsonBody', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#(?:role|cap)#i',
  ),
)),
wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#.*#',
    2 => '#(?:role|cap)#i',
  ),
)),
wfWAFRuleComparisonSubject::create($this, 'request.jsonbody', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#.*#',
    2 => '#(?:role|cap)#i',
  ),
)),
wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#.*#',
    2 => '#.*#',
    3 => '#(?:role|cap)#i',
  ),
)),
wfWAFRuleComparisonSubject::create($this, 'request.jsonbody', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '#.*#',
    2 => '#.*#',
    3 => '#(?:role|cap)#i',
  ),
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[667] = wfWAFRule::create($this, 667, NULL, 'xss', '100', 'Stored Cross-Site Scripting via Block', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+posts#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/xmlrpc\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#<!--\\s+wp:(?:[a-z][a-z0-9_-]*\\/)?(?:[a-z][a-z0-9_-]*)\\s+{[^}]*(?:\\b|\\d)+(on(abort|activate|active|addsourcebuffer|addstream|addtrack|afterprint|afterscriptexecute|afterupdate|alerting|animationcancel|animationend|animationiteration|animationstart|antennaavailablechange|appinstalled|audioend|audioprocess|audiostart|autocomplete|autocompleteerror|auxclick|beforeactivate|beforecopy|beforecut|beforedeactivate|beforeeditfocus|beforeinput|beforeinstallprompt|beforematch|beforepaste|beforeprint|beforescriptexecute|beforeunload|beforeupdate|beforexrselect|begin|beginevent|blocked|blur|bounce|boundary|broadcast|busy|cached|callschanged|cancel|canplay|canplaythrough|cardstatechange|cellchange|cfstatechange|change|chargingchange|chargingtimechange|checkboxstatechange|checking|click(?!="(custom_link|img_link_large|link_image|link_no|zoom)?")|close|command|commandupdate|compassneedscalibration|complete|compositionend|compositionstart|compositionupdate|connect|connected|connecting|connectioninfoupdate|contactchange|contextlost|contextmenu|contextrestored|controllerchange|controlselect|copy|cuechange|currentchannelchanged|currentsourcechanged|cut|data|dataavailable|datachange|datachannel|dataerror|datasetchanged|datasetcomplete|dblclick|deactivate|delivered|deliveryerror|deliverysuccess|devicechange|devicelight|devicemotion|deviceorientation|deviceproximity|dialing|disabled|dischargingtimechange|disconnected|disconnecting|domattrmodified|domcharacterdatamodified|domcontentloaded|dommenuitemactive|dommenuiteminactive|dommousescroll|domnodeinserted|domnodeinsertedintodocument|domnoderemoved|domnoderemovedfromdocument|domsubtreemodified|downloading|drag|dragdrop|dragend|dragenter|dragexit|dragleave|dragover|dragstart|drain|drop|durationchange|eitbroadcasted|emptied|enabled|encrypted|end|ended|endevent|enter|enterpictureinpicture|error|errorupdate|exit|failed|fetch|filterchange|finish|focus|focusin|focusout|formchange|formdata|forminput|frequencychange|fullscreenchange|fullscreenerror|gamepadconnected|gamepaddisconnected|gesturechange|gestureend|gesturestart|gotpointercapture|hashchange|headphoneschange|held|help|holding|icccardlockerror|iccinfochange|icecandidate|iceconnectionstatechange|icegatheringstatechange|identityresult|idpassertionerror|idpvalidationerror|inactive|incoming|input|install|invalid|isolationchange|keydown|keypress|keystatuschange|keyup|languagechange|layoutcomplete|leavepictureinpicture|levelchange|load|loaded|loadeddata|loadedmetadata|loadend|loading|loadingdone|loadingerror|loadstart|localized|losecapture|lostpointercapture|mark|mediacomplete|mediaerror|message|messageerror|midimessage|mousedown|mouseenter|mouseleave|mousemove|mouseout|mouseover|mouseup|mousewheel|move|moveend|movestart|mozaudioavailable|mozbrowseractivitydone|mozbrowserasyncscroll|mozbrowseraudioplaybackchange|mozbrowsercaretstatechanged|mozbrowserclose|mozbrowsercontextmenu|mozbrowserdocumentfirstpaint|mozbrowsererror|mozbrowserfindchange|mozbrowserfirstpaint|mozbrowsericonchange|mozbrowserloadend|mozbrowserloadstart|mozbrowserlocationchange|mozbrowsermanifestchange|mozbrowsermetachange|mozbrowseropensearch|mozbrowseropentab|mozbrowseropenwindow|mozbrowserresize|mozbrowserscroll|mozbrowserscrollareachanged|mozbrowserscrollviewchange|mozbrowsersecuritychange|mozbrowserselectionstatechanged|mozbrowsershowmodalprompt|mozbrowsertitlechange|mozbrowserusernameandpasswordrequired|mozbrowservisibilitychange|mozfullscreenchange|mozfullscreenerror|mozgamepadbuttondown|mozgamepadbuttonup|mozinterruptbegin|mozinterruptend|mozmousepixelscroll|mozorientation|mozpointerlockchange|mozpointerlockerror|mozscrolledareachanged|moztimechange|mscontentzoom|msgesturechange|msgesturedoubletap|msgestureend|msgesturehold|msgesturerestart|msgesturestart|msgesturetap|msgotpointercapture|msinertiastart|mslostpointercapture|msmanipulationstatechanged|msneedkey|mspointercancel|mspointerdown|mspointerenter|mspointerhover|mspointerleave|mspointermove|mspointerout|mspointerover|mspointerup|mute|negotiationneeded|nodecreate|nomatch|notificationclick|noupdate|obsolete|offline|online|open|orientationchange|outofsync|overconstrained|overflow|page|pagehide|pageshow|paste|pause|peeridentity|peerinfoupdat|play|playing|pointercancel|pointerdown|pointerenter|pointerleave|pointerlockchange|pointerlockerror|pointermove|pointerrawupdate|pointerout|pointerover|pointerup|popstate|popuphidden|popuphiding|popupshowing|popupshown|progress|propertychange|push|pushsubscriptionchange|radiostatechange|ratechange|readystatechange|received|rejectionhandled|removesourcebuffer|removestream|removetrack|repeat|repeatevent|reset|resize|resizeend|resizestart|resourcetimingbufferfull|result|resume|resuming|retrieving|reverse|rowdelete|rowenter|rowexit|rowinserted|rowsdelete|rowsinserted|scanningstatechanged|scroll|search|securitypolicyviolation|seek|seeked|seeking|select|selectionchange|selectstart|sending|sent|sessionavailable|sessionconnect|settingchange|shippingaddresschange|shippingoptionchange|show|signalingstatechange|slotchange|smartcard|sort|soundend|soundstart|sourceclose|sourceended|sourceopen|speakerforcedchange|speechend|speechstart|stalled|start|started|statechange|statuschange|stkcommand|stksessionend|stop|storage|submit|success|suspend|svgabort|svgerror|svgload|svgresize|svgscroll|svgunload|svgzoom|synchrestored|timeerror|timeout|timer|timeupdate|toggle|tonechange|touchcancel|touchend|touchenter|touchleave|touchmove|touchstart|trackchange|transitioncancel|transitionend|transitionrun|transitionstart|underflow|unhandledrejection|unload|unmute|update|updateend|updatefound|updateready|updatestart|upgradeneeded|urlflip|userproximity|ussdreceived|valuechange|versionchange|visibilitychange|voicechange|voiceschanged|volumechange|vrdisplayactivate|vrdisplayblur|vrdisplayconnect|vrdisplayconnected|vrdisplaydeactivate|vrdisplaydisconnect|vrdisplaydisconnected|vrdisplayfocus|vrdisplaypresentchange|waiting|waitingforkey|webglcontextcreationerror|webglcontextlost|webglcontextrestored|webkitanimationend|webkitanimationiteration|webkitanimationstart|webkitfullscreenchange|webkitfullscreenerror|webkitmouseforcechanged|webkitmouseforcedown|webkitmouseforceup|webkitmouseforcewillbegin|webkittransitionend|webkitwillrevealbottom|wheel|writeend|zoom)|formaction|data\\-bind|ev:event)[^}]*[\\s+}]+\\s+\\/?-->#ix', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[709] = wfWAFRule::create($this, 709, NULL, 'xss', '100', 'Stored Cross-Site Scripting via Block Attribute (Javascript in URL)', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+posts#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/xmlrpc\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#<!--\\s+wp:(?:[a-z][a-z0-9_-]*\\/)?(?:[a-z][a-z0-9_-]*)\\s+{[^}]*(?:\\b|\\d)+javascript\\:[^}]*[\\s+}]+\\s+\\/?-->#ix', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[510] = wfWAFRule::create($this, 510, NULL, 'privesc', '100', 'WPGateway <= 3.5 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wpgateway\\/wpgateway-webservice-new\\.php#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#wpgateway-webservice\\.php#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[67] = wfWAFRule::create($this, 67, NULL, 'traversal', '100', 'Directory Traversal (Requesting wp-config.php)', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\)(\\.\\.?(\\\\|\\/)+)+wp\\-config\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[119] = wfWAFRule::create($this, 119, NULL, 'rce', '100', 'Duplicator <= 1.2.41 - Sensitive Information Disclosure leading to Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/installer(-backup)?\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', '3', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action_ajax'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[578] = wfWAFRule::create($this, 578, NULL, 'priv-esc', '100', 'WP Data Access <= 5.3.7 - Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/profile\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/user\\-edit\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'wpda_role', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[545] = wfWAFRule::create($this, 545, NULL, 'file-download', '100', 'Shortcodes Ultimate <= 5.12.6 - Authenticated (Subscriber+) Arbitrary File Read via Shortcode', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\[su_table#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonbody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#url=(\'|\\")http#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonbody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[641] = wfWAFRule::create($this, 641, NULL, 'xss', '100', 'WordPress Core 6.3 - 6.3.1 - Authenticated(Contributor+) Cross-Site Scripting via Footnotes Block', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp[\\/]+v2[\\/]+posts/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'meta', 'footnotes'), array (
))))));
$this->rules[507] = wfWAFRule::create($this, 507, NULL, 'xss', '100', 'WordPress Core < 6.0.2 - Authenticated Contributor+ Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'meta'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'metavalue'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'metakeyinput'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'metakeyselect'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[18] = wfWAFRule::create($this, 18, NULL, 'priv-esc', '100', 'User Role Editor <= 4.24 - Authenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'notEquals', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ure_other_roles'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/(network/)?(profile|user-new)\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[599] = wfWAFRule::create($this, 599, NULL, 'priv-esc', '100', 'ReviewX <= 1.6.13 - Arbitrary Usermeta Update to Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wp_capabilities', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_screen_options', 'option'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wp_user_level', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_screen_options', 'option'), array (
)))))));
$this->rules[604] = wfWAFRule::create($this, 604, NULL, 'auth-bypass', '100', 'Abandoned Cart Lite for WooCommerce <= 5.14.2 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.14.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'woocommerce-abandoned-cart'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'checkout_link', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'wcal_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'track_links', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'wcal_action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'validate'), array (
))))));
$this->rules[272] = wfWAFRule::create($this, 272, NULL, 'auth-bypass', '100', 'Advanced Access Manager <= 6.6.1 - Authenticated Authorization Bypass and Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'aam_user_roles'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[609] = wfWAFRule::create($this, 609, NULL, 'auth-bypass', '100', 'Stripe Payment Plugin for WooCommerce <= 3.7.7 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.7.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'payment-gateway-stripe-and-woocommerce-integration'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '4c53f56131093d2fe2c606e0f42cffb6', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '05f1cdc0c9c37949c2d105619a21c30e'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '34f9f5a95087301785196ee0e503f060'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '69dfcb072307d1f23d6dae1ab92fffbf'), array (
))))));
$this->rules[621] = wfWAFRule::create($this, 621, NULL, 'rce', '100', 'JetElements <= 2.6.10 - Authenticated (Contributor+) Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#meta_callback\\":\\"(?!(get_permalink|get_the_title|wp_get_attachment_url|wp_get_attachment_image|date|date_i18n|\\"))#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
))))));
$this->rules[642] = wfWAFRule::create($this, 642, NULL, 'rce', '100', 'WP EXtra <= 6.2 - Missing Authorization to .htaccess File Modification', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'wp_extra', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'save_includes', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keyExists', 'save_content', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keyExists', 'save_root', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[66] = wfWAFRule::create($this, 66, NULL, 'dos', '100', 'WordPress Core <= 4.5.3 - Denial of Service', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'update-plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\|%2f|%5c)\\.\\.(\\\\|\\/|%2f|%5c)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[502] = wfWAFRule::create($this, 502, NULL, 'file_delete', '100', 'WAF-RULE-502', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', '0d97ef17e443af0f442712be63a3714e', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '01b0357bbb461420eb0aced7e3c2fcb9'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '01b0357bbb461420eb0aced7e3c2fcb9'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^(\\w{3,5}:\\/\\/|wp-content\\/uploads\\/)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '8c7dd922ad47494fc02c388e12c00eac', '45b963397aa40d4a0063e0d85e4fe7a1'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/[\\/\\\\]/i', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '8c7dd922ad47494fc02c388e12c00eac', '45b963397aa40d4a0063e0d85e4fe7a1'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[286] = wfWAFRule::create($this, 286, NULL, 'auth-bypass', '100', 'Epsilon Framework Themes (Various Versions) - Unauthenticated Plugin Activation/Deactivation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'deactivate_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'activate_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'plugin'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[596] = wfWAFRule::create($this, 596, NULL, 'priv-esc', '100', 'WAF-RULE-596', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.1.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'userpro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'parse-media-shortcode', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[userpro#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'shortcode'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\[userpro#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'comment'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[445] = wfWAFRule::create($this, 445, NULL, 'xss', '100', 'SupportCandy <= 2.2.6 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.2.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'supportcandy'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\[supportcandy#', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\&\\?][^=]*[\\}\\(;<>]#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)))))));
$this->rules[446] = wfWAFRule::create($this, 446, NULL, 'xss', '100', 'WordPress Core < 5.8.3 - Authenticated Stored Cross Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '5.8.3', array(wfWAFRuleComparisonSubject::create($this, 'wordpress.core', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\"slug\\":\\"[^\\"]{200}#', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#[^\\w\\-]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'post_name'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '199', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'post_name'), array (
))))))));
$this->rules[292] = wfWAFRule::create($this, 292, NULL, 'priv-esc', '100', 'Ultimate Member <= 2.1.11 - Unauthenticated Privilege Escalation via User Roles', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/profile\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'um-role'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'um-role'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[550] = wfWAFRule::create($this, 550, NULL, 'insufficient-auth', '100', '10Web Booster – Website speed optimization, Cache & Page Speed optimizer <= 2.13.44 - Missing Authorization in Settings Import to Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'two_import_settings', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keyExists', 'two_export', array(wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[298] = wfWAFRule::create($this, 298, NULL, 'xss', '100', 'Orbit Fox by ThemeIsle <= 2.10.2 - Authenticated (Contributor+) Stored Cross Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'editpost', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'obfx-footer-scripts'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'obfx-footer-scripts'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'obfx-header-scripts'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'obfx-header-scripts'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[561] = wfWAFRule::create($this, 561, NULL, 'xss', '100', 'Yoast SEO <= 20.2 - Authenticated (Contributor+) Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\-admin/post.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'yoast_wpseo_title'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[563] = wfWAFRule::create($this, 563, NULL, 'sqli', '100', 'Slimstat Analytics <= 4.9.3.3 - Authenticated (Subscriber+) SQL Injection via Shortcode', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '4.9.3.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-slimstat'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[slimstat[^\\]]*\\]#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[316] = wfWAFRule::create($this, 316, NULL, 'sde', '100', 'Elementor Contact Form DB <= 1.5 - Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'download_csv'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'download_csv'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'download_csv'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'download_csv'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'form_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'form_name'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'form_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'form_id'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[330] = wfWAFRule::create($this, 330, NULL, 'auth-bypass', '100', 'WP Page Builder <= 1.2.3 - Insecure Default to Unauthorized Page Editing', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wppb_page_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wppb_editor', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIs', 'subscriber', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[590] = wfWAFRule::create($this, 590, NULL, 'privesc', '100', 'Woodmart Core <= 1.0.36 - Authentication Bypass to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.0.36', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'woodmart-core'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'opauth'), array (
))))));
$this->rules[345] = wfWAFRule::create($this, 345, NULL, 'xss', '100', 'Related Posts for WordPress <= 2.0.3 - Reflected Cross-Site Scripting', 0, 'blockXSS', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'lang'), array (
))))));
$this->rules[350] = wfWAFRule::create($this, 350, NULL, 'xss', '100', 'Mapplic Lite and Mapplic <= (Various Versions) - Server Side Request Forgery to Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mapplic-mapdata'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#\\.svg$#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'new-map'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#"map":"[^"]+\\.svg"#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mapplic-mapdata'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[440] = wfWAFRule::create($this, 440, NULL, 'rce', '100', 'PHP Everywhere <= 2.0.3 - Authenticated (Contributor+) Remote Code Execution via Metabox', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp:php-everywhere-block\\/php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#\\[php_everywhere#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'shortcode'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'php_everywhere_code'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'Just+put+[php_everywhere]+where+you+want+the+code+to+be+executed.', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'php_everywhere_code'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'Just put [php_everywhere] where you want the code to be executed.', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'php_everywhere_code'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[452] = wfWAFRule::create($this, 452, NULL, 'lfi', '100', 'Popup Builder <= 4.0.6 - Local File Inclusion to Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#[^a-zA-Z]#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sgpb_type'), array (
))))));
$this->rules[457] = wfWAFRule::create($this, 457, NULL, 'xss', '100', 'Reflected XSS via \\\'page\\\' parameter', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>%]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
))))));
$this->rules[582] = wfWAFRule::create($this, 582, NULL, 'bypass', '100', 'Front End Users <= 3.2.24 - Missing Authorization in Multiple Functions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_MassUserAction', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_DeleteAllUsers', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_DeleteUser', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_MassDeleteFields', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_AddPayment', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_EditPayment', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_DeletePayment', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_DeleteLevel', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_MassDeleteLevels', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'EWD_FEUP_ExportToExcel', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[263] = wfWAFRule::create($this, 263, NULL, 'xss', '100', 'All in One SEO Pack <= 3.6.1 - Authenticated (Contributor+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'aiosp_title'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'aiosp_title'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'aiosp_description'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'aiosp_description'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[520] = wfWAFRule::create($this, 520, NULL, 'insufficient-auth', '100', 'Betheme <= 26.6.2 - Missing Authorization Checks', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\-admin/post.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'mfn-live-builder', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'contributor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[524] = wfWAFRule::create($this, 524, NULL, 'insufficient-auth', '100', 'ContentStudio <= 1.1.8/1.2.5 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_set_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_set_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_check_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_check_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_verfiy_wp_user'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_verfiy_wp_user'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_get_blog_authors'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_get_blog_authors'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_create_new_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_create_new_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_update_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_update_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_unset_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_unset_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_change_post_status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_change_post_status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_get_metadata'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_get_metadata'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_is_installed'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_is_installed'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_create_nonce_for_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_create_nonce_for_post'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_set_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_set_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_create_nonce_for_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_create_nonce_for_post'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'token_validity'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'token_validity'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'cstu_change_post_status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'cstu_change_post_status'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[533] = wfWAFRule::create($this, 533, NULL, 'xss', '100', 'Stored Cross-Site Scripting via Shortcode', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+posts#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/xmlrpc\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[\\w+\\b[^\\]]*(?:^|[^\\w])(?:on(?:abort|activate|active|addsourcebuffer|addstream|addtrack|afterprint|afterscriptexecute|afterupdate|alerting|animationcancel|animationend|animationiteration|animationstart|antennaavailablechange|appinstalled|audioend|audioprocess|audiostart|autocomplete|autocompleteerror|auxclick|beforeactivate|beforecopy|beforecut|beforedeactivate|beforeeditfocus|beforeinput|beforeinstallprompt|beforematch|beforepaste|beforeprint|beforescriptexecute|beforeunload|beforeupdate|beforexrselect|begin|beginevent|blocked|blur|bounce|boundary|broadcast|busy|cached|callschanged|cancel|canplay|canplaythrough|cardstatechange|cellchange|cfstatechange|change|chargingchange|chargingtimechange|checkboxstatechange|checking|click(?!="(custom_link|img_link_large|link_image|link_no|zoom)?")|close|command|commandupdate|compassneedscalibration|complete|compositionend|compositionstart|compositionupdate|connect|connected|connecting|connectioninfoupdate|contactchange|contextlost|contextmenu|contextrestored|controllerchange|controlselect|copy|cuechange|currentchannelchanged|currentsourcechanged|cut|data|dataavailable|datachange|datachannel|dataerror|datasetchanged|datasetcomplete|dblclick|deactivate|delivered|deliveryerror|deliverysuccess|devicechange|devicelight|devicemotion|deviceorientation|deviceproximity|dialing|disabled|dischargingtimechange|disconnected|disconnecting|domattrmodified|domcharacterdatamodified|domcontentloaded|dommenuitemactive|dommenuiteminactive|dommousescroll|domnodeinserted|domnodeinsertedintodocument|domnoderemoved|domnoderemovedfromdocument|domsubtreemodified|downloading|drag|dragdrop|dragend|dragenter|dragexit|dragleave|dragover|dragstart|drain|drop|durationchange|eitbroadcasted|emptied|enabled|encrypted|end|ended|endevent|enter|enterpictureinpicture|error|errorupdate|exit|failed|fetch|filterchange|finish|focus|focusin|focusout|formchange|formdata|forminput|frequencychange|fullscreenchange|fullscreenerror|gamepadconnected|gamepaddisconnected|gesturechange|gestureend|gesturestart|gotpointercapture|hashchange|headphoneschange|held|help|holding|icccardlockerror|iccinfochange|icecandidate|iceconnectionstatechange|icegatheringstatechange|identityresult|idpassertionerror|idpvalidationerror|inactive|incoming|input|install|invalid|isolationchange|keydown|keypress|keystatuschange|keyup|languagechange|layoutcomplete|leavepictureinpicture|levelchange|load|loaded|loadeddata|loadedmetadata|loadend|loading|loadingdone|loadingerror|loadstart|localized|losecapture|lostpointercapture|mark|mediacomplete|mediaerror|message|messageerror|midimessage|mousedown|mouseenter|mouseleave|mousemove|mouseout|mouseover|mouseup|mousewheel|move|moveend|movestart|mozaudioavailable|mozbrowseractivitydone|mozbrowserasyncscroll|mozbrowseraudioplaybackchange|mozbrowsercaretstatechanged|mozbrowserclose|mozbrowsercontextmenu|mozbrowserdocumentfirstpaint|mozbrowsererror|mozbrowserfindchange|mozbrowserfirstpaint|mozbrowsericonchange|mozbrowserloadend|mozbrowserloadstart|mozbrowserlocationchange|mozbrowsermanifestchange|mozbrowsermetachange|mozbrowseropensearch|mozbrowseropentab|mozbrowseropenwindow|mozbrowserresize|mozbrowserscroll|mozbrowserscrollareachanged|mozbrowserscrollviewchange|mozbrowsersecuritychange|mozbrowserselectionstatechanged|mozbrowsershowmodalprompt|mozbrowsertitlechange|mozbrowserusernameandpasswordrequired|mozbrowservisibilitychange|mozfullscreenchange|mozfullscreenerror|mozgamepadbuttondown|mozgamepadbuttonup|mozinterruptbegin|mozinterruptend|mozmousepixelscroll|mozorientation|mozpointerlockchange|mozpointerlockerror|mozscrolledareachanged|moztimechange|mscontentzoom|msgesturechange|msgesturedoubletap|msgestureend|msgesturehold|msgesturerestart|msgesturestart|msgesturetap|msgotpointercapture|msinertiastart|mslostpointercapture|msmanipulationstatechanged|msneedkey|mspointercancel|mspointerdown|mspointerenter|mspointerhover|mspointerleave|mspointermove|mspointerout|mspointerover|mspointerup|mute|negotiationneeded|nodecreate|nomatch|notificationclick|noupdate|obsolete|offline|online|open|orientationchange|outofsync|overconstrained|overflow|page|pagehide|pageshow|paste|pause|peeridentity|peerinfoupdat|play|playing|pointercancel|pointerdown|pointerenter|pointerleave|pointerlockchange|pointerlockerror|pointermove|pointerrawupdate|pointerout|pointerover|pointerup|popstate|popuphidden|popuphiding|popupshowing|popupshown|progress|propertychange|push|pushsubscriptionchange|radiostatechange|ratechange|readystatechange|received|rejectionhandled|removesourcebuffer|removestream|removetrack|repeat|repeatevent|reset|resize|resizeend|resizestart|resourcetimingbufferfull|result|resume|resuming|retrieving|reverse|rowdelete|rowenter|rowexit|rowinserted|rowsdelete|rowsinserted|scanningstatechanged|scroll|search|securitypolicyviolation|seek|seeked|seeking|select|selectionchange|selectstart|sending|sent|sessionavailable|sessionconnect|settingchange|shippingaddresschange|shippingoptionchange|show|signalingstatechange|slotchange|smartcard|sort|soundend|soundstart|sourceclose|sourceended|sourceopen|speakerforcedchange|speechend|speechstart|stalled|start|started|statechange|statuschange|stkcommand|stksessionend|stop|storage|submit|success|suspend|svgabort|svgerror|svgload|svgresize|svgscroll|svgunload|svgzoom|synchrestored|timeerror|timeout|timer|timeupdate|toggle|tonechange|touchcancel|touchend|touchenter|touchleave|touchmove|touchstart|trackchange|transitioncancel|transitionend|transitionrun|transitionstart|underflow|unhandledrejection|unload|unmute|update|updateend|updatefound|updateready|updatestart|upgradeneeded|urlflip|userproximity|ussdreceived|valuechange|versionchange|visibilitychange|voicechange|voiceschanged|volumechange|vrdisplayactivate|vrdisplayblur|vrdisplayconnect|vrdisplayconnected|vrdisplaydeactivate|vrdisplaydisconnect|vrdisplaydisconnected|vrdisplayfocus|vrdisplaypresentchange|waiting|waitingforkey|webglcontextcreationerror|webglcontextlost|webglcontextrestored|webkitanimationend|webkitanimationiteration|webkitanimationstart|webkitfullscreenchange|webkitfullscreenerror|webkitmouseforcechanged|webkitmouseforcedown|webkitmouseforceup|webkitmouseforcewillbegin|webkittransitionend|webkitwillrevealbottom|wheel|writeend|zoom)|formaction|data\\-bind|ev:event)[^\\w]
#ix', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'shortcode'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[535] = wfWAFRule::create($this, 535, NULL, 'xss', '100', 'All in One SEO Pack <= 4.2.9 - Authenticated (Contributor+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'aioseo-post-settings'), array (
))))));
$this->rules[289] = wfWAFRule::create($this, 289, NULL, 'priv-esc', '100', 'TI WooCommerce Wishlist <= 1.21.11 and TI WooCommerce Wishlist Pro <= 1.21.4 - Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'tinvwl_import_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[546] = wfWAFRule::create($this, 546, NULL, 'information-disclosure', '100', 'Profile Builder – User Profile & User Registration Forms <= 3.9.0 - Sensitive Information Disclosure via Shortcode (Extended Protection)', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\[user_meta#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonbody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(user_email|user_pass|user_login|user_activation_key)#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonbody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[562] = wfWAFRule::create($this, 562, NULL, 'sqli', '100', 'Paid Memberships Pro <= 2.9.11 - Authenticated (Subscriber+) SQL Injection via Shortcodes', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.9.12', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'paid-memberships-pro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[membership[^\\]]+levels=[\'"][^\'"]*[^\\d,]#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
))))));
$this->rules[564] = wfWAFRule::create($this, 564, NULL, 'xss', '100', 'XSS in User-Agent Header', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(?:
#tags
(?:\\<|\\+ADw\\-|\\xC2\\xBC)(script|iframe|svg|object|embed|applet|link|style|meta|base|\\/\\/|\\?xml\\-stylesheet)(?:[^\\w]|\\xC2\\xBE)|
#protocols
(?:^|[^\\w])(?:(?:(?:\\s|(?:&\\#(?:x0*(?:[0-9a-f]{1,2})|0*(?:[0-9]{1,2}));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6a|4a)|0*(?:106|74));?|j)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e))(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:72|52)|0*(?:114|82));?|r)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:6f|4f)|0*(?:111|79));?|o)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)|(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:64|44)|0*(?:100|68));?|d)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?!(?:&\\#(?:x0*3a|0*58);?|&colon;?|\\:)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*2f|0*47);?|\\/)(?:(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:&\\#(?:x0*(?:6e|4e)|0*(?:110|78));?|n)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)|(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)|(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)|(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)?(?:&\\#(?:x0*(?:6a|4a)|0*(?:106|74));?|j)(?:&\\#(?:x0*(?:70|50)|0*(?:112|80));?|p)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)|(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:&\\#(?:x0*(?:69|49)|0*(?:105|73));?|i)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)(?:&\\#(?:x0*(?:66|46)|0*(?:102|70));?|f)|(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:76|56)|0*(?:118|86));?|v)(?:&\\#(?:x0*(?:67|47)|0*(?:103|71));?|g)(?:&\\#(?:x0*2b|0*43);?|\\+)(?:&\\#(?:x0*(?:78|58)|0*(?:120|88));?|x)(?:&\\#(?:x0*(?:6d|4d)|0*(?:109|77));?|m)(?:&\\#(?:x0*(?:6c|4c)|0*(?:108|76));?|l))(?:(?:&\\#(?:x0*3b|0*59);?|;)(?:&\\#(?:x0*(?:63|43)|0*(?:99|67));?|c)(?:&\\#(?:x0*(?:68|48)|0*(?:104|72));?|h)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:72|52)|0*(?:114|82));?|r)(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*(?:74|54)|0*(?:116|84));?|t)(?:&\\#(?:x0*3d|0*61);?|=)[\\-a-z0-9]+)?(?:(?:&\\#(?:x0*3b|0*59);?|;)(?:&\\#(?:x0*(?:62|42)|0*(?:98|66));?|b)(?:&\\#(?:x0*(?:61|41)|0*(?:97|65));?|a)(?:&\\#(?:x0*(?:73|53)|0*(?:115|83));?|s)(?:&\\#(?:x0*(?:65|45)|0*(?:101|69));?|e)(?:&\\#(?:x0*36|0*54);?|6)(?:&\\#(?:x0*34|0*52);?|4))?(?:&\\#(?:x0*2c|0*44);?|,)))(?:\\s|(?:&\\#(?:x0*(?:9|a|d)|0*(?:9|10|13));?|&Tab;?|&NewLine;?))*(?:&\\#(?:x0*3a|0*58);?|&colon|\\:)|
#css expression
(?:^|[^\\w])(?:(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*78|\\\\0*58|x)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*70|\\\\0*50|p)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*72|\\\\0*52|r)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*73|\\\\0*53|s)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*73|\\\\0*53|s)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n))[^\\w]*?(?:\\\\0*28|\\()|
#css properties
(?:^|[^\\w])(?:(?:(?:\\\\0*62|\\\\0*42|b)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*65|\\\\0*45|e)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*68|\\\\0*48|h)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*61|\\\\0*41|a)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*76|\\\\0*56|v)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*72|\\\\0*52|r)(?:\\/\\*.*?\\*\\/)*)|(?:(?:\\\\0*2d|\\\\0*2d|-)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6d|\\\\0*4d|m)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6f|\\\\0*4f|o)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*7a|\\\\0*5a|z)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*2d|\\\\0*2d|-)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*62|\\\\0*42|b)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*64|\\\\0*44|d)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*69|\\\\0*49|i)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*6e|\\\\0*4e|n)(?:\\/\\*.*?\\*\\/)*(?:\\\\0*67|\\\\0*47|g)(?:\\/\\*.*?\\*\\/)*))[^\\w]*(?:\\\\0*3a|\\\\0*3a|:)[^\\w]*(?:\\\\0*75|\\\\0*55|u)(?:\\\\0*72|\\\\0*52|r)(?:\\\\0*6c|\\\\0*4c|l)|
#properties
(?:^|[^\\w])(?:on(?:abort|activate|active|addsourcebuffer|addstream|addtrack|afterprint|afterscriptexecute|afterupdate|alerting|animationcancel|animationend|animationiteration|animationstart|antennaavailablechange|appinstalled|audioend|audioprocess|audiostart|autocomplete|autocompleteerror|auxclick|beforeactivate|beforecopy|beforecut|beforedeactivate|beforeeditfocus|beforeinput|beforeinstallprompt|beforematch|beforepaste|beforeprint|beforescriptexecute|beforeunload|beforeupdate|beforexrselect|begin|beginevent|blocked|blur|bounce|boundary|broadcast|busy|cached|callschanged|cancel|canplay|canplaythrough|cardstatechange|cellchange|cfstatechange|change|chargingchange|chargingtimechange|checkboxstatechange|checking|click|close|command|commandupdate|compassneedscalibration|complete|compositionend|compositionstart|compositionupdate|connect|connected|connecting|connectioninfoupdate|contactchange|contextlost|contextmenu|contextrestored|controllerchange|controlselect|copy|cuechange|currentchannelchanged|currentsourcechanged|cut|data|dataavailable|datachange|datachannel|dataerror|datasetchanged|datasetcomplete|dblclick|deactivate|delivered|deliveryerror|deliverysuccess|devicechange|devicelight|devicemotion|deviceorientation|deviceproximity|dialing|disabled|dischargingtimechange|disconnected|disconnecting|domattrmodified|domcharacterdatamodified|domcontentloaded|dommenuitemactive|dommenuiteminactive|dommousescroll|domnodeinserted|domnodeinsertedintodocument|domnoderemoved|domnoderemovedfromdocument|domsubtreemodified|downloading|drag|dragdrop|dragend|dragenter|dragexit|dragleave|dragover|dragstart|drain|drop|durationchange|eitbroadcasted|emptied|enabled|encrypted|end|ended|endevent|enter|enterpictureinpicture|error|errorupdate|exit|failed|fetch|filterchange|finish|focus|focusin|focusout|formchange|formdata|forminput|frequencychange|fullscreenchange|fullscreenerror|gamepadconnected|gamepaddisconnected|gesturechange|gestureend|gesturestart|gotpointercapture|hashchange|headphoneschange|held|help|holding|icccardlockerror|iccinfochange|icecandidate|iceconnectionstatechange|icegatheringstatechange|identityresult|idpassertionerror|idpvalidationerror|inactive|incoming|input|install|invalid|isolationchange|keydown|keypress|keystatuschange|keyup|languagechange|layoutcomplete|leavepictureinpicture|levelchange|load|loaded|loadeddata|loadedmetadata|loadend|loading|loadingdone|loadingerror|loadstart|localized|losecapture|lostpointercapture|mark|mediacomplete|mediaerror|message|messageerror|midimessage|mousedown|mouseenter|mouseleave|mousemove|mouseout|mouseover|mouseup|mousewheel|move|moveend|movestart|mozaudioavailable|mozbrowseractivitydone|mozbrowserasyncscroll|mozbrowseraudioplaybackchange|mozbrowsercaretstatechanged|mozbrowserclose|mozbrowsercontextmenu|mozbrowserdocumentfirstpaint|mozbrowsererror|mozbrowserfindchange|mozbrowserfirstpaint|mozbrowsericonchange|mozbrowserloadend|mozbrowserloadstart|mozbrowserlocationchange|mozbrowsermanifestchange|mozbrowsermetachange|mozbrowseropensearch|mozbrowseropentab|mozbrowseropenwindow|mozbrowserresize|mozbrowserscroll|mozbrowserscrollareachanged|mozbrowserscrollviewchange|mozbrowsersecuritychange|mozbrowserselectionstatechanged|mozbrowsershowmodalprompt|mozbrowsertitlechange|mozbrowserusernameandpasswordrequired|mozbrowservisibilitychange|mozfullscreenchange|mozfullscreenerror|mozgamepadbuttondown|mozgamepadbuttonup|mozinterruptbegin|mozinterruptend|mozmousepixelscroll|mozorientation|mozpointerlockchange|mozpointerlockerror|mozscrolledareachanged|moztimechange|mscontentzoom|msgesturechange|msgesturedoubletap|msgestureend|msgesturehold|msgesturerestart|msgesturestart|msgesturetap|msgotpointercapture|msinertiastart|mslostpointercapture|msmanipulationstatechanged|msneedkey|mspointercancel|mspointerdown|mspointerenter|mspointerhover|mspointerleave|mspointermove|mspointerout|mspointerover|mspointerup|mute|negotiationneeded|nodecreate|nomatch|notificationclick|noupdate|obsolete|offline|online|open|orientationchange|outofsync|overconstrained|overflow|pagehide|pageshow|paste|pause|peeridentity|peerinfoupdat|play|playing|pointercancel|pointerdown|pointerenter|pointerleave|pointerlockchange|pointerlockerror|pointermove|pointerrawupdate|pointerout|pointerover|pointerup|popstate|popuphidden|popuphiding|popupshowing|popupshown|progress|propertychange|push|pushsubscriptionchange|radiostatechange|ratechange|readystatechange|received|rejectionhandled|removesourcebuffer|removestream|removetrack|repeat|repeatevent|reset|resize|resizeend|resizestart|resourcetimingbufferfull|result|resume|resuming|retrieving|reverse|rowdelete|rowenter|rowexit|rowinserted|rowsdelete|rowsinserted|scanningstatechanged|scroll|search|securitypolicyviolation|seek|seeked|seeking|select|selectionchange|selectstart|sending|sent|sessionavailable|sessionconnect|settingchange|shippingaddresschange|shippingoptionchange|show|signalingstatechange|slotchange|smartcard|sort|soundend|soundstart|sourceclose|sourceended|sourceopen|speakerforcedchange|speechend|speechstart|stalled|start|started|statechange|statuschange|stkcommand|stksessionend|stop|storage|submit|success|suspend|svgabort|svgerror|svgload|svgresize|svgscroll|svgunload|svgzoom|synchrestored|timeerror|timeout|timer|timeupdate|toggle|tonechange|touchcancel|touchend|touchenter|touchleave|touchmove|touchstart|trackchange|transitioncancel|transitionend|transitionrun|transitionstart|underflow|unhandledrejection|unload|unmute|update|updateend|updatefound|updateready|updatestart|upgradeneeded|urlflip|userproximity|ussdreceived|valuechange|versionchange|visibilitychange|voicechange|voiceschanged|volumechange|vrdisplayactivate|vrdisplayblur|vrdisplayconnect|vrdisplayconnected|vrdisplaydeactivate|vrdisplaydisconnect|vrdisplaydisconnected|vrdisplayfocus|vrdisplaypresentchange|waiting|waitingforkey|webglcontextcreationerror|webglcontextlost|webglcontextrestored|webkitanimationend|webkitanimationiteration|webkitanimationstart|webkitfullscreenchange|webkitfullscreenerror|webkitmouseforcechanged|webkitmouseforcedown|webkitmouseforceup|webkitmouseforcewillbegin|webkittransitionend|webkitwillrevealbottom|wheel|writeend|zoom)|formaction|data\\-bind|ev:event)[^\\w]
)/ix', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
))))));
$this->rules[568] = wfWAFRule::create($this, 568, NULL, 'auth-bypass', '100', 'WooCommerce Payments <= 5.6.1 Authentication Bypass and Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Wcpay-Platform-Checkout-User'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notequals', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Wcpay-Platform-Checkout-User'), array (
))))));
$this->rules[574] = wfWAFRule::create($this, 574, NULL, 'obji', '100', 'Advanced Custom Fields <= 6.0.7 - Authenticated (Contributor+) PHP Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|;|{|})(?:O|C):\\d+:"(?!stdClass")[^"]+":/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'acf'), array (
  0 => 
  array (
    0 => 'filterkeys',
    1 => '/field.*/',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'acf_fields'), array (
  0 => 
  array (
    0 => 'filterkeys',
    1 => '/.*/',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'acf_field_group'), array (
  0 => 
  array (
    0 => 'filterkeys',
    1 => '/.*/',
  ),
))))));
$this->rules[576] = wfWAFRule::create($this, 576, NULL, 'priv-esc', '100', 'Directorist <= 7.5.4 - Authenticated (Subscriber+) Arbitrary User Password Reset to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '7.5.4', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'directorist'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'directorist_reset_password', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))));
$this->rules[603] = wfWAFRule::create($this, 603, NULL, 'auth-bypass', '100', 'WordPress Social Login and Register (Discord, Google, Twitter, LinkedIn) <= 7.6.4 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '7.6.4', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'miniorange-login-openid'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '17152c925f6cfb25418f799518c95b2c', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', 'ef3e30e070f70244fd6578d88a6b77ac'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5Body', 'ef3e30e070f70244fd6578d88a6b77ac'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '0c83f57c786a0b4a39efab23731c7ebc'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', 'b9d55a0ccdd8b5ea78d6257232d5a7b0'), array (
))))));
$this->rules[623] = wfWAFRule::create($this, 623, NULL, 'priv-esc', '100', 'Donation Forms by Charitable <= 1.7.0.12 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'update_profile', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'charitable_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'charitable_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_registration', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'charitable_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'charitable_action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'role'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'role'), array (
))))));
$this->rules[630] = wfWAFRule::create($this, 630, NULL, 'file_upload', '100', 'Form Maker by 10Web <= 1.15.19 - Unauthenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(p(h(pt?|t(ml?)?|ar)[0-9]?|l|y)|(j|a)sp|aspx|sh|shtml|html?|cgi|htaccess|user\\.ini);/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/wdform_\\d+_element\\d+/',
  ),
))))));
$this->rules[633] = wfWAFRule::create($this, 633, NULL, 'xss', '100', 'PowerPress <= 11.0.10 - Authenticated(Contributor+) Stored Cross-Site Scripting via Media URL', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'Powerpress', 'podcast', 'url'), array (
))))));
$this->rules[637] = wfWAFRule::create($this, 637, NULL, 'privesc', '100', 'Simple Membership <= 4.3.4 - Account Takeover via Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.3.4', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'simple-membership'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'swpm-password-reset-using-link', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))));
$this->rules[656] = wfWAFRule::create($this, 656, NULL, 'rce', '100', 'Astra Pro <= 4.3.1 - Authenticated(Contributor+) Remote Code Execution via Metabox', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'enabled', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ast-advanced-hook-with-php'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ast-advanced-hook-php-code'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[146] = wfWAFRule::create($this, 146, NULL, 'rce', '100', 'PHAR Deserialization Attack', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/phar:\\/\\//i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[491] = wfWAFRule::create($this, 491, NULL, 'insufficient-auth', '100', 'HC Custom WP-Admin URL <= 1.4 - Missing Authorization to Login URL Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_wpadmin_slug'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_wpadmin_slug'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[492] = wfWAFRule::create($this, 492, NULL, 'insufficient-auth', '100', 'Change wp-admin login <= 1.0.9 - Missing Authorization Checks', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rwl_redirect_field'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rwl_redirect_field'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rwl_page'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rwl_page'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[504] = wfWAFRule::create($this, 504, NULL, 'file_download', '100', 'All-in-One Video Gallery <= 2.6.0 - Arbitrary File Download & Server-Side Request Forgery', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.6.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'all-in-one-video-gallery'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'dl'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^\\d+$/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'dl'), array (
))))));
$this->rules[268] = wfWAFRule::create($this, 268, NULL, 'xss', '100', 'WPBakery Page Builder <= 6.2.0 Contributor+ Stored XSS Edit Posts', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'editpost', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/vc_raw_html|vc_raw_js|custom_onclick_code/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[689] = wfWAFRule::create($this, 689, NULL, 'xss', '100', 'WordPress Core < 6.5.2 - Authenticated (Contributor+) Stored Cross-Site Scripting via Avatar Block', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/(network/)?profile\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', '"', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'first_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'last_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'display_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'nickname'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'first_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'last_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'display_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'nickname'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[374] = wfWAFRule::create($this, 374, NULL, 'xss', '100', 'Profile and User-New XSS Logonly Rule', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/(network/)?(profile|user-new)\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[1] = wfWAFRule::create($this, 1, NULL, 'whitelist', '100', 'Whitelisted URL', 1, 'allow', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/(network/)?(post|profile|user-new|settings)\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wordfence_loadLiveTraffic', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wordfence_ticker', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rocket_rucss_warmup_resource_fetcher', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rocket_saas_warmup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIs', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'install-plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'update-plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'delete-plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'search-plugins', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'search-install-plugins', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'activate-plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'update-theme', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'delete-theme', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'install-theme', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'customize_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/index\\.php$#', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/fluent-crm/v2/#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^/wp-json/fluent-crm/v2/#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))))));
$this->rules[2] = wfWAFRule::create($this, 2, NULL, 'lfi', '100', 'Slider Revolution <= 4.1.4 - Directory Traversal', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'revslider_show_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_revslider_show_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'img'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'revslider_show_image', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_revslider_show_image', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'img'), array (
))))))));
$this->rules[60] = wfWAFRule::create($this, 60, NULL, 'file_upload', '100', 'Slider Revolution < 3.0.96 & Showbiz Pro < 1.7.1 - Missing Authorization to Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'revslider_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_revslider_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'update_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'client_action'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'revslider_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_revslider_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'update_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'client_action'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[15] = wfWAFRule::create($this, 15, NULL, 'xss', '100', 'DZS Video Gallery <= 8.60 - Reflected Cross-Site Scripting', 0, 'blockXSS', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/dzs\\-videogallery[\\/]+admin[\\/]+(?:playlist|tag)seditor[\\/]+popup\\.php/', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', '\'', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'initer'), array (
))))));
$this->rules[16] = wfWAFRule::create($this, 16, NULL, 'sqli', '100', 'Simple Ads Manager <= 2.9.4.116 - SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/simple-ads-manager[\\/]+sam-ajax-loader\\.php/', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wc'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
))))));
$this->rules[17] = wfWAFRule::create($this, 17, NULL, 'rfi', '100', 'Gwolle Guestbook <= 1.5.3 - Remote File Inclusion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/gwolle\\-gb[\\/]+frontend[\\/]+captcha[\\/]+ajaxresponse\\.php/', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/.*/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'abspath'), array (
))))));
$this->rules[29] = wfWAFRule::create($this, 29, NULL, 'xss', '100', 'MainWP Dashboard – The Private WordPress Manager for Multiple Website Maintenance Plugin <= 3.1.2 - Stored Cross-Site Scripting', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'mainwp-setup', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[33] = wfWAFRule::create($this, 33, NULL, 'sqli', '100', 'Kento Post View Counter <= 2.8 - SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', '46f5a89acb206a7f58db187e45fa2a4d', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^(?:country|city)$/ix', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '5fc75f82e79d75efb9716109034a3209'), array (
))))))));
$this->rules[36] = wfWAFRule::create($this, 36, NULL, 'file_upload', '100', 'WP Mobile Detector <= 3.5 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-mobile\\-detector[/]+resize\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-mobile\\-detector[/]+timthumb\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'src'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/\\.(?:png|gif|jpg|jpeg|jif|jfif|svg)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'src'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'src'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/\\.(?:png|gif|jpg|jpeg|jif|jfif|svg)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'src'), array (
))))))));
$this->rules[37] = wfWAFRule::create($this, 37, NULL, 'sqli', '100', 'Double Opt-In for Download <= 2.0.9 - SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'id'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^[0-9]+$/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'id'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'populate_download_edit_form', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[38] = wfWAFRule::create($this, 38, NULL, 'sde', '100', 'WP Maintenance Mode <= 2.0.6 - Authenticated Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '9082302c5211de15622f1cfab357f521', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[39] = wfWAFRule::create($this, 39, NULL, 'sde', '100', 'WP Maintenance Mode <= 2.0.6 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wpmm_reset_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[45] = wfWAFRule::create($this, 45, NULL, 'auth-bypass', '100', 'DELUCKS SEO <= 1.3.9 - Unauthorized Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'dpc_save_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'dpc_save_settings'), array (
)))))));
$this->rules[48] = wfWAFRule::create($this, 48, NULL, 'xss', '100', 'All in One SEO – Best WordPress SEO Plugin – Easily Improve SEO Rankings & Increase Traffic <= 2.3.6 - Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/Abonti|aggregator|AhrefsBot|asterias|BDCbot|BLEXBot|BuiltBotTough|Bullseye|BunnySlippers|ca\\-crawler|CCBot|Cegbfeieh|CheeseBot|CherryPicker|CopyRightCheck|cosmos|Crescent|discobot|DittoSpyder|DotBot|Download Ninja|EasouSpider|EmailCollector|EmailSiphon|EmailWolf|EroCrawler|Exabot|ExtractorPro|Fasterfox|FeedBooster|Foobot|Genieo|grub\\-client|Harvest|hloader|httplib|HTTrack|humanlinks|ieautodiscovery|InfoNaviRobot|IstellaBot|Java\\/1\\.|JennyBot|k2spider|Kenjin Spider|Keyword Density\\/0\\.9|larbin|LexiBot|libWeb|libwww|LinkextractorPro|linko|LinkScan\\/8\\.1a Unix|LinkWalker|LNSpiderguy|lwp\\-trivial|magpie|Mata Hari|MaxPointCrawler|MegaIndex|Microsoft URL Control|MIIxpc|Mippin|Missigua Locator|Mister PiX|MJ12bot|moget|MSIECrawler|NetAnts|NICErsPRO|Niki\\-Bot|NPBot|Nutch|Offline Explorer|Openfind|panscient\\.com|PHP\\/5\\.\\{|ProPowerBot\\/2\\.14|ProWebWalker|Python\\-urllib|QueryN Metasearch|RepoMonkey|RMA|SemrushBot|SeznamBot|SISTRIX|sitecheck\\.Internetseer\\.com|SiteSnagger|SnapPreviewBot|Sogou|SpankBot|spanner|spbot|Spinn3r|suzuran|Szukacz\\/1\\.4|Teleport|Telesoft|The Intraformant|TheNomad|TightTwatBot|Titan|toCrawl\\/UrlDispatcher|True_Robot|turingos|TurnitinBot|UbiCrawler|UnisterBot|URLy Warning|VCI|WBSearchBot|Web Downloader\\/6\\.9|Web Image Collector|WebAuto|WebBandit|WebCopier|WebEnhancer|WebmasterWorldForumBot|WebReaper|WebSauger|Website Quester|Webster Pro|WebStripper|WebZip|Wotbox|wsr\\-agent|WWW\\-Collector\\-E|Xenu|Zao|Zeus|ZyBORG|coccoc|Incutio|lmspider|memoryBot|SemrushBot|serf|Unknown|uptime files/i', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/semalt\\.com|kambasoft\\.com|savetubevideo\\.com|buttons\\-for\\-website\\.com|sharebutton\\.net|soundfrost\\.org|srecorder\\.com|softomix\\.com|softomix\\.net|myprintscreen\\.com|joinandplay\\.me|fbfreegifts\\.com|openmediasoft\\.com|zazagames\\.org|extener\\.org|openfrost\\.com|openfrost\\.net|googlsucks\\.com|best\\-seo\\-offer\\.com|buttons\\-for\\-your\\-website\\.com|www\\.Get\\-Free\\-Traffic\\-Now\\.com|best\\-seo\\-solution\\.com|buy\\-cheap\\-online\\.info|site3\\.free\\-share\\-buttons\\.com|webmaster\\-traffic\\.co/i', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Referer'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Referer'), array (
)))))));
$this->rules[49] = wfWAFRule::create($this, 49, NULL, 'xss', '100', 'All in One SEO Pack <= 2.3.7 - Unauthenticated Stored XSS', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/sitemap_.*?<.*?(:?_\\d+)?\\.xml(:?\\.gz)?/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[52] = wfWAFRule::create($this, 52, NULL, 'file_upload', '100', 'File Manager <= 3.0 - Unauthenticated Arbitrary File Upload/Download', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', 'dfff0a7fa1a55c8c1a4966c19f6da452'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', 'dfff0a7fa1a55c8c1a4966c19f6da452'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '266e0d3d29830abfe7d4ed98b47966f7', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[53] = wfWAFRule::create($this, 53, NULL, 'file_upload', '100', 'Levo Slideshow <= 2.3 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:lvo_admin_head|lvo_add_new_album|lvo_delete_album|reset_albums|save_lvo_settings|lvo_single_image_upload|lvo_resize_image_and_add|lvo_delete_image|lvo_get_albums_table|lvo_get_albums_images_table|lvo_get_album|lvo_get_album_images|lvo_delete_cache|lvo_reorder_image|lvo_reorder_album|lvo_bulk_delete_albums|lvo_bulk_disable_albums|lvo_bulk_enable_albums|delete_image|lvo_bulk_delete_images|lvo_bulk_disable_images|lvo_bulk_enable_images|lvo_disable_album|lvo_enable_album|lvo_disable_image|lvo_enable_image)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'task'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'task'), array (
))))));
$this->rules[55] = wfWAFRule::create($this, 55, NULL, 'auth-bypass', '100', 'Form Lightbox <= 2.1 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/form\\-lightbox/ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[57] = wfWAFRule::create($this, 57, NULL, 'priv-esc', '100', 'Ultimate Product Catalog <= 3.8.1 - Missing Authorization to Plugin Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', '8c2e1c2817e3de18e2140498bdd4f7fa', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'e12a2417ffbd0ae4010210b596a3f230', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'df33bf68ad0288e1547139e02c1e096b', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'c000b32f92bbd81b6cbbddd101073e54', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'cc61a84091dcc8b9bd6ae35cf48d71ab', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'c80c9038bbb5910385decc276e42061e', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'b81e270701125a0024db04bebdbcfc2a', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '2e563359c1b268da0041c5bf822857a1', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '4ba84dbaaafd4e7d98f55e9f093fe65a', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '1deb089a44f2962f92c678a451e61142', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '6ffa8f3e70a6279866e4b2c16fe18729', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'aa1c4fd7fb193a2cd1b0cc9150131b31', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '91e590bfc230eb3971ef1bb6b97ef974', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'd0e980fd7bc681b3c3085b1ac31024d6', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '069dde6f8ea27c8618cc8f6c6703a7c7', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '819900411c0d5c99c116bbce137ee04b', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '097d5401a3ae688b669f29351b9667de', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '81f1bbc03176c4525b8801b0058b309a', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'a8072b3a87b49ffea18548f35c6abd8c', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '364409901cb1fce968104dce4bf7e4fe', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '246c8343383408c8644f31b1f42617ce', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '66d87c0a0e2c02192c322c61d9d6990a', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '67bfe619d00425b51276ae083ae271a5', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '4aaddae320d8aaa8241ffd22693dd546', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '141f5901534f2b3092be526cac250bb6', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '2b7efaffcb87e027a011c33125585db7', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '979e32726f541a1e568557e9eb6554aa', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'c252a9eb30d304ba6079376ef5231aad', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '75b0967858cf244d4e2654e69b33d2f1', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '9cfad494bbf947c2ce316fe96eac396d', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'a4a148b325f286e07d9f24e3654e2672', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '3863850b63dc41d4e6e8cee097644d18', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '8fb62eed357b03c7be735352ab247bbe', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'a0380a8020e3a09257a6c67a1fe14627', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'b0f145120ec76e700969f63c5af3e8f4', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '52f6fc037a9e97f93309b1115882c080', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'f2a2c32747d2d49ddf682158eb9a510e', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '5caa7c3d6bba5a36798619b0ac4747bb', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'a0793408acebd97af0414d46b6705a65', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'f605a16b247f81f2eb2fdc097e1e1a19', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'ea7348459bf68bf881facb0e5d18ccd7', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'c747677e1903fdfffd4108f3347cf5ab', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '05c0ea3ee2df67b6bc2f3921c3fe2180', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'd986eb29534241e46402c30e678af902', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'Action'), array (
)))))));
$this->rules[59] = wfWAFRule::create($this, 59, NULL, 'xss', '100', 'Generic XSS Injection in IP Forwarding Headers', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Client-IP'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Client-Ip'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Forwarded-For'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Forwarded'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Cluster-Client-IP'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Forwarded-For'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Forwarded'), array (
))))));
$this->rules[64] = wfWAFRule::create($this, 64, NULL, 'rce', '100', 'TimThumb <= 2.8.13 - Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/(?:timthumb\\.php|img\\.php)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/[^A-Za-z0-9\\-\\.\\_:\\/\\?\\&\\+\\;\\=]/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'src'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'webshot'), array (
))))));
$this->rules[63] = wfWAFRule::create($this, 63, NULL, 'rfd', '100', 'TimThumb <= 1.33 - Remote File Download', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/(?:timthumb\\.php|img\\.php)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '_^[^\\?]+?\\.(?:jpg|jpeg|gif|png)(?:\\?[a-z0-9\\-\\_\\.\\~%\\!\\$&\'\\(\\)\\*\\+,;\\=\\:@\\/\\?]*)?$_iu', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'src'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'src'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthLessThan', '1', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'webshot'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'webshot'), array (
)))))));
$this->rules[65] = wfWAFRule::create($this, 65, NULL, 'file_upload', '100', 'MailPoet Newsletters <= 2.6.6 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:wysija_)+campaigns/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'themes', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'themeupload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))));
$this->rules[69] = wfWAFRule::create($this, 69, NULL, 'file_upload', '100', 'N-Media Post Front-end Form < 1.1 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?nm_postfront_save_settings$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?nm_postfront_(?:load_post_form|save_post|upload_file)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/plupload[^/]*/+examples/+upload\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))))));
$this->rules[70] = wfWAFRule::create($this, 70, NULL, 'file_upload', '100', 'CYSTEME Finder <= 1.3 - Arbitrary File Upload/Read', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/cysteme\\-finder[^/]*/+php/+connector\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[78] = wfWAFRule::create($this, 78, NULL, 'file_upload', '100', 'BePro Listings <= 2.2.0020 - Unauthenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'notMatch', '/\\.(jpe?g|png|mpeg|mov|flv|pdf|docx?|txt|csv|avi|mp3|wma|wav)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'save_bepro_listing'), array (
))))));
$this->rules[81] = wfWAFRule::create($this, 81, NULL, 'xss', '100', 'FancyBox for WordPress <= 3.0.2 - Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'fancybox-for-wordpress', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mfbfw'), array (
))))));
$this->rules[83] = wfWAFRule::create($this, 83, NULL, 'file_download', '100', 'Delete All Comments <= 2.0 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/delete\\-all\\-comments/delete\\-all\\-comments\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'restorefromfileNAME'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'restorefromfileURL'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[88] = wfWAFRule::create($this, 88, NULL, 'file_upload', '100', 'Showbiz Pro Responsive Teaser WordPress Plugin <= 1.7.1 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'showbiz_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'update_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'client_action'), array (
))))));
$this->rules[89] = wfWAFRule::create($this, 89, NULL, 'file_upload', '100', 'Tevolution < 2.3.0 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#monetize[\\/]+templatic\\-custom_fields[\\/]+single\\-upload\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[91] = wfWAFRule::create($this, 91, NULL, 'auth-bypass', '100', 'Newspaper - News & WooCommerce WordPress Theme <= 6.7 - Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?td_ajax_update_panel$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[94] = wfWAFRule::create($this, 94, NULL, 'file_upload', '100', 'jQuery HTML5 File Upload <= 3.0 - Multiple Vulnerabilities', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/Save\\sSetting/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'savesetting'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(p(h(p|tml)[0-9]?|l|y)|(j|a)sp|aspx|sh|shtml|html?|cgi|htaccess|ini|exe)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'accepted_file_types'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/(p(h(p|tml)[0-9]?|l|y)|(j|a)sp|aspx|sh|shtml|html?|cgi|htaccess|ini|exe)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'inline_file_types'), array (
)))))));
$this->rules[99] = wfWAFRule::create($this, 99, NULL, 'privesc', '100', 'WP Support Plus Responsive Ticket System <= 7.1.4 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'email'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'loginGuestFacebook', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))));
$this->rules[105] = wfWAFRule::create($this, 105, NULL, 'sqli', '100', 'Ultimate Form Builder Lite <= 1.3.6 - SQL Injection to PHP Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', 'da6c71b8bb99069bd8e2fde83d95cf0d', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '144e471fa0e0005b146b3f10ed5f8192', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(?:^|&)(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:d|%64)(?:a|%61)(?:t|%74)(?:a|%61)(?:\\[|%5b)(.+?)(?:\\]|%5d)(?:\\[|%5b)(?:n|%6e)(?:a|%61)(?:m|%6d)(?:e|%65)(?:\\]|%5d)=(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:i|%69)(?:d|%64)&.*?(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:d|%64)(?:a|%61)(?:t|%74)(?:a|%61)(?:\\[|%5b)\\1(?:\\]|%5d)(?:\\[|%5b)(?:v|%76)(?:a|%61)(?:l|%6c)(?:u|%75)(?:e|%65)(?:\\]|%5d)=\\d*[^\\d&]+/i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/(?:^|&)(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:d|%64)(?:a|%61)(?:t|%74)(?:a|%61)(?:\\[|%5b)(.+?)(?:\\]|%5d)(?:\\[|%5b)(?:v|%76)(?:a|%61)(?:l|%6c)(?:u|%75)(?:e|%65)(?:\\]|%5d)=\\d*[^\\d&]+[^&]*&.*?(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:d|%64)(?:a|%61)(?:t|%74)(?:a|%61)(?:\\[|%5b)\\1(?:\\]|%5d)(?:\\[|%5b)(?:n|%6e)(?:a|%61)(?:m|%6d)(?:e|%65)(?:\\]|%5d)=(?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f)(?:i|%69)(?:d|%64)(?:$|&)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))))));
$this->rules[106] = wfWAFRule::create($this, 106, NULL, 'auth-bypass', '100', 'UserPro - User Profiles with Social Login <= 4.9.17 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'true', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'up_auto_log'), array (
))))));
$this->rules[107] = wfWAFRule::create($this, 107, NULL, 'auth-bypass', '100', 'Formidable Forms < 2.05.03 - Multiple Vulnerabilities', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'before_html'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'before_html'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'after_html'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'after_html'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?frm_forms_preview$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[121] = wfWAFRule::create($this, 121, NULL, 'auth-bypass', '100', 'AMP for WP <= 0.9.97.19 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin\\/admin\\-ajax\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^ampforwp_(save_installer|get_licence_activate_update|deactivate_license|enable_modules_upgread)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^(amppb_(color_picker|textEditor|export_layout_data|save_layout_data)|ampforwp_get_image)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'contributor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))))));
$this->rules[137] = wfWAFRule::create($this, 137, NULL, 'auth-bypass', '100', 'Yuzo Related Posts <= 5.12.93 - Missing Authorization to Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^yuzo_related_post/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'name_options'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'save_options'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'save_options'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'reset_options'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'reset_options'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[138] = wfWAFRule::create($this, 138, NULL, 'privesc', '100', 'Visual CSS Style Editor <= 7.2.0 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'yp_remote_get'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'yp_remote_get'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[139] = wfWAFRule::create($this, 139, NULL, 'auth-bypass', '100', 'ARI-Adminer <= 1.1.14 - Missing Authorization and No Direct File Access Restrictions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/(a|%61|%41)(r|%72|%52)(i|%69|%49)(\\-|%2d)(a|%61|%41)(d|%64|%44)(m|%6d|%4D)(i|%69|%49)(n|%6e|%4E)(e|%65|%45)(r|%72|%52)/#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[140] = wfWAFRule::create($this, 140, NULL, 'rce', '100', 'WP Database Backup <= 5.1.2 - Unauthenticated Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wpsetting'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_email_attachment'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_email_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_destination_Email'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wpsetting'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_email_attachment'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_email_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_db_backup_destination_Email'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[142] = wfWAFRule::create($this, 142, NULL, 'auth-bypass', '100', 'WooCommerce User Email Verification <= 3.3.0 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wuev_form_type'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[144] = wfWAFRule::create($this, 144, NULL, 'auth-bypass', '100', 'WooCommerce Checkout Manager <= 4.2.6 - Unauthenticated Arbitrary Media Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'update_attachment_wccm', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wooccm_front_enduploadsave', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'remove'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'remove'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[145] = wfWAFRule::create($this, 145, NULL, 'xss', '100', 'Blog Designer <= 1.8.10 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_css'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_css'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'blog_page_display'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'identical', 'save', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'identical', 'true', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'updated'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'updated'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[147] = wfWAFRule::create($this, 147, NULL, 'xss', '100', 'WP Live Chat Support <= 8.0.27 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_save_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_save_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_custom_css'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_custom_css'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_custom_js'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wplc_custom_js'), array (
)))))));
$this->rules[148] = wfWAFRule::create($this, 148, NULL, 'auth-bypass', '100', 'WPGraphQL <= 0.2.3 - Multiple Vulnerable Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/application\\/json/', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Content-Type'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/graphql/', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^\\s*\\{\\s*"query"/', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\{\\s*(plugins|themes|mediaItems|users|comments|posts|pages)/', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/mutation\\s*\\{\\s*registerUser.*?roles:/s', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[149] = wfWAFRule::create($this, 149, NULL, 'privesc', '100', 'Convert Plus <= 3.4.2 - Unauthenticated Administrator Creation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'cp_add_subscriber', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(administrator|editor|shop_manager|author)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'cp_set_user'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[153] = wfWAFRule::create($this, 153, NULL, 'rce', '100', 'Ad Inserter <= 2.4.21 - Authenticated Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'ai_ajax_backend', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'preview'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'code'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[154] = wfWAFRule::create($this, 154, NULL, 'privesc', '100', 'Hybrid Composer <= 1.4.6 - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'hc_ajax_save_option', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[151] = wfWAFRule::create($this, 151, NULL, 'privesc', '100', 'File Manager <= 4.8 - Missing Authorization on AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^mk_file_manager_(backup_remove|single_backup_remove|single_backup_logs|single_backup_restore)$#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[152] = wfWAFRule::create($this, 152, NULL, 'backdoor', '100', 'WAF-RULE-152', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^[0-9a-f]{32}$/', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '5f4dcc3b5aa765d61d8327deb882cf99'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '5f4dcc3b5aa765d61d8327deb882cf99'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', '808ad1ac54d3a5e6ab09ed69c2a6605d', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '84a1c9137ae2863590475c6c385b92d7', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '0ebbe8a2b6999ec31f44118f5396e3f3', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '770209dbd19d2cd3da20a08cb138036e', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'd480834a6c46e6e0778d0c863a010667', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '9a2f516318cdf6712d01150110b590b8', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))))));
$this->rules[155] = wfWAFRule::create($this, 155, NULL, 'auth-bypass', '100', 'ND Shortcodes <= 5.9.1 & ND Booking <= 2.4 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^(?:nopriv_)?nd_[^_]+_import_settings_php_function#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[156] = wfWAFRule::create($this, 156, NULL, 'file_upload', '100', 'Woody Ad Snippets <= 2.2.4 - Missing Authorization to Settings Import', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.files', 'wbcr_inp_import_files'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[158] = wfWAFRule::create($this, 158, NULL, 'xss', '100', 'WP Mega Menu <= 1.3.6 - Unauthenticated Settings Update to Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wpmm_theme_type'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'export_wpmm_theme', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[159] = wfWAFRule::create($this, 159, NULL, 'file_upload', '100', 'Simple 301 Redirects Addon Bulk Uploader <= 1.2.4 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit_bulk_301'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit_bulk_301'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'bulk301clearlist', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'bulk301export', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[161] = wfWAFRule::create($this, 161, NULL, 'auth-bypass', '100', 'WP Private Content Plus <= 1.31 - Unauthenticated Settings Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wppcp_tab'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[3] = wfWAFRule::create($this, 3, NULL, 'sqli', '40', 'SQL Injection', 1, 'failSQLi', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[9] = wfWAFRule::create($this, 9, NULL, 'xss', '100', 'XSS: Cross Site Scripting', 1, 'failXSS', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[11] = wfWAFRule::create($this, 11, NULL, 'file_upload', '100', 'Malicious File Upload', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\.(p(h(pt?|t(ml?)?|ar)[0-9]?|l|y)|(j|a)sp|aspx|sh|shtml|html?|cgi|htaccess|user\\.ini)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[68] = wfWAFRule::create($this, 68, NULL, 'file_upload', '100', 'Malicious File Upload (Patterns)', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'filePatternsMatch', '', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
))))));
$this->rules[12] = wfWAFRule::create($this, 12, NULL, 'traversal', '100', 'Directory Traversal', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\)\\.\\.(\\\\|\\/)/', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[76] = wfWAFRule::create($this, 76, NULL, 'file_upload', '100', 'Malicious File Upload (PHP)', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'fileHasPHP', '', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
))))));
$this->rules[13] = wfWAFRule::create($this, 13, NULL, 'lfi', '100', 'LFI: Local File Inclusion', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^\\/(?:\\.\\/)*(?:var|usr|mnt|etc|tmp|dev|proc)\\//i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[14] = wfWAFRule::create($this, 14, NULL, 'xxe', '100', 'XXE: External Entity Expansion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/<\\!(?:DOCTYPE|ENTITY)\\s+(?:%\\s*)?\\w+\\s+SYSTEM/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[120] = wfWAFRule::create($this, 120, NULL, 'privesc', '100', 'WP GDPR Compliance <= 1.4.2 - Arbitrary Options Update and Action Calling', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?wpgdprc_process_action$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^\\{[\'"]type[\'"]:[\'"]access_request[\'"],\\s?[\'"]email[\'"]:[\'"][^\'"]+[\'"],\\s?[\'"]consent[\'"]:(true|false)\\}$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'data'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[122] = wfWAFRule::create($this, 122, NULL, 'privesc', '100', 'Kiwi Social Share <= 2.0.10 - Unauthenticated Update Any Option', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?kiwi_social_share_set_option$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[123] = wfWAFRule::create($this, 123, NULL, 'sde', '100', 'Kiwi Social Share <= 2.0.10 - Unauthenticated Read Any Option', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?kiwi_social_share_get_option$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))));
$this->rules[125] = wfWAFRule::create($this, 125, NULL, 'auth-bypass', '100', 'Orbit Fox by ThemeIsle <= 2.6.3 - Improper REST Capabilities Checks', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+templates-directory[\\/]+import_elementor/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/templates-directory[\\/]+import_elementor/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[129] = wfWAFRule::create($this, 129, NULL, 'privesc', '100', 'Total Donations <= 2.0.5 - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/the-ajax-caller\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(nopriv_)?miglaA?_/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?miglaA?_(?:add_(?:amount|options|offline_backend)|change_donation|constantcontact_test|delete_(?:postmeta|mform)|export_report|form_bgcolor|get(?:OffDonation|me(?:_array)?|_(?:option|postmeta))|mailchimp_(?:getlists|test)|new_(?:mform|mCampaignCreator)|purgeCache|remove_(?:donation|options)|report|reset_(?:c?form|theme)|retrieve_cc_lists|save_(?:option|campaign(?:_creator)?)|stripe_(?:add(?:Basic)?|get|delete)Plan|syncPlan|test_(?:email|hEmail|offline_email|constant_contact)|update(?:Undesignated|_(?:me|barinfo|c?form|me(?:tadata)?|arr|us|recurring_plans|report|postmeta)))$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[130] = wfWAFRule::create($this, 130, NULL, 'bypass', '100', 'UserPro <= 4.9.20 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^userpro_process_form$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(?:^|&)((?:f|%66)(?:o|%6f)(?:r|%72)(?:m|%6d)(?:_|%5f))?(?:r|%72)(?:o|%6f)(?:l|%6c)(?:e|%65)(?:(?:-|%2d).+)?=(?:(?:a|%61)(?:d|%64)(?:m|%6d)(?:i|%69)(?:n|%6e)(?:i|%69)(?:s|%73)(?:t|%74)(?:r|%72)(?:a|%61)(?:t|%74)(?:o|%6f)(?:r|%72)|(?:e|%65)(?:d|%64)(?:i|%69)(?:t|%74)(?:o|%6f)(?:r|%72)|(?:s|%73)(?:h|%68)(?:o|%6f)(?:p|%70)(?:_|%5f)(?:m|%6d)(?:a|%61)(?:n|%6e)(?:a|%61)(?:g|%67)(?:e|%65)(?:r|%72))/i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[132] = wfWAFRule::create($this, 132, NULL, 'privesc', '100', 'Freemius SDK <= 2.2.3 - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^fs_set_db_option$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[134] = wfWAFRule::create($this, 134, NULL, 'auth-bypass', '100', 'SiteGround Optimizer <= 5.0.12 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+siteground-optimizer[\\/]+v1/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/siteground-optimizer[\\/]+v1/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[135] = wfWAFRule::create($this, 135, NULL, 'privesc', '100', 'Easy WP SMTP <= 1.3.9 - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'swpsmtp_import_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^swpsmtp_(clear_log|self_destruct)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[136] = wfWAFRule::create($this, 136, NULL, 'xss', '100', 'Social Warfare <= 3.5.2 - Unauthenticated Arbitrary Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'swp_url'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[162] = wfWAFRule::create($this, 162, NULL, 'xss', '100', 'Bold Page Builder <= 2.3.1 - Missing Authorization to Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/^(?:nopriv_)?bt_bb_save_custom_css$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))));
$this->rules[163] = wfWAFRule::create($this, 163, NULL, 'auth-bypass', '100', 'GiveWP <= 2.5.4 - Authorization Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'give-api'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'forms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'give-api'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^[0-9a-fA-F]{32}$/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'key'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[164] = wfWAFRule::create($this, 164, NULL, 'auth-bypass', '100', 'Advanced Access Manager <= 5.9.8.1 - Unauthenticated Arbitrary File Read', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'aam-media'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/wp\\-config\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'aam-media'), array (
))))));
$this->rules[165] = wfWAFRule::create($this, 165, NULL, 'auth-bypass', '100', 'LMS by LifterLMS <= 3.35.0 - Stored Cross-Site Scripting via Import', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.files', 'llms_import'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[166] = wfWAFRule::create($this, 166, NULL, 'redirect', '100', 'Qode Instagram Widget <= 2.0.1 - Unauthenticated Open Redirect', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/qode-instagram-widget\\/lib\\/instagram-redirect\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[167] = wfWAFRule::create($this, 167, NULL, 'auth-bypass', '100', 'Motors Car Dealer & Classified Ads <= 1.4.0 - Unauthenticated Settings Import/Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.files', 'import_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'export_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'export_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/^stm_ajax_(file_)?automanager/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/stm_listings_.+option/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'stm_xml_do_import_automanager'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'stm_xml_do_import_automanager'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[168] = wfWAFRule::create($this, 168, NULL, 'auth-bypass', '100', 'WooCommerce AJAX Product Filters <= 1.3.6 - Arbitrary Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'br-aapf-setup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[170] = wfWAFRule::create($this, 170, NULL, 'auth-bypass', '100', 'Rich Reviews <= 1.7.4 - Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'rr-update-options', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'update'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rr-update-support', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'update'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rr-update-support-prompt', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'update'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[172] = wfWAFRule::create($this, 172, NULL, 'xss', '100', 'Simple Fields <= 1.4.11 - Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'simple_fields_do_import', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[176] = wfWAFRule::create($this, 176, NULL, 'xss', '100', 'ShopWP <= 2.0.4 - Missing Authorization to Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-json/wpshopify/v1/settings#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[177] = wfWAFRule::create($this, 177, NULL, 'file-download', '100', 'Email Subscribers & Newsletters <= 4.2.2 - Unauthenticated File Download w/ Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'status'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'report'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'report'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[179] = wfWAFRule::create($this, 179, NULL, 'bypass', '100', 'Email Subscribers & Newsletters <= 4.2.2 - Missing Authorization to Test Email', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'es_send_test_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[182] = wfWAFRule::create($this, 182, NULL, 'auth-bypass', '100', 'Fast Velocity Minify <= 2.7.6 - Full Path Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'fastvelocity_min_files', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[184] = wfWAFRule::create($this, 184, NULL, 'redirect', '100', 'Bridge Theme <= 18.2, Qode Instagram Widget <=2.0.1, Qode Twitter Feed <= 2.0.0 - Open Redirect', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/qode-twitter-feed\\/lib\\/twitter-redirect\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[185] = wfWAFRule::create($this, 185, NULL, 'auth-bypass', '100', 'GiveWP <= 2.5.9 - Missing Authorization to Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'stripe_publishable_key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'stripe_publishable_key'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[186] = wfWAFRule::create($this, 186, NULL, 'priv-esc', '100', 'Mesmerize <= 1.6.89 & Materialis <= 1.0.172 - Authenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'companion_disable_popup_wpnonce'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[187] = wfWAFRule::create($this, 187, NULL, 'xss', '100', 'Sassy Social Share <= 3.3.3 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'heateor_sss_sharing_count', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'contains', '%3C', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'contains', '<', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'contains', '%3c', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', 'urls', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[189] = wfWAFRule::create($this, 189, NULL, 'bypass', '100', '301 Redirects - Easy Redirect Manager <= 2.40 - Missing Authorization', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'eps_redirect_get_new_entry', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'eps_redirect_delete_entry', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'eps_redirect_get_inline_edit_entry', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'eps_redirect_save', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[190] = wfWAFRule::create($this, 190, NULL, 'auth-bypass', '100', 'Minimal Coming Soon & Maintenance Mode <= 2.10 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'csmm_change_status', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'enabled', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'new_status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'new_status'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'disabled', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'new_status'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'new_status'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[191] = wfWAFRule::create($this, 191, NULL, 'bypass', '100', 'Minimal Coming Soon & Maintenance Mode <= 2.16 - Missing Authorization to Export Settings/Theme Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'csmm_export_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'csmm_activate_theme', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[192] = wfWAFRule::create($this, 192, NULL, 'priv-esc', '100', 'WordPress Database Reset <= 3.1 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'db-reset-code'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'db-reset-code'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'db-reset-code-confirm'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'db-reset-code-confirm'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'db-reset-code'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'db-reset-code'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'db-reset-code-confirm'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'db-reset-code-confirm'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[194] = wfWAFRule::create($this, 194, NULL, 'xss', '100', 'Pricing Table by Supsystic <= 1.8.1 - Missing Authorization on AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'importJSONTable', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'getJSONExportTable', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'createFromTpl', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[196] = wfWAFRule::create($this, 196, NULL, 'auth-bypass', '100', 'Data Tables Generator by Supsystic <= 1.9.91 - Missing Authorization on AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'supsystic-tables', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[199] = wfWAFRule::create($this, 199, NULL, 'xss', '100', 'Elementor Website Builder <= 2.8.4 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'elementor-system-info', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(?:%22|")/', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[200] = wfWAFRule::create($this, 200, NULL, 'auth-bypass', '100', 'Manage WP Worker <= 4.9.2 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'auto_login'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'auto_login'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'mwp_goto'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'service_sign'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'service_key'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'username'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'message_id'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^[0-9a-f]+_\\d+$/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'message_id'), array (
))))));
$this->rules[201] = wfWAFRule::create($this, 201, NULL, 'auth-bypass', '100', 'GDPR Cookie Consent & Compliance Notice <= 1.8.2 - Authenticated Stored Cross-Site Scripting and Authorization Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'cli_policy_generator', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[204] = wfWAFRule::create($this, 204, NULL, 'auth-bypass', '100', 'Profile Builder <= 3.1.0 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_field_user_role'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/administrator/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'custom_field_user_role'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[205] = wfWAFRule::create($this, 205, NULL, 'auth-bypass', '100', 'wpCentral <= 1.4.7 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'my_wpc_fetch_authkey', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[206] = wfWAFRule::create($this, 206, NULL, 'privesc', '100', 'wpCentral <= 1.5.0 - Improper Access Control to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^my_wpc_#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'auth_key'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'auth_key'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', '192.200.108.100', array(wfWAFRuleComparisonSubject::create($this, 'request.ip', array (
))))));
$this->rules[207] = wfWAFRule::create($this, 207, NULL, 'auth-bypass', '100', 'ThemeGrill Demo Importer 1.3.4 - 1.6.1 - Authorization Bypass to Site Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'do_reset_wordpress'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'do_reset_wordpress'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[209] = wfWAFRule::create($this, 209, NULL, 'rce', '100', 'ThemeREX Addons (Various Versions) - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+trx_addons[\\/]+V2[\\/]+get[\\/]+sc_layout/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/trx_addons[\\/]+V2[\\/]+get[\\/]+sc_layout/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[210] = wfWAFRule::create($this, 210, NULL, 'privesc', '100', 'Registration Magic <= 4.6.0.3 - Multiple Vulnerabilities', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'send_email_user_view', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rm_admin_upload_template', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'import_first', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'set_default_form', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rm_save_form_view_sett', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rm_form_export', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rm_slug'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rm_slug'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'rm_user_edit', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rm_slug'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rm_slug'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[211] = wfWAFRule::create($this, 211, NULL, 'auth-bypass', '100', 'WooCommerce Smart Coupons <= 4.6.0 - Unauthenticated Coupon Creation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'smart_coupon_amount'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '15', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '20', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[212] = wfWAFRule::create($this, 212, NULL, 'auth-bypass', '100', 'Indeed Membership Pro 7.3 - 8.6 - Missing Authorization Checks and Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'ihc_ajax_admin_popup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_get_font_awesome_popup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_delete_user_via_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_ajax_admin_popup_the_forms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_ajax_template_popup_preview', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_login_form_preview', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_locker_preview_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_register_preview_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_approve_new_user', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_approve_user_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_reorder_levels', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_preview_select_level', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_update_aweber', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_get_cc_list', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_return_csv_link', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_delete_coupon_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_notification_templates_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_delete_currency_code_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_preview_user_listing', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_delete_user_level_relationship', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_make_user_affiliate', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_check_mail_server', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_do_generate_individual_pages', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_preview_invoice_via_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_run_custom_process', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_do_delete_woo_ihc_relation', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_make_export_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_send_email_popup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_do_send_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_do_send_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_generate_direct_link', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_generate_direct_link_by_uid', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_direct_login_delete_item', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_save_reason_for_cancel_delete_level', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_close_admin_notice', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_update_list_notification_constants', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_delete_level', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_delete_order', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_delete_locker', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_delete_register_field', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ihc_admin_delete_payment_transaction', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[213] = wfWAFRule::create($this, 213, NULL, 'bypass', '100', 'Flexible Checkout Fields for WooCommerce <= 2.3.1 - Unauthenticated Arbitrary Plugin Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'inspire_checkout_fields_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'option_page'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'inspire_checkout_fields_checkboxes', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'option_page'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[215] = wfWAFRule::create($this, 215, NULL, 'auth-bypass', '100', 'Modern Events Calendar Lite <= 5.1.6 - Missing Authorization to Stored Cross-Site Scripting and Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'mec_save_notifications', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_import_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'import_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[216] = wfWAFRule::create($this, 216, NULL, 'auth-bypass', '100', 'Async JavaScript <= 2.19.07.14 - Authenticated (Subscriber+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'aj_steps', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[217] = wfWAFRule::create($this, 217, NULL, 'auth-bypass', '100', '10WebMapBuilder <= 1.0.63 - Unauthenticated Stored Cross-Site Scripting via Plugin Settings Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/wp\\-admin\\/#', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'step'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'step'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_api_key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_language'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'choose_marker_icon'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'marker_default_icon'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_address'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_lat'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_lng'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'zoom_level'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'whell_scrolling'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_draggable'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'gdpr'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'gdpr_text'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_api_key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_language'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'choose_marker_icon'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'marker_default_icon'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_address'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_lat'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'center_lng'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'zoom_level'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'whell_scrolling'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'map_draggable'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'gdpr'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'gdpr_text'), array (
)))))));
$this->rules[220] = wfWAFRule::create($this, 220, NULL, 'auth-bypass', '100', 'IMPress for IDX Broker <= 2.6.1 - Multiple Vulnerabilities', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'create_dynamic_page', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'delete_dynamic_page', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^idx_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'idx_get_saves', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'idx_check_login', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[222] = wfWAFRule::create($this, 222, NULL, 'auth-bypass', '100', 'Responsive Ready Sites Importer <= 2.2.6 -  Unprotected AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-xml', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-wpforms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-customizer-settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-widgets', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-options', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-reset-customizer-data', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-reset-site-options', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-reset-widgets-data', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-delete-posts', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-delete-wp-forms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-delete-terms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-wxr-import', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-activate-theme', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-required-plugin-activate', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'responsive-ready-sites-import-end', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'set-user-consent', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[223] = wfWAFRule::create($this, 223, NULL, 'bypass', '100', 'Product Import Export for WooCommerce <= 1.7.3 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'woocommerce_csv_import_request', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'edit_others_posts', array())));
$this->rules[224] = wfWAFRule::create($this, 224, NULL, 'xss', '100', 'WordPress Landing Page – Squeeze Page – Responsive Landing Page Builder Free – WP Lead Plus X <= 0.98 - Authenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-(?:ajax|post)\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^c(?:ore)?37_lp_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^wplx_campaign#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'c37_wpl_import_template', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_c37_wpl_import_template', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[225] = wfWAFRule::create($this, 225, NULL, 'xss', '100', 'Popup Builder <= 3.63 - Authenticated Settings Modification, Configuration Disclosure, and User Data Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sgpb_autosave', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_sgpb_autosave', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sgpb_system_info', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sgpbSaveSettings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'csv_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))));
$this->rules[226] = wfWAFRule::create($this, 226, NULL, 'auth-bypass', '100', 'Custom Searchable Data Entry System <= 1.7.1 Unauthenticated data modification/deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-del-entry-first-entry-id'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-del-entry-first-entry-id'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale-sds-submit-field-name'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale-sds-submit-field-name'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-total-del-form-table'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-total-del-form-table'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-delete-field-id'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-delete-field-id'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale_sds_edit_field'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale_sds_edit_field'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-update-single-entry'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-update-single-entry'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-del-data-input-table'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-del-data-input-table'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-total-del-input-table-and-corresponding-form'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'sds-total-del-input-table-and-corresponding-form'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'sds-submit-upload-csv-file'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'sds-submit-upload-csv-file'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale_sds_submit_new_form'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ghazale_sds_submit_new_form'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[227] = wfWAFRule::create($this, 227, NULL, 'lfi', '100', 'WP Fastest Cache <= 0.9.0.2 - Authenticated (Subscriber+) Arbitrary File Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wpfc_delete_current_page_cache', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\.|%2E/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'path'), array (
))))));
$this->rules[230] = wfWAFRule::create($this, 230, NULL, 'file_upload', '100', 'Migration, Backup, Staging – WPvivid <= 0.9.35 - Multiple Vulnerabilities', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpvivid_upload_import_files', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvivid_upload_files', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvivid_rescan_local_folder', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvivid_add_remote', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvivid_generate_url', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvivid_get_post_list', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[231] = wfWAFRule::create($this, 231, NULL, 'rce', '100', 'WordPress File Upload <= 4.12.2 Remote Code Execution via Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wfu_ajax_action_ask_server', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#2e2e(2f|5c)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'filenames'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wfu_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#2e2e(2f|5c)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'uploadedfile_1_name'), array (
))))))));
$this->rules[232] = wfWAFRule::create($this, 232, NULL, 'priv-esc', '100', 'LearnPress <= 3.2.6.8 - Privilege Escalation via accept-to-be-teacher action parameter', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'learnpress_be_teacher', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'learnpress_plugin_install', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'learnpress_update_order_status', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'learnpress_create_page', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'accept-to-be-teacher', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[233] = wfWAFRule::create($this, 233, NULL, 'priv-esc', '100', 'Rank Math SEO <= 1.0.40.2 - Unprotected REST API Endpoints', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+rankmath[\\/]+v1[\\/]+update/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/rankmath[\\/]+v1[\\/]+update/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[234] = wfWAFRule::create($this, 234, NULL, 'auth-bypass', '100', 'Elementor Website Builder <= 2.9.5 - Authorization Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#enable_safe_mode#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'safe', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'elementor-mode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'elementor-mode'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[235] = wfWAFRule::create($this, 235, NULL, 'rce', '100', 'LifterLMS Wordpress Plugin <= 3.37.14 - Arbitrary File Write', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'export_admin_table', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'get_admin_table_data', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[236] = wfWAFRule::create($this, 236, NULL, 'file_upload', '100', 'MapPress Maps for WordPress <=2.53.8 - Authenticated Map Creation/Deletion to Stored Cross-Site Scripting & Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'mapp_tpl_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'mapp_tpl_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'mapp_tpl_get', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'mapp_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'mapp_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[237] = wfWAFRule::create($this, 237, NULL, 'auth-bypass', '100', 'OneTone <= 3.0.6 & OneTone Companion <= 1.1.1 - Unauthenticated Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?onetone_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[238] = wfWAFRule::create($this, 238, NULL, 'auth-bypass', '100', 'Klarna Checkout for WooCommerce <= 2.0.9 - Arbitrary Plugin Installation, Activation and Deactivation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'change_klarna_addon_status', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[239] = wfWAFRule::create($this, 239, NULL, 'auth-bypass', '100', 'Timetable and Event Schedule by MotoPress <= 2.3.8 XSS and Unsafe Extraction', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'route_url', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mptt_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'mptt_action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[243] = wfWAFRule::create($this, 243, NULL, 'xss', '100', 'Page Builder: Pagelayer – Drag and Drop website builder <= 1.1.1 - Missing Authorization to Cross-Site Scripting', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'pagelayer_save_content', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_do_shortcodes', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_get_taxonomy_list', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_apply_revision', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_post_nav', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_get_revision', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_post_info', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_posts_data', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_products_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_product_archives', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_create_post_autosave', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pagelayer_get_pages_list', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'contributor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[244] = wfWAFRule::create($this, 244, NULL, 'file_upload', '100', 'Elementor Pro <= 2.9.3 - Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.files', 'zip_upload'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[247] = wfWAFRule::create($this, 247, NULL, 'xss', '100', 'WP Product Review Lite <= 3.7.5 - Unauthenticated Stored Cross Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+wp-product-review[\\/]+update-review/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wp-product-review[\\/]+update-review/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[248] = wfWAFRule::create($this, 248, NULL, 'bypass', '100', 'Photo Gallery by 10Web <= 1.5.54 - SQL Injection via bwg_search_x Parameter', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#bwg_frontend_data#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]|\\%[\\da-f]{2}#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'bwg_search_0'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'bwg_search_0'), array (
))))));
$this->rules[250] = wfWAFRule::create($this, 250, NULL, 'priv-esc', '100', 'bbPress <= 2.6.4 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'bbpress', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'option_page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'option_page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', '_bbp_allow_super_mods'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', '_bbp_allow_super_mods'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[251] = wfWAFRule::create($this, 251, NULL, 'spam', '100', 'Contact Builder by Themify <= 1.4.5 - Email Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'builder_contact_send', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'contains', '%3C', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'contact-message'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'contact-message'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'contains', '<', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'contact-message'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'contact-message'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'contains', '%3c', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'contact-message'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'contact-message'), array (
)))))));
$this->rules[254] = wfWAFRule::create($this, 254, NULL, 'bypass', '100', 'JetBackup – WP Backup, Migrate & Restore <= 1.4.0 - Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'backup_guard_modalManualBackup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[255] = wfWAFRule::create($this, 255, NULL, 'auth-bypass', '100', 'Brizy < 1.0.126 - Authorization Bypass to Settings Updates', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/brizy(\\-|_)(?!(timestamp|submit_form|heartbeat))/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'author', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[257] = wfWAFRule::create($this, 257, NULL, 'xss', '100', 'TC Custom JavaScript <= 1.2.1 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'tccj-content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'tccj-update'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[260] = wfWAFRule::create($this, 260, NULL, 'file_upload', '100', 'Adning Advertising <= 1.5.5 - Arbitrary File Upload and Arbitrary File Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', '_ning_upload_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', '_ning_remove_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[264] = wfWAFRule::create($this, 264, NULL, 'xss', '100', 'Newsletter <= 6.8.1 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'tnpc_render', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'encoded_options'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#(\\\\u003c|\\\\u003e)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'encoded_options'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)))))));
$this->rules[266] = wfWAFRule::create($this, 266, NULL, 'xss', '100', 'WPBakery Page Builder <= 6.2.0 Contributor+ Stored XSS FE Save Post', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'vc_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'content'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/vc_raw_html|vc_raw_js|custom_onclick_code/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[270] = wfWAFRule::create($this, 270, NULL, 'xss', '100', 'WPBakery Page Builder <= 6.2.0 Contributor+ Stored XSS FE Save Template', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'vc_save_template', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/vc_raw_html|vc_raw_js|custom_onclick_code/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'template'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[271] = wfWAFRule::create($this, 271, NULL, 'file_upload', '100', 'Quiz and Survey Master <= 7.0.1 - Arbitrary File Deletion and Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^\\/(?:\\.\\/)*(?:var|home|usr|mnt|media|etc|tmp|dev|proc)\\/|(^|\\/|\\\\)\\.\\.(\\\\|\\/)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'qsm_remove_file_fd_question', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\.(p(h(p|tml)[0-9]?|l|y)|(j|a)sp|aspx|sh|shtml|html?|cgi|htaccess|user\\.ini)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'qsm_upload_image_fd_question', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))))));
$this->rules[273] = wfWAFRule::create($this, 273, NULL, 'bypass', '100', 'Backup, Restore and Migrate WordPress Sites With the XCloner Plugin 4.2.1 - 4.2.12 - Unprotected AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'restore_backup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'write_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'restore_mysql_backup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'list_backup_files', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'restore_finish', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'list_mysqldump_backups', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'list_backup_archives', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'restore_backup_to_path', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'get_current_directory', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'xcloner_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'xcloner_action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[274] = wfWAFRule::create($this, 274, NULL, 'xss', '100', 'Discount Rules for WooCommerce < 2.1.0 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^(?:nopriv_)?wdr_ajax#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'get_price_html', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'method'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'get_variable_product_bulk_table', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'method'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[275] = wfWAFRule::create($this, 275, NULL, 'xss', '100', 'Discount Rules for WooCommerce <= 2.1.1 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'awdr_switch_plugin_to'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'forceValidateLicenseKey', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'savePriceRule', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'saveCartRule', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'saveConfig', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'resetWDRCache', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'loadProductSelectBox', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'loadCoupons', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'UpdateStatus', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'RemoveRule', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'doBulkAction', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'createDuplicateRule', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[276] = wfWAFRule::create($this, 276, NULL, 'bypass', '100', 'Kali Forms <= 2.1.1 - Missing Authorization to Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'kaliforms_update_option_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'kaliforms_clear_log', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'kaliforms_form_delete_uploaded_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_kaliforms_form_delete_uploaded_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[278] = wfWAFRule::create($this, 278, NULL, 'rce', '100', 'File Manager <= 6.8 - Arbitrary File Upload/Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/php/connector.minimal.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[279] = wfWAFRule::create($this, 279, NULL, 'auth-bypass', '100', 'NextScripts: Social Networks Auto-Poster <= 4.3.17 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'nxs_snap_aj', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[283] = wfWAFRule::create($this, 283, NULL, 'auth-bypass', '100', 'Forminator < 1.13.5 - Unauthenticated Sensitive Data Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'forminator_export_entries', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[284] = wfWAFRule::create($this, 284, NULL, 'priv-esc', '100', 'Thrive Themes Plugins <= 1.3.4 Unprotected AJAX', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'tve_dash_backend_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[285] = wfWAFRule::create($this, 285, NULL, 'rce', '100', 'Epsilon Framework Themes (Various Versions) - Function Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?epsilon_framework_ajax_action#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?welcome_screen_ajax_callback#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?epsilon_dashboard_ajax_callback#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[287] = wfWAFRule::create($this, 287, NULL, 'priv-esc', '100', 'NEX-Forms <= 7.7.1 - Missing Authorization on Various AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'get_table_records', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_insert_record', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_update_record', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_delete_record', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_duplicate_record', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_delete_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_populate_form_entry_dashboard', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'do_form_entry_save', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_send_test_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_other_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_email_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_script_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_gr_key', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_mc_key', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'do_form_import', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'deactivate_license', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_style_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_field_pref', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_validation_pref', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_email_pref', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_other_pref', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'do_upload_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_email_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_script_config', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'preview_nex_form', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_print_chart', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_print_to_pdf', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_print_report_to_pdf', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_nf_print_report_to_pdf', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_ nf_print_to_pdf', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_get_email_setup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_get_pdf_setup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_get_options_setup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_create_custom_layout', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_delete_custom_layout', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'update_paypal', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_get_forms', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_load_form_entries', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'submission_report', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nf_hidden_fields', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[291] = wfWAFRule::create($this, 291, NULL, 'priv-esc', '100', 'Ultimate Member <= 2.1.11 - Unauthenticated Privilege Escalation via User Meta', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'form_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'form_id'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'role'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#^um_#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'role'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_user_level'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[294] = wfWAFRule::create($this, 294, NULL, 'obji', '100', 'WordPress Core < 5.5.3 - PHP Object Injection Gadget', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'matchCount', '/(^|;|{|})C:+?\\+*[0-9]+:"\\\\?Requests_Utility_FilteredIterator"/i', array(wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.cookies', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[295] = wfWAFRule::create($this, 295, NULL, 'xss', '100', 'WordPress Core < 5.5.2 - Reflected Cross-Site Scripting via Global Variables', 1, 'blockXSS', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#(?:%2f|/)(?:%77|%57|w)(?:%70|%50|p)(?:%2d|-)(?:%61|%41|a)(?:%64|%44|d)(?:%6d|%4d|m)(?:%69|%49|i)(?:%6e|%4e|n)(?:%2f|/).*(?:%2f|/)(?:%77|%57|w)(?:%70|%50|p)(?:%2d|-)(?:%61|%41|a)(?:%64|%44|d)(?:%6d|%4d|m)(?:%69|%49|i)(?:%6e|%4e|n)(?:%2f|/).*%27#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[303] = wfWAFRule::create($this, 303, NULL, 'file_upload', '100', 'ListingPro - WordPress Directory & Listing Theme < 2.6.1 - Arbitrary Plugin Installation, Activation and Deactivation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'lp_cc_addons_actions', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_lp_cc_addons_actions', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[305] = wfWAFRule::create($this, 305, NULL, 'lfi', '100', 'WordPress Gallery Plugin – NextGEN Gallery <= 3.4.7 - Cross-Site Request Forgery', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/^\\/(?:\\.\\/)*(?:var|home|usr|mnt|media|etc|tmp|dev|proc)\\//i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_thumbnails', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_imagebrowser', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_singlepic', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_compact_album', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_extended_album', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_thumbnails', 'display_view'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_imagebrowser', 'display_view'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_singlepic', 'display_view'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_compact_album', 'display_view'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_extended_album', 'display_view'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_slideshow', 'display_view'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\)\\.\\.(\\\\|\\/)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_thumbnails', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_imagebrowser', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_singlepic', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_compact_album', 'template'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'photocrati-nextgen_basic_extended_album', 'template'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthLessThan', '1', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'nonce'), array (
))))));
$this->rules[308] = wfWAFRule::create($this, 308, NULL, 'priv-esc', '100', 'Tutor LMS – eLearning and online course solution <= 1.7.6 - Unprotected AJAX including Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'tutor_add_instructor', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'instructor_approval_action', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'setup_action', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'addon_enable_disable', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[310] = wfWAFRule::create($this, 310, NULL, 'file_upload', '100', 'Responsive Menu 4.0 - 4.0.3 - Authenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'rmp_upload_theme_file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[313] = wfWAFRule::create($this, 313, NULL, 'obji', '100', 'Meta pixel for WordPress <= 2.2.2 - PHP Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '3.0.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'official-facebook-pixel'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#wp\\-admin/+admin\\-post.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wp_async_send_server_events', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_wp_async_send_server_events', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(^|;|{|})O:+?\\+*[0-9]+:(?!"(?:stdClass)")/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'event_data'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'event_data'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
))))));
$this->rules[314] = wfWAFRule::create($this, 314, NULL, 'file_upload', '100', 'WooCommerce Upload Files <= 59.3 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wcuf_file_chunk_upload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_wcuf_file_chunk_upload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(?:\\.php|\\.\\.\\/|\\.jsp|\\.vbs|\\.exe|\\.bat|\\.php5|\\.pht|\\.phtml|\\.shtml|\\.asa|\\.cer|\\.asax|\\.swf|\\.xap|;|\\.asp|\\.aspx|\\*|<|>|::)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wcuf_file_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wcuf_upload_field_name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wcuf_current_upload_session_id'), array (
))))));
$this->rules[317] = wfWAFRule::create($this, 317, NULL, 'xss', '100', 'FV Flowplayer Video Player <= 7.4.37.727 - Authenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'fv_player_db_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[318] = wfWAFRule::create($this, 318, NULL, 'redirect', '100', 'Ninja Forms Contact Form <= 3.4.33 - Administrator Open Redirect', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'nf_oauth_connect', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'redirect'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'redirect'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#^https:\\/\\/my.ninjaforms.com\\/#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'redirect'), array (
))))));
$this->rules[319] = wfWAFRule::create($this, 319, NULL, 'auth-bypass', '100', 'Ninja Forms Contact Form <= 3.4.33 - Authenticated SendWP Plugin Installation and Client Secret Key Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'ninja_forms_sendwp_remote_install', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[320] = wfWAFRule::create($this, 320, NULL, 'auth-bypass', '100', 'Ninja Forms <= 3.4.34 - Authenticated OAuth Connection Key Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'nf_oauth', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[321] = wfWAFRule::create($this, 321, NULL, 'xss', '100', 'Autoptimize Cross-Site Scripting Bypass', 0, 'blockXSS', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'autoptimize'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#j[\\savscript]+<\\!--[\\s\\S]*?-->[\\savscript]*:|"[a-z\\s\\:\\-]+<\\!--[\\s\\S]*?-->[a-z\\s\\:\\-]+=\\s*"|<<\\!--|<[^dp\\s\\+][^>]*<\\!--#ix', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))));
$this->rules[323] = wfWAFRule::create($this, 323, NULL, 'auth-bypass', '100', 'Popup Builder <= 3.72 Missing Authorization on AJAX actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sgpb_subscribers_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sgpb_add_subscribers', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sgpb_import_subscribers', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sgpb_save_imported_subscribers', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sgpb_send_newsletter', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[324] = wfWAFRule::create($this, 324, NULL, 'file_upload', '100', 'External Media <= 1.0.33 - Authenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'upload-remote-file', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[325] = wfWAFRule::create($this, 325, NULL, 'auth-bypass', '100', 'Ultimate GDPR & CCPA <= 2.4 - Unauthenticated Settings Import & Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ct-ultimate-gdpr-export'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ct-ultimate-gdpr-export-services'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ct-ultimate-gdpr-import'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'ct-ultimate-gdpr-import-services'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[329] = wfWAFRule::create($this, 329, NULL, 'bypass', '100', 'Redirection for Contact Form 7 <= 2.3.3 - Unprotected AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpcf7r_delete_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpcf7r_add_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpcf7r_make_api_test', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'activate_wpcf7r_extension', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'deactivate_wpcf7r_extension', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpcf7r_extension_update', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpcf7r_reset_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[328] = wfWAFRule::create($this, 328, NULL, 'bypass', '100', 'Redirection for Contact Form 7 <= 2.3.3 - Unauthenticated Arbitrary Nonce Generation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'nopriv_wpcf7r_get_nonce', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpcf7r_get_nonce', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[331] = wfWAFRule::create($this, 331, NULL, 'information-disclosure', '100', 'User Profile Picture <= 2.4.0 - Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+mpp[\\/]+v2[\\/]+get_users/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/mpp[\\/]+v2[\\/]+get_users/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[333] = wfWAFRule::create($this, 333, NULL, 'file_upload', '100', 'WordPress Mega Menu <= 2.0.6 - Arbitrary File Creation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'quadmenu_compiler_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_quadmenu_compiler_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[335] = wfWAFRule::create($this, 335, NULL, 'xss', '100', 'Elementor <= 3.1.2 Elements Kit Lite/Pro <= 2.1.7 - Authenticated (Contributor+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(?:["_]tag|header_size|title_size)":"(?!(?:div|header|footer|main|article|section|aside|nav|span|p|a|none|h1|h2|h3|h4|h5|h6|null|large|custom|ul|)")#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[336] = wfWAFRule::create($this, 336, NULL, 'sqli', '100', 'Tutor LMS <= 1.8.3 - SQL Injection via Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'tutor_place_rating', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tutor_mark_answer_as_correct', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tutor_quiz_builder_get_question_form', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tutor_quiz_builder_get_answers_by_question', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'tutor_answering_quiz_question', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'tutor_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'tutor_action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))))));
$this->rules[338] = wfWAFRule::create($this, 338, NULL, 'sqli', '40', 'SQL Injection in User-Agent String', 0, 'failSQLi', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
))))));
$this->rules[341] = wfWAFRule::create($this, 341, NULL, 'information-disclosure', '100', 'Store Locator Plus <= 5.12.3 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+store-locator-plus[\\/]+v2[\\/]+options[\\/]+all/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/store-locator-plus[\\/]+v2[\\/]+options[\\/]+all/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+store-locator-plus[\\/]+v2[\\/]+options[\\/]+import/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/store-locator-plus[\\/]+v2[\\/]+options[\\/]+import/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[343] = wfWAFRule::create($this, 343, NULL, 'auth-bypass', '100', 'Plus Addons for Elementor Page Builder <= 4.1.6 - Authentication Bypass Method #2', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'theplus_ajax_login', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'theplus_google_ajax_register', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'email'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'email'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'email'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'email'), array (
)))))));
$this->rules[344] = wfWAFRule::create($this, 344, NULL, 'obji', '100', 'PHP Object Injection in Cookies', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|;|{|})(?:O|C):\\d+:"(?!stdClass")[^"]+":/', array(wfWAFRuleComparisonSubject::create($this, 'request.cookies', array (
))))));
$this->rules[347] = wfWAFRule::create($this, 347, NULL, 'priv-esc', '100', 'BuddyPress 5.0.0-7.2.0 - Privilege Escalation via REST API', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+buddypress[\\/]+v1[\\/]+members[\\/]+(?:me|\\d+)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/buddypress[\\/]+v1[\\/]+members[\\/]+(?:me|\\d+)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'versionLessThan', '7.2.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'buddypress'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[348] = wfWAFRule::create($this, 348, NULL, 'file_upload', '100', 'Multiple Thrive Themes and Plugins (Various Versions) - Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+td[\\/]+v1[\\/]+optin[\\/]+subscription/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/td[\\/]+v1[\\/]+optin[\\/]+subscription/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'api_key'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'api_key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#api_key":""#i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#(?:hook_url|hookUrl)":"\\{#i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\{\\}]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'hook_url'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'hookUrl'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'hook_url'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'hookUrl'), array (
)))))));
$this->rules[349] = wfWAFRule::create($this, 349, NULL, 'rfd', '100', 'Multiple Thrive Themes < 2.0.0 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+thrive[\\/]+kraken/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/thrive[\\/]+kraken/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^(?![0-9a-f]{32}).#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'id'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#"id":"(?![0-9a-f]{32})#i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))))));
$this->rules[351] = wfWAFRule::create($this, 351, NULL, 'auth-bypass', '100', 'Woocommerce Customers Manager <= 26.4 - Authenticated Account Creation and Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'upload_csv', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wccm_export_csv', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wccm_export_guests_csv', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[352] = wfWAFRule::create($this, 352, NULL, 'file_upload', '100', 'Business Hours Pro <= 5.5.0 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'iva_bh_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_iva_bh_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'iva_bh_import_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_iva_bh_import_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[353] = wfWAFRule::create($this, 353, NULL, 'lfi', '100', 'The Plus Addons for Elementor PRO <= 4.1.9 & The Plus Addons for Elementor <= 2.0.6 - Authenticated (Contributor+) Arbitrary File Read', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#"(?:loop_)?svg_image":\\{[^\\}]*"url":"[^"]+\\.(?!svg)\\w+"#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[356] = wfWAFRule::create($this, 356, NULL, 'redirect', '100', 'Simple 301 Redirects 2.0.0 - 2.0.3 - Unauthenticated Redirect Import/Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', '301options', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'export'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'export'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'import'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'import'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[357] = wfWAFRule::create($this, 357, NULL, 'file_upload', '100', 'Simple 301 Redirects by BetterLinks 2.0.0 - 2.0.1 - Unprotected AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'simple301redirects/admin/wildcard', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'simple301redirects/admin/install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'simple301redirects/admin/activate_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'simple301redirects/admin/hide_notice', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'simple301redirects/admin/get_import_info', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[359] = wfWAFRule::create($this, 359, NULL, 'priv-esc', '100', 'Essential Addons for Elementor <= 4.6.4 - Authenticated (Contributor+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', 'eael-login-register', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#register_user_role":"(?!subscriber|customer)[^"]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[360] = wfWAFRule::create($this, 360, NULL, 'bypass', '100', 'Essential Addons for Elementor <= 4.6.4 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpdeveloper_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpdeveloper_activate_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_settings_with_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'clear_cache_files_with_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[361] = wfWAFRule::create($this, 361, NULL, 'file_upload', '100', 'Kaswara Modern VC Addons <= 3.0.1 - Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'contains', 'kaswara', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'uploadFontIcon', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_uploadFontIcon', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(\\.zip)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[362] = wfWAFRule::create($this, 362, NULL, 'bypass', '100', 'Kaswara Modern VC Addons <= 3.0.1 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'contains', 'kaswara', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'exportShortcodeData', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_exportShortcodeData', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'importShortcodeData', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_importShortcodeData', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'exportCf7Styles', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_exportCf7Styles', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'importCf7Styles', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_importCf7Styles', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'deleteFontIcon', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_deleteFontIcon', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[364] = wfWAFRule::create($this, 364, NULL, 'auth-bypass', '100', 'WooCommerce Product Filter by WooBeWoo <= 1.4.9 Unprotected AJAXs', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpf', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'pl'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'pl'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'save', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'deleteByID', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'drawFilterAjax', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'removeGroup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'saveGroup', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'createTable', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[365] = wfWAFRule::create($this, 365, NULL, 'obji', '100', 'Thrive Plugins < 2021-05-11 Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|;|{|})(?:O|C):\\d+:"(?!stdClass")[^"]+":/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', '__tcb_lg_msg'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', '__tcb_lg_fc'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'consent_config'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'tve_mapping'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'tve_labels'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'config'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
))))));
$this->rules[369] = wfWAFRule::create($this, 369, NULL, 'priv-esc', '100', 'User Registration, User Profiles, Login & Membership – ProfilePress (Formerly WP User Avatar) 3.0.0 - 3.1.3 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'pp_ajax_signup', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pp_ajax_editprofile', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_user_level'), array (
)))))));
$this->rules[370] = wfWAFRule::create($this, 370, NULL, 'priv-esc', '100', 'Privilege Escalation via User Meta Updates', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_capabilities'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_user_level'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[371] = wfWAFRule::create($this, 371, NULL, 'file_upload', '100', 'Fancy Product Designer <= 4.6.8 - Unauthenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'fpd_custom_uplod_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_fpd_custom_uplod_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\.[^a-z0-9\\.]*p[^a-z0-9\\.]*h[^a-z0-9\\.]*p#i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/custom\\-image\\-handler\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[372] = wfWAFRule::create($this, 372, NULL, 'auth-bypass', '100', 'Fancy Product Designer <= 4.6.9 Unprotected AJAX actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^fpd_(?:create_|update_|delete_|get_|upload_|export|reset_)#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[376] = wfWAFRule::create($this, 376, NULL, 'file_upload', '100', 'ZoomSounds <= 5.96 - Unauthenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/dzs\\-zoomsounds\\/savepng\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[379] = wfWAFRule::create($this, 379, NULL, 'sqli', '100', 'WooCommerce < 5.5.1 - SQL Injection via URL Encode Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+wc[\\/]+store[\\/]+products[\\/]+collection-data/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wc[\\/]+store[\\/]+products[\\/]+collection-data/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\%25[0-9a-fA-F]{2}#', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.jsonBody', array (
))))));
$this->rules[380] = wfWAFRule::create($this, 380, NULL, 'sqli', '100', 'WooCommerce < 5.5.1 - SQL Injection via Double URL Encode Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+wc[\\/]+store[\\/]+products[\\/]+collection-data/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wc[\\/]+store[\\/]+products[\\/]+collection-data/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\%2525[0-9a-fA-F]{2}#', array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
))))));
$this->rules[381] = wfWAFRule::create($this, 381, NULL, 'auth-bypass', '100', 'Profile Builder <= 3.4.8 - Admin Access via Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'recover_password2', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action2'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'notMatch', '#^[a-zA-Z0-9]{20}$#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#key(\\[|\\%5b)#', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))))));
$this->rules[383] = wfWAFRule::create($this, 383, NULL, 'xss', '100', 'SEOPress 5.0.0 - 5.0.3 - Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/seopress[\\/]+v1[\\/]+posts/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^put$#i', array(wfWAFRuleComparisonSubject::create($this, 'request.method', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Http-Method-Override'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.headers', 'X-Method-Override'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[384] = wfWAFRule::create($this, 384, NULL, 'auth-bypass', '100', 'Booster for WooCommerce <= 5.4.3 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '5736f6a062bcdc410e5565249a74af55'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'versionlessthanequalto', '5.4.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'woocommerce-jetpack'), array (
))))));
$this->rules[386] = wfWAFRule::create($this, 386, NULL, 'insufficient-auth', '100', 'Gutenberg Template Library & Redux Framework <= 4.2.11 - Missing Authorization to Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/redux[\\/]+v1[\\/]+templates/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[387] = wfWAFRule::create($this, 387, NULL, 'auth-bypass', '100', 'Ninja Forms <= 3.5.7 - Unprotected REST-API to Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/ninja-forms-submissions/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[390] = wfWAFRule::create($this, 390, NULL, 'file_upload', '100', 'AccessPress Themes and Plugin <= Various Versions - Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'plugin_offline_installer', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[391] = wfWAFRule::create($this, 391, NULL, 'xss', '100', 'underConstruction <= 1.18 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'under-construction', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#wp-admin[\\/]+admin\\.php.+#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[392] = wfWAFRule::create($this, 392, NULL, 'xss', '100', 'Easy Social Icons <= 3.0.8 – Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'cnss_social_icon_page', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#wp-admin[\\/]+admin\\.php.+#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[393] = wfWAFRule::create($this, 393, NULL, 'auth-bypass', '100', 'HashThemes Demo Importer <= 1.1.1 - Missing Authorization to Database Wipe', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^hdi_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[396] = wfWAFRule::create($this, 396, NULL, 'auth-bypass', '100', 'Premium Addons for Elementor <= 4.5.1 - Authenticated (Subscriber+) Limited Arbitrary Option Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'pa_dismiss_admin_notice', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[397] = wfWAFRule::create($this, 397, NULL, 'auth-bypass', '100', 'WooCommerce Dynamic Pricing and Discounts <= 2.4.1 - Unauthenticated Settings Import/Export', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.files', 'rp_wcdpd_settings'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rp_wcdpd_export_settings'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rp_wcdpd_export_settings'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rp_wcdpd_export_settings'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rp_wcdpd_export_settings'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[399] = wfWAFRule::create($this, 399, NULL, 'file_upload', '100', 'Envato Elements <= 2.0.9 -  Contributor+ Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'envato_elements', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'template_kit_import', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/envato-elements\\/v2/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/template-kit-import\\/v2/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[400] = wfWAFRule::create($this, 400, NULL, 'auth-bypass', '100', 'WordPress Automatic <= 3.53.2 + Pinterest Automatic <= 4.14.3 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'wp_pinterest_automatic'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'wp_pinterest_automatic'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-automatic\\/process_form\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))))));
$this->rules[401] = wfWAFRule::create($this, 401, NULL, 'xss', '100', 'OptinMonster <= 2.6.0 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.6.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'optinmonster'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(\\(|\\)|=)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'om-live-rules-preview'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'om-live-rules-preview'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'om-live-preview'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'om-live-preview'), array (
))))));
$this->rules[403] = wfWAFRule::create($this, 403, NULL, 'auth-bypass', '100', 'RegistrationMagic <= 5.2.1.0 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionlessthanequalto', '5.2.1.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'custom-registration-form-builder-with-submission-manager'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '1297c6ae35002b8a3ea315c00b6c799c', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
))))));
$this->rules[404] = wfWAFRule::create($this, 404, NULL, 'auth-bypass', '100', 'YITH Easy Login & Register Popup for WooCommerce <= 1.8.0 - Authentication Bypass via Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'set-new-password', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'yith_welrp_form_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wc-ajax'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'wc-ajax'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'versionlessthanequalto', '1.8.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'yith-easy-login-register-popup-for-woocommerce'), array (
))))));
$this->rules[405] = wfWAFRule::create($this, 405, NULL, 'auth-bypass', '100', 'Multiple XforWooCommerce Add-On Plugins (Various Versions) - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'svx_ajax_factory', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[406] = wfWAFRule::create($this, 406, NULL, 'priv-esc', '100', 'WP User Manager <= 2.6.2 - Arbitrary User Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionlessthan', '2.6.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-user-manager'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit_password_recovery'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'password_recovery_nonce'), array (
))))));
$this->rules[407] = wfWAFRule::create($this, 407, NULL, 'auth-bypass', '100', 'WP DSGVO Tools (GDPR) <= 3.1.22 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^(nopriv_)?SPDSGVO-integration-#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'admin-dismiss-unsubscribe', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_admin-dismiss-unsubscribe', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[408] = wfWAFRule::create($this, 408, NULL, 'bypass', '100', 'OptinMonster <= 2.6.4 - Unprotected REST-API Endpoints', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.6.4', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'optinmonster'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/omapp\\/v1/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[413] = wfWAFRule::create($this, 413, NULL, 'auth-bypass', '100', 'WCFM Membership <= 2.10.0 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wcfmvm_(vendor_approval_html|vendor_approval_response_update|membership_change|change_next_renewal)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'delete_wcfm_membership', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wcfm-(memberships|memberships-manage|memberships-settings)$/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'controller'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'controller'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>\\%]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'controller'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'controller'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[414] = wfWAFRule::create($this, 414, NULL, 'auth-bypass', '100', 'RULE-414', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.4.10', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wc-multivendor-marketplace'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wcfm_(vendor_store_offline|vendor_store_online)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wcfmmp_(media_delete|bulk_media_delete|reviews_delete)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[415] = wfWAFRule::create($this, 415, NULL, 'sqli', '100', 'WCFM Marketplace <= 3.4.11 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wcfm_(messages_bulk_mark_read|messages_bulk_mark_delete)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/wcfm-(refund-requests|vendor-orders|orders|enquiry|reviews)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'controller'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'controller'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>%]#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))));
$this->rules[417] = wfWAFRule::create($this, 417, NULL, 'auth-bypass', '100', 'WCFM Frontend Manager <= 6.6.0 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '6.6.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wc-frontend-manager'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wcfm_(vendor_disable|vendor_enable)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/(archive|delete|publish)_wcfm/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(wcfm-payments|wcfm-withdrawal|wcfm-vendors|wcfm-notices|wcfm-capability|wcfm-[a-z]+-manage)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'controller'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>\\%]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'controller'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[421] = wfWAFRule::create($this, 421, NULL, 'auth-bypass', '100', 'Responsive Menu <= 4.1.7 - Missing Authorization Checks', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^rmp_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[422] = wfWAFRule::create($this, 422, NULL, 'xss', '100', 'Smash Balloon Social Post Feed <= 4.0 - Arbitrary Plugin Settings Update to Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '4.0.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'custom-facebook-feed'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^cff_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[427] = wfWAFRule::create($this, 427, NULL, 'csrf', '100', 'Login/Signup Popup <= 2.2 - Cross-Site Request Forgery to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'xoo_admin_settings_save', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(administrator|siteurl|users_can_register|default_role|admin_email|mailserver_url|mailserver_login|rewrite_rules|wp_user_roles)#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'form'), array (
))))));
$this->rules[429] = wfWAFRule::create($this, 429, NULL, 'auth-bypass', '100', 'Tawk.To Live Chat <= 0.5.4 - Missing Authorization to Visitor Monitoring & Chat Removal', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'tawkto_setwidget', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tawkto_removewidget', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[431] = wfWAFRule::create($this, 431, NULL, 'insufficient-auth', '100', 'Variation Swatches for WooCommerce <= 2.1.1 - Authenticated (Subscriber+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'update_product_attr_type', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'update_attribute_type_setting', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tawcvs_save_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'woosuite_saving_variation_settings'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[435] = wfWAFRule::create($this, 435, NULL, 'options_update', '100', 'PublishPress Capabilities <= 2.3 - Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionlessthanequalto', '2.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'capability-manager-enhanced'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'pp-capabilities-settings', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'page'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'page'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'all_options'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'all_options_pro'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[436] = wfWAFRule::create($this, 436, NULL, 'options_update', '100', 'Oxilab Plugins <= (Various Versions) Unauthenticated Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+.*[\\/]+(v1|v2)[\\/]+(oxi_settings|addons_settings)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/\\/.*[\\/]+(v1|v2)[\\/]+(oxi_settings|addons_settings)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[437] = wfWAFRule::create($this, 437, NULL, 'sqli', '100', 'Page Duplication Function (Various Plugins) Second Order SQLi', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'add-meta', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'editpost', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'meta'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'metakeyinput'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'meta'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>]#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'metakeyinput'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[438] = wfWAFRule::create($this, 438, NULL, 'auth-bypass', '100', 'All in One SEO 4.1.3.1 - 4.1.5.2 - Authenticated SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '4.1.5.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'all-in-one-seo-pack'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/aioseo[\\/]+v1[\\/]+/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[439] = wfWAFRule::create($this, 439, NULL, 'xss', '100', 'WP HTML Mail <= 3.0.9 - Missing Authorization on Rest Route', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/whm[\\/]+v3[\\/]+themesettings/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[441] = wfWAFRule::create($this, 441, NULL, 'auth-bypass', '100', 'Ultimate FAQ <= 2.1.1 - Missing Authorization to Arbitrary FAQ Creation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#ewd_ufaq_welcome_#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[442] = wfWAFRule::create($this, 442, NULL, 'auth-bypass', '100', 'Oxilab Plugins <= Various Versions Unprotected AJAX and Rest Routes', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/[\\/]+(ImageHoverUltimate|ShortCodeAddonsUltimate|oxilabtabsultimate)[\\/]+(v1|v2)[\\/]/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin\\/admin\\-ajax\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'image_hover_ultimate', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'oxi_flip_box_data', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[444] = wfWAFRule::create($this, 444, NULL, 'auth-bypass', '100', 'Insight Core <= 1.0 - Authenticated PHP Object Injection & Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'insight_customizer_options_import', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'import_dummy', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[448] = wfWAFRule::create($this, 448, NULL, 'insufficient-auth', '100', 'Easy Drag And drop All Import : WP Ultimate CSV Importer < 6.4.1 Unprotected AJAX Actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '6.4.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-ultimate-csv-importer'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(get_desktop|get_csv_url|get_ftp_url|get_ftp_details|get_parse_xml|saveMappedFields|StartImport|GetProgress|ImportState|ImportStop|checkmain_mode|disable_main_mode|bulk_file_import|bulk_import|PauseImport|ResumeImport|DeactivateMail|total_records|check_export|updatefields|LineChart|PieChart|BarChart|checkExtensions|listuploads|locklist|install_plugins|zip_ngg_upload|csv_options|display_log|download_log|displayCSV|preview|zip_upload|image_options|delete_image|media_report|support_mail|send_subscribe_email|settings_options|send_login_credentials_to_users|get_options|security_performance|active_addons|mappingfields|getfields)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[451] = wfWAFRule::create($this, 451, NULL, 'xss', '100', 'GiveWP <= 2.17.2 - Reflected Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.17.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'give'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#wp-admin\\/edit\\.php#', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#[\\r\\n\\t<>=]#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 's'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'json'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'give_forms', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'post_type'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'post_type'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 's'), array (
))))))));
$this->rules[453] = wfWAFRule::create($this, 453, NULL, 'file_upload', '100', 'Zip File Uploads', 0, 'log', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\.(zip)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'add_custom_font', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))));
$this->rules[455] = wfWAFRule::create($this, 455, NULL, 'auth-bypass', '100', 'Use Any Font < 6.2.1 - Unauthenticated Arbitrary CSS Appending', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-uaf-font-php'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-uaf-font-js'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-uaf-font-php'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'submit-uaf-font-js'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[456] = wfWAFRule::create($this, 456, NULL, 'priv-esc', '100', 'MasterStudy LMS < 2.7.6 - Unauthenticated Admin Account Creation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'stm_lms_register', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(wp_capabilities|wp_user_level)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[458] = wfWAFRule::create($this, 458, NULL, 'xss', '100', 'WP Cerber Security <= 8.9.5.2 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '8.9.6', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-cerber'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.uri', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[459] = wfWAFRule::create($this, 459, NULL, 'auth-bypass', '100', 'UpdraftPlus WordPress Backup Plugin < 1.22.3 - Sensitive Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'updraft_download_backup', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'heartbeat', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'data', 'updraftplus'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'data', 'updraftplus', 'log_nonce'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[460] = wfWAFRule::create($this, 460, NULL, 'file_download', '100', 'BackupWordPress <= 3.12 - Missing Authorization to Authenticated (Subscriber+) Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'heartbeat', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'data', 'hmbkp_schedule_id'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[461] = wfWAFRule::create($this, 461, NULL, 'information-disclosure', '100', 'Total Upkeep <= 1.14.13 - Missing Authorization to Authenticated (Subscriber+) Information Disclosure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'heartbeat', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'data', 'boldgrid_backup_in_progress'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[462] = wfWAFRule::create($this, 462, NULL, 'insufficient-auth', '100', 'Freemius <= 2.4.2 - Missing Authorization on AJAX actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(fs_dismiss_notice_action_|fs_retry_connectivity_test_|fs_resolve_firewall_issues_)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'fs_toggle_debug_mode', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'fs_get_debug_log', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[477] = wfWAFRule::create($this, 477, NULL, 'xss', '100', 'WordPress Core 5.9 - 5.9.1 - Authenticated (Contributor+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionGreaterThanEqualTo', '5.9.0', array(wfWAFRuleComparisonSubject::create($this, 'wordpress.core', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.9.1', array(wfWAFRuleComparisonSubject::create($this, 'wordpress.core', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/wp[\\/]+v2[\\/]+posts/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\\\\\\\u0#', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[478] = wfWAFRule::create($this, 478, NULL, 'xss', '100', 'WordPress Core < 5.9.2 & Gutenberg < 12.7.2 - Prototype Pollution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', '__proto__'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'constructor'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'prototype'), array (
))))));
$this->rules[482] = wfWAFRule::create($this, 482, NULL, 'rce', '100', 'Tatsu <= 3.3.12 - Unauthenticated Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?add_custom_font#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[483] = wfWAFRule::create($this, 483, NULL, 'rce', '100', 'WAF-RULE-483', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', '9419144043c824fe684399c5ff5ba46d', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '82bc3ff3aa0b29f7a326c88b6b53617a', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '1bc92cdc15368557981fcab5dfca2979', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'e81f641f598c43fd2923236d0e398ec2', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'dd46145d9f2c386a47527d9d204f264a', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'd84b5d5582f4dd40688105bf48ef1b07', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[485] = wfWAFRule::create($this, 485, NULL, 'privesc', '100', 'WAF-RULE-485', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#^abb_(?!\\w+_action)#', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^jupiterx_[^l]#', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[486] = wfWAFRule::create($this, 486, NULL, 'file_upload', '100', 'Cool Plugins (Various Versions) - Arbitrary Plugin Installation and Activation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(cool_plugins_(install|activate))/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[489] = wfWAFRule::create($this, 489, NULL, 'xss', '100', 'Ultimate Member <= 2.3.2 - Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.3.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'ultimate-member'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\&(lt|#60|#x3c);/i', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'edit', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'um_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'um_action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[499] = wfWAFRule::create($this, 499, NULL, 'auth-bypass', '100', 'Custom Product Tabs for WooCommerce <= 1.7.7 - Subscriber+ Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#yikes/cpt/v1/settings#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[503] = wfWAFRule::create($this, 503, NULL, 'information-disclosure', '100', 'Duplicator – WordPress Migration Plugin <= 1.4.7 - Unauthenticated Backup Download', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/dup\\-installer/main\\.installer\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[514] = wfWAFRule::create($this, 514, NULL, 'auth-bypass', '100', 'WAF-RULE-514', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^jkit_#', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '42dd1238ecd3cea6190ca8155ef9b7bb'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '42dd1238ecd3cea6190ca8155ef9b7bb'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '42dd1238ecd3cea6190ca8155ef9b7bb'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '42dd1238ecd3cea6190ca8155ef9b7bb'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '3c1d76e6a2e9e5afed4be33600b638f9'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '3c1d76e6a2e9e5afed4be33600b638f9'), array (
))))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[515] = wfWAFRule::create($this, 515, NULL, 'insufficient-auth', '100', 'Blog2Social <= 6.9.11 - Missing Authorization to Authenticated (Subscriber+) Settings Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'b2s_save_social_meta_tags', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'b2s_user_network_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'legacy_mode'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'legacy_mode'), array (
)))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'b2s_lock_auto_post_import', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[516] = wfWAFRule::create($this, 516, NULL, 'ssrf', '100', 'Web Stories <= 1.24.0 - Server Side Request Forgery', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+web-stories[\\/]+v1[\\/]+hotlink[\\/]+proxy/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/web-stories[\\/]+v1[\\/]+hotlink[\\/]+proxy/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/\\/(0|127|10|172|192|169|100)\\./i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'url'), array (
))))));
$this->rules[517] = wfWAFRule::create($this, 517, NULL, 'auth-bypass', '100', 'Download Plugin <= 1.6.2 - Missing Authorization and Sensitive Information Exposure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'dpwap_plugin_download_url', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[518] = wfWAFRule::create($this, 518, NULL, 'priv-esc', '100', 'tagDiv Composer < 3.5 - Unauthorized Account Access and Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'td_ajax_fb_login_user', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'user', 'email'), array (
))))));
$this->rules[519] = wfWAFRule::create($this, 519, NULL, 'auth-bypass', '100', 'Multiple Bill Minozzi Plugins - Authenticated (Subscriber+) Missing Authorization to Arbitrary Plugin Install', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'antihacker_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'stopbadbots_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpmemory_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'cardealer_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wptools_install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[522] = wfWAFRule::create($this, 522, NULL, 'insufficient-auth', '100', 'Download Monitor <= 4.7.60 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '4.7.70', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'download-monitor'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/download-monitor[\\/]+v1[\\/]+(user_data|download_reports|user_reports|templates)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[523] = wfWAFRule::create($this, 523, NULL, 'sqli', '100', 'Cyr to Lat <= 3.5 - Authenticated SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+tags#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', '\'', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[526] = wfWAFRule::create($this, 526, NULL, 'auth-bypass', '100', 'BeRocket Plugins <= (Various Versions) - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin\\/admin\\-ajax\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'berocket_admin_close_notice', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'berocket_subscribe_email', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'berocket_rate_stars_close', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'berocket_feature_request_send', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'berocket_error_notices_get', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'berocket_information_close_notice', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'br_test_key', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[528] = wfWAFRule::create($this, 528, NULL, 'privesc', '100', 'iubenda <= 3.3.2 - Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'ajax_save_options', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'quick_generator_api', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'integrate_setup', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'toggle_services', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'save_public_api_key', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'auto_detect_forms', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'update_options', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'radar_percentage_reload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'cs_configuration', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'pp_configuration', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'tc_configuration', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'cons_configuration', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'frontpage_main_box', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[529] = wfWAFRule::create($this, 529, NULL, 'auth-bypass', '100', 'WAF-RULE-529', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'md5Equals', 'b254c456fc0fea3d356dbac744ba1394', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '79eb411a0574474c9b544c3fcd76a056', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '6ee5d32bb9ef333e8d23a4a84aa80777', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'be422283e46ff4557994546f1afb59ca', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '603e8e451644f9a9704cd2ce61e9d4de', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '207940e9eb2165482ba653b169e56f92', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'b777e22f790d44cc1315dcd12d47953e', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '0cdf70afbfad8fc504c4d6c911feb621', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', 'a48b99906c864bc7c919ac6e7f6ef968', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '8365bd60f38f7952add8d300c517676d', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '8d2086d798c5bd532b6e60c6d8920629', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'md5Equals', '5b5c5ed0942517f1a27d9f3d45ace6a6', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[530] = wfWAFRule::create($this, 530, NULL, 'rce', '100', 'User Post Gallery - UPG <= 2.19 - Missing Authorization to Remote Command Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'upg_datatable', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[532] = wfWAFRule::create($this, 532, NULL, 'insufficient-auth', '100', 'Quick Restaurant Menu <= 2.0.2 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'erm_update_menu_item', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'erm_delete_menu_item', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'erm_create_menu_item', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'erm_update_list_menu_items', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'erm_list_menu_items', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'erm_update_menu_week', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[537] = wfWAFRule::create($this, 537, NULL, 'lfi', '100', 'LearnPress <= 4.1.7.3.2 - Unauthenticated Local File Inclusion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/+lp\\/+v1#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(\\/|\\%2F)(?:(\\.|\\%2E)(\\/|\\%2F))*(?:var|usr|mnt|etc|tmp|dev|proc|home)(\\/|\\%2F)|(\\.|\\%2E)(\\.|\\%2E)(\\\\|\\/|\\%2F|\\%5C)#i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[538] = wfWAFRule::create($this, 538, NULL, 'sqli', '30', 'LearnPress <= 4.1.7.3.2 - Unauthenticated SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/+lp\\/+v1#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[548] = wfWAFRule::create($this, 548, NULL, 'insufficient-auth', '100', 'Redirect Redirection <= 1.1.3 - Missing Authorization Checks on Various Functions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(irAddRedirect|irInstantEditRedirect|irLoadRedirectSettings|irSaveRedirectSettings|irDeleteRedirect|irStatusBulkEdit|irBulkDelete|irRedirectionPageContent|irLiveSearch|irSelectAll|irLogPageContent|irLogFilter|irAddRedirectRule|irLoadTab|irSaveSettings|irLoadSettings|inisev_installation)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[551] = wfWAFRule::create($this, 551, NULL, 'auth-bypass', '100', 'WP Meta SEO <= 4.5.3 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpms_regenerate_sitemaps', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpms_save_sitemap_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpms_list_posts_category', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpms_sitemap_check_all_category', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpms_gg_save_information', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpms_set_ignore', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[552] = wfWAFRule::create($this, 552, NULL, 'privesc', '100', 'Houzez Theme <= 2.7.1 and Houzez Login Register <= 2.6.3 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#(?:nopriv_)?houzez_(?:register|change_user_role|register_user_with_membership)#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'user_role', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#^houzez_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'user_role'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'role', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '#^houzez_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'role'), array (
))))))));
$this->rules[553] = wfWAFRule::create($this, 553, NULL, 'auth-bypass', '100', 'WP Meta SEO <= 4.5.2 - Missing Authorization - startProcess', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpms', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'edit_posts', array())));
$this->rules[555] = wfWAFRule::create($this, 555, NULL, 'priv-esc', '100', 'ProfileGrid <= 5.3.0 - Missing Authorization to Arbitrary Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'pm_reset_user_password', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[557] = wfWAFRule::create($this, 557, NULL, 'options_update', '100', 'Sitemap by click5 <= 1.0.35 - Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#click5_sitemap\\/+API\\/+update_html_option_AJAX#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[559] = wfWAFRule::create($this, 559, NULL, 'insufficient-auth', '100', 'OoohBoi Steroids for Elementor <= 2.1.3 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'exopite-sof-file_uploader', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'exopite-sof-file-batch-delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'upload_files', array())));
$this->rules[560] = wfWAFRule::create($this, 560, NULL, 'insufficient-auth', '100', 'Paytium <= 4.3.7 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'pt_cancel_subscription', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_notice_dismiss', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_sw_save_api_keys', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_mollie_check_for_verified_profiles', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_mollie_update_profile_preference', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_mollie_create_profile', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_mollie_check_account_details', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'paytium_mollie_create_account', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[566] = wfWAFRule::create($this, 566, NULL, 'priv-esc', '100', 'Updraft Plus 1.22.14 to 1.23.2 - Privilege Escalation via updraft_central_ajax_handler', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'updraft_central_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[567] = wfWAFRule::create($this, 567, NULL, 'whitelist', '100', 'SEO Plugin by Squirrly SEO <= 12.1.20 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sq_ajax_search_blog', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_checkin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_keywords', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_preview', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_tasks', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_briefcase_get', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_briefcase_add', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_briefcase_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_briefcase_save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_customcall', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_research_process', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_research_others', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_research_history', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_journey_close', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_auditpages_getaudit', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_focuspages_inspecturl', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_focuspages_getpage', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ranking_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_serp_delete_keyword', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_rank_bulk_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_rank_bulk_refresh', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_postslist ', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sla_customcall ', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_onboarding_commitment', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_focuspages_getpage ', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'edit_others_posts', array())), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sq_register', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_login', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_seosettings_clear_cache', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_seosettings_importall', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_rollback', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_reinstall', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_type_click', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_onboading_checksite', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_account_disconnect', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_ajax_account_getaccount', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_seosettings_ga_check', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_seosettings_gsc_check', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'sq_alerts_close', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'inline-save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'edit_posts', array()))));
$this->rules[569] = wfWAFRule::create($this, 569, NULL, 'auth-bypass', '100', 'FULL - Customer <= 2.2.3 - Authenticated(Subscriber+) Improper Authorization to Arbitrary Plugin Installation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/full-customer/#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp-json/full-customer/#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[570] = wfWAFRule::create($this, 570, NULL, 'priv-esc', '100', 'Elementor Pro <= 3.11.6 - Authenticated(Subscriber+) Privilege Escalation via update_page_option', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#pro_woocommerce_update_page_option#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[571] = wfWAFRule::create($this, 571, NULL, 'insufficient-auth', '100', 'Filebird <= 5.1.4 - Missing Authorization via resAdminPermissionsCheck', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/filebird/v1/fbv-api/#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())));
$this->rules[573] = wfWAFRule::create($this, 573, NULL, 'insufficient-auth', '100', 'HappyFiles Pro <= 1.8.1 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.8.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'happyfiles-pro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin\\/admin\\-ajax\\.php$/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/happyfiles_/i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[575] = wfWAFRule::create($this, 575, NULL, 'insufficient-auth', '100', 'ACF Quick Edit Fields <= 3.2.2 - Authenticated (Contributor+) Insecure Direct Object Reference', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'get_acf_post_meta', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[577] = wfWAFRule::create($this, 577, NULL, 'idor', '100', 'Directorist <= 7.5.4 - Authenticated (Subscriber+) Insecure Direct Object Reference to Arbitrary Post Deletion in listing_task', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '7.5.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'directorist'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'directorist_dashboard_listing_tab', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'edit_others_posts', array())));
$this->rules[579] = wfWAFRule::create($this, 579, NULL, 'ssrf', '100', 'Getwid – Gutenberg Blocks <= 1.8.3 - Authenticated(Subscriber+) Server Side Request Forgery', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/getwid/v1/get_remote_content#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/\\/(0|127|10|172|192|169|100)\\./i', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'get_content_url'), array (
))))));
$this->rules[581] = wfWAFRule::create($this, 581, NULL, 'insufficient-auth', '100', 'WP Fastest Cache <= 1.1.2 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpfc_preload_single', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpfc_purgecache_varnish', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpfc_clear_cache_of_allsites', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpfc_delete_cache_and_minified', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[585] = wfWAFRule::create($this, 585, NULL, 'auth-bypass', '100', 'ZM Ajax Login & Register <= 2.0.2 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.0.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'zm-ajax-login-register'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'facebook_login', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[586] = wfWAFRule::create($this, 586, NULL, 'priv-esc', '100', 'Easy Digital Downloads <= 3.1.1.4.1 - Unauthenticated Arbitrary Password Reset to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '3.1.1.4.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'easy-digital-downloads'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'user_reset_password', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'edd_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'edd_action'), array (
))))));
$this->rules[588] = wfWAFRule::create($this, 588, NULL, 'priv-esc', '100', 'Essential Addons for Elementor <= 5.7.1 - Unauthenticated Arbitrary Password Reset to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '5.7.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'essential-addons-for-elementor-lite'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'eael-resetpassword-submit'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'eael-resetpassword-submit'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'eael-resetpassword-submit'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'eael-resetpassword-submit'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rp_login'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rp_login'), array (
))))));
$this->rules[589] = wfWAFRule::create($this, 589, NULL, 'priv-esc', '100', 'MStore API <= 3.9.2 - Multiple Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.9.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'mstore-api'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/api\\/+flutter_woo\\/#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+add-listing#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[591] = wfWAFRule::create($this, 591, NULL, 'privesc', '100', 'WCFM Membership – WooCommerce Memberships for Multivendor Marketplace <= 2.10.7 - Unauthenticated Insecure Direct Object Reference to Arbitrary User Password Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.10.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wc-multivendor-membership'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wcfm_ajax_controller', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/member_id/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wcfm_membership_registration_form'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/user_email/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wcfm_membership_registration_form'), array (
))))));
$this->rules[592] = wfWAFRule::create($this, 592, NULL, 'auth-bypass', '100', 'BP Social Connect <= 1.5 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.5', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'bp-social-connect'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'bp_social_connect_facebook_login', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))));
$this->rules[593] = wfWAFRule::create($this, 593, NULL, 'insufficient-auth', '100', 'TheGem < 5.8.1.1 - Missing Authorization', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'thegem_theme_options_api', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[595] = wfWAFRule::create($this, 595, NULL, 'privesc', '100', 'WAF-RULE-595', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.1.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'userpro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'userpro_fbconnect', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[600] = wfWAFRule::create($this, 600, NULL, 'auth-bypass', '100', 'BookIt <= 2.3.7 - Authentication Bypass', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.3.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'bookit'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '72477b7978287d4a0161d5ee79b95027', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '0c83f57c786a0b4a39efab23731c7ebc'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '0c83f57c786a0b4a39efab23731c7ebc'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[601] = wfWAFRule::create($this, 601, NULL, 'file_upload', '100', 'Unlimited Elements For Elementor (Free Widgets, Addons, Templates) <= 1.5.60 - Arbitrary File Upload in File Manager', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'unlimitedelements_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#^assets_#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'client_action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'client_action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[602] = wfWAFRule::create($this, 602, NULL, 'auth-bypass', '100', 'Wordapp <= 1.5.0 - Authorization Bypass through Use of Insufficiently Unique Cryptographic Signature', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.5.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wordapp'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '8df4dd8336c5c15d097e9d20eb0e060d', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', 'c81e728d9d4c2f636f067f89cc14862c', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '8d777f385d3dfec8815d20f7496026dc', '11d8c28a64490a987612f2332502467f'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '8d777f385d3dfec8815d20f7496026dc', '8d777f385d3dfec8815d20f7496026dc', '649b92cd2814a1c763883483020f1ccd'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '8d777f385d3dfec8815d20f7496026dc', '8d777f385d3dfec8815d20f7496026dc', '56f87754b90c41110339186644d71add'), array (
))))));
$this->rules[605] = wfWAFRule::create($this, 605, NULL, 'insufficient-auth', '100', 'Formidable Forms <= 6.3 - Authenticated (Subscriber+) Arbitrary Plugin Installation and Activation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#frm-admin/v1/install-addon#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[606] = wfWAFRule::create($this, 606, NULL, 'insufficient-auth', '100', 'Jetpack <= 12.1 - Authenticated (Author+) Arbitrary File Manipulation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '12.1.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'jetpack'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/xmlrpc\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#https:\\/\\/public-api\\.wordpress\\.com\\/rest\\/v\\d+(\\.\\d+)?\\/sites\\/\\d+\\/media\\/\\d+/edit#i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[607] = wfWAFRule::create($this, 607, NULL, 'idor', '100', 'SP Project & Document Manager <= 4.67 - Authenticated (Subscriber+) Insecure Direct Object Reference to Arbitrary User Password Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.67', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'sp-client-document-manager'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', 'f019630bf1a756ccbd108090402e3c19', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '0c83f57c786a0b4a39efab23731c7ebc'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '7c6a180b36896a0a8c02787eeafb0e4c'), array (
))))));
$this->rules[608] = wfWAFRule::create($this, 608, NULL, 'idor', '100', 'LearnDash LMS <= 4.6.0 - Authenticated (Subscriber+) Insecure Direct Object Reference to Arbitrary User Password Change', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.6.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'sfwd-lms'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '13ac4273dc853636a2413f2d70b438ff'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '62a0b91a9b98a7ec19f27e42c13de207'), array (
))))));
$this->rules[610] = wfWAFRule::create($this, 610, NULL, 'file_upload', '100', 'User Registration <= 3.0.2 - Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.0.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'user-registration'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'md5Equals', '6afb15540df8394855f56b037a0ff083', array(wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '418c5509e2171d55b0aee5c2ea4442b5'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', 'e06f853092cefc99d84f72a056c378f8'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', '9bb151b69a6e2b82a60009e4b0a0e1d8'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[611] = wfWAFRule::create($this, 611, NULL, 'priv-esc', '100', 'tagDiv Cloud Library < 2.7 - Missing Authorization to Arbitrary User Metadata Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/tdb_user_form_on_submit/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(wp_capabilities|wp_user_level)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'formElements'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'td-cloud-library'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'manage_options', array())))));
$this->rules[612] = wfWAFRule::create($this, 612, NULL, 'options_update', '100', 'ProfileGrid <= 5.4.8 - Authenticated (Subscriber+) Arbitrary Option Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'pm_test_smtp', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[613] = wfWAFRule::create($this, 613, NULL, 'priv-esc', '100', 'WP Post Author <= 3.3.0 - Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/aft-wp-post-author\\/v1\\/set-user-data/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[614] = wfWAFRule::create($this, 614, NULL, 'priv-esc', '100', 'Ultimate Member <= 2.6.6 - Privilege Escalation via Arbitrary User Meta Updates', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'form_id', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/.*/',
    2 => '/administrator/i',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/.*/',
    2 => '/administrator/i',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/.*/',
    2 => '/shop_manager/i',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/.*/',
    2 => '/shop_manager/i',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keymatches', '#_\\\\*c\\\\*a\\\\*p\\\\*a\\\\*b\\\\*i\\\\*l\\\\*i\\\\*t\\\\*i\\\\*e\\\\*s\\\\*#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keymatches', '#u\\\\*s\\\\*e\\\\*r\\\\*_\\\\*l\\\\*e\\\\*v\\\\*e\\\\*l#', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[615] = wfWAFRule::create($this, 615, NULL, 'bypass', '100', 'Atarim - Client Interface <= 3.9.1 - Missing Authorization via AJAX actions', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'avc_send_invitations', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'avc_delete_invitations', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[616] = wfWAFRule::create($this, 616, NULL, 'priv-esc', '100', 'HT Mega – Absolute Addons for Elementor <= 2.2.0 - Missing Authorization to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'htmega_ajax_register', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_htmega_ajax_register', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'reg_role'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'reg_role'), array (
))))));
$this->rules[617] = wfWAFRule::create($this, 617, NULL, 'priv-esc', '100', 'Booking Package <= 1.5.98 - Authorization Bypass to Arbitrary Password Reset', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.5.98', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'booking-package'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp\\-content/plugins/booking\\-package/ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'package_app_public_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'updateUser', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mode'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[618] = wfWAFRule::create($this, 618, NULL, 'priv-esc', '100', 'WP Project Manager <= 2.6.4 - Arbitrary Usermeta Update to Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.6.3', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wedevs-project-manager'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/pm/v2/save_users_map_name#', array(wfWAFRuleComparisonSubject::create($this, array('request.md5Body', 'c98d48a702d2fb75df0353af9c222655'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.md5QueryString', 'c98d48a702d2fb75df0353af9c222655'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[619] = wfWAFRule::create($this, 619, NULL, 'ssrf', '100', 'Spectra <= 2.6.6 - Authenticated (Contributor+) Server-Side Request Forgery in template_importer and import_wpforms', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'ast_block_templates_importer', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'api_uri'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'api_uri'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'ast_block_templates_import_wpforms', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wpforms_url'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'wpforms_url'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[620] = wfWAFRule::create($this, 620, NULL, 'priv-esc', '100', 'Ultimate Member <= 2.6.6 - Privilege Escalation via Arbitrary User Meta Updates via API', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.6.6', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'ultimate-member'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'update.user', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'um-api'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'um-api'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'delete.user', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'um-api'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'um-api'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[622] = wfWAFRule::create($this, 622, NULL, 'priv-esc', '100', 'BAN Users <= 1.5.3 - Missing Authorization to Authenticated (Subscriber+) Settings Update & Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'w3dev_toggle_ban_user', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'user_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'user_id'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'w3dev_save_ban_user_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[624] = wfWAFRule::create($this, 624, NULL, 'ssrf', '100', 'Avada <= 7.11.1 - Authenticated(Contributor+) Server Side Request Forgery', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '7.11.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'Avada'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'fusion_panel_import', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#//((0|127|10|172|192|169|100)\\.|localhost)#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'toUrl'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'toUrl'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))));
$this->rules[625] = wfWAFRule::create($this, 625, NULL, 'file_upload', '100', 'Avada <= 7.11.1 - Authenticated(Author+) Arbitrary File Upload via Zip Extraction', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '7.11.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'Avada'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\.zip($|\\.)#i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[626] = wfWAFRule::create($this, 626, NULL, 'information-disclosure', '100', 'Post Grid <= 2.2.50 - Missing Authorization to Sensitive Information Exposure via REST API', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.2.51', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'post-grid'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/post-grid\\/v2\\/(?!(loggedout_current_user|get_posts)\\b).+/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[627] = wfWAFRule::create($this, 627, NULL, 'obji', '100', 'WAF-RULE-627', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/essential-blocks[\\/]+v1[\\/]+(queries|products)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#(?:O|C)\\:+\\d+\\:#', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'query_data'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'attributes'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'query_data'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'attributes'), array (
))))));
$this->rules[628] = wfWAFRule::create($this, 628, NULL, 'priv-esc', '100', 'JupiterX Core <= 3.3.8 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.3.8', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'jupiterx-core'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'jupiterx-facebook-social-login'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'jupiterx-facebook-social-login'), array (
)))))));
$this->rules[629] = wfWAFRule::create($this, 629, NULL, 'rce', '100', 'Media Library Assistant <= 3.09 - Unauthenticated Local/Remote File Inclusion & Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '3.10', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'media-library-assistant'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#media-library-assistant\\/includes\\/mla\\-stream\\-image\\.php#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
))))));
$this->rules[631] = wfWAFRule::create($this, 631, NULL, 'privesc', '100', 'WPvivid Backup Plugin <= 0.9.90 - Missing Authorization via start_staging and get_staging_progress', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpvividstg_start_staging_free', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wpvividstg_get_staging_progress_free', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[632] = wfWAFRule::create($this, 632, NULL, 'auth-bypass', '100', 'MultiVendorX <= 4.0.25 - Improper Authorization on REST Routes via save_settings_permission', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/mvx_module/v1/#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[634] = wfWAFRule::create($this, 634, NULL, 'spam', '100', 'Super Store Finder <= 6.9.2 - Unauthenticated Email Creation/Sending', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\/superstorefinder\\-wp\\/sendMail\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[635] = wfWAFRule::create($this, 635, NULL, 'auth-bypass', '100', 'Social Media Share Buttons & Social Sharing Icons <= 2.8.5 - Information Exposure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'sfsi_save_export', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[636] = wfWAFRule::create($this, 636, NULL, 'rce', '100', 'Allow PHP in Posts and Pages <= 3.0.4 - Authenticated (Subscriber+) Remote Code Execution via Shortcode', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#\\[(php|allowphp)#i', array(wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[638] = wfWAFRule::create($this, 638, NULL, 'insufficient-auth', '100', 'AI ChatBot <= 4.8.9 - Missing Authorization on Various AJAX', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'qcld_openai_delete_training_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'qcld_openai_upload_pagetraining_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_file_upload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_file_list', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_file_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_finetune_list', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_ft_model_create', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_ft_model_delete', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'openai_file_dowload', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[639] = wfWAFRule::create($this, 639, NULL, 'file_upload', '100', 'Dropshipping & Affiliation with Amazon <= 2.1.2 - Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'wpas_import_product_from_amazon', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[640] = wfWAFRule::create($this, 640, NULL, 'auth-bypass', '100', 'WordPress Core < 6.3.2 - Authenticated (Subscriber+) Arbitrary Shortcode Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'parse-media-shortcode', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^\\[(audio|embed|playlist|video|gallery)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
))))));
$this->rules[644] = wfWAFRule::create($this, 644, NULL, 'insufficient-auth', '100', '10Web Booster <= 2.24.14 - Unauthenticated Arbitrary Option Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(two_init_flow_score|nopriv_two_init_flow_score|activate_score_check|nopriv_activate_score_check)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[645] = wfWAFRule::create($this, 645, NULL, 'priv-esc', '100', 'MStore API <= 4.10.7 - Unauthorized Account Access and Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.10.7', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'mstore-api'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\/api\\/+flutter_user\\/apple_login#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[646] = wfWAFRule::create($this, 646, NULL, 'priv-esc', '100', 'WooODT Lite <= 2.4.6 - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'byconsolewooodt_admin_fields_setting_files', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[648] = wfWAFRule::create($this, 648, NULL, 'priv-esc', '100', 'WP Courses LMS <= 3.2.3 - Missing Authorization to Authenticated (Subscriber+) Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'save_fe_option', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[649] = wfWAFRule::create($this, 649, NULL, 'file-download', '100', 'Backup Migration <= 1.3.6 - Unauthenticated Arbitrary File Download to Sensitive Information Exposure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'BMI_BACKUP', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'backup-migration'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'backup-id', array(wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[650] = wfWAFRule::create($this, 650, NULL, 'whitelist', '100', 'wp-autoload.php backdoor', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\-autoload\\.php#', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'pass', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'keyExists', 'bypass', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)))))));
$this->rules[651] = wfWAFRule::create($this, 651, NULL, 'xss', '100', 'WAF-RULE-651', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'meta', '_uag_custom_page_level_css'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[652] = wfWAFRule::create($this, 652, NULL, 'rce', '100', 'WAF-RULE-652', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/includes/backup-heart.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[653] = wfWAFRule::create($this, 653, NULL, 'rce', '100', 'WordPress Core 6.4-6.4.1 - Remote Code Execution POP Chain via Object Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|;|{|})(?:O|C):\\d+:"WP_HTML_Token/i', array(wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.cookies', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.queryString', array (
)),
wfWAFRuleComparisonSubject::create($this, 'request.rawBody', array (
))))));
$this->rules[654] = wfWAFRule::create($this, 654, NULL, 'file_upload', '100', 'Elementor <= 3.18.1 - Authenticated(Contributor+) File Upload via Template Import', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '3.18.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'elementor'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#import_template#i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[655] = wfWAFRule::create($this, 655, NULL, 'insufficient-auth', '100', 'OMGF | GDPR/DSGVO Compliant, Faster Google Fonts. Easy. <= 5.7.6 - Missing Authorization to Unauthenticated Directory Deletion and Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'omgf-update', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[657] = wfWAFRule::create($this, 657, NULL, 'priv-esc', '100', 'Smart Forms <= 2.6.84 - Missing Authorization to Authenticated (Subscriber+) Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'rednao_smart_forms_save_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[658] = wfWAFRule::create($this, 658, NULL, 'priv-esc', '100', 'Cookie Information | Free GDPR Consent Solution <= 2.0.22 - Authenticated (Subscriber+) Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThan', '2.0.23', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-gdpr-compliance'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wpgdprc_update_integration', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[660] = wfWAFRule::create($this, 660, NULL, 'rce', '100', 'Unlimited Elements for Elementor <= 1.5.88 - Authenticated(Contributor+) Remote Code Execution via template import', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'unitecreator_elementor_import_template', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[661] = wfWAFRule::create($this, 661, NULL, 'auth-bypass', '100', 'POST SMTP Mailer – Email log, Delivery Failure Notifications and Best Mail SMTP for WordPress <= 2.8.6 - Authorization Bypass via type connect-app API', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/post-smtp/v1/connect-app#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthLessThan', '1', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Auth-Key'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Auth-Key'), array (
)))))));
$this->rules[663] = wfWAFRule::create($this, 663, NULL, 'xss', '100', 'Generic XSS in Custom Meta', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'meta'), array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/\\[\\d+\\]/',
    2 => '/value/',
  ),
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'meta'), array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/\\[\\d+\\]/',
    2 => '/key/',
  ),
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[664] = wfWAFRule::create($this, 664, NULL, 'traversal', '100', 'Directory Traversal via HTTP Headers', 1, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\)\\.\\.(\\\\|\\/)/', array(wfWAFRuleComparisonSubject::create($this, 'request.headers', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[665] = wfWAFRule::create($this, 665, NULL, 'rce', '100', 'File Manager Pro <= 8.3.4 - Authenticated(Subscriber+) Remote Code Execution via mk_check_filemanager_php_syntax', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'mk_check_filemanager_php_syntax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-content/uploads/fm_temp\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))));
$this->rules[666] = wfWAFRule::create($this, 666, NULL, 'xss', '100', 'WP Meta SEO <= 4.5.12 - Unauthenticated Stored Cross-Site Scripting via Referer header', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.5.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wp-meta-seo'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Referer'), array (
))))));
$this->rules[668] = wfWAFRule::create($this, 668, NULL, 'xss', '100', 'Popup Builder <= 4.2.2 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'keyExists', 'sgpb-ShouldOpen', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'keys'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'administrator', array())));
$this->rules[669] = wfWAFRule::create($this, 669, NULL, 'insufficient-auth', '100', 'ColorMag <= 3.1.2 - Missing Authorization to Arbitrary Plugin Installation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '3.1.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'colormag'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'install_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'activate_plugin', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[670] = wfWAFRule::create($this, 670, NULL, 'hook-injection', '100', 'WAF-RULE-670', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.0.8', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'check-email'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'check-email-action', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
))))));
$this->rules[671] = wfWAFRule::create($this, 671, NULL, 'hook-injection', '100', 'WAF-RULE-671', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.4.8', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'email-log'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#/wp-admin/#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'keyExists', 'el-action', array(wfWAFRuleComparisonSubject::create($this, 'request.body', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'notEquals', 'el-download-system-info', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el_license_activate', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el_license_deactivate', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el_bundle_license_activate', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el_bundle_license_deactivate', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el-log-list-export', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el-log-list-export-all', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'el-export-logs-with-columns', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'el-action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[672] = wfWAFRule::create($this, 672, NULL, 'sqli', '100', 'Ultimate Member – User Profile, Registration, Login, Member Directory, Content Restriction & Membership Plugin 2.1.3 - 2.8.2 - Unauthenticated SQL Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'um_get_members', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^[a-z_-]*$/ix', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'sorting'), array (
))))));
$this->rules[673] = wfWAFRule::create($this, 673, NULL, 'insufficient-auth', '100', 'SlimStat Analytics <= 5.1.3 - Authenticated (Subscriber+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'slimstat_manage_filters', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[674] = wfWAFRule::create($this, 674, NULL, 'file_upload', '100', 'WAF-RULE-674', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.2.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'wemanage-app-worker'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+wc[\\/]+v3[\\/]+upload-csv-file/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wc[\\/]+v3[\\/]+upload-csv-file/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[675] = wfWAFRule::create($this, 675, NULL, 'insufficient-auth', '100', 'LeadConnector <= 1.7 - Missing Authorization to Unauthenticated Arbitrary Post Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+lc_public_api[\\/]+v1[\\/]+proxy/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/lc_public_api[\\/]+v1[\\/]+proxy/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wp_delete_post', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'endpoint'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'endpoint'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'currentUserIsNot', 'editor', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
)))))));
$this->rules[676] = wfWAFRule::create($this, 676, NULL, 'information-disclosure', '100', 'Page Builder Sandwich – Front End WordPress Page Builder Plugin <= 5.1.0 - Sensitive Information Exposure', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'pbs_inspector_dropdown_db', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[677] = wfWAFRule::create($this, 677, NULL, 'rce', '100', 'Bricks <= 1.9.6 - Unauthenticated Remote Code Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.9.6', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'bricks'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+bricks[\\/]+v1[\\/]+render_element/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/bricks[\\/]+v1[\\/]+render_element/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'bricks_render_element', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'code', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'element', 'name'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'element', 'name'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'element', 'settings', 'code'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'element', 'settings', 'code'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'element', 'settings', 'executeCode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'element', 'settings', 'executeCode'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[678] = wfWAFRule::create($this, 678, NULL, 'file_upload', '100', 'WAF-RULE-678', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wpr_addons_upload_file', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\.(xml|svgz)($|\\.)/i', array(wfWAFRuleComparisonSubject::create($this, 'request.fileNames', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[679] = wfWAFRule::create($this, 679, NULL, 'rce', '100', 'Bricks <= 1.9.6 - Unauthenticated Remote Code Execution via queryEditor', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.9.6', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'bricks'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+bricks[\\/]+v1[\\/]+render_element/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/bricks[\\/]+v1[\\/]+render_element/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'bricks_render_element', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'loopElement', 'settings', 'query', 'useQueryEditor'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'loopElement', 'settings', 'query', 'useQueryEditor'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'loopElement', 'settings', 'query', 'queryEditor'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'loopElement', 'settings', 'query', 'queryEditor'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[680] = wfWAFRule::create($this, 680, NULL, 'file_upload', '100', 'Addon Library <= 1.3.76 - Missing Authorization to Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'unitecreator_ajax_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[681] = wfWAFRule::create($this, 681, NULL, 'priv-esc', '100', 'RegistrationMagic – Custom Registration Forms, User Registration, Payment, and User Login <= 5.2.6.0 - Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'rm_update_users_role', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[682] = wfWAFRule::create($this, 682, NULL, 'priv-esc', '100', 'Malware Scanner <= 4.7.2 - Unauthenticated Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'mo_wpns_change_password', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'option'), array (
))))));
$this->rules[684] = wfWAFRule::create($this, 684, NULL, 'priv-esc', '100', 'User Registration – Custom Registration Form, Login Form, and User Profile WordPress Plugin <= 3.1.5 - Missing Authorization to Authenticated (Subscriber+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'user_registration_form_save_action', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[685] = wfWAFRule::create($this, 685, NULL, 'file_upload', '100', 'WAF-RULE-685', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '0.1.0.20', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'instawp-connect'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+instawp-connect[\\/]+v1[\\/]+config/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/instawp-connect[\\/]+v1[\\/]+config/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'override_plugin_zip'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'override_plugin_zip'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[686] = wfWAFRule::create($this, 686, NULL, 'insufficient-auth', '100', 'WAF-RULE-686', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+fluentform[\\/]+v1[\\/]+global-settings/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+fluentform[\\/]+v1[\\/]+managers/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/fluentform[\\/]+v1[\\/]+global-settings/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/fluentform[\\/]+v1[\\/]+managers/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[687] = wfWAFRule::create($this, 687, NULL, 'insufficient-auth', '100', 'Responsive <= 5.0.2 - Missing Authorization to HTML Injection', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.0.1', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.themes', 'responsive'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'save_footer_text', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'footer_text'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[688] = wfWAFRule::create($this, 688, NULL, 'xss', '100', 'Forminator – Contact Form, Payment Form & Custom Form Builder <= 1.29.2 - Authenticated (Contributor+) Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '1.29.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'forminator'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+posts#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[forminator_form#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#\\[forminator_form#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'shortcode'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array())));
$this->rules[690] = wfWAFRule::create($this, 690, NULL, 'priv-esc', '100', 'PowerPack Pro for Elementor <= 2.10.17 - Authenticated (Contributor+) Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/admin\\-ajax\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', 'pp-registration-form', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'contains', 'user_role', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'actions'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'actions'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'elementor_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[691] = wfWAFRule::create($this, 691, NULL, 'sqli', '100', 'Visualizer: Tables and Charts Manager for WordPress <= 3.10.15 - Missing Authorization to Arbitrary SQL Execution', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'visualizer-fetch-db-data', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'params', 'query'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[692] = wfWAFRule::create($this, 692, NULL, 'options_update', '100', 'WP Datepicker <= 2.1.0 - Missing Authorization to Authenticated (Subscriber+) Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wpdp_add_new_datepicker_ajax', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'wpdp_form_data'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[693] = wfWAFRule::create($this, 693, NULL, 'lfi', '100', 'WAF-RULE-693', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'yotu_pagination', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/(^|(\\%2F)|(\\%5C))\\.\\.((\\%2F)|(\\%5C))/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'settings'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/(^|\\/|\\\\)\\.\\.(\\\\|\\/)/', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'settings'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
)))))));
$this->rules[696] = wfWAFRule::create($this, 696, NULL, 'sqli', '100', 'Email Subscribers by Icegram Express <= 5.7.20 - Unauthenticated SQL Injection via hash', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'optin', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'es'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'es'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'unsubscribe', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'es'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'es'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'hash'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
  1 => 
  array (
    0 => 'json',
  ),
)), 'list_ids'), array (
)),
wfWAFRuleComparisonSubject::create($this, array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'hash'), array (
  0 => 
  array (
    0 => 'base64decode',
  ),
  1 => 
  array (
    0 => 'json',
  ),
)), 'list_ids'), array (
))))));
$this->rules[697] = wfWAFRule::create($this, 697, NULL, 'priv-esc', '100', 'WAF-RULE-697', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.7.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'tutor-pro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'tutor_pro_social_authentication', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))));
$this->rules[698] = wfWAFRule::create($this, 698, NULL, 'insufficient-auth', '100', 'WAF-RULE-698', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.7.0', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'tutor-pro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/(?:tutor_)(?:content_drip_state_update|enrollment_bulk_action|search_students|gc_credential_save|gc_class_action|google_meet_reset_cred|admin_student_list_bulk_action)|(?:quiz_)(?:export_data|import_data)|save_email_template|send_test_email_ajax|import_bulk_student/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[699] = wfWAFRule::create($this, 699, NULL, 'sqli', '100', 'WAF-RULE-699', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'ig_es_do_import', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'matchCount', new wfWAFRuleVariable($this, 'sqliRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'options', 'list_id'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'options', 'list_id'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[700] = wfWAFRule::create($this, 700, NULL, 'insufficient-auth', '100', 'WAF-RULE-700', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+instawp-connect[\\/]+v1[\\/]+config/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/instawp-connect[\\/]+v1[\\/]+config/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[701] = wfWAFRule::create($this, 701, NULL, 'options_update', '100', 'XootiX Framework <= Various Plugin Versions - Missing Authorization to Arbitrary Options Update', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/xoo_admin_settings_(?:import|export)/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[702] = wfWAFRule::create($this, 702, NULL, 'file_upload', '100', 'Modern Events Calendar <= 7.10.0 - Authenticated (Subscriber+) Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'mec_fes_form', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mec', 'featured_image'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notMatch', '/^(?!:.*\\.[^.]+\\.)(?:[^.]+)\\.(png|gif|jpg|jpeg|jif|jfif)$/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'mec', 'featured_image'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[703] = wfWAFRule::create($this, 703, NULL, 'xss', '100', 'Easy Pixels by JEVNET <= 2.13 - Unauthenticated Stored Cross-Site Scripting', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'identical', '', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'epform'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'epform'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[704] = wfWAFRule::create($this, 704, NULL, 'insufficient-auth', '100', 'WordPress Header Builder Plugin – Pearl <= 1.3.7 - Missing Authorization to Unauthenticated Arbitrary Site Options Deletion', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'delete_hb'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'hb'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'hb'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[705] = wfWAFRule::create($this, 705, NULL, 'insufficient-auth', '100', 'WAF-RULE-705', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '2.7.2', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'tutor-pro'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/treport_quiz_atttempt_delete|tutor_gc_class_action|tutor_admin_student_list_bulk_action/', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[706] = wfWAFRule::create($this, 706, NULL, 'xss', '100', 'WAF-RULE-706', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+userfeedback[\\/]+v1[\\/]+surveys[\\/]+(?:\\d+)[\\/]+responses/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/userfeedback[\\/]+v1[\\/]+surveys[\\/]+(?:\\d+)[\\/]+responses/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', new wfWAFRuleVariable($this, 'xssRegex', NULL), array(wfWAFRuleComparisonSubject::create($this, 'request.jsonBody', array (
  0 => 
  array (
    0 => 'filterKeys',
    1 => '/answers/',
    2 => '/\\d+/',
    3 => '/extra/',
    4 => '/name/',
  ),
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserCannot', 'unfiltered_html', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[707] = wfWAFRule::create($this, 707, NULL, 'file_upload', '100', 'Keydatas <= 2.5.2 - Unauthenticated Arbitrary File Upload', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'post', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', '__kds_flag'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'keydatas.com', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'kds_password'), array (
))))));
$this->rules[708] = wfWAFRule::create($this, 708, NULL, 'insufficient-auth', '100', 'EventON <= 2.2.15 - Missing Authorization to Unauthenticated Stored Cross-Site Scripting and Plugin Settings Updates', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'eventon_import_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'nopriv_eventon_import_settings', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[710] = wfWAFRule::create($this, 710, NULL, 'rce', '100', 'WAF-RULE-710', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.6.11', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'sitepress-multilingual-cms'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '#wp\\/+v2\\/+posts#i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#/wp\\-admin/post\\.php$#i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '#\\[wpml_language_(?:switcher|selector_widget|selector_footer)#', array(wfWAFRuleComparisonSubject::create($this, array('request.jsonBody', 'content'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'content'), array (
))))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#\\[wpml_language_(?:switcher|selector_widget|selector_footer)#', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'shortcode'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'shortcode'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[711] = wfWAFRule::create($this, 711, NULL, 'rce', '100', 'WAF-RULE-711', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'createTable', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wtbp', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'pl'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'pl'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'wootablepress', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'mod'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'mod'), array (
))))));
$this->rules[712] = wfWAFRule::create($this, 712, NULL, 'auth-bypass', '100', 'WAF-RULE-712', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '4.14.6', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'mstore-api'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+api[\\/]+flutter_user[\\/]+firebase_sms_login(?:_v2)?/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/api[\\/]+flutter_user[\\/]+firebase_sms_login(?:_v2)?/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
)))))));
$this->rules[713] = wfWAFRule::create($this, 713, NULL, 'auth-bypass', '100', 'InstaWP Connect – 1-click WP Staging & Migration <= 0.1.0.44 - Authentication Bypass to Admin', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '0.1.0.43', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'instawp-connect'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'true', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'success'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'success'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'lengthGreaterThan', '0', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'access_token'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'access_token'), array (
))))));
$this->rules[714] = wfWAFRule::create($this, 714, NULL, 'insufficient-auth', '100', 'FULL <= 3.1.12 - Unauthenticated Stored Cross-Site Scripting via License Plan Parameter', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'match', '/wp-json[\\/]+full-customer[\\/]+license/i', array(wfWAFRuleComparisonSubject::create($this, 'request.path', array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '/full-customer[\\/]+license/i', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'rest_route'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'rest_route'), array (
))))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'currentUserIsNot', 'administrator', array(wfWAFRuleComparisonSubject::create($this, 'server.empty', array (
))))));
$this->rules[716] = wfWAFRule::create($this, 716, NULL, 'priv-esc', '100', 'ProfileGrid – User Profiles, Groups and Communities <= 5.8.9 - Authenticated (Subscriber+) Authorization Bypass to Privilege Escalation', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'versionLessThanEqualTo', '5.8.9', array(wfWAFRuleComparisonSubject::create($this, array('wordpress.plugins', 'profilegrid-user-profiles-groups-and-communities'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'match', '/\\/wp\\-admin[\\/]+admin\\-ajax\\.php/i', array(wfWAFRuleComparisonSubject::create($this, 'server.script_filename', array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'pm_upload_image', array(wfWAFRuleComparisonSubject::create($this, array('request.queryString', 'action'), array (
)),
wfWAFRuleComparisonSubject::create($this, array('request.body', 'action'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'notEquals', 'pm_cover_image', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'user_meta'), array (
)))), new wfWAFRuleLogicalOperator('AND'), new wfWAFRuleComparison($this, 'equals', 'save', array(wfWAFRuleComparisonSubject::create($this, array('request.body', 'status'), array (
))))));
$this->rules[307] = wfWAFRule::create($this, 307, NULL, 'brute-force', '100', 'Known malicious User-Agents', 0, 'block', new wfWAFRuleComparisonGroup(new wfWAFRuleComparison($this, 'equals', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#mozlila#i', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#^anonymousfox#i', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'Referer'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'wp_is_mobile', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ALittle Client', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'equals', 'ALittleClient', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
)))), new wfWAFRuleLogicalOperator('OR'), new wfWAFRuleComparison($this, 'match', '#colonel#i', array(wfWAFRuleComparisonSubject::create($this, array('request.headers', 'User-Agent'), array (
))))));
?>