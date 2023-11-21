<?php
include('../../lib/db.php');
throw_exception();

extract($_REQUEST);

$errors = [];
$data = [];


function checkProductName($db, $value)
{
    $sql = "SELECT * FROM `stock_purchase` WHERE invoice_number='" . $value . "'";
    $query = mysqli_query($db, $sql);
    return (mysqli_num_rows($query) > 0) ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = checkProductName($db, $value);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
