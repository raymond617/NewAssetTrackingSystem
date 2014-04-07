<?php
//require_once (__DIR__.'/../module/assetModule.php');
//
require_once ($_SERVER['DOCUMENT_ROOT'] .'/Asset_control_system/module/assetModule.php');
class AssetObject{
	private $id;
	private $name;
	private $type;
	private $status;
	private $labID;
	private $dayB4alert;
	private $arrayOfTimetable;
        /*private $idT;
	private $nameT;
	private $typeT;
	private $statusT;
	private $labIDT;
	private $dayB4alertT;
	private $arrayOfTimetableT;*/
	public function __construct(){
		/*$this->id=$this->idT;
                $this->name=$this->nameT;
                $this->type=$this->typeT;
                $this->status=$this->statusT;
                $this->labID=$this->labIDT;
                $this->dayB4alert=$this->dayB4alertT;*/
	}
	public static function withID($id){
		$instance = new self();
		$assetInfoArray = getAssetsByID($id);
                if($assetInfoArray != null){
                    $instance->setID($assetInfoArray[0]['asset_id']);
                    $instance->setName($assetInfoArray[0]['name']);
                    $instance->setTheType($assetInfoArray[0]['type']);
                    $instance->setStatus($assetInfoArray[0]['status']);
                    $instance->setLabID($assetInfoArray[0]['lab_id']);
                    $instance->setDayB4alert($assetInfoArray[0]['days_b4_alert']);
                    return $instance;
                }
                else return null;
	}
	public static function withRow(array $row){
		$instance = new self();
                $instance->setID($row['assetID']);
                $instance->setName($row['name']);
                $instance->setTheType($row['type']);
                $instance->setStatus($row['status']);
                $instance->setLabID($row['labID']);
                $instance->setDayB4alert($row['daysB4Alert']);
		return $instance;
	}
	public function addAssetToDB(){
		return addAssets($this->getID(),$this->getTheType(),$this->getStatus(),$this->getName(),$this->getDayB4alert(),$this->getLabID());
	}
        public function updateInfo($assetInfoArray){
            return updateAsset($assetInfoArray['assetID'],$assetInfoArray['type'],$assetInfoArray['status'],$assetInfoArray['name'],$assetInfoArray['daysB4Alert'],$assetInfoArray['labID']);
        }
        public function getID(){
            return $this->id;
        }
        public function setID($aID){
            $this->id=$aID;
        }
        public function getName(){
            return $this->name;
        }
        public function setName($aName){
            $this->name=$aName;
        }
        public function getTheType(){
            return $this->type;
        }
        public function setTheType($aType){
            $this->type=$aType;
        }
        public function getLabID(){
            return $this->labID;
        }
        public function setLabID($aLabid){
            $this->labID=$aLabid;
        }
        public function getStatus(){
            return $this->status;
        }
        public function setStatus($aStatus){
            $this->status = $aStatus;
        }
        public function getDayB4alert(){
            return $this->dayB4alert;
        }
        public function setDayB4alert($db4){
            $this->dayB4alert = $db4;
        }
}