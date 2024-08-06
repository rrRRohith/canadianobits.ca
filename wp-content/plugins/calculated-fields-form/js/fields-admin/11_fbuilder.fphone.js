	$.fbuilder.typeList.push(
		{
			id:"fPhone",
			name:"Phone field",
			control_category:1
		}
	);
	$.fbuilder.controls[ 'fPhone' ] = function(){};
	$.extend(
		$.fbuilder.controls[ 'fPhone' ].prototype,
		$.fbuilder.controls[ 'ffields' ].prototype,
		{
			title:"Phone",
			ftype:"fPhone",
			required:false,
			exclude:false,
			readonly:false,
			dformat:"### ### ####",
			predefined:"888 888 8888",

            countryComponent:false,
            toDisplay:'iso',
            countries:[],
            defaultCountry:'',

			display:function()
				{
					var str = "",
                        tmp = this.dformat.split(/\s/),
                        tmpv = this.predefined.split(/\s/);
					for (var i=0;i<tmpv.length;i++)
					{
						if ($.trim(tmpv[i])=="") tmpv.splice(i,1);
					}
					for (var i=0;i<tmp.length;i++)
					{
						if ($.trim(tmp[i])!="")
							str += '<div class="uh_phone" ><input type="text" class="field disabled" style="width:'+(15*$.trim(tmp[i]).length)+'px" value="'+cff_esc_attr((tmpv[i])?tmpv[i]:"")+'" maxlength="'+$.trim(tmp[i]).length+'" /><div class="l">'+$.trim(tmp[i])+'</div></div>';
					}
					return '<div class="fields '+this.name+' '+this.ftype+'" id="field'+this.form_identifier+'-'+this.index+'" title="'+this.name+'"><div class="arrow ui-icon ui-icon-play "></div><div title="Delete" class="remove ui-icon ui-icon-trash "></div><div title="Duplicate" class="copy ui-icon ui-icon-copy "></div><label>'+this.title+''+((this.required)?"*":"")+'</label><div class="dfield">'+str+'<span class="uh">'+this.userhelp+'</span></div><div class="clearer" /></div>';
				},
			editItemEvents:function()
				{
					var evt = [
                        {s:"#sFormat",e:"change keyup", l:"dformat", f:function(el){return (el.val()+'').replace(/^\s+/, '').replace(/\s+$/, '').replace(/\s+/g, ' ')}},
                        {s:"#sCountryComponent",e:"click", l:"countryComponent", f:function(el){return el.is(':checked');}},
                        {s:"[name='sToDisplay']",e:"click", l:"toDisplay", f:function(){return $("[name='sToDisplay']:checked").val();}},
                        {s:"#sCountries",e:"change", l:"countries"},
                        {s:"#sDefaultCountry",e:"change", l:"defaultCountry"},
                    ];
					$.fbuilder.controls[ 'ffields' ].prototype.editItemEvents.call(this,evt);
                    $('#sSelectAll').click(function(){var e = $("#sCountries"); e.find('option').prop('selected', true); e.change();});
				},
			showFormatIntance: function()
				{
                    var db = {"AF":"+93","AX":"+358","AL":"+355","DZ":"+213","AS":"+1684","AD":"+376","AO":"+244","AI":"+1264","AQ":"+672","AG":"+1268","AR":"+54","AM":"+374","AW":"+297","AU":"+61","AT":"+43","AZ":"+994","BS":"+1242","BH":"+973","BD":"+880","BB":"+1246","BY":"+375","BE":"+32","BZ":"+501","BJ":"+229","BM":"+1441","BT":"+975","BO":"+591","BA":"+387","BW":"+267","BV":"+47","BR":"+55","IO":"+246","BN":"+673","BG":"+359","BF":"+226","BI":"+257","KH":"+855","CM":"+237","CA":"+1","CV":"+238","KY":"+ 345","CF":"+236","TD":"+235","CL":"+56","CN":"+86","CX":"+61","CC":"+61","CO":"+57","KM":"+269","CG":"+242","CD":"+243","CK":"+682","CR":"+506","CI":"+225","HR":"+385","CU":"+53","CY":"+357","CZ":"+420","DK":"+45","DJ":"+253","DM":"+1767","DO":"+1849","EC":"+593","EG":"+20","SV":"+503","GQ":"+240","ER":"+291","EE":"+372","ET":"+251","FK":"+500","FO":"+298","FJ":"+679","FI":"+358","FR":"+33","GF":"+594","PF":"+689","TF":"+262","GA":"+241","GM":"+220","GE":"+995","DE":"+49","GH":"+233","GI":"+350","GR":"+30","GL":"+299","GD":"+1473","GP":"+590","GU":"+1671","GT":"+502","GG":"+44","GN":"+224","GW":"+245","GY":"+592","HT":"+509","HM":"+0","VA":"+379","HN":"+504","HK":"+852","HU":"+36","IS":"+354","IN":"+91","ID":"+62","IR":"+98","IQ":"+964","IE":"+353","IM":"+44","IL":"+972","IT":"+39","JM":"+1876","JP":"+81","JE":"+44","JO":"+962","KZ":"+7","KE":"+254","KI":"+686","KP":"+850","KR":"+82","XK":"+383","KW":"+965","KG":"+996","LA":"+856","LV":"+371","LB":"+961","LS":"+266","LR":"+231","LY":"+218","LI":"+423","LT":"+370","LU":"+352","MO":"+853","MK":"+389","MG":"+261","MW":"+265","MY":"+60","MV":"+960","ML":"+223","MT":"+356","MH":"+692","MQ":"+596","MR":"+222","MU":"+230","YT":"+262","MX":"+52","FM":"+691","MD":"+373","MC":"+377","MN":"+976","ME":"+382","MS":"+1664","MA":"+212","MZ":"+258","MM":"+95","NA":"+264","NR":"+674","NP":"+977","NL":"+31","AN":"+599","NC":"+687","NZ":"+64","NI":"+505","NE":"+227","NG":"+234","NU":"+683","NF":"+672","MP":"+1670","NO":"+47","OM":"+968","PK":"+92","PW":"+680","PS":"+970","PA":"+507","PG":"+675","PY":"+595","PE":"+51","PH":"+63","PN":"+64","PL":"+48","PT":"+351","PR":"+1939","QA":"+974","RO":"+40","RU":"+7","RW":"+250","RE":"+262","BL":"+590","SH":"+290","KN":"+1869","LC":"+1758","MF":"+590","PM":"+508","VC":"+1784","WS":"+685","SM":"+378","ST":"+239","SA":"+966","SN":"+221","RS":"+381","SC":"+248","SL":"+232","SG":"+65","SK":"+421","SI":"+386","SB":"+677","SO":"+252","ZA":"+27","SS":"+211","GS":"+500","ES":"+34","LK":"+94","SD":"+249","SR":"+597","SJ":"+47","SZ":"+268","SE":"+46","CH":"+41","SY":"+963","TW":"+886","TJ":"+992","TZ":"+255","TH":"+66","TL":"+670","TG":"+228","TK":"+690","TO":"+676","TT":"+1868","TN":"+216","TR":"+90","TM":"+993","TC":"+1649","TV":"+688","UG":"+256","UA":"+380","AE":"+971","GB":"+44","US":"+1","UY":"+598","UZ":"+998","VU":"+678","VE":"+58","VN":"+84","VG":"+1284","VI":"+1340","WF":"+681","YE":"+967","ZM":"+260","ZW":"+263"},

                    output = '<label>Number Format</label><input type="text" name="sFormat" id="sFormat" value="'+$.fbuilder.htmlEncode(this.dformat)+'" class="large" />'+
                    '<hr />'+

                    '<label><input type="checkbox" name="sCountryComponent" id="sCountryComponent" '+(this.countryComponent ? 'CHECKED' : '')+'/> Include country code selector</label>'+

                    '<div><label class="column"><input type="radio" name="sToDisplay" value="code" '+(this.toDisplay == 'code' ? 'CHECKED' : '')+' /> Display country code&nbsp;&nbsp;</label>'+
                    '<label class="column"><input type="radio" name="sToDisplay" value="iso" '+(this.toDisplay == 'iso' ? 'CHECKED' : '')+' /> Display country ISO</label></div>'+
                    '<div class="clear"></div>'+

                    '<label>Countries</label>'+
                    '<select name="sCountries" id="sCountries" class="large" multiple size="10">';
                    for(var i in db) output += '<option value="'+cff_esc_attr(i)+'" '+(!this.countries.length || this.countries.indexOf(i) != -1 ? 'SELECTED' : '')+'>'+cff_esc_attr(i)+'</option>';
                    output += '</select><br><br>'+
                    '<input type="button" class="button-secondary large" value="Select all" id="sSelectAll" /><br>'+

                    '<label>Select country by default</label>'+
                    '<select name="sDefaultCountry" id="sDefaultCountry" class="large">';
                    for(var i in db) output += '<option value="'+cff_esc_attr(i)+'" '+(this.defaultCountry == i ? 'SELECTED' : '')+'>'+cff_esc_attr(i)+'</option>';
                    output += '</select><hr />';

                    return output;
				}
	});