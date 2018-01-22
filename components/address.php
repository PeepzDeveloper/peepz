<?php
require_once "functionmain.php";

call_user_func('address_' . Get("fn", 'Default'));

function address_AddNew()
{
    require_once "../functions/formpage.php";
    $ContactID = Get('contactid');
    $JobID = Get('jobid');

    $AddRw = [];
    $UpdateLookup = SPostGet('updatelookup', false);

    // Clean up apostrophes
    foreach (array ('num', 'street', 'suburb', 'town', 'locality', 'building', 'placename', 'province', 'provincename') as $Fld)
    {
       $AddRw[$Fld] = '';
    }

    $AddRw['type'] = 1;
    $AddRw['person_id'] = $Person;
    $AddRw['lat'] = -29.7147929326568;
    $AddRw['lng'] = 25.174749;
    $AddRw['clat'] = -29.7147929326568;
    $AddRw['clng'] = 25.174749;
    $AddRw['zoom'] = 5;

    $Form = new InputForm("Address");
    $Form->Columns = 3;
    $Form->Widths = array('300px', '300px', '100px');
    $Form->ShowPDF = false;
    $Form->Bootstrap= true;
    $Form->BootstrapColumns = true;

    $Form->Action->Parameter->func = 'AddNew_Step3';
    $Form->Action->Parameter->updatelookup = $UpdateLookup;

    $Form->AddButton(Button::Save);

    $Cell = "<input id='type' type=hidden name='type' value=$AddRw[type]>";
    $Cell .= "<input id='person_id' type=hidden name='person_id' value=$Person>";
    $Cell .= "<input id='lat' type=hidden name='lat' value=$AddRw[lat]>";
    $Cell .= "<input id='lng' type=hidden name='lng' value=$AddRw[lng]>";
    $Cell .= "<input id='clat' type=hidden name='clat' value=$AddRw[clat]>";
    $Cell .= "<input id='clng' type=hidden name='clng' value=$AddRw[clng]>";
    $Cell .= "<input id='zoom' type=hidden name='zoom' value=$AddRw[zoom]>";

    $Form->AddInput(2,In::Text, 'shortname', 'Friendly name','',[]," id='sfname'");
    $Form->AddCell(new InputFormCell("<input class='form-control' type='text' style='background-color:#fff8f8;' onkeydown='FindAddressEnter(event)' id='sAddress' name='searchaddress' autocomplete='off'><p>Enter a location to search</p>",2,false,'',true));
    $Form->AddCell(new InputFormCell("<select id='sCountry'>
                                        <option selected value='za'>South Africa</option>
                                        <option value='bw'>Botswana</option>
                                        <option value='mz'>Mozambique</option>
                                        <option value='na'>Namibia</option>
                                        <option value='ls'>Lesotho</option>
                                        </select>"));

    if (Debug())
    {
        $Enabled = '';
    }
    else
    {
        $Enabled = " readonly='readonly'";
        $Cell .= "<input id='placename' type=hidden name='placename' value='']>";
        $Cell .= "<input id='sub' type=hidden name='locality' value=''>";
        $Cell .= "<input id='place_id' type=hidden name='place_id' value=''>";
        $Cell .= "<textarea id='gdbg' style='display:none'></textarea>";
        $Cell .= "<input id='province' type=hidden name='province' value=''>";
    }


    $Form->AddCell(new InputFormCell("$Cell<div id=gmap style='height:300px;'></div>", 3, false));
    $Form->AddInput(2,In::Text, 'building', 'Additional prefix (CO, Building or Complex)');

    if(Debug())
    {
        $Form->AddInput(1,In::Text, 'placename', 'Place Name',$AddRw['placename'],[]," id='placename'");
    }

    $Form->AddInput(1,In::Text, 'num', 'Number',$AddRw['num'],[]," id='snum' $Enabled", true);
    $Form->AddInput(1,In::Text, 'street', 'Street',$AddRw['street'],[]," id='sname' $Enabled'");
    $Form->AddInput(2,In::Text, 'suburb', 'Suburb',$AddRw['suburb'],[]," id='ssuburb' $Enabled", true);
    $Form->AddInput(2,In::Text, 'town', 'Town',$AddRw['town'],[]," id='stown' $Enabled", true);
    $Form->AddInput(1,In::Text, 'provincename', 'Province Name',$AddRw['provincename'],[]," id='provincename' $Enabled",true);
    $Form->AddInput(1,In::Text, 'postcode', 'Code',$AddRw['num'],[]," id='postcode' $Enabled",true);


    if(Debug())
    {
        $Form->AddInput(1,In::Text, 'locality', 'Locality',$AddRw['locality'],[]," id='sub'");
        $Form->AddInput(1,In::Text, 'province', 'Province',$AddRw['province'],[]," id='province'");
        $Form->AddInput(1,In::Text, 'place_id', 'Place ID',$AddRw['placename'],[]," id='place_id'");
        $Form->AddCell(new InputFormCell("<textarea id='gdbg' style='display:block'></textarea>", 3));
    }

    echo $Form;


    $endscript = <<<EOS
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

EOS;

    EndScript($endscript);

}
