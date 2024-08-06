if(typeof $.fn['fbuilder_serializeObject'] == 'undefined')
{
	$.fn.fbuilder_serializeObject = function()
	{
	   var  o = {},
		 	a = this.serializeArray();

	   $.each(a, function() {
		   if(/^fieldname\d+_\d+(\[\])?$/.test(this.name)) this.name = this.name.match(/fieldname\d+/)[0];
		   else return;
		   if (o[this.name]) {
			   if (!o[this.name].push) {
				   o[this.name] = [o[this.name]];
			   }
			   o[this.name].push(this.value || '');
		   } else {
			   o[this.name] = this.value || '';
		   }
	   });
	   return o;
	};
}

$.fn.fbuilder_localstorage = function(){
	var form = this,
		id = form.attr('id'),
		sq = (typeof id == 'undefined') ? 1 : id.replace(/[^\d]/g,''),
		localStore_obj,
		fields;
	if(sq == '') sq = 1;
	localStore_obj = new $.fbuilder_localstorage(form, true);
	$(document).on('change', '#'+id+' *', function(evt){
		if(
			typeof this['id'] != 'undefined' &&
			/^fieldname\d+_\d+$/i.test(this.id) &&
			typeof this['value'] != 'undefined'
		)
		{
			localStore_obj.set_fields();
		}
	});
	form.on('submit', function(){localStore_obj.clear_fields();});
	fields = localStore_obj.get_fields();
	if(!$.isEmptyObject(fields))
	{
		if(typeof cpcff_default == 'undefined') cpcff_default = {};
		if(typeof cpcff_default[sq] == 'undefined') cpcff_default[sq] = {};
		cpcff_default[sq] = $.extend(cpcff_default[sq], fields);
	}
	return this;
}

$.fbuilder_localstorage = function(form, debug){
	this.form 		= form;
	this.id			= form.attr('id')+'_'+form.find('[name="cp_calculatedfieldsf_id"]').val();
	this.debug 		= (typeof debug != 'undefined' && debug) ? true : false;
};

$.fbuilder_localstorage.prototype = (function(){

	/** Private variables **/
	var is_available;

	/** Private functions **/
	function _log(mssg)
	{
		if(typeof console != 'undefined') console.log(mssg);
	};

	return {
		is_available : function() {
			if(typeof is_available != 'undefined') return is_available;
			try {
				var storage = window['localStorage'],
					x = '__storage_test__';
				storage.setItem(x, x);
				storage.removeItem(x);
				is_available = true;
				return true;
			}
			catch(e) {
				if(this.debug) _log( 'localStorage object is not available' );
				is_available = false;
				return e instanceof DOMException && (
					e.code === 22 ||
					e.code === 1014 ||
					e.name === 'QuotaExceededError' ||
					e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
					storage.length !== 0;
			}
		},

		get_fields : function(){
			try{
				if(typeof this.fields == 'undefined') this.fields = JSON.parse(localStorage.getItem(this.id));
				return this.fields;
			} catch(err) {
				_log( 'Error reading the fields.' );
				_log( err );
			}
		},

		set_fields : function(){
			try{
				this.fields = this.form.fbuilder_serializeObject();
				localStorage.setItem(this.id, JSON.stringify(this.fields));
			} catch(err) {
				_log( 'Error saving the fields.' );
				_log( err );
			}
		},

		clear_fields : function(){
			try{
				localStorage.removeItem(this.id);
			} catch(err) {
				_log( 'Error deleting the fields.' );
				_log( err );
			}
		}
	};
})();