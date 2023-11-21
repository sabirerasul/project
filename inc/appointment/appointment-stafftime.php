<?php

require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$dayName = date('l', strtotime($date));

$appointmentDate = $date;

$spSql = "
        SELECT 
            `id`, `working_hours_end`, CONCAT_WS(' - ', `name`, `username`) AS `name`, `service_provider_type`
        FROM
            service_provider
        WHERE 
            status = 1 AND id='{$id}'
        ";

$modalSql = mysqli_query($db, $spSql);
$modal = mysqli_fetch_object($modalSql);


$serviceModal = $modal;
$serviceProviderModel = fetch_object($db, "SELECT * FROM `service_provider` WHERE `status`=1 AND id='{$id}'");

$arr = [];

$holidaySql = "SELECT id FROM service_provider_holiday WHERE sp_id='" . $serviceModal->id . "' AND date='" . $appointmentDate . "'";
$holidayQuery = mysqli_query($db, $holidaySql);
$numHoliday = mysqli_num_rows($holidayQuery);

$offWeekDaySql = "SELECT id FROM service_provider_off_week_day WHERE sp_id='" . $serviceModal->id . "' AND day='" . $dayName . "'";
$offWeekDayQuery = mysqli_query($db, $offWeekDaySql);
$numOffWeekDay = mysqli_num_rows($offWeekDayQuery);

$serviceEndTime = getOnlyTimeWithoutSecond($endtime, 'h');

$starttimeLocal = date("h:i A", strtotime($starttime));
if ($numHoliday == 1 || $numOffWeekDay == 1 || $serviceEndTime > $serviceModal->working_hours_end) {

    $arr['pid'] = $serviceModal->id;
    $arr['pname'] = $serviceModal->name;
    $arr['spcat'] = $serviceModal->service_provider_type;
    $arr['starttimestamp'] = $starttime;
    $arr['start'] = $starttimeLocal;
    $arr['available'] = 1;
    $arr['serviceProviderModel'] = $serviceProviderModel;
} else {
    $arr['pid'] = $serviceModal->id;
    $arr['pname'] = $serviceModal->name;
    $arr['spcat'] = $serviceModal->service_provider_type;
    $arr['starttimestamp'] = $starttime;
    $arr['start'] = $starttimeLocal;
    $arr['available'] = 0;
    $arr['serviceProviderModel'] = $serviceProviderModel;
}

$arr = [
    'success' => $arr['available'],
    'data' => $arr
];

echo json_encode($arr);
