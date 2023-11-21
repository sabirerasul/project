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


function addServiceReminder($db, $v, $k, $val){

    foreach ($v as $key => $value) {
        if($key != 'staff_submit'){
            $k .=  "`".$key."`,";
            $val .=  "'".$value."',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');
    
    $mysqltime = date ('Y-m-d H:i:s', time());
    $k1 = $k.", `created_at`, `status`";
    $val1 = $val.", '".$mysqltime."', '1'";   

    $sql = "INSERT INTO `service_reminder` ({$k1}) VALUES ({$val1})";
    
    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addServiceReminder($db, $v, $k, $val);
    
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>