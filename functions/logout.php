<?php
require_once 'system_function.php';
session_start();
session_destroy();
header("location:".$_SERVER['HTTP_REFERER']);

?>