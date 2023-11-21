<?php
include('../lib/db.php');
include('../lib/sms-config.php');

$model = fetch_all($db, "SELECT id, client_id, appointment_date FROM appointment");

$startDate = date("Y-m-d");

$dayString = "0 day";
$dateModel = new DateTime($startDate);
$dateModel->modify($dayString);

$endDate =  $dateModel->format("Y-m-d");

$appointmentArr = [];

$c2 = 0;
foreach ($model as $key2 => $val2) {

    $dbDate2 = (!empty($val2['appointment_date'])) ? getDateServerFormat($val2['appointment_date']) : "00/00/0000";

    if ($startDate <= $dbDate2 && $endDate >= $dbDate2) {

        $datetime3 = new DateTime($startDate);
        $datetime4 = new DateTime($dbDate2);
        $difference2 = $datetime4->diff($datetime3);

        foreach ($val2 as $val2key => $val2value) {
            $appointmentArr[$c2][$val2key] = $val2value;
            $appointmentArr[$c2]['diff'] = $difference2->days;
        }

        $c2++;
    }
}

foreach ($appointmentArr as $key => $value) {
    //echo anniversarySMS($db, $value['id'], $template_id);
}
