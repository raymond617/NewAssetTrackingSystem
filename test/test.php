<?php
require_once '../functions/connectDB.php';
require_once ('../module/assetModule.php');
require_once '../class/AssetObject.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo addAssets("2","bench","U","Bench 1",1,"1");
$assetInfoArray = getAssetsByID("1");
foreach ($assetInfoArray as $key => $value){
    if(is_array($value)){
        foreach ($value as $key2 => $data){
            echo "element: $key, porperty: $key2, value: $data <br>";
        }
    }else{
        echo "porperty: $key, => $value\n";
    }
}
print_r($assetInfoArray);