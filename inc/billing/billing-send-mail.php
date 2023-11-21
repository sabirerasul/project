<?php
include('../../lib/db.php');
include('../../lib/mail-config.php');
throw_exception();

$invoice_number = $_POST['invoice_number'];

$errors = [];
$data = [];

if (empty($invoice_number)) {
    $errors['error'] = 'Invoice Number is required.';
}

function sendMail($db, $invoice_number, $discountArr)
{
    $model = fetch_object($db, "SELECT * FROM client_billing WHERE `invoice_number`='{$invoice_number}'");
    $response = false;
    if (!empty($model)) {
        $response = invoiceMail($db, $model->id, $discountArr);
    }

    return $response ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = sendMail($db, $invoice_number, $discountArr);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
