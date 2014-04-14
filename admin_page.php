<?php
require_once 'class/Objects.php';
require_once ('functions/system_function.php');
require_once ('module/assetModule.php');
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
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
            <script type="text/javascript" src="javascript/jquery.maphilight.min.js"></script>
            <style type="text/css">
                #map{
                    float:right;
                    width:65%;
                    display:inline-block;
                }
                #admin_list{
                    width:30%;
                    display:inline-block;
                }
                #map_image{
                    background-image: url('image/laboratory_map.png');
                    background-repeat:no-repeat;
                    height: 306px;
                }
            </style>
            <script type="text/javascript">
                $(function() {
                    $('#map_image').maphilight({
                        fillColor:"111111",
                        strokeColor: '86FCEC',
                        stroke: true
                    });
                });
            </script>
        </head>
        <body>
            <header class="row">
                <h1 id="site_logo"><a href="index.php">Laboratory asset tracking system</a></h1>
                <h2 id="page_name">Admin page</h2>
                <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
            </header>
            <div  id="admin_list">
                <ul>
                    <li><a href="edit_asset.php">Asset management</a></li>
                    <li><a href="current_asset_in_lent.php">Current lending asset</a></li>
                    <li><a href="user_management.php">User management</a></li>
                    <li><a href="form_management.php">Form management</a></li>
                    <li><a href="equipiment_form_management.php">Equipiment borrowing management</a></li>
                    <li><a href="form_approve_management.php">Approve forms</a></li>
                    <li><a href="forms/lendingPage.php">Lending page</a></li>
                    <li><a href="forms/returnPage.php">Return page</a></li>
                    <li><a href="forms/barcode_generator.php">Barcode generator</a></li>
                </ul>
            </div>
            <div id="map">
                <img src="image/laboratory_map.png" width="452px" height="306px" alt="Laboratory map" usemap="#graphmap" id="map_image">
                <map name="graphmap">
                    <area shape="rect" coords="44.16,44.15,195.98,80.51" href="JavaScript:newPopup('functions/timetable.php?asset_id=1')" alt="Bench 1" id="bench_1" data-maphilight='<?php if(countBenchInUse(1)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                    <area shape="rect" coords="44.16,122.07,195.98,158.43" href="JavaScript:newPopup('functions/timetable.php?asset_id=11')" alt="Bench 2" id="bench_2" data-maphilight='<?php if(countBenchInUse(11)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                    <area shape="rect" coords="44.16,201.71,195.98,238.07" href="JavaScript:newPopup('functions/timetable.php?asset_id=14')" alt="abcde" id="abcde" data-maphilight='<?php if(countBenchInUse(14)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                    <area shape="rect" coords="251.8,44.15,403.62,80.51" href="JavaScript:newPopup('functions/timetable.php?asset_id=30')" alt="coffee" id="coffee" data-maphilight='<?php if(countBenchInUse(30)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                    <area shape="rect" coords="251.8,122.07,403.62,158.43" href="JavaScript:newPopup('functions/timetable.php?asset_id=5')" alt="hello" id="hello" data-maphilight='<?php if(countBenchInUse(5)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                    <area shape="rect" coords="251.8,201.71,403.62,238.07" href="JavaScript:newPopup('functions/timetable.php?asset_id=8')" alt="no.6" id="no6" data-maphilight='<?php if(countBenchInUse(8)>0){ ?>{"alwaysOn":true,"fillColor":"F25715"}<?php }?>'>
                </map>
            </div>
            
        </body>
        <script type="text/javascript">
            function newPopup(url) {
                popupWindow = window.open(url, 'popUpWindow', 'height=500,width=700,left=0,top=0,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
            }
            
        </script>
    </html>
    <?php
} else {
    header('Refresh: 3;url=index.php');
    echo "must login as admin";
}
?>