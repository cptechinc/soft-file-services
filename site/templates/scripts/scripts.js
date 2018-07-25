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
	   YOUTUBE NAVIGATION
	=============================================================*/
		$('.yt-menu-open').on('click', function(e) { //Youtube-esque navigation
			e.preventDefault();
			$('#yt-menu').toggle();
			$(this).toggleClass('menu-open');
			if ($(this).hasClass('menu-open')) {
				$(this).css({"background-color":"#242F40", "color": "#f8f8f8"});
			} else {
				$(this).removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$(document).mouseup(function (e) {
			var container = $("#yt-menu");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				 $('#yt-menu').hide();
				 $('.yt-menu-open').data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});
});

function preview_tableformatter(formatterform) {
	var form = $(formatterform);
	form.find('[name=action]').val('preview');
	
	form.postform({jsoncallback: true, html: true}, function(html) {
		var title = form.find('.panel-title').text();
		$(config.modals.ajax).find('.modal-body').addClass('modal-results').html(html);
		$(config.modals.ajax).find('.modal-title').text('Previewing ' + title + ' Formatter');
		$(config.modals.ajax).resizemodal('xl').modal();
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
