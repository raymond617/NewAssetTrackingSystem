<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Asset_control_system/functions/connectDB.php');
$pdo = connectDB();

function getProfessorNameM($prof_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT username FROM lts_users where id = ?');
    $stmt->execute(array($prof_id));
    $profName = $stmt->fetchAll();
    return $profName;
}
function listAllUsersDetailFromForm($form_id){
    global $pdo;
    $stmt = $pdo->prepare('
SELECT lu.id, lu.username, lu.email, lu.contact_no, lu.user_level
FROM users_r_form uf, lts_users lu
WHERE uf.form_id =?
AND uf.id = lu.id');
    $stmt->execute(array($form_id));
    $userIDArray = $stmt->fetchAll();
    return $userIDArray;
}
function listAllUserM(){
    global $pdo;
    $stmt = $pdo->prepare('select * from lts_users');
    $stmt->execute();
    $userArray = $stmt->fetchAll();
    return $userArray;
}
function addUser($user_id,$name,$email,$contact_no,$user_level,$user_type){
    global $pdo;
    $stmt = $pdo->prepare('insert into lts_users (id,username,email,contact_no,user_level,user_type,password) values (?,?,?,?,?,?,?)');
    try {
        if ($stmt->execute(array($user_id, $name, $email, $contact_no, $user_level, $user_type,"1234567")) == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}

function deleteUser($user_id) {
    global $pdo;
    $stmt = $pdo->prepare('delete from lts_users where id =?');
    try {
        if ($stmt->execute(array($user_id)) == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        //echo $e;
        return FALSE;
    }
}
