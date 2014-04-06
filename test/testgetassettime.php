<?php
require_once '../module/assetModule.php';

if(isset($_GET['start_time'])&&isset($_GET['end_time'])&&isset($_GET['bench_id'])){
    
    $benchTimeList = getAssetTimesList($_GET['bench_id'],1);
    $result = "success";
    foreach ($benchTimeList as $value) {
        $s_time_l = $value['start_time'];
        $e_time_l = $value['end_time'];
        if(checkTimeOverlap($start_time,$end_time,$s_time_l,$e_time_l)){
            $result = "fail";
            break;
        }
    }
    echo $result;
    //echo $_GET['start_time']." @@@@ ".$_GET['end_time']." bench: ".$_GET['bench_id'];
}
function checkTimeOverlap($start_time,$end_time,$s_time_l,$e_time_l){
    if($start_time >= $s_time_l && $start_time < $e_time_l || $end_time> $s_time_l && $end_time <= $e_time_l || $s_time_l >= $start_time && $s_time_l < $end_time || $e_time_l> $start_time && $e_time_l <= $end_time)
        return true;
    else
        return false;
}

