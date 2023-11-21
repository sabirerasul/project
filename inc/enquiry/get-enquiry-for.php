<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$startTimestamp = $timestamp;
$withSecondStartTimestamp = $startTimestamp . ":00";

$branch_id = BRANCHID;

if (!empty($service_id)) {

    $zeroId = 0;

    $sqlService = "SELECT * FROM `service` WHERE id='{$zeroId}'";
    $sqlPackage = "SELECT * FROM `package` WHERE id='{$zeroId}'";
    $sqlMembership = "SELECT * FROM `membership` WHERE id='{$zeroId}'";
    $sqlStock = "SELECT * FROM product WHERE id='{$zeroId}'";

    if ($service_type == 'service') {
        $sqlService = "SELECT * FROM service_category LEFT JOIN service ON service.category_id=service_category.id WHERE service.id='{$service_id}' service.status=1";
    }

    if ($service_type == 'stock') {
        $sqlStock = "SELECT * FROM product WHERE id='{$service_id}' AND status=1";
    }

    if ($service_type == 'package') {
        $sqlPackage = "SELECT * FROM `package` WHERE id='{$service_id}'";
    }

    if ($service_type == 'membership') {
        $sqlMembership = "SELECT * FROM `membership` WHERE id='{$service_id}'";
    }
} else {

    $sqlService = "SELECT * FROM service_category LEFT JOIN service ON service.category_id=service_category.id WHERE service.service_name LIKE '%{$terms}%' AND service_category.status=1 AND service.status=1 LIMIT 5";
    $sqlPackage = "SELECT * FROM `package` WHERE package_name LIKE '%{$terms}%' LIMIT 5";
    $sqlMembership = "SELECT * FROM `membership` WHERE membership_name LIKE '%{$terms}%' LIMIT 5";
    $sqlStock = "SELECT * FROM product WHERE product LIKE '%{$terms}%' AND status=1 LIMIT 5";
}

$mainModel = fetch_all($db, $sqlStock);

$mainProductIdsArr = array_column($mainModel, 'id');
$mainProductIds = implode(',', $mainProductIdsArr);
$mainProductIds = !empty($mainProductIds) ? $mainProductIds : 0;

$stockSql = "SELECT * FROM stock_purchase_product WHERE product_id IN ({$mainProductIds}) AND status=1 LIMIT 5";

$todayDate = todayDate();

$serviceModal = fetch_all($db, $sqlService);
$packageModal = fetch_all($db, $sqlPackage);
$membershipModal = fetch_all($db, $sqlMembership);
$stockModal = fetch_all($db, $stockSql);

$enquiryFor = [];

$count = 0;

foreach ($serviceModal as $serviceKey => $serviceValue) {

    $enquiryFor[$count]["actual_stock"] = "0";
    $enquiryFor[$count]["category_id"] = $serviceValue['category_id'];
    $enquiryFor[$count]["category_name"] = $serviceValue['name'];
    $enquiryFor[$count]["duration"] = $serviceValue['duration'];
    $enquiryFor[$count]["exp_date"] = "0000-00-00";
    $enquiryFor[$count]["id"] = $serviceValue['id'];
    $enquiryFor[$count]["points"] = "";
    $enquiryFor[$count]["price"] = $serviceValue['price'];
    $enquiryFor[$count]["ser_etime"] = getOnlyTime($withSecondStartTimestamp, 'h');
    $enquiryFor[$count]["ser_stime"] = getOnlyTime(getEndTime($startTimestamp, $serviceValue['duration']), 'h');
    $enquiryFor[$count]["ser_etimedate"] = $withSecondStartTimestamp;
    $enquiryFor[$count]["ser_stimedate"] = getEndTime($startTimestamp, $serviceValue['duration']);
    $enquiryFor[$count]["stock_id"] = "0";
    $enquiryFor[$count]["type"] = "service";
    $enquiryFor[$count]["value"] = $serviceValue['service_name'];

    $count++;
}

foreach ($packageModal as $packageKey => $packageValue) {

    $enquiryFor[$count]["actual_stock"] = "0";
    $enquiryFor[$count]["category_id"] = "";
    $enquiryFor[$count]["category_name"] = "";
    $enquiryFor[$count]["duration"] = $packageValue['duration'];
    $enquiryFor[$count]["exp_date"] = $packageValue['package_validity'];
    $enquiryFor[$count]["id"] = $packageValue['id'];
    $enquiryFor[$count]["points"] = "";
    $enquiryFor[$count]["price"] = $packageValue['price'];
    $enquiryFor[$count]["ser_etime"] = getOnlyTime($withSecondStartTimestamp, 'h');
    $enquiryFor[$count]["ser_stime"] = getOnlyTime($withSecondStartTimestamp, 'h');
    $enquiryFor[$count]["ser_etimedate"] = $withSecondStartTimestamp;
    $enquiryFor[$count]["ser_stimedate"] = $withSecondStartTimestamp;
    $enquiryFor[$count]["stock_id"] = "0";
    $enquiryFor[$count]["type"] = "package";
    $enquiryFor[$count]["value"] = $packageValue['package_name'];

    $count++;
}

foreach ($membershipModal as $membershipKey => $membershipValue) {


    $enquiryFor[$count]["actual_stock"] = "0";
    $enquiryFor[$count]["category_id"] = "";
    $enquiryFor[$count]["category_name"] = "";
    $enquiryFor[$count]["duration"] = "0";
    $enquiryFor[$count]["exp_date"] = $membershipValue['validity'];
    $enquiryFor[$count]["id"] = $membershipValue['id'];
    $enquiryFor[$count]["points"] = "";
    $enquiryFor[$count]["price"] = $membershipValue['price'];
    $enquiryFor[$count]["ser_etime"] = getOnlyTime($withSecondStartTimestamp, 'h');
    $enquiryFor[$count]["ser_stime"] = getOnlyTime($withSecondStartTimestamp, 'h');
    $enquiryFor[$count]["ser_etimedate"] = $withSecondStartTimestamp;
    $enquiryFor[$count]["ser_stimedate"] = $withSecondStartTimestamp;
    $enquiryFor[$count]["stock_id"] = "0";
    $enquiryFor[$count]["type"] = "membership";
    $enquiryFor[$count]["value"] = $membershipValue['membership_name'];

    $count++;
}

foreach ($stockModal as $stockKey => $stockValue) {

    $productModel = fetch_object($db, "SELECT * FROM product WHERE id={$stockValue['product_id']}");
    $purchaseModel = fetch_object($db, "SELECT * FROM stock_purchase WHERE id='{$stockValue['stock_purchase_id']}'");
    $recordModel = fetch_object($db, "SELECT * FROM stock_record WHERE id='{$stockValue['stock_record_id']}' AND vendor_client_service_provider_id='{$purchaseModel->vendor_id}' AND branch_id='{$branch_id}'");
    if (empty($recordModel)) {
        continue;
    }
    $stockModel = fetch_object($db, "SELECT * FROM stock WHERE id='{$recordModel->stock_main_id}'");

    $availableStock = availableStock($db, $stockModel->id);
    if ($availableStock < 1) {
        continue;
    }

    if (getDateServerFormat($stockModel->exp_date) > getDateServerFormat($todayDate)) {
        $enquiryFor[$count]['actual_stock'] = $availableStock;
        $enquiryFor[$count]["category_id"] = "";
        $enquiryFor[$count]["category_name"] = "";
        $enquiryFor[$count]["duration"] = "0";
        $enquiryFor[$count]["exp_date"] = $stockValue['exp_date'];
        $enquiryFor[$count]["id"] = $stockModel->id;
        $enquiryFor[$count]["points"] = $productModel->reward_point_on_purchase;
        $enquiryFor[$count]["price"] = $stockValue['sale_price'];
        $enquiryFor[$count]["ser_etime"] = getOnlyTime($withSecondStartTimestamp, 'h');
        $enquiryFor[$count]["ser_stime"] = getOnlyTime($withSecondStartTimestamp, 'h');
        $enquiryFor[$count]["ser_etimedate"] = $withSecondStartTimestamp;
        $enquiryFor[$count]["ser_stimedate"] = $withSecondStartTimestamp;
        $enquiryFor[$count]["stock_id"] = $stockModel->id;
        $enquiryFor[$count]["type"] = "stock";
        $enquiryFor[$count]["value"] = "{$productModel->product} ({$stockValue['volume']} {$stockValue['unit']}) - {$stockValue['exp_date']}";

        $count++;
    }
}



echo json_encode($enquiryFor);
