<?php
include('../../lib/db.php');
throw_exception();


$rawData = $_POST['product_use_in_salon'];

$errors = [];
$data = [];



function updateProductUseInSalon($db, $value)
{
    $sql = '';

    $id = $value['id'];
    $salon_product_id = $value['salon_product_id'];
    $quantity = $value['quantity'];
    $sp_id = $value['sp_id'];
    $remark = $value['remark'];
    $updatedAt = date('Y-m-d H:i:s', time());

    $sql = "UPDATE `product_use_in_salon` SET `salon_product_id`='" . $salon_product_id . "', `quantity`='" . $quantity . "', `service_provider_id`='" . $sp_id . "', `remark`='" . $remark . "', `updated_at`='" . $updatedAt . "' WHERE id='" . $id . "'";

    $query = mysqli_query($db, $sql);

    $productUseInSalonStockRecordModel = fetch_object($db, "SELECT `stock_record_id` FROM `product_use_in_salon_stock_record` WHERE `product_use_in_salon_id`='{$id}'");

    $query1 = mysqli_query($db, "UPDATE `stock_record` SET `stock_main_id`='{$salon_product_id}', `vendor_client_service_provider_id`='{$sp_id}', `debit`='{$quantity}', `updated_at`='{$updatedAt}' WHERE `id`='{$productUseInSalonStockRecordModel->stock_record_id}'");

    return $query ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = updateProductUseInSalon($db, $rawData);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
