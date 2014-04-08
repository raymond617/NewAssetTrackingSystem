<?php
require_once ('../functions/system_function.php');
require_once ('../module/UserModule.php');
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
try {
    if(isset($_POST['add_user'])){
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email= $_POST['email'];
        $contact_no = $_POST['contact_no'];
        $user_level = $_POST['user_level'];
        $user_type = $_POST['user_type'];
        try{
            if(addUser($user_id, $name, $email, $contact_no, $user_level, $user_type)){
                echo 'Add user success!';
            }else{
                echo 'Add user fail!';
            }
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../lendingPage.php');
        }
    }else if(isset($_GET['delete_user'])){
        $user_id = $_GET['user_id'];
        try{
            if(deleteUser($user_id)){
                echo 'Delete user success!';
            }else{
                echo 'Delete user fail!'; 
            }
        }catch (Exception $e){
            echo 'Delete asset fail!';
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

    if ($message != '')
        header('X-Error-Description: ' . $message);

    exit;
}
