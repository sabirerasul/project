<?php
require_once "../../lib/db.php";

throw_exception();



extract($_REQUEST);

//, CONCAT_WS(' - ', `product`, `mrp_price`, `exp_date`) as value

$mainSql = "SELECT * FROM product WHERE product LIKE '%{$product}%' AND status=1 LIMIT 10";
$mainModel = fetch_all($db, $mainSql);

$mainProductIdsArr = array_column($mainModel, 'id');
$mainProductIds = implode(',', $mainProductIdsArr);

$sql = "SELECT * FROM stock_purchase_product WHERE product_id IN ({$mainProductIds}) AND status=1 LIMIT 10";
$modal = fetch_all($db, $sql);

$emp = [];

$todayDate = todayDate();

$branch_id = BRANCHID;

foreach ($modal as $key => $value) {

    $productModel = fetch_object($db, "SELECT * FROM product WHERE id={$value['product_id']}");


    $purchaseModel = fetch_object($db, "SELECT * FROM stock_purchase WHERE id='{$value['stock_purchase_id']}'");

    $recordModel = fetch_object($db, "SELECT * FROM stock_record WHERE id='{$value['stock_record_id']}' AND vendor_client_service_provider_id='{$purchaseModel->vendor_id}' AND branch_id='{$branch_id}'");

    // /debug($recordModel);

    if (empty($recordModel)) {
        continue;
    }

    $stockModel = fetch_object($db, "SELECT * FROM stock WHERE id='{$recordModel->stock_main_id}'");

    if (getDateServerFormat($stockModel->exp_date) <= getDateServerFormat($todayDate)) {
        continue;
    }

    //foreach ($value as $key1 => $value1) {
    $emp[$key]["id"] = $stockModel->id;
    $emp[$key]["value"] = "{$productModel->product} - {$value['sale_price']} - {$value['exp_date']}";
    $emp[$key]["sale_price"] = $value['sale_price'];
    $emp[$key]["duration"] = "0";
    $emp[$key]["points"] = "0";
    $emp[$key]["exp_date"] = $value['exp_date'];
    $emp[$key]["stock_id"] = $stockModel->id;
    $emp[$key]["name"] = $productModel->product;
    $emp[$key]["price"] = $value['mrp_price'];
    $emp[$key]["volume"] = $value['volume'];
    $emp[$key]["unit"] = $value['unit'];
    $emp[$key]["barcode"] = $productModel->barcode;
    $emp[$key]["reward"] = $productModel->reward_point_on_purchase;
    $emp[$key]["active"] = $value['status'];
    $emp[$key]["branch_id"] = "0";
    $emp[$key]["ser_stime"] = "1970-01-01 05:30:00";
    $emp[$key]["ser_etime"] = "1970-01-01 05:30:00";
    $emp[$key]['actual_stock'] = availableStock($db, $stockModel->id);
    //}
}

echo json_encode($emp);

/*


when product is not found then create new product


*/