<?php
  $RequireLogin = true;
  require_once "../functions/functionmain.php";

  call_user_func('profile_' . Get("fn", 'Default'));

  function profile_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');
    profile_Display();

  }

  function profile_Display()
  {
      $ProfileID = Get('profileid');
      $EditButton= '';
      if($ProfileID = $_SESSION['userid'])
      {
          $EditButton  ="<div class='listbtn'><a href='#.' class='btn'><i class='fa fa-floppy-o' aria-hidden='true'></i> Edit Details</a></div>";
      }

      profile_DisplayHeader();

      echo "<div class='row'>
                    <div class='col-md-4'>";
      profile_DisplayDetails();
      profile_DisplayRatings();

      echo "</div>
                  <div class='col-md-8'>";
      profile_DisplayAbout();
      profile_DisplayPortfolio();
     //profile_DisplayExperience();

      echo "</div>
                  </div>";


  }

  function profile_DisplayHeader()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
      $EditButton= $Return ='';
    if($ProfileID = $_SESSION['userid'])
    {
        $EditButton = "<div class='listbtn'>" .Button('Edit Details', "admin/editprofile.php?fn=EditDetails&profileid=$ProfileID", 'divProfileHeader', '', 'fa-floppy-o') ."</div>";
    }

    $SQL = "select contactid,firstnames,surname,email,cellno, coalesce(suburb,0) as suburb,
            coalesce(profileimage, '../logos/peepz_.jpg') as profileimage from contacts where contactid=$1";
    if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
    {
      $rwDetail = $Details[0];

      if($Refresh =='')
      {
        $Return .= <<<HTML
      <div class="card">
        <div class="card-body" id='divProfileHeader'>
HTML;
      }

    $ProfileImage = $rwDetail['profileimage'];

    $Return .= <<<HTML
              <div class="row">
                  <div class="col-md-2 col-sm-4">
                        <img class='img-circle' src="$ProfileImage" alt="" height='150px' width='150px'>
                  </div>
                  <div class="col-md-4 col-sm-4">
                      <h4 class="card-title m-t-10">$rwDetail[firstnames] $rwDetail[surname] $EditButton</h4>
                        <h6 class="card-subtitle">
HTML;

    $Return .= DisplayStars(5);

    $Return .= <<<HTML
                        </h6>
                        <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> $rwDetail[suburb]</div>

                  </div>
                <div class="col-md-6 col-sm-4">
HTML;


    $Sql = "select r.rating,r.message,reviewedby,
            (select firstnames || ' ' || surname from contacts where contactid=r.reviewedby) as reviewedbyname,
            (select name from companies where companyid=j.companyid) as brand
            from reviews r
            join jobs j
            on r.jobid=j.jobid
            where r.contactid=$1 order by rating desc, datereviewed";
    if(execute_sql($Sql, $RaReviews, $error,["$ProfileID"]))
    {

    }

    $Return .= "    </div>
              </div>";

    $Return .= "<!-- Buttons -->
        <div class='GigButtons'>";

    if($Refresh =='')
    {
      if($ProfileID = $_SESSION['userid'])
      {
        //$Return .= Button('Edit Settings', 'admin/editprofile.php?fn=EditAbout&profileid=2', 'divProfileAbout', '', 'fa-cog');
        //$Return .= Button('Edit Profile via Wizard', 'admin/editprofile.php?fn=EditAbout&profileid=2', 'divProfileAbout', '', 'fa-edit');
      }
      else
      {
        $Return .= Button('Hire', 'admin/editprofile.php?fn=EditAbout&profileid=2', 'divProfileAbout', 'apply', 'fa-paper-plane');
        $Return .= Button('Send Message', '', '', '', 'fa-envelope');
        $Return .= Button('Shortlist User', '', '', '', 'fa-floppy-o');
      }
    }

    $Return .= "</div>";

    if($Refresh =='')
      {
        $Return .= "</div></div>";
      }
    }
     echo $Return;

  }

  function profile_DisplayAbout()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $EditButton= '';
    if($ProfileID = $_SESSION['userid'])
    {
        $EditButton = "<div class='listbtn'>" .Button('Edit Details', "admin/editprofile.php?fn=EditAbout&profileid=$ProfileID", 'divProfileAbout', '', 'fa-floppy-o') ."</div>";
    }

    $About = DB("select description from contacts where contactid=$ProfileID");

    if($Refresh =='')
    {
      $Return = "<div class='card'>
                  <div class='card-header'>
                       About me $EditButton
                  </div>
          <div class='card-body' id='divProfileAbout'>";
    }
    $Return .= <<<HTML
            <p>$About </p>

HTML;

    if($Refresh =='')
    {
      $Return .= "</div>
        </div>";
    }

    echo $Return;

  }

  function profile_DisplayExperience()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $EditButton= '';
    if($ProfileID = $_SESSION['userid'])
    {
        $EditButton = "<div class='listbtn'>" .Button('Edit Details', "admin/editprofile.php?fn=EditExperience&profileid=$ProfileID", 'divProfileAbout', '', 'fa-floppy-o') ."</div>";
    }
    $Return = <<<HTML
      <div class="card">
        <div class='card-header'>
             Experience $EditButton
        </div>
          <div class="card-body">
            <ul class="experienceList">
              <li>
                <div class="row">
                  <div class="col-md-2"><img src="images/employers/emplogo1.jpg" alt="your alt text"></div>
                  <div class="col-md-10">
                    <h4>Company Name</h4>
                    <div class="row">
                      <div class="col-md-6">www.companywebsite.com</div>
                      <div class="col-md-6">From 2014 - Present</div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pellentesque massa vel lorem fermentum fringilla. Pellentesque id est et neque blandit ornare</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="col-md-2"><img src="images/employers/emplogo1.jpg" alt="your alt text"></div>
                  <div class="col-md-10">
                    <h4>Company Name</h4>
                    <div class="row">
                      <div class="col-md-6">www.companywebsite.com</div>
                      <div class="col-md-6">From 2014 - Present</div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pellentesque massa vel lorem fermentum fringilla. Pellentesque id est et neque blandit ornare</p>
                  </div>
                </div>
              </li>
              <li>
                <div class="row">
                  <div class="col-md-2"><img src="images/employers/emplogo1.jpg" alt="your alt text"></div>
                  <div class="col-md-10">
                    <h4>Company Name</h4>
                    <div class="row">
                      <div class="col-md-6">www.companywebsite.com</div>
                      <div class="col-md-6">From 2014 - Present</div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pellentesque massa vel lorem fermentum fringilla. Pellentesque id est et neque blandit ornare</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>

HTML;

    echo $Return;

  }

  function profile_DisplayReviews()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $Return = <<<HTML


HTML;

    echo $Return;

  }

  function profile_DisplayPortfolio()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $EditButton= $Return ='';
    $Missing = [];
    $Path = "portfolio/";
    //define ('MAIN_ROOT', '/home/craigv1/public_html/');
    define ('MAIN_ROOT', $_SERVER["DOCUMENT_ROOT"] ."/");
    $DefaultImg = $Path. "portfolio.jpg";

    $Image1 = $Path. "portfolio_1_$ProfileID.jpg";
    $Image2 = $Path. "portfolio_2_$ProfileID.jpg";
    $Image3 = $Path. "portfolio_3_$ProfileID.jpg";
    $Image4 = $Path. "portfolio_4_$ProfileID.jpg";
    $Image5 = $Path. "portfolio_5_$ProfileID.jpg";
    $Image6 = $Path. "portfolio_6_$ProfileID.jpg";

    if($ProfileID = $_SESSION['userid'])
    {
        $EditButton = "<div class='listbtn'>" .Button('Edit Details', "admin/editprofile.php?fn=EditPortfolio&profileid=$ProfileID", 'divProfilePortfolio', '', 'fa-floppy-o') ."</div>";
    }
    $Sql = "select * from portfolios where contactid=$1";
    if(execute_sql($Sql, $RaPortfolio, $error,["$ProfileID"]))
    {
      $RowPortfolio = $RaPortfolio[0];
    }
    else
    {
      $RowPortfolio = [
          'title1' => 'Title Here',
          'description1' => 'Your Description Here',
          'title2' => 'Title Here',
          'description2' => 'Your Description Here',
          'title3' => 'Title Here',
          'description3' => 'Your Description Here',
          'title4' => 'Title Here',
          'description4' => 'Your Description Here',
          'title5' => 'Title Here',
          'description5' => 'Your Description Here',
          'title6' => 'Title Here',
          'description6' => 'Your Description Here'
      ];
    }
      if (!file_exists(MAIN_ROOT .$Image1))
      {
          $Image1 = $DefaultImg;
      }
      if (!file_exists(MAIN_ROOT .$Image2))
      {
          $Image2 = $DefaultImg;
      }
      if (!file_exists(MAIN_ROOT .$Image3))
      {
          $Image3 = $DefaultImg;
      }
      if (!file_exists(MAIN_ROOT .$Image4))
      {
          $Image4 = $DefaultImg;
      }
      if (!file_exists(MAIN_ROOT .$Image5))
      {
          $Image5 = $DefaultImg;
      }
      if (!file_exists(MAIN_ROOT .$Image6))
      {
          $Image6 = $DefaultImg;
      }

    if($Refresh =='')
      {
      $Return .= <<<HTML
        <div class="card">
          <div class='card-header'>
             Portfolio $EditButton
          </div>
          <div class="card-body" id='divProfilePortfolio'>

HTML;
      }

    $Return .= "<ul class='row userPortfolio'>";
    if (file_exists(MAIN_ROOT .$Image1) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image1" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title1]</h5>
                        <p>$RowPortfolio[description1]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }
    if (file_exists(MAIN_ROOT .$Image2) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image2" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title2]</h5>
                        <p>$RowPortfolio[description2]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }
    if (file_exists(MAIN_ROOT .$Image3) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image3" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title3]</h5>
                        <p>$RowPortfolio[description3]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }
    if (file_exists(MAIN_ROOT .$Image4) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image4" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title4]</h5>
                        <p>$RowPortfolio[description4]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }
    if (file_exists(MAIN_ROOT .$Image5) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image5" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title5]</h5>
                        <p>$RowPortfolio[description5]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }
    if (file_exists(MAIN_ROOT .$Image6) || $EditButton != '')
    {
    $Return .= <<<HTML
              <li class="col-md-6 col-sm-6">
                <div class="imgbox"><img src="$Image6" alt="your alt text">
                  <div class="itemHover">
                    <div class="infoItem">
                      <div class="itemtitle">
                        <h5>$RowPortfolio[title6]</h5>
                        <p>$RowPortfolio[description6]</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
HTML;
    }

    $Return .= "</ul>";
    if($Refresh =='')
    {
        $Return .= <<<HTML
          </div>
        </div>

HTML;
    }
    echo $Return;

  }

  function profile_DisplayRatings()
  {
    $ProfileID = Get('profileid');
    $Return = <<<HTML
        <div class="card">
          <div class='card-header'>
             Reviews
        </div>
          <div class="card-body">
          <div class="comment-widgets m-b-20">
HTML;

    $Sql = "select r.rating,r.message,reviewedby,
            (select firstnames || ' ' || surname from contacts where contactid=r.reviewedby) as reviewedbyname,
            (select profileimage from contacts c where c.contactid=r.reviewedby) as profileimage,
            (select name from companies where companyid=j.companyid) as brand,
            (select display from stafftypes where stafftypeid = j.stafftypeid) as stafftype
            from reviews r
            join jobs j
            on r.jobid=j.jobid
            where r.contactid=$1 order by datereviewed";
    if(execute_sql($Sql, $RaReviews, $error,["$ProfileID"]))
    {
        foreach($RaReviews as $RowReviews)
        {
            $Return.= <<<HTML
                      <div class="d-flex flex-row comment-row">
                          <div class="p-2">
                              <span class="round"><img src="$RowReviews[profileimage]" alt="user" width="50"></span>
                          </div>
                               <div class="comment-text w-100">
                                    <h5>$RowReviews[reviewedbyname]</h5>
                                    <div class="comment-footer">
                                        <span class="date">
HTML;
            $Return .= DisplayStars($RowReviews['rating']);

            $Return .= <<<HTML
                                        </span>
                                        <!--<span class="label label-info">Pending</span> <span class="action-icons">
                                              <a href="javascript:void(0)"><i class="mdi mdi-pencil-circle"></i></a>
                                              <a href="javascript:void(0)"><i class="mdi mdi-checkbox-marked-circle"></i></a>
                                              <a href="javascript:void(0)"><i class="mdi mdi-heart"></i></a>
                                        </span>-->
                                    </div>
                                        <p class="m-b-5 m-t-10">$RowReviews[message]</p>
                                </div>
                          </div>
HTML;

        }
    }
    else
    {
      $Return .= "No reviews yet";
    }


    $Return.= "</div></div>
        </div>";



    echo $Return;

  }

  function profile_DisplayDetails()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $EditButton= '';
    if($ProfileID = $_SESSION['userid'])
    {
        $EditButton = "<div class='listbtn'>" .Button('Edit Details', "admin/editprofile.php?fn=EditAttributes&profileid=$ProfileID", 'divProfileAttr', '', 'fa-floppy-o') ."</div>";
    }
    $SQL= "select c.contactid,age_in_years(dob) as age,
            hasowntransport, firstlanguage, secondlanguage,
              datatype_value(14,gender) as gender, datatype_value(15,race) as race,
              datatype_value(103,height) as height, weight,
              datatype_value(102,pantsize) as pantsize,datatype_value(102,shirtsize) as shirtsize,
              datatype_value(102,dresssize) as dresssize,datatype_value(104,shoesize) as shoesize,
              datatype_value(100,visibletatoos) as visibletatoos,datatype_value(101,haircolour) as haircolour,
              datatype_value(100,visiblepiercings) as visiblepiercings
              from contacts c
              where c.contactid=$1";
    $Return="";
    if($Refresh =='')
    {
      $Return .= "<div class='card'>
                    <div class='card-header'>
                       Candidate Detail $EditButton
                    </div>
                  <div class='card-body' id='divProfileAttr'>";
    }

    if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
    {
      $rwDetail = $Details[0];

      $Return .= <<<HTML

            <ul class="jbdetail">
              <li class="row">
                <div class="col-md-6 col-xs-6">Own Transport</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[hasowntransport]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Gender</div>
                <div class="col-md-6 col-xs-6"><span class="permanent">$rwDetail[gender]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Age</div>
                <div class="col-md-6 col-xs-6"><span class="freelance">$rwDetail[age]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Language</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[firstlanguage]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Other Languages</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[secondlanguage]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Gender</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[gender]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Echnic Background</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[race]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Height</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[height]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Weight</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[weight]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Pants Size</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[pantsize]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Shirt Size</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[shirtsize]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Dress Size</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[dresssize]</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">Shoe Size</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[shoesize]</span></div>
              </li>
         <li class="row">
                <div class="col-md-6 col-xs-6">Visible Tatoos</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[visibletatoos]</span></div>
              </li>
         <li class="row">
                <div class="col-md-6 col-xs-6">Hair Colour</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[haircolour]</span></div>
              </li>
         <li class="row">
                <div class="col-md-6 col-xs-6">Visible Piercings</div>
                <div class="col-md-6 col-xs-6"><span>$rwDetail[visiblepiercings]</span></div>
              </li>
            </ul>

HTML;
  }
  else
  {
      $Return .= "Oops somthing went wrong. Please try again";
  }
  if($Refresh =='')
    {
      $Return .= "</div>
        </div>";
    }
    echo $Return;


  }

  function profile_DisplayMessage()
  {
    $ProfileID = Get('profileid');
    $Refresh = Get('refresh');
    $Return = <<<HTML


HTML;

    echo $Return;


  }





?>
