<?php
  $currpage = 'login.php';
  require_once "../functions/functionmain.php";

  if (Get("login") == 'y')
  {
    $loginValid = 'f';
    if (Post("email") != '' && Post("password") != '')
    {
      $loginValid = Login(Post("email"),Post("password"));
    }

    if (Post("oauth_uid") != '')
    {
      $loginValid = LoginFacebook(Post("oauth_uid"));
    }


    if ($loginValid == 'successful')
    {
      echo "<div id='divResult'>";
      echo "<input type='hidden' id='authResult' value='success'>";
      echo "User Authenticated";
      echo "</div>";
    }
    else
    {

      echo "<div class='ui-widget' id='divResult'>";
      echo "<input type='hidden' id='authResult' value='error'>";
      echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
      echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
      echo "$loginValid</p>";
      echo "</div>";
      echo "</div>";
    }
  }
  else
  {
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
                <form class='form-horizontal' method='post' id='frmlogin'>
                    <a href='javascript:void(0)' class='text-center db'>
                      <img src='../images/logo_pink.png' alt='Home' /></a>
                      <div class='row'>
                        <div class='col-xs-12 col-sm-12 col-md-12 m-t-10 text-center'>
                            <div class='social'>
                                <a onclick="javascript:loginwithfacebook();" class='btn  btn-facebook' data-toggle='tooltip' title='Login with Facebook'>
                                  <i aria-hidden='true'  style="padding-right:15px; border-right:1px solid white;" class='fa fa-facebook'></i>
                               Login with Facebook </a>
                              <!--<a href='javascript:void(0)' class='btn btn-googleplus' data-toggle='tooltip' title='Login with Google'> <i aria-hidden='true' class='fa fa-google-plus'></i> </a> -->
                            </div>
                        </div>
                    </div>
                    <div class='form-group m-t-40'>
                        <div class='col-xs-12'>
                            <input class='form-control' type='text' placeholder="Email or SA ID number" name="email"  required="">
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12'>
                            <input class='form-control' type='password' placeholder="Password" name="password"  required="">
                        </div>
                    </div>

                  <div id="divsave" class='form-group alert alert-error'>

                  </div>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <div class='checkbox checkbox-primary pull-left p-t-0'>
                                <input id='checkbox-signup' type='checkbox'>
                                <label for='checkbox-signup'> Remember me </label>
                            </div>
                            <a href='javascript:void(0)' id='to-recover' class='text-dark pull-right'><i class='fa fa-lock m-r-5'></i> Forgot pwd?</a> </div>
                    </div>
                    <div class='form-group text-center m-t-20'>
                        <div class='col-xs-12'>
                            <button class='btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light' type='submit'>Log In</button>

                        </div>
                    </div>

                    <div class='form-group m-b-0'>
                        <div class='col-sm-12 text-center'>
                            <p>Don't have an account?
                              <a href='register.php' class='text-primary m-l-5'><b>Sign Up</b></a></p>
                        </div>
                    </div>
                </form>
                <form class='form-horizontal' id='recoverform' action='index.html'>
                    <div class='form-group '>
                        <div class='col-xs-12'>
                            <h3>Recover Password</h3>
                            <p class='text-muted'>Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class='form-group '>
                        <div class='col-xs-12'>
                            <input class='form-control' type='text' required='' placeholder='Email'>
                        </div>
                    </div>
                    <div class='form-group text-center m-t-20'>
                        <div class='col-xs-12'>
                            <button class='btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light' type='submit'>Reset</button>
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
                  $("#frmlogin").on('submit',(function(e) {
                    e.preventDefault();
                    $.ajax({
                      url: "login.php?login=y", // Url to which the request is send
                      type: "POST",             // Type of request to be send, called as method
                      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                      contentType: false,       // The content type used when sending data to the server.
                      cache: false,             // To unable request pages to be cached
                      processData:false,        // To send DOMDocument or non processed data file it is set to false
                      success: function(data)   // A function to be called if request succeeds
                      {
                        var $response = $(data);
                        var authResult = $response.find('#authResult').val();
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

    function loginwithfacebook() {
      FB.login(function(response) {
				if (response.status === 'connected') {
		    		//document.getElementById('status').innerHTML = 'We are connected.';
            //getInfo();
            //alert('loggedin as ' + response.authResponse.userID);
            $.ajax({
                  url:  "login.php?login=y",
                  type: 'POST',
                  data: {
                            'oauth_uid': response.authResponse.userID
                        },
                  success : function(text){
                    var $response = $(text);
                        var authResult = $response.find('#authResult').val();
                        if(authResult == 'success')
                        {
                         parent.document.location.href='../index2.php';
                        }
                        else
                        {
                          $("#divsave").html(text);
                        }

                  }
                });
		    	} else if (response.status === 'not_authorized') {
		    		$("#divsave").html('Error connecting to facebook. We are not logged in.')
		    	} else {
		    		$("#divsave").html('You are not logged into Facebook.');
		    	}
			}, {scope: 'email'});
		}

              </script>

</body>
<?php

            }
    ?>
</html>