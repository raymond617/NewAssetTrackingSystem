<?php
require_once ('class/Objects.php');
require_once ('functions/system_function.php');
session_start();
//include_once("functions/user_info_functions.php");

if (checkLogined() == true) {
    $object = $_SESSION['object'];
    ?>
    <!doctype html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
            <style type="text/css">
            input,label{
                display:block;
            }
            
                    
                    
                    .btn {
                        width: auto;
                    }
        </style>
        </head>
        <body>
            <header class="row">
                <h1 id="site_logo"><a href="index.php">Laboratory asset tracking system</a></h1>
                <h2 id="page_name">User profile</h2>
                <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
            </header>
            <div>
                <?php
                if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['contact_no'])) {
                    if ($object->updateInformation($_POST['username'], $_POST['email'], $_POST['contact_no']) == true) {
                        header('Refresh: 3;url=user_info.php');
                        echo "update info success";
                    } else {
                        header('Refresh: 3;url=user_info.php');
                        echo "fail to update info";
                    }
                } else if (isset($_POST['oldPassword']) && strlen($_POST['oldPassword']) != 0 && isset($_POST['newPassword']) && strlen($_POST['newPassword']) != 0) {
                    if ($object->changePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword']) == true) {
                        header('Refresh: 3;url=user_info.php');
                        echo "change password success\n redirect in 3 seconds";
                    } else {
                        header('Refresh: 3;url=user_info.php');
                        echo "fail to change, the old password is wrong or confirm password doesn't match the new password\n redirect in 3 seconds";
                    }
                } else {
                    ?>
                    <form action="" method="post">
                        <label for="username">User name:</label>
                        <input id="username" name="username" type="text" value="<?php echo $object->getUserName(); ?>" tabindex="1">
                        <label for="email">Email:</label>
                        <input id="email" name="email" type="email" value="<?php echo $object->getEmail(); ?>" tabindex="2">
                        <label for="contact_no">Contact no.:</label>
                        <input id="contact_no" name="contact_no" type="text" value="<?php echo $object->getContact_no(); ?>" tabindex="3">
                        <input id="updateSubmit" type="submit" value="Update Information" tabindex="4">
                    </form>
                    <form action="" method="post">
                        <label for="oldPassword">Old password:</label>
                        <input id="oldPassword" name="oldPassword" type="password" placeholder="old password" tabindex="5">
                        <label for="newPassword">New password:</label>
                        <input id="newPassword" name="newPassword" type="password" placeholder="new password" tabindex="6">
                        <label for="confirmPassword">Confirm password:</label>
                        <input id="confirmPassword" name="confirmPassword" type="password" placeholder="confirm password" tabindex="7" onBlur="comparePassword()">
                        <!-- Result:<div id="result" style="display:inline-block"></div> -->
                        <br>
                        <input id="changePassword" type="submit" value="Change Password" tabindex="8">
                    </form>
                <?php } ?>
            </div>
        </body>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script type="text/javascript">

                            function comparePassword() {
                                var newPassword = document.getElementById('newPassword');
                                var confirmPassword = document.getElementById('confirmPassword');
                                if (strcmp(newPassword.value, confirmPassword.value) == 0 && newPassword.value.length != 0) {
                                    $("#newPassword").css({'background-color': 'green'});
                                    $("#confirmPassword").css({'background-color': 'green'});
                                    //$("#newPassword").css("background-color: green");
                                    //document.getElementById('result').innerHTML="true";
                                } else {
                                    //$("#newPassword").css("background-color: red");
                                    $("#newPassword").css({'background-color': 'red'});
                                    $("#confirmPassword").css({'background-color': 'red'});
                                    //document.getElementById('result').innerHTML="false";
                                }
                            }
                            function strcmp(str1, str2) {
                                return ((str1 == str2) ? 0 : ((str1 > str2) ? 1 : -1));
                            }
        </script>
    </html>
    <?php
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}?>