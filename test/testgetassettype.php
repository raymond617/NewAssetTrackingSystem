<?php
require_once ('../module/assetModule.php');
$types = getAssetTypesM();
print_r($types);
?>
<html>
    <body>
    <form>
        <select>
<?php
$assets =getAssetByTypes("bench");
$msg="";
    foreach($assets as $x){
        $msg = $msg.'<option value="'.$x["asset_id"].'">'.$x["name"].'</option>';
    }
    echo $msg;
?>
            </select>
        </form>
    </body>
    </html>


