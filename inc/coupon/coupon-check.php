<?php
include('../../lib/db.php');
throw_exception();


extract($_REQUEST);

$errors = [];
$data = [];

function checkCoupon($db, $value)
{
    $sql = "SELECT * FROM `coupon` WHERE coupon_code='" . $value . "'";
    $query = mysqli_query($db, $sql);
    return (mysqli_num_rows($query) > 0) ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = checkCoupon($db, $value);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
