jQuery(function ($) {

	var host = window.location.protocol + "//" + window.location.hostname + '/';
	var url_login = 'sign-in';
	var url_logout = 'sign-out';
	var url_offline = 'offline';
	var last_loc = window.location.pathname;
	var timer, xhr;

	// check if localhost
	if (host.includes('localhost')) {
		host = host + 'meys-v2/';
		split = last_loc.split("meys-v2/");
		last_loc = split[split.length - 1];
	}

	$(window).on('mousemove', function () {
		clearInterval(timer);
		timer = setInterval(update, (10 *60*1000));
	}).trigger('mousemove');

	function update() {
		if (!(xhr && xhr.state && xhr.state == 'pending')) {
			xhr = $.ajax({
				url: host + url_offline,
			}).done(function (html) {
				window.location.href = host + url_login + '?act=session-expired&reff=' + last_loc;
			});
		}
	}
});
