<?php
 require_once "../functions/functionmain.php";

  call_user_func('Subs_' . Get("fn", 'Default'));

  function Subs_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');

    echo "<div id='Gigdiv'>";
    Subs_DisplayTable();
    echo "</div>";
  }

  function Subs_DisplayTable()
  {
    $ContactID = Get('profileid');
    //once happy with table - move to class / common function
    echo "<div class='card'>
              <div class='card-header'>Registrations </div>
              <div class='card-body'>
                  <div class='col-md-12 col-12 align-self-center'>";
    echo "        </div>
              </div>
              <div class='table-responsive'>
                   <table id='foo-table-Subs' class='table m-t-30 table-hover no-wrap contact-list' data-paging='true' data-page-size='20'>
                      <thead>
                        <tr>
                           <th>Contact #</th>
                           <th>Name</th>
                           <th>Company</th>
                           <th>IDNo</th>
                           <th>email</th>
                           <th>configured</th>
                           <th>facebook</th>
                       </tr>
                     </thead>
                     <tbody>";

    $sSQL = "select contactid,companyid,firstnames,surname,isagent,idno,email, created,configured,profileimage,facebook
              from contacts c order by contactid desc";

    if(execute_sql($sSQL, $ra, $error))
    {
      foreach ($ra as $row)
      {
        $Url = "";
        $ContactID = $row['contactid'];
        $Facebook = ($row['facebook'] == '' ? '' : "<a href='$row[facebook]' target='new'>View</a>");
        echo "<tr>
                  <td>
                  <a onclick=\"LoadDivContent('$Url', 'Gigdiv')\"><i class='fa fa-pencil' aria-hidden='true'></i>
                  $ContactID</a></td>
                 <td>
                    <img src='$row[profileimage]' width='40' class='img-circle'>$row[firstnames] $row[surname]</td>
                 <td>$row[companyid]</td>
                 <td>$row[idno]</td>
                 <td>$row[email]</td>
                 <td>$row[configured] </td>
                   <td>$Facebook </td>
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
var addrow = $('#foo-table-Subs');
	addrow.footable()

});
</script>
";


  }
