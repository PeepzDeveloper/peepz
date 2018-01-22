<?php
  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */
?>

  <!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="marketing event staff solution">
    <meta name="keywords" content="event, staff, promoter, brand ambassador, jobs, waiter, event software">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <title>Online Event/ Promo/ Modeling Gig Application</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.slimscroll.js"></script>
    <script src="../js/waves.js"></script>
    <script src="../js/sidebarmenu.js"></script>
    <script src="../js/sticky-kit.min.js"></script>
    <script src="../js/jquery.sparkline.min.js"></script>
    <script src="../js/custom.js"></script>
    <script>

      function LoadMainContent(pageurl)
      {
        $("#divMainContent").load(pageurl);
      }

      function LoadDivContent(pageurl, targetdiv)
      {
        $("#" + targetdiv).load(pageurl);
      }
      </script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class='preloader'>
        <svg class='circular' viewBox='25 25 50 50'>
            <circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id='wrapper' class='login-register login-sidebar' style='background-image:url(../images/bg2.jpg);'>
        <div class='login-box card'>
            <div class='card-body'>
                <form class='form-horizontal form-material' method='post' id='frmregister'>
                    <a href='javascript:void(0)' class='text-center db'><img src='../images/logo_pink.png' alt='Home' /></a>
                    <h3 class='box-title m-t-40 m-b-0'>Register Now</h3><small>Create your account and enjoy</small>
                    <div class='row'>
                        <div class='col-xs-12 col-sm-12 col-md-12 m-t-10 text-center'>
                            <div class='social'>
                                <a onclick="javascript:registerwithfacebook();" class='btn btn-facebook' data-toggle='tooltip' title='Login with Facebook'>
                                  <i aria-hidden='true'  style="padding-right:15px; border-right:1px solid white;" class='fa fa-facebook'></i>
                               Register with Facebook </a>
                              <!--<a href='javascript:void(0)' class='btn btn-googleplus' data-toggle='tooltip' title='Login with Google'> <i aria-hidden='true' class='fa fa-google-plus'></i> </a> -->
                            </div>
                        </div>
                    </div>
                    <div class='form-group m-t-20'>
                        <div class='col-xs-12'>
                            <input class='form-control' type='text' name='firstnames' required='' placeholder='Firstname'>
                        </div>
                    </div>
                    <div class='form-group m-t-20'>
                        <div class='col-xs-12'>
                            <input class='form-control' type='text' name='surname' required='' placeholder='Surname'>
                        </div>
                    </div>
                    <div class='form-group '>
                        <div class='col-xs-12'>
                            <input class='form-control' type='text' name='email' required='' placeholder='Email'>
                        </div>
                    </div>
                    <div class='form-group '>
                        <div class='col-xs-12'>
                            <input class='form-control' type='password' name='password' required='' placeholder='Password'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12'>
                            <input class='form-control' type='password' required='' placeholder='Confirm Password'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <div class='checkbox checkbox-primary p-t-0'>
                                <input id='checkbox-signup' type='checkbox'>
                                <label for='checkbox-signup'> I agree to all <a href='#'>Terms</a></label>
                            </div>
                        </div>
                    </div>
                    <div id="divsave" class='form-group alert alert-error'></div>
                    <div class='form-group text-center m-t-20'>
                        <div class='col-xs-12'>
                            <button class='btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light' type='submit'>Register</button>
                        </div>
                    </div>
                    <div class='form-group m-b-0'>
                        <div class='col-sm-12 text-center'>
                            <p>Already have an account? <a href='login.php' class='text-info m-l-5'><b>Sign In</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <script>
                $(document).ready(function (e) {
                  $("#frmregister").on('submit',(function(e) {
                    e.preventDefault();
                    $.ajax({
                      url: "../functions/registerwork.php?fn=register",
                      type: "POST",
                      data: new FormData(this),
                      contentType: false,
                      cache: false,
                      processData:false,
                      success: function(data)
                      {
                        var response = $(data);
                        var authResult = response.find('#authResult').val();
                        if(authResult == 'success')
                        {
                          parent.document.location.href='../index2.php';
                        }
                        else
                        {
                          $("#divsave").html(data);
                        }
                      }
                    });
                  }));

                });
                  // initialize and setup facebook js sdk
		window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '118944778770206',
          cookie  : true,
		      xfbml      : true,
		      version    : 'v2.10'
		    });
		    FB.getLoginStatus(function(response) {
		    	if (response.status === 'connected') {
		    		//document.getElementById('status').innerHTML = 'We are connected.';
            //alert(response.authResponse.userID);
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
		function registerwithfacebook() {
      FB.login(function(response) {
				if (response.status === 'connected') {
		    		//document.getElementById('status').innerHTML = 'We are connected.';
            getInfo();
		    	} else if (response.status === 'not_authorized') {
		    		$("#divsave").html('Error connecting to facebook. We are not logged in.')
		    	} else {
		    		$("#divsave").html('You are not logged into Facebook.');
		    	}
			}, {scope: 'email'});
		}

		// getting basic user info
		function getInfo() {
			FB.api('/me', 'GET', {fields: 'first_name,last_name,name,email,gender,locale,id,link,picture.width(150).height(150)'}, function(response) {
        $.ajax({
          url:  '../functions/registerwork.php?fn=registerFacebook',
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
              //$("#divsave").html('<h2>Hi <font class="top">' + response.name +'</font> Thank you for joining us.<br>Have a look at our <a href="https://www.facebook.com/peepzonline">facebook</a> page for updates</h2>');
              parent.document.location.href='../index2.php';
            }
            else {
                $("#divsave").html(text);
            }
            
          }
        });
			});
		}
              </script>

</body>

</html>