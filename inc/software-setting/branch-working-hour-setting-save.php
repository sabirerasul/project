<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$branch_working_day_hour = $_POST['branch_working_day_hour'];
$branch_id = BRANCHID;

$errors = [];
$data = [];



function saveBranchWorkingDayHour($db, $model, $branch_id)
{
    extract($model);

    $day_end_report_send_mail = isset($day_end_report_send_mail) ? $day_end_report_send_mail : 0;
    $day_end_report_send_sms = isset($day_end_report_send_sms) ? $day_end_report_send_sms : 0;

    $monday = isset($monday) ? $monday : 0;
    $monday = isset($monday) ? $monday : 0;
    $tuesday = isset($tuesday) ? $tuesday : 0;
    $wednesday = isset($wednesday) ? $wednesday : 0;
    $thursday = isset($thursday) ? $thursday : 0;
    $friday = isset($friday) ? $friday : 0;
    $saturday = isset($saturday) ? $saturday : 0;
    $sunday = isset($sunday) ? $sunday : 0;

    if(!empty($branch_working_day_hour_id)){
        $sql = "UPDATE `branch_working_day_hour` SET `monday`='{$monday}', `monday_hour_open`='{$monday_hour_open}', `monday_hour_close`='{$monday_hour_close}', `tuesday`='{$tuesday}', `tuesday_hour_open`='{$tuesday_hour_open}', `tuesday_hour_close`='{$tuesday_hour_close}', `wednesday`='{$wednesday}', `wednesday_hour_open`='{$wednesday_hour_open}', `wednesday_hour_close`='{$wednesday_hour_close}', `thursday`='{$thursday}', `thursday_hour_open`='{$thursday_hour_open}', `thursday_hour_close`='{$thursday_hour_close}', `friday`='{$friday}', `friday_hour_open`='{$friday_hour_open}', `friday_hour_close`='{$friday_hour_close}', `saturday`='{$saturday}', `saturday_hour_open`='{$saturday_hour_open}', `saturday_hour_close`='{$saturday_hour_close}', `sunday`='{$sunday}', `sunday_hour_open`='{$sunday_hour_open}', `sunday_hour_close`='{$sunday_hour_close}', `extra_hour`='{$extra_hour}', `day_end_report_time`='{$day_end_report_time}', `day_end_report_send_mail`='{$day_end_report_send_mail}', `day_end_report_send_sms`='{$day_end_report_send_sms}' WHERE id='{$branch_working_day_hour_id}'";
    }else{
        $sql = "INSERT INTO `branch_working_day_hour`(`branch_id`, `monday`, `monday_hour_open`, `monday_hour_close`, `tuesday`, `tuesday_hour_open`, `tuesday_hour_close`, `wednesday`, `wednesday_hour_open`, `wednesday_hour_close`, `thursday`, `thursday_hour_open`, `thursday_hour_close`, `friday`, `friday_hour_open`, `friday_hour_close`, `saturday`, `saturday_hour_open`, `saturday_hour_close`, `sunday`, `sunday_hour_open`, `sunday_hour_close`, `extra_hour`, `day_end_report_time`, `day_end_report_send_mail`, `day_end_report_send_sms`) VALUES ('{$branch_id}', '{$monday}', '{$monday_hour_open}', '{$monday_hour_close}', '{$tuesday}', '{$tuesday_hour_open}', '{$tuesday_hour_close}', '{$wednesday}', '{$wednesday_hour_open}', '{$wednesday_hour_close}', '{$thursday}', '{$thursday_hour_open}', '{$thursday_hour_close}', '{$friday}', '{$friday_hour_open}', '{$friday_hour_close}', '{$saturday}', '{$saturday_hour_open}', '{$saturday_hour_close}', '{$sunday}', '{$sunday_hour_open}', '{$sunday_hour_close}', '{$extra_hour}', '{$day_end_report_time}', '{$day_end_report_send_mail}', '{$day_end_report_send_sms}')";
    }

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveBranchWorkingDayHour($db, $branch_working_day_hour, $branch_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
