<?php

require_once ('../functions/system_function.php');

/////////////////////////////////////////////////////

try {
    if(isset($_POST['email_alert'])){
        $message = $_POST['email_content'];
        $emailArray = $_POST['email'];
        try{
            foreach($emailArray as $email){
                if(alertEmail($email,$message)){
                    echo "SENT <br>";
                }
            }
        }catch (Exception $e){
            //echo "Delete assets failed.\n";
            header('Location:../current_asset_in_lent.php');
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

