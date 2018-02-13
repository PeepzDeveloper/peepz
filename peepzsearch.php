<?php
$RequireLogin = true;
require_once "functions/functionmain.php";

call_user_func('peepzsearch_' . Get("fn", 'Default'));

function peepzsearch_Default()
{
    peepzsearch_Display();
}

function peepzsearch_Display()
{
    peepzsearch_PageSearch();
    echo "<div class='row'>
      <div class='col-md-3 col-sm-6'>";
    peepzsearch_LeftBar();
    echo "</div>";
    echo "<div class='col-md-9 col-sm-12' id='divSearchResults'>";
    peepzsearch_Results();
    echo "</div>";
}

function peepzsearch_PageSearch()
{
    $ProfileID = Get('profileid', $_SESSION['userid']);

    if (empty($ProfileID) === false) {
        $Name = DB("SELECT firstnames FROM contacts WHERE contactid = $1", [$ProfileID]);
    }

    $staffDisplaySql = "SELECT stafftypeid, display FROM stafftypes ORDER BY stafftypeid";
    $staffTypes = flatten(DB($staffDisplaySql));

    require_once TEMPLATE_DIR . 'PeepzSearch/Index.php';
}


function peepzsearch_Results()
{
    $ProfileID = Get('profileid', $_SESSION['userid']);
    $Search = Get('search');
    $Type = Get('type');
    $Date = Get('date');
    $Area = Get('area');
    $MinRate = Get('minrate');
    $IsSuperUser = DB("SELECT issuperuser FROM contacts WHERE contactid=$1", $ProfileID);

    $FilterCompany = ($IsSuperUser == 't' ? '' : "(companyid <> 1) and ");
    $searchSql = <<<SQL
SELECT
    contactid,
    (firstnames || ' ' || surname) AS name,
    COALESCE(profileimage, 'logos/jobimg.jpg') AS profileimage,
    description,
    suburb,
    race,
    age_in_years(dob) AS age,
    gender
FROM contacts
WHERE isagent = 'f'
ORDER BY name ASC;
SQL;

    $foundPeepz = DB($searchSql);

    require_once TEMPLATE_DIR . 'PeepzSearch/Search.php';
}

function peepzsearch_BookGig()
{
    $ProfileID = Get('profileid', $_SESSION['userid']);
    $GigID = Get('gigid');
    $ContactStatus = Get('status', '6');

    if ($ProfileID != '' and $GigID != '') {
        $Params = [
            "contactid" => "$ProfileID",
            "jobid" => "$GigID",
            "contactstatus" => "$ContactStatus"
        ];
        $result = inserttable("jobrequests", $Params, "jobrequestid");

        if ($result != '') {
            echo "<div class='alert alert-success'><h3 class='text-success'>
              <i class='fa fa-thumbs-up'></i>Request Sent</h3></div>";
        }

    }

}

function peepzsearch_LeftBar()
{
    require_once TEMPLATE_DIR . 'PeepzSearch/LeftBar.php';
}

?>
