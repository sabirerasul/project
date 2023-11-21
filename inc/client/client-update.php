<?php
include('../../lib/db.php');
throw_exception();

if(isset($_SESSION['clientUpdateError'])){
    unset($_SESSION['clientUpdateError']);
}

$v = $_REQUEST;
$k = '';
$val = '';
$id = $_REQUEST['cid'];

if(empty($id)){
    header("location: ../../client.php");
}

$errors = [];
$data = [];

$modelSql = mysqli_query($db, "SELECT * FROM client WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);


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
        if($model->contact != $_REQUEST['contact']){
            $sql = mysqli_query($db, "SELECT contact FROM client WHERE contact='".$_REQUEST['contact']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Number is already registered.';
            }
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{

        if($model->email != $_REQUEST['email']){
            $sql = mysqli_query($db, "SELECT email FROM client WHERE email='".$_REQUEST['email']."'");
            if(mysqli_num_rows($sql) > 0){
                $errors['error'] = 'Email is already registered.';
            }
        }
    }
}

if (empty($_REQUEST['gender'])) {
    $errors['error'] = 'Gender cannot be blank';
}

function updateClient($db, $v, $k, $id){

    foreach ($v as $key => $value) {
        if($key != 'client_submit' && $key != 'cid'){
            $k .=  "{$key}='{$value}',";
        }
    }

    $k = rtrim($k, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", updated_at='".$mysqltime."'";

    $sql = "UPDATE `client` SET {$k} WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateClient($db, $v, $k, $id);
    $errors['error'] = 'Profile updated successfully';
    $data['success'] = true;
    $data['errors'] = $errors;
}

$_SESSION['clientUpdateError'] = $data;
header('location: ../../client-profile.php?id='.$id);
