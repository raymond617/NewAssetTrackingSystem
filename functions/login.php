<?php
require_once ('../class/Objects.php');
session_start();

class API {
	
	private $pdo;
	private $userName;
	private $email;
	private $id;
	function __construct(){
		$this->pdo = connectDB(); //get the connection
	}
	
	function checkIdPassword($id,$password){
		$stmt = $this->pdo->prepare('SELECT * FROM lts_users where id = ? AND password = ?');
		$stmt->execute(array($id,$password));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->userName = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			$this->id = $userInfoArray[0]['id'];
			if($userInfoArray[0]['user_level']==3){
				return 3;	//admin level
			}else if($userInfoArray[0]['user_level']==2){
				return 2;	//user level
                        }else{
                            return 1;
                        }
		}else{
			return 0; 		//login fail
		}
	}
	function getUserName() {
		return $this->userName;
	}
	function getEmail() {
		return $this->email;
	}
	function getId(){
		return $this->id;
	}
	function getPdo(){
		return $this->pdo;
	}
}
/////////////////////////////////////////////////////////////////
try
{
	//$api = new API(returnDBInfo());
	$api = new API();
	
	if ($api->checkIdPassword($_POST["id"],$_POST["password"])==3) {
		//$_SESSION['adminLoggedIn'] = 'true';
		$admin = new AdminObject($_POST['id']);
		$_SESSION['object'] = $admin;
		/*$_SESSION['username']=$api->getUserName();
		$_SESSION['email']=$api->getEmail();
		$_SESSION['id']=$api->getId();*/
		$_SESSION['approved'] = 1;
		header("location: ../admin_page.php");
	} else if ($api->checkIdPassword($_POST["id"],$_POST["password"])== 2) {
		$teacher = new TeacherObject($_POST['id']);
		$_SESSION['object'] = $teacher;
		$_SESSION['approved'] = 1;
		header("location:".$_SERVER['HTTP_REFERER']);
	} else if ($api->checkIdPassword($_POST["id"],$_POST["password"])== 1) {			
			$user = new UserObject($_POST["id"]);
			//var_dump($user);			
			/*$_SESSION['username']=$api->getUserName();
			$_SESSION['email']=$api->getEmail();
			$_SESSION['id']=$api->getId();
			
			var_dump($_SESSION);
			echo "\n\n\n";*/
			//var_dump(serialize($user));
			$_SESSION['object'] = $user;
			$_SESSION['approved'] = 1;
			//var_dump($_SESSION['object']);
			header("location:".$_SERVER['HTTP_REFERER']);
	} else {
			$_SESSION['approved'] = 0;
			header("location:".$_SERVER['HTTP_REFERER']);
	}
	
}
catch (Exception $e)
{
	exitWithHttpError(500);
}
function exitWithHttpError($error_code, $message = '')
{
	switch ($error_code)
	{
		case 400: header("HTTP/1.0 400 Bad Request"); break;
		case 403: header("HTTP/1.0 403 Forbidden"); break;
		case 404: header("HTTP/1.0 404 Not Found"); break;
		case 500: header("HTTP/1.0 500 Server Error"); break;
	}

	header('Content-Type: text/plain');

	if ($message != '')
	header('X-Error-Description: ' . $message);

	exit;
}
?>