<?php
require_once ('../class/Objects.php');
session_start();
//require_once ('../class/assetObject.php');
try {
    if (isset($_POST['add_asset'])) {
        $assetGetArray = array('labID' => $_POST['labID'],
            'name' => $_POST['name'],
            'assetID' => $_POST['assetID'],
            'type' => $_POST['type'],
            'daysB4Alert' => $_POST['days_b4_alert'],
            'sop' => $_POST['sop'],
                'status'=>'A');
        try{
            if($_SESSION['object']::addAsset($assetGetArray)){
                echo 'add asset success!';
                //header('Refresh: 3;url=../edit_asset.php');
            }else{
                echo 'add asset fail!\n May be deplicate asset id or lab id not exists';
                //header('Refresh: 3;url=../edit_asset.php');
            }
        }catch (Exception $e){
            echo "Create object failed.\n";
        
        }
        /*try{
            if($assetOject->addAssetToDB() == true){
                echo 'add asset success!';
                header('Refresh: 3;url=../add_assets.php');
            }else{
                echo 'add asset fail!\n May be deplicate asset id or lab id not exists';
                header('Refresh: 3;url=../add_assets.php');
            }
        }catch (Exception $ee){
            echo "addAssetToDB() Exception";
        }*/
    }else if(isset($_POST['edit_asset'])){
        $assetInfoArray = array('labID' => $_POST['labID'],
            'name' => $_POST['name'],
            'assetID' => $_POST['assetID'],
            'type' => $_POST['type'],
            'daysB4Alert' => $_POST['days_b4_alert'],
            'sop' => $_POST['sop'],
                'status'=>$_POST['status']);
        try{
            if($_SESSION['object']::updateAsset($assetInfoArray)){
                echo 'edit asset success!';
                //header('Refresh: 3;url=../edit_asset.php');
            }else{
                echo 'edit asset fail!\n May be deplicate asset id or lab id not exists';
                //header('Refresh: 3;url=../edit_asset.php');
            }
        }catch (Exception $e){
            echo "Create object failed.\n";
        
        }
        
    }else if(isset($_GET['delete_asset'])){
        $asset_id = $_GET['asset_id'];
        try{
            if($_SESSION['object']::deleteAsset($asset_id)){
                echo 'Delete asset success!';
            }else{
                echo 'Delete asset fail!'; 
            }
        }catch (Exception $e){
            echo 'Delete asset fail!';
        }
        
    }else if(isset($_POST['row_selected'])){
        $list_of_assets = $_POST['row_selected'];
        try{
            foreach($list_of_assets as $value){
                $_SESSION['object']::deleteAsset($value);   
            }
                //echo 'delete assets success!';
                header('Location:../edit_asset.php');
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../edit_asset.php');
        }
    }
} catch (Exception $e) {
    echo "Exception.\n";
    exitWithHttpError(500);
}
function exitWithHttpError($error_code, $message = '') {
    switch ($error_code) {
        case 400: header("HTTP/1.0 400 Bad Request");
            break;
        case 403: header("HTTP/1.0 403 Forbidden");
            break;
        case 404: header("HTTP/1.0 404 Not Found");
            break;
        case 500: header("HTTP/1.0 500 Server Error");
            break;
    }
    header('Content-Type: text/plain');
    if ($message != ''){
        header('X-Error-Description: ' . $message);
    }
    exit;
}
