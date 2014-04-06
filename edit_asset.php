<?php
require_once 'class/Objects.php';
require_once ('functions/system_function.php');
session_start();
if (checkLogined() == true) {
    $adminObject = $_SESSION['object'];
    if ($adminObject->getUserLevel() == 3) {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link rel="stylesheet" type="text/css" href="css/common_style.css"/>
                <script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
                <script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>                
                <link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
                <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.fancybox').fancybox({
                            maxWidth: 700,
                            maxHeight: 400,
                            fitToView: false,
                            width: '70%',
                            height: '70%',
                            autoSize: false,
                            closeClick: false,
                            openEffect: 'none',
                            closeEffect: 'none',
                            afterClose: function() {
                                window.setTimeout(function() {
                                    window.location.href = window.location.href
                                }, 1);
                            }
                        });
                    });
                    $(document).ready(function() {
                        $('#asset_table').dataTable();
                    });
                </script>
                <style  type="text/css">
                    input,label{
                        display:block;
                    }
                    table {
                        font-family: Helvetica, Arial, sans-serif;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    td {
                        min-width: 7em;
                        height: 3em;
                    }
                    tr {
                        border-bottom: 0.1em solid #DDD;
                    }
                    th {
                        border-bottom: 0.3em solid #1A7480;
                    }
                    .narrowCol,.admin_mem_checkBox {
                        min-width: 3em;
                    }
                    .narrowCol input,.admin_mem_checkBox input{
                        min-width: 3em;
                    }
                    .wideCol {
                        min-width: 12em;
                    }
                    .actionBtn {
                        min-width: 5em;
                        font-size: 1em;
                        margin: 0.5em 1em;
                        float: left;
                    }
                    #action{
                        margin-top:0.7em;
                    }
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Asset Management</h2>
                    <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
                </header>
                <?php
                $assetInfoArray = $adminObject->listAsset();
                ?>
                <article>
                    <form action="functions/assetsProcessor.php" method="post" class="" onSubmit="return confirm('Selected asset will be deleted. Are you sure?')">
                        <label for="Delete Asset" id="action">Action: </label>
                        <input type="submit" class="actionBtn" name="Delete Asset" value="Delete" id="delete_asset">
                        <a id="add_asset" class="fancybox" data-fancybox-type="iframe" href="forms/addAssetform.php" style="display:hidden;"></a>
                        <input type="button" class="actionBtn" value="Add Asset" id="add_asset" onClick="callFancyBox(this.value);">
                        <br>
                        <br>
                        <table id="asset_table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="admin_mem_checkBox" name="all" onClick="check_all(this, 'row_selected[]')"></th>
                                    <th>Asset ID</th>
                                    <th>Asset Type</th>
                                    <th>status</th>
                                    <th>name</th>
                                    <th>days before alert</th>
                                    <th>belongs to lab</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($assetInfoArray as $row) {
                                    ?>
                                    <tr>
                                        <td class="narrowCol"><input type="checkbox" class="admin_mem_checkBox" name="row_selected[]" value="<?php echo $row['asset_id'] ?>"></td>
                                        <td><?php echo $row['asset_id'] ?></td>
                                        <td><?php echo $row['type'] ?></td>
                                        <td><?php echo $row['status'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['days_b4_alert'] ?></td>
                                        <td><?php echo $row['lab_id'] ?></td>

                                        <td><a id="edit_asset" class="fancybox" data-fancybox-type="iframe" href="forms/editAssetform.php?asset_id=<?php echo $row['asset_id'] ?>">Edit</a>
                                            <a class="fancybox" data-fancybox-type="iframe" href="functions/assetsProcessor.php?delete_asset=true&asset_id=<?php echo $row['asset_id'] ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                    <!--///////////////////////-->
                </article>
            </body>
            <script type='text/javascript' charset='utf-8'>

                function check_all(obj, cName)
                {
                    var checkboxs = document.getElementsByName(cName);
                    for (var i = 0; i < checkboxs.length; i++) {
                        checkboxs[i].checked = obj.checked;
                    }
                }

                function deleteMember() {

                }

                function callFancyBox(val)
                {
                    $('#add_asset').trigger('click');
                }

            </script>            
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