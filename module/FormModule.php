<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

/* function getNewFormID() {
  global $pdo;
  try {
  $stmt = $pdo->prepare("select max(form_id) from appl_form");
  $stmt->execute();
  $maxFormID = $stmt->fetch();
  $maxFormID++;
  return $maxFormID;
  } catch (Exception $e) {
  echo "retrive max form id fail";
  }
  } */

function formSubmit(array $userIDs, array $assets_id, $project_title, $professor_id, $course_code, $bench, $status, $start_time, $end_time) {
    global $pdo;
    //$newFormID=getNewFormID();
    $count = 0;
    $stmt = $pdo->prepare('insert into appl_form (status,course_code,project_title,admin_id,prof_id) values (?,?,?,?,?)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    $stmt3 = $pdo->prepare('insert into users_r_form (id,form_id) values (?,?)');
    try {
        if ($stmt->execute(array('1', $course_code, $project_title, 10002000, $professor_id)) == true) {
            $count++;
        }
        $newID = $pdo->lastInsertId();
        foreach ($userIDs as $value) {
            $stmt3->execute(array($value, $newID));
            $count++;
        }
        foreach ($assets_id as $value) {
            $stmt2->execute(array($newID, $value, $start_time, $end_time, '1'));
            $count++;
        }
        if ($stmt2->execute(array($newID, $bench, $start_time, $end_time, '1')) == true) {
            $count++;
        }
        if ($count == 2 + count($userIDs) + count($assets_id)){
            return true;
        }else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}
function equipimentFormSubmit($userID, array $assets_id, $status, $start_time, $end_time) {
    global $pdo;
    //$newFormID=getNewFormID();
    $count = 0;
    $stmt = $pdo->prepare('insert into appl_form (status) values (?)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    $stmt3 = $pdo->prepare('insert into users_r_form (id,form_id) values (?,?)');
    try {
        if ($stmt->execute(array($status)) == true) {
            $count++;
        }
        $newID = $pdo->lastInsertId();
        
            if($stmt3->execute(array($userID, $newID))==true){
                $count++;
            }
       
        foreach ($assets_id as $value) {
            $stmt2->execute(array($newID, $value, $start_time, $end_time, $status));
            $count++;
        }
        
        if ($count == 2 + count($assets_id)){
            return true;
        }else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}
function listAllForms() {
    global $pdo;
    //$stmt = $pdo->prepare('select * from appl_form where status >=1 and status <=5 or status = 9 ORDER BY `apply_timestamp` ');
    $stmt = $pdo->prepare('select af.* from appl_form af, form_r_asset f where af.form_id = f.form_id and
(af.status not between 6  and 8)and
f.asset_id IN (select asset_id from assets where type="bench")
ORDER BY `apply_timestamp` ');
    $stmt->execute();
    $FormInfoArray = $stmt->fetchAll();
    $fullFormArray = array();
    foreach ($FormInfoArray as $row) {
        $one_column = $row;
        $userArray = listAllUsersFromForm($row['form_id']);
        $AssetArray = listAllAssetsFromFormWithoutBench($row['form_id']);
        $bench = findTheBenchFromForm($row['form_id']);
        $one_column['user_array'] = $userArray;
        $one_column['asset_array'] = $AssetArray;
        $one_column['bench'] = $bench;
        array_push($fullFormArray, $one_column);
    }
    return $fullFormArray;
}
function listAllEquipimentForms() {
    global $pdo;
    //$stmt = $pdo->prepare('select * from appl_form where status = 6 or status = 7 ORDER BY `apply_timestamp`');
    $stmt = $pdo->prepare('select af.* from appl_form af, form_r_asset f where af.form_id = f.form_id and
(f.status BETWEEN 4 and 7)and
f.form_id NOT IN (select form_id from form_r_asset f,assets a where a.type="bench" and f.asset_id = a.asset_id)ORDER BY `apply_timestamp` ');
    $stmt->execute();
    $FormInfoArray = $stmt->fetchAll();
    $fullFormArray = array();
    foreach ($FormInfoArray as $row) {
        $one_column = $row;
        $userArray = listAllUsersFromForm($row['form_id']);
        $AssetArray = listAllAssetsFromFormWithoutBench($row['form_id']);
        $one_column['user_array'] = $userArray;
        $one_column['asset_array'] = $AssetArray;
        array_push($fullFormArray, $one_column);
    }
    return $fullFormArray;
}

function listAllFormsWithStatus($status){
    global $pdo;
    //$stmt = $pdo->prepare('select * from appl_form where status = ? ORDER BY `apply_timestamp`');
    $stmt = $pdo->prepare('SELECT DISTINCT a . * , f.end_time
FROM appl_form a, form_r_asset f
WHERE a.status = ?
AND a.form_id = f.form_id
AND f.end_time > ( 
SELECT NOW( ) ) 
ORDER BY `apply_timestamp`');
    $stmt->execute(array($status));
    $FormInfoArray = $stmt->fetchAll();
    $fullFormArray = array();
    foreach ($FormInfoArray as $row) {
        $one_column = $row;
        $userArray = listAllUsersFromForm($row['form_id']);
        $AssetArray = listAllAssetsFromFormWithoutBench($row['form_id']);
        $bench = findTheBenchFromForm($row['form_id']);
        $one_column['user_array'] = $userArray;
        $one_column['asset_array'] = $AssetArray;
        $one_column['bench'] = $bench;
        array_push($fullFormArray, $one_column);
    }
    return $fullFormArray;
}

function listAllUsersFromForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('select id from users_r_form where form_id =?');
    $stmt->execute(array($form_id));
    $userIDArray = $stmt->fetchAll();
    return $userIDArray;
}
function listAllUsersIDAndEmailFromForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('select u.id,l.email from users_r_form u,lts_users l where form_id =79 and u.id = l.id');
    $stmt->execute(array($form_id));
    $userIDAndEmailArray = $stmt->fetchAll();
    return $userIDAndEmailArray;
}
function listAllAssetsFromFormWithoutBench($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.form_id, f.asset_id, f.start_time, f.end_time, f.status, a.name, a.type
FROM form_r_asset f, assets a
WHERE f.asset_id = a.asset_id
AND form_id =?
AND a.type <> "bench"
LIMIT 0 , 30');
    $stmt->execute(array($form_id));
    $AssetInfoArray = $stmt->fetchAll();
    return $AssetInfoArray;
}

function findTheBenchFromForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.asset_id, a.name,f.start_time,f.end_time from assets a, form_r_asset f where f.asset_id = a.asset_id and type = "bench" and form_id = ?');
    $stmt->execute(array($form_id));
    $bench = $stmt->fetchAll();
    return $bench;
}

function showOneForm($form_id) {
    global $pdo;
    $stmt = $pdo->prepare('select * from appl_form where form_id = ?');
    $stmt->execute(array($form_id));
    $FormInfo = $stmt->fetchAll();
    $OneFormInfo = $FormInfo[0];
    $userArray = listAllUsersFromForm($OneFormInfo['form_id']);
    $AssetArray = listAllAssetsFromFormWithoutBench($OneFormInfo['form_id']);
    $bench = findTheBenchFromForm($OneFormInfo['form_id']);
    $OneFormInfo['user_array'] = $userArray;
    $OneFormInfo['asset_array'] = $AssetArray;
    $OneFormInfo['bench'] = $bench;
    return $OneFormInfo;
}
function showOneFormDetail($form_id){
    global $pdo;
    $stmt = $pdo->prepare('select * from appl_form where form_id = ?');
    $stmt->execute(array($form_id));
    $FormInfo = $stmt->fetchAll();
    $OneFormInfo = $FormInfo[0];
    $userArray = listAllUsersFromForm($OneFormInfo['form_id']);
    $AssetArray = listAllAssetsFromFormWithoutBench($OneFormInfo['form_id']);
    $bench = findTheBenchFromForm($OneFormInfo['form_id']);
    $OneFormInfo['user_array'] = $userArray;
    $OneFormInfo['asset_array'] = $AssetArray;
    $OneFormInfo['bench'] = $bench;
    return $OneFormInfo;
}
function deleteFormM($form_id){
    global $pdo;
    $stmt = $pdo->prepare('DELETE from appl_form where form_id = ?');
    return $stmt->execute(array($form_id));    
}
function edit_and_approveForm($form_id,$project_title,$course_code,$asset_array,$status,$bench,$start_time,$end_time){
    global $pdo;
    $count =0;
    $stmt = $pdo->prepare('update appl_form set project_title = ?,course_code=?,status=? where form_id =?');
    $stmt2 =$pdo->prepare('DELETE From form_r_asset where form_id = ? AND asset_id IN (SELECT asset_id from assets)');
    $stmt3 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    
    if($stmt->execute(array($project_title,$course_code,$status,$form_id))){
        $count++;
    }
    if($stmt2->execute(array($form_id))){
        $count++;
    }
    if($stmt3->execute(array($form_id,$bench,$start_time,$end_time,$status))){
        $count++;
    }
    foreach($asset_array as $value){
        if($stmt3->execute(array($form_id,$value,$start_time,$end_time,$status))){
            $count++;
        }
    }
    if($count == 3+ count($asset_array)){
        return true;
    }else{
        return false;
    }
}
function edit_and_approveEquipimentForm($form_id,$asset_array,$status,$start_time,$end_time){
    global $pdo;
    $count =0;
    $stmt = $pdo->prepare('update appl_form set status=? where form_id =?');
    $stmt2 =$pdo->prepare('DELETE From form_r_asset where form_id = ? AND asset_id IN (SELECT asset_id from assets)');
    $stmt3 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status) values (?,?,?,?,?)');
    
    if($stmt->execute(array($status,$form_id))){
        $count++;
    }
    if($stmt2->execute(array($form_id))){
        $count++;
    }
    foreach($asset_array as $value){
        if($stmt3->execute(array($form_id,$value,$start_time,$end_time,$status))){
            $count++;
        }
    }
    if($count == 2+ count($asset_array)){
        return true;
    }else{
        return false;
    }
}
function lendingAssetAndBench($form_id,$assetid_list,$start_time,$end_time,$bench){
    global $pdo;
    $count = 0;
    $stmt =$pdo->prepare('DELETE From form_r_asset where form_id = ? AND asset_id IN (SELECT asset_id from assets)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status,real_start) values (?,?,?,?,?,DATE_ADD(NOW(),INTERVAL 1 SECOND))');
    $stmt3 = $pdo->prepare('update appl_form set status = ? where form_id = ?');
    $stmtTime = $pdo->query('SELECT NOW();');
    $stmtTime->execute();
    $timestamp = $stmtTime->fetch()[0];
    //$timestamp = date('Y-m-d G:i:s');
    if($stmt->execute(array($form_id))){
        $count++;
    }
    foreach($assetid_list as $value){
        if($stmt2->execute(array($form_id,$value,$start_time,$end_time,4))){
            $count++;
        }
    }
    if($stmt2->execute(array($form_id,$bench,$start_time,$end_time,3))){
        $count++;
    }
    if($stmt3->execute(array(4,$form_id))){
        $count++;
    }
    if($count == 3+count($assetid_list)){
        return true;
    }else{
        return false;
    }
}
function lendingEquipiment($form_id,$assetid_list,$start_time,$end_time){
    global $pdo;
    $count = 0;
    $stmt =$pdo->prepare('DELETE From form_r_asset where form_id = ? AND asset_id IN (SELECT asset_id from assets)');
    $stmt2 = $pdo->prepare('insert into form_r_asset (form_id,asset_id,start_time,end_time,status,real_start) values (?,?,?,?,?,?)');
    $stmt3 = $pdo->prepare('update appl_form set status = ? where form_id = ?');
    $stmtTime = $pdo->query('SELECT NOW();');
    $stmtTime->execute();
    $timestamp = $stmtTime->fetch()[0];
    //$timestamp = date('Y-m-d G:i:s');
    if($stmt->execute(array($form_id))){
        $count++;
    }
    foreach($assetid_list as $value){
        if($stmt2->execute(array($form_id,$value,$start_time,$end_time,4,$timestamp))){
            $count++;
        }
    }
    if($stmt3->execute(array(4,$form_id))){
        $count++;
    }
    if($count == 2+count($assetid_list)){
        return true;
    }else{
        return false;
    }
}
function checkFormExpire($form_id){
    global $pdo;
    $stmtTime = $pdo->query('SELECT NOW();');
    $stmtTime->execute();
    $timestamp = $stmtTime->fetch()[0];
    //$timestamp = date('Y-m-d G:i:s');
    $stmt=$pdo->prepare('select end_time from form_r_asset where form_id = ?');
    $stmt->execute(array($form_id));
    $end_time_list = $stmt->fetchAll();
    if($end_time_list==null){
        return "notfound";
    }
    $end_time = $end_time_list[0][0];
    //return $end_time." && ".$timestamp ;
    if($timestamp >= $end_time){
        return true;
    }else{
        return false;
    } 
}
function checkFormApproval($form_id){
     global $pdo;
     $stmt=$pdo->prepare('select status from appl_form where form_id = ? limit 1');
     $stmt->execute(array($form_id));
     $status = $stmt->fetch();
     return ($status[0]=='3' or $status[0]=='7');
}
function checkFormStatus($form_id){
     global $pdo;
     $stmt=$pdo->prepare('select status from appl_form where form_id = ? limit 1');
     $stmt->execute(array($form_id));
     $status = $stmt->fetch();
     return $status[0];
}
function listFormByStudentID($student_id){
    global $pdo;
    $stmt = $pdo->prepare('select form_id from users_r_form where id = ?');
    $stmt->execute(array($student_id));
    $form_list = $stmt->fetchAll();
    return $form_list;
}
function listAllFormsDetailByUserID($user_id) {
    global $pdo;
    $stmt = $pdo->prepare('select a.* from appl_form a, users_r_form u where a.form_id = u.form_id and u.id = ? ORDER BY `apply_timestamp` 
LIMIT 0 , 30');
    $stmt->execute(array($user_id));
    $FormInfoArray = $stmt->fetchAll();
    $fullFormArray = array();
    foreach ($FormInfoArray as $row) {
        $one_column = $row;
        $userArray = listAllUsersFromForm($row['form_id']);
        $AssetArray = listAllAssetsFromFormWithoutBench($row['form_id']);
        $bench = findTheBenchFromForm($row['form_id']);
        $one_column['user_array'] = $userArray;
        $one_column['asset_array'] = $AssetArray;
        $one_column['bench'] = $bench;
        array_push($fullFormArray, $one_column);
    }
    return $fullFormArray;
}
function returnAsset($asset_id){
    global $pdo;
    $stmtTime = $pdo->query('SELECT NOW();');
    $stmtTime->execute();
    $timestamp = $stmtTime->fetch()[0];
    //$timestamp = date('Y-m-d G:i:s');
    $stmt = $pdo->prepare('update form_r_asset set status = ?, real_end = ? where asset_id = ? and status = ?');
    $stmt2 = $pdo->prepare('select form_id from form_r_asset where asset_id = ? and status = 4');
    $stmt3 = $pdo->prepare('update appl_form set status = 5 where form_id = ?');
    $stmt2->execute(array($asset_id));
    $form_id = $stmt2->fetch()[0];
    if($stmt->execute(array(5,$timestamp,$asset_id,4)))
            if($stmt->rowCount()>=1){
                $count = countAssetStillInLendingOfTheForm($form_id);
                if($count==0){
                    $stmt3->execute(array($form_id));
                }
                return true;
            }
    else
        return false;
}
function countAssetStillInLendingOfTheForm($form_id){
    global $pdo;
    $stmt = $pdo->prepare('SELECT count( f.status ) AS lending
FROM form_r_asset f, assets a
WHERE a.type <> "bench"
AND f.asset_id = a.asset_id
AND f.form_id = ?
AND f.status =4');
    $stmt->execute(array($form_id));
    $count = $stmt->fetch()[0];
    return $count;
}