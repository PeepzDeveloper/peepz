//-------------------------------------------------------------
//Google Map Functions and address input
//-------------------------------------------------------------

var map;
var geocoder;
var addr;
var g_resp;
var latlng;
var googlemapsurl;
googlemapsurl = 'https://maps.googleapis.com/maps/api/js?libraries=places&sensor=true';

l_lat = -29.7147929326568;
l_lng = 25.174749;
l_clat = -29.7147929326568;
l_clng = 25.174749;
l_p_zoom = 6;

/**
 * Show object properties
 *
 * @param {Object} obj Object
 * @param {String} objName Object name
 * @returns {String}
 */
function showProps(obj, objName)
{
  var result = "";
  for (var i in obj)
  {
    if (obj[i].length != 0)
      result += showProps(obj[i], i);
    else
      result += objName + "." + i + " = " + obj[i] + "<BR>";
  }
  return result;
}

/**
 * Initialize Google Maps API
 *
 * @param {Float} lat Default lattitude
 * @param {Float} lng Default longitude
 * @param {Float} clat Center lattitude
 * @param {Float} clng Center longitude
 * @param {Float} p_zoom Zoom level
 * @returns {undefined}
 */
function geo_initialize(lat, lng, clat, clng, p_zoom)
{
  addr = null;
  if (!lat)
    lat = l_lat;
  if (!lng)
    lng = l_lng;
  if (!clat)
    clat = l_clat;
  if (!clng)
    clng = l_clng;
  if (!p_zoom)
    p_zoom = l_p_zoom;
  lAddr = new google.maps.LatLng(lat, lng);
  lCenter = new google.maps.LatLng(clat, clng);
  var myOptions =
          {
            zoom: p_zoom
            ,
            center: lCenter
            ,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            ,
            mapTypeControlOptions: {
              mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE],
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
            ,
            draggableCursor: 'url(\"/images/scrosshair.png\"), url(\"/images/scrosshair.gif\"), pointer'
            ,
            draggingCursor: 'move'
          };
  if (map)
    map = null;
  map = new google.maps.Map(document.getElementById("gmap"), myOptions);
  google.maps.event.addListener(map, 'click', clicked);
  google.maps.event.addListener(map, 'bounds_changed', SetBounds);
  google.maps.event.addListener(map, 'center_changed', SetCenter);
  if (!geocoder)
    geocoder = new google.maps.Geocoder();
  if (!addr)
  {
    var MOpts =
            {
              position: lAddr,
              map: map,
              draggable: true
            };

    addr = new google.maps.Marker(MOpts);
    google.maps.event.addListener(addr, 'dragend', dragged);
  }

  try
  {
    var inBounds = map.getBounds().contains(lAddr);
    if (!inBounds)
      map.panTo(lAddr);
  }
  catch (err) {
    //do nothing
    //IE this is null or not an object
  }
}

/**
 * Set zoom level
 *
 * @returns {undefined}
 */
function SetBounds()
{
  document.getElementById("zoom").value = map.getZoom();
}

/**
 * Set center position
 *
 * @returns {undefined}
 */
function SetCenter()
{
  pos = map.getCenter();
  document.getElementById("clat").value = pos.lat();
  document.getElementById("clng").value = pos.lng();
}

/**
 * Handle a mouse click on the map
 *
 * @param {Object} mouse Mouse object passed from Google Maps API
 * @returns {undefined}
 */
function clicked(mouse)
{
  searchLocation(mouse.latLng);

  /*
   // Optional Place Nearby Search
   var request = {
   location: mouse.latLng, //pyrmont,
   //types: ['establishment'],
   radius: '50'
   };

   service = new google.maps.places.PlacesService(map);
   service.nearbySearch(request, g_place_callback);
   */
}
//    , types: ['store']


function g_place_callback(results, status)
{
  try
  {
    if (resp.length == 0 || status != 'OK')
    {
      msg = '';
      switch (status)
      {
        case 'ERROR' :
          msg = 'There was a problem contacting the Google servers.';
          break;
        case 'INVALID_REQUEST' :
          msg = 'This GeocoderRequest was invalid.';
          break;
        case 'OVER_QUERY_LIMIT' :
          msg = 'The webpage has gone over the requests limit in too short a period of time.';
          break;
        case 'REQUEST_DENIED' :
          msg = 'The webpage is not allowed to use the geocoder.';
          break;
        case 'UNKNOWN_ERROR' :
          msg = 'A geocoding request could not be processed due to a server error. The request may succeed if you try again.';
          break;
        case 'ZERO_RESULTS' :
          msg = 'No result was found for this location.';
          break;
        default :
          msg = 'Unknown Error';
      }
      ae_alert(msg);
      return;
    }
  }
  catch (err)
  {
  }

  try
  {
    document.getElementById("place_id").value = results[0].place_id;
    var showResult = document.getElementById('divShowResult');
    if (showResult)
      showResult.innerHTML = '';
    else
    {
      showResult = document.createElement('div');
      showResult.id = 'divShowResult';
      showResult.style.width = '300px';
      showResult.style.height = '900px';
      showResult.style.borderBottom = '1px solid #cfd8d5';
      showResult.setAttribute('ctxmenu', 'mapresult');
    }

    g_resp = results;
    gotresult = false;
    for (i = 0; i < results.length; i++)
    {
      isZA = false;
      isAllowed = false;

      {
        var newdiv = document.createElement('div');
        var divIdName = 'my' + i + 'Div';
        newdiv.setAttribute('id', divIdName);
        newdiv.innerHTML = '<p style="cursor:pointer;margin:0px;height:3px;" onclick=\'selectAddress(' + i + ');\'><img style="height:11px;" src="' + results[i].icon + '">' + results[i].name + '</p><br>';
        showResult.appendChild(newdiv);
        gotresult = true;
      }

      if (isZA)
      {
        var adres = results[i].formatted_address.replace(', South Africa', '');
      }
      else
      {
        var adres = results[i].formatted_address;
      }

      if (isAllowed)
      {
        var newdiv = document.createElement('div');
        var divIdName = 'my' + i + 'Div';
        newdiv.setAttribute('id', divIdName);
        newdiv.innerHTML = '<p style="cursor:pointer;margin:0px;height:3px;" onclick=\'selectAddress(' + i + ');\'>' + adres + '</p><br>';
        showResult.appendChild(newdiv);
        gotresult = true;
      }
    }

    ae$('aep_t').innerHTML = 'Streets Found - Please select';
    if (gotresult)
      ae_div(showResult, null, true);
    else
    {
      if (!trySapo)
      {
        searchSapoAddress(lastAddress);
        lastAddress = '';
      }
      else
      {
        trySapo = false;
        ae_alert('No result was found for this location.');
      }
    }

    trySapo = false;
  }
  catch (e)
  {
    alert(e);
  }
}

/**
 * Handle a mouse drag on the map
 *
 * @param {Object} mouse Mouse object passed from Google Maps API
 * @returns {undefined}
 */
function dragged(mouse)
{
  //alert(showProps(mouse, 'mouse'));
  //SetMarker(new google.maps.LatLng(mouse.latLng.a, mouse.latLng.b));
  SetMarker(mouse.latLng, false);
}

/**
 * Get address based on clicked position from Google Maps API
 *
 * Limited to South African addresses
 *
 * @param {Object} platLng Position object passed from Google Maps API
 * @returns {undefined}
 */
function searchLocation(platLng)
{
  var find =
          {
            latLng: platLng,
            region: 'ZA'
          };
  geocoder.geocode(find, doneGeocode);
}

/**
 * Set a marker on the map
 *
 * @param {Object} pos Position object
 * @param {Object} viewport Viewport object
 * @returns {undefined}
 */
function SetMarker(pos, viewport)
{
  addr.setPosition(pos);
  ae$("lat").value = pos.lat();
  ae$("lng").value = pos.lng();

  if (viewport)
  {
    map.fitBounds(viewport);
  }
  else
  {
    if (viewport !== false)
    {
      map.setZoom(17);
    }
    map.setCenter(pos);
  }
}

/**
 * Set up address components for a place
 *
 * @param {Object} place Place object
 * @returns {undefined}
 */
function g_setPlace(place)
{
  if (!place.geometry)
  {
    return;
  }
  try
  {
    for (i = 0; i < place.types.length; i++)
    {
      if (place.types[i] == 'establishment')
      {
        if (ae$('sfname').value == '') ae$('sfname').value = place.name;
        ae$('placename').value = place.name;
      }
    }
    fillAddress(place);
    SetMarker(place.geometry.location, place.geometry.viewport);
    //alert(place.place_id + ' : ' + place.formatted_address);
    updateAddressPreview();
  }
  catch (e)
  {
    alert('Could not mark address: ' + e.message);
  }
}

/**
 * Initialize Google Maps API and display a map with pre-set markers
 *
 * @param {Array} locations Array of arrays containing co-ordinates for the markers
 * @param {Float} clat Center lattitude
 * @param {Float} clng Center longitude
 * @param {Float} p_zoom Zoom level
 * @returns {undefined}
 */
function geo_initialize_flat(locations, clat, clng, p_zoom)
{
  if (!clat)
    clat = l_clat;
  if (!clng)
    clng = l_clng;
  if (!p_zoom)
    p_zoom = l_p_zoom;

  lCenter = new google.maps.LatLng(clat, clng);
  var myOptions =
          {
            zoom: p_zoom
            ,
            center: lCenter
            ,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            ,
            mapTypeControlOptions: {
              mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE]
            }
          };
  if (map)
    map = null;
  map = new google.maps.Map(document.getElementById("gmap"), myOptions);
  setMarkerMultiple(locations);
}

var markers = [];
/**
 * Set multiple markers on a Google Map
 *
 * @param {Array} arrlocations Array of arrays with co-ordinates of markers
 * @returns {undefined}
 */
function setMarkerMultiple(arrlocations)
{
  if (typeof (arrlocations) == 'undefined')
    return;
  var minlat = 500;
  var minlng = 500;
  var maxlat = -500;
  var maxlng = -500;

  for (var i = 0; i < arrlocations.length; i++)
  {
    var point = arrlocations[i];
    var myLatLng = new google.maps.LatLng(point[1], point[2]);
    minlat = min(minlat, point[1]);
    maxlat = max(maxlat, point[1]);
    minlng = min(minlng, point[2]);
    maxlng = max(maxlng, point[2]);

    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      icon: point[3],
      title: point[0]
    });
    if (point[4] != '')
      attachMessage(marker, point[4]);
    if (typeof (point[5]) != 'undefined')
    {
      markers[point[5]] = marker;
      if (point[5] != '0')
      {
        ae$(point[5]).onclick = function(e)
        {
          var elem, evt = e ? e : event;
          if (evt.srcElement)
            elem = evt.srcElement;
          else if (evt.target)
            elem = evt.target;
          markers[elem.id].setAnimation(google.maps.Animation.DROP); //BOUNCE);
        }
      }
    }
  }
  map.fitBounds(new google.maps.LatLngBounds(new google.maps.LatLng(minlat, minlng), new google.maps.LatLng(maxlat, maxlng)));
}

/**
 * Display a message when a marker is cliecked.
 *
 * @param {Object} marker Marker
 * @param {String} message Message
 * @returns {undefined}
 */
function attachMessage(marker, message)
{
  var infowindow = new google.maps.InfoWindow({
    content: message
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map, marker);
  });
}

/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr, level) {
  var dumped_text = "";
  if (!level)
    level = 0;

  //The padding given at the beginning of the line.
  var level_padding = "";
  for (var j = 0; j < level + 1; j++)
    level_padding += "    ";

  if (typeof (arr) == 'object') { //Array/Hashes/Objects
    for (var item in arr) {
      var value = arr[item];

      if (typeof (value) == 'object') { //If it is an array,
        dumped_text += level_padding + "'" + item + "' ...\n";
        dumped_text += dump(value, level + 1);
      } else {
        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
      }
    }
  } else { //Stings/Chars/Numbers etc.
    dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
  }
  return dumped_text;
}

/**
 * Fill address inputs with values obtained from Google Maps
 *
 * @param {Object} resp API response
 * @returns {undefined}
 */
function fillAddress(resp)
{
  var street_number = '', street_name = '', suburb = '', town = '', postcode = '', extra_name = '';

  //alert(resp.formatted_address);

  for (i = 0; i < resp.types.length; i++)
  {
    if (resp.types[i] == 'establishment')
      extra_name = resp.name;
  }

  var gdbg = dump(resp);
  gdbg = gdbg + '\n\n';

  var suburb = '';
  for (i = 0; i < resp.address_components.length; i++)
  {
    gdbg = gdbg + resp.address_components[i].types + ': ' + resp.address_components[i].short_name + '\n';
    if (resp.address_components[i].types == 'street_number')
      var street_number = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'route')
      var street_name = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'sublocality,political')
      suburb = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'sublocality_level_1,sublocality,political' && suburb == '')
      suburb = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'locality,political')
      var town = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'postal_code')
      var postcode = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'natural_feature,establishment')
      0; //var extra_name = resp.address_components[i].short_name;
    else if (resp.address_components[i].types == 'administrative_area_level_3,political')
      0; // Tshwane
    else if (resp.address_components[i].types == 'administrative_area_level_2,political')
      0; // Pretoria
    else if (resp.address_components[i].types == 'administrative_area_level_1,political')
      0; // GP
    else if (resp.address_components[i].types == 'country,political')
      0; // ZA
    //else alert(resp.address_components[i].types + ': ' + resp.address_components[i].short_name);
  }

  document.getElementById("gdbg").value = gdbg;
  document.getElementById("place_id").value = resp.place_id;
  document.getElementById("placename").value = extra_name;
  document.getElementById("snum").value = street_number;
  document.getElementById("sname").value = street_name;

  if (suburb != '')
  {
    document.getElementById("sub").value = suburb + ', ' + town;
    document.getElementById("ssuburb").value = suburb;
    document.getElementById("stown").value = town;
  }
  else
  {
    document.getElementById("ssuburb").value = '';
    document.getElementById("sub").value = town;
    document.getElementById("stown").value = town;
  }
  if (town == '' && street_name == '')
  {
    searchLocation(resp.geometry.location);
  }
  if (postcode != '')
    document.getElementById("postcode").value = postcode;
  else
    FindPostcode(resp.geometry.location);

  ae$('hpostcode').value = '';
}

/**
 * Hide the address chooser window
 *
 * @returns {Boolean}
 */
function hideResult()
{
  ae_clk(0);
  return false;
}

var trySapo = false;
var lastAddress = '';

/**
 * Event handler to handle a response from the Google Maps API
 *
 * @param {Object} resp API response
 * @param {String} status Status returned from the API
 * @returns {undefined}
 */
function doneGeocode(resp, status)
{
  try
  {
    if (resp.length == 0 || status != 'OK')
    {
      msg = '';
      switch (status)
      {
        case 'ERROR' :
          msg = 'There was a problem contacting the Google servers.';
          break;
        case 'INVALID_REQUEST' :
          msg = 'This GeocoderRequest was invalid.';
          break;
        case 'OVER_QUERY_LIMIT' :
          msg = 'The webpage has gone over the requests limit in too short a period of time.';
          break;
        case 'REQUEST_DENIED' :
          msg = 'The webpage is not allowed to use the geocoder.';
          break;
        case 'UNKNOWN_ERROR' :
          msg = 'A geocoding request could not be processed due to a server error. The request may succeed if you try again.';
          break;
        case 'ZERO_RESULTS' :
          msg = 'No result was found for this location.';
          break;
        default :
          msg = 'Unknown Error';
      }
      ae_alert(msg);
      return;
    }
  } catch (err) {
  }
  var showResult = document.getElementById('divShowResult');
  if (showResult)
    showResult.innerHTML = '';
  else
  {
    showResult = document.createElement('div');
    showResult.id = 'divShowResult';
    showResult.style.width = '300px';
    showResult.style.borderBottom = '1px solid #cfd8d5';
    showResult.setAttribute('ctxmenu', 'mapresult');
  }

  g_resp = resp;
  gotresult = false;
  for (i = 0; i < resp.length; i++)
  {
    isZA = false;
    isAllowed = false;
    for (l = 0; l < resp[i].address_components.length; l++)
    {
      if ((resp[i].types == 'route' || resp[i].types == 'street_address' || resp[i].types == 'sublocality,political' || resp[i].types == 'locality,political') &&
              (resp[i].address_components[l].types == 'country,political'))
      {
        if (resp[i].address_components[l].short_name == 'ZA')
        {
          isAllowed = isZA = true;
        }
        else if (resp[i].address_components[l].short_name == 'NA')
        {
          isAllowed = true;
        }
      }
    }

    if (isZA)
    {
      var adres = resp[i].formatted_address.replace(', South Africa', '');
    }
    else
    {
      var adres = resp[i].formatted_address;
    }

    if (isAllowed)
    {
      var newdiv = document.createElement('div');
      var divIdName = 'my' + i + 'Div';
      newdiv.setAttribute('id', divIdName);
      newdiv.innerHTML = '<p style="cursor:pointer;margin:0px;height:3px;" onclick=\'selectAddress(' + i + ');\'>' + adres + '</p><br>';
      showResult.appendChild(newdiv);
      gotresult = true;
    }
  }

  ae$('aep_t').innerHTML = 'Streets Found - Please select';
  if (gotresult)
    ae_div(showResult, null, true);
  else
  {
    if (!trySapo)
    {
      searchSapoAddress(lastAddress);
      lastAddress = '';
    }
    else
    {
      trySapo = false;
      ae_alert('No result was found for this location.');
    }
  }

  trySapo = false;

}

/**
 * Update the preview address shown on the address form
 *
 * @returns {undefined}
 */
function updateAddressPreview()
{
  var p = ae$('physAddressPreview');
  if (null == p)
  {
    return;
  }

  var val = ae$('bname').value + "<br />" +
          ae$('placename').value + "<br />" +
          ae$('snum').value + ' ' + ae$('sname').value + "<br />" +
          ae$('ssuburb').value + "<br />" +
          ae$('stown').value + "<br />" +
          ae$('postcode').value;

  if (ae$('snum').value == '' && ae$('sname').value == '' &&
          ae$('ssuburb').value == '' && ae$('stown').value == '' &&
          ae$('postcode').value == '' && ae$('oldAddressField').value != '')
  {
    val = ae$('oldAddressField').value.replace(/\n/g, "<br />");
  }

  p.innerHTML = val.replace(/(<br \/>\s*)+/g, "<br />").replace(/^(<br \/>)+/, "");
}

/**
 * Select an address from a list of possibilities provided by the API
 *
 * @param {Integer} i Identifier of the selected result
 * @returns {undefined}
 */
function selectAddress(i)
{
  hideResult();
  fillAddress(g_resp[i]);
  SetMarker(g_resp[i].geometry.location, g_resp[i].geometry.viewport);
  updateAddressPreview();
}

/**
 * Search for an address using the Google Maps PAI
 *
 * @param {String} find_address Search string
 * @returns {Boolean}
 */
function searchAddress(find_address)
{
  lastAddress = find_address;

  var find =
          {
            address: find_address,
            region: 'ZA'
          };
  geocoder.geocode(find, doneGeocode);
  return false;
}

/**
 * Search for suburb name using SA Post Office postal code data
 *
 * @param {String} address Postal code
 * @returns {undefined}
 */
function searchSapoAddress(address)
{
  var sapoTmp;
  sapoTmp = ae$('sapoTmp');
  if (sapoTmp == null)
  {
    sapoTmp = document.createElement('span');
    sapoTmp.style.display = 'none';
    sapoTmp.id = 'sapoTmp';
    document.body.appendChild(sapoTmp);
  }

  if ('' == address)
  {
    ae_alert("<p>Please enter an address to search for.</p>");
    return;
  }

  var a = new AjaxClass();
  a.url = '/contact/addresses.php?searchSuburbCode=' + encodeURIComponent(address);
  a.target = 'sapoTmp';

  a.returnMethod = function(ajaxObj)
  {
    var b = ajaxObj;
    if ('' != b.result)
    {
      trySapo = true;
      searchAddress(b.result);
    }
    else
    {
      ae_alert('<p>No result was found for this location.</p>');
    }
  };

  a.Execute();
}

/**
 * Find the postal code for a given position
 *
 * @param {Object} latlng Position object
 * @returns {undefined}
 */
function FindPostcode(latlng)
{
  var find =
          {
            latLng: latlng
          };
  geocoder.geocode(find, ShowPostcode);
}

/**
 * Set the postel code based on an API response
 *
 * @param {Object} resp API response
 * @param {String} status Status returned from the API
 * @returns {undefined}
 */
function ShowPostcode(resp, status)
{
  if (resp == null)
  {
    return;
  }

  for (i = 0; i < resp.length; i++)
  {
    for (l = 0; l < resp[i].address_components.length; l++)
    {
      if (resp[i].address_components[l].types == 'postal_code')
      {
        document.getElementById("postcode").value = resp[i].address_components[l].short_name;
        return;
      }
    }
  }
}

/**
 * Event handler to handle the enter key being pressed in the address search input
 *
 * @param {Event} evt Event passed from browser
 * @returns {Boolean}
 */
function FindAddressEnter(evt)
{
  if (evt == null)
  {
    evt = window.event;
  }

  var charCode;

  if (typeof (evt.which) == 'undefined')
  {
    charCode = evt.keyCode;
  }
  else
  {
    charCode = evt.which;
  }

  if (charCode == "13")
  {
    searchAddress(ae$('sAddress').value);
  }

  return false;
}

/**
 * Clear all address inputs
 *
 * @returns {undefined}
 */
function clearInput()
{
  document.getElementById('snum').value = '';
  document.getElementById('sname').value = '';
  document.getElementById('sub').value = '';
  document.getElementById('postcode').value = '';
}