fbuilderjQuery = ( typeof fbuilderjQuery != 'undefined' ) ? fbuilderjQuery : jQuery;
fbuilderjQuery[ 'fbuilder' ] = fbuilderjQuery[ 'fbuilder' ] || {};
fbuilderjQuery[ 'fbuilder' ][ 'modules' ] = fbuilderjQuery[ 'fbuilder' ][ 'modules' ] || {};

fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'default' ] = {
	'prefix' : '',
	'callback'		: function()
	{
		var math_prop = ["LN10", "PI", "E", "LOG10E", "SQRT2", "LOG2E", "SQRT1_2", "LN2", "cos", "pow", "log", "tan", "sqrt", "asin", "abs", "exp", "atan2", "atanh", "random", "acos", "atan", "sin"];

		for(var i = 0, h = math_prop.length; i < h; i++)
		{
			if( !window[ math_prop[ i ] ] )
			{
				window[ math_prop[ i ] ] = window[ math_prop[ i ].toUpperCase() ] = Math[ math_prop[ i ] ];
			}
		}

		if(Number.prototype.LENGTH == undefined)
		{
			// Only LENGTH in uppercase to prevent a conflict with Lottie
			Number.prototype.LENGTH = function(){return this.valueOf().toString().length;};
		}

		if(window.REMAINDER == undefined)
		{
			window.REMAINDER = window.remainder = function(a, b){return a%b;};
		}

		function ROUNDx(operation, num, y)
		{
			if(y && y != 0)
			{
				var r  = operation(num/y)*y, p = (new String(y)).split('.');
				if(p.length == 2) r = PREC(r,p[1].length);
				return r;
			}
			else
			{
				return operation(num);
			}
		};

		if(window.ROUND == undefined)
		{
			window.ROUND = window.round = function(num, y)
			{
				if(y) return ROUNDx(Math.round, num, y);
				return ROUNDx(Math.round, num);
			}
		}

		if(window.FLOOR == undefined)
		{
			window.FLOOR = window.floor = function(num, y)
			{
				if(y) return ROUNDx(Math.floor, num, y);
				return ROUNDx(Math.floor, num);
			}
		}

		if(window.CEIL == undefined)
		{
			window.CEIL = window.ceil = function(num, y)
			{
				if(y) return ROUNDx(Math.ceil, num, y);
				return ROUNDx(Math.ceil, num);
			}
		}

		if(window.PREC == undefined)
		{
			window.PREC = window.prec = function (num, pr, if_not_integer)
				{
                    pr = pr || 0;
                    if_not_integer = if_not_integer || 0;

					if(/^\d+$/.test(pr) && $.isNumeric(num))
					{
                        if(
                            Math.floor(num) != num ||
                            !if_not_integer
                        )
                        {
                            var f = Math.pow(10,pr);
                            num = Math.round(num*f)/f;
                            return num.toFixed(pr);
                        }
					}
					return num;
				};
		} // End if window.PREC

		if(window.CDATE == undefined)
		{
			window.CDATE = window.cdate = function ( num, format )
				{
					format = ( typeof format != 'undefined' ) ? format : ( ( typeof window.DATETIMEFORMAT != 'undefined' ) ? window.DATETIMEFORMAT : 'dd/mm/yyyy' );

					if(isFinite(num*1))
					{
						var time_only = (Math.abs(num)<1);
						num = Math.round(num*86400000);
						if(time_only) num += (new Date(2021,01,01,0,0,0,0)).valueOf();
						var date = new Date(num),
							d = (time_only) ? 0 : date.getDate(),
							m = (time_only) ? 0 : date.getMonth()+1,
							y = (time_only) ? 0 : date.getFullYear(),
							h = date.getHours(),
							i = date.getMinutes(),
							s = date.getSeconds(),
							a = '';
						m = (m < 10) ? '0'+m : m;
						d = (d < 10) ? '0'+d : d;

						if( /a/.test( format ) )
						{
							a = ( h >= 12 ) ? 'pm' : 'am';
							h = h % 12;
							h = ( h == 0 ) ? 12: h;
						}
						h = (h < 10) ? '0'+h : h;
						i = (i < 10) ? '0'+i : i;
						s = (s < 10) ? '0'+s : s;

						return format.replace( /\by{2}\b/i, y%100)
                                     .replace( /y+/i, y)
									 .replace( /m+/i, m)
									 .replace( /d+/i, d)
									 .replace( /h+/i, h)
									 .replace( /i+/i, i)
									 .replace( /s+/i, s)
									 .replace( /a+/i, a);
					}
					return num;
				};
		} // End if window.CDATE

		if(window.SUM == undefined)
		{
			window.SUM = window.sum = function ()
			{
				var r = 0, l = arguments.length, t, callback = function(x){return x;};
				if(l) {
					if(typeof arguments[l-1] == 'function') {
						callback = arguments[l-1];
						l -= 1;
					}
					for(var i=0; i < l; i++)
					{
						if(Array.isArray(arguments[i]))
							r += SUM.apply(this,arguments[i].concat(callback));
						else if(jQuery.isPlainObject(arguments[i]))
							r += SUM.apply(this,Object.values(arguments[i]).concat(callback));
						else
						{
							t = arguments[i]*1;
							if(!isNaN(t))
							{
								t = callback(t);
								if(!isNaN(t)) r += t;
							}

						}
					}
				}
				return r;
			};
		} // End if window.SUM

		if(window.SIGMA == undefined)
		{
			window.SIGMA = window.sigma = function ()
			{
				var r = 0,
					l = arguments.length,
					n,m,callback,t;
				if(l == 3) {

					n = parseInt(arguments[0]);
					m = parseInt(arguments[1]);
					callback = arguments[2];

					if(
						!isNaN(n) &&
						!isNaN(m) &&
						typeof callback == 'function'
					) {

						for(var i=n; i<=m; i++) {
							t = callback(i);
							if(!isNaN(t)) r += t;
						}
					}
				}
				return r;
			};
		} // End if window.SIGMA

		if(window.CONCATENATE == undefined)
		{
			window.CONCATENATE = window.concatenate = function ()
			{
				var r = '';
				for(var i in arguments)
				{
					if(Array.isArray(arguments[i]))
						r += CONCATENATE.apply(this,arguments[i]);
					else if(jQuery.isPlainObject(arguments[i]))
						r += CONCATENATE.apply(this,Object.values(arguments[i]));
					else r += (new String(arguments[i]));
				}
				return r;
			};
		} // End if window.CONCATENATE

		if(window.AVERAGE == undefined)
		{
			window.AVERAGE = window.average = function ()
			{
                var _c = 0;
                function c(v)
                {
                    if(Array.isArray(v) && v.length) for(var i in v) c(v[i]);
                    else _c++;
                }
                for(var i in arguments) c(arguments[i]);
                return SUM.apply(this,arguments)/_c;
			};
		} // End if window.AVERAGE

		if(window.GCD == undefined)
		{
			window.GCD = window.gcd = function( a, b)
				{
					if ( ! b) return a;
					return GCD(b, a % b);
				};
		} // End if window.GCD

		if(window.LCM == undefined)
		{
			window.LCM = window.lcm = function( a, b)
				{
					return (!a || !b) ? 0 : ABS((a * b) / GCD(a, b));
				};
		} // End if window.LCM

		if(window.LOGAB == undefined)
		{
			window.LOGAB = window.logab = function( a, b)
				{
					return LOG(a)/LOG(b);
				};
		} // End if window.LOGAB

		if(window.NTHROOT == undefined)
		{
			window.NTHROOT = window.nthroot = function(a,b)
				{
                    var n = (a<0 && b%2 == 1) ? -1 : 1;
					return n*POW(Math.abs(a), 1/b);
				};
		} // End if window.NTHROOT

		if(window.MIN == undefined)
		{
			window.MIN = window.min = function ()
			{
				var l = [];
				for(var i in arguments)
					var l = l.concat(arguments[i]);
				return Math.min.apply(this, l);
			};
		} // End if window.MIN

		if(window.MAX == undefined)
		{
			window.MAX = window.max = function ()
			{
				var l = [];
				for(var i in arguments)
					var l = l.concat(arguments[i]);
				return Math.max.apply(this, l);
			};
		} // End if window.MAX

		if(window.RADIANS == undefined)
		{
			window.RADIANS = window.radians = function(a){ return a*PI/180;};
		}

		if(window.DEGREES == undefined)
		{
			window.DEGREES = window.degrees = function(a){ return a*180/PI;};
		}

		if(window.FACTORIAL == undefined)
		{
			window.FACTORIAL = window.factorial = function(a){
				if(a<0 || FLOOR(a) != a) return null;
				var r = 1;
				for(var i=1; i<=a; i++) r *= i
				return r;
			};
		}

		if(window.FRACTIONTODECIMAL == undefined)
        {
            window.FRACTIONTODECIMAL = window.fractiontodecimal = window.fractionToDecimal = function(v){
                try
                {
                    var x = v.toString().split('/');
                    return parseInt(x[0], 10)/((1 in x) ? parseInt(x[1], 10) : 1);
                }catch(err){return v;}
            };
        }

		if(window.DECIMALTOFRACTION == undefined)
        {
            window.DECIMALTOFRACTION = window.decimaltofraction = window.decimalToFraction = function(v){
                try
                {
                    if(v*1 == parseInt(v, 10)) return parseInt(v, 10);
                    var x = v.toString().split('.'),
                        top = parseInt(x[0]+''+x[1]),
                        bottom = Math.pow(10, x[1].length),
                        y = gcd(Math.abs(top), bottom);

                    return (top/y) + '/' + (bottom/y);
                }catch(err){return v;}
            };
        }

        if(window.FRACTIONSUM == undefined)
        {
            window.FRACTIONSUM = window.fractionsum = function(){
                try
                {
                    var _aux = function(a, b){
                        var d1, d2, m, r;

                        a = (a+'/1').split('/');
                        b = (b+'/1').split('/');

                        d1 = a[0]*b[1]+a[1]*b[0];
                        d2 = a[1]*b[1];

                        if(isNaN(d1) || isNaN(d2)) throw 'Invalid numbers';

                        m = abs(gcd(d1,d2));
                        r = d1/m + IF(d2/m == 1, '', '/'+d2/m);
                        return jQuery.isNumeric(r) ? r*1 : r;
                    };
                    var r = 0;
                    for(var i in arguments) r = _aux(r,arguments[i]);
                    return r;
                } catch(err){}
           };
        }

		if(window.FRACTIONSUB == undefined)
        {
            window.FRACTIONSUB = window.fractionsub = function(){
                try
                {
                    var _aux = function(a, b){
                        var d1, d2, m, r;

                        a = (a+'/1').split('/');
                        b = (b+'/1').split('/');

                        d1 = a[0]*b[1]-a[1]*b[0];
                        d2 = a[1]*b[1];

                        if(isNaN(d1) || isNaN(d2)) throw 'Invalid numbers';

                        m = abs(gcd(d1,d2));
                        r = d1/m + IF(d2/m == 1, '', '/'+d2/m);
                        return jQuery.isNumeric(r) ? r*1 : r;
                    };
                    var r = 0;
                    for(var i in arguments)
                    {
                        if(i == 0) r = _aux(arguments[i], r);
                        else  r = _aux(r,arguments[i]);
                    }
                    return r;
                } catch(err){}
            };
        }

		if(window.FRACTIONMULT == undefined)
        {
            window.FRACTIONMULT = window.fractionmult = function(){
                try
                {
                    var _aux = function(a, b){
                        var d1, d2, m, r;

                        a = (a+'/1').split('/');
                        b = (b+'/1').split('/');

                        d1 = a[0]*b[0];
                        d2 = a[1]*b[1];

                        if(isNaN(d1) || isNaN(d2)) throw 'Invalid numbers';

                        m = abs(gcd(d1,d2));
                        r = d1/m + IF(d2/m == 1, '', '/'+d2/m);
                        return jQuery.isNumeric(r) ? r*1 : r;
                    };
                    var r = 1;
                    for(var i in arguments) r = _aux(r,arguments[i]);
                    return r;
                } catch(err){}
            };
        }

		if(window.FRACTIONDIV == undefined)
        {
            window.FRACTIONDIV = window.fractiondiv = function(){
                try
                {
                    var _aux = function(a, b){
                        var d1, d2, m, r;

                        a = (a+'/1').split('/');
                        b = (b+'/1').split('/');

                        d1 = a[0]*b[1];
                        d2 = a[1]*b[0];

                        if(isNaN(d1) || isNaN(d2)) throw 'Invalid numbers';

                        m = abs(gcd(d1,d2));
                        r = d1/m + IF(d2/m == 1, '', '/'+d2/m);
                        return jQuery.isNumeric(r) ? r*1 : r;
                    };
                    var r = 1;
                    for(var i in arguments)
                    {
                        if(i == 0) r = _aux(arguments[i], r);
                        else  r = _aux(r,arguments[i]);
                    }
                    return r;
                } catch(err){}
            };
        }

		if(window.SCIENTIFICTODECIMAL == undefined)
		{
			window.SCIENTIFICTODECIMAL = window.scientifictodecimal = function(x){
                x *= 1;
				if (Math.abs(x) < 1.0)
				{
					var e = parseInt(x.toString().split('e-')[1]);
					if(e)
					{
						x *= Math.pow(10,e-1);
						x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
					}
				}
				else
				{
					var e = parseInt(x.toString().split('+')[1]);
					if (e > 20)
					{
						e -= 20;
						x /= Math.pow(10,e);
						x += (new Array(e+1)).join('0');
					}
				}
				return x;
			};
		}

        if(window.DECIMALTOSCIENTIFIC == undefined)
        {
            window.DECIMALTOSCIENTIFIC = window.decimaltoscientific = function(x){
                var v = Number(x).toExponential();
                return (isNaN(v) || x == '') ? x : v;
            };
        }

		if(window.FORMAT == undefined)
		{
			window.FORMAT = window.format = function(x,o){
				return fbuilderjQuery.fbuilder.calculator.format(x,o);
			};
		}

		if(window.UNFORMAT == undefined)
		{
			window.UNFORMAT = window.unformat = function(x,o){
                try
                {
                    var s;
                    try
                    {
                        s = (typeof o != 'undefined' && 'decimalsymbol' in o) ? o['decimalsymbol'] : '.';
                    }catch(err){ s = '.'; }

                    return (x+'').replace(new RegExp('[^\\-\\d\\'+s+']', 'gi'), '')
                                 .replace(new RegExp('\\'+s, 'gi'), '.')*1;
                }
                catch(err){ return x; }
			};
		}

		fbuilderjQuery[ 'fbuilder' ][ 'extend_window' ]( fbuilderjQuery[ 'fbuilder' ][ 'modules' ][ 'default' ][ 'prefix' ], CF_LOGICAL );
	},

	'validator'	: function( v )
		{
			return ( typeof v == 'number' ) ? isFinite( v ) : ( typeof v != 'undefined' );
		}
};