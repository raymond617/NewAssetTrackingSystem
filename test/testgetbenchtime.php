<?php
require_once '../module/assetModule.php';

//$benchTimeList = getBenchTimesList(1,1);
//print_r($benchTimeList);

$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];

/*foreach ($benchTimeList as $value) {
    $s_time_l = $value['start_time'];
    $e_time_l = $value['end_time'];
    if($start_time >= $s_time_l && $start_time <= $e_time_l || $end_time>= $s_time_l && $start_time <= $e_time_l){
        return false;
    }
    return true;
}*/
if(isset($_GET['start_time'])&&isset($_GET['end_time'])&&isset($_GET['bench_id'])){
    
    $benchTimeList = getBenchTimesList($_GET['bench_id'],1);
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

