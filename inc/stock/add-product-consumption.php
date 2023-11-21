<?php
include('../../lib/db.php');
throw_exception();

$product_consumption = isset($_POST['product_consumption']) ? $_POST['product_consumption'] : [];

$errors = [];
$data = [];

$branch_id = BRANCHID;


function addProductConsumption($db, $product_consumption)
{
    if (count($product_consumption)) {
        foreach ($product_consumption as $key => $value) {
            $service_provider_id = $value['service_provider_id'];
            $service_id = $value['service_id'];
            $product_id = $value['product_id'];
            $invoice_number = $value['invoice_number'];
            $quantity = $value['quantity'];
            $created_at = date('Y-m-d H:i:s', time());

            $stockModel = fetch_object($db, "SELECT * FROM stock WHERE product_id='{$product_id}'");
            if (empty($stockModel)) {
                continue;
            }

            $key = "`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `debit`, `created_at`";
            $value = "'{$branch_id}', '{$stockModel->id}', '{$service_provider_id}', 'Product Used', '{$invoice_number}', '{$quantity}', '{$created_at}'";
            $query = mysqli_query($db, "INSERT INTO `stock_record`({$key}) VALUES ({$value})");
        }
    }
    return true;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addProductConsumption($db, $product_consumption);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
