<?php
require_once "../functions/functionmain.php";

call_user_func('Gigs_' . Get("fn", 'Default'));

function Gigs_Default()
{
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');

    echo "<div id='Gigdiv'>";
    Gigs_DisplayTable();
    echo "</div>";
}

function Gigs_Edit()
{
    require_once "../functions/formpage.php";
    $ContactID = Get('contactid');
    $JobID = Get('jobid');

    echo "<div class='Gig-header'>
          <div class='Giginfo'>";

    if ($JobID == '') {
        echo "<p class='error'>Sorry, something went wrong.</p>";
    } else {
        $SQL = "select * from jobs where jobid=$1";
        if (execute_sql($SQL, $Details, $error, ["$JobID"])) {
            $rwDetail = $Details[0];
            $Form = new FormPage("frmGig", "frmGig", "jobs", "jobid", 'jobid', "$JobID");
            $Form->PostUrl = "admin/jobs.php?fn=ViewAdmin&jobid=";
            $Form->ContentDiv = "Gigdiv";
            $Form->AddSubHeading("Add New Gig");
            $Form->AddHidden("jobid", "txtjobid", "$JobID");
            $Form->AddTextBox("title", 'txtID', "$rwDetail[title]", 'Title', '', '', '', true, true, true, true, true);
            $Form->AddSelect("stafftypeid", "selstafftype", "$rwDetail[stafftypeid]", "Peepz Type", "stafftypeid", "display", "stafftypes", "", "display", "", "", true, true, true, true, false, "", "");
            $Form->AddTextarea("description", "txtdescription", "$rwDetail[description]", "Description", "", "", '', true, true, true, true);
            $Form->AddSelect("ratetypeid", "selratetype", "$rwDetail[ratetypeid]", "Rate Type", "ratetypeid", "display", "ratetypes", "", "display", "", "", true, true, true, true, false, "", "");
            $Form->AddCurrency("suggestedrate", 'txtrate', "$rwDetail[suggestedrate]", 'Rate', '', '', '', true, true, true, true, true);
            $Form->AddDate("datestart", 'DtStart', "$rwDetail[datestart]", 'Start Date', '', '', '', true, true, true, true, true);
            $Form->AddDate("dateend", 'dtEnd', "$rwDetail[dateend]", 'End Date', '', '', '', true, true, true, true, true);
            $Form->AddTime("timestart", 'tmStart', "$rwDetail[timestart]", 'Start Time', '', '', '', true, true, true, true, true);
            $Form->AddTime("timeend", 'tmEnd', "$rwDetail[timeend]", 'End Time', '', '', '', true, true, true, true, true);

            echo $Form->Display();
        } else {
            echo "<p class='error'>Sorry, something went wrong.</p>";
        }
    }

    echo "</div>
      </div>
          </div>";
}

function Gigs_ViewAdmin()
{
    require_once "../functions/formpage.php";
    $ContactID = Get('contactid');
    $JobID = Get('jobid');

    $sSQL = "select jobid,contactid,eventid,title,stafftypeid,stafftype(stafftypeid) as stafftype,statusid,
              status(statusid) as status, assignedto,datestart, coalesce(approvedrate,suggestedrate) as rate,
              'johannesburg' as suburb,
              (select count(*) from jobrequests where jobid = j.jobid) as requests
              from jobs j where jobid=$1";

    if (execute_sql($sSQL, $Ra, $error, [$JobID])) {
        $Row = $Ra[0];
        echo "<div class='card'>
            <div class='card-body'>
          <div class='row'>
            <div class='col-md-8'>
              <h2>$Row[stafftype]</h2>
              <div class='ptext'>Date Start: $Row[datestart]</div>
              <div class='salary'>Pay: <strong>$Row[rate]</strong></div>
            </div>
            <div class='col-md-4'>
              <div class='clientinfo'>
                <div class='title'>Status: $Row[status]</div>
                <div class='ptext'>$Row[suburb], ZA</div>
                <div class='opening'><a href='#.'>$Row[requests] requests booking Requests</a></div>
                <div class='clearfix'></div>
              </div>
            </div>
          </div>
        </div>
        ";

        //once happy with tab - move to class / common function
        echo "
                <ul class='nav nav-tabs' id='GigViewTabs' role='tablist'>
                  <li class='nav-item'> <a class='nav-link active' data-toggle='tab' data-func='Activity' href='#activity' role='tab' aria-expanded='true'><span class='hidden-sm-up'><i class='ti-home'></i></span> <span class='hidden-xs-down'>Activity</span></a> </li>
                    <li class='nav-item'> <a class='nav-link' data-toggle='tab' data-func='Requests' href='#requests' role='tab' aria-expanded='false'><span class='hidden-sm-up'><i class='ti-user'></i></span> <span class='hidden-xs-down'>Requests</span></a> </li>
                    <li class='nav-item'> <a class='nav-link' data-toggle='tab' data-func='Messages' href='#messages' role='tab' aria-expanded='false'><span class='hidden-sm-up'><i class='ti-email'></i></span> <span class='hidden-xs-down'>Messages</span></a> </li>
                    <li class='nav-item'> <a class='nav-link' data-toggle='tab' data-func='ToDo' href='#todo' role='tab' aria-expanded='false'><span class='hidden-sm-up'><i class='ti-check-box'></i></span> <span class='hidden-xs-down'>Notes / To Do</span></a> </li>
                    <li class='nav-item dropdown'>
                      <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                        <span class='hidden-sm-up'><i class='ti-email'></i></span> <span class='hidden-xs-down'>Edit</span>
                      </a>
                      <div class='dropdown-menu' x-placement='bottom-start' style='position: absolute; transform: translate3d(0px, 42px, 0px); top: 0px; left: 0px; will-change: transform;'>
                        <a class='dropdown-item' id='dropdown1-tab' href='#details' role='tab' data-toggle='tab' data-func='Edit' aria-controls='dropdown1' aria-expanded='true'>Details</a>
                        <a class='dropdown-item' id='dropdown2-tab' href='#address' role='tab' data-toggle='tab' data-func='Address' aria-controls='dropdown2' aria-expanded='true'>Address</a>
                        <a class='dropdown-item' id='dropdown3-tab' href='#settings' role='tab' data-toggle='tab' data-func='Settings' aria-controls='dropdown3' aria-expanded='true'>Settings</a>
                        <a class='dropdown-item' id='dropdown4-tab' href='#instructions' role='tab' data-toggle='tab' data-func='Instructions' aria-controls='dropdown4' aria-expanded='true'>Instructions</a>
                      </div>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class='tab-content tabcontent-border'>
                  <div class='tab-pane active p-20' id='activity' role='tabpanel' aria-expanded='true'>Loading...</div>
                  <div class='tab-pane p-20' id='requests' role='tabpanel' aria-expanded='false'>Loading...</div>
                  <div class='tab-pane p-20' id='messages' role='tabpanel' aria-expanded='false'>Loading...</div>
                  <div class='tab-pane p-20' id='todo' role='tabpanel' aria-expanded='false'>Loading...</div>
                  <div class='tab-pane fade p-20' id='details' role='tabpanel' aria-labelledby='dropdown1-tab' aria-expanded='false'>
                    <p>Loading...</p>
                  </div>
                  <div class='tab-pane fade p-20' id='address' role='tabpanel' aria-labelledby='dropdown2-tab' aria-expanded='false'>
                    <p>Loading...</p>
                  </div>
                  <div class='tab-pane fade p-20' id='settings' role='tabpanel' aria-labelledby='dropdown3-tab' aria-expanded='false'>
                    <p>Loading...</p>
                  </div>
                  <div class='tab-pane fade p-20' id='instructions' role='tabpanel' aria-labelledby='dropdown4-tab' aria-expanded='false'>
                    <p>Loading...</p>
                  </div>
                </div>
              </div>";

        echo <<<HTML
       <script>
    $(function() {
        var baseURL = '';

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href");
            var func = $(e.target).data("func");

            $(target).load(baseURL+'admin/jobs.php?fn=' + func + '&jobid=$JobID&contactid=$ContactID', function(){
                //$('#myTabs').tab(); //reinitialize tabs
            });
        });
    });
</script>
HTML;
        // <div class='GigButtons'> <a href='#.' class='btn apply'><i class='fa fa-paper-plane' aria-hidden='true'></i> Apply Now</a> <a href='#.' class='btn'><i class='fa fa-envelope' aria-hidden='true'></i> Email to Friend</a> <a href='#.' class='btn'><i class='fa fa-black-tie' aria-hidden='true'></i> Job Aleart</a> <a href='#.' class='btn'><i class='fa fa-floppy-o' aria-hidden='true'></i> Save This Job</a> <a href='#.' class='btn report'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Report Abuse</a> </div>
        echo "</div>";
    }
}

function Gigs_New()
{
    $request = new RequestHandler();
    $ContactID = $request->get('contactid');
    $EventID = $request->get('eventid');
    $CompanyID = db("select companyid from contacts where contactid=$1", [$ContactID]);
    $stafftypes = flatten(DB('SELECT stafftypeid, display FROM stafftypes ORDER BY display ASC;'));
    if ($EventID != "") {
        $EventDetails = DB("select * from events where eventid = $1", [$EventID]);
        $showMessage = false;
        $StartTime = ($EventDetails['timestart'] != '' ? $EventDetails['timestart'] : "");
        $EndTime = ($EventDetails['timeend'] != '' ? $EventDetails['timeend'] : "");
        $DateStart = ($EventDetails['datestart'] != '' ? $EventDetails['datestart'] : "");
        $DateEnd = ($EventDetails['dateend'] != '' ? $EventDetails['dateend'] : "");
    } else {
        $showMessage = true;
        $EventDetails = $StartTime = $EndTime = $DateStart = $DateEnd = "";
    }
    require_once TEMPLATE_DIR . 'Gigs/New.php';
}

function Gigs_GigDetail()
{
    echo "coming soon";
}

function Gigs_DisplayTable()
{
    $ContactID = Get('contactid');
    $CompanyID = db("select companyid from contacts where contactid=$1", [$ContactID]);
    //once happy with table - move to class / common function
    echo "<div class='card'>
              <div class='card-header'>Your gigs </div>
              <div class='card-body'>
                  <div class='col-md-12 col-12 align-self-center'>";
    echo Button("Add Standalone Gig", "admin/jobs.php?fn=New&contactid=$ContactID", "Gigdiv", "btn-success pull-right");
    echo "        </div>
              </div>
              <div class='table-responsive'>
                   <table id='foo-table-Gigs' class='table m-t-30 table-hover no-wrap contact-list' data-paging='true' data-page-size='10'>
                      <thead>
                        <tr>
                           <th>Gig #</th>
                           <th>Event</th>
                           <th>Title</th>
                           <th>Peepz Type</th>
                           <th>Status</th>
                           <th>Date</th>
                           <th>Awarded To</th>
                           <th>Notices</th>
                       </tr>
                     </thead>
                     <tbody>";

    $sSQL = "select jobid,contactid,eventid,title,stafftypeid,stafftype(stafftypeid) as stafftype,statusid,
              status(statusid) as status, assignedto,datestart,
              (select count(*) from jobrequests where jobid = j.jobid and agentstatus=1) as newrequests
              from jobs j where companyid=$1";

    if (execute_sql($sSQL, $ra, $error, [$CompanyID])) {
        foreach ($ra as $row) {
            $JobID = $row['jobid'];
            $Url = "admin/jobs.php?fn=ViewAdmin&jobid=$JobID&contactid=$ContactID";
            $Notifications = "";
            if ($row['newrequests'] != '0') {
                $Notifications .= "$row[newrequests] new booking requests";
            }
            echo "<tr>
                 <td>
                  <a onclick=\"LoadDivContent('$Url', 'Gigdiv')\"><i class='fa fa-pencil' aria-hidden='true'></i>
                  $JobID</a></td>
                 <td>$row[eventid]</td>
                 <td><a onclick=\"LoadDivContent('$Url', 'Gigdiv')\">$row[title]</a></td>
                 <td>$row[stafftype]</td>
                 <td><span class='label label-warning'>$row[status]</span> </td>
                 <td>$row[datestart]</td>
                 <td>$row[assignedto]</td>
                 <td>$Notifications </td>
             </tr>";

        }

    }

    echo " </tbody>
             <tfoot>
              <tr>
                  <td colspan='12'>
                      <div class='text-right'>
                           <ul class='pagination'> </ul>
                      </div>
                  </td>
              </tr>
             </tfoot>
             </table>
             </div>
             </div>

<script>
$(document).ready(function (e) {
var addrow = $('#foo-table-Gigs');
	addrow.footable()

});
</script>
";


}

function Gigs_Display()
{
    $ProfileID = Get('profileid');
    echo "Display";

}

function Gigs_Requests()
{
    $ProfileID = Get('profileid');
    echo "Requests functionality coming soon";

}

function Gigs_Activity()
{
    $ProfileID = Get('profileid');
    echo "activity functionality coming soon";

}

function Gigs_ToDo()
{
    $ProfileID = Get('profileid');
    echo "ToDo functionality coming soon";

}

function Gigs_Messages()
{
    $ProfileID = Get('profileid');
    echo "Messages functionality coming soon";

}

function Gigs_Address()
{
    $ProfileID = Get('profileid');
    echo "Address functionality coming soon";

}

function Gigs_Settings()
{
    $ProfileID = Get('profileid');
    echo "Settings functionality coming soon";

}

function Gigs_Instructions()
{
    $ProfileID = Get('profileid');
    echo "instructions functionality coming soon";

}

?>
