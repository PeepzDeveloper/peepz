<?php
    require_once "../functions/functionmain.php";

  call_user_func('editprofile_' . Get("fn", 'Default'));

  function editprofile_Default()
  {
    //require_once "functions/setpage.php";
    $ProfileID = Get('profileid');
    echo profile_EditMain();

  }

  function editprofile_Step1()
  {
      $ProfileID = Get('profileid');
      $FromPG = Get('frompg','index.php');
      $_GET['contentdiv'] = 'divStep1';
      $_GET['posturl'] = 'admin/editprofile.php?fn=Step2&frompg='.$FromPG.'&profileid=';

      echo "<div class='card' id='divStep1'>
                  <div class='card-header'>
                       Step 1: Personal details
                  </div>
          <div class='card-body'>";

      editprofile_EditDetails();

      echo "</div></div>";
      }

  function editprofile_Step2()
  {
      $ProfileID = Get('profileid');
      $FromPG = Get('frompg','index.php');

      $UserInfo = db('select isagent, coalesce(companyid,0) as companyid from contacts where contactid= $1',[$ProfileID]);

      if($UserInfo['isagent'] =='t' && $UserInfo['companyid'] == '0')
      {
        $_GET['contentdiv'] = 'divStep2';
        $_GET['posturl'] = 'admin/editprofile.php?fn=Step3_agent&frompg='.$FromPG.'&profileid='.$ProfileID.'&companyid=';

          echo "<div class='card' id='divStep2'>
                      <div class='card-header'>
                           Step 2: Company details
                      </div>
              <div class='card-body'>";

          editprofile_AddCompany();

          echo "</div></div>";
      }
      else
      {
        echo "<script language=javascript>document.location.href='index2.php';</script>";
      }
  }

  function editprofile_Step3_agent()
  {
      $ProfileID = Get('profileid');
      $FromPG = Get('frompg','index.php');
      $ContentDiv = Get('contentdiv', 'divStep1');
      $CompanyID = Get("companyid");

      if($CompanyID != '')
      {
        $SQL = "update contacts set companyid=$2 where contactid= $1";
        execute_sql($SQL, $Ra, $Error, [$ProfileID, $CompanyID]);
        echo "<script language=javascript>document.location.href='index2.php';</script>";
      }
      else
      {
        echo "Oops, something went wrong. Please try again";
      }

  }

  function editprofile_Step3()
  {
      $ProfileID = Get('profileid');
      $FromPG = Get('frompg','index.php');
      $ContentDiv = Get('contentdiv', 'divStep1');

  }

  function editprofile_EditAbout()
  {
      $ProfileID = Get('profileid');
      $FormOnly = Get('formonly');
      $ContentDiv = Get('contentdiv', 'divProfileAbout');
      $PostUrl = Get('posturl', "promo/profile.php?fn=DisplayAbout&refresh=true&profileid=");

      if($ProfileID == '')
      {
        echo "<p class='error'>Sorry, something went wrong.</p>";
      }
      else
      {
        if($FormOnly != 't')
        {

        }

        $About = DB("select description from contacts where contactid=$ProfileID");
        $Form = new FormPage("frmContact", "frmContact", "contacts", "contactid", "contactid", "$ProfileID");
        $Form->PostUrl = 'promo/profile.php?fn=DisplayAbout&refresh=true&profileid=';
        $Form->ContentDiv = "$ContentDiv";
        $Form->AddTextarea("description", "txtdescription", $About, "About", "", "", 'Please enter the surname', true, true, true,true);

        echo $Form->Display();
      }


  }

  function editprofile_EditAttributes()
  {
      $ProfileID = Get('profileid');
      $FormOnly = Get('formonly');
      $ContentDiv = Get('contentdiv', 'divProfileAttr');
      $PostUrl = Get('posturl', "promo/profile.php?fn=DisplayDetails&refresh=true&profileid=");

      if($ProfileID == '')
      {
        echo "<p class='error'>Sorry, something went wrong.</p>";
      }
      else
      {
        $SQL= "select c.contactid,dob,
            hasowntransport, firstlanguage, secondlanguage,
              gender, race,height,weight,pantsize,shirtsize,dresssize,shoesize,
              visibletatoos,haircolour,visiblepiercings
              from contacts c
              where c.contactid=$1";

        if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
        {
          $rwDetail = $Details[0];
          $Form = new FormPage("frmContact", "frmContact", "contacts", "contactid", "contactid", "$ProfileID");
          $Form->PostUrl = "$PostUrl";
          $Form->ContentDiv = "$ContentDiv";
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          /*$Form->AddCustomHTML("<p>Please note these settings are not there to be discriminatory and you are not required to fill them out. However we recommend that you do as they will assist your hirer  with any clothing requirements.
                                  </p><p>Values that haven’t been filled out will not appear on your profile. You may go to your settings and hide them from public view and will only be visible to the hirer once you have been hired.
                                   </p>");*/
          $Form->EndCol();
          $Form->EndRow();
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("firstlanguage", "txtfirstlanguage", $rwDetail['firstlanguage'], "First Language","","","",false,false,false,false);
          $Form->EndCol();
          $Form->EndRow();
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("secondlanguage", "txtsecondlanguage", $rwDetail['secondlanguage'], "Other Languages","","","",false,false,false,false);
          $Form->EndCol();
          $Form->EndRow();
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("gender", "selgender", $rwDetail["gender"], "Gender", "value", "display", "datatypevalues", "where datatypeid = 14", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //haircolour,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("haircolour", "selhaircolour", $rwDetail["haircolour"], "Hair Colour", "value", "display", "datatypevalues", "where datatypeid = 101", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //race,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("race", "selrace", $rwDetail["race"], "Ethnic Group", "value", "display", "datatypevalues", "where datatypeid = 15", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          ///height,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("height", "selheight", $rwDetail["height"], "Height", "value", "display", "datatypevalues", "where datatypeid = 103", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //weight,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("weight", "txtweight", $rwDetail['weight'], "Weight","","","",false,false,false,false);
          //$Form->AddSelect("weight", "selweight", $rwDetail["weight"], "Weight", "value", "display", "datatypevalues", "where datatypeid = 14", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //pantsize,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("pantsize", "selpantsize", $rwDetail["pantsize"], "Pants Size", "value", "display", "datatypevalues", "where datatypeid = 102", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //shirtsize,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("shirtsize", "selshirtsize", $rwDetail["shirtsize"], "Shirt Size", "value", "display", "datatypevalues", "where datatypeid = 102", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //dresssize,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("dresssize", "seldresssize", $rwDetail["dresssize"], "Dress Size", "value", "display", "datatypevalues", "where datatypeid = 102", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //shoesize,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("shoesize", "selshoesize", $rwDetail["shoesize"], "Shoe Size", "value", "display", "datatypevalues", "where datatypeid = 104", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //visibletatoos,
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("visibletatoos", "selvisibletatoos", $rwDetail["visibletatoos"], "Visible Tatoos", "value", "display", "datatypevalues", "where datatypeid = 100", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();
          //visiblepiercings
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddSelect("visiblepiercings", "selvisiblepiercings", $rwDetail["visiblepiercings"], "Visible Piercings", "value", "display", "datatypevalues", "where datatypeid = 100", 'display', '','', false, false, false, false);
          $Form->EndCol();
          $Form->EndRow();

          echo $Form->Display();
        }
        else
        {
          echo "<p class='error'>Sorry, something went wrong.</p>";
        }
      }
  }

  function editprofile_EditDetails()
  {
      $ProfileID = Get('profileid');
      $ContentDiv = Get('contentdiv', 'divProfileHeader');
      $PostUrl = html_entity_decode(Get('posturl', 'promo/profile.php?fn=DisplayHeader&refresh=true&profileid='));

      $FromPG = Get('frompg','index.php');

      if($ProfileID == '')
      {
        echo "<p class='error'>Sorry, something went wrong.</p>";
      }
      else
      {
        $SQL = "select firstnames,surname,email,cellno, idno, suburb, profileimage, configured, isagent, address, coordinates from contacts where contactid=$1";
        if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
        {
          $rwDetail = $Details[0];
          $Form = new FormPage("frmContact", "frmContact", "contacts", "contactid", "contactid", "$ProfileID");
          $Form->PostUrl = "$PostUrl";
          $Form->ContentDiv = "$ContentDiv";
          $Form->AddSubHeading("Personal Information");
          if($rwDetail['configured'] != 't')
          {
              $HTMLAgent = "<div class='btn-group' data-toggle='buttons' role='group'>
                              <label class='btn btn-outline btn-info " .
                                  ($rwDetail['isagent'] != 't' ? ' active' : '') ."' aria-pressed='true'>
                                  <input type='radio' name='field[isagent]' autocomplete='off' value='false' " .
                                  ($rwDetail['isagent'] != 't' ? ' checked' : '') .">
                                  <i class='ti-check text-active' aria-hidden='true'></i> Gig Seeker
                              </label>
                              <label class='btn btn-outline btn-info" .
                                  ($rwDetail['isagent'] == 't' ? ' active' : '') ."' aria-pressed='true'>
                                  <input type='radio' name='field[isagent]' autocomplete='off' value='true'" .
                                  ($rwDetail['isagent'] == 't' ? ' checked' : '') .">
                                  <i class='ti-check text-active' aria-hidden='true'></i> Agent / Gig poster
                              </label>
                            </div>";
              $Form->AddCustomCell($HTMLAgent);
          }

          $Form->AddFileDrop("profileimage", "txtprofileimage", $rwDetail['profileimage'], "Profile Image", "", "", '', true, true, true,true);
          $Form->AddTextBox("firstnames", "txtfirstnames", $rwDetail['firstnames'], "First Names", "", "", '', true, true, true,false, true);
          $Form->AddTextBox("surname", "txtsurname", $rwDetail['surname'], "Surname", "", "", '', false, true, true,true, true);
          $Form->AddTextBox("email", "txtemail", $rwDetail['email'], "Email", "", "", '', true, true, true,false, true);
          $Form->AddTextBox("cellno", "txtcellno", $rwDetail['cellno'], "Cell", "", "", '', false, true, true,true, true);
          $Form->AddTextBox("idno", "txtidno", $rwDetail['idno'], "ID No", "", "", '', true, true, true,false, true);
          $Form->AddTextBox("address", "address", $rwDetail['address'], "Address", "", "", '', false, true, true,true, true);
          $Form->AddHidden("coordinates", "coordinates", $rwDetail['coordinates']);
          $Form->AddCustomHTML('<img id="map_canvas" style="display:none;">');

          echo $Form->Display();
          echo <<<HTML
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'http://maps.googleapis.com/maps/api/js?key=AIzaSyA5h9a9VU1vQ_8CdWmIIZcLu9dAtTJvKb0&libraries=places',
                dataType: 'script',
                success: function() {
                    //Define Autocomplete Textbox
                    var input = document.getElementById('address');
                    var autocomplete = new google.maps.places.Autocomplete(input);

                    //Define Place Changed Event Listener
                    google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();
                        var view = lat + ',' + lng;

                        $('#map_canvas')
                            .attr('src','http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyA5h9a9VU1vQ_8CdWmIIZcLu9dAtTJvKb0&center=' + view + '&zoom=15&size=400x400&markers=color:green%7Clabel:S%7C' + view)
                            .show();
                        $('#coordinates').val(view);
                    })
                },
                async: true
            });
        });
    </script>
HTML;

        }
        else
        {
          echo "<p class='error'>Sorry, something went wrong.</p>";
        }
      }
  }

  function editprofile_EditPortfolio()
  {
      $ProfileID = Get('profileid');
      $ContentDiv = Get('contentdiv', 'divProfilePortfolio');

      if($ProfileID == '')
      {
        echo "<p class='error'>Sorry, something went wrong.</p>";
      }
      else
      {
        $Proceed = false;
        $SQL = "select * from portfolios where contactid=$1";
        if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
        {
          $rwDetail = $Details[0];
          $Proceed = true;
        }
        else
        {
          $SQL = "insert into portfolios(contactid) values($1) returning *";
          if(execute_sql($SQL, $Details, $error,["$ProfileID"]))
          {
            $rwDetail = $Details[0];
            $Proceed = true;
          }
        }

        if($Proceed)
        {
          $Form = new FormPage("frmportfolio", "frmportfolio", "portfolios", "contactid", "contactid", "$ProfileID");
          $Form->PostUrl = "promo/profile.php?fn=DisplayPortfolio&refresh=true&profileid=";
          $Form->ContentDiv = "$ContentDiv";


          $Path = "portfolio/";
          $DefaultImg = $Path. "portfolio.jpg";
          define ('MAIN_ROOT', $_SERVER["DOCUMENT_ROOT"] ."/peepz/");
          $Image1 = $Path. "portfolio_1_$ProfileID.jpg";
          $Image2 = $Path. "portfolio_2_$ProfileID.jpg";
          $Image3 = $Path. "portfolio_3_$ProfileID.jpg";
          $Image4 = $Path. "portfolio_4_$ProfileID.jpg";
          $Image5 = $Path. "portfolio_5_$ProfileID.jpg";
          $Image6 = $Path. "portfolio_6_$ProfileID.jpg";
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
          $HTML = "<div class='subtitle'>Yo Peepz, because 6 is such a great number, we gonna give you 6 images that you can use to strut your stuff. So pick wisely!</div>";
          $Form->AddCustomCell($HTML , false, false,true,true);
          $Form->AddSubHeading("Image 1");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio1", "txtportfolio1", $Image1, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title1", "txttitle1", $rwDetail['title1'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description1", "txtdescription1", $rwDetail['description1'], "Description", "", "", '', false, false, true,true);
          $Form->AddSubHeading("Image 2");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio2", "txtportfolio2", $Image2, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title2", "txttitle2", $rwDetail['title2'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description2", "txtdescription2", $rwDetail['description2'], "Description", "", "", '', false, false, true,true);
          $Form->AddSubHeading("Image 3");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio3", "txtportfolio3", $Image3, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title3", "txttitle3", $rwDetail['title3'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description3", "txtdescription3", $rwDetail['description3'], "Description", "", "", '', false, false, true,true);
          $Form->AddSubHeading("Image 4");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio4", "txtportfolio4", $Image4, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title4", "txttitle4", $rwDetail['title4'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description4", "txtdescription4", $rwDetail['description4'], "Description", "", "", '', false, false, true,true);
          $Form->AddSubHeading("Image 5");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio5", "txtportfolio5", $Image5, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title5", "txttitle5", $rwDetail['title5'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description5", "txtdescription5", $rwDetail['description5'], "Description", "", "", '', false, false, true,true);
          $Form->AddSubHeading("Image 6");
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddFileDrop("portfolio6", "txtportfolio6", $Image6, "Image", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextBox("title6", "txttitle6", $rwDetail['title6'], "Title", "", "", '', false, false, true,true);
          $Form->NewRow();
          $Form->NewCol("12", "12", "12");
          $Form->AddTextArea("description6", "txtdescription6", $rwDetail['description6'], "Description", "", "", '', false, false, true,true);


          echo $Form->Display();
        }
        else
        {
            echo "<p class='error'>Sorry, something went wrong.</p>";
        }

      }
  }

  function editprofile_AddCompany()
  {
      $ProfileID = Get('profileid');
      $ContentDiv = Get('contentdiv', 'divProfileHeader');
      $PostUrl = html_entity_decode(Get('posturl', 'promo/profile.php?fn=DisplayHeader&refresh=true&profileid='.$ProfileID.'&companyid='));
      $FromPG = Get('frompg','index.php');

      if($ProfileID == '')
      {
        echo "<p class='error'>Sorry, something went wrong.</p>";
      }
      else
      {
          $rwDetail = $Details[0];
          $Form = new FormPage("frmCompany", "frmCompany", "companies", "companyid", "companyid", "", true);
          $Form->PostUrl = $PostUrl;
          $Form->ContentDiv = "$ContentDiv";
          $Form->AddSubHeading("Company Details");
          $Form->AddSelect("companytypeid", "selcompanytypeid", '2', 'Category', 'companytypeid', 'display', 'companytypes', '', 'display', '', '', true, true, true, true, false);
          $Form->AddTextBox("name", "txtname", "", "Company Name", "", "", '', true, true, true,false, true);
          $Form->AddTextBox("tradingas", "txttradingas", "", "Trading As", "", "", '', false, true, true,true);
          $Form->AddTextBox("email", "txtemail", "", "Email", "", "", '', true, true, true,false);
          $Form->AddTextBox("officetel1", "txtofficetel1", "", "officetel1", "", "", '', false, true, true,true);
          $Form->AddTextBox("coregno", "txtcoregno", "", "Registration No", "", "", '', true, true, true,false, true);
          $Form->AddTextBox("vatno", "txtvatno", "", "VAT No", "", "", '', false, true, true,true);
          echo $Form->Display();
      }
  }


?>
