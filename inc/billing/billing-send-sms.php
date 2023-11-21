<?php
include('../../lib/db.php');
include('../../lib/sms-config.php');
throw_exception();

$invoice_number = $_POST['invoice_number'];

$errors = [];
$data = [];

if (empty($invoice_number)) {
    $errors['error'] = 'Invoice Number is required.';
}

function sendSMS($db, $invoice_number)
{
    $model = fetch_object($db, "SELECT * FROM client_billing WHERE `invoice_number`='{$invoice_number}'");
    $response = false;
    if (!empty($model)) {
        $response = invoiceSMS($db, $model->id, 5);
    }

    return $response ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = sendSMS($db, $invoice_number);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
