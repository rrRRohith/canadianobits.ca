/*
* managing_fields.js v0.1
* By: CALCULATED FIELD PROGRAMMERS
* The script allows managing fields
* Copyright 2015 CODEPEOPLE
* You may use this project under MIT or GPL licenses.
*/

;(function(root){
	var lib = {};
	lib.cf_processing_version = '0.1';

	/*** PRIVATE FUNCTIONS ***/

	function _getForm(_form)
	{
		if(typeof _form == 'undefined'){
			if('currentFormId' in fbuilderjQuery.fbuilder) _form = fbuilderjQuery.fbuilder.currentFormId;
			else return '_1';
		}
		if(/^_\d*$/.test(_form)) return _form;
		if(/^\d*$/.test(_form)) return '_'+_form;
		return $((typeof _form == 'object') ? _form : '#'+_form).find('[name="cp_calculatedfieldsf_pform_psequence"]').val();
	}

	function _getField( _field, _form )
	{
        try
        {
            if(typeof _field == 'undefined') return false;
            if(typeof _field == 'object')
            {
                if('ftype' in _field) return _field;
                if('jquery' in _field)
                {
                    if(_field.length) _field = _field[0];
                    else return false;
                }

                if('getAttribute' in _field)
                {
                    _form  = $(_field).closest('form');
                    _field = _field.getAttribute('class').match(/fieldname\d+/)[0];
                }
                else return false;
            }
            return $.fbuilder['forms'][_getForm(_form)].getItem(_field);
        } catch (err) { return false; }
	}

	/*** PUBLIC FUNCTIONS ***/
    lib.getField = function(_field, _form)
    {
        return _getField(_field, _form);
    };

	lib.activatefield = lib.ACTIVATEFIELD = function( _field, _form )
	{
		var o = _getForm(_form), f = _getField(_field, _form), j;
		if(f)
		{
			j = f.jQueryRef();
            j.removeClass('ignorefield');
			if(j.find('[id*="'+f.name+'"]').hasClass('ignore'))
			{
                j.add(j.find('.fields')).show();
				if(f.name in $.fbuilder.forms[o].toHide) delete $.fbuilder.forms[o].toHide[f.name];
				if(!(f.name in $.fbuilder.forms[o].toShow)) $.fbuilder.forms[o].toShow[f.name] = {'ref': {}};
				j.find('[id*="'+f.name+'"]').removeClass('ignore').change();
				$.fbuilder.showHideDep({'formIdentifier':o,'fieldIdentifier':f.name});
			}
		}
	};

	lib.ignorefield = lib.IGNOREFIELD = function( _field, _form )
	{
		var o = _getForm(_form), f = _getField(_field, _form), j;
		if(f)
		{
			j = f.jQueryRef();
            j.addClass('ignorefield');
			if(!j.find('[id*="'+f.name+'"]').hasClass('ignore'))
			{
				j.add(j.find('.fields')).hide();
				if(!(f.name in $.fbuilder.forms[o].toHide)) $.fbuilder.forms[o].toHide[f.name] = {};
				if(f.name in $.fbuilder.forms[o].toShow) delete $.fbuilder.forms[o].toShow[f.name];
				j.find('[id*="'+f.name+'"]').addClass('ignore').change();
				$.fbuilder.showHideDep({'formIdentifier':o,'fieldIdentifier':f.name});
			}
		}
	};

    lib.showfield = lib.SHOWFIELD = function( _field, _form )
    {
        var f = _getField(_field, _form), j;
		if(f)
		{
			j = f.jQueryRef();
            if(!j.find('[id*="'+f.name+'"]').hasClass('ignore'))
                j.removeClass('hide-strong').show();
		}
    };

	lib.hidefield = lib.HIDEFIELD = function( _field, _form )
    {
        var f = _getField(_field, _form);
		if(f)
		{
            j = f.jQueryRef();
            if(!j.find('[id*="'+f.name+'"]').hasClass('ignore'))
                f.jQueryRef().addClass('hide-strong');
		}
    };

	lib.disableequations = lib.DISABLEEQUATIONS = function(f)
	{
		jQuery(f || '[id*="cp_calculatedfieldsf_pform_"]').attr('data-evalequations',0);
	};

	lib.enableequations = lib.ENABLEEQUATIONS = function(f)
	{
		jQuery(f || '[id*="cp_calculatedfieldsf_pform_"]').attr('data-evalequations',1);
	};

	lib.EVALEQUATIONS = lib.evalequations = function(f)
	{
		fbuilderjQuery.fbuilder.calculator.defaultCalc(f);
	};

	lib.EVALEQUATION = lib.evalequation = function( _field, _form )
	{
        try
        {
            /* For compatibility with function( _form, _field ) */
            if(typeof _field == 'object' && 'tagName' in _field && _field.tagName == 'FORM')
                [_field, _form] = [_form, _field];

            var c = fbuilderjQuery.fbuilder.calculator;

            if(typeof _field == 'undefined') c.defaultCalc(_form);

            var f = _getField(_field, _form),
                o = f.jQueryRef().closest('form')[0];

            for(i in o.equations)
            {
                if(o.equations[i].result == f.name){
                    c.enqueueEquation(f.form_identifier, [o.equations[i]]);
                    c.processQueue(f.form_identifier);
                    return;
                }
            }
        }
        catch(err){if('console' in window) console.log(err);}
    };


    lib.COPYFIELDVALUE = lib.copyfieldvalue = function(_field, _form)
    {
        var f = _getField(_field, _form), j;
		if(f)
		{
			j = f.jQueryRef().find(':input:eq(0)');
			if(j.length)
			{
                try
                {
                    j.select();
                    document.execCommand('copy');
                } catch(err){}
			}
		}
    };

    lib.gotopage = lib.GOTOPAGE = lib.goToPage = function(p, f)
    {
        try
        {
            var o = $('#'+$.fbuilder['forms'][_getForm(f)].formId), c;
            if(o.length)
            {
                c = o.find('.pbreak:visible').attr('page');
                $.fbuilder.goToPage({'form':o,'from':c,'to':p, 'forcing' : true});
            }
        } catch(err) { if(typeof console != 'undefined') console.log(err); }
    };

    lib.gotofield = lib.GOTOFIELD = lib.goToField = function(e, f)
    {
        try
        {
            var o = $('#'+$.fbuilder['forms'][_getForm(f)].formId), p, c;
			if(o.length)
            {
				e = o.find('[id*="'+(Number.isInteger(e) ? 'fieldname'+e : e)+'_"]');
				if(e.length)
				{
					c = o.find('.pbreak:visible').attr('page');
					p = e.closest('.pbreak').attr('page');
					$(document).one('cff-gotopage', function(evt, arg){
						if(e.is(':visible'))
							$('html,body').animate({scrollTop:e.offset().top});
					});
					$.fbuilder.goToPage({'form':o,'from':c,'to':p, 'forcing' : true});
				}
            }
        } catch(err) { if(typeof console != 'undefined') console.log(err); }
    };

    if(window.PRINTFORM == undefined)
    {
        lib.printform = lib.PRINTFORM = function(show_pages)
        {
            var o = $('#'+$.fbuilder['forms'][_getForm()].formId);
            if(o.length)
            {
                o.addClass('cff-print');
                if(!!show_pages) o.find('.pbreak').addClass('cff-print');
                while(o.length)
                {
                    o.siblings().addClass('cff-no-print');
                    o = o.parent();
                }
            }
            window.print();
            setTimeout(function(){
                jQuery('.cff-no-print').removeClass('cff-no-print');
                jQuery('.cff-print').removeClass('cff-print');
            }, 5000);
        };

    }
	root.CF_FIELDS_MANAGEMENT = lib;

})(this);