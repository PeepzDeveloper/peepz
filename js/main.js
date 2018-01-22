(function($){


	'use strict';
	var screen = $(window),
		s_width = screen.width();

	screen.on('load', function() {
		/*------------------
			Preloder
		--------------------*/
		$(".loader").fadeOut();
		$("#preloder").delay(400).fadeOut("slow");

	});


	/*------------------
		Right Area
	--------------------*/
	var rarea = $('.right-area').height();
	var darea = rarea/2;
	$('.spacial-right-style').css({
		'border-top': darea,
		'border-bottom': darea,
		'border-top-style': 'solid',
		'border-bottom-style': 'solid',
		'border-top-color': 'transparent',
		'border-bottom-color': 'transparent'
	});

	screen.on('resize',function(){
		//location.reload();
	});

	$('#about').on('click', function(e) {
		$('.about-section').addClass('active');
		$('.close-about').addClass('active');
		$('.intro-main').addClass('hide');
		$('.spacial-right-style').addClass('hide');
		e.preventDefault();
	});

	$('.close-about').on('click', function(e) {
		$('.about-section').removeClass('active');
		$(this).removeClass('active');
		$('.intro-main').removeClass('hide');
		$('.spacial-right-style').removeClass('hide');
		e.preventDefault();
	});


	/*------------------
		Countdown
	--------------------*/
	$(".counter").countdown("2017/11/15", function(event) {
		$(this).html(event.strftime("<div class='cd-item'><span>%D</span> days </div>" + "<div class='cd-item'><span>%H</span> hour </div>" + "<div class='cd-item'><span>%M</span> min </div>" + "<div class='cd-item'><span>%S</span> sec </div>"));
	});
	if(s_width < 991) {
		$('.counter').prependTo('.intro-content');
	}


	/*------------------
		Subscribe Form
	--------------------*/
	$('#mc-form').ajaxChimp({
		url: 'http://peepz.us16.list-manage.com/subscribe/post?u=930543cd78ab7c0eaa0df89de&id=68addac13f',//Set Your Mailchamp URL
		callback: function(resp){
        if (resp.result === 'success') {
        	setTimeout(function () {
	        	$('.mc-info').text("");
	        	$("#mc-email").val("");
			}, 4500);
		}
      },
	});

	/*------------------
		Magnific Popup
	--------------------*/
	$('#sub_show').magnificPopup({
		type:'inline',
		mainClass:'mfp-zoom-in',
		removalDelay: 400
	});

  /*$('#reg_show').magnificPopup({
		type:'inline',
		mainClass:'mfp-zoom-in',
		removalDelay: 400
	});*/


	/*------------------
		Water Ripples
	--------------------*/
	$('.waterr').ripples();


	/*------------------
		Slideshow BG
	--------------------*/
	$("#slideshow").backstretch([
		"img/slide1.jpg",
		"img/slide2.jpg",
	], {duration: 4000, fade: 650});


	/*------------------
		CONTACT FORM
	--------------------*/
	$('#contact-form').on('submit', function() {
		var send_btn = $('#send-form'),
			form = $(this),
			formdata = $(this).serialize(),
			chack = $('#form-chack');
			send_btn.text('Wait...');

		function reset_form(){
		 	$("#name").val('');
			$("#email").val('');
			$("#message").val('');
		}

		$.ajax({
			url:  $(form).attr('action'),
			type: 'POST',
			data: formdata,
			success : function(text){
				if (text == "success"){
					send_btn.addClass('done');
					send_btn.text('Success');
					setTimeout(function() {
						reset_form();
						send_btn.removeClass('done');
						send_btn.text('Send Message');
					}, 3000);
				}
				else {
					reset_form();
					send_btn.addClass('error');
					send_btn.text('Error');
          document.getElementById('divResponse').innerHTML = text;
					setTimeout(function() {
						send_btn.removeClass('error');
						send_btn.text('Send Message');
					}, 5000);
				}
			}
		});
		return false;
	});
})(jQuery);