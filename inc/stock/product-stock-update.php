<?php
include('../../lib/db.php');

throw_exception();


$stock = $_POST['stock'];
$stockProductDetails = $_POST['stock_product_details'];

$branch_id = BRANCHID;

$errors = [];
$data = [];

function updateStock($db, $stock)
{
    extract($stock);
    $updated_at = date('Y-m-d H:i:s', time());
    $sql = "UPDATE `stock_purchase` SET `vendor_id`='{$vendor_id}',`gst_number`='{$gst_number}',`invoice_number`='{$invoice_number}',`purchase_date`='{$purchase_date}',`sub_total`='{$sub_total}',`discount`='{$discount}',`discount_type`='{$discount_type}',`tax`='{$tax}',`shipping_charge`='{$shipping_charge}',`total_charge`='{$total_charge}',`amount_paid`='{$amount_paid}',`payment_mode`='{$payment_mode}',`pending_due`='{$pending_due}',`notes`='{$notes}',`updated_at`='{$updated_at}' WHERE id='{$id}'";
    //$sql2 = "INSERT INTO `purchase_history` (`vendor_id`, `invoice`, `amount_payable`, `amount_paid`, `payment_mode`, `amount_pending`, `created_at`) VALUES ('".$stock['vendor_id']."', '".$stock['invoice_number']."', '".$stock['total_charge']."', '".$stock['amount_paid']."', '".$stock['payment_mode']."', '".$stock['pending_due']."','".$mysqltime."')";
    $query = mysqli_query($db, $sql);

    return $id;
}

function updateStockProduct($db, $val, $stock_id, $stock)
{
    $sql = '';
    foreach ($val as $key => $value) {

        $product_id = $value['salon_product_id'];
        $product = $value['product'];
        $volume = $value['volume'];
        $unit = $value['volume_unit'];
        $mrp_price = $value['mrp_price'];
        $purchase_price = $value['purchase_price'];
        $sale_price = $value['sale_price'];
        $quantity = $value['quantity'];
        $exp_date = $value['exp_date'];
        $total_price = $value['total_price'];
        $stock_record_id = $value['stock_record_id'];

        $stockAvailableSql = "SELECT * FROM stock WHERE product_id='{$product_id}'";
        $stockAvailable = num_rows($db, $stockAvailableSql);

        $invoice = $stock['invoice_number'];

        if ($stockAvailable == 0) {
            $sql = mysqli_query($db, "INSERT INTO `stock`(`stock_purchase_id`, `product_id`, `volume`, `unit`, `mrp_price`, `purchase_price`, `sale_price`, `quantity`, `exp_date`, `total_price`) VALUES ('{$stock_id}', '{$product_id}', '{$volume}', '{$unit}', '{$mrp_price}', '{$purchase_price}', '{$sale_price}', '{$quantity}', '{$exp_date}', '{$total_price}')");
            $stock_main_id = mysqli_insert_id($db);
        } else {
            $oldModel = fetch_object($db, $stockAvailableSql);
            $stock_main_id = $oldModel->id;
        }

        $createdAt = date('Y-m-d H:i:s', time());

        $purchaseModel = fetch_object($db, "SELECT * FROM stock_purchase WHERE id='{$stock_id}'");

        if(empty($stock_record_id)){
            $stockRecordSql = "INSERT INTO `stock_record`(`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `credit`, `created_at`) VALUES ('{$branch_id}', '{$stock_main_id}', '{$purchaseModel->vendor_id}', 'Inventory Purchase', '{$invoice}', '{$quantity}', '{$createdAt}')"; 
        }else{
            $stockRecordSql = "UPDATE `stock_record` SET `stock_main_id{$stock_main_id}',`vendor_client_service_provider_id`='{$purchaseModel->vendor_id}',`invoice`='{$invoice}',`credit`='{$quantity}',`updated_at`='{$createdAt}' WHERE id={$stock_record_id}";
        }
        $q = mysqli_query($db, $stockRecordSql);

        $stock_record_id1 = empty($stock_record_id) ? mysqli_insert_id($db) : $stock_record_id;

        $stockPurchaseSql = empty($stock_record_id) ? "INSERT INTO `stock_purchase_product`(`stock_record_id`, `stock_purchase_id`, `product_id`, `volume`, `unit`, `mrp_price`, `purchase_price`, `sale_price`, `quantity`, `exp_date`, `total_price`) VALUES ('".$stock_record_id1."', '{$stock_id}', '{$product_id}', '{$volume}', '{$unit}', '{$mrp_price}', '{$purchase_price}', '{$sale_price}', '{$quantity}', '{$exp_date}', '{$total_price}')" : "UPDATE `stock_purchase_product` SET `stock_record_id`='{$stock_record_id1}',`stock_purchase_id`='{$stock_id}',`product_id`='{$product_id}',`volume`='{$volume}',`unit`='{$unit}',`mrp_price`='{$mrp_price}',`purchase_price`='{$purchase_price}',`sale_price`='{$sale_price}',`quantity`='{$quantity}',`exp_date`='{$exp_date}',`total_price`='{$total_price}' WHERE stock_record_id1='{$stock_record_id1}'";
        mysqli_query($db, $stockPurchaseSql);
    }

    return true;
}

function addProductVendor($db, $value)
{
    $sql = '';
    $vendor_name = $value['vendor_name'];
    $contact = $value['contact'];
    $gst_number = $value['gst_number'];
    $createdAt = date('Y-m-d H:i:s', time());
    $sql = "INSERT INTO `vendor`(`vendor_name`, `contact`, `gst_number`, `created_at`) VALUES ('{$vendor_name}', '{$contact}', '{$gst_number}', '{$createdAt}')";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($stock['vendor_id'])) {
        $stock = $_POST['stock'];
        $vendor_id = addProductVendor($db, $stock);
        $stock['vendor_id'] = $vendor_id;
    }

    $stock_id = updateStock($db, $stock);
    $m = updateStockProduct($db, $stockProductDetails, $stock_id, $stock);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
