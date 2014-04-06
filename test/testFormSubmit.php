<?php
require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');

$test = formSubmit(array(11000000,12000000), array("16","20","24"), "test cookies 4", 20000000, "s333f", 11,  'l',"2014-02-25 18:00:00","2014-02-26 01:00:00");
if($test==true){
    echo "success";
}else{
    echo "false";
}

?>
