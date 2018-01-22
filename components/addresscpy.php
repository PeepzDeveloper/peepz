<?php
require_once "globals.php";
session_write_close();

call_user_func('component_address_' . SGet("func", Get('func','default')));
AjaxLast(false, true);

function component_address_default()
{
    $curpage = CurPage();
    $address = Get('address');
    $contact = Get('person');
    $layout = Get('layout',1);

    $address = 357104;
    $person = 245280;


    /**************************************************
     * Layout options
    ***************************************************
     * 1 = left menu, map with form inputs (contact id required)
     * 2 = no menu, form to select addresses from list (policy id required)
     * 3 = no menu, map and form inputs (address id required)
     * 4 = no menu, map and address readonly (address id required)
     * 5 = flat map with multiple markers (locations and showlist options required)
    ***************************************************
     * Options
     **************************************************
     * addnew: shows add new button/menu item
     * lat: lat point used to centre map
     * lng: lng point used to centre map
     * locations: Array of addresses to be pinned (layout 5 only)
     *            array(
     *                  locationname: string name to be displayed in list and popup
     *                  address: formatted address
     *                  lat: float lat co-ords
     *                  lng: float lng co-ords
     *                  image: string icon to use as pin/marker
     *                  description: string html to show in popup of marker
     *                  isprimary: boolean used for distance calculations
     *                  distance: float distance calculated in db from primary location to current location
     *                  showinlist: boolean show in left list of markers or not
     *                  )
     * showlist: boolean list addresses on left of map (layout 5 only)
     * Radius: int radius of circle to show on map in km
     **************************************************/

    switch ($layout)
    {
        case 1:
            component_address_Menu();
            break;
        case 2:
            component_address_List();
            break;
        case 3:
            component_address_ShowMapForm();
            break;
        case 4:
            component_address_ShowReadonly();
            break;
        case 5:
            component_address_FlatMap();
            break;
    }


}

function component_address_Menu()
{
    $person = Get('person');
   // require_once "functions/ui.php";
    //$menuItems[] = array('id' => "baAddNew", 'display' => "<span class='addNew'>Add new ...</span>", 'link' => CurPage(array('func' => 'ShowMapForm', 'address' => 'new'), true, array('target')), 'save' => false);


    /*$sSQL = <<<EOS
     select id, shortname, case when building = shortname then '' else building end as building, show_address,
           default_physical_address, default_postal_address, type,
           count(*) over (partition by show_address) as instances,
           (select string_agg(policyno(policy), ', ') from (select distinct policy from address_history where id = a.id) b) as usage
       from
     (
        select id, coalesce(shortname, street, suburb, town, postcode, '-') as shortname, building, format_address(id, ', ', true) as show_address,
          default_physical_address, default_postal_address, type,
          case when type = 1 then 0 else 1 end as adr_order
        from address
        where person_id = $1
      ) a
      order by adr_order, show_address, default_physical_address desc, default_postal_address desc, building, shortname
EOS;*/
/*
    $sSQL = <<<EOS
       select id, coalesce(address,shortname, street, suburb, town, postcode, '-') as display, building,
          default_physical_address, default_postal_address, type,
          case when type = 1 then 0 else 1 end as adr_order
        from address
        where person_id = $1
      order by adr_order, default_physical_address desc, default_postal_address desc, display
EOS;
*/
   /* if (execute_sql($sSQL, $ra, false, $person))
    {
        foreach($ra as $row)
        {
            //$usage = ($row['usage'] != '' ? "<br>(Policies: $row[usage])" : '');
            $disp = ($row['building'] != '' ? "$row[building]<br>" : '') . "$row[shortname]";
            $menuItems[] = array('id' => "add$row[id]", 'display' => $disp, 'link' => CurPage(array('func' => 'ShowMapForm', 'address' => $row['id']), true, array('target')));
        }
    }
    echo DisplayMenu("Addresses", $menuItems, "Address");
*/
    $AddressMenu = new Menu('Addresses');
    $AddressMenu->Filter = true;
    $Link = new AjaxLink();
    $Link->Parameter->MenuContainer = Get('container');
    $Link->Parameter->func = 'AddNew_Step1';
    $Link->Parameter->saveascontactdetails = true;
    $AddressMenu->AddItem('<span class="addNew &hellip;">Add new</span>', $Link);

    //$Link->Parameter->func = 'ShowMapForm';
    $Link->Parameter->func = 'ShowReadonly';
    $sSQL = <<<EOS
       select distinct id, shortname, coalesce(address, street, suburb, town, postcode, '-') as description, type
        from address
        where id in (select address from contact_detail where person = $1 and type in (8,9))
      order by type, description
EOS;
    EachSQL($sSQL, [$person], function ($row) use ($AddressMenu, $Link)
    {
        $Link->Parameter->address = $row['id'];
        $Link->Parameter->showform = true;
        $AddressMenu->AddItem("$row[shortname]: <br>" .$row['description'] . (Session('dataintegritymode') ? " <span style='color: #FF0000;'>($row[id])</span>" : ""), $Link,
            'list' . $row['id']);
    });
    echo $AddressMenu;
}

function component_address_ShowMapForm()
{
    $Address = Get('address');
    $Person = Get('person');

    if($Address !='new')
    {
        $sSQL = <<<EOS
        select *, coalesce(complex_address, address_id(complex)) as compla,
          format_address(c.id, E'\n', false) as old_address,
          (select suburb || E'\n' || town || E'\n' || postcode from postal_code where id = c.postcodeid) as postal_address_area
        from address as c
        where id = $1 and person_id = $2
EOS;


        if (execute_sql($sSQL, $RS, false, array($Address, $Person)))
        {
            $AddRw = $RS[0];
        }
    }
    else
    {
        $AddRw = [];
    }
    $Type = 1;

    // Clean up apostrophes
    foreach (array ('num', 'street', 'suburb', 'town', 'locality', 'building', 'placename') as $Fld)
    {
        if($Address =='new')
        {
            $AddRw[$Fld] = '';
        }
        $AddRw[$Fld] = str_replace("'", "&#39;", $AddRw[$Fld]);
    }

    if($Address =='new')
    {
        $AddRw['type'] = 1;
        $AddRw['person_id'] = $Person;
        $AddRw['lat'] = $AddRw['lng'] = $AddRw['clat'] = $AddRw['clng'] = $AddRw['zoom'] = $AddRw['place_id'] = 0;
    }
    $AddRw['lat'] = ($AddRw['lat'] != 0 ? $AddRw['lat'] : -29.7147929326568);
    $AddRw['lng'] = ($AddRw['lng'] != 0 ? $AddRw['lng'] : 25.174749);
    $AddRw['clat'] = ($AddRw['clat'] != 0 ? $AddRw['clat'] : -29.7147929326568);
    $AddRw['clng'] = ($AddRw['clng'] != 0 ? $AddRw['clng'] : 25.174749);
    $AddRw['zoom'] = ($AddRw['zoom'] != 0 ? $AddRw['zoom'] : 5);

    require_once "classes/Form.php";
    require_once "functions/forms.php";

    $Form = new InputForm("Address");
    $Form->Columns = 3;
    $Form->Widths = array('50px', '300px', '350px');
    $Form->ShowPDF = false;
    $Form->Bootstrap= true;
    $Form->BootstrapColumns = true;

    if($Address =='new')
    {
        $DbOp = $Form->DBOperation('address', '', '', [], false, $AddRw);
        $Form->Action->Parameter->func = 'Menu';
        $Form->Action->Target = SGet('_menu_parent');
        $Form->Action->Parameter->dbopid = $DbOp[0];
    }
    else
    {
        $DbOp = $Form->DBOperation('address', 'id = $1 and person_id = $2', [$Address, $Person]);
    }
    $Form->AddButton(Button::Save);
    $Form->DBHidden($DbOp,'type');
    $Form->DBHidden($DbOp, 'person_id');

    $Cell = "<input id='lat' type=hidden name='_db_field[$DbOp[0]][lat]' value=$AddRw[lat]>";
    $Cell .= "<input id='lng' type=hidden name='_db_field[$DbOp[0]][lng]' value=$AddRw[lng]>";
    $Cell .= "<input id='clat' type=hidden name='_db_field[$DbOp[0]][clat]' value=$AddRw[clat]>";
    $Cell .= "<input id='clng' type=hidden name='_db_field[$DbOp[0]][clng]' value=$AddRw[clng]>";
    $Cell .= "<input id='zoom' type=hidden name='_db_field[$DbOp[0]][zoom]' value=$AddRw[zoom]>";

    $Form->DBInput($DbOp, In::Text, 'shortname', 'Friendly name',['columns'=>2], " id='sfname'");
    $Form->AddCell(new InputFormCell("<input class='form-control' type='text' style='background-color:#fff8f8;' onkeydown='FindAddressEnter(event)' id='sAddress' name='searchaddress' autocomplete='off'><p>Enter a location to search</p>",3, false, '', true));

    if (Debug())
    {
        $Enabled = '';
    }
    else
    {
        $Enabled = " readonly='readonly'";
        $Cell .= "<input id='placename' type=hidden name='_db_field[$DbOp[0]][placename]' value=$AddRw[placename]>";
        $Cell .= "<input id='sub' type=hidden name='_db_field[$DbOp[0]][locality]' value=$AddRw[locality]>";
        $Cell .= "<input id='place_id' type=hidden name='_db_field[$DbOp[0]][place_id]' value=$AddRw[place_id]>";
        $Cell .= "<textarea id='gdbg' style='display:none'></textarea>";
    }


    $Form->AddCell(new InputFormCell("$Cell<div id=gmap style='height:300px;'>hello</div>", 3, false));
    $Form->DBInput($DbOp, In::Text, 'building', 'Additional prefix (CO, Building or Complex)',['columns'=>2]);

    if(Debug())
    {
        $Form->DBInput($DbOp, In::Text, 'placename', 'Place Name',['columns'=>2]," id='placename'", true);
    }

    $Form->DBInput($DbOp, In::Text, 'num', 'Number',[]," id='snum' $Enabled", true);
    $Form->DBInput($DbOp, In::Text, 'street', 'Street',[]," id='sname' $Enabled");
    $Form->DBInput($DbOp, In::Text, 'suburb', 'Suburb',['columns'=>2]," id='ssuburb'", true);
    $Form->DBInput($DbOp, In::Text, 'town', 'Town',['columns'=>2]," id='stown' $Enabled", true);
    $Form->DBInput($DbOp, In::Text, 'postcode', 'Code',[]," id='postcode' $Enabled", true);

    if(Debug())
    {
        $Form->DBInput($DbOp, In::Text, 'locality', 'Locality',[]," id='sub'");
        $Form->DBInput($DbOp, In::Text, 'place_id', 'Place ID',[]," id='place_id'");
        $Form->AddCell(new InputFormCell("<textarea id='gdbg' style='display:block'></textarea>",3));
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
 if ($Type == 1) // Add autocomplete on search field
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
        }
        catch (e)
        {
        alert('Error setting Autocomplete search box: ' + e.message);
        }
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

function component_address_AddNew_Step1()
{
    /*echo Input(In::Lookup, "newAddressType", 'Address Type', 1, array ('datatype' => 879, 'blank' => false,
        'filter' => '(value != 5 or (select entitytype from person where id = ' . Get('new') . ') != 10)'));*/
    require_once "functions/forms.php";
    $Person = Get('person');

    $Form = new InputForm("Add new Address");
    $Form->Columns = 1;
    $Form->Widths = array('300px');
    $Form->ShowPDF = false;
    $Form->Bootstrap= true;
    $Form->BootstrapColumns = true;

    $Form->Action->Parameter->func = 'AddNew_Step2';
    $Form->AddButton(Button::Save);

    $Form->AddInput(1,In::Lookup,"newAddressType",'Address Type',1,['datatype' => 879, 'blank' => false,
        'filter' => "(value != 5 or (select entitytype from person where id = $Person) != 10)"]);

    echo $Form;
}

function component_address_AddNew_Step2()
{
    $Person = SPostGet('person');
    $Type = SPostGet('newAddressType', 1);

    if(in_array($Type,[2,3,4]))
    {
        component_address_AddNew_Step2Postal();
    }
    elseif ($Type == 5)
    {
        component_address_AddNew_Step2SectionalTitle();
    }
    else
    {
        component_address_AddNew_Step2Physical();
    }
}

function component_address_AddNew_Step2Postal()
{
    require_once "classes/Form.php";
    require_once "functions/forms.php";

    $Person = SPostGet('person');
    $Type = SPostGet('newAddressType', 2);
    $AddRw = [];
    $UpdateLookup = SPostGet('updatelookup', false);

    foreach (array ('num', 'street', 'suburb', 'town', 'locality', 'building', 'placename') as $Fld)
    {
        $AddRw[$Fld] = '';
    }

    $AddRw['type'] = $Type;
    $AddRw['person_id'] = $Person;

    $Form = new InputForm("New Postal Address");
    $Form->Columns = 1;
    $Form->Widths = array('200px');
    $Form->ShowPDF = false;
    $Form->Bootstrap= true;
    $Form->BootstrapColumns = true;

    $Form->Action->Parameter->func = 'AddNew_Step3';
    $Form->Action->Parameter->updatelookup = $UpdateLookup;
    $Form->Action->Parameter->type = $Type;

    $Form->AddButton(Button::Save);

    if (2 == $Type) //PO Box
    {
        $Form->AddInput(1,In::Text, 'po_box', 'PO Box','',[]," id='poboxField' onkeyup='updatePostalAddressField()'");
    }
    if (4 == $Type) // Postnet
    {
        $Form->AddInput(1,In::Text, 'postnet_suite', 'Postnet Suite','',[]," id='suiteField' onkeyup='updatePostalAddressField()'");
    }
    if (in_array($Type, array (3, 4))) //Private bag or Postnet
    {
        $Form->AddInput(1,In::Text, 'private_bag', 'Private Bag','',[]," id='bagField' onkeyup='updatePostalAddressField()'");
    }

    $LookupOptions = ['table'=>'postal_code', 'key'=> 'id', 'display'=> "suburb || ', ' || town || ', ' || postcode", 'callback'=>'updatePostalCode'];
    $Form->AddInput(1, In::LookupInput, "postcodeid","Search for suburb name or postal code", '',$LookupOptions, "");

 //echo "<tr><td $ColSpan>" . MakeLookUpInput("field[postcodeid]", "Search for suburb name or postal code", $a['postcodeid'], "postal_code", "suburb || ', ' || town || ', ' || postcode", '', '', 'updatePostalCode');


    $Cell = "<p id='postalAddressStatic' class='addressPreview' style='height:150px; width:100%;'>&nbsp;</p><p>Preview</p>";
    $Cell .= "<input type='hidden' id='postalTmp' name='postalTmp' value='' />";
    $Cell .= "<input type='hidden' id='hpostcode' name='dummypostcode' value='' />";
    $Cell .= "<input id='type' type=hidden name='type' value=$AddRw[type]>";
    $Cell .= "<input id='person_id' type=hidden name='person_id' value=$Person>";

    $Form->AddCell(new InputFormCell("$Cell"));

    echo $Form;
    $CurPage= CurPage(['func'=>'FetchPostalCode']);

    $EndScript = <<<EOS
 try
 {

parent.updatePostalAddressField = function()
{
   var ad = '';

  var pobox =$('#poboxField').val();
  if( pobox != '' && pobox !== undefined)
  {
    ad += 'PO Box ' + pobox + "\\n";
  }

  var suite =$('#suiteField').val();
  if( suite != '' && suite !== undefined)
  {
    ad += 'Postnet Suite ' + suite + "\\n";
  }

  var bag =$('#bagField').val();
  if( bag != '' && bag !== undefined)
  {
    ad += 'Private Bag ' + bag + "\\n";
  }

  ad += $('#postalTmp').val();

  var st = parent.ae$('postalAddressStatic');

  st.innerHTML = ad.replace(/\\n/g, '<br />');

};

parent.updatePostalCodeCallback = function(ajaxObject)
{
  $('#postalTmp').val(ajaxObject.result);
  parent.updatePostalAddressField();
};

parent.updatePostalCode = function()
{

  var idField = $('#lu_postcodeidid').val();
  if( idField == '' || idField === undefined)
  {
      return;
  }

  var a = new AjaxClass();
  a.url = '$CurPage&getPostal=' + idField;
  a.target = 'postalTmp';
  a.returnMethod = parent.updatePostalCodeCallback;
  a.Execute();
};


}
catch (e)
{
  alert('Error initializing Postal Address code: ' + e.message);
}

EOS;

    EndScript($EndScript);

}

function component_address_AddNew_Step2Physical()
{
    require_once "classes/Form.php";
    require_once "functions/forms.php";

    $Person = SPostGet('person');
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

function component_address_AddNew_Step3()
{
    $Person = SPostGet('person_id');
    $Shortname = SPostGet('shortname');
    $Type = SPostGet('type',1);
    $Lat = SPostGet('lat');
    $Lng = SPostGet('lng');
    $Clat = SPostGet('clat');
    $Clng = SPostGet('clng');
    $Zoom = SPostGet('zoom');
    $Building = SPostGet('building');
    $Placename = SPostGet('placename');
    $Num = SPostGet('num');
    $Street = SPostGet('street');
    $Suburb = SPostGet('suburb');
    $Town = SPostGet('town');
    $Postcode = SPostGet('postcode');
    $Locality = SPostGet('locality');
    $Province = SPostGet('province');
    $Place_id = SPostGet('place_id');
    //$UsageType = SPostGet('usage_type', 3);
    $UpdateLookup = SPostGet('updatelookup', false);
    $SaveAsContactDetail = SPostGet('saveascontactdetails', false);
    $POBox = SPostGet('po_box');
    $Postnet = SPostGet('postnet_suite');
    $PrivateBag = SPostGet('private_bag');
    $PostalCode = SPostGet('postcodeid');
    $NewId = 0;
    $DetailType = "";

    if($Type == 1)
    {
        /*$SQL = "select id from address
            where upper(regexp_replace(coalesce(building,coalesce(shortname,'')), '[^a-zA-Z0-9]', '', 'g'))=upper(regexp_replace($1, '[^a-zA-Z0-9]', '', 'g'))
            and coalesce(street,'') = coalesce($2,'')
            and coalesce(locality,'')= coalesce($3,'') limit 1";*/

        $SQL = "select id from address
            where upper(regexp_replace(address, '[^a-zA-Z0-9]', '', 'g')) = upper(regexp_replace(coalesce($1, '') ||
			coalesce($2, '') || coalesce($3, '') ||	coalesce($4, '') ||
			coalesce($5, '') || coalesce($6, ''), '[^a-zA-Z0-9]', '', 'g')) limit 1";


        $Params=[($Building != '' ? $Building : ''), $Num, $Street, $Suburb, $Town, $Postcode];
        $DetailType = 8;
    }
    elseif(in_array($Type,[2,3,4]))
    {
        $SQL = "select id from address
            where
            upper(regexp_replace(coalesce(po_box,''), '[^a-zA-Z0-9]', '', 'g'))=upper(regexp_replace($1, '[^a-zA-Z0-9]', '', 'g'))
            and upper(regexp_replace(coalesce(postnet_suite,''), '[^a-zA-Z0-9]', '', 'g'))=upper(regexp_replace($2::character varying, '[^a-zA-Z0-9]', '', 'g'))
            and upper(regexp_replace(coalesce(private_bag,''), '[^a-zA-Z0-9]', '', 'g'))=upper(regexp_replace($3::character varying, '[^a-zA-Z0-9]', '', 'g'))
            and postcodeid=$4 limit 1";

        $Params=[$POBox, $Postnet, $PrivateBag, $PostalCode];
        $DetailType = 9;
    }


    if(execute_sql($SQL, $Ra, false, $Params))
    {
        $NewId = $Ra[0]['id'];
    }
    else
    {
        require_once "functions/dbupdate.php";
        $_POST['field']['person_id'] = $Person;
        $_POST['field']['shortname'] = $Shortname;
        $_POST['field']['type'] = $Type;
        $_POST['field']['lat'] = $Lat;
        $_POST['field']['lng'] = $Lng;
        $_POST['field']['clat'] = $Clat;
        $_POST['field']['clng'] = $Clng;
        $_POST['field']['zoom'] = $Zoom;
        $_POST['field']['building'] = $Building;
        $_POST['field']['placename'] = $Placename;
        $_POST['field']['num'] = $Num;
        $_POST['field']['street'] = $Street;
        $_POST['field']['suburb'] = $Suburb;
        $_POST['field']['town'] = $Town;
        $_POST['field']['postcode'] = $Postcode;
        $_POST['field']['locality'] = $Locality;
        $_POST['field']['province'] = $Province;
        $_POST['field']['place_id'] = $Place_id;
        $_POST['field']['po_box'] = $POBox;
        $_POST['field']['postnet_suite'] = $Postnet;
        $_POST['field']['private_bag'] = $PrivateBag;
        $_POST['field']['postcodeid'] = $PostalCode;
        $NewCTID = inserttable('address');
        if ($NewCTID !== false && $NewCTID !== null)
        {
            $NewId = db("SELECT id FROM address WHERE ctid=$1", $NewCTID);
        }
    }

    if($NewId != 0)
    {
        if($SaveAsContactDetail)
        {
            $SQL = "INSERT INTO contact_detail (changed_by, person, type, detail) values($1,$2,$3,$4)";
            execute($SQL,[Userinfo('id'), $Person, $DetailType, $NewId]);
        }


        if($UpdateLookup)
        {
            //$EndScript = " var select = parent.ae\$('address_id'); select.options[select.options.length] = new Option('$Shortname', $NewId);";
            $EndScript = "closePopups(); $('#address_id').append($('<option>', {value:" . $NewId .", text:'" . $Shortname ."'}));
                            $('#address_id').val($NewId).change(); ";
            EndScript($EndScript);
        }
        else
        {
            //echo "<p class='message'>New address added</p>";
            $Reload = new AjaxLink(null, SGet('MenuContainer'));
            $Reload->Parameter->func = 'Menu';
            EndScript("$Reload");
        }

    }
    else
    {
        echo "<p class='message'>$NewId == Error adding new address</p>";
    }

}

function component_address_ShowReadonly()
{
    $Address = Get('address');
    $ShowForm = SGet('showform', false);
    if($Address == '')
    {
        echo "<div class=warning>No address selected</div>";
        return false;
    }

    if (execute_sql(" select shortname as locationname,
                      format_address(id, '<br>', false) as address,
                      lat,
                      lng,
                      'images/red-dot.png' as image,
                      '' as description, type,
                      person_id, (select entitytype from person where id=person_id) as entitytype
                          from address where id=$1", $Ra, false, [$Address]))
    {
        $Row = $Ra[0];
        if(in_array($Row['type'], [2,3,4]))
        {
           if($ShowForm)
           {
               $Form = new InputForm("Postal Address - $Row[locationname]");
               $Form->Columns = 1;
               $Form->Widths = array('200px');
               $Form->Bootstrap= true;
               $Form->BootstrapColumns = true;
               $Form->AddCell(new InputFormCell("<p id='postalAddressStatic' class='addressPreview' style='height:150px; width:100%;'>$Row[address]</p>", 1, false));
               echo $Form;
           }
           else
           {
               echo "<p id='postalAddressStatic' class='addressPreview' style='height:150px; width:100%;'>$Row[address]</p>";
           }
        }
        else
        {
            $UID1 = uniqid('d');
            $Description = html_entity_decode($Row['description']);
            $ArrLocation = "['" . str_replace("'", htmlencode("'", true), "$Row[locationname]") . "','$Row[lat]', '$Row[lng]','$Row[image]','" . str_replace("'", htmlencode("'", true), "<h1>$Row[locationname]</h1><p>$Description</p>") . "']";
            $Lat = $Row['lat'];
            $Lng = $Row['lng'];
            if($ShowForm)
            {
                $Form = new InputForm("Residential Address - $Row[locationname]");
                $Form->Columns = 2;
                $Form->Widths = array('200px','300px');
                $Form->Bootstrap= true;
                $Form->BootstrapColumns = true;
                $Form->AddCell(new InputFormCell("<br><div>$Row[address]</div>", 1, false));
                $Form->AddCell(new InputFormCell("<div id='gmapdisplay' style='height:300px;'></div>", 1, false));

                if ($Row['entitytype'] == 10)
                {
                    $Link = new AjaxLink(null, uniqid('popup'));
                    $Link->Option->popupType = Popup::Large;
                    $Link->Parameter->func = 'ListPQ';
                    $Form->AddButton(Button::Custom, $Link, "", "Edit units", "Home.png");
                }

                echo $Form;
            }
            else
            {
                echo "<br><div class='col-lg-4 col-sm-12 col-md-4 col-xs-12'>$Row[address]</div>";
                echo "<div id='gmapdisplay' class='col-lg-8 col-sm-12 col-md-8 col-xs-12' style='height:300px;'></div>";
            }
            $EndScript = <<<EOS
              var locations = [$ArrLocation];
              parent.cbinit = function(a) { geo_initialize_flat(locations, $Lat, $Lng, 5, 'gmapdisplay'); };
              parent.cbinit();
EOS;
            EndScript($EndScript);
        }
    }
    else
    {
        echo "<div class=warning>No address found</div>";
    }
}

function component_address_FlatMap()
{
    $EndScript ="";
    $Coords = db('select lat, lng, format_address(id, \' \', true) as address from address where id = $1', Get('address', 336873));
    $Lat = Get('lat',$Coords['lat']);
    $Lng = Get('lng',$Coords['lng']);
    $Locations = Get('locations');
    $ShowList = Get('showlist',false);
    $ArrLocation = "";

    $MapStyle = "width:100%; height:100%;";
    echo "<div style='width:100%; height:100%;'>";

    if($ShowList)
    {
        $MapStyle = "position:absolute;top:60px;bottom:0px;left:301px;right:20px;height:auto;";

        echo "<div style='position:absolute;top:60px;bottom:0px;left:0px;width:300px;overflow-y:scroll;height:auto;'>";
        echo "<table class=result>";
    }

    foreach ($Locations as $Row)
    {
     $Description = html_entity_decode($Row['description']);

        if($ShowList && $Row['showinlist'] == 't')
        {
            $UID1 = uniqid('d');
            echo "<tr>";
            echo "<td id='$UID1' onclick='alert(0);'>$Row[locationname]";
            $UID = uniqid('d');
            echo "<td id=$UID>$Row[distance]";
            $EndScript .= "try {parent.ae\$('$UID').innerHTML = Math.round(google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng($Row[lat], $Row[lng]), new google.maps.LatLng($Coords[lat], $Coords[lng])) / 1000, 2) + 'km';} catch (e) {parent.ae\$('$UID').innerHTML = '?';} \n";
        }
        else
        {
            $UID1 = 0;
        }
        //$UID1 = ($Row['showinlist'] != 't' ? '0' : $UID1) ;
        $ArrLocation .= ($ArrLocation != '' ? "," : "");
        $ArrLocation .= " ['" . str_replace("'", htmlencode("'", true), "$Row[locationname]") . "','$Row[lat]', '$Row[lng]','$Row[image]','" . str_replace("'", htmlencode("'", true), "<h1>$Row[locationname]</h1><p>$Description</p>") . "', '$UID1']";
    }

    if($ShowList)
    {
        echo "</table>";
        echo "</div>";
    }

    echo "<div id=gmap style='$MapStyle'></div></div>";

    $EndScript .= <<<EOS
      var locations = [$ArrLocation];
      parent.cbinit = function(a) { geo_initialize_flat(locations, $Lat, $Lng, 6); };
      //if (!parent.loadscript('https://maps-api-ssl.google.com/maps/api/js?v=3&sensor=false&libraries=geometry,places&region=ZA&callback=cbinit'))
      parent.cbinit();
EOS;

if(0 != $Radius = Get('radius',0))
{
    $EndScript .= <<<EOS
      var Radius = ($Radius * 1000);
      var RaduisCircle = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: {lat: $Lat, lng: $Lng},
      radius: Radius
    });
EOS;

}
    EndScript($EndScript);
}

function component_address_FetchPostalCode()
{
    $PostalCodeId = Get('getPostal');
    echo db("select suburb || E'\n' || coalesce(town || E'\n', '') || postcode from postal_code where id = $1", $PostalCodeId);
}

function component_address_FetchProvinceID()
{
        $ProvinceName = Get('getProvince');
        echo db("select fetch_or_create_datatype_value(31, $1)", $ProvinceName);
}