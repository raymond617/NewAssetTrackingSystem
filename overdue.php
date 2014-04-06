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
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Overdue asset management</h2>
                    <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
                </header>
                <?php
                $formInfoArray = $adminObject->listForms();
                ?>
                <article>
                    <form action="functions/FormProcessor.php" method="post" class="" onSubmit="return confirm('Selected forms will be deleted. Are you sure?')">
                        <label for="Delete Form">Action: </label>
                        <input type="submit" class="actionBtn" name="Delete Form" value="Delete" id="delete_form">
                        <a id="add_form" class="fancybox" data-fancybox-type="iframe" href="forms/experiment_reservation_form.php" style="display:hidden;"></a>
                        <input type="button" class="actionBtn" value="Add Form" id="add_form" onClick="callFancyBox(this.value);">
                        <br>
                        <br>
                        <table>
                            <tr>
                                <th><input type="checkbox" class="admin_mem_checkBox" name="all" onClick="check_all(this, 'row_selected[]')"></th>
                                <th>Apply Time</th>
                                <th>Form ID</th>
                                <th>Project title</th>
                                <th>Student IDs</th>
                                <th>Bench</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            foreach ($formInfoArray as $row) {
                                ?>
                            
                                <tr>    
                                    <td class="narrowCol"><input type="checkbox" class="admin_mem_checkBox" name="row_selected[]" value="<?php echo $row['form_id'] ?>"></td>
                                    <td><?php echo $row['apply_timestamp'] ?></td>
                                    <td><?php echo $row['form_id'] ?></td>
                                    <td><?php echo $row['project_title'] ?></td>
                                    <td><?php foreach($row['user_array'] as $value) echo $value['id'].'<br>' ?></td>
                                    <td><?php echo "ID:".$row['bench'][0]['asset_id']."  Name:".$row['bench'][0]['name'] ?></td>
                                    <td><?php echo $row['bench'][0]['start_time'] ?></td>
                                    <td><?php echo $row['bench'][0]['end_time'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td>
                                        <a class="fancybox" data-fancybox-type="iframe" href="forms/editApplForm.php?form_id=<?php echo $row['form_id'] ?>"><?php if($row['status']>=3) echo "Detail"; else echo "Detail or Edit"?></a>
                                        <a class="fancybox" data-fancybox-type="iframe" href="functions/FormProcessor.php?delete_form=true&form_id=<?php echo $row['form_id'] ?>">Delete</a>
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

                function callFancyBox(val)
                {
                    $('#add_form').trigger('click');
                }
            </script>

        </html>
        <?php
    } else {
        echo "You have no authorize\n redirect in 3 seconds";
        header('Refresh: 3;url=index.php');
    }
} else {
    echo "You need login as a professor.";
    header('Refresh: 3;url=index.php');
}
?>		