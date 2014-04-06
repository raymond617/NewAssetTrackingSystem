<?php
require_once ('functions/system_function.php');
require_once ('class/Objects.php');
session_start();
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
        <style  type="text/css">
            #loginOut{
                float:right;
            }
        </style>
    </head>
    <body>
        <header class="row">
            <h1 id="site_logo"><a href="">Laboratory asset tracking system</a></h1>
            <?php include rootPath() . "/common_content/login_panel.php"; // div of login panel?>
        </header>
        <?php
        if (checkLogined() == true) {
            $object = $_SESSION['object'];
            if ($object->getUserLevel() == 3) {
                ?>
                <ul>
                    <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
                    <li><a href="forms/equipiment_borrowing.php">Equipiment borrowing</a></li>
                    <li><a href="myForm.php">My form</a></li>
                    <li><a href="admin_page.php">Admin Page</a></li>
                </ul>

                <?php
            } else if ($object->getUserLevel() == 2) {
                ?>
                <ul>
                    <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
                    <li><a href="forms/equipiment_borrowing.php">Equipiment borrowing</a></li>
                    <li><a href="form_approve_management.php">Approve forms</a></li>
                    <li><a href="myForm.php">My form</a></li>
                </ul>
            <?php 
            
            } else if ($object->getUserLevel() == 1) {
                ?>
                <ul>
                    <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
                    <li><a href="forms/equipiment_borrowing.php">Equipiment borrowing</a></li>
                    <li><a href="myForm.php">My form</a></li>
                </ul>
                <?php
            }
        }
        ?>

    </body>
</html>