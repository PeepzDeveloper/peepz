<?php
  require_once "functionmain.php";


  if (Get("save") == 'y')
  {
    $table = Post('savetable');
    $return = Post('savereturn');

    if ($table != '' && $return != '')
    {
      echo "<div id='content'>";
      $result = inserttable("$table", $_POST['field'], "$return");
      echo "<input type='hidden' id='saveResult' value='$result'>";
      echo "</div>";
    }
  }
?>
