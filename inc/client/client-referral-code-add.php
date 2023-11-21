<?php
include('../../lib/db.php');
throw_exception();

$value = $_REQUEST;


$errors = [];
$data = [];

function addReferral($db, $value)
{
    $client_id = $value['client_id'];
    $referral_code = get_referral_code($db, $client_id);
    $created_at = date('Y-m-d H:i:s', time());

    $sql1 = "SELECT * FROM `client_referral_code` WHERE client_id='{$client_id}'";

    $numRows = num_rows($db, $sql1);

    if ($numRows == 0) {
        $sql = "INSERT INTO `client_referral_code`(`client_id`, `referral_code`, `created_at`) VALUES ('{$client_id}','{$referral_code}','{$created_at}')";
        $query2 = mysqli_query($db, $sql);
        $model = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE client_id='{$client_id}'");
        $referral = $model->referral_code;
    } else {
        $model = fetch_object($db, $sql1);
        $referral = $model->referral_code;
    }

    return $referral;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addReferral($db, $value);

    if (!empty($m)) {
        $data['success'] = true;
        $data['data'] = $m;
    } else {
        $data['success'] = false;
        $data['data'] = '';
    }
    $data['data'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
