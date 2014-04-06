<?php

require_once ('../module/assetModule.php');

function checkAssetOverlap($id, $status,$start_time,$end_time) {
    $assetTimeList = getAssetTimesList($id, $status);
    foreach ($assetTimeList as $value) {
        $s_time_l = $value['start_time'];
        $e_time_l = $value['end_time'];
        if (checkTimeOverlap($start_time,$end_time, $s_time_l, $e_time_l)) {
            return true;
        }
    }
    return false;
}

//echo $_GET['start_time']." @@@@ ".$_GET['end_time']." bench: ".$_GET['bench_id'];

function checkTimeOverlap($start_time, $end_time, $s_time_l, $e_time_l) {
    if ($start_time >= $s_time_l && $start_time < $e_time_l || $end_time > $s_time_l && $end_time <= $e_time_l || $s_time_l >= $start_time && $s_time_l < $end_time || $e_time_l > $start_time && $e_time_l <= $end_time)
        return true;
    else
        return false;
}
