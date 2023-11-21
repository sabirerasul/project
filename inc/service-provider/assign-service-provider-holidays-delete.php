<?php
include('../../lib/db.php');
throw_exception();


extract($_REQUEST);

$errors = [];
$data = [];

if (empty($id)) {
    $errors['error'] = 'id is required.';
}

function deleteServiceProviderHolidays($db, $id){
    $sql1 = "DELETE FROM service_provider_holiday WHERE `id`='".$id."'";
    $query1 = mysqli_query($db, $sql1);
    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['status'] = false;
} else {

    $m = deleteServiceProviderHolidays($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['status'] = true;
}

echo json_encode($data);

?>