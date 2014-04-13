<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();

function dateConvert($time) {
    $newDateString = date(DATE_W3C, strtotime($time));
    return $newDateString;
}

function acrossMidnight($start_time, $end_time) {
    $start_time = split(' ', $start_time);
    $end_time = split(' ', $end_time);
    if ($start_time[0] != $end_time[0]) {
        return true;
    } else {
        return false;
    }
}

function splitAcrossNightToDays($begin, $end) {
    $timeslot = array();

    $begin_split = split(" ", $begin);
    $end_split = split(" ", $end);
    $firstDay = array("start" => $begin, "end" => $begin_split[0] . " 23:59:59");
    array_push($timeslot, $firstDay);

    $secondStart = date('Y-m-d', strtotime(str_replace('-', '/', $begin_split[0]) . "+1 day")) . " 00:00:00";
    $secondEnd = date('Y-m-d', strtotime(str_replace('-', '/', $begin_split[0]) . "+1 day")) . " 23:59:59";
    $secondDay = array("start" => $secondStart, "end" => $secondEnd);
    array_push($timeslot, $secondDay);

    $lastSecondStart = date('Y-m-d', strtotime(str_replace('-', '/', $end_split[0]) . "-1 day")) . " 00:00:00";
    $lastSecondEnd = date('Y-m-d', strtotime(str_replace('-', '/', $end_split[0]) . "-1 day")) . " 23:59:59";
    $lastSecondDay = array("start" => $lastSecondStart, "end" => $lastSecondEnd);

    $interval = DateInterval::createFromDateString('1 day');
    $periodStart = new DatePeriod(new DateTime($secondStart), $interval, new DateTime($lastSecondStart));

    array_push($timeslot, $lastSecondDay);

    foreach ($periodStart as $dt) {
        $oneDay = array("start" => $dt->format("Y-m-d H:i:s"), "end" => str_replace("00:00:00", "23:59:59", $dt->format("Y-m-d H:i:s")));
        array_push($timeslot, $oneDay);
    }

    $lastDay = array("start" => $end_split[0] . " 00:00:00", "end" => $end);
    array_push($timeslot, $lastDay);
    
    return $timeslot;
}

if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() >= 1) {
        if (isset($_GET['asset_id'])) {
            $asset_id = $_GET['asset_id'];
            $asset_info = getAssetsByID($asset_id);
            $timelistArray = getAssetReserveTime($asset_id);
            $editedArray = array(); // open an array for save edited data to json
            foreach ($timelistArray as $value) {
                if ($value['status'] == 3 || $value['status'] == 7 || $value['status'] == 4 || $value['status'] == 5) {
                    $oneRow = array("id" => $value['form_id'], "start" => dateConvert($value['start_time']), "end" => dateConvert($value['end_time']), "title" => $value['form_id']);
                    array_push($editedArray, $oneRow);
                }
            }
            $returnInJSON = json_encode($editedArray);
        }

        //$bookingArray = getAssetReserveTime($asset_id);
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

                <link rel='stylesheet' type='text/css' href='timetable/css/reset.css' />
                <!--
                    <link rel='stylesheet' type='text/css' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css' />
                -->
                <link rel='stylesheet' type='text/css' href='timetable/css/jquery-ui-1.8rc3.custom.css' />
                <link rel='stylesheet' type='text/css' href='timetable/css/jquery.weekcalendar.css' />
                <link rel='stylesheet' type='text/css' href='timetable/css/demo.css' />
                <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
                <!--
         <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js'></script>
                -->
                <script type='text/javascript' src='timetable/js/jquery-ui-1.8rc3.custom.min.js'></script>
                <script type='text/javascript' src='timetable/js/jquery.weekcalendar.js'></script>
                <!--<script type='text/javascript' src='timetable/js/demo.js'></script>-->
                <style  type="text/css">

                </style>
            </head>
            <body>
                <header class="row">
                    <h2 id="page_name">Asset timetable</h2>
                    <p>Type: <?php echo $asset_info[0]['type']; ?> Name: <?php echo $asset_info[0]['name']; ?></p>
                </header>
                <div id='calendar'></div>
                <article>
                    <p><?php echo "Asset ID: " . $asset_id; ?> </p>
                </article>
            </body>
            <script type="text/javascript">
                $(document).ready(function() {


                    var $calendar = $('#calendar');
                    var id = 10;

                    var neededData;
                    /*$.getJson('getAssetTimeJSON.php?asset_id=<?php echo $asset_id; ?>',function(jsonData){
                     neededData = jsonData; 
                     });*/
                    //alert(neededData);


                    $calendar.weekCalendar({
                        timeslotsPerHour: 4,
                        allowCalEventOverlap: true,
                        overlapEventsSeparate: false,
                        firstDayOfWeek: 1,
                        businessHours: {start: 6, end: 23, limitDisplay: false},
                        daysToShow: 7,
                        height: function($calendar) {
                            return $(window).height() - $("h1").outerHeight() - 1;
                        },
                        readonly: true,
                        eventClick: function(calEvent, $event) {
                            window.open('../forms/editApplForm.php?form_id=' + calEvent.title, 'formDetail', 'height=500,width=700,left=0,top=0,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
                        },
                        eventMouseover: function(calEvent, $event) {
                        },
                        eventMouseout: function(calEvent, $event) {
                        },
                        noEvents: function() {

                        },
                        data: function(start, end, callback) {
                            //callback(neededData);
                            callback(getEventData());
                        }

                    });

                    function resetForm($dialogContent) {
                        $dialogContent.find("input").val("");
                        $dialogContent.find("textarea").val("");
                    }

                    function getEventData() {
                        var year = new Date().getFullYear();
                        var month = new Date().getMonth();
                        var day = new Date().getDate();

                        /*var neededData; 
                         $.getJson('getAssetTimeJSON.php?asset_id=<?php echo $asset_id; ?>',function(jsonData){
                         neededData = jsonData; 
                         }); 
                         alert(JSON.parse(neededData));*/
                        return {
                            //events: neededData
                            events:<?php echo $returnInJSON; ?>
                            /*[
                             {
                             
                             "start": new Date(year, month, day, 12),
                             "end": new Date(year, month, day, 13, 30),
                             "title": "Lunch with Mike"
                             },
                             {
                             
                             "start": new Date(year, month, day, 14),
                             "end": new Date(year, month, day, 14, 45),
                             "title": "Dev Meeting"
                             },
                             {
                             
                             "start": new Date(year, month, day + 1, 17),
                             "end": new Date(year, month, day + 1, 17, 45),
                             "title": "Hair cut"
                             },
                             {
                             
                             "start": new Date(year, month, day - 1, 8),
                             "end": new Date(year, month, day - 1, 9, 30),
                             "title": "Team breakfast"
                             },
                             {
                             
                             "start": new Date(year, month, day + 1, 14),
                             "end": new Date(year, month, day + 1, 15),
                             "title": "Product showcase"
                             },
                             {
                             
                             "start": new Date(year, month, day, 10),
                             "end": new Date(year, month, day, 11),
                             "title": "I'm read-only",
                             readOnly: true
                             },
                             {   
                             "start":"2014-04-10T13:15:00.000+10:00",
                             "end":"2014-04-10T14:15:00.000+10:00",
                             "title":"testing 2014 4 10"
                             },
                             {   
                             "start":"2014-04-06T15:00:00+04:00",
                             "end":"2014-04-06T16:30:00+04:00",
                             "title":"testing 2014 4 6"
                             }
                             ]*/
                        };
                    }

                });
            </script>
            <!--<script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>-->
        </html>
        <?php
    } else {
        header('Refresh: 3;url=../index.php');
        echo "You have no authorize\n redirect in 3 seconds";
    }
} else {
    header('Refresh: 3;url=../index.php');
    echo "You need login as an admin.";
}
