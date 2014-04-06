<?php
require_once '../functions/system_function.php';
require_once rootPath().'functions/connectDB';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$pdo = connectDB();
function getLabByID($id){
    global $pdo;
	$stmt = $pdo->prepare('SELECT * FROM Laboratory where lab_id = ?');
	$stmt->execute(array($id));
	$labInfoArray = $stmt->fetchAll();
        if(count($labInfoArray)>0)
            return $labInfoArray;
        else
            return null;
}
function addLab($lab_id,$max_ppl){
        global $pdo;
	$stmt = $pdo->prepare('insert into laboratory (lab_id,max_ppl) values (?,?)');
        try{
            if($stmt->execute(array($lab_id,$max_ppl))==true){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            //echo $e;
            return FALSE;
        }
}
