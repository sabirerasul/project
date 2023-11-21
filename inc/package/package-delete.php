<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['pid'];

if (empty($_REQUEST['pid'])) {
    $errors['error'] = 'pid is required.';
}


function deletePackage($db, $id){
    $sql1 = "DELETE FROM `package` WHERE id={$id}";
    $sql2 = "DELETE FROM `package_service` WHERE package_id={$id}";

    $query1 = mysqli_query($db, $sql1);
    $query2 = mysqli_query($db, $sql2);

    return $query1 ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deletePackage($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>