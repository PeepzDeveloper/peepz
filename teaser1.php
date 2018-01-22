<!DOCTYPE html>
<html lang="en">
<head>
	<title>Online Event/ Promo/ Modeling Gig Application</title>
	<meta charset="UTF-8">
	<meta name="description" content="marketing event staff solution">
	<meta name="keywords" content="event, staff, promoter, brand ambassador, jobs, waiter, event software">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/owl.carousel.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/style2.css"/>

	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

  <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '134533200501992');
fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" src="https://www.facebook.com/tr?id=134533200501992&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>
	<!-- ==== Main Area Start ==== -->
	<main class="main-warp">
		<div class="left-area h-100 pl-md-5 pl-xl-5">
			<div class="left-area-bg"></div>
				<div class="intro-main">
					<!-- Logo -->
					<div class="logo">
						<img src="images/logo_pink.png" alt="">
					</div>
					<div class="intro-content">
						<!-- Intro Text -->
						<h2><font class="top">There's something big coming...</font><br>
            ...to disrupt the events industry</h2>
						<p>Join us on this journey!</p>
						<p>Register now for free, be part of the Beta, get ahead of the game!</p>
            <a onclick="registerfacebook();" class="site-btn btn-pink" id='registerbtn'><i style="padding-right:10px;" class="fa fa-facebook" aria-hidden="true"></i>Register now</a>

						<a href="#subscribe" id="sub_show" class="site-btn btn-black">Slap me a mail later!</a>
						<button id="about" class="site-btn btn-black-line ml-2 hidden-sm">Wanna know more?</button>
						<!-- Social Links -->
						<div class="social mt-5">
							<span>Follow Us:</span>
							<a href="https://www.facebook.com/peepzonline" target="new"><i class="fa fa-facebook"></i></a>
							<a href="https://www.twitter.com/peepzonline" target="new"><i class="fa fa-twitter"></i></a>
							<!--<a href=""><i class="fa fa-google-plus"></i></a>-->
						</div>
					</div>
				</div>
			<div class="close-about">×</div>
		</div>
		<div class="right-area h-100">
			<div class="spacial-right-style"></div>
			<div class="counter-center">
				<div class="counter"></div>
			</div>
		</div>
	</main>
	<!-- ==== Main Area End ==== -->


	<!-- ==== Left Area Start ==== -->
	<div class="about-section">
		<!-- About Content -->
		<div class="about-content spad">
			<h2 class="mb-4"><font class="top">Little more info?</font></h2>
			<p>
        Peepz is an online booking portal for staff in the marketing industry.
        This includes Brand Ambassadors, Promoters, Bartenders and Service Staff.
        Our staff are called Peepz and they assist you in creating engaging experiences for your clients and consumers.
        <br><br>Our simple system allows you, to find good staff located near to your event, activation or function.
        It is simple to use for both clients and Peepz. It is free to use for Peepz and a small percentage is charged
        for clients to use the system.
        <br><br>If you need Peepz, you've come to the right place.

      </p>
		</div>
		<div class="services spad">
			<div class="row">
				<!-- Service Item -->
				<div class="col-md-4 col-sm-4">
					<div class="service-item purple">
						<i class="fa fa-desktop"></i>
						<h4>Simple Registration</h4>
						<p>Clients and Peepz register on the system and create a free profile</p>
					</div>
				</div>
				<!-- Service Item -->
				<div class="col-md-4 col-sm-4">
					<div class="service-item orange">
						<i class="fa fa-map-marker"></i>
						<h4>Create a booking</h4>
						<p>Our Geo-location based system allows
              you to find good staff, at your price, in
              whichever region your event is taking
              place.</p>
					</div>
				</div>
				<!-- Service Item -->
				<div class="col-md-4 col-sm-4">
					<div class="service-item pink">
						<i class="fa fa-dollar"></i>
						<h4>Automated billing and payment</h4>
						<p>Clients are billed 24hrs before the event and
              Peepz are paid 3 days after the booking..</p>
					</div>
				</div>
			</div>
		</div>
		<div class="contact spad">
      <p class="contact-info">Contact us for more information</p>
			<!-- Contact Form -->
			<form action="teaserwork.php?savecontact=y" id="contact-form" method="POST">
				<div class="row">
					<div class="col-sm-6">
						<input type="text" name="name" id="name" required placeholder="Your Name*">
					</div>
					<div class="col-sm-6">
						<input type="email" name="email" id="email" required placeholder="Your Email*">
					</div>
					<div class="col-sm-12">
						<textarea id="message" name="message" required placeholder="Your Message*"></textarea>
						<div class="text-center">
							<button type="submit" class="site-btn btn-black-line" id="send-form">Send Message</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- ==== Left Area End ==== -->

	<!-- Subscribe form & text-->
	<!--<div id="register" class="mfp-hide subscribe-area">
		<div id="status">Registering...</div>
	</div>-->

  <div id="subscribe" class="mfp-hide subscribe-area">
		<h2><font class="top">Join Us</font> in changing the industry</h2>
		<p>Subscribe to us and we will keep you posted.</p>
		<form class="subform" id="mc-form">
			<input type="email" id="mc-email" placeholder="Enter Your Email">
			<button type="submit" class="subform-btn">Subscribe!</button>
			<label for="mc-email"></label>
		</form>
	</div>


	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
  <script>
		// initialize and setup facebook js sdk
		window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '118944778770206',
		      xfbml      : true,
		      version    : 'v2.10'
		    });
		    FB.getLoginStatus(function(response) {
		    	if (response.status === 'connected') {
		    		//document.getElementById('status').innerHTML = 'We are connected.';
		    	} else if (response.status === 'not_authorized') {
		    		//document.getElementById('status').innerHTML = 'We are not logged in.'
		    	} else {
		    		//document.getElementById('status').innerHTML = 'You are not logged into Facebook.';
		    	}
		    });
		};
		(function(d, s, id){
		    var js, fjs = d.getElementsByTagName(s)[0];
		    if (d.getElementById(id)) {return;}
		    js = d.createElement(s); js.id = id;
		    js.src = "//connect.facebook.net/en_US/sdk.js";
		    fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		// login with facebook with extra permissions
		function registerfacebook() {
      $.magnificPopup.open({
                items: {
                    src: '<div id="register" class="subscribe-area">'
                        + '<p id="status">Connecting to facebook...</p>'
                        + '</div>',

                    type:'inline'
                },
                closeBtnInside: true
         });

			FB.login(function(response) {
				if (response.status === 'connected') {
		    		document.getElementById('status').innerHTML = 'We are connected.';
            getInfo();
		    	} else if (response.status === 'not_authorized') {
		    		document.getElementById('status').innerHTML = 'We are not logged in.'
		    	} else {
		    		document.getElementById('status').innerHTML = 'You are not logged into Facebook.';
		    	}
			}, {scope: 'email'});
		}

		// getting basic user info
		function getInfo() {
			FB.api('/me', 'GET', {fields: 'first_name,last_name,name,email,gender,locale,id,link,picture.width(150).height(150)'}, function(response) {
        $.ajax({
          url:  'teaserwork.php?register=y',
          type: 'POST',
          data: {
                    'name': response.name,
                    'first_name': response.first_name,
                    'last_name': response.last_name,
                    'email': response.email,
                    'gender': response.gender,
                    'locale': response.locale,
                    'id': response.id,
                    'picture': response.picture.data.url,
                    'link': response.link
                },
          success : function(text){
            if (text == "success"){
              document.getElementById('status').innerHTML = '<h2>Hi <font class="top">' + response.name +'</font> Thank you for joining us.</h2>';
            }
            else {
                document.getElementById('status').innerHTML = text;
            }
          }
        });
			});
		}
	</script>
</body>
</html>
