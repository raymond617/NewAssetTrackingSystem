<?php
require_once 'class/Objects.php';
require_once ('functions/system_function.php');
session_start();
if (checkLogined() == true && $_SESSION['object']->getUserLevel() == 3) {
    $object = $_SESSION['object'];
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Admin page</title>
            <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
            <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
        </head>
        <body>
            <header class="row">
                <h1 id="site_logo"><a href="">Laboratory asset tracking system</a></h1>
                <h2 id="page_name">Admin page</h2>
                <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
            </header>
            <ul>
                <li><a href="edit_asset.php">Asset management</a></li>
                <li><a href="forms/experiment_reservation_form.php">Reserve an experiment</a></li>
                <li><a href="form_management.php">Form management</a></li>
                <li><a href="equipiment_form_management.php">Equipiment borrowing management</a></li>
                <li><a href="form_approve_management.php">Approve forms</a></li>
                <li><a href="forms/lendingPage.php">Lending page</a></li>
                <li><a href="forms/returnPage.php">Return page</a></li>
                <li><a href="forms/barcode_generator.php">Barcode generator</a></li>
                <li><a href="current_asset_in_lent.php">Current lending asset</a></li>
            </ul>

        </body>
    </html>
<?php
} else {
    header('Refresh: 3;url=index.php');
    echo "must login as admin";
    
}
?>