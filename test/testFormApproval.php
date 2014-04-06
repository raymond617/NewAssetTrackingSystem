<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../module/FormModule.php');

if(checkFormApproval(12)){
    echo "YES";
}  else {
    echo"NO";
}
