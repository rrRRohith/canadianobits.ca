jQuery(
	function(){
		window['cp_calculatedfieldsf_insertForm'] = function () {
			send_to_editor('[CP_CALCULATED_FIELDS]');
		};

		window['cp_calculatedfieldsf_insertVar'] = function() {
			send_to_editor('[CP_CALCULATED_FIELDS_VAR name=""]');
		};
	}
);