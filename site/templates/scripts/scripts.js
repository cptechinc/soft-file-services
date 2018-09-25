$(document).ready(function() {
	
	$('body').popover({selector: '[data-toggle="popover"]', placement: 'top'});
	$('body').tooltip({selector: '[data-toggle="tooltip"]', placement: 'top'});
	
	$('body').on('click', function (e) {
		$('[data-toggle="popover"]').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	});
	
	/*==============================================================
		PAGE SCROLLING FUNCTIONS
	=============================================================*/
	$(window).scroll(function() {
		if ($(this).scrollTop() > 50) { $('#back-to-top-button').fadeIn(); } else { $('#back-to-top-button').fadeOut(); }
	});

	// scroll body to 0px on click
	$('#back-to-top-button').click(function () {
		$('#back-to-top-button').tooltip('hide');
		$('body,html').animate({ scrollTop: 0 }, 800);
		return false;
	});
});

function preview_tableformatter(formatterform) {
	var form = $(formatterform);
	form.find('[name=action]').val('preview');
	
	form.postform({jsoncallback: true}, function(json) {
		$.notify({
			icon: json.response.icon,
			message: json.response.message
		},{
			type: json.response.notifytype
		});
		$('#preview-formatter').removeClass('invisible').click();
		$('#preview-formatter').click();
	});
}

$.fn.extend({
	postform: function(options, callback) { //{formdata: data/false, jsoncallback: true/false, action: true/false}
		var form = $(this);
		console.log('submitting ' + form.attr('id'));
		if (!options.action) {options.action = form.attr('action');}
		if (!options.formdata) {options.formdata = form.serialize();}
		if (options.jsoncallback) {
			$.post(options.action, options.formdata, function(json) {callback(json);});
		} else if (options.html) {
			$.post(options.action, options.formdata, function(html) {callback(html);});
		} else {
			$.post(options.action, options.formdata).done(function() {callback();});
		}
	}
});
