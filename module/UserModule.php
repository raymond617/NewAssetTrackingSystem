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
