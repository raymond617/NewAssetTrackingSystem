<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() >=1) {
        if(isset($_GET['asset_id'])){
            $asset_id = $_GET['asset_id'];
        }
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <style  type="text/css">
                    
                </style>
            </head>
            <body>
                <header class="row">
                    <h2 id="page_name">Asset timetable</h2>
                </header>
                <article>
                        <p><?php echo "Asset ID: ".$asset_id;?> </p>
                </article>
           </body>
           <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
        </html>
<?php
    } else {
        header('Refresh: 3;url=../index.php');
        echo "You have no authorize\n redirect in 3 seconds";
    }
    } else {
        header('Refresh: 3;url=../index.php');
        echo "You need login as an admin.";
}
