<?php
include('../../lib/db.php');

throw_exception();


$rawData = $_POST['product_use_in_salon'];

$errors = [];
$data = [];





function addProductUseInSalon($db, $val)
{
    $sql = '';
    foreach ($val as $key => $value) {

        $salon_product_id = $value['salon_product_id'];
        $quantity = $value['quantity'];
        $sp_id = $value['sp_id'];
        $remark = $value['remark'];
        $createdAt = date('Y-m-d H:i:s', time());

        $invoice = rand(0, 99999);
        $branch_id = BRANCHID;

        $query1 = mysqli_query($db, "INSERT INTO `stock_record`(`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `debit`, `created_at`) VALUES ('{$branch_id}', '{$salon_product_id}', '{$sp_id}', 'Product Used', '{$invoice}', '{$quantity}', '{$createdAt}')");
        $stock_record_id = mysqli_insert_id($db);

        $query2 = mysqli_query($db, "INSERT INTO `product_use_in_salon`(`branch_id`, `salon_product_id`, `quantity`, `service_provider_id`, `remark`, `created_at`) VALUES ('{$branch_id}', '{$salon_product_id}', '{$quantity}', '{$sp_id}', '{$remark}', '{$createdAt}')");
        $product_use_in_salon_id = mysqli_insert_id($db);

        $query2 = mysqli_query($db, "INSERT INTO `product_use_in_salon_stock_record`(`product_use_in_salon_id`, `stock_record_id`) VALUES ('{$product_use_in_salon_id}', '{$stock_record_id}')");
    }

    return true;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = addProductUseInSalon($db, $rawData);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
