<?php
require_once '../functions/system_function.php';
require_once rootPath().'module/LabModule.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Laboratory
 *
 * @author Raymond Yuen
 */
class LaboratoryObject {
    private $labID;
    private $maxPpl;
    function __construct() {
        
    }
    public static function withID($id){
		$instance = new self();
		$labInfoArray = getLabByID($id);
                if($labInfoArray != null){
                    $instance->setLabID($labInfoArray[0]['lab_id']);
                    $instance->setMaxPpl($labInfoArray[0]['max_ppl']);
                    return $instance;
                }else return null; 
     }                
     public static function withRow(array $row){
		$instance = new self();
                $instance->setLabID($row['lab_id']);
                $instance->setMaxPpl($row['max_ppl']);                
		return $instance;
    }
    public function addLabToDB($lab_id,$max_ppl){
        return addLab($lab_id, $max_ppl);
    }
    public function getLabID() {
        return $this->labID;
    }

    public function getMaxPpl() {
        return $this->maxPpl;
    }

    public function setLabID($labID) {
        $this->labID = $labID;
    }

    public function setMaxPpl($maxPpl) {
        $this->maxPpl = $maxPpl;
    }

        //put your code here
    
    
}
