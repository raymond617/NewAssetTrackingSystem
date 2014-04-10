<?php

require_once ('../functions/system_function.php');
//require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');

$asset_id = $_GET['asset_id'];
$timelistArray = getAssetReserveTime($asset_id);
$editedArray = array(); // open an array for save edited data to json
foreach ($timelistArray as $value) {
    if($value['status']==3 || $value['status']==7 ||$value['status']==4){
        $oneRow = array("id"=> $value['form_id'],"start"=>dateConvert($value['start_time']),"end"=>dateConvert($value['end_time']),"title"=>$value['form_id']);
        array_push($editedArray,$oneRow);
    }
}

$returnInJSON = json_encode($editedArray);
//print_r($timelistArray);
//echo "<br>";
echo $returnInJSON;

function dateConvert($time){
    $newDateString = date(DATE_W3C,  strtotime($time));
    return $newDateString;
}