<?php
include('../../lib/db.php');

throw_exception();

//$v = $_REQUEST;

$id = $_POST['id'];

$errors = [];
$data = [];

if (empty($id)) {
    $errors['error'] = 'ID is required.';
}

function deleteAppointment($db, $id)
{

    $sql = "DELETE FROM `appointment` WHERE `id`='{$id}'";

    mysqli_query($db, "DELETE FROM `pending_payment_history` WHERE app_bill_id='{$id}' AND bill_type='appointment'");
    mysqli_query($db, "DELETE FROM `appointment_checkin` WHERE appointment_id='{$id}'");
    mysqli_query($db, "DELETE FROM `appointment_service` WHERE appointment_id='{$id}'");
    mysqli_query($db, "DELETE FROM `appointment_assign_service_provider` WHERE appointment_id='{$id}'");
    mysqli_query($db, "DELETE FROM `appointment_advance_payment` WHERE appointment_id='{$id}'");

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteAppointment($db, $id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
