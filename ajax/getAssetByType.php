<?php
require_once ('../module/assetModule.php');
//$type = $_GET['type'];
//echo $type;

if(isset($_GET['type'])){
    $assets =getAssetByTypes($_GET['type']);
    $msg="";
    foreach($assets as $x){
        $msg = $msg. '<option value="'.$x["asset_id"].'">'.$x["name"].'</option>';
    }
    echo $msg;
}
//var_dump($type);
//echo $type;

