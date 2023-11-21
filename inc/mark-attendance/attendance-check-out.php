<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

/*
if (empty($_REQUEST['name'])) {
    $errors['error'] = 'Name is required.';
}else{
    if(validName($_REQUEST['name']) == false){
        $errors['error'] = 'Name is not valid.';
    }
}

if (empty($_REQUEST['contact_number'])) {
    $errors['error'] = 'Mobile is required.';
}else{
    if(validNumber($_REQUEST['contact_number']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT contact_number FROM employee WHERE contact_number='".$_REQUEST['contact_number']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Contact Number is already registered.';
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT email FROM employee WHERE email='".$_REQUEST['email']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Email is already registered.';
        }
    }
}

if (empty($_REQUEST['working_hours_start'])) {
    $errors['error'] = 'working time start is required.';
}

if (empty($_REQUEST['working_hours_end'])) {
    $errors['error'] = 'working time end is required.';
}

if (empty($_REQUEST['salary'])) {
    $errors['error'] = 'salary is required.';
}




if (!empty($_REQUEST['emer_contact_number'])) {
    if(validNumber($_REQUEST['emer_contact_number']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT emer_contact_number FROM employee WHERE emer_contact_number='".$_REQUEST['emer_contact_number']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Number is already registered.';
        }
    }
}


if (!empty($_REQUEST['emer_contact_person'])) {
    if(validName($_REQUEST['emer_contact_person']) == false){
        $errors['error'] = 'Emer. Contact Person Name is not valid.';
    }
}

if (empty($_REQUEST['gender'])) {
    $errors['error'] = 'gender is required.';
}

if (empty($_REQUEST['date_of_joining'])) {
    $errors['error'] = 'date of joining is required.';
}

if (empty($_REQUEST['user_type'])) {
    $errors['error'] = 'user type is required.';
}

if (empty($_REQUEST['department'])) {
    $errors['error'] = 'department type is required.';
}
*/

function updateAttendance($db, $v)
{
    $employeeId = $v['employee_id'];
    $employeeType = $v['employee_type'];
    $mysqltime = date('Y-m-d H:i:s', time());
    $serverDate = date("d/m/Y");

    $chkSql = "SELECT * FROM attendance WHERE date='{$serverDate}' AND employee_id='{$employeeId}' AND employee_type='{$employeeType}'";

    $model = fetch_object($db, $chkSql);
    $id = $model->id;
    $checkOutTime = $v['check_out_time'];
    $sql = "UPDATE `attendance` SET `check_out_time`='{$checkOutTime}',`updated_at`='{$mysqltime}' WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateAttendance($db, $v);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
