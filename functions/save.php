<?php
  require_once "functionmain.php";

  if (Get("save") == 'y')
  {
    $table = Post('savetable');
    $key = Post('savekey');
    $keyvalue = Post('savekeyvalue');
    $return = Post('savereturn');
    $DataSave = $_POST['field'];

    //define ('SITE_ROOT', $_SERVER["DOCUMENT_ROOT"] ."/");

    if(isset($_FILES['logo']))
    {
       $file_tmp =$_FILES['logo']['tmp_name'];
       //define ('SITE_ROOT', '/home/craigv1/public_html/peepz/');
       $file_name = "logos/company_".$keyvalue.".jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
       $DataSave['logo'] = $file_name;
    }
    if(isset($_FILES['profileimage']))
    {
       $file_tmp =$_FILES['profileimage']['tmp_name'];
       //define ('SITE_ROOT', '/home/craigv1/public_html/peepz/');
       $file_name = "logos/peepz_".$keyvalue.".jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
       $DataSave['profileimage'] = $file_name;
    }
    if(isset($_FILES['portfolio1']))
    {
       $file_tmp =$_FILES['portfolio1']['tmp_name'];
       $file_name = "portfolio/portfolio_1_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }
    if(isset($_FILES['portfolio2']))
    {
       $file_tmp =$_FILES['portfolio2']['tmp_name'];
       $file_name = "portfolio/portfolio_2_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }
    if(isset($_FILES['portfolio3']))
    {
       $file_tmp =$_FILES['portfolio3']['tmp_name'];
       $file_name = "portfolio/portfolio_3_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }
    if(isset($_FILES['portfolio4']))
    {
       $file_tmp =$_FILES['portfolio4']['tmp_name'];
       $file_name = "portfolio/portfolio_4_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }
    if(isset($_FILES['portfolio5']))
    {
       $file_tmp =$_FILES['portfolio5']['tmp_name'];
       $file_name = "portfolio/portfolio_5_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }
    if(isset($_FILES['portfolio6']))
    {
       $file_tmp =$_FILES['portfolio6']['tmp_name'];
       $file_name = "portfolio/portfolio_6_$keyvalue.jpg";
       move_uploaded_file($file_tmp,SITE_ROOT ."$file_name");
    }


    if ($table != '' && $key != '' && $keyvalue != '')
    {
      echo "<div id='content'>";
      $result = updatetable("$table", $DataSave, "$key=$keyvalue", "$return");
      echo "<input type='hidden' id='saveResult' value='$result'>";
      echo "</div>";
    }

  }
?>
