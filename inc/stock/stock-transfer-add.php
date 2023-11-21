<?php
include('../../lib/db.php');

throw_exception();


$rawData = $_POST['stockTransfer'];

$errors = [];
$data = [];





function addStockTransfer($db, $val)
{
    $sql = '';

    $login_branch_id = BRANCHID;
    $stock_main_id = $val['id'];
    $quantity = $val['quantity'];
    $createdAt = date('Y-m-d H:i:s', time());
    $branch_id = $val['branch'];
    
    $loginBranchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$login_branch_id}'");
    $transferBranchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$login_branch_id}'");

    $type1 = "Transferred";
    $type2 = "Received";

    $invoice = rand(0, 99999);

    $sql1 = "`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `debit`, `created_at`";
    $sql2 = "`branch_id`, `stock_main_id`, `vendor_client_service_provider_id`, `type`, `invoice`, `credit`, `created_at`";

    $sqlValue1 = "'{$login_branch_id}', '{$stock_main_id}', '{$branch_id}', '{$type1}', '{$invoice}', '{$quantity}', '{$createdAt}'";
    $sqlValue2 = "'{$branch_id}', '{$stock_main_id}', '{$login_branch_id}', '{$type2}', '{$invoice}', '{$quantity}', '{$createdAt}'";

    $query1 = mysqli_query($db, "INSERT INTO `stock_record`({$sql1}) VALUES ({$sqlValue1})");
    //$query = mysqli_insert_id($db);

    $query2 = mysqli_query($db, "INSERT INTO `stock_record`({$sql2}) VALUES ({$sqlValue2})");
    //$stock_record_id = mysqli_insert_id($db);


    return true;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = addStockTransfer($db, $rawData);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
