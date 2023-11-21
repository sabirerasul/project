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


function deletePayment($db, $id){


    $model = fetch_object($db, "SELECT * FROM `pending_payment_history` WHERE id='{$id}'");

    $billingModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE id='{$model->app_bill_id}'");

    $paid = $model->paid;
    $mode = $model->payment_mode;
    
    $billingPayment = fetch_object($db, "SELECT * FROM `client_billing_payment` WHERE billing_id='{$model->app_bill_id}' AND method='{$mode}'");
    
    if (!empty($billingPayment)) {
        $advance = ($billingPayment->advance - $paid);
        $sql2 = "UPDATE `client_billing_payment` SET `advance`='{$advance}' WHERE id='{$billingPayment->id}'";
        mysqli_query($db, $sql2);
    }

    $actualPending = $billingModel->pending_amount + $paid;
    $sql3 = "UPDATE `client_billing` SET `pending_amount`='{$actualPending}' WHERE id='{$model->app_bill_id}'";
    mysqli_query($db, $sql3);

    $sql = "DELETE FROM `pending_payment_history` WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $query ? true:false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = deletePayment($db, $id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
