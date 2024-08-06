(function($) {

	$.fn.spasticNav = function(options) {
	
		options = $.extend({
			overlap : 0,
			speed : 500,
			reset : 50,
			color : '#f1ad48',
			easing : 'swing'	//'easeOutExpo'
		}, options);
	
		return this.each(function() {
		
		 	var nav = $(this),
		 		currentPageItem = nav.find('>.current-menu-item,>.current-menu-parent,>.current-menu-ancestor'),	//>.current_page_parent
				hidden = true,	//false
		 		blob,
		 		reset;
			if (currentPageItem.length === 0) {
		 		currentPageItem = nav.find('li').eq(0);
				//hidden = true;
			}

		 	$('<li id="blob"></li>').css({
					width : currentPageItem.css('width'),	//.outerWidth(),
					height : currentPageItem.css('height'),	//.outerHeight() + options.overlap,
					left : currentPageItem.position().left,
					top : currentPageItem.position().top - options.overlap / 2,
					backgroundColor : hidden ? options.color : currentPageItem.find('a').css('backgroundColor'),
					opacity: hidden ? 0 : 1
				}).appendTo(this);
		 	blob = $('#blob', nav);
					 	
			nav.find('>li:not(#blob)').hover(function() {
				// mouse over
				clearTimeout(reset);
				var bg = $(this).css('backgroundColor');
				$(this).addClass('blob_over');
				blob.css({backgroundColor: bg}).animate(
					{
						left: $(this).position().left,
						top: $(this).position().top - options.overlap / 2,
						width: $(this).css('width'),	//.outerWidth(),
						height: $(this).css('height') + options.overlap,	//.outerHeight() + options.overlap,
						opacity: 1
					},
					{
						duration : options.speed,
						easing : options.easing,
						queue : false
					}
				);
			}, function() {
				// mouse out	
				reset = setTimeout(function() {
					/*
					var a = currentPageItem.find('a');
					var bg = a.css('backgroundColor');
					*/
					blob.animate({
						/*
						width : currentPageItem.outerWidth(),
						left : currentPageItem.position().left,
						*/
						opacity: 0	//hidden ? 0 : 1,
					}, options.speed)
					//.css({backgroundColor: bg})
				}, options.reset);
				$(this).removeClass('blob_over');
			});
		 
		
		}); // end each
	
	};

})(jQuery);