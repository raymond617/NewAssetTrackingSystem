<?php
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(checkFormExpire(69))
    echo "YES";
else
    echo "NO";

echo checkFormExpire(69);


$timestamp = date('Y-m-d G:i:s');
echo "<br>".$timestamp."<br>";

