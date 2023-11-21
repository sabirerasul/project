<?php
include('../lib/db.php');
include('../lib/sms-config.php');

$model = fetch_all($db, "SELECT id,client_id,membership_id,valid_upto FROM client_membership");

$startDate = date("Y-m-d");

$dayString = "1 day";
$dateModel = new DateTime($startDate);
$dateModel->modify($dayString);

$endDate =  $dateModel->format("Y-m-d");

$membershipArr = [];

$c2 = 0;
foreach ($model as $key2 => $val2) {

    $dbDate2 = (!empty($val2['valid_upto'])) ? getDateServerFormat($val2['valid_upto'], '-') : "00/00/0000";

    if ($startDate <= $dbDate2 && $endDate >= $dbDate2) {

        $datetime3 = new DateTime($startDate);
        $datetime4 = new DateTime($dbDate1);
        $difference2 = $datetime4->diff($datetime3);

        foreach ($val2 as $val2key => $val2value) {
            $membershipArr[$c2][$val2key] = $val2value;
            $membershipArr[$c2]['diff'] = $difference2->days;
        }

        $c2++;
    }
}

foreach ($membershipArr as $key => $value) {
    //echo anniversarySMS($db, $value['id'], $template_id);
}
