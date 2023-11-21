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


function deleteProduct($db, $id){
    $sql = "DELETE FROM `product` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteProduct($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>