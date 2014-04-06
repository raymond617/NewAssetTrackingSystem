<?php
require_once 'class/Objects.php';
require_once ('functions/system_function.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() == 2 ||$Object->getUserLevel() == 3) {
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
                    <?php if($Object->getUserLevel() == 3){ ?>
                    <h2 id="page_name">Form Approval form technicians</h2>
                    <?php }else{ ?>
                    <h2 id="page_name">Form Approval form professors</h2>
                    <?php } ?>
                    <?php include dirname(__FILE__) . "/common_content/login_panel.php"; // div of login panel?>
                </header>
                <?php
                if($Object->getUserLevel() == 2){
                    $formInfoArray = $Object->listFormsWithStatus(1);
                }else if($Object->getUserLevel() == 3){
                    $formInfoArray = $Object->listFormsWithStatus(2);
                }
                ?>
                <article>
                        <table>
                            <tr>
                                <th>Apply Time</th>
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
                                    <td><?php echo $row['apply_timestamp'] ?></td>
                                    <td><?php echo $row['project_title'] ?></td>
                                    <td><?php foreach($row['user_array'] as $value) echo $value['id'].'<br>' ?></td>
                                    <td><?php echo "ID:".$row['bench'][0]['asset_id']."  Name:".$row['bench'][0]['name'] ?></td>
                                    <td><?php echo $row['bench'][0]['start_time'] ?></td>
                                    <td><?php echo $row['bench'][0]['end_time'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td>
                                        <a class="fancybox" data-fancybox-type="iframe" href="forms/formEditAndApprove.php?form_id=<?php echo $row['form_id'] ?>">Detail &AMP; Edit</a>
                                        
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

                function deleteMember() {

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
    echo "You need login as an admin.";
    header('Refresh: 3;url=index.php');
}
?>		