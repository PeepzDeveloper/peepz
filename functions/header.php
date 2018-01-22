
<?php
  if(is_array($Userinfo))
  {
      echo <<<HTML
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="images/logo_white_icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="images/logo_white_icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="images/logo_white_text.png" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->
                         <img src="images/logo_white_text.png" class="light-logo" alt="homepage" /></span>
                          - BETA Release</a>
                </div>
HTML;
        if($Userinfo['configured'] == "t" || ($Userinfo['isagent'] == "t" && $Userinfo['companyid'] != "0"))
        {

            echo <<<HTML
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox scale-up-left">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
HTML;

            $sSQL = "select notificationid,message,dateadded,dateactioned,actionurl,title,
                    coalesce(icon,'link') as icon, coalesce(class,'info') as class
                      from notifications where contactid=$1 order by dateadded desc, dateactioned nulls first limit 5";

    if(execute_sql($sSQL, $raNotifications, $error, [$ContactID]))
    {
      foreach ($raNotifications as $rowN)
      {

          echo <<<HTML

                <a onclick="javascript:LoadMainContent('$rowN[actionurl]');">
                <div class="btn btn-$rowN[class] btn-circle"><i class="fa fa-$rowN[icon]"></i></div>
                <div class="mail-contnet">
                <h5>$rowN[title]</h5> <span class="mail-desc">$rowN[message]</span> <span class="time">$rowN[dateadded]</span> </div>
                </a>
HTML;


      }
    }



            echo <<<HTML
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" onclick="javascript:LoadMainContent('admin/notifications.php?profileid=$ContactID');"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
HTML;

            $NewCnt = DB("select count(messageid) from messages where contactto = $1 and dateread is null",[$ContactID]);
echo <<<HTML
             <div class="dropdown-menu mailbox scale-up-left" aria-labelledby="2">
                  <ul>
                       <li>
                           <div class="drop-title">You have $NewCnt new messages</div>
                       </li>
                       <li>
                           <div class="message-center">
HTML;

            $sSQL = "select messageid, substring(message from 0 for 80) as message,datesent,dateread,c.profileimage,
                      (c.firstnames || ' ' || c.surname) as fromname
                      from messages m
                      join contacts c
                      on m.contactfrom = c.contactid
                      where contactto=$1 order by datesent desc, dateread nulls first limit 5";

    if(execute_sql($sSQL, $raMessages, $error, [$ContactID]))
    {

      foreach ($raMessages as $rowM)
      {

          echo <<<HTML

                <a onclick="javascript:LoadMainContent('admin/messages.php?profileid=$ContactID&messageid=$rowM[messageid]');">
                   <div class="user-img"> <img src="$rowM[profileimage]" alt="user" class="img-circle">
                        <span class="profile-status online pull-right"></span> </div>
                   <div class="mail-contnet">
                        <h5>$rowM[fromname]</h5> <span class="mail-desc">$rowM[message]</span> <span class="time">$rowM[datesent]</span> </div>
                </a>

HTML;


      }
    }

            echo <<<HTML
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" onclick="javascript:LoadMainContent('admin/messages.php?profileid=$ContactID');"> <strong>See all messages</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i></a>
                            <div class="dropdown-menu scale-up-left">
                                <ul class="mega-dropdown-menu row">
                                    <li class="col-lg-3 col-xlg-2 m-b-30">
                                        <h4 class="m-b-20">CAROUSEL</h4>
                                        <!-- CAROUSEL -->
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner" role="listbox">
                                                <div class="carousel-item active">
                                                    <div class="container"> <img class="d-block img-fluid" src="efiling/news/img1.jpg" alt="First slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="efiling/news/img2.jpg" alt="Second slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="efiling/news/img3.jpg" alt="Third slide"></div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                                        </div>
                                        <!-- End CAROUSEL -->
                                    </li>
                                    <li class="col-lg-3 m-b-30">
                                        <h4 class="m-b-20">ACCORDION</h4>
                                        <!-- Accordian -->
                                        <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingOne">
                                                    <h5 class="mb-0">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  Collapsible Group Item #1
                                                </a>
                                              </h5> </div>
                                                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingTwo">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  Collapsible Group Item #2
                                                </a>
                                              </h5> </div>
                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingThree">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                  Collapsible Group Item #3
                                                </a>
                                              </h5> </div>
                                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3  m-b-30">
                                        <h4 class="m-b-20">CONTACT US</h4>
                                        <!-- Contact -->
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Enter email"> </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </form>
                                    </li>
                                    <li class="col-lg-3 col-xlg-4 m-b-30">
                                        <h4 class="m-b-20">List style</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">

                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="$Userinfo[profileimage]" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="$Userinfo[profileimage]" alt="user"></div>
                                            <div class="u-text">
                                                <h4>$Userinfo[firstnames]</h4>
                                                <p class="text-muted">$Userinfo[email]</p><a onclick="javascript:LoadMainContent('profile.php?profileid=$ContactID');" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a onclick="javascript:LoadMainContent('admin/editprofiletabbed.php?profileid=$ContactID');"><i class="ti-user"></i> Edit Profile</a></li>
                                    <li><a onclick="javascript:LoadMainContent('admin/accounts.php?profileid=$ContactID');"><i class="ti-wallet"></i> Accounts History</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a onclick="javascript:LoadMainContent('admin/settings.php?profileid=$ContactID');"><i class="ti-settings"></i>Settings</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="index2.php?logout=yes"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
HTML;
            }


        echo "    </nav>
        </header>";

  }

  ?>