<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() >= 1 && isset($_SESSION['experiment_reservation_form']) or isset($_SESSION['equipiment_borrowing'])) {
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

                    .box { 
                        width: 450px; 
                        margin: 0 ; 
                        overflow: auto; 
                        border: 1px solid grey; 
                        padding: 1px; 
                        background: transparent; 
                    } 
                </style>
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
                        <div class="box">
                            <p><?php echo "Asset name: " . $row['name'] . "<br>Please download and bring the document to the lab: <a href='" . $row['sop'] . "'>" . $row['sop'] . "</a>"; ?></p>
                        </div>
                        <?php } ?>
                    
                    <input type="hidden" name="sop" value="true">
                    <input type="submit" value="Submit" id="submit">
                </form>
            </article>
        </body>
        <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
        <script type="text/javascript">
            document.getElementById("box").contentEditable = 'false';
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
