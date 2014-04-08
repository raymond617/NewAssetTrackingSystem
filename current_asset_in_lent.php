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
                        min-width: 1em;
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
                    nav{
                        display: block;
                        overflow:hidden;
                        margin: 1em;
                    }
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Current lending asset management</h2>
                    <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
                </header>
                <nav>
                    <ul>
                        <li><a href="edit_asset.php">Asset management</a></li>
                        <li><a href="current_asset_in_lent.php">Current lending asset management</a></li>
                    </ul>
                </nav>
                <?php
                $formInfoArray = $adminObject->listCurrentAssetInlend();
                $currentTime = $formInfoArray[0]['NOW()'];
                ?>
                <article>
                    <form action="functions/FormProcessor.php" method="post" class="" onSubmit="return confirm('Selected forms will be deleted. Are you sure?')">
                        <label for="Delete Form">Action: </label>
                        <input type="submit" class="actionBtn" name="Delete Form" value="Delete" id="delete_form">
                        <br>
                        <br>
                        <p>Current Time: <?php echo $currentTime;?></p>
                        <table>
                            <tr>
                                <th><input type="checkbox" class="admin_mem_checkBox" name="all" onClick="check_all(this, 'row_selected[]')"></th>
                                <th>Form ID</th>
                                <th>Asset ID</th>
                                <th>Asset Name</th>
                                <th>Lent out Time</th>
                                <th>expect end time</th>
                                <th>User IDs</th>
                                <th>User Name</th>
                                <th>Email</th>
                            </tr>
                            <?php
                            foreach ($formInfoArray as $row) {
                                ?>

                                <tr <?php 
                                if($row['NOW()']>$row['end_time']){echo 'style="background-color:#FF8C8C;"';} if($row['NOW()']>$row['alert_time']){echo 'style="background-color:#FFFDA0;"';}
                                ?>>    
                                    <td class="narrowCol"><input type="checkbox" class="admin_mem_checkBox" name="row_selected[]" value="<?php echo $row['form_id'] ?>"></td>
                                    <td><?php echo $row['form_id'] ?></td>
                                    <td><?php echo $row['asset_id'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['real_start'] ?></td>
                                    <td><?php echo $row['end_time'] ?></td>
                                    <td><?php foreach ($row['user_array'] as $value)
                        echo $value['id'] . '<br>' ?></td>
                                    <td><?php foreach ($row['user_array'] as $value)
                        echo $value['username'] . '<br>' ?></td>
                                    <td><?php foreach ($row['user_array'] as $value)
                        echo $value['email'] . '<br>' ?></td>

                                    <td>
                                        <a class="fancybox" data-fancybox-type="iframe" href="forms/editApplForm.php?form_id=<?php echo $row['form_id'] ?>">Detail</a>
                                        <?php if($row['NOW()']>$row['alert_time']){?>
                                        <a class="fancybox" data-fancybox-type="iframe" href="emailAlert.php?form_id=<?php echo $row['form_id'] ?>&asset_id=<?php echo $row['asset_id'] ?>&asset_name=<?php echo $row['name'] ?>">Send Alert Email</a>
                                        <?php } ?>
                                        <!--<a class="fancybox" data-fancybox-type="iframe" href="functions/FormProcessor.php?delete_form=true&form_id=<?php //echo $row['form_id']  ?>">Delete</a>-->
                                    </td>
                                </tr>
        <?php } ?>
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
            </script>

        </html>
        <?php
    } else {
        header('Refresh: 3;url=index.php');
        echo "You have no authorize\n redirect in 3 seconds";   
    }
} else {
    header('Refresh: 3;url=index.php');
    echo "You need login as a professor.";
}
?>		