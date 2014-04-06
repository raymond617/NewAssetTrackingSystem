<div id="loginOut">
<?php if(checkLogined()==false){?>
    <form action="../functions/login.php" method="post">
		<label for="id">OUID:</label>
		<input id="id" name="id" type="text" placeholder="OUID">
		<label for="id">Password:</label>
		<input id="password" name="password" type="password" placeholder="PASSWORD">
		<input id="loginSubmit" type="submit" value="Login">
	</form>
<?php }else if (checkLogined()==true){?>
	<form action="../functions/logout.php" method="get">
		<span>Welcome, <?php echo $_SESSION['object']->getUserName();?></span>
		<p><input id="logout" type="submit" value="Logout">
		<a href="../user_info.php">change Information</a></p>
	</form>		
<?php }?>
</div>