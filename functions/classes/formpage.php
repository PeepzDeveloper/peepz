<?php

  /**
   * Description of formpage
   *
   * @author craig
   */
  class FormPage
  {
    private $Name;
    private $Id;
    private $Method;
    private $Header;
    private $Return;
    private $Footer;
    public $Javascript;
    private $SaveTable;
    private $SaveReturn;
    private $SaveKey;
    private $SaveKeyValue;
    private $Insert;
    public $BackLink;
    public $PostUrl;
    public $ContentDiv;
    public $MDcols;
    public $LGcols;
    public function __construct($Id, $Name, $SaveTable, $SaveReturn = 'true', $SaveKey = '', $SaveKeyValue = '', $Insert = false, $Method = 'post' )
    {
      $this->Name = $Name;
      $this->Id = $Id;
      $this->Method = $Method;
      $this->Return = "";
      $this->Header = "<form id='$Id' name='$Name' method='$Method' class='form-horizontal' enctype='multipart/form-data'><div class='form-body'>";
      $this->Javascript = "";
      $this->SaveTable = $SaveTable;
      $this->SaveReturn = $SaveReturn;
      $this->SaveKey = $SaveKey;
      $this->SaveKeyValue = $SaveKeyValue;
      $this->Insert = $Insert;
      $this->BackLink = "";
      $this->PostUrl = "";
      $this->ContentDiv = "divMainContent";
      $this->MDcols = "6";
      $this->LGcols = "6";
    }
    public function Display()
    {
      $this->BuildButtons();
      $this->BuildFooter();
      $JScript = "";
      $Hidden = "<input type='hidden' name='savetable'  id='savetable' value='$this->SaveTable'>";
      $Hidden .= "<input type='hidden' name='savereturn'  id='savereturn' value='$this->SaveReturn'>";
      $Hidden .= "<input type='hidden' name='savekey'  id='savekey' value='$this->SaveKey'>";
      $Hidden .= "<input type='hidden' name='savekeyvalue'  id='savekeyvalue' value='$this->SaveKeyValue'>";

      $this->BuildPostScript();

      if ($this->Javascript != '')
      {
        $JScript = "<script>" . $this->Javascript . "</script>";
      }

      return $this->Header . $Hidden . $this->Return . $this->Footer .$JScript;
    }
    private function BuildFooter()
    {
      $this->Footer = "</form><div id=divsave></div></div>";
    }
    private function BuildPostScript()
    {

      $PostTo = ($this->Insert ? 'insert' : 'save');

      $this->Javascript .= "
      $(document).ready(function (e) {
    $('#" . $this->Id ."').on('submit',(function(e) {

      // validate form
      e.preventDefault();
      var iserror = false;
      var namep = $('#name').val();
      if( namep === '')
      {
        iserror = true;
        $('#divsave').text('error, please fill in the name of the product').show();
      }

      if(iserror ==false)
      {
        $('#divsave').html(\"<p><img src='images/loader.gif' style='width:12px; height:12px;'>Loading...</p>\");
        $.ajax({
          url: 'functions/$PostTo.php?save=y',
          type: 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data)
          {
            var response = $(data);
            var saveResult = response.find('#saveResult').val();
            if($.isNumeric(saveResult))
            {
              $('#" . $this->ContentDiv. "').load('" . $this->PostUrl . "' + saveResult);
            }
            else
            {
              $('#divsave').html(data);
            }
          }
        });
      }
    }));
  });";
    }
    public function BuildButtons()
    {
      //$this->return .="<button id='btnsave" . $this->id ."'>" . ($this->insert == true ? "Add New" : "Save") . "</button>";

      $this->Return .="<div class='form-actions'>
                <div class='row'>
                  <div class='col-md-6'>
                    <div class='row'>
                      <div class='col-md-offset-3 col-md-9'>";

      $this->Return .="<button type='submit' id='btnsave" . $this->Id ."' class='btn btn-success'>" . ($this->Insert == true ? "Add New" : "Save") . "</button>";

      $this->Return .="</div>
                    </div>
                  </div>
                  <div class='col-md-6'> </div>
                </div>
              </div>";

      if ($this->BackLink != "")
      {
        $this->Return .="<button id='btnback" .$this->Id ."'>Cancel</button>";
        $this->Javascript .= "  $(function() {
                $( '#btnback" . $this->id ."' ).button().click(function( event ) {
                  event.preventDefault();
                  $('#" .$this->ContentDiv ."').load('" . $this->BackLink ."');
                });
              });";
      }
    }

    public function AddGroup()
    {
      $this->return .="<tr" . ($id != '' ? " id='$id'" : "")
              . ($class != '' ? " class='$class'" : "")
              . ($style != '' ? " style='$style'" : "") . ">";
    }

    public function AddSubHeading($Description)
    {
      $this->Return .= "<h3 class='box-title'>$Description</h3><hr class='m-t-0 m-b-40'>";
    }

    public function AddCustomHTML($HTML)
    {
      $this->Return .= "$HTML";
    }

    public function AddCustomCell($HTML, $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true)
    {
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $this->Return .= "<div class='form-group'> $HTML </div>";

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }
    }

    public function NewRow()
    {
     $this->Return .= "<div class='row'>";
    }

    public function EndRow()
    {
     $this->Return .= "</div>";
    }

    public function NewCol($Md = "6", $Sm = "12", $Lg = "6")
    {
     $this->Return .= "<div class='col-md-$Md col-sm-$Sm col-lg-$Lg'>";
    }

    public function EndCol()
    {
     $this->Return .= "</div>";
    }

    public function AddTextBox($Name, $Id, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false)
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeTextBox("field[$Name]", $Id, $Javascript, $Value, $Title, $PlaceHolder, $HelpBtn, $HelpBlock, 'form-control', $Required);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }


    }

    public function AddHidden($Name, $Id, $Value = '')
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";

      $Return .= MakeHidden("field[$Name]", $Id, $Javascript, $Value);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

    }

     public function AddTextarea($Name, $Id, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false)
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeTextarea("field[$Name]", $Id, $Javascript, $Value, $Title, $PlaceHolder, $HelpBtn, $HelpBlock, 'form-control', $Required);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }


    }

    public function AddSelect($Name, $Id, $Value = '', $Title = '', $Key, $Display, $Table, $Where = '', $OrderBy = 'display', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false, $InitialDisplay = '', $InitialValue = '')
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeSelect("field[$Name]", $Id, $Javascript, $Value, $Title, $Key, $Display, $Table, $Where, $OrderBy, $HelpBtn, $HelpBlock, 'form-control', $Required, $InitialDisplay, $InitialValue);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }


    }

    public function AddDate($Name, $Id, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false)
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeDate("field[$Name]", $Id, $Javascript, $Value, $Title, $PlaceHolder, $HelpBtn, $HelpBlock, 'form-control', $Required);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }


    }

    public function AddTime($Name, $Id, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false)
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeTime("field[$Name]", $Id, $Javascript, $Value, $Title, $PlaceHolder, $HelpBtn, $HelpBlock, 'form-control', $Required);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }


    }

    public function AddFileDrop($Name, $Id, $Value = '', $Title = '', $PlaceHolder ='', $HelpBtn = '', $HelpBlock ='', $NewRow = true, $NewCol = true, $EndCol = true, $EndRow = true, $Required = false)
    {
      $Javascript = $Return = '';
      require_once "../formfunctions.php";
      If($NewRow)
      {
        $this->NewRow();
      }
      if($NewCol)
      {
          $this->NewCol($this->MDcols, "12", $this->LGcols);
      }
      $Return .= "<div class='form-group'>";
      $Return .= MakeFileDrop("$Name", $Id, $Javascript, $Value, $Title, $PlaceHolder, $HelpBtn, $HelpBlock, 'form-control', $Required);
      $Return .= "</div>";
      $this->Javascript .= $Javascript;
      $this->Return .= $Return;

      if($EndCol)
      {
          $this->EndCol();
      }
      If($EndRow)
      {
          $this->EndRow();
      }
    }
  }
?>
