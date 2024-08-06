/*
* file.js v0.1
* By: CALCULATED FIELD PROGRAMMERS
* Includes operations to interact with the URLs and parameters
* Copyright 2020 CODEPEOPLE
*/

;(function(root){
	var lib = {
		records: {}
	};

	/*** PRIVATE FUNCTIONS ***/

    function eval_equation(eq)
    {
        $.fbuilder.calculator.enqueueEquation(eq.identifier, [eq]);
        $.fbuilder.calculator.removePending(eq.identifier);
        if(
            !(eq.identifier in $.fbuilder.calculator.processing_queue) ||
            !$.fbuilder.calculator.processing_queue[eq.identifier]
        ) $.fbuilder.calculator.processQueue(eq.identifier);
    }

	function _getField(fieldname, form)
    {
        var field = getField(fieldname, form);
        return (field && 'ftype' in field && field['ftype'] == 'ffile') ? field : false;
    }

    /*** PUBLIC FUNCTIONS ***/

	lib.cff_file_version = '0.1';

	// PDFPAGESNUMBER(fieldname, form) the form parameter is optional
	lib.PDFPAGESNUMBER = lib.pdfpagesnumber = function(fieldname, form){
        var field = _getField(fieldname, form), files, counter = 0, result = 0, index;
        if(field)
        {
            if(field.multiple) result = [];
            files = field.val(true);
            counter = files.length;
            if(counter)
            {
                index = 'PDFPAGESNUMBER:'+field.val();
                if(index in lib.records)
                {
                    result = lib.records[index];
                    /*delete lib.records[index];*/
                }
                else
                {
                    for(var i in files)
                    {
                        if(typeof files[i] == 'object')
                        {
                            var reader = new FileReader();
                            reader.onloadend = (function(eq, index, multiple){
                                return function(evt){
                                    var reader = evt.target;
                                    try{
                                        var tmp = reader.result.match(/\/Type[\s]*\/Page[^s]/g);
                                        if(multiple) result.push((tmp) ? tmp.length : 0);
                                        else result += (tmp) ? tmp.length : 0;
                                    } catch (err) {}
                                    counter--;
                                    if(counter == 0)
                                    {
                                        lib.records[index] = result;
                                        eval_equation(eq);
                                    }
                                };
                            })($.fbuilder['currentEq'], index, field.multiple)
                            reader.readAsBinaryString(files[i]);
                        }
                    }
                }
            }
        }
		return result;
	}

    // IMGDIMENSION(fieldname, form) the form parameter is optional
	lib.IMGDIMENSION = lib.imgdimension = function(fieldname, form){
        var field = _getField(fieldname, form), files, counter = 0, result = {width:0, height:0}, index;
        if(field)
        {
            if(field.multiple) result = [];
            files = field.val(true);
            counter = files.length;
            if(counter)
            {
                index = 'IMGDIMENSION:'+field.val();
                if(index in lib.records)
                {
                    result = lib.records[index];
                    /*delete lib.records[index];*/
                }
                else
                {
                    for(var i in files)
                    {
                        if(typeof files[i] == 'object')
                        {
                            if(files[i].type.match(/image.*/i))
                            {
                                var reader = new FileReader();
                                reader.onloadend = (function(eq, index, multiple){
                                    return function(evt){
                                        var reader = evt.target;
                                        try{
                                            var image = new Image();
                                            image.onload = function(){

                                                if(multiple) result.push({width:this.naturalWidth, height:this.naturalHeight});
                                                else result = {width:this.naturalWidth, height:this.naturalHeight};

                                                counter--;

                                                if(counter == 0)
                                                {
                                                    lib.records[index] = result;
                                                    eval_equation(eq);
                                                }
                                            };
                                            image.src = reader.result;
                                        } catch (err) {}
                                    };
                                })($.fbuilder['currentEq'], index, field.multiple)
                                reader.readAsDataURL(files[i]);
                            }
                            else counter--;
                        }
                    }
                }
            }
        }
		return result;
	}

    // VIEWFILE(fieldname, id, form) the form parameter is optional
	lib.VIEWFILE = lib.viewfile = function(fieldname, id, form){
        var field = _getField(fieldname, form), files, el = document.getElementById(id);
        if(field && el)
        {
            el.innerHTML = '';
            files = field.val(true);
            if(files.length)
            {
                for(var i in files)
                {
                    if(typeof files[i] == 'object')
                    {
                        var reader = new FileReader();
                        if(files[i].type.match(/image.*/i))
                        {
                            reader.onloadend = function(evt){
                                var reader = evt.target;
                                try{
                                    var img = document.createElement('img');
                                    img.classList.add('cff-image-viewer');
                                    img.src = reader.result;
                                    el.appendChild(img);
                                } catch (err) {}
                            };
                        }
                        else if(files[i].type.match(/pdf/i))
                        {
                            reader.onloadend = function(evt){
                                var reader = evt.target;
                                try{
                                    var iframe = document.createElement('iframe');
                                    iframe.classList.add('cff-pdf-viewer');
                                    iframe.src = reader.result;
                                    el.appendChild(iframe);
                                } catch (err) {}
                            };
                        }
                        reader.readAsDataURL(files[i]);
                    }
                }
            }
        }
	}

	// CSVTOJSON(fieldname, args, form) the ards, and form parameter are optional
	lib.CSVTOJSON = lib.csvtojson = function(fieldname, args, form){
        function parseLine(line) {
            var flag = false, parts = [], cell = '';
            for(var i = 0, h = line.length; i < h; i++){
                if(line[i] == args['quote']) {
                    if(!flag && (i==0 || line[i-1] != '\\')) flag = true;
                    else if(flag && line[i-1] != '\\') flag = false;
                } else if(line[i] == args['delimiter'] && !flag){
                    parts.push(cell);
                    cell = '';
                    continue;
                }
                cell += line[i];
            }
            parts.push(cell);
            return parts;
        };

        var field   = _getField(fieldname, form),
            counter = 0,
            result  = null,
            files;

        if(field)
        {
            if(field.multiple) result = [];

            if(typeof args == 'undefined' || args === null) args = {};
            if(!('headline'  in args)) args['headline'] = false;
            if(!('delimiter' in args)) args['delimiter'] = ',';
            if(!('quote' in args)) args['quote'] = '"';

            files = field.val(true);
            counter = files.length;
            if(counter)
            {
                index = 'CSVTOJSON:'+field.val();
                if(index in lib.records)
                {
                    result = lib.records[index];
                    /*delete lib.records[index];*/
                }
                else
                {
                    for(var i in files)
                    {
                        if(typeof files[i] == 'object' && files[i].type.match(/csv.*/i))
                        {
                            var reader = new FileReader();
                            reader.onloadend = (function(eq, index, multiple){
                                return function(evt){
                                    var reader = evt.target;
                                    try{
                                        var csv = reader.result,
                                            json = [],
                                            lines = csv.split(/[\r\n]+/),
                                            line,
                                            headers,
                                            obj;
                                        for( var i = 0, h = lines.length; i < h; i++) {
                                            if(!lines[i].length) continue;
                                            if(args['headline'] && typeof headers == 'undefined') {
                                                headers = parseLine(lines[i]);
                                            } else {
                                                obj = {};
                                                line = parseLine(lines[i]);
                                                for (var j = 0, k = line.length; j < k; j++) {
                                                    obj[ (typeof headers != 'undefined') ? headers[j] : j ] = line[j];
                                                }
                                                json.push(JSON.parse(JSON.stringify(obj)));
                                            }
                                        }

                                        if(multiple) result.push(json);
                                        else result = json;
                                    } catch (err) {}
                                    counter--;
                                    if(counter == 0)
                                    {
                                        lib.records[index] = result;
                                        eval_equation(eq);
                                    }
                                };
                            })($.fbuilder['currentEq'], index, field.multiple)
                            reader.readAsBinaryString(files[i]);
                        }
                    }
                }
            }
        }
        return result;
	};

	root.CF_FILE = lib;

})(this);