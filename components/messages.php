<?php
  $RequireLogin = true;
  require_once "../functions/functionmain.php";

  call_user_func('messages_' . Get("fn", 'Default'));

  function messages_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');

    //echo PageHeader('Messages');

    messages_Display();
  }

  function messages_Display()
  {
    $ProfileID = Get('profileid');
    $MessageID = Get('messageid');
    echo <<<HTML

          <div class="row">
                    <div class="col-12">
                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner">
HTML;

    echo messages_DisplayMenu();

    echo <<<HTML
                                    </div>
                                </div>
                                <!-- .chat-left-panel -->
                                <!-- .chat-right-panel -->
                                <div class="chat-right-aside" id='divChatContent'>
HTML;

    echo messages_DisplayChats();

    echo <<<HTML
                                </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
                        </div>
                    </div>
                </div>
                <script src="../js/chat.js"></script>

HTML;

  }

  function messages_DisplayChats()
  {
    $ProfileID = Get('profileid');
    $MessageID = Get('messageid');

    if($MessageID == '')
    {
      $Return = "Please select a chat group on the left menu";
    }
    else
    {

      $ParentTitle = DB("select subject from messages where messageid=$1","$MessageID");
      $Return = "<div class='chat-main-header'>
                       <div class='p-20 b-b'>
                            <h3 class='box-title'>$ParentTitle</h3>
                       </div>
                 </div>
                 <div class='chat-rbox'>";

      $sSQL = "select messageid, contactfrom, message, datesent, dateread, c.profileimage,
                      (c.firstnames || ' ' || c.surname) as fromname
                      from messages m
                      join contacts c
                      on m.contactfrom = c.contactid
                      where messageid= $1 or parentid= $1
                      order by datesent desc, dateread nulls first limit 50";
      if(execute_sql($sSQL, $raMessages, $error, [$MessageID]))
      {
          $Return .= "<ul class='chat-list p-20'>";
          foreach ($raMessages as $rowM)
          {
              if($rowM['contactfrom']== $ProfileID)
              {
                $Return .= "<li>
                              <div class='chat-img'><img src='$rowM[profileimage]' alt='user' /></div>
                              <div class='chat-content'>
                                   <h5>$rowM[fromname]</h5>
                                   <div class='box bg-light-info'>$rowM[message]</div>
                              </div>
                              <div class='chat-time'>$rowM[datesent]</div>
                            </li>";
              }
              else
              {
                $Return .= "<li class='reverse'>
                                <div class='chat-content'>
                                     <h5>$rowM[fromname]</h5>
                                     <div class='box bg-light-inverse'>$rowM[message]</div>
                                </div>
                                <div class='chat-img'><img src='$rowM[profileimage]' alt='user' /></div>
                                <div class='chat-time'>$rowM[datesent]</div>
                            </li>";
              }

          }
          $Return .= "</ul>
                </div>
                <div class='card-body b-t'>
                <div class='row'>
                <div class='col-8'>
                     <textarea placeholder='Type your message here' class='form-control b-0'></textarea>
                </div>
                <div class='col-4 text-right'>
                     <button type='button' class='btn btn-info btn-circle btn-lg'><i class='fa fa-paper-plane-o'></i> </button>
                </div>";
      }
      else
      {
        $Return .="sorry, something went wrong";
      }



     $Return.= "</div>
                </div> ";
    }
    echo $Return;

  }

  function messages_DisplayMenu()
  {
      $ProfileID = Get('profileid');
      $MessageID = Get('messageid');
      $Return = "";
      /*$Return .= " <div class='form-material'>
                       <input class='form-control p-20' type='text' placeholder='Search Contact'>
                       </div>";*/

      $ForceSelect = "select ";

      $sSQL = "select messageid, subject, contact, lastsent, hasunread,
                  c.profileimage, (c.firstnames || ' ' || c.surname) as contactname
                  from (select distinct messageid, substring(subject from 0 for 80) as subject,
                                  (case when contactto = $1 then contactfrom else contactto end) as contact,
                                  coalesce((select max(datesent) from messages where parentid= m.messageid),datesent) as lastsent,
                                  case when dateread is null
                                      then true
                                      else exists(select 1 from messages where parentid= m.messageid and dateread is null)
                                      end as hasunread
                                  from messages m
                                  where (contactto=$1 or contactfrom=$1) and parentid is null
                  ) cm
                  join contacts c on cm.contact = c.contactid
                  order by hasunread, lastsent";

      if(execute_sql($sSQL, $raMessages, $error, [$ProfileID]))
      {
          $Return .= "<ul class='chatonline style-none '>";
          foreach ($raMessages as $rowM)
          {

              $Unread = ($rowM['hasunread'] == 't' ? "active" : "");
              $Return .= " <li>
                               <a onclick='javascript:LoadDivContent('messages.php?profileid=$ProfileID&messageid=$rowM[messageid]&fn=DisplayChats','divChatContent');' class='$Unread'>
                               <img src='$rowM[profileimage]' alt='user-img' class='img-circle'>
                               <span>$row[contactname]
                               <small class='text-info'>$row[subject]</small>
                               </span></a>
                            </li>";
          }
          $Return .= "  <li class='p-20'></li>
                  </ul>";
      }
      else
      {
        $Return .= "There are no messages to display";
       }


    echo $Return;

  }

  function messages_DisplayContacts()
  {
    $ProfileID = Get('profileid');


  }
?>

