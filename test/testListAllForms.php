<?php
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');

$complexForm = listAllForms();

//print_r ($complexForm);

$userarray = listAllUsersFromForm(2);
//print_r ($userarray);
$oneForm =showOneForm(2);
print_r ($oneForm);
$bench = findTheBenchFromForm(7);
//print_r($bench);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

