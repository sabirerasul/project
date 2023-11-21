<?php
include('../../lib/db.php');

throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];
$id = $_REQUEST['id'];

if (empty($_REQUEST['id'])) {
    $errors['error'] = 'id is required.';
}


function deleteProductInSalon($db, $id)
{
    $model = fetch_object($db, "SELECT * FROM product_use_in_salon WHERE id='{$id}'");

    $productUseInSalonStockRecord = fetch_object($db, "SELECT * FROM product_use_in_salon_stock_record WHERE product_use_in_salon_id='{$id}'");

    mysqli_query($db, "DELETE FROM `stock_record` WHERE id='{$productUseInSalonStockRecord->stock_record_id}'");

    $sql = "DELETE FROM `product_use_in_salon` WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deleteProductInSalon($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
