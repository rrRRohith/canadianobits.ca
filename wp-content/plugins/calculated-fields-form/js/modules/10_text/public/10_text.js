/*
* text.js v0.1
* By: CALCULATED FIELD PROGRAMMERS
* Includes operations to interact with Texts
* Copyright 2022 CODEPEOPLE
*/

;(function(root){
	var lib = {};

	/*** PUBLIC FUNCTIONS ***/

	if(window.WORDSCOUNTER == undefined) {
        lib.WORDSCOUNTER = lib.wordscounter = function(text){
            try {
                return text.replace(/(?!\w|\s)./g, '')
                            .replace(/\s+/g, ' ')
                            .replace(/^(\s*)([\W\w]*)(\b\s*$)/g, '$2')
                            .split(' ').length;
            } catch (err) {
                return 0;
            }
        }
    }

    if(window.CHARSCOUNTER == undefined) {
        lib.CHARSCOUNTER = lib.charscounter = function(text, ignore_blank){
            try {
                var ignore_blank = ignore_blank || 0;
                text += '';
                if ( ignore_blank ) text = text.replace( /[\s\r\n\t]/g, '');
                return text.length;
            } catch (err) {
                return 0;
            }
        }
    }

    if(window.INTEXT == undefined) {
        lib.INTEXT = lib.intext = function(term, text, case_insensitive){
            try {
                var case_insensitive = case_insensitive || 0;
                if( ! term instanceof RegExp ) term += '';
                text += '';
                if ( case_insensitive ) {
                    if( term instanceof RegExp ) term = new RegExp( term.source, 'i' );
                    else term = term.toLowerCase();
                    text = text.toLowerCase();
                }
                return Math.max(text.split(term).length - 1, 0);
            } catch (err) {
                return 0;
            }
        }
    }

    root.CF_TEXT = lib;

})(this);