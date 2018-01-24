<?php
  function MakeTextBox($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>
                   <input type='text' name='$Name' id='$Id' class='$Class' value='$Value' ";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    if($PlaceHolder != '')
    {
      $Return .= " placeholder='$PlaceHolder' ";
    }

    $Return .= ">";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
  }

    function makeselect($Name, $Id, &$Javascript, $Value = '', $Title = '', $Key, $Display, $Table, $Where = '', $OrderBy = 'display', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false, $InitialDisplay = '', $InitialValue = '')
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>";

    $Return .= "<select id='$Id' name='$Name' class='$Class'";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    $Return .= ">";
    if ($InitialDisplay != '')
    {
      $Return .= " <option value='$InitialValue'" . ($Value == "" ? $Selected : '') . ">$InitialDisplay</option>";
    }
    $sSQL = "select $Key as keyid, $Display as display from $Table $Where order by $OrderBy";
    if (execute_sql($sSQL, $ra, $error))
    {
      foreach ($ra as $row)
      {
        $Return .= " <option value='$row[keyid]'" . ($Value == $row['keyid'] ? ' selected' : '') . ">$row[display]</option>";
      }
    }

    $Return .= "</select>";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
    }

  function makeselectbox_old($id, $name, $value, $key, $display, $table, $where = '', &$javascript, $orderby = 'display', $title = '', $helpdesc = '', $customclass = 'ui-state-focus', $usetheme = false, $initialdisplay = '', $initialvalue = '')
  {
    if ($usetheme == true)
    {
      $javascript .= " $( '#$id' ).selectmenu(); ";
    }

    $helpbtn = "";
    $helpdialog = "";
    if ($helpdesc != '')
    {
      $helpbtn = "<div id='divhelp_$id' style='width:16px; display:inline-block; margin-left:5px;' class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-help'></span></div>";
      $helpdialog = "<div id='help_$id' title='$title'><p>$helpdesc</p></div>";

      $javascript .= " $( '#divhelp_$id' ).hover(
                          function() { $( this ).addClass('ui-state-hover'); },
                          function() { $( this ).removeClass('ui-state-hover'); }
                      );

                      $( '#help_$id' ).dialog({
                          autoOpen: false,
                          width: 400
                    });

                    // Link to open the dialog
                    $( '#divhelp_$id' ).click(function( event ) {
                      $( '#help_$id' ).dialog( 'open' );
                      event.preventDefault();
                    });

      ";
    }

    $select = "<div style='white-space: nowrap; width:300px;'>";
    $select .= "<select id='$id' name='$name' class='ui-selectmenu-button ui-widget ui-corner-all $customclass'>";
    if ($initialdisplay != '')
    {
      $select .= " <option value='$initialvalue'" . ($value == "" ? $selected : '') . ">$initialdisplay</option>";
    }
    $sSQL = "select $key as keyid, $display as display from $table $where order by $orderby";
    if (execute_sql($sSQL, $ra, $error))
    {
      foreach ($ra as $row)
      {
        $select .= " <option value='$row[keyid]'" . ($value == $row['keyid'] ? ' selected' : '') . ">$row[display]</option>";
      }
    }

    $select .= "        </select>$helpbtn</div> $helpdialog";

    return $select;
  }

  function MakeTextarea($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>
                   <textarea name='$Name' id='$Id' class='$Class' ";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    if($PlaceHolder != '')
    {
      $Return .= " placeholder='$PlaceHolder' ";
    }

    $Return .= ">$Value</textarea>";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
    }

    function MakeHidden($Name, $Id, &$Javascript, $Value = '')
    {
        $Return = "<input type='hidden' name='$Name'  id='$Id' value='$Value'>";
        return $Return;
    }

    function MakeTime($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>
                   <input type='time' name='$Name' id='$Id' class='$Class' value='$Value' ";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    if($PlaceHolder != '')
    {
      $Return .= " placeholder='$PlaceHolder' ";
    }

    $Return .= ">";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
    }

    function MakeDate($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>
                   <input type='date' name='$Name' id='$Id' class='$Class' value='$Value' ";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    if($PlaceHolder != '')
    {
      $Return .= " placeholder='$PlaceHolder' ";
    }

    $Return .= ">";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
    }

    function MakeFileDrop($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    If($Value != '')
    {
      $DataDefault = " data-default-file='$Value'";
    }
    else
    {
      $DataDefault = " data-default-file='logos/peepz_.jpg'";
    }

    $Return .= "<div class='col-md-8'>
                   <div class='card'>
      <div class='card-block'>
          <input type='file' id='$Id' name='$Name' class='dropify' data-show-remove='false' data-height='200' $DataDefault >
      </div>
    </div>
    </div>";

    $Javascript = " $('.dropify').dropify(); ";

    return $Return;
    }

  function MakeCurrency($Name, $Id, &$Javascript, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $Class='form-control', $Required = false)
  {
    $HelpDialog = "";
    $Return = "";

    if($Title != '')
    {
      $Return .= "<label class='col-form-label col-md-4'>$Title</label>";
    }

    $Return .= "<div class='col-md-8'>
                  <div class='input-group'> <span class='input-group-addon'>R</span>
                   <input type='number' name='$Name' id='$Id' class='$Class' value='$Value' ";

    if($Required)
    {
     $Return .= " required='' data-validation-required-message='This field is required' ";
    }

    if($PlaceHolder != '')
    {
      $Return .= " placeholder='$PlaceHolder' ";
    }

    $Return .= "><span class='input-group-addon'>.00</span></div>";

    if($HelpBlock != '')
    {
      $Return .= "<span class='help-block'> $HelpBlock </span>";
    }

    $Return .= " </div>";

    return $Return;
  }
?>
