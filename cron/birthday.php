<?php
include('../lib/db.php');
include('../lib/sms-config.php');

$model = fetch_all($db, "SELECT id,client_name,contact,dob,anniversary FROM client");

$startDate = date("Y-m-d");

$dayString = "1 day";
$dateModel = new DateTime($startDate);
$dateModel->modify($dayString);

$endDate =  $dateModel->format("Y-m-d");

$birthdayArr = [];

$c1 = 0;
foreach ($model as $key1 => $val1) {
    $dbDate1 = (!empty($val1['dob'])) ? getDateServerFormat($val1['dob']) : "00/00/0000";

    if ($startDate <= $dbDate1 && $endDate >= $dbDate1) {

        $datetime1 = new DateTime($startDate);
        $datetime2 = new DateTime($dbDate1);
        $difference1 = $datetime2->diff($datetime1);

        foreach ($val1 as $val1key => $val1value) {
            $birthdayArr[$c1][$val1key] = $val1value;
            $birthdayArr[$c1]['diff'] = $difference1->days;
        }

        $c1++;
    }
}

foreach ($birthdayArr as $key => $value) {
    //echo birthdaySMS($db, $value['id'], 10);
}