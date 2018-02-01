<?php
  require_once "conset/config.php";
  require_once "HTML.php";
  require_once "RequestHandler.php";
  require_once "formpage.php";
  session_start();

  if(isset($_GET['logout']))
  {
    Logout();
  }
  if(isset($RequireLogin) && $RequireLogin)
  {
    if (!isset($_SESSION['userid']) && (empty($currpage) || $currpage !== 'login.php'))
    {
      echo "<script language=javascript>document.location.href='beta/login.php';</script>";
      //echo "<script language=javascrip>LoadMainContent('../beta/login.php');</script>";
    }
  }
//phpinfo();
  require_once "conset/config.php";
  require_once "classes/icons.php";
  try
  {
    $pwdsql = md5('P@ssw0rd1');
    //$sqlPConn = pg_pconnect("host=localhost port=5432 dbname=craigv1_peepz user=craigv1_adminpg password=P@ssw0rd1");
    //$sqlPConn = pg_pconnect("host=localhost port=5432 dbname=postgres user=postgres password=OuLlrud8s1L8");
    $sqlPConn = pg_pconnect("host=" . DB_SERVER ." port=" .DB_PORT. " dbname=" .DB_NAME. " user=" .DB_USER. " password=" .DB_PASS);
    //$dbcon = @mysqli_connect('localhost', 'craigv1_admin', 'P@ssw0rd1', 'craigv1_gobroker') OR trigger_error("Could not connect to database!");
  }
  catch (Exception $e)
  {
    echo var_Dump($e->getMessage());
  }
  function execute_sql($sql, &$ra, &$error, $params = array ())
  {
    global $sqlPConn;
    if (!is_array($params)) $params = array ($params);
    if ($sqlPConn === false)
    {
      die("db failure");
    }
    $continue = 'n';

    $lastsql = $sql . ' (' . var_export($params, true) . ')';
    if (isset($_SESSION['lastsql']))
    {
      if ($lastsql != $_SESSION['lastsql'])
      {
        $_SESSION['lastsql'] = $lastsql;
        $continue = 'y';
      }
    }
    else
    {
      $continue = 'y';
      $_SESSION['lastsql'] = $lastsql;
    }

    if ($continue = 'y')
    {
      if (count($params) == 0)
      {
        $result = pg_query($sqlPConn, $sql);
      }
      else
      {
        $result = pg_query_params($sqlPConn, $sql, $params);
      }


      if (false !== $result)
      {
        $ra = pg_fetch_all($result);
      }
      else
      {
        $ra = false;
      }

      $error = pg_last_error($sqlPConn);

      return ($ra !== false);
    }
    else
    {
      return false;
    }
  }
  function updatetable($table, $params, $where = '', $return = '')
  {
    $sqlupdate = "update $table set changedby = " . $_SESSION['userid'];

 //$sqlupdate = "update $table set changedby = 1";

    foreach ($params as $key => $value)
    {
      $sqlupdate .= ", $key = '$value'";
    }

    if ($where != '')
    {
      $sqlupdate .= " where $where";
    }

    if ($return != '')
    {
      $sqlupdate .= " returning $return";
    }

    if (execute_sql($sqlupdate, $ra, $error))
    {
      if ($return != '')
      {
        return $ra[0]["$return"];
      }
      else
      {
        return 'success';
      }
    }
    else
    {
      return "Error: $error";
    }
  }
  function inserttable($table, $params, $return = '')
  {
    $sqlupdate = "insert into $table";
    $sqlfields = "changedby";
    //$sqlvalues = "$1";
    $sqlvalues = $_SESSION['userid'];
    //$sqlarray = array ($_SESSION['userid']);
    $x = 1;
    foreach ($params as $key => $value)
    {
      //$x++;
      $sqlfields .= ",$key";
      //$sqlvalues .= ",$" . $x;
      $sqlvalues .= ",'$value'";
      //array_merge($sqlarray, array ($value));
    }

    $sqlupdate .= "($sqlfields) values($sqlvalues) ";
    if ($return != '')
    {
      $sqlupdate .= " returning $return";
    }
    if (execute_sql($sqlupdate, $ra, $error))
    {
      if ($return != '')
      {
        return $ra[0]["$return"];
      }
      else
      {
        return 'success';
      }
    }
    else
    {
      return "Error: $error";
    }
  }

  function DB($sql, $params = array())
        {
            if (!is_array($params))
            {
                $params = array($params);
            }
            try
            {
                if (!execute_sql($sql, $ra, $error, $params))
                {
                    $ra[0]['No Result'] = null;
                }
                //set_error_handler("userError");
            } catch (Exception $e)
            {
                /*global $oldnotice, $id;
                set_error_handler("userError");
                if (strpos($e->getMessage(), 'canceling statement due to statement timeout') !== false)
                {
                    pg_connection_reset($id);
                    return false;
                }
                else
                {
                    RaiseError($e->getMessage());
                    return false;
                }*/
            }

            if (count($ra) > 1)
            {
                return $ra;
            }
            if (count($ra[0]) == 1)
            {
                return array_shift($ra[0]);
            }
            if (count($ra) == 1)
            {
                return $ra[0];
            }
            return $ra;
        }

  function execute($sql, $params = array(), $quiet = false)
        {
            if (!is_array($params))
            {
                $params = array($params);
            }
            return execute_sql($sql, $ra, $error, $params);
        }

  function pwdhash($password)
  {
    return md5($password . 'goglobalit');
  }
  function Login($Email, $Password)
  {

    $sSQLLogin = "select contactid, surname, firstnames  from contacts
                    where (email='$Email' or idno = '$Email' or cellno='$Email') and password='$Password'";

    if (execute_sql($sSQLLogin, $ra, $error))
    {
      $_SESSION['userid'] = $ra[0]['contactid'];
      $_SESSION['surname'] = $ra[0]['surname'];
      $_SESSION['firstnames'] = $ra[0]['firstnames'];
      $loginresult = "successful";
    }
    else
    {
      $loginresult = "Invalid Username or Password!";
    }

    return $loginresult;
  }

  function LoginFacebook($Oauth_UID)
  {

    $sSQLLogin = "select contactid, surname, firstnames  from contacts
                    where oauth_provider = 'facebook' AND oauth_uid = '$Oauth_UID'";

    if (execute_sql($sSQLLogin, $ra, $error))
    {
      $_SESSION['userid'] = $ra[0]['contactid'];
      $_SESSION['surname'] = $ra[0]['surname'];
      $_SESSION['firstnames'] = $ra[0]['firstnames'];
      $loginresult = "successful";
    }
    else
    {
      $loginresult = "Facebook user not registered";
    }

    return $loginresult;
  }

  function Register($Firstnames, $Surname, $Idno, $Cellno, $Email,$Password, $IsAgent)
  {

    $SQL = "insert into contacts(firstnames, surname, idno,cellno, email, password, isagent)
            values($1, $2, $3, $4, $5, $6, $7) returning contactid";

    if(execute_sql($SQL, $Ra, $Error, [$Firstnames,$Surname,$Idno,$Cellno,$Email,$Password,$IsAgent]))
    {
        $_SESSION['userid'] = $Ra[0]['contactid'];
        $_SESSION['surname'] = $Surname;
        $_SESSION['firstnames'] = $Firstnames;
        $RegisterValid = "successful";
    }
    else
    {
      $RegisterValid = "Error registering new user!";
    }

    return $RegisterValid;
  }
  function RegisterFacebook($Oauth_Provider,$Oauth_UID,$Firstnames, $Surname, $Email,$Gender, $Locale,$Picture,$Link)
  {

    $prevQuery = "SELECT count(contactid) as cntc FROM contacts
                          WHERE oauth_provider = 'facebook'
                          AND oauth_uid = '$Oauth_UID'";

            if (execute_sql($prevQuery, $ra, $error))
            {
                if($ra[0]['cntc'] == 0)
                {
                    $SQL = "INSERT INTO contacts(oauth_provider,oauth_uid,firstnames,
                                            surname,email,gender,
                                            locale,profileimage,facebook)
                                            values($1,$2,$3,$4,$5,$6,$7,$8,$9) returning contactid";

                    if(execute_sql($SQL, $Ra, $Error, [$Oauth_Provider,$Oauth_UID,$Firstnames,$Surname,$Email,$Gender,$Locale,$Picture,$Link]))
                    {
                        $_SESSION['userid'] = $Ra[0]['contactid'];
                        $_SESSION['surname'] = $Surname;
                        $_SESSION['firstnames'] = $Firstnames;
                        $RegisterValid = "success";
                    }
                    else
                    {
                      $RegisterValid = "Error registering new user!";
                    }
                }
                else
                {
                    $RegisterValid = "This facebook account has already been registered. Please go to login";
                }
             }

    return $RegisterValid;
  }
  function Get($key, $default = '')
  {
    return (array_key_exists($key, $_GET)) ? htmlentities($_GET[$key], ENT_COMPAT, "UTF-8") : $default;
  }
  function Post($key, $default = '')
  {
    return (array_key_exists($key, $_POST)) ?
            (is_array($_POST[$key]) ? $_POST[$key] : htmlentities($_POST[$key], ENT_COMPAT, "UTF-8")) : $default;
  }
  Function SendSMSpvt($CellNo, $Message)
  {

    $user = "craigmv";
    $password = "Password1";
    $api_id = "3145935";
    $baseurl = "http://api.clickatell.com";
    $text = urlencode($Message);
    $to = $CellNo;

    // auth call
    $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
    // do auth call
    $ret = file($url);
    // split our response. return string is on first line of the data returned
    $sess = split(":", $ret[0]);
    if ($sess[0] == "OK")
    {
      $sess_id = trim($sess[1]); // remove any whitespace
      $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
      // do sendmsg call
      $ret = file($url);
      $send = split(":", $ret[0]);
      if ($send[0] == "ID") return "success. message ID: " . $send[1];
      else return "send message failed";
    } else
    {
      return "Authentication failure: " . $ret[0];
      exit();
    }
  }

  function SendEmail_old($to, $subject, $body, $from = 'Peepz <info@peepz.online>', $attachment = '')
  {

    //$to = "craig@1web.co.za";
    //$subject = "Testing ";
    //$body = "<p>Your <i>message</i> here.</p>";
    //$from = "info@ido.co.za";
    //$headers = "To: Craig Vermeulen <craig@1web.co.za>\n";

    if ($attachment <> '')
    {
      $file_size = filesize($attachment);
      $handle = fopen($attachment, "r");
      $content = fread($handle, $file_size);
      fclose($handle);
      $content = chunk_split(base64_encode($content));
      $uid = md5(uniqid(time()));
      $name = basename($attachment);
      $headers = "From: " . $from . "\r\n";
      $headers .= "Reply-To: " . $from . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
      $headers .= "This is a multi-part message in MIME format.\r\n";
      $headers .= "--" . $uid . "\r\n";
      $headers .= "Content-type:text/plain; charset=iso-8859-1\r\n";
      $headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
      $headers .= $body . "\r\n\r\n";
      $headers .= "--" . $uid . "\r\n";
      $headers .= "Content-Type: application/octet-stream; name=\"" . $attachment . "\"\r\n"; // use different content types here
      $headers .= "Content-Transfer-Encoding: base64\r\n";
      $headers .= "Content-Disposition: attachment; filename=\"" . $attachment . "\"\r\n\r\n";
      $headers .= $content . "\r\n\r\n";
      $headers .= "--" . $uid . "--";

      if (mail($to, $subject, "", $headers))
      {
        //echo("<p>Message successfully sent!</p>");
      }
      else
      {
        echo("<p>Message delivery failed...</p>");
      }
    }
    else
    {
      $headers = "From: $from\n";
      $headers .= "MIME-Version: 1.0\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1;\n";

      if (mail($to, $subject, $body, $headers))
      {
        //echo("<p>Message successfully sent!</p>");
      }
      else
      {
        echo("<p>Message delivery failed...</p>");
      }
    }
  }
  function ToCurr($number, $symbol = 'R ', $space = '&nbsp;', $dec = 2)
  {
    if ($number === null) return '';
    return str_replace(' ', $space, $symbol . number_format(round($number, $dec), $dec, ',', ' '));
  }
  function NoWrap($data, $width = 100, $prefix = '')
  {
    return "<div style='text-align:left;white-space: nowrap;width:{$width}px;overflow:hidden;' title='" . str_replace("'", "`", $data) . "'>$prefix$data<div>";
  }

  function Button($Caption, $Url, $TargetDiv = '', $Class = '', $Icon = '', $CustomOnClick ='')
  {

    $OnClick = " onclick=\"LoadDivContent('$Url', '$TargetDiv')\"";
    if($CustomOnClick != '')
    {
      $OnClick = $CustomOnClick;
    }

    $Return = <<<HTML
      <a $OnClick class="btn $Class"><i class="fa $Icon" aria-hidden="true"></i> $Caption</a>
HTML;

    return $Return;
  }
  function setDateToday()
  {

    $date = getdate();

    if (strlen($date['mday']) == 1) $day = "0" . $date['mday'];
    else $day = $date['mday'];
    if (strlen($date['mon']) == 1) $mon = "0" . $date['mon'];
    else $mon = $date['mon'];
    $value = $day . "/" . $mon . "/" . $date['year'];

    return $value;
  }
  function logactivity($section, $key, $url)
  {
    $sSQL = "insert into recentactivity(userid, section, key, url) values ($1, $2, $3, $4)";
    execute_sql($sSQL, $ra, $error, array ($_SESSION['userid'], $section, $key, $url));

  }
  //session_write_close();

  function DisplayStars($Stars)
  {
      $Return =" <span>";
      for ($x = 1; $x <= 5; $x++)
      {
          $Filled = ($Stars < $x ? "" : "text-warning");
          $Return .= "<i class='fa fa-star $Filled'></i>";
      }

      return $Return;
  }

  function Logout()
  {
    session_start();
    unset($_SESSION["userid"]);
    //echo "<script language=javascript>document.location.href='beta/login.php';</script>";
}
function validata($data){
			$data = stripcslashes($data);
			$data = trim($data);
			$data = htmlspecialchars($data);
			return $data;
		}
?>
