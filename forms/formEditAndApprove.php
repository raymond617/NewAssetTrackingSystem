<?php
require_once ('../functions/system_function.php');
require_once (rootPath() . 'class/Objects.php');
require_once (rootPath() . 'module/assetModule.php');
session_start();
if (checkLogined() == true) {
    $Object = $_SESSION['object'];
    if ($Object->getUserLevel() == 2 || $Object->getUserLevel() == 3) {
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
                <form action="../functions/FormProcessor.php" method="post" id="prof_form_approve">
                    <label for="formID">Form ID:</label>
                    <input id="formID" name="formID" type="text" value="<?php echo $formInfo['form_id'] ?>" readonly>
                    <label for="studID">Student IDs:</label>
                    <?php foreach ($formInfo['user_array'] as $value){ ?>
                        <input id="studID" name="studID[]" type="text" value="<?php echo $value['id'] ?>" readonly>
                    <?php } ?>
                    <label for="project_title">Project title:</label>
                    <input id="project_title" name="project_title" type="text" value="<?php echo $formInfo['project_title']; ?>">
                    <label for="appl_time">Apply Time:</label>
                    <input id="appl_time" name="appl_time" type="text" value="<?php echo $formInfo['apply_timestamp']; ?>" readonly>
                    <label for="course_code">Course code:</label>
                    <input id="course_code" name="course_code" type="text" value="<?php echo $formInfo['course_code'] ?>">
                    <label for="professor">Professor:</label>
                    <input id="professor_id" name="professor_id" type="hidden" value="<?php echo $formInfo['prof_id']; ?>" >
                    <input id="professor" name="professor" type="text" value="<?php echo $_SESSION['object']->getProfessorName($formInfo['prof_id'])[0][0]; ?>" disabled="disabled">
                    <label for="bench">Bench:</label>
                    <input id="bench" type="text" value="<?php echo $formInfo['bench'][0]['name']; ?>" readonly>
                    <input id="bench" name="bench" type="hidden" value="<?php echo $formInfo['bench'][0]['asset_id']; ?>">
                    <!--<select name="bench" id="bench" onchange="clearTime();">
                    <?php/*
                    $benches = getBenchList();
                    foreach ($benches as $b) {
                        if(strcmp((string)$b['asset_id'],(string)$formInfo['bench'][0]['asset_id'])==0){
                        //if(strcmp($b['asset_id'],$formInfo['bench'][0]['asset_id'])==0){
                            echo "<option value='" . $b['asset_id'] . "' selected='selected'>" . $b['name'] . "</option>";
                        }else{
                            echo "<option value='" . $b['asset_id'] . "'>" . $b['name'] . "</option>";
                        }
                    }*/
                    ?>
                </select>-->
                    <div class="control-group">
                        <label class="control-label">Start time:</label>
                        <div class="controls input-append date form_datetime" data-date="" data-link-field="dtp_input1">
                            <input size="16" type="text" value="<?php echo $formInfo['bench'][0]['start_time'] ?>" name="start_time" id="start_time" readonly onchange="checkTime()">
                            <span class="add-on"><i class="icon-remove"></i></span>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                        <input type="hidden" id="dtp_input1" value="" /><br/>
                    </div>
                    <div class="control-group">
                        <label class="control-label">End time:</label>
                        <div class="controls input-append date form_datetime" data-date="" data-link-field="dtp_input1">
                            <input size="16" type="text" value="<?php echo $formInfo['bench'][0]['end_time'] ?>" name="end_time"  id="end_time" readonly onchange="checkTime()">
                            <span class="add-on"><i class="icon-remove"></i></span>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                        <input type="hidden" id="dtp_input2" value="" /><br/>
                    </div>
                    <div id="asset_list">
                        <?php $types = $_SESSION['object']->getAssetTypes(); ?>
                        <label for="assets">Assets Type &amp; Name:</label> <a href="#" id="addAsset">Add another asset</a>
                            <?php
                            $i = 1;
                            foreach ($formInfo['asset_array'] as $value) {
                                ?>
                                <p><label for='assetType<?php echo $i; ?>'><?php echo $i; ?></label><a href="#" id="remAsset">Remove</a>
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
                        <?php $status = $formInfo['status']; ?>
                    <select name="status" form="prof_form_approve" id="status">

                        <?php if ($Object->getUserLevel() == 2) { ?>
                            <option value="2">Approved</option>
                            <option value="1">Wait for professor's approval</option>
                        <?php } else if ($Object->getUserLevel() == 3) { ?>
                            <option value="3">Approved</option>
                            <option value="2">Wait for technician's approval</option>
        <?php } ?>
                        <option value="9">Rejected</option>
                    </select> 

                    <input id="action" name="form_approve" type="hidden" value="true">

                    <input id="submit" type="submit" value="Submit Form">
                </form>
                <?php print_r($formInfo['asset_array']); ?>
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
                                            var scntDiv = $('#p_scents');
                                            var i = $('#p_scents p').size() + 1;

                                            $('#addScnt').live('click', function() {
                                                $('<p><label for="student_name"><a href="#" id="remScnt">Remove</a><input id="student_name" name="student_name[]" type="text" value="" placeholder="Name"/><input id="studID" name="studID[]" type="text" value="" placeholder="Student id"></label></p>').appendTo(scntDiv);
                                                i++;
                                                return false;
                                            });

                                            $('#remScnt').live('click', function() {
                                                if (i > 2) {
                                                    $(this).parents('p').remove();
                                                    i--;
                                                }
                                                return false;
                                            });
                                        });
                                    });
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
                                                if (result === "success")
                                                    alert("OK");
                                                else
                                                    alert("overlapping");
                                            }});
                                    });
                                    $("#start_time").change(function() {
                                        $.ajax({type: "GET",
                                            url: "../ajax/checkTimeOverlapping.php",
                                            data: "end_time=" + $("#end_time").val() + "&start_time=" + $(this).val() + "&bench_id=" + $("#bench").val(),
                                            success: function(result) {
                                                //alert(result);
                                                if (result !== "success")
                                                    alert("overlapping");
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
