<?php
function acrossMidnight($start_time,$end_time){
    $start_time = split(" ",$start_time);
    $end_time = split(" ",$end_time);
    if($start_time[0] != $end_time[0]){
        return true;
    }  else {
        return false;
    }
}
function dateConvert($time){
    $newDateString = date(DATE_W3C,  strtotime($time));
    return $newDateString;
}
class MyDatePeriod extends DatePeriod
{
    public $dates;

    public function toArray()
    {
        if ($this->dates === null) {
            $this->dates = iterator_to_array($this);
        }

        return $this->dates;
    }
}

$begin ="2014-04-06 23:30:00";
$end = "2014-12-31 23:00:00";
$timeslot= array();

if(acrossMidnight($begin,$end)){
    $begin_split = split(" ",$begin);
    $end_split = split(" ",$end);
    $firstDay = array("start"=>$begin,"end"=>$begin_split[0]." 23:59:59");
    array_push($timeslot,$firstDay);
    
    $secondStart = date('Y-m-d',strtotime(str_replace('-','/',$begin_split[0])."+1 day"))." 00:00:00";
    $secondEnd = date('Y-m-d',strtotime(str_replace('-','/',$begin_split[0])."+1 day"))." 23:59:59";
    $secondDay = array("start"=>$secondStart,"end"=>$secondEnd);
    array_push($timeslot,$secondDay);    
    
    $lastSecondStart = date('Y-m-d',strtotime(str_replace('-','/',$end_split[0])."-1 day"))." 00:00:00";
    $lastSecondEnd = date('Y-m-d',strtotime(str_replace('-','/',$end_split[0])."-1 day"))." 23:59:59";
    $lastSecondDay = array("start"=>$lastSecondStart,"end"=>$lastSecondEnd);
    
    $interval = DateInterval::createFromDateString('1 day');
    $periodStart = new DatePeriod(new DateTime($secondStart), $interval, new DateTime($lastSecondStart));
    
    foreach ($periodStart as $dt){
        $oneDay = array("start"=>$dt->format("Y-m-d H:i:s"),"end"=>str_replace("00:00:00","23:59:59",$dt->format("Y-m-d H:i:s")));
        array_push($timeslot,$oneDay);
    }
    
    array_push($timeslot,$lastSecondDay);
    
    $lastDay = array("start"=>$end_split[0]." 00:00:00","end"=>$end);
    array_push($timeslot,$lastDay);
    
}

print_r($timeslot);
