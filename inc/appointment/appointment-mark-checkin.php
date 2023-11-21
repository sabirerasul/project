<?php
extract($_REQUEST);
include('../../lib/db.php');
throw_exception();

$errors = [];
$data = [];

$id = $_REQUEST['sid'];

function markAppointment($db, $id)
{
    $model = fetch_object($db, "SELECT * FROM `appointment_service` WHERE id='{$id}'");
    $appointmentModel = fetch_object($db, "SELECT * FROM appointment WHERE id='{$model->appointment_id}'");
    $status = 'Checkedin';
    $sql = "UPDATE `appointment` SET status='" . $status . "' WHERE id={$appointmentModel->id}";
    $checkinTime = date('Y-m-d H:i:s', time());
    mysqli_query($db, "INSERT INTO `appointment_checkin`(`appointment_id`, `checkin_time`) VALUES ('{$model->appointment_id}','{$checkinTime}')");
    $query = mysqli_query($db, $sql);
    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = markAppointment($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
