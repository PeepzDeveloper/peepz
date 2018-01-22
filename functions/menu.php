<?php

  $INC_DIR = $_SERVER["DOCUMENT_ROOT"];
  function Menu_Item($Caption, $TargetUrl = '', $Icon ='beer', $HasSubitems = false, $Class = '')
  {
    $ClassHTML = ($Class == ''? '' : " class='$Class' ");
    $MenuItem = <<<HTML
      <li $ClassHTML> <a onclick="javascript:LoadMainContent('$TargetUrl');" class="waves-effect waves-dark" aria-expanded="false">
            <i class="mdi mdi-$Icon"></i><span class="hide-menu">$Caption</span></a>


HTML;

    return $MenuItem;
  }

  function Menu_Set(&$InitialPage)
  {


    $MenuItems = "";
    if(!isset($_SESSION['userid']))
    {
        $InitialPage = "login.php";

    }
    else
    {
      $ContactID = $_SESSION['userid'];
      $Userinfo = DB("select firstnames, surname, isagent, issuperuser, coalesce(companyid,0) as companyid, configured, profileimage, email  from contacts where contactid=$1", [$ContactID]);

      require_once "functions/header.php";

      $Name = $Userinfo["firstnames"];


      if($Userinfo['configured'] == "f")
      {

              $_GET['profileid'] = "$ContactID";
              $_GET['frompg'] = "index2.php";
              $_GET['fn'] = "Step1";
              $InitialPage = "admin/editprofile.php";
              echo <<<HTML
                      <script>
                      swal("Hello $Name", "Welcome to Peepz. In order to best serve you, we require you to verify some details.")

                      </script>
HTML;
          }
          elseif($Userinfo['isagent'] == "t" && $Userinfo['companyid'] == "0")
          {
              $_GET['profileid'] = "$ContactID";
              $_GET['frompg'] = "index.php";
              $_GET['fn'] = "Step2";
              $InitialPage ="admin/editprofile.php";
              echo <<<HTML
                      <script>
                      swal("Hello $Name, "Welcome to Peepz. In order to best serve you, we require you to verify some details.")

                      </script>
HTML;
          }
          else
          {

            /*echo <<<HTML
                      <script>
                      swal("Thank you for joining our Beta testing", "Please note that this version is very raw and A LOT of functionality has been left out intentionally for the purpose of this beta test. Hope you enjoy helping us make Peepz awesome.")

                      </script>
HTML;*/
            if($Userinfo['isagent'] == 't')
            {
                $InitialPage = "admin/dashboard.php";
                $MenuItems.= Menu_Item("Dashboard","admin/dashboard.php?profileid=$ContactID", "gauge");
                $MenuItems.= Menu_Item("Campaigns / Events","admin/projects.php?profileid=$ContactID","calendar");
                $MenuItems.= Menu_Item("Gigs","admin/jobs.php?fn=Default&contactid=$ContactID","tie");
                $MenuItems.= Menu_Item("Peepz Search","peepzsearch.php?profileid=$ContactID","emoticon-cool");
                $MenuItems.= Menu_Item("Messages","components/messages.php?profileid=$ContactID","comment-text-outline");
            }
            else
            {
                $InitialPage = "admin/dashboard.php";
                $MenuItems.= Menu_Item("Dashboard","promo/dashboard.php?profileid=$ContactID", "gauge");
                $MenuItems.= Menu_Item("Profile","promo/profile.php?profileid=$ContactID","face");
                $MenuItems.= Menu_Item("Calendar","components/calendar.php?profileid=$ContactID","calendar");
                $MenuItems.= Menu_Item("Gig Search","jobsearch.php?profileid=$ContactID","currency-usd");
                $MenuItems.= Menu_Item("Messages","components/messages.php?profileid=$ContactID","comment-text-outline");
            }

            if($Userinfo['issuperuser'] == 't' && $Userinfo['companyid'] == '1')
            {
                $MenuItems.= <<<HTML
                              <li> <a class='has-arrow waves-effect waves-dark' href='#' aria-expanded='false'>
                              <i class='mdi mdi-bullseye'></i><span class='hide-menu'>Peepz Admin</span></a>
                            <ul aria-expanded='false' class='collapse'>
                                <li><a onclick="javascript:LoadMainContent('peepzadmin/tests.php?profileid=$ContactID');">Test page </a></li>
                                <li><a onclick="javascript:LoadMainContent('peepzadmin/registrations.php?profileid=$ContactID');">Registrations</a></li>
                                <li><a onclick="javascript:LoadMainContent('peepzadmin/contactrequests.php?profileid=$ContactID');">Contact Requests</a></li>
                            </ul>
                        </li>
HTML;

            }

          }
    }

    return $MenuItems;

  }


  function Menu_Display(&$InitialPage)
  {
      $Menu = <<<HTML
        <aside class='left-sidebar'>
            <!-- Sidebar scroll-->
            <div class='scroll-sidebar'>
                <!-- Sidebar navigation-->
                <nav class='sidebar-nav'>
                    <ul id='sidebarnav'>
                        <li class='nav-small-cap'>PERSONAL</li>

HTML;

      $Menu .= Menu_Set($InitialPage);

      $Menu .= "
            </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>";


  return $Menu;
  }

?>
