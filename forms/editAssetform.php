<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
session_start();
if (checkLogined() == true) {
    $adminObject = $_SESSION['object'];
    if ($adminObject->getUserLevel() == 3) {
        $currentAssetID = $_GET['asset_id'];
        $assetObject = $_SESSION['object']->getAssetInfo($currentAssetID);
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                 <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <style>
                    body{
                        width:500px;
                    }
                select,label{
                        display:block;
                    }
                </style>
            </head>
            <body>
                <h2>Edit asset</h2>
                <form action="../functions/assetsProcessor.php" method="post" id="edit_asset">
                    <label for="assetID">Asset ID:</label>
                    <input id="assetID" name="assetID" type="text" value="<?php echo $assetObject->getID(); ?>" disabled>
                    <input id="assetID" name="assetID" type="hidden" value="<?php echo $assetObject->getID(); ?>">
                    <label for="labID">Laboratory ID:</label>
                    <input id="labID" name="labID" type="text" value="<?php echo $assetObject->getLabID(); ?>">
                    <label for="name">Asset name:</label>
                    <input id="name" name="name" type="text" value="<?php echo $assetObject->getName(); ?>" >
                    <label for="type">Asset type:</label>
                    <input id="type" name="type" type="text" value="<?php echo $assetObject->getTheType(); ?>">
                    <label for="days_b4_alert">Date before alert:</label>
                    <input id="days_b4_alert" name="days_b4_alert" type="text" value="<?php echo $assetObject->getDayB4alert(); ?>">
                    <label for="status">Status:</label>
                    <input id="status" name="status" type="text" value="<?php echo $assetObject->getStatus(); ?>">
                    <input id="action" name="edit_asset" type="hidden" value="true">

                    <input id="submit" type="submit" value="Edit Asset">
                </form>
            </body>
        </html>
        <?php
    } else {
        echo "You have no authorize\n redirect in 3 seconds";
        header('Refresh: 3;url=index.php');
    }
} else {
    echo "You need login as an admin.";
    header('Refresh: 3;url=index.php');
}
?>	