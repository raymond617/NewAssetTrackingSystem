<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() == 3) {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <style  type="text/css">
                    select,label{
                        display:block;
                    }
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="../index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Barcode generator</h2>
                    <?php include rootPath() . "common_content/login_panel_deep.php"; // div of login panel?>
                </header>
                <article>
                    <form action="../functions/FormProcessor.php" method="post" id="return">
                        <label for="ad">ID:</label>
                        <input id="id" name="id" type="text" value="" placeholder="ID">
                        <input type="hidden" name="barcode" value="true">
                        <input type="submit" value="Generate">
                    </form>
                </article>
           </body>
           <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
           
        </html>
<?php
    } else {
    echo "You have no authorize\n redirect in 3 seconds";
    header('Refresh: 3;url=../index.php');
    }
    } else {
echo "You need login as an admin.";
header('Refresh: 3;url=../index.php');
}
