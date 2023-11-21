<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['mid'];

if (empty($_REQUEST['mid'])) {
    $errors['error'] = 'mid is required.';
}

function deleteMembership($db, $id){
    $sql = "DELETE FROM `membership` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteMembership($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>