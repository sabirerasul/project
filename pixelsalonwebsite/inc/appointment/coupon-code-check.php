<?php
require_once "../../lib/db.php";

extract($_REQUEST);
$couponModel = fetch_object($db, "SELECT * FROM `coupon` WHERE coupon_code='{$coupon_code}'");
$error = '';
$array = [];

if (!empty($couponModel)) {

    if ($client_id != 0) {
        $couponCodeClientNum = num_rows($db, "SELECT * FROM `client_coupon_code_use_history` WHERE `coupon_code_id`='{$couponModel->id}' AND `client_id`='{$client_id}'");
        if ($couponCodeClientNum >= $couponModel->coupon_per_user) {
            $error = "Coupon Applied Maximum Time";
        }
    }

    if ($sub_total < $couponModel->min_bill_amount) {
        $error = "Min Bill Amount {$couponModel->min_bill_amount}";
    }

    if (getDateServerFormat($couponModel->valid_till) < getDateServerFormat(todayDate())) {
        $error = "Coupon Code expired";
    }
} else {
    $error = "Invalid Coupon Code";
}

$array['status'] = empty($error) ? true : false;
$array['error'] = $error;

$array['modal'] = empty($error) ? $couponModel : '';

echo json_encode($array);


// 0 = invalid code
// 1 = already used
// 2 = applied
