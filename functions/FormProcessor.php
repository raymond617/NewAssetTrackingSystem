<?php

require_once ('../functions/system_function.php');
require_once ('../module/FormModule.php');
require_once ('rule.php');
require_once('../functions/checkAssetOverlap.php');
session_start();

/////////////////////////////////////////////////////
try {
    if (isset($_POST['experiment_reservation'])) {
        $checkAssetCount = 0;

        $project_title = $_POST['project_title'];
        $professor_id = $_POST['professor_id'];
        $course_code = $_POST['course_code'];
        $bench = $_POST['bench'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $student_id_list = $_POST['studID'];
        //////////////////////////////////////////////////////////for just book the bench
        if (!isset($_POST['asset'])) {
            if (checkAssetOverlap($bench, 3, $start_time, $end_time) || checkAssetOverlap($bench, 7, $start_time, $end_time) || checkAssetOverlap($bench, 4, $start_time, $end_time)) {
                $temp = getAssetsByID($bench);
                $returnMsg = $returnMsg . "Asset ID: " . $bench . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                $checkAssetCount++;
            }
            if ($checkAssetCount > 0) {
                header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
                echo $returnMsg;
            } else {
                try {
                    if (formSubmitNoAsset($student_id_list, $project_title, $professor_id, $course_code, $bench, "1", $start_time, $end_time) == true) {
                        header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                        //unset($_SESSION['experiment_reservation_form']);
                        echo 'Form submit success!';
                    } else {
                        header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                        echo 'Form submit fail!<br> error occur.';
                    }
                } catch (Exception $e) {
                    echo "Create object failed.\n";
                }
            }
        } else {
            ////////////////////////////////////////////////////////////////////////END
            $asset_list = $_POST['asset'];

            $_SESSION['experiment_reservation_form']['project_title'] = $project_title;
            $_SESSION['experiment_reservation_form']['professor_id'] = $professor_id;
            $_SESSION['experiment_reservation_form']['course_code'] = $course_code;
            $_SESSION['experiment_reservation_form']['bench'] = $bench;
            $_SESSION['experiment_reservation_form']['start_time'] = $start_time;
            $_SESSION['experiment_reservation_form']['end_time'] = $end_time;
            $_SESSION['experiment_reservation_form']['studID'] = $student_id_list;
            $_SESSION['experiment_reservation_form']['asset'] = $asset_list;

            $returnMsg = "";
            //////////////////////////////////////////////check are the assets in list have double booking 
            foreach ($asset_list as $asset) {
                if (checkAssetOverlap($asset, 3, $start_time, $end_time) || checkAssetOverlap($asset, 7, $start_time, $end_time) || checkAssetOverlap($asset, 4, $start_time, $end_time)) {
                    $temp = getAssetsByID($asset);
                    $returnMsg = $returnMsg . "Asset ID: " . $asset . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                    $checkAssetCount++;
                }
            }
            /////////////////////////////////////////////////END
            //////////////////////////////////////////////check are the bench in list have double booking 
            if (checkAssetOverlap($bench, 3, $start_time, $end_time) || checkAssetOverlap($bench, 7, $start_time, $end_time) || checkAssetOverlap($bench, 4, $start_time, $end_time)) {
                $temp = getAssetsByID($bench);
                $returnMsg = $returnMsg . "Asset ID: " . $bench . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                $checkAssetCount++;
            }
            ////////////////////////////////////////////////////END
            if ($checkAssetCount > 0) {
                header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
                echo $returnMsg;
            }
            if ($checkAssetCount == 0) {
                $sopList = checkSOPreviewer($asset_list);
                if ($sopList != null) {
                    $_SESSION['sop'] = $sopList;
                    header('Refresh: 3;url=../forms/sopChecker.php');
                } else {
                    try {
                        if (formSubmit($student_id_list, $asset_list, $project_title, $professor_id, $course_code, $bench, "1", $start_time, $end_time) == true) {
                            header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                            unset($_SESSION['experiment_reservation_form']);
                            echo 'Form submit success!';
                        } else {
                            header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                            echo 'Form submit fail!<br> error occur.';
                        }
                    } catch (Exception $e) {
                        echo "Create object failed.\n";
                    }
                }
            }
        }
    } else if (isset($_POST['sop']) && isset($_SESSION['experiment_reservation_form'])) {
        $project_title = $_SESSION['experiment_reservation_form']['project_title'];
        $professor_id = $_SESSION['experiment_reservation_form']['professor_id'];
        $course_code = $_SESSION['experiment_reservation_form']['course_code'];
        $bench = $_SESSION['experiment_reservation_form']['bench'];
        $start_time = $_SESSION['experiment_reservation_form']['start_time'];
        $end_time = $_SESSION['experiment_reservation_form']['end_time'];
        $student_id_list = $_SESSION['experiment_reservation_form']['studID'];
        $asset_list = $_SESSION['experiment_reservation_form']['asset'];
        try {
            if (formSubmit($student_id_list, $asset_list, $project_title, $professor_id, $course_code, $bench, 'l', $start_time, $end_time) == true) {
                unset($_SESSION['experiment_reservation_form']);
                header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                echo 'Form submit success!';
            } else {
                header('Refresh: 3;url=../forms/experiment_reservation_form.php');
                echo 'Form submit fail!<br> error occur.';
            }
        } catch (Exception $e) {
            echo "Create object failed.\n";
        }
    } else if (isset($_POST['equipiment_borrowing'])) {
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $student = $_POST['studID'];
        $asset_list = $_POST['asset'];
        $checkAssetCount = 0;
        $returnMsg = "";
        foreach ($asset_list as $asset) {
            if (checkAssetOverlap($asset, 3, $start_time, $end_time) || checkAssetOverlap($asset, 7, $start_time, $end_time) || checkAssetOverlap($asset, 4, $start_time, $end_time)) {
                $temp = getAssetsByID($asset);
                $returnMsg = $returnMsg . "Asset ID: " . $asset . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                $checkAssetCount++;
            }
        }
        if ($checkAssetCount > 0) {
            header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
            echo $returnMsg;
        }
        if ($checkAssetCount == 0) {
            $sopList = checkSOPreviewer($asset_list);
            if ($sopList != null) {
                $_SESSION['equipiment_borrowing']['start_time'] = $start_time;
                $_SESSION['equipiment_borrowing']['end_time'] = $end_time;
                $_SESSION['equipiment_borrowing']['studID'] = $student;
                $_SESSION['equipiment_borrowing']['asset'] = $asset_list;
                $_SESSION['sop'] = $sopList;
                header('Refresh: 3;url=../forms/sopChecker.php');
            } else {
                try {
                    if (equipimentFormSubmit($student, $asset_list, '6', $start_time, $end_time) == true) {
                        header('Refresh: 3;url=../forms/equipiment_borrowing.php');
                        echo 'Form submit success!';
                    } else {
                        header('Refresh: 3;url=../forms/equipiment_borrowing.php');
                        echo 'Form submit fail!<br> error occur.';
                    }
                } catch (Exception $e) {
                    echo "Create object failed.\n";
                }
            }
        }
    } else if (isset($_POST['sop']) && isset($_SESSION['equipiment_borrowing'])) {
        $start_time = $_SESSION['equipiment_borrowing']['start_time'];
        $end_time = $_SESSION['equipiment_borrowing']['end_time'];
        $student = $_SESSION['equipiment_borrowing']['studID'];
        $asset_list = $_SESSION['equipiment_borrowing']['asset'];
        try {
            if (equipimentFormSubmit($student, $asset_list, '6', $start_time, $end_time) == true) {
                unset($_SESSION['equipiment_borrowing']);
                header('Refresh: 3;url=../forms/equipiment_borrowing.php');
                echo 'Form submit success!';
            } else {
                header('Refresh: 3;url=../forms/equipiment_borrowing.php');
                echo 'Form submit fail!<br> error occur.';
            }
        } catch (Exception $e) {
            echo "Create object failed.\n";
        }
    } else if (isset($_POST['equipiment_approve'])) {
        $form_id = $_POST['formID'];
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $checkAssetCount = 0;
        $returnMsg = "";
        foreach ($asset_list as $asset) {
            if (checkAssetOverlap($asset, 3, $start_time, $end_time) || checkAssetOverlap($asset, 7, $start_time, $end_time) || checkAssetOverlap($asset, 4, $start_time, $end_time)) {
                $temp = getAssetsByID($asset);
                $returnMsg = $returnMsg . "Asset ID: " . $asset . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                $checkAssetCount++;
            }
        }
        if ($checkAssetCount > 0) {
            header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
            echo $returnMsg;
        }
        if ($checkAssetCount == 0) {
            try {
                if (edit_and_approveEquipimentForm($form_id, $asset_list, $status, $start_time, $end_time) == TRUE) {
                    echo 'Equipiment Form approve success!';
                    //header('Refresh: 3;url=../form_approve_management.php');
                } else {
                    echo 'Equipiment Form approve fail!<br> error occur.';
                    //header('Refresh: 3;url=../form_approve_management.php');
                }
            } catch (Exception $e) {
                echo "module process fail\n";
            }
        }
    } else if (isset($_POST['row_selected'])) {
        $list_of_forms = $_POST['row_selected'];
        try {
            foreach ($list_of_assets as $value) {
                $_SESSION['object']::deleteAsset($value);
            }
            //echo 'delete assets success!';
            header('Location:../edit_asset.php');
        } catch (Exception $e) {
            //echo "Delete assets failed.\n";
            header('Location:../edit_asset.php');
        }
    } else if (isset($_POST['form_approve'])) {
        $form_id = $_POST['formID'];
        //$student_id_list = $_POST['studID'];
        $project_title = $_POST['project_title'];
        //$appl_time = $_POST['appl_time'];
        $course_code = $_POST['course_code'];
        //$professor_id = $_POST['professor_id'];
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $bench = $_POST['bench'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $checkAssetCount = 0;
        $returnMsg = "";
        if ($status == 9) {
            if (edit_and_approveForm($form_id, $project_title, $course_code, $asset_list, $status, $bench, $start_time, $end_time) == TRUE) {
                header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
                echo 'Form approve success!';
            }
        } else {
            if (!isset($_POST['asset'])) {
                if (checkAssetOverlap($bench, 3, $start_time, $end_time) || checkAssetOverlap($bench, 7, $start_time, $end_time) || checkAssetOverlap($bench, 4, $start_time, $end_time)) {
                    $temp = getAssetsByID($bench);
                    $returnMsg = $returnMsg . "Asset ID: " . $bench . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                    $checkAssetCount++;
                }
                if ($checkAssetCount > 0) {
                    header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
                    echo $returnMsg;
                } else {
                    try {
                        if (edit_and_approveFormNoAsset($form_id, $project_title, $course_code,  $status, $bench, $start_time, $end_time) == TRUE) {
                            echo 'Form approve success!';
                            //header('Refresh: 3;url=../form_approve_management.php');
                        } else {
                            echo 'Form approve fail!<br> error occur.';
                            //header('Refresh: 3;url=../form_approve_management.php');
                        }
                    } catch (Exception $e) {
                        echo "Create object failed.\n";
                    }
                }
            } else {
                foreach ($asset_list as $asset) {
                    if (checkAssetOverlap($asset, 3, $start_time, $end_time) || checkAssetOverlap($asset, 7, $start_time, $end_time) || checkAssetOverlap($asset, 4, $start_time, $end_time)) {
                        $temp = getAssetsByID($asset);
                        $returnMsg = $returnMsg . "Asset ID: " . $asset . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                        $checkAssetCount++;
                    }
                }
                if (checkAssetOverlap($bench, 3, $start_time, $end_time) || checkAssetOverlap($bench, 7, $start_time, $end_time) || checkAssetOverlap($bench, 4, $start_time, $end_time)) {
                    $temp = getAssetsByID($bench);
                    $returnMsg = $returnMsg . "Asset ID: " . $bench . " Asset Name: " . $temp[0]['name'] . " Asset Type: " . $temp[0]['type'] . " have been booked.<br>";
                    $checkAssetCount++;
                }
                if ($checkAssetCount > 0) {
                    header('Refresh: 3;url=' . $_SERVER['HTTP_REFERER']);
                    echo $returnMsg;
                }
                if ($checkAssetCount == 0) {
                    try {
                        if (edit_and_approveForm($form_id, $project_title, $course_code, $asset_list, $status, $bench, $start_time, $end_time) == TRUE) {
                            echo 'Form approve success!';
                            //header('Refresh: 3;url=../form_approve_management.php');
                        } else {
                            echo 'Form approve fail!<br> error occur.';
                            //header('Refresh: 3;url=../form_approve_management.php');
                        }
                    } catch (Exception $e) {
                        echo "module process fail\n";
                    }
                }
            }
        }
    } else if (isset($_POST['lent'])) {
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $form_id = $_POST['formID'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $bench = $_POST['bench'];
        try {
            if (lendingAssetAndBench($form_id, $asset_list, $start_time, $end_time, $bench) == TRUE) {
                header('Refresh: 3;url=../forms/lendingPage.php');
                echo 'lending success!';
            } else {
                header('Refresh: 3;url=../forms/lendingPage.php');
                echo 'Lending fail!<br> error occur.';
            }
        } catch (Exception $e) {
            echo "module process fail\n";
        }
    } else if (isset($_POST['lent_equipiment'])) {
        $asset_list = $_POST['asset'];
        $status = $_POST['status'];
        $form_id = $_POST['formID'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        try {
            if (lendingEquipiment($form_id, $asset_list, $start_time, $end_time) == TRUE) {
                header('Refresh: 3;url=../forms/lendingPage.php');
                echo 'lending success!';
            } else {
                header('Refresh: 3;url=../forms/lendingPage.php');
                echo 'Lending fail!<br> error occur.';
            }
        } catch (Exception $e) {
            echo "module process fail\n";
        }
    } else if (isset($_GET['delete_form'])) {
        $form_id = $_GET['form_id'];
        try {
            if (deleteFormM($form_id) == true) {
                //header('Refresh: 3;url=../form_management.php');
                echo 'Delete form success!';
            } else {
                echo 'Delete form fail!';
                //header('Refresh: 3;url=../form_management.php');
            }
        } catch (Exception $e) {
            header('Location:../form_management.php');
            echo "module fail.\n";
        }
    } else if (isset($_POST['return'])) {
        $asset_id = $_POST['asset_id'];
        if (returnAsset($asset_id) == true) {
            header('Refresh: 3;url=../forms/returnPage.php');
            echo 'Asset id:' . $asset_id . ' return success !';
        } else {
            header('Refresh: 3;url=../forms/returnPage.php');
            echo 'Asset id:' . $asset_id . ' return fail , it has not lent out!';
        }
    } else if (isset($_POST['barcode'])) {
        $barcode_id = $_POST['id'];
        header('Location: barcodegen/generator.php?barcode=' . $barcode_id);
    }
} catch (Exception $e) {
    echo "Exception.\n";
    exitWithHttpError(500);
}

function exitWithHttpError($error_code, $message = '') {
    switch ($error_code) {
        case 400: header("HTTP/1.0 400 Bad Request");
            break;
        case 403: header("HTTP/1.0 403 Forbidden");
            break;
        case 404: header("HTTP/1.0 404 Not Found");
            break;
        case 500: header("HTTP/1.0 500 Server Error");
            break;
    }

    header('Content-Type: text/plain');

    if ($message != '')
        header('X-Error-Description: ' . $message);

    exit;
}
