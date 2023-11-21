<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);

$appointment_date = $date;

if (strpos($date, '/') !== false) {
    $newappointmentDate = explode('/', $date);
    $appointmentDate = $newappointmentDate[0] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[2];
    $serverAppointmentDate = $newappointmentDate[2] . "-" . $newappointmentDate[1] . "-" . $newappointmentDate[0];
} else {
    $appointmentDate = date("d-m-Y", strtotime($date));
    $serverAppointmentDate = $date;
}

$dayName = date('l', strtotime($serverAppointmentDate));

$spSql = "
        SELECT 
            *
        FROM
            service_provider
        WHERE 
            status = 1 AND id='{$staff_id}'
        ";

$modal = fetch_object($db, $spSql);


$serviceModal = $modal;

$arr = [];

$numHoliday = num_rows($db, "SELECT id FROM service_provider_holiday WHERE sp_id='" . $serviceModal->id . "' AND date='" . $appointmentDate . "'");

$numOffWeekDay = num_rows($db, "SELECT id FROM service_provider_off_week_day WHERE sp_id='" . $serviceModal->id . "' AND day='" . $dayName . "'");

$serviceEndTime = getOnlyTimeWithoutSecond($endtime, 'h');


$busy = 0;

$appointmentModel = fetch_all($db, "SELECT id FROM appointment WHERE appointment_date='{$appointment_date}' AND status!='Cancelled'");

$appointmentIds = array_column($appointmentModel, "id");

$appointmentIds = implode(',', $appointmentIds);

$appointmentIds = !empty($appointmentIds) ? $appointmentIds : 0;

$appointmentServiceModel = fetch_all($db, "SELECT * FROM appointment_service WHERE appointment_id IN ({$appointmentIds})");

foreach ($appointmentServiceModel as $appointmentServiceKey => $appointmentServiceVal) {
    $appointmentServiceValue = (object) $appointmentServiceVal;
    $serviceNumRow = num_rows($db, "SELECT * FROM appointment_assign_service_provider WHERE appointment_service_id='{$appointmentServiceValue->id}' AND service_provider_id='{$staff_id}'");
    if ($serviceNumRow > 0) {

        $serviceStartTime = $appointmentServiceValue->start_time;
        $serviceEndTime = $appointmentServiceValue->end_time;
        if ($starttime >= $serviceStartTime && $endtime <= $serviceEndTime) {
            $busy = 1;
        }
    }
}

if ($numHoliday == 1 || $numOffWeekDay == 1 || $serviceEndTime > $serviceModal->working_hours_end) {
    $arr['available'] = 2;
} elseif ($busy == 1) {
    $arr['available'] = 1;
} else {
    $arr['available'] = 0;
}


$arr['pid'] = $serviceModal->id;
$arr['pname'] = $serviceModal->name;
$arr['spcat'] = $serviceModal->service_provider_type;
$arr['start'] = $starttime;

$model = [
    'data' => $arr,
    'success' => $arr['available'],
];

echo json_encode($model);
