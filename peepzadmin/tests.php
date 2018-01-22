<?php

  require_once "../functions/functionmain.php";

  call_user_func('Address_' . Get("fn", 'Default'));

  function Address_Default()
  {
      require_once "../functions/formpage.php";
    $ContactID = Get('contactid');
    $JobID = Get('jobid');

    //$SQL = "select * from jobs where jobid=$1";
        //if(execute_sql($SQL, $Details, $error,["$JobID"]))
        //{
        //  $rwDetail = $Details[0];
          echo "<div class='row col-md-12'>
                <div class='card col-md-12'>
                <div class='card-body' id='divProfileHeader'>";
          echo "<div class='col-md-6'>";
          echo "<div class='card'>";
          $Form = new FormPage("frmGig", "frmGig", "jobs", "jobid", 'jobid',"$JobID");
          $Form->PostUrl = "admin/jobs.php?fn=ViewAdmin&jobid=";
          $Form->ContentDiv = "Gigdiv";
          $Form->MDcols = 12;
          $Form->LGcols = 12;
          $Form->AddHidden("jobid","txtjobid","$JobID");
          $Form->AddTextBox("name", 'txtname', "", 'name', '', '', '', true, true, true, true, true);
          $Form->AddTextarea("building", "txtbuilding", "", "building", "", "", '', true, true, true,true);
          $Form->AddTextBox("number", 'txtnumber', "", 'number', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("street", 'txtstreet', "", 'street', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("suburb", 'txtsuburb', "", 'suburb', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("town", 'txttown', "", 'town', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("postcode", 'txtpostcode', "", 'postcode', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("locality", 'txtlocality', "", 'locality', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("place_id", 'txtplace_id', "", 'place_id', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("placename", 'txtplacename', "", 'placename', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("lat", 'txtlat', "", 'lat', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("lng", 'txtlng', "", 'lng', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("clat", 'txtclat', "", 'clat', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("clng", 'txtclng', "", 'clng', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("zoom", 'txtzoom', "", 'zoom', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("country", 'txtcountry', "", 'country', '', '', '', true, true, true, true, true);
          $Form->AddTextBox("province", 'txtprovince', "", 'province', '', '', '', true, true, true, true, true);
          echo $Form->Display();
          echo "</div>
                </div>
                <div class='col-md-6'>
                  <div class='card'>
                    <div id=gmap style='height:300px;'>
                    </div>
                  </div>";
          echo "</div>
                  </div>
                  </div>
                  </div>";
        //}
        //else
        //{
        //  echo "<p class='error'>Sorry, something went wrong.</p>";
        //}


        $AddRw['lat'] = -29.7147929326568;
        $AddRw['lng'] = 25.174749;
        $AddRw['clat'] = -29.7147929326568;
        $AddRw['clng'] = 25.174749;
        $AddRw['zoom'] = 5;

          echo <<<EOS
          <script>

          try
          {
         parent.l_lat = $AddRw[lat];
         parent.l_lng = $AddRw[lng];
         parent.l_clat = $AddRw[clat];
         parent.l_clng = $AddRw[clng];
         parent.l_p_zoom = $AddRw[zoom];

         parent.d_lat = -29.7147929326568;
         parent.d_lng = 25.174749;
         parent.d_clat = -29.7147929326568;
         parent.d_clng = 25.174749;
         parent.d_zoom = 4;

         parent.googleApiReady = function(lat, lng, clat, clng, zoom, bl)
         {
             try
            {
                   var options = { componentRestrictions: { country: 'za'} };
                   var input = document.getElementById('sAddress');
                   var autocomplete = new google.maps.places.Autocomplete(input, options);
                   //google.maps.event.addListener(autocomplete, 'place_changed', function ()
                   autocomplete.addListener('place_changed', function()
                       {
                         g_setPlace(autocomplete.getPlace());
                       }
                     );

                   var country = document.getElementById('sCountry');

                   country.addEventListener('change', function()
                         {
                             var Country = document.getElementById('sCountry').value;
                             autocomplete.setComponentRestrictions({'country': Country});
                             setAutocompleteCountry();
                         }
                   );
            }
            catch (e)
            {
                alert('Error setting Autocomplete search box: ' + e.message);
            }

           parent.geo_initialize(lat, lng, clat, clng, zoom, bl);

         };

         //if (!parent.loadscript(parent.googlemapsurl + '&callback=googleApiReady'))
         //{
           parent.googleApiReady($AddRw[lat], $AddRw[lng], $AddRw[clat], $AddRw[clng], $AddRw[zoom],true);
          //}

         }
         catch (e)
         {
           alert('Error initializing Google Maps: ' + e.message);
         }
         </script>
EOS;

  }