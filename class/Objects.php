<?php
//require(__DIR__.'/../functions/connectDB.php');
/*require_once ('/../functions/connectDB.php');
require_once ('/../module/assetModule.php');
require_once ('/../module/FormModule.php');
require_once ('/../module/UserModule.php');*/
//require_once ('../functions/connectDB.php');
require_once ($_SERVER['DOCUMENT_ROOT'] .'/Asset_control_system/module/assetModule.php');
require_once ($_SERVER['DOCUMENT_ROOT'] .'/Asset_control_system/module/FormModule.php');
require_once ($_SERVER['DOCUMENT_ROOT'] .'/Asset_control_system/module/UserModule.php');
require_once ('AssetObject.php');
//require_once('../functions/system_function.php');
/*require_once (ROOT.'/functions/connectDB.php');
require_once (ROOT.'/module/assetModule.php');
require_once (ROOT.'/module/FormModule.php');
require_once (ROOT.'/module/UserModule.php');*/
//require_once ('AssetObject.php');
abstract class UserInfo{
	//private $pdo;
	private $email;
	private $contact_no;
	private $username;
	private $password;
	private $id;
	private $user_type;
	private $user_level;

	public function __construct($id){
		//$this->pdo = connectDB(); //get the connection
		$this->id = $id;
		$this->getUserInfo(connectDB());
	}
	public function getUserInfo($pdo){
		$stmt = $pdo->prepare('SELECT * FROM lts_users where id = ?');
		$stmt->execute(array($this->id));
		$userInfoArray = $stmt->fetchAll();
		if(count($userInfoArray)>0){
			$this->username = $userInfoArray[0]['username'];
			$this->email = $userInfoArray[0]['email'];
			$this->contact_no = $userInfoArray[0]['contact_no'];
			$this->password = $userInfoArray[0]['password'];
			$this->user_type = $userInfoArray[0]['user_type'];
			$this->user_level = $userInfoArray[0]['user_level'];
		}
	}
	public function getID(){
		return $this->id;
	}
	public function getUserName(){
		return $this->username;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getContact_no(){
		return $this->contact_no;
	}
	public function getPassword(){
		return $this->password;
	}
	public function changePassword($oldPassword,$newPassword,$confirmPassword){
		if(strcmp($oldPassword,$this->password)==0 && strcmp($newPassword,$confirmPassword)==0){
			$pdo = connectDB();
			$stmt = $pdo->prepare('update lts_users set password = ? where id =?');
			$stmt->execute(array($newPassword,$this->id));
			$this->getUserInfo(connectDB()); // for renew the session
			return true;
		}else{
			return false;
		}
	}
	public function updateInformation($name,$email,$contact){
		$pdo = connectDB();
		$stmt = $pdo->prepare('update lts_users set username = ?,email=?,contact_no=? where id =?');
		if($stmt->execute(array($name,$email,$contact,$this->id))==true){
			$this->getUserInfo(connectDB()); // for renew the session
			return true;
		}else
			return false;
	}
	public function getUserType(){
		return $this->user_type;
	}
	public function getUserLevel(){
	return $this->user_level;
	}
        public function getAssetTypes(){
            return getAssetTypesM();
        }
        public function getAssetByType($type){
            return getAssetByTypes($type);
        }
        public function listMyForm(){
            return listAllFormsDetailByUserID($this->id);
        }
        public function getFormInfo($form_id){
            return showOneForm($form_id);
        }
        public function getProfessorName($prof_id){
            return getProfessorNameM($prof_id);
        }
}
/////////////////////////////
/*
 try{
$userInfo = new UserInfo();
echo "print something \n";
echo $_SESSION['id'];

}catch(Exception $a){
echo "failed";

}
*/
class AdminObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}
	public function addAsset($assetGetArray){
            try{
                $assetOject=AssetObject::withRow($assetGetArray);
                if($assetOject->addAssetToDB()){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo "Create object failed.\n";
            }
        }
        public function deleteAsset($asset_id){
            try{
                return deleteAsset($asset_id);
            }catch(Exception $e){
                echo "delete object failed.\n";
            }
        }
        public function listAsset(){
            $pdo = connectDB();
            $stmt = $pdo->prepare('select * from assets');
            $stmt->execute();
            $assetInfoArray = $stmt->fetchAll();
            return $assetInfoArray;
        }
        public function getAssetInfo($id){
            $assetObject=AssetObject::withID($id);
            return $assetObject;
        }
        public function updateAsset(array $assetInfoArray){
            try{
                $assetObject=AssetObject::withID($assetInfoArray['assetID']);
                if($assetObject->updateInfo($assetInfoArray)){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo "Create object failed.\n";
            }
        }
        public function listForms(){
            return listAllForms();
        }
        public function listEquipimentForms(){
            return listAllEquipimentForms();
        }
        public function deleteForm($form_id){
            try{
                return deleteFormM($form_id);
            }catch(Exception $e){
                echo "delete form failed.\n";
            }
        }
        public function listFormsWithStatus($status){
            return listAllFormsWithStatus($status);
        }
        public function listFormByStudentID($student_id){
            return listFormByStudentID($student_id);
        }
        public function listCurrentAssetInlend(){
            return getCurrentAssetInTime();
        }
        public function listUsers(){
            return listAllUserM();
        }
}
class TeacherObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}
        public function listFormsWithStatus($status){
            return listAllFormsWithStatus($status);
        }
        public function getFormInfo($form_id){
            return showOneFormDetail($form_id);
        }
        public function getProfessorName($prof_id){
            return getProfessorNameM($prof_id);
        }
}
class UserObject extends UserInfo{
	public function __construct($id){
		parent::__construct($id);
	}
	
}
?>