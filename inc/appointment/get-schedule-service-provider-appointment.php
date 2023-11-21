<?php

require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$currentDate = date('d/m/Y');
$currentTime = date('h:m A');

if ($date < $currentDate) {
    $model = [];
} else {
    $sql = "SELECT * FROM appointment WHERE appointment_date = '" . $date . "'";
    $model = fetch_all($db, $sql);
}

$html = '';
if (count($model) > 0) {
    foreach ($model as $key => $val) {
        $value = (object) $val;

        $appointmentServiceSql = "SELECT * FROM appointment_service WHERE appointment_id='" . $value->id . "'";
        $appointmentServiceModel = fetch_all($db, $appointmentServiceSql);

        foreach ($appointmentServiceModel as $appointmentServiceKey => $appointmentServiceVal) {
            $appointmentServiceValue = (object) $appointmentServiceVal;

            $serviceNumRow = num_rows($db, "SELECT * FROM appointment_assign_service_provider WHERE appointment_service_id='{$appointmentServiceValue->id}' AND service_provider_id='{$staff_id}'");
            if ($serviceNumRow == 0) {
                continue;
            }

            $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='" . $appointmentServiceValue->service_id . "'");
            $clientModel = fetch_object($db, "SELECT * FROM client WHERE id='" . $value->client_id . "'");


            $assignServiceProviderModel = fetch_object($db, "SELECT * FROM appointment_assign_service_provider WHERE appointment_service_id='" . $appointmentServiceValue->id . "'");

            $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='" . $assignServiceProviderModel->service_provider_id . "'");


            //if ($currentTime <= $appointmentServiceValue->start_time) {

            if ($value->status == 'Billed') {
                $appointmentClassName = 'billed-appointment';
            }

            if ($value->status == 'Pending') {
                $appointmentClassName = 'pending-appointment';
            }

            if ($value->status == 'Cancelled') {
                $appointmentClassName = 'cancelled-appointment';
            }

            if ($value->status == 'Checkedin') {
                $appointmentClassName = 'checkedin-appointment';
            }

            $trColor = $appointmentClassName;

            $html .= '
                <tr class=' . "$trColor" . '>
                    <td>' . $serviceProviderModel->name . '</td>
                    <td>' . $clientModel->client_name . '</td>
                    <td>' . $serviceModel->service_name . '</td>
                    <td>' . $appointmentServiceValue->start_time . '</td>
                    <td>' . $appointmentServiceValue->end_time . '</td>
                    <td>' . getMinute($serviceModel->duration) . ' Min</td>
                </tr>';
            /*} else {
                $html = '
                <tr>
                    <td colspan="6">No Scheduled Appointment Found!</td>
                </tr>';
            }*/
        }
    }
} else {
    $html = '
    <tr>
        <td colspan="6">No Scheduled Appointment Found!</td>
    </tr>';
}



echo $html;
