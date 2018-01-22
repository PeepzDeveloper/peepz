<?php
  require_once "functionmain.php";

  call_user_func('register_' . Get("fn", 'Default'));

  function register_Default()
  {
    register_register();
  }

  function register_register()
  {
    $RegisterValid='failed';

    $Firstnames = Post('firstnames');
    $Surname = Post('surname');
    $Email = Post('email');
    $Password = Post('password');
    $IsAgent = Post('isagent','f');

    if ($Email != '' && $Password != '' && $Firstnames != '')
    {
      $RegisterValid = Register($Firstnames, $Surname, $Idno, $Cellno, $Email,$Password, $IsAgent);
    }

    if ($RegisterValid == 'successful')
    {
      echo "<div id='divResult'>";
      echo "<input type='hidden' id='authResult' value='success'>";
      echo "User Registered";
      echo "</div>";
    }
    else
    {

      echo "<div class='ui-widget' id='divResult'>";
      echo "<input type='hidden' id='authResult' value='error'>";
      echo "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
      echo "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>";
      echo "Error registering.</p>";
      echo "</div>";
      echo "</div>";
    }

  }
  function register_registerFacebook()
  {

    $Firstnames = validata(Post('first_name'));
    $Surname = validata(Post('last_name'));
    $name = validata(Post('name'));
    $Email = validata(Post('email'));
    $Gender = validata(Post('gender'));
    $Locale = validata(Post('locale'));
    $ID = validata(Post('id'));
    $Picture = validata(Post('picture'));
    $Link = validata(Post('link'));

    if ($name != '' && $ID != '')
    {
      $RegisterValid = RegisterFacebook('facebook',$ID,$Firstnames, $Surname, $Email,$Gender, $Locale,$Picture,$Link);
    }
    else
    {
      $RegisterValid='Missing Fields';
    }

    echo $RegisterValid;

  }
?>
