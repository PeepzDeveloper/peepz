<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta name="description" content="marketing event staff solution">
    <meta name="keywords" content="event, staff, promoter, brand ambassador, jobs, waiter, event software">-->
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <title>Online Event/ Promo/ Modeling Gig Application</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="css/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/default.css" id="theme" rel="stylesheet">
    <link href="css/dropify.css" rel="stylesheet">
    <link href="css/gigcustom.css" rel="stylesheet">
    <link href="css/badges.css" rel="stylesheet">
    <link href="css/footable.core.css" rel="stylesheet">
    <script src="js/sweetalert.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/sticky-kit.min.js"></script>
    <script src="js/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <script src="js/dropify.js"></script>
    <script src='js/footable.all.min.js'></script>
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

<body class="fix-header card-no-border logo-center">
  <?php

  /*try{
    $to = "craig_vermeulen@hotmail.com";
$subject = "Email from Peepz Site";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>hello</p>
<hr>
<p>
How are you
</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@peepz.online>' . "\r\n";

mail($to,$subject,$message,$headers);

echo "email sent";
}
catch (Exception $e)
{
  echo "error sending email";
  }*/
/*

  require_once "functions/functionmqin.php";
            $db = new Db();

            // Check whether user data already exists in database
            $prevQuery = "SELECT * FROM users
                          WHERE oauth_provider = 'facebook'
                          order by created desc";
            $Result = $db->select($prevQuery);
            if($Result === false)
            {
               echo "Error checking for previous records";
            }
            else
            {
                 foreach($Result as $Row)
                  {
                   $Picture =html_entity_decode($Row['picture']);
                   echo "<div class='md-12'>";
                   echo "<h2>$Row[first_name] $Row[last_name] (facebookid = $Row[oauth_uid])</h2>";
                    echo "<hr>";
                    echo "$Row[gender]<br>";
                    echo "$Row[locale]<br>";
                    echo "$Row[email]<br>";
                    echo "<a href='$Row[link]' target='new'>$Row[link]</a><br>";
                    echo  "<img src='$Picture'></div>";
                  }

            }*/

  require_once "functions/functionmain.php";
  echo "hello";
  $URL = "index.php";
  $Icon = Icon::Peepz;
  echo "<hr>";
  echo "Icon = $Icon";
echo "<hr>";
  $Glyph = new Icon(Icon::Peepz, $URL);
                 /*   $Glyph->Height = 11;
                    $Glyph->ToolTip = $ToolTip;
                    $Glyph->Classes = $Classes;
                    $Glyph->Style = $Style;*/

   //$Icon2 = (string)$Glyph;
   echo $Icon2;
   echo "<hr>";
   echo "<div class='card'>
                    <div class='card-header'>
                       Candidate Detail <div class='listbtn'>      <a onclick='LoadDivContent('admin/editprofile.php?fn=EditAttributes&amp;profileid=2', 'divProfileAttr')' class='btn '><i class='fa fa-floppy-o' aria-hidden='true'></i> Edit Details</a></div>
                    </div>
                  <div class='card-body' id='divProfileAttr'>
            <ul class='jbdetail'>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::OwnTransport, $URL) ." Own Transport</div>
                <div class='col-md-6 col-xs-6'><span></span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Gender1, $URL) ."Gender</div>
                <div class='col-md-6 col-xs-6'><span class='permanent'>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Gender, $URL) ."Age</div>
                <div class='col-md-6 col-xs-6'><span class='freelance'>37</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Language, $URL) ."Language</div>
                <div class='col-md-6 col-xs-6'><span></span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Gender, $URL) ."Other Languages</div>
                <div class='col-md-6 col-xs-6'><span></span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::EchnicBackground, $URL) ."Echnic Background</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Height, $URL) ."Height</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::Weight, $URL) ."Weight</div>
                <div class='col-md-6 col-xs-6'><span></span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::PantsSize, $URL) ."Pants Size</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::ShirtSize, $URL) ."Shirt Size</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::DressSize, $URL) ."Dress Size</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
              <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::ShoeSize, $URL) ."Shoe Size</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
         <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::VisibleTatoos, $URL) ."Visible Tatoos</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
         <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::HairColour, $URL) ."Hair Colour</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
         <li class='row'>
                <div class='col-md-6 col-xs-6'>" .new Icon(Icon::VisiblePiercings, $URL) ."Visible Piercings</div>
                <div class='col-md-6 col-xs-6'><span>Not Specified</span></div>
              </li>
            </ul>
</div>
        </div>";
?>
</body>

</html>