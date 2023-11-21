<?php
include('../../lib/db.php');
throw_exception();

$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];


if (empty($_REQUEST['client_name'])) {
    $errors['error'] = 'Name is required.';
}else{
    if(validName($_REQUEST['client_name']) == false){
        $errors['error'] = 'Name is not valid.';
    }
}

if (empty($_REQUEST['contact'])) {
    $errors['error'] = 'Mobile is required.';
}else{
    if(validNumber($_REQUEST['contact']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT contact FROM client WHERE contact='".$_REQUEST['contact']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Number is already registered.';
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT email FROM client WHERE email='".$_REQUEST['email']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Email is already registered.';
        }
    }
}

function addClient($db, $v, $k, $val){

    foreach ($v as $key => $value) {
        if($key != 'client_submit'){
            $k .=  "`".$key."`,";
            $val .=  "'".$value."',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", `created_at`";
    $val = $val.", '".$mysqltime."'";

    $sql = "INSERT INTO `client` ({$k}) VALUES ({$val})";


    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addClient($db, $v, $k, $val);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>