<?php
  $RequireLogin = true;
  require_once "../functions/functionmain.php";

  call_user_func('Gigsearch_' . Get("fn", 'Default'));

  function Gigsearch_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');
    Gigsearch_Display();
  }

  function Gigsearch_Display()
  {
    $ProfileID = Get('profileid');

    Gigsearch_PageSearch();
    echo "<div class='row'>
      <div class='col-md-3 col-sm-6'>";
    Gigsearch_LeftSearch();
    echo "</div>";
    echo "<div class='col-md-9 col-sm-12'>";
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
              <div class='col-md-4 col-sm-3'>
                <input type='text' class='form-control' placeholder='Gig Title' />
              </div>
              <div class='col-md-2 col-sm-2'>
                <select class='form-control'>
                  <option>Industry</option>
                </select>
              </div>
              <div class='col-md-2 col-sm-2'>
                <select class='form-control'>
                  <option>City</option>
                </select>
              </div>
              <div class='col-md-3 col-sm-3'>
                <select class='form-control'>
                  <option>Min. Hourly Rate</option>
                </select>
              </div>
              <div class='col-md-1 col-sm-2'>
                <button class='btn'><i class='fa fa-search' aria-hidden='true'></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>";

    echo $Return;
  }



  function Gigsearch_LeftSearch()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Return = "<div class='card'>
                <div class='card-body'>
            <h4 class='card-title'>Gigs By Title</h4>
            <ul class='optionlist'>
              <li>
                <input type='checkbox' name='checkname' id='webdesigner' />
                <label for='webdesigner'></label>
                Promoter <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='webdesigner' />
                <label for='webdesigner'></label>
                Model <span>12</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='3dgraphic' />
                <label for='3dgraphic'></label>
                Brand Brand Ambassador <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='graphic' />
                <label for='graphic'></label>
                Supervisors <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='electronicTech' />
                <label for='electronicTech'></label>
                Waiters <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='webgraphic' />
                <label for='webgraphic'></label>
                Bartender <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='brandmanager' />
                <label for='brandmanager'></label>
                Cocktail/Flair Bartender <span>33</span> </li>
              <li>
                <input type='checkbox' name='checkname' id='brandmanager' />
                <label for='brandmanager'></label>
                DJ / Band <span>33</span> </li>
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
            <button class='btn'><i class='fa fa-search' aria-hidden='true'></i> Search Gigs</button>
          </div>
          <!-- button end-->
        </div>
        </div>";

    echo $Return;
  }


  function Gigsearch_Results()
  {
    $ProfileID = Get('profileid',$_SESSION['userid']);
    $Return .= "<ul class='searchList'>";

    $sSQL = "select j.jobid,j.contactid,projectid,title,stafftypeid,stafftype(stafftypeid) as stafftype,assignedto,datestart,
              description, c.name, c.companyid, coalesce(c.logo,'images/jobs/jobimg.jpg') as logo,
              jr.jobrequestid, contactstatus, requeststatus(contactstatus) as contactstatus_display,
              agentstatus, requeststatus(agentstatus) as agentstatus_display
              from jobs j
              left join jobrequests jr on j.jobid=jr.jobid and jr.contactid=$1
              join companies c on j.companyid = c.companyid
              --where --statusid in (1) and coalesce(datestart,now())> (now() - interval '1 day')
              --and (j.jobrequestid is null or j.jobrequestid = jr.jobrequestid)
              order by datestart, title";

    if(execute_sql($sSQL, $ra, $error, [$ProfileID]))
    {
      foreach ($ra as $row)
      {
        $GigID=$row['jobid'];
        $Url = "admin/jobsearch.php?fn=BookGig&gigid=$GigID&profileid=$ProfileID";
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
    }
    $Return .= "</ul>";

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
?>
