<?php
  $RequireLogin = true;
  require_once "functions/functionmain.php";

  call_user_func('Gigsearch_' . Get("fn", 'Default'));

  function Gigsearch_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');

    //echo PageHeader('Gig search');

    Gigsearch_Display();

  }

  function Gigsearch_Display()
  {
    $ProfileID = Get('profileid');

    Gigsearch_PageSearch();
    echo "<div class='row'>
      <div class='col-md-3 col-sm-6'>";
    //Gigsearch_LeftSearch();
    Gigsearch_LeftBar();
    echo "</div>";
    echo "<div class='col-md-9 col-sm-12' id='divSearchResults'>";
    Gigsearch_Results();
    echo "</div>";
  }

  function Gigsearch_PageSearch()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);

    if($ProfileID == '')
    {
      $LoginText = "<a href='#.' class='btn'><i class='fa fa-file-text' aria-hidden='true'></i> Login to set your profile</a>";
    }
    else
    {
      $Name = db("select firstnames from contacts where contactid = $1", [$ProfileID]);
      $LoginText = "<div class='randommessage'>Yo $Name<h3> Book your <span>Gigs here...</span></h3></div>";

    }

    $Return = "<div class='card'><div class='card-body'>
      <div class='row'>
        <div class='col-md-3'>$LoginText</div>
        <div class='col-md-9'>
          <div class='searchform'>
            <div class='row'>
              <div class='col-md-2 col-sm-2'>
                <select class='form-control' id='type'>
                  <option value =''>Any Type</option>";

                  $SQL = "select stafftypeid, display from stafftypes order by stafftypeid";
                  if(execute_sql($SQL, $raST, $error))
                  {
                    foreach ($raST as $rowST)
                    {
                      $Return .= "<option value='$rowST[stafftypeid]'>$rowST[display]</option>";
                    }
                  }
     $Return .= "</select>
              </div>
              <div class='col-md-2 col-sm-2'>
                <select class='form-control' id='area'>
                  <option value=''>Any Area</option>
                  <option value='1'>Johannesburg - North</option>
                  <option value='2'>Johannesburg - South</option>
                  <option value='3'>Johannesburg - East</option>
                  <option value='4'>Johannesburg - West</option>
                  <option value='5'>Cape Town</option>
                  <option value='6'>Durban</option>
                  <option value='7'>PE</option>
                  <option value='8'>Bloemfontein</option>
                </select>
              </div>
              <div class='col-md-3 col-sm-3'>
                <select class='form-control' id='minrate'>
                  <option value='0'>R0 Min Hourly Rate</option>
                  <option value='50'>R50</option>
                  <option value='100'>R100</option>
                  <option value='150'>R150</option>
                  <option value='200'>R200</option>
                  <option value='250'>R250</option>
                  <option value='300'>R300</option>
                  <option value='350'>R350</option>
                </select>
              </div>
              <div class='col-md-3 col-sm-3'>
                Date
              </div>
              <div class='col-md-2 col-sm-2'>
                <button class='btn' id='btnTopSearch'><i class='fa fa-search' aria-hidden='true'></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>";

     $Return .= <<<HTML
        <script>
            $("#btnTopSearch").on('click',(function(e) {

                  // validate form
                  //e.preventDefault();
                  var querystring = "";

                  var type = $("#type").val();
                  if( type !== '')
                  {
                    querystring = querystring + "&type=" + type;
                  }
                  var minrate = $("#minrate").val();
                  if( minrate !== '')
                  {
                    querystring = querystring + "&minrate=" + minrate;
                  }
                  var area = $("#area").val();
                  if( area !== '')
                  {
                    querystring = querystring + "&area=" + area;
                  }

                  if(querystring != '')
                  {
                    $("#divSearchResults").load('jobsearch.php?fn=Results&search=yes' + querystring);
                  }
      }));
        </script>

HTML;

    echo $Return;
  }



  /*function Gigsearch_LeftSearch()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Return = "<div class='card'>
                <div class='card-body'>
            <h4 class='card-title'>Gigs By Title</h4>
            <ul class='optionlist'>
              <li>
                <input type='checkbox' name='stafftype[1]' id='Promoter' />
                <label for='Promoter'></label>
                Promoter <span>12</span> </li>
              <li>
                <input type='checkbox' name='stafftype[3]' id='Model' />
                <label for='Model'></label>
                Model <span>12</span> </li>
              <li>
                <input type='checkbox' name='stafftype[2]' id='BrandAmbassador' />
                <label for='BrandAmbassador'></label>
                Brand Ambassador <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[4]' id='Supervisors' />
                <label for='Supervisors'></label>
                Supervisors <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[5]' id='Waiters' />
                <label for='Waiters'></label>
                Waiters <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[6]' id='Bartender' />
                <label for='Bartender'></label>
                Bartender <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[11]' id='CocktailBartender' />
                <label for='CocktailBartender'></label>
                Cocktail/Flair Bartender <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[7]' id='DJ' />
                <label for='DJ'></label>
                DJ / Band <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[9]' id='Technical' />
                <label for='Technical'></label>
                Technical <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[12]' id='Setup' />
                <label for='Setup'></label>
                Setup Staff <span>33</span> </li>
              <li>
                <input type='checkbox' name='stafftype[8]' id='Speaker' />
                <label for='Speaker'></label>
                Guest Speaker <span>33</span> </li>
            </ul>

            <h4 class='card-title'>Gigs By City</h4>
            <ul class='optionlist'>
              <li>
                <input type='checkbox' name='checkname' id='newyork' />
                <label for='newyork'></label>
                Johannesburg <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='losangles' />
                <label for='losangles'></label>
                Cape Town <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='chicago' />
                <label for='chicago'></label>
                PE <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='houston' />
                <label for='houston'></label>
                Nelspruit <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='sandiego' />
                <label for='sandiego'></label>
                Bloemfontein <span>555</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='sanjose' />
                <label for='sanjose'></label>
                Durban <span>44</span> </li>
            </ul>

            <h4 class='card-title'>Top Companies</h4>
            <ul class='optionlist'>
              <li>
                <input type='checkbox' name='checkname' id='Envato' />
                <label for='Envato'></label>
                Envato <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='Themefores' />
                <label for='Themefores'></label>
                Themefores <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='GraphicRiver' />
                <label for='GraphicRiver'></label>
                Graphic River <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='Codecanyon' />
                <label for='Codecanyon'></label>
                Codecanyon <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='AudioJungle' />
                <label for='AudioJungle'></label>
                Audio Jungle <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='Videohive' />
                <label for='Videohive'></label>
                Videohive <span>33</span> </li>
            </ul>
            <h4 class='card-title'>Hourly Rate Range</h4>
            <ul class='optionlist'>
              <li>
                <input type='checkbox' name='checkname' id='price1' />
                <label for='price1'></label>
                0 to R100 <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='price2' />
                <label for='price2'></label>
                R10 to R200 <span>41</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='price3' />
                <label for='price3'></label>
                R200 to R350 <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='price6' />
                <label for='price6'></label>
                Above R350 <span>865</span> </li>
            </ul>
          <div class='searchnt'>
            <button class='btn' id='btnLeftSearch'><i class='fa fa-search' aria-hidden='true'></i> Search Gigs</button>
          </div>
          <!-- button end-->
        </div>
        </div>";



    echo $Return;
  }*/


  function Gigsearch_Results()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Search = Get('search');
    $Type = Get('type');
    $Area = Get('area');
    $StartDate = Get('startdate');
    $MinRate = Get('minrate');
    $IsSuperUser = DB("select issuperuser from contacts where contactid=$1",$ProfileID);
    $SearchSQL = "";
    if ($Type != '')
    {
      $SearchSQL .= " and (stafftypeid = $Type)";
    }
    $FilterCompany = ($IsSuperUser == 't' ? '' : "(c.companyid <> 1) and ");
    $sSQL = "select j.jobid,j.contactid,eventid,title,stafftypeid,stafftype(stafftypeid) as stafftype,assignedto,datestart,
              description, c.name, c.companyid, coalesce(c.logo,'logos/company_.jpg') as logo,
              jr.jobrequestid, contactstatus, requeststatus(contactstatus) as contactstatus_display,
              agentstatus, requeststatus(agentstatus) as agentstatus_display
              from jobs j
              left join jobrequests jr on j.jobid=jr.jobid and jr.contactid=$1
              join companies c on j.companyid = c.companyid
              where $FilterCompany coalesce(statusid,1) in (1)
              and coalesce(datestart,(now()- interval '1 day'))> (now() - interval '1 day')
              $SearchSQL
              --and (j.jobrequestid is null or j.jobrequestid = jr.jobrequestid)
              order by datestart, title";

    if(execute_sql($sSQL, $ra, $error, [$ProfileID]))
    {

      $Return = "<ul class='searchList'>";
      foreach ($ra as $row)
      {
        $GigID=$row['jobid'];
        $Url = "jobsearch.php?fn=BookGig&gigid=$GigID&profileid=$ProfileID";
        $Agentstatus =$row['agentstatus_display'];
        if($Agentstatus != '')
        {
          switch ($row['agentstatus'])
          {
            case 3:
              $Icon = "exclamation-triangle";
              $Class = "warning";
              break;
            case 4:
              $Icon = "exclamation-triangle";
              $Class = "warning";
              break;
            case 5:
              $Icon = "thumbs-up";
              $Class = "success";
              break;
            case 6:
              $Icon = "thumbs-up";
              $Class = "success";
              break;
            default:
              $Icon = "info-circle";
              $Class = "info";
          }
            $Bookingstatus = "<div class='alert alert-$Class'><h3 class='text-$Class'>
                            <i class='fa fa-$Icon'></i>$Agentstatus</h3></div>";
        }
        else
        {
          $Bookingstatus = "<a onclick=\"LoadDivContent('$Url', 'bookgig_$GigID')\">Book Now</a>";
        }

        $Return .= "<li>
            <div class='row'>
              <div class='col-md-8 col-sm-8'>
                <div class='Gigimg'><img src='$row[logo]' alt='Gig' /></div>
                <div class='Giginfo'>
                  <h3><a href='#.'>$row[stafftype]</a></h3>
                  <div class='companyName'><a href='#.'>$row[name]</a></div>
                  <div class='location'>$row[title]   - <span>Sandton</span></div>
                </div>
                <div class='clearfix'></div>
              </div>
              <div class='col-md-4 col-sm-4'>
                <div class='listbtn' id='bookgig_$GigID'>$Bookingstatus</div>
              </div>
            </div>
            <p>$row[description]</p>
          </li>";
      }
      $Return .= "</ul>";
    }
    else
    {
      $Return = "Sorry, No Gigs found";
    }


    echo $Return;
  }

  function Gigsearch_BookGig()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $GigID = Get('gigid');
    $ContactStatus = Get('status', '6');

    if($ProfileID != '' and $GigID != '')
    {
      $Params = [
          "contactid" => "$ProfileID",
          "jobid" => "$GigID",
          "contactstatus" => "$ContactStatus"
      ];
      $result = inserttable("jobrequests", $Params, "jobrequestid");

      if($result != '')
      {
        echo "<div class='alert alert-success'><h3 class='text-success'>
              <i class='fa fa-thumbs-up'></i>Request Sent</h3></div>";
      }

    }

  }

  function Gigsearch_LeftBar()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Return = "<div class='card'>
            <div class='card-header'>Top Gigs for you</div>
            <div class='card-body'>
            Coming Soon...
            </div>
            <div class='card-header'>Months top Hirers</div>
            <div class='card-body'>
             <div class='table-responsive'>
                 <table class='table table-hover earning-box'>
                 <thead>
                 <tr>
                 <th colspan='2'>Name</th>
                 <th>Paid</th>
                 </tr>
                 </thead>
                  <tbody>
                  <tr>
                      <td style='width:50px;'><span class='round'><img src='logos/company_1.jpg' alt='user' width='50'></span></td>
                      <td><h6>Peepz</h6><small class='text-muted'>Hrs</small></td>
                      <td>R1000</td>
                  </tr>

                   </tbody>
                  </table>
              </div>

          </div>
        </div>";



    echo $Return;
  }
?>
