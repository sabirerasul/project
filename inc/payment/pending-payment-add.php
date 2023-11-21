<?php
include('../../lib/db.php');
include('../../lib/mail-config.php');
throw_exception();

$id = $_REQUEST['id'];
$paid = $_REQUEST['paid'];
$mode = $_REQUEST['mode'];

// if(!isset($v['send_receipt'])){
//     $v['send_receipt'] = 'no';
// }

$errors = [];
$data = [];

/*
if (empty($_REQUEST['client_name'])) {
    $errors['error'] = 'Name is required.';
}else{
    if(validName($_REQUEST['client_name']) == false){
        $errors['error'] = 'Name is not valid.';
    }
}

if (empty($_REQUEST['contact'])) {
    $errors['error'] = 'Mobile is required.';
}else{
    if(validNumber($_REQUEST['contact']) == false){
        $errors['error'] = 'Number is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT contact FROM client WHERE contact='".$_REQUEST['contact']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Number is already registered.';
        }
    }
}


if (!empty($_REQUEST['email'])) {
    if(validEmail($_REQUEST['email']) == false){
        $errors['error'] = 'Email is not valid.';
    }else{
        $sql = mysqli_query($db, "SELECT email FROM client WHERE email='".$_REQUEST['email']."'");
        if(mysqli_num_rows($sql) > 0){
            $errors['error'] = 'Email is already registered.';
        }
    }
}
*/

function addPayment($db, $id, $paid, $mode)
{

    $model = fetch_object($db, "SELECT * FROM `pending_payment_history` WHERE id='{$id}'");

    $billingModel = fetch_object($db, "SELECT * FROM `client_billing` WHERE id='{$model->app_bill_id}'");

    $created_at = date('Y-m-d H:i:s', time());
    $pending = $model->pending - $paid;
    $date = todayDate();

    $key = "`date`, `branch_id`, `client_id`, `app_bill_id`, `total`, `advance`, `paid`, `pending`, `payment_mode`, `appointment_id`, `bill_type`, `paid_branch_id`, `created_at`";
    $value = "'{$date}', '{$model->branch_id}', '{$model->client_id}', '{$model->app_bill_id}', 0, 0, '{$paid}', '{$pending}', '{$mode}', 0, 'pending payment', '{$model->branch_id}', '{$created_at}'";

    $sql = "INSERT INTO `pending_payment_history`({$key}) VALUES ({$value})";

    $billingPayment = fetch_object($db, "SELECT * FROM `client_billing_payment` WHERE billing_id='{$model->app_bill_id}' AND method='{$mode}'");
    if (!empty($billingPayment)) {
        $advance = $paid + $billingPayment->advance;
        $sql2 = "UPDATE `client_billing_payment` SET `advance`='{$advance}' WHERE id='{$billingPayment->id}'";
    } else {
        $sql2 = "INSERT INTO `client_billing_payment` (`billing_id`, `transaction_id`, `advance`, `method`) VALUES ('{$model->app_bill_id}', '', '{$paid}', '{$mode}')";
    }

    mysqli_query($db, $sql2);

    $actualPending = $billingModel->pending_amount - $paid;
    $sql3 = "UPDATE `client_billing` SET `pending_amount`='{$actualPending}' WHERE id='{$model->app_bill_id}'";
    mysqli_query($db, $sql3);

    $query = mysqli_query($db, $sql);

    $last_id = mysqli_insert_id($db);

    $dueAmount = get_client_pending_amount($db, $model->client_id);

    pendingDueMail($db, $last_id, $dueAmount);

    if ($mode == 7) {
        $payModel = [
            'id' => '',
            'transaction_id' => '', 
            'advance' => $paid,
            'method' => $mode
        ];
        client_wallet_debit($db, $payModel, $model->app_bill_id, 'bill');
    }

    if ($mode == 9) {
        subtractRewardPoint($db, $paid, $model->app_bill_id, 'bill');
    }

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addPayment($db, $id, $paid, $mode);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
