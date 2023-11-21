<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['id'];

if (empty($_REQUEST['id'])) {
    $errors['error'] = 'id is required.';
}


function deleteEnquiry($db, $id){
    $sql = "DELETE FROM `enquiry` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteEnquiry($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>