<?php
$arrayForPDO = array(
	 'db' => array(
		    'host'     => '127.0.0.1',
			'dbname'   => 'lts',
			'username' => 'root',
			'password' => '',
			)
      );

function connectDB(){
	global $arrayForPDO;
	$dbHost = $arrayForPDO['db']['host'];
	$dbUserName = $arrayForPDO['db']['username'];
	$dbPassword = $arrayForPDO['db']['password'];
	$dbName= $arrayForPDO['db']['dbname'];
	try {
	$connection = new PDO("mysql:host=$dbHost;dbname=$dbName;", $dbUserName, $dbPassword);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->query('SET NAMES utf8');
	}catch (PDOException $e) {
		echo $e->getMessage();
	}
	return $connection;
}

function returnDBInfo() {
	global $arrayForPDO;
    return $arrayForPDO;
}