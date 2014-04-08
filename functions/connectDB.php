<?php
/*$arrayForPDO = array(
	 'db' => array(
		    'host'     => '127.0.0.1',
			'dbname'   => 'lts',
			'username' => 'root',
			'password' => '',
			)
      );*/
$arrayForPDO = array(
	 'db' => array(
		    'host'     => '69.85.84.105',
			'dbname'   => 'ericb_ouhk',
			'username' => 'ericb_raymond',
			'password' => '1q2w3e',
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