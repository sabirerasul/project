<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

if (isset($category_id) && !empty($category_id)) {
    $sql = "SELECT service_category.name as cat_name, service.id, service.category_id, service.membership_price, service.price, service.service_name as value, service.duration FROM service_category LEFT JOIN service ON service.category_id=service_category.id WHERE service.service_name LIKE '%{$name}%' AND category_id='{$category_id}' AND service_category.status=1 AND service.status=1 LIMIT 10";
} else {
    $sql = "SELECT service_category.name as cat_name, service.id, service.category_id, service.membership_price, service.price, service.service_name as value, service.duration FROM service_category LEFT JOIN service ON service.category_id=service_category.id WHERE service.service_name LIKE '%{$name}%' AND service_category.status=1 AND service.status=1 LIMIT 10";
}


if(isset($service_id)){
    $sql = "SELECT service_category.name as cat_name, service.id, service.category_id, service.membership_price, service.price, service.service_name as value, service.duration FROM service_category LEFT JOIN service ON service.category_id=service_category.id WHERE service.id='{$service_id}' LIMIT 10";
}

$modal = fetch_all($db, $sql);

$membership_id = (isset($membership_id) && $membership_id != 0) ? $membership_id : 0;
$membershipModel = fetch_object($db, "SELECT * FROM membership WHERE id='{$membership_id}'");
$emp = [];

foreach ($modal as $key => $value) {

    

    $price = $value['membership_price'];
    foreach ($value as $key1 => $value1) {
        $emp[$key][$key1] = $value1;

        if (!empty($membershipModel)) {
            $price = ($value['membership_price'] != 0) ? $value['membership_price'] : $value['price'];
        } else {
            $price = $value['price'];
        }

        // $emp[$key]['ser_etimedate'] = $timestamp.':00';
        // $emp[$key]['ser_stimedate'] = getEndTime($timestamp, $value['duration']);



        $emp[$key]['price'] = $price;
        $emp[$key]['ser_stimedate'] = $timestamp . ':00';
        $emp[$key]['ser_etimedate'] = getEndTime($timestamp, $value['duration']);

        // $emp[$key]['ser_stime'] = getOnlyTime($emp[$key]['ser_etimedate'], 'h');
        $emp[$key]['ser_stime'] = getOnlyTime($emp[$key]['ser_stimedate'], 'h');
        $emp[$key]['ser_etime'] = getOnlyTime(getEndTime($timestamp, $value['duration']), 'h');
        $emp[$key]['membership_price'] = 0;
    }
}

echo json_encode($emp);
