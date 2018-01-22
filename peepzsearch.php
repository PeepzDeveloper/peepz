<?php
  $RequireLogin = true;
  require_once "functions/functionmain.php";

  call_user_func('peepzsearch_' . Get("fn", 'Default'));

  function peepzsearch_Default()
  {
    $ProfileID = Get('profileid');

    peepzsearch_Display();

  }

  function peepzsearch_Display()
  {
    $ProfileID = Get('profileid');

    peepzsearch_PageSearch();
    echo "<div class='row'>
      <div class='col-md-3 col-sm-6'>";
    //Gigsearch_LeftSearch();
    peepzsearch_LeftBar();
    echo "</div>";
    echo "<div class='col-md-9 col-sm-12' id='divSearchResults'>";
    peepzsearch_Results();
    echo "</div>";
  }

  function peepzsearch_PageSearch()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);

    if($ProfileID == '')
    {
      $LoginText = "<a href='#.' class='btn'><i class='fa fa-file-text' aria-hidden='true'></i> Login to set your profile</a>";
    }
    else
    {
      $Name = db("select firstnames from contacts where contactid = $1", [$ProfileID]);
      $LoginText = "<div class='randommessage'>Yo $Name<h3> Find your <span>Peepz here...</span></h3></div>";

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
                  if(querystring != "")
                  {
                    $("#divSearchResults").load('peepzsearch.php?fn=Results&search=yes' + querystring);
                  }
      }));
        </script>

HTML;

    echo $Return;
  }



  function peepzsearch_Results()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Search = Get('search');
    $Type = Get('type');
    $Date = Get('date');
    $Area = Get('area');
    $MinRate = Get('minrate');
    //$Return = "<ul class='searchList'>";
    $IsSuperUser = DB("select issuperuser from contacts where contactid=$1",$ProfileID);

    $FilterCompany = ($IsSuperUser == 't' ? '' : "(companyid <> 1) and ");
    $sSQL = "select contactid, (firstnames || ' ' || surname) as name,
              coalesce(profileimage, 'logos/jobimg.jpg') as profileimage, description,suburb, race, age_in_years(dob) as age
              from contacts
              where isagent = 'f'
              order by created desc";

    $Return = "<div class='col-12'>
                      <div class='row'>";
    if(execute_sql($sSQL, $ra, $error))
    {
      $cntX = 0;
      foreach ($ra as $row)
      {
        $PeepzID=$row['contactid'];
        $Url = "promo/profile.php?fn=Default&profileid=$PeepzID";

        //  $Bookingstatus = "<a onclick=\"LoadDivContent('$Url', '$PeepzID')\">Book Now</a>";

        if($cntX == 3)
        {
          //$Return .= "</div>";
          $cntX=0;
        }
        if($cntX == 0)
        {
          //$Return .= "<div class='row'>";
        }
        $Return .= "<div class='col-lg-3 col-md-3'>
                      <div class='card'>
                        <img class='card-img-top img-responsive' style='max-height: 180px;' src='" .html_entity_decode($row['profileimage']) ."' alt='$row[gender]'>
                        <div class='card-body'>
                          <h4 class='card-title'>$row[name]</h4>
                          <p class='card-text'>$row[description]</p>
                          <a href='#' class='btn btn-primary'>Shortlist</a>
                        </div>
                      </div>
                    </div>";


        $cntX++;
      }
      //$Return .= "</div>";
    }
    $Return .= "</div>
                </div>";

    echo $Return;
  }

  function peepzsearch_BookGig()
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

  function peepzsearch_LeftBar()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Return = "<div class='card'>
            <div class='card-header'>Top Peepz for you</div>
            <div class='card-body'>
            Coming Soon...
            </div>
            <div class='card-header'>Months top Peepz</div>
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
                      <td style='width:50px;'><span class='round'><img src='logos/peepz_1.jpg' alt='user' width='50'></span></td>
                      <td><h6>Craig Vermeulen</h6><small class='text-muted'>Hrs</small></td>
                      <td>R1000 (test data)</td>
                  </tr>

                   </tbody>
                  </table>
              </div>

          </div>
        </div>";



    echo $Return;
  }
?>
