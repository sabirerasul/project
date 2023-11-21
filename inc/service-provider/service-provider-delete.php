<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['spid'];

if (empty($_REQUEST['spid'])) {
    $errors['error'] = 'id is required.';
}


function deleteServiceProvider($db, $id){
    $sql = "DELETE FROM `service_provider` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteServiceProvider($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>