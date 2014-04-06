<?php
require_once ('functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/FormModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() ==3) {
        $currentFormID = $_GET['form_id'];
        $asset_id = $_GET['asset_id'];
        $asset_name = $_GET['asset_name'];
        //$formInfo = $_SESSION['object']->getFormInfo($currentFormID);
        $usersArray = listAllUsersIDAndEmailFromForm($currentFormID);
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link rel="stylesheet" type="text/css" href="css/form_style.css"/>
                <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
                <style  type="text/css">
                    select{
                        display:block;
                    }
                    #p_scents input,#asset_list input{
                        display: block;
                    }
                    #p_scents a,#asset_list a{                    
                        display:inline;
                    }
                    textarea{
                        width:auto;
                    }
                    textarea{
                        text-indent:0;
                    }
                </style>
            </head>
            <body>
                <h2>Email Alert</h2>
                
                <form action="functions/emailProcessor.php" method="post" id="email_alert">
                    <label for="formID">Form ID:</label>
                    <input id="formID" name="formID" type="text" value="<?php echo $currentFormID ?>" readonly>
                    <label for="studID">Student IDs:</label>
                    <?php foreach ($usersArray as $value){ ?>
                        <input id="studID" type="text" value="<?php echo $value['id'] ?>" readonly>
                        <input id="email" name="email[]" type="text" value="<?php echo $value['email']?>" readonly>
                    <?php } ?>
                    <label for="email_content">Email Content</label>
                    <textarea rows="10" cols="70" id="email_content" name="email_content"><?php echo "Please return the asset \nName: ".$asset_name."\nID: ".$asset_id; ?>
                    </textarea>
                    
                    <input id="action" name="email_alert" type="hidden" value="true">
                    <input id="submit" type="submit" value="Send">
                    
                </form>
            </body>
            <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
        
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