<?php
require_once "../../lib/db.php";
extract($_REQUEST);
$billingModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE invoice_number='{$invoice_number}'");
$error = '';
$array = [];

if (!empty($billingModel)) {

    $clientModel = fetch_object($db, "SELECT * FROM `client` WHERE id='{$billingModel->client_id}'");

    $model = [
        'client_id' => $billingModel->client_id,
        'client_name' => $clientModel->client_name,
        'branch_id' => $billingModel->branch_id,
        'email' => $clientModel->email,
    ];
    $feedbackModel = num_rows($db, "SELECT * FROM `feedback` WHERE invoice_number='{$invoice_number}' AND client_id='{$billingModel->client_id}'");
    if ($feedbackModel != 0) {
        $error = "Feedback already submitted for this Invoice";
    }
} else {
    $error = "Invalid Invoice Number";
}

$array['status'] = empty($error) ? true : false;
$array['error'] = $error;

$array['modal'] = empty($error) ? $model : '';

echo json_encode($array);


// 0 = invalid code
// 1 = already used
// 2 = applied
