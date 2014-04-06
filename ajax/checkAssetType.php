<?php
require_once ('../module/assetModule.php');
//echo "success";
if(isset($_GET['type'])&&isset($_GET['name'])&&isset($_GET['id'])){
    //echo true;
    $assetInfo = getAssetsByID($_GET['id']);
    //print_r($assetInfo);
    $assetType=$assetInfo[0]['type'];
    $assetName=$assetInfo[0]['name'];
    //echo $assetType." & ".$assetName;
    if(strcmp($_GET['type'],$assetType)==0){
        echo $assetName;
    }else{
        echo "false";
    }
}





