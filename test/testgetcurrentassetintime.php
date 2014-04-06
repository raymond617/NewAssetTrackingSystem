<?php
require_once ('../module/assetModule.php');
require_once ('../module/UserModule.php');

$a = getCurrentAssetInTime();

print_r($a);