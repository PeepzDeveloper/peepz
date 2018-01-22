<?php
  require_once "../functions/functionmain.php";

  call_user_func('Calendar_' . Get("fn", 'Default'));

  function Calendar_Default()
  {
    //require_once "../functions/setpage.php";
    $ProfileID = Get('profileid');

    $CalHTML = <<<HTML
                  <div class='row'>
                    <div class='col-md-12'>
                        <div class='card'>
                            <div class=''>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <div class='card-body'>
                                            <h4 class='card-title m-t-10'>Menu</h4>

                                        </div>
                                    </div>
                                    <div class='col-md-9'>
                                        <div class='card-body b-l calender-sidebar'>
                                            <div id='calendar'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal none-border' id='calendarModal'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h4 class='modal-title' id='modalTitle'><strong>Event</strong></h4>
                            </div>
                            <div class='modal-body' id='modalBody'></div>
                            <div class='modal-footer' id='modalFooter'>
                              <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal" id="btnEventDetail">More Detail</button>
                                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal none-border' id='mCalendarSearch'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h4 class='modal-title' id='mSearchTitle'><strong>Search for Events</strong></h4>
                            </div>
                            <div class='modal-body' id='mSearchBody'></div>
                            <div class='modal-footer' id='mSearchFooter'>
                              <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal" id="btnEventSearch">Search</button>
                                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function(){
                      var calendar = $('#calendar').fullCalendar({
                          header:{
                              left: 'prev,next today',
                              center: 'title',
                              right: 'month,agendaWeek,agendaDay'
                          },
                          defaultView: 'month',
                          editable: true,
                          selectable: true,
                          allDaySlot: false,

                          events: "components/calendar.php?profileid=2&fn=GetEvents",


                          eventClick:  function(event, jsEvent, view) {
                              var StartTime = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD HH:mm:ss");
                              var EndTime = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD HH:mm:ss");
                              /*var When = StartTime + ' - ' + EndTime;*/
                              var Title = '<img src="' + event.logo + '"> <span style="margin-left:20px;">' + event.title + '</span>';
                              var BodyText = '<p>' + event.description + '</p>' + '<p>Start: ' + StartTime + '<br> End: ' + EndTime + '</p>';
                              var Footer ='';
                              $('#modalTitle').html(Title);
                              $('#modalBody').html(BodyText);
                              $( "#btnEventDetail" ).bind( "click", function() {
                                                      LoadMainContent('viewjob.php');
                                                    });
                              $('#calendarModal').modal();
                          },

                          //header and other values
                          select: function(start, end, jsEvent) {
                              StartTime = moment(start).format('YYYY-MM-DD');
                              // end = moment(end).format('YYYY-MM-DD');
                              var BodyText = '<p>Search for jobs on ' + StartTime + '</p>';

                              $('#mSearchBody').html(BodyText);
                              $( "#btnEventSearch" ).bind( "click", function() {
                                      LoadMainContent('jobsearch.php?profileid=$ProfileID&startdate=' + StartTime);
                                                    });
                              $('#mCalendarSearch').modal('toggle');
                         }
                      });



                  });

                    </script>
HTML;



    echo $CalHTML;
  }

  function Calendar_GetEvents()
  {
    $ProfileID = Get('profileid');
    $GigsList=array();

    $SQL = <<<SQL
            select jobid, title, description, j.companyid, brandid,
            (datestart + timestart) as start, (dateend+ timeend) as "end",
            c.name, c.logo
            from jobs j
            join companies c
            on j.companyid=c.companyid
SQL;
    $GigsList = DB($SQL);

    /*$GigsList = [0 => ['title' => 'Released Ample Admin!',
                     'start' =>'2017-10-09 9:00:00',
                     'end' => '2017-10-09 10:00:00'],
               1 => ['title' => 'Like it?',
                     'start' => '2017-10-10 12:00:00',
                     'end' => '2017-10-10 13:00:00']
                ];*/



    echo json_encode($GigsList);
  }
?>
