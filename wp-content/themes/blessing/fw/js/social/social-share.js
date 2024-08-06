(function ($) {
	"use strict";
	$(function () {
		$('.sc_socials_share a:not(.inited)').each(function (idx) {
			var el = $(this).addClass('inited'),
				cnt = el.data('count'),
				u = el.data('url'),					// share url
				z = el.data("zero-counter");		// show zero counter
			if (!u) u = location.href;
			if (!z) z = 1;
			if (cnt == "delicious") {
				function delicious_count(url) {
					var shares;
					$.getJSON('http://feeds.delicious.com/v2/json/urlinfo/data?callback=?&url=' + url, function (data) {
						shares = data[0] ? data[0].total_posts : 0;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					});
				}
				delicious_count(u);
			} else if (cnt == "facebook") {
				function fb_count(url) {
					var shares;
					$.getJSON('http://graph.facebook.com/?callback=?&ids=' + url, function (data) {
						shares = data[url] && data[url].shares ? data[url].shares : 0;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
				fb_count(u);
			} else if (cnt == "linkedin") {
				function lnkd_count(url) {
					var shares;
					$.getJSON('http://www.linkedin.com/countserv/count/share?callback=?&url=' + url, function (data) {
						shares = data.count;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
				lnkd_count(u);
			} else if (cnt == "mail") {
				function mail_count(url) {
					var shares;
					$.getJSON('http://connect.mail.ru/share_count?callback=1&func=?&url_list=' + url, function (data) {
						shares = data.hasOwnProperty(url) ? data[url].shares : 0;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
	            mail_count(u);
			} else if (cnt == "odnoklassniki") {
				function odkl_count(url) {
					var shares;
					$.getScript('http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=' + idx + '&ref=' + url);
					if (!window.ODKL) window.ODKL = {};
					window.ODKL.updateCount = function (idx, number) {
						shares = number;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					}
				}
				odkl_count(u);
			} else if (cnt == "pinterest") {
				function pin_count(url) {
					var shares;
					$.getJSON('http://api.pinterest.com/v1/urls/count.json?callback=?&url=' + url, function (data) {
						shares = data.count;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
				pin_count(u);
			} else if (cnt == "twitter") {
				function twi_count(url) {
					var shares;
					$.getJSON('http://urls.api.twitter.com/1/urls/count.json?callback=?&url=' + url, function (data) {
						shares = data.count;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
				twi_count(u);
			} else if (cnt == "vk" || cnt == "vk2") {
				function vk_count(url) {
					var shares;
					$.getScript('http://vk.com/share.php?act=count&index=' + idx + '&url=' + url);
					if (!window.VK) window.VK = {};
					window.VK.Share = {
						count: function (idx, number) {
							shares = number;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
						}
					}
				}
				vk_count(u);
			} else if (cnt == "ya") {
				function ya_count(url) {
					if (!window.Ya) window.Ya = {};
					window.Ya.Share = {
						showCounter: function (number) {
							window.yaShares = number
						}
					};
					$.getScript('http://wow.ya.ru/ajax/share-counter.xml?url=' + url, function () {
						var shares = window.yaShares;
						if (shares > 0 || z == 1) el.after('<span class="share_counter">' + shares + '</span>')
					})
				}
				ya_count(u);
			}
        })
    })
})(jQuery);
