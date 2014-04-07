<?php
require_once '../class/Objects.php';
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');
session_start();
if (checkLogined() == true) {
    $adminObject = $_SESSION['object'];
    if ($adminObject->getUserLevel() == 3) {
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>
                <script type="text/javascript" src="../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
                <link rel="stylesheet" type="text/css" href="../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
                
                <style  type="text/css">
                    input,label{
                        display:block;
                    }
                    table {
                        font-family: Helvetica, Arial, sans-serif;
                        text-align: center;
                        margin: 2em 0 0 2em;
                        padding: 1em;
                        border-collapse: collapse;
                        //width: 100%;
                    }
                    td {
                        min-width: 10em;
                        height: 3em;
                    }
                    tr {
                        border-bottom: 0.1em solid #DDD;
                    }
                    th {
                        border-bottom: 0.3em solid #1A7480;
                    }
                    
                </style>
            </head>
            <body>
                <header class="row">
                    <h1 id="site_logo"><a href="../index.php">Laboratory asset tracking system</a></h1>
                    <h2 id="page_name">Reserved form of Student ID: <?php echo $_GET['student_id']?></h2>
                    <?php include rootPath(). "/common_content/login_panel.php"; // div of login panel?>
                </header>
                <?php
                $formList = $adminObject->listFormByStudentID($_GET['student_id']);
                ?>
                <article>
                    
                        <table>
                            <tr>
                                
                                <th>Form ID</th>
                                <th>Project title</th>
                                
                            </tr>
                            <?php
                            foreach ($formList as $id) {
                                if(checkFormExpire($id['form_id'])==false && checkFormApproval($id['form_id'])==true){
                                $row=$adminObject->getFormInfo($id['form_id']);
                                ?>
                            
                                <tr>                                        
                                    <td><?php echo $row['form_id'] ?></td>
                                    <td><?php echo $row['project_title'] ?></td>
                                    <td><a href="lendingPage.php?form_id=<?php echo $row['form_id']?>">Lending Page</a></td>
                                    <!--<td><?php //foreach($row['user_array'] as $value) echo $value['id'].'<br>' ?></td>
                                    <td><?php //echo "ID:".$row['bench'][0]['asset_id']."  Name:".$row['bench'][0]['name'] ?></td>
                                    <td><?php //echo $row['bench'][0]['start_time'] ?></td>
                                    <td><?php //echo $row['bench'][0]['end_time'] ?></td>
                                    <td>
                                        <a class="fancybox" data-fancybox-type="iframe" href="forms/editApplForm.php?form_id=<?php //echo $row['form_id'] ?>">Detail &AMP; Edit</a>
                                        <a class="fancybox" data-fancybox-type="iframe" href="functions/FormProcessor.php?delete_form=true&form_id=<?php //echo $row['form_id'] ?>">Delete</a>
                                    </td>-->
                                </tr>
                                <?php }} ?>
                        </table>
                    <!--///////////////////////-->
                </article>
            </body>
            <script type='text/javascript' charset='utf-8'>
                
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