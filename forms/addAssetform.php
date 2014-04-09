<?php
	require_once ('../functions/system_function.php');
        require_once (rootPath() . 'class/Objects.php');
	session_start();
	if (checkLogined()==true){
		$adminObject = $_SESSION['object'];
		if($adminObject->getUserLevel() == 3){
?>
<!doctype html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
 <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
 <style>
     body{
         width:500px;
     }
     select,label{
                        display:block;
                    }
 </style>
</head>
<body>
    <h2>Add asset</h2>
<form action="../functions/assetsProcessor.php" method="post" id="add_asset">
	<label for="labID">Laboratory ID:</label>
	<input id="labID" name="labID" type="text" value="">
	<label for="name">Asset name:</label>
	<input id="name" name="name" type="text" value="" >
	<label for="assetID">Asset ID:</label>
	<input id="assetID" name="assetID" type="text" value="" >
	<label for="type">Asset type:</label>
	<input id="type" name="type" type="text" value="">
	<label for="days_b4_alert">Date before alert:</label>
	<input id="days_b4_alert" name="days_b4_alert" type="text" value="">
        <label for="sop">SOP link:</label>
	<input id="sop" name="sop" type="text" value="">
        
	<input id="action" name="add_asset" type="hidden" value="true">
	
	<input id="submit" type="submit" value="Add assets">
</form>
<div>

 </div>
</body>

</html>
<?php 
		}else{
                    header('Refresh: 3;url=index.php');	
                    echo "You have no authorize\n redirect in 3 seconds";	
		}
        }else{
            header('Refresh: 3;url=index.php');
            echo "You need login as an admin.";
        }
?>		