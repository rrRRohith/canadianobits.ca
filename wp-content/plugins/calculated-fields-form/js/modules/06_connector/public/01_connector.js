/*
* connector.js v0.1
* By: CALCULATED FIELD PROGRAMMERS
* Allows connecting with third party modules in the equations
* Copyright 2019 CODEPEOPLE
*/

;(function(root){
	var lib = {
		records: {}
	};

	/*** PRIVATE FUNCTIONS ***/

	/*** PUBLIC FUNCTIONS ***/

	lib.cff_connector_version = '0.1';

	// cffProxy( function ) The function should accept a callback
	lib.cffProxy = lib.cffproxy = lib.CFFPROXY = function(){
        if(typeof fbuilderjQuery == 'undefined' || !arguments.length || typeof arguments[0] != 'function') return;

		var $ 		= fbuilderjQuery,
			args	= Array.prototype.slice.call(arguments);
			index 	= args.toString();

		if(typeof lib.records[index] != 'undefined') return lib.records[index];
		var	form_id = (typeof $.fbuilder['currentFormId'] != 'undefined') ? $.fbuilder['currentFormId'] : 'cp_calculatedfieldsf_pform_1',
			aux	= (function(eq, index){
				return function(value){
					lib.records[index] = value;
					$.fbuilder.calculator.enqueueEquation(eq.identifier, [eq]);
					$.fbuilder.calculator.removePending(eq.identifier);
					if(
                        !(eq.identifier in $.fbuilder.calculator.processing_queue) ||
                        !$.fbuilder.calculator.processing_queue[eq.identifier]
                    )
					{
						$.fbuilder.calculator.processQueue(eq.identifier);
					}
				};
			})($.fbuilder['currentEq'], index),
			f = args[0];

		args.shift();
		args.push(aux);
		$.fbuilder.calculator.addPending($.fbuilder['currentEq']['identifier']);
        setTimeout(function(){f.apply(null, args);},5);
	};

	root.CF_CONNECTOR = lib;

})(this);