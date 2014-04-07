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
    <h2>Add User</h2>
<form action="../functions/userProcessor.php" method="post" id="add_user">
	<label for="userID">User ID:</label>
	<input id="userID" name="user_id" type="text" value="">
	<label for="name">User name:</label>
	<input id="name" name="name" type="text" value="" >
	<label for="email">Email:</label>
	<input id="email" name="email" type="text" value="" >
	<label for="contact_no">Contact no:</label>
	<input id="contact_no" name="contact_no" type="text" value="">
	<label for="user_level">User level:</label>
        <input id="user_level" name="user_level" type="text" value="" placeholder="1 or 2 or 3">
        <label for="user_type">User Type:</label>
        <input id="user_type" name="user_type" type="text" value="" placeholder="Student or Teacher or Admin">
	<input id="action" name="add_user" type="hidden" value="true">
	<input id="submit" type="submit" value="Add user">
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