<?php

  require_once "functions/functionmain.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

		/*function validata($data){
			$data = stripcslashes($data);
			$data = trim($data);
			$data = htmlspecialchars($data);
			return $data;
		}*/

    if(Get('savecontact') == 'y')
    {
      $name = validata(Post('name'));
      $email = validata(Post('email'));
      $message = validata(Post('message'));

      if ($name != '' && $email != '' && $message != '')
      {

            $sqlupdate = "insert into contactrequests(name, email, message)
                                values('" . $name . "','" . $email . "','" . $message . "') returning name";
            if (execute_sql($sqlupdate, $ra, $error))
            {
                echo "success";
            }
            else
            {
                 echo "Something went wrong :$sqlupdate";
            }

      }
    }

    if(Get('register') == 'y')
    {
      $first_name = validata(Post('first_name'));
      $last_name = validata(Post('last_name'));
      $name = validata(Post('name'));
      $email = validata(Post('email'));
      $gender = validata(Post('gender'));
      $locale = validata(Post('locale'));
      $id = validata(Post('id'));
      $picture = validata(Post('picture'));
      $link = validata(Post('link'));

      if ($name != '' && $id != '')
      {

            // Check whether user data already exists in database
            $prevQuery = "SELECT count(contactid) as cntc FROM contacts
                          WHERE oauth_provider = 'facebook'
                          AND oauth_uid = '$id'";

            if (execute_sql($prevQuery, $ra, $error))
            {
                if($ra[0]['cntc'] == 0)
                {
                  $query = "INSERT INTO contacts(oauth_provider,oauth_uid,firstnames,
                            surname,email,gender,
                            locale,profileimage,facebook)
                            values('facebook',
                                    '$id',
                                    '$first_name',
                                    '$last_name',
                                    '$email',
                                    '$gender',
                                    '$locale',
                                    '$picture',
                                    '$link') returning firstnames";


                  if (execute_sql($query, $ra, $error))
                  {
                   echo "success";
                  }
                  else
                  {
                   echo "Snap, Sorry Peepz, Something went wrong :(";
                  }

               }
               else
               {
                 echo "success";
               }
            }
            else
            {
               echo "Error checking for previous records";
            }

      }
    }
	}
?>
