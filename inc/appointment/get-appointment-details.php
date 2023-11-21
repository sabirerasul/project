<?php

require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$datetime = new DateTime('now');
$datetime_string = $datetime->format('c');

$appointmentServiceModelArr = [];

$appointmentServiceSql = "SELECT * FROM appointment_service WHERE id='" . $appointmentServiceId . "'";
$appointmentServiceValue = fetch_object($db, $appointmentServiceSql);

$appointmentSql = "SELECT * FROM appointment WHERE id = '" . $appointmentServiceValue->appointment_id  . "'";
$appointmentModel = fetch_object($db, $appointmentSql);

$serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='" . $appointmentServiceValue->service_id . "'");
$clientModel = fetch_object($db, "SELECT * FROM client WHERE id='" . $appointmentModel->client_id . "'");

$appointmentServiceProviderAssignModel = fetch_object($db, "SELECT * FROM `appointment_assign_service_provider` WHERE appointment_service_id='{$appointmentServiceValue->id}'");
$serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='" . $appointmentServiceProviderAssignModel->service_provider_id . "'");

$appointmentClassName = ($appointmentModel->status == 'Billed') ? 'billed-appointment' : 'pending-appointment';
$appointmentColor = ($appointmentModel->status == 'Billed') ? 'green' : 'blue';

$checkinModel = fetch_object($db, "SELECT * FROM `appointment_checkin` WHERE appointment_id='{$appointmentModel->id}'");

$checkinStatus = !empty($checkinModel) ? 1 : 0;
$checkinTime = ($checkinStatus != 0) ? $checkinModel->checkin_time : '';

$isBilled = num_rows($db, "SELECT * FROM client_billing WHERE appointment_id='{$appointmentModel->id}'");

$isBilled = ($isBilled == 0) ? 0 : 1;

$appointmentServiceModelArr = [
    'id' => $appointmentServiceValue->id,
    'resourceId' => $appointmentServiceProviderAssignModel->service_provider_id,
    'start' => getCFormatDate($appointmentServiceValue->start_timestamp),
    'end' => getCFormatDate($appointmentServiceValue->end_timestamp),
    'client' => $clientModel->client_name,
    'color' => $appointmentColor,
    'beautician' => $serviceProviderModel->name,
    'className' => $appointmentClassName,
    'notes' => $appointmentModel->notes,
    'service' => $serviceModel->service_name,
    'date' => $appointmentModel->appointment_date,
    'appointment_status' => $appointmentModel->status,
    'start_time' => date("h:i A", strtotime($appointmentServiceValue->start_timestamp)),
    'end_time' => date("h:i A", strtotime($appointmentServiceValue->end_timestamp)),
    //'bill_status' => '1',
    'appointment_id' => $appointmentModel->id,
    'bill_status' => $isBilled,
    'checkin_status' => $checkinStatus,
    'checkin_time' => $checkinTime

];
echo json_encode($appointmentServiceModelArr);
