<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() >=1) {
        $currentFormID = $_GET['form_id'];
        $formInfo = $_SESSION['object']->getFormInfo($currentFormID);
        ?>
        <!doctype html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link rel="stylesheet" type="text/css" href="../css/form_style.css"/>
                <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
                <style  type="text/css">
                    select{
                        display:block;
                    }
                    #p_scents input,#asset_list input{
                        display: block;
                    }
                    #p_scents a,#asset_list a{                    
                        display:inline;
                    }
                </style>
            </head>
            <body>
                <?php if($formInfo['status'] ==7){?>
                <h2>Detail of equipiment form</h2>
                <?php }else{ ?>
                <h2>Edit equipiment form</h2>
                <?php } ?>
                <form action="../functions/FormProcessor.php" method="post" id="prof_form_approve">
                    <label for="formID">Form ID:</label>
                    <input id="formID" name="formID" type="text" value="<?php echo $formInfo['form_id'] ?>" readonly>
                    <label for="studID">Student IDs:</label>
                    <?php foreach ($formInfo['user_array'] as $value){ ?>
                        <input id="studID" name="studID[]" type="text" value="<?php echo $value['id'] ?>" readonly>
                    <?php } ?>
                    
                    <label for="appl_time">Apply Time:</label>
                    <input id="appl_time" name="appl_time" type="text" value="<?php echo $formInfo['apply_timestamp']; ?>" readonly>
                   
                    <div class="control-group">
                        <label class="control-label">Start time:</label>
                        <div class="controls input-append date form_datetime" data-date="" data-link-field="dtp_input1">
                            <input size="16" type="text" value="<?php echo $formInfo['asset_array'][0]['start_time'] ?>" name="start_time" id="start_time" readonly onchange="checkTime()">
                            <span class="add-on"><i class="icon-remove"></i></span>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                        <input type="hidden" id="dtp_input1" value="" /><br/>
                    </div>
                    <div class="control-group">
                        <label class="control-label">End time:</label>
                        <div class="controls input-append date form_datetime" data-date="" data-link-field="dtp_input1">
                            <input size="16" type="text" value="<?php echo $formInfo['asset_array'][0]['end_time'] ?>" name="end_time"  id="end_time" readonly onchange="checkTime()">
                            <span class="add-on"><i class="icon-remove"></i></span>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                        <input type="hidden" id="dtp_input2" value="" /><br/>
                    </div>
                    <div id="asset_list">
                        <?php $types = $_SESSION['object']->getAssetTypes(); ?>
                        <p><label for="assets">Assets Type &amp; Name:</label> <a href="#" id="addAsset">Add another asset</a>
                            <?php
                            $i = 1;
                            foreach ($formInfo['asset_array'] as $value) {
                                ?>
                                <label for='assetType<?php echo $i; ?>'><?php echo $i; ?></label>
                                <select name="type[]" id="assetType<?php echo $i; ?>" onchange="getAssetByType(this, '#asset<?php echo $i; ?>');">
                                    <?php
                                    foreach ($types as $x) {
                                        if (strcmp($x['type'], $value['type']) == 0) {
                                            ?>
                                            <option value="<?php echo $x['type']; ?>" selected><?php echo $x['type']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $x['type']; ?>"><?php echo $x['type']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php $assets = $_SESSION['object']->getAssetByType($value['type']); ?>
                                <select name="asset[]" id="asset<?php echo $i; ?>">
                                    <?php
                                    foreach ($assets as $y) {
                                        if (strcmp($y['name'], $value['name']) == 0) {
                                            ?>
                                            <option value="<?php echo $y['asset_id'] ?>" selected><?php echo $y['name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $y['asset_id'] ?>"><?php echo $y['name'] ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select></p>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <label for="status">Status:</label>
                    <?php $status = $formInfo['status']; 
                    if($Object->getUserLevel() !=3){?>
                    <input type="text" value="<?php echo statusTranslation($status)?>" readonly>
                    <input type="hidden" name="status"value="<?php echo $status?>">
                    <?php }else if($Object->getUserLevel() ==3){?>
                    <select name="status" form="prof_form_approve" id="status">
                        <option value="6">Wait for Approved</option>
                        <option value="7">Approved</option>
                        <option value="9">Rejected</option>
                    </select> 
                    <?php }?>

                    <input id="action" name="equipiment_approve" type="hidden" value="true">
                    <?php if($status == 6){?>
                    <input id="submit" type="submit" value="Submit Form">
                    <?php }else{ ?>
                    <input id="submit" type="submit" value="Submit Form" disabled="disabled">
                    <?php } ?>
                    <?php print_r($formInfo['asset_array']); ?>
                </form>
            </body>
            <script type="text/javascript" src="../javascript/jquery-1.8.3.min.js" charset="UTF-8"></script>
        <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
        <script type="text/javascript" src="../javascript/bootstrap-datetimepicker.js" charset="UTF-8"></script>
            <script type="text/javascript">
                                    var text1 = "<?php echo $status; ?>";
                                    $("select option").filter(function() {
                                        //may want to use $.trim in here
                                        return $(this).attr("value") == text1;
                                    }).prop('selected', true);

                                    $(window).load(function() {
                                        $(function() {
                                            var scntDiv = $('#asset_list');
                                            var i = $('#asset_list p').size() + 1;

                                            $('#addAsset').live('click', function() {
                                                $('<p><label for="asset"><a href="#" id="remAsset">Remove</a><select name="type[]" onchange="getAssetByType(this,\'#asset' + i + '\');"><option selected="selected">select a type</option><?php
        foreach ($types as $value) {
            echo '<option value="' . $value['type'] . '">' . $value['type'] . '</option>';
        }
        ?></select><select name="asset[]" id="asset' + i + '" ></select></label></p>').appendTo(scntDiv);
                                                i++;
                                                return false;
                                            });

                                            $('#remAsset').live('click', function() {
                                                if (i > 2) {
                                                    $(this).parents('p').remove();
                                                    i--;
                                                }
                                                return false;
                                            });
                                        });
                                    });



                                    function getAssetByType(self, targetID) {
                                        var type = 'type=' + $(self).val();
                                        //alert(type);
                                        $.ajax({type: "GET",
                                            url: "../ajax/getAssetByType.php",
                                            data: type,
                                            success: function(msg) {
                                                //alert(msg);
                                                $(targetID).html(msg);
                                            },
                                            error: function() {
                                                alert("An error ocurred.");
                                            }
                                        });
                                    }
                                    function placeTheType(typeSelectID, type) {
                                        $("select#" + typeSelectID + " option").each(function() {
                                            this.selected = (this.text === type);
                                        });
                                        //$("#"+typeSelectID+" option[text=" +type+"]").attr("selected","selected") ;
                                        //$("#"+assetSelectID+" option[text=" +asset+"]").attr("selected","selected") ;
                                    }
                                    $('.form_datetime').datetimepicker({
                                        //language:  'fr',
                                        weekStart: 1,
                                        //todayBtn: 1,
                                        autoclose: 1,
                                        todayHighlight: 1,
                                        startView: 2,
                                        forceParse: 0,
                                        showMeridian: 1,
                                        minuteStep: 30,
                                        format: 'yyyy-mm-dd hh:ii:00',
                                        startDate: new Date()
                                    });

                                    function checkTime() {
                                        var startTime = document.getElementById('start_time');
                                        var endTime = document.getElementById('end_time');
                                        var startT = new Date(startTime.value.split(' ').join('T')).getTime() / 1000;
                                        var endT = new Date(endTime.value.split(' ').join('T')).getTime() / 1000;
                                        if (endT <= startT)
                                            $("#end_time").css({'background-color': 'red'});
                                    }
                                    $("#end_time").change(function() {
                                        $.ajax({type: "GET",
                                            url: "../ajax/checkTimeOverlapping.php",
                                            data: "end_time=" + $(this).val() + "&start_time=" + $("#start_time").val() + "&bench_id=" + $("#bench").val(),
                                            success: function(result) {
                                                //alert(result);
                                                //if (result === "success")
                                                    //alert("OK");
                                                //else
                                                if (result !== "success")
                                                    alert("Bench time overlap");
                                            }});
                                    });
                                    $("#start_time").change(function() {
                                        $.ajax({type: "GET",
                                            url: "../ajax/checkTimeOverlapping.php",
                                            data: "end_time=" + $("#end_time").val() + "&start_time=" + $(this).val() + "&bench_id=" + $("#bench").val(),
                                            success: function(result) {
                                                //alert(result);
                                                if (result !== "success")
                                                    alert("Bench time overlap");
                                            }});
                                    });
                                    function clearTime(){
                                        $('#start_time').val('');
                                        $('#end_time').val('');
                                    }
                                    
            </script>
        </html>
        <?php
    } else {
        echo "You have no authorize\n redirect in 3 seconds";
        header('Refresh: 3;url=index.php');
    }
} else {
    echo "You need login as an admin.";
    header('Refresh: 3;url=index.php');
}
?>