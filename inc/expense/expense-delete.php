<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['eid'];

if (empty($_REQUEST['eid'])) {
    $errors['error'] = 'eid is required.';
}


function deleteExpense($db, $id){
    $sql = "DELETE FROM `expense` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteExpense($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>