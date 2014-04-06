<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../functions/system_function.php');
require_once ('../module/assetModule.php');

function checkSOPreviewer(array $assets_id){
    $assetWithSOPList = getAssetWithSOP($assets_id);
    return $assetWithSOPList;
}
