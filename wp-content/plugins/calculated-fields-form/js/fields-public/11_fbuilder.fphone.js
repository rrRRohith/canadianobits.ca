	$.fbuilder.controls['fPhone']=function(){};
	$.extend(
		$.fbuilder.controls['fPhone'].prototype,
		$.fbuilder.controls['ffields'].prototype,
		{
			title:"Phone",
			ftype:"fPhone",
			required:false,
			readonly:false,
			dformat:"### ### ####",
			predefined:"888 888 8888",

            countryComponent:false,
            toDisplay:'iso',
            countries:[],
            defaultCountry:'',

			show:function()
				{
                    var me  = this,
                        db = {"AF":"+93","AX":"+358","AL":"+355","DZ":"+213","AS":"+1684","AD":"+376","AO":"+244","AI":"+1264","AQ":"+672","AG":"+1268","AR":"+54","AM":"+374","AW":"+297","AU":"+61","AT":"+43","AZ":"+994","BS":"+1242","BH":"+973","BD":"+880","BB":"+1246","BY":"+375","BE":"+32","BZ":"+501","BJ":"+229","BM":"+1441","BT":"+975","BO":"+591","BA":"+387","BW":"+267","BV":"+47","BR":"+55","IO":"+246","BN":"+673","BG":"+359","BF":"+226","BI":"+257","KH":"+855","CM":"+237","CA":"+1","CV":"+238","KY":"+ 345","CF":"+236","TD":"+235","CL":"+56","CN":"+86","CX":"+61","CC":"+61","CO":"+57","KM":"+269","CG":"+242","CD":"+243","CK":"+682","CR":"+506","CI":"+225","HR":"+385","CU":"+53","CY":"+357","CZ":"+420","DK":"+45","DJ":"+253","DM":"+1767","DO":"+1849","EC":"+593","EG":"+20","SV":"+503","GQ":"+240","ER":"+291","EE":"+372","ET":"+251","FK":"+500","FO":"+298","FJ":"+679","FI":"+358","FR":"+33","GF":"+594","PF":"+689","TF":"+262","GA":"+241","GM":"+220","GE":"+995","DE":"+49","GH":"+233","GI":"+350","GR":"+30","GL":"+299","GD":"+1473","GP":"+590","GU":"+1671","GT":"+502","GG":"+44","GN":"+224","GW":"+245","GY":"+592","HT":"+509","HM":"+0","VA":"+379","HN":"+504","HK":"+852","HU":"+36","IS":"+354","IN":"+91","ID":"+62","IR":"+98","IQ":"+964","IE":"+353","IM":"+44","IL":"+972","IT":"+39","JM":"+1876","JP":"+81","JE":"+44","JO":"+962","KZ":"+7","KE":"+254","KI":"+686","KP":"+850","KR":"+82","XK":"+383","KW":"+965","KG":"+996","LA":"+856","LV":"+371","LB":"+961","LS":"+266","LR":"+231","LY":"+218","LI":"+423","LT":"+370","LU":"+352","MO":"+853","MK":"+389","MG":"+261","MW":"+265","MY":"+60","MV":"+960","ML":"+223","MT":"+356","MH":"+692","MQ":"+596","MR":"+222","MU":"+230","YT":"+262","MX":"+52","FM":"+691","MD":"+373","MC":"+377","MN":"+976","ME":"+382","MS":"+1664","MA":"+212","MZ":"+258","MM":"+95","NA":"+264","NR":"+674","NP":"+977","NL":"+31","AN":"+599","NC":"+687","NZ":"+64","NI":"+505","NE":"+227","NG":"+234","NU":"+683","NF":"+672","MP":"+1670","NO":"+47","OM":"+968","PK":"+92","PW":"+680","PS":"+970","PA":"+507","PG":"+675","PY":"+595","PE":"+51","PH":"+63","PN":"+64","PL":"+48","PT":"+351","PR":"+1939","QA":"+974","RO":"+40","RU":"+7","RW":"+250","RE":"+262","BL":"+590","SH":"+290","KN":"+1869","LC":"+1758","MF":"+590","PM":"+508","VC":"+1784","WS":"+685","SM":"+378","ST":"+239","SA":"+966","SN":"+221","RS":"+381","SC":"+248","SL":"+232","SG":"+65","SK":"+421","SI":"+386","SB":"+677","SO":"+252","ZA":"+27","SS":"+211","GS":"+500","ES":"+34","LK":"+94","SD":"+249","SR":"+597","SJ":"+47","SZ":"+268","SE":"+46","CH":"+41","SY":"+963","TW":"+886","TJ":"+992","TZ":"+255","TH":"+66","TL":"+670","TG":"+228","TK":"+690","TO":"+676","TT":"+1868","TN":"+216","TR":"+90","TM":"+993","TC":"+1649","TV":"+688","UG":"+256","UA":"+380","AE":"+971","GB":"+44","US":"+1","UY":"+598","UZ":"+998","VU":"+678","VE":"+58","VN":"+84","VG":"+1284","VI":"+1340","WF":"+681","YE":"+967","ZM":"+260","ZW":"+263"};

					me.predefined = new String(me._getAttr('predefined', true));
                    me.dformat = me.dformat.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\s+/g, ' ');
                    me.predefined = me.predefined.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\s+/g, ' ');

					var str  = "",
						tmp  = me.dformat.split(/\s/),
						tmpv = me.predefined.split(/\s/),
						attr = (typeof me.predefinedClick != 'undefined' && me.predefinedClick) ? 'placeholder' : 'value',
                        c = 0;

					for (var i=0;i<tmpv.length;i++)
					{
						if ($.trim(tmpv[i])=="")
						{
							tmpv.splice(i,1);
						}
					}

                    if(me.countryComponent)
                    {
                        str += '<div class="uh_phone"><select id="'+me.name+'_'+c+'" name="'+me.name+'_'+c+'" class="field">';
                        if(!me.countries.length) me.countries = Object.keys(db);
                        for(var i in me.countries)
                            str += '<option value="'+db[me.countries[i]]+'" '+(me.defaultCountry == me.countries[i] ? 'SELECTED' : '')+'>'+(me.toDisplay == 'iso' ? me.countries[i] : db[me.countries[i]])+'</option>';
                        str += '</select></div>';
                        c++;
                    }

					for (var i = 0, h = tmp.length;i<h;i++)
					{
                        if ($.trim(tmp[i])!="")
						{
							str += '<div class="uh_phone" ><input aria-label="'+cff_esc_attr(me.title)+'" type="text" id="'+me.name+'_'+c+'" name="'+me.name+'_'+c+'" class="field '+((i==0 && !me.countryComponent) ? ' phone ' : ' digits ')+((me.required) ? ' required ' : '')+'" size="'+$.trim(tmp[i]).length+'" '+attr+'="'+((tmpv[i])?tmpv[i]:"")+'" maxlength="'+$.trim(tmp[i]).length+'" minlength="'+$.trim(tmp[i]).length+'" '+((me.readonly)?'readonly':'')+' /><div class="l">'+$.trim(tmp[i])+'</div></div>';
						}
                        c++;
					}

					return '<div class="fields '+cff_esc_attr(me.csslayout)+' '+me.name+' cff-phone-field" id="field'+me.form_identifier+'-'+me.index+'"><label for="'+me.name+'">'+me.title+''+((me.required)?"<span class='r'>*</span>":"")+'</label><div class="dfield"><input type="hidden" id="'+me.name+'" name="'+me.name+'" class="field" />'+str+'<div class="clearer"></div><span class="uh">'+me.userhelp+'</span></div><div class="clearer"></div></div>';
				},
            after_show: function()
				{
					var me   = this,
						tmp  = me.dformat.split(' ');

					if(!('phone' in $.validator.methods))
						$.validator.addMethod("phone", function(value, element)
						{
							if(this.optional(element)) return true;
							else return /^\+{0,1}\d*$/.test(value);
						});

					for (var i = 0, h = tmp.length+(me.countryComponent ? 1 : 0); i < h; i++)
					{
						$('#'+me.name+'_'+i).bind('change', function(){
							var v = '';
                            $('[id*="'+me.name+'_"]').each(function(){v+=$(this).val();});
							$('#'+me.name).val(v).change();
						});
						if(i+1 < h)
						{
							$('#'+me.name+'_'+i).bind('keyup', { 'next': i+1 }, function(evt){
								var e = $(this);
								if(e.val().length == e.attr('maxlength'))
								{
									e.change();
									$('#'+me.name+'_'+evt.data.next).focus();
								}
							});
						}
					}
                    $('#'+me.name+'_0').change();
				},
			val:function(raw, no_quotes)
				{
                    raw = raw || true;
                    no_quotes = no_quotes || false;
					var e = $('[id="'+this.name+'"]:not(.ignore)'),
						p = $.fbuilder.parseValStr(e.val(), raw, no_quotes);

					if(e.length) return ($.isNumeric(p) && !no_quotes) ? '"'+p+'"' : p;
					return 0;
				},
			setVal:function(v)
				{
					v = (new String(v)).replace(/^\s+/, '').replace(/\s+$/, '');
                    if(v.length)
                    {
                        var d = this.dformat.split(/\s+/g),
                            f = v.substr(0,1),
                            r = '(.*)',
                            c;

                        for(var i in d) r += '(.{'+d[i].length+'})';
                        r = new RegExp(r+'$');

                        v = f+v.substr(1).replace(/[^\d]/g, '');
                        c = r.exec(v);

                        if(c != null)
                        {
                            for(var i = c.length-1; 0<i; i--)
                                $('[id="'+this.name+'_'+(i-1)+'"]').val(c[i]);
                        }
                        else $('input[id*="'+this.name+'_"]:eq(0)').val(v);
                    }

                    $('[name="'+this.name+'"]').val(v);
				}
		}
	);