fbuilderjQuery = (typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'text' ] = {
	'tutorial' : 'https://cff.dwbooster.com/documentation#text-module',
	'toolbars'		: {
		'text' : {
			'label' : 'Text Operations',
			'buttons' : [
                {
                    "value" : "WORDSCOUNTER",
                    "code" : "WORDSCOUNTER(",
                    "tip" : "<p><strong>WORDSCOUNTER(text)</strong></p><p>Returns the number of words in text.<br><br> Ex. <strong>WORDSCOUNTER(fieldname123|r);</strong></p>"
                },
                {
                    "value" : "CHARSCOUNTER",
                    "code" : "CHARSCOUNTER(",
                    "tip" : "<p><strong>CHARSCOUNTER(text, ignore blank characters)</strong></p><p>Returns the number of characters in text. The second parameter allows ignoring blank characters in the text.<br><br> Ex. <strong>CHARSCOUNTER(fieldname123|r);</strong> or <strong>CHARSCOUNTER(fieldname123|r, true);</strong>.</p>"
                },
                {
                    "value" : "INTEXT",
                    "code" : "INTEXT(",
                    "tip" : "<p><strong>INTEXT(to search, text, case insensitive)</strong></p><p>Returns the number of times the word, character, phrase, or regular expression appears in the text. The search can be case-sensitive or case-insensitive (optional parameter, case-sensitive by default).<br><br> Ex. <strong>INTEXT(fieldname12|r, fieldname34|r);</strong> or <strong>INTEXT(fieldname12|r, fieldname34|r, true);</strong>.</p>"
                },

            ]
		}
	}
};