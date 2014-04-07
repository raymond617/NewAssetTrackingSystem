<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() >= 1 && isset($_SESSION['experiment_reservation_form']) or isset($_SESSION['equipiment_borrowing'] )) {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <style  type="text/css">
                    textarea{
                        width:auto;
                    }
                    textarea{
                        text-indent:0;
                    }
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="../index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Please read the SOP document</h2>
                    <?php include rootPath() . "common_content/login_panel_deep.php"; // div of login panel?>
                </header>
                <article>
                    <?php $sopList = $_SESSION['sop']; ?>
                    <form action="../functions/FormProcessor.php" method="post" id="sop">
                        <?php foreach ($sopList as $row) { ?>
                            <textarea rows="8" cols="50"><?php echo "Asset name: " . $row['name'] . "\nDocument: ", $row['sop']; ?>
                            </textarea>
                        <?php } ?>
                        <input type="hidden" name="sop" value="true">
                        <input type="submit" value="Submit" id="submit">
                    </form>
                </article>
            </body>
            <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
            <script type="text/javascript">
                $(window).load(function() {
                    $(function() {
                        setTimeout(function() {
                            $("#submit").attr()
                        }, 3000);
                    });
                });
            </script>
        </html>
        <?php
    } else {
        header('Refresh: 3;url=../index.php');
        echo "You have no authorize\n redirect in 3 seconds";
    }
} else {
    header('Refresh: 3;url=../index.php');
    echo "You need to login.";
}
