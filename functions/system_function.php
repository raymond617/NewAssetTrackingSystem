<?php
function checkLogined(){
	if (isset($_SESSION['approved']) && $_SESSION['approved']==1 && isset($_SESSION['object'])){
		return true;
	}else return false;
}
function rootPath(){
    return $_SERVER['DOCUMENT_ROOT']."/Asset_control_system/";
}
function checkWithIn2Times($start,$end,$timeToCheck){
    if($timeToCheck>=$start && $timeToCheck<=$end)
        return true;
    else
        return false;
}
function statusTranslation($status){
    switch($status){
        case 3:
            return "Approved";
        case 2:
            return "Wait for technician's approval";
        case 1:
            return "Wait for professor's approval";
        case 6:
            return "Equipiment wait for approval";
        case 7:
            return "Equipiment approved";
        case 9:
            return "Rejected";
        case 4:
            return "Lending";
        default :
            return "Error";
    }
}
function alertEmail($to,$message){
    $subject = "Asset return alert";
    //$message = 'Please return the asset Name:'.$asset_name.'ID: '.$asset_id;
    
    $headers = "From: deserter617@gmail.com";
    return mail($to,$subject,$message,$headers);
}