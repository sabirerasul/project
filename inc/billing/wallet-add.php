<?php
include('../../lib/db.php');
include('../../lib/sms-config.php');
include('../../lib/whatsapp-sms-config.php');
include('../../lib/mail-config.php');
throw_exception();

$wallet = $_REQUEST['wallet'];
$client = $_REQUEST['client'];
$wallet['branch_id'] = $client['branch_id'];

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

function addClient($db, $client)
{
    $k = "`branch_id`, `client_name`,`contact`,`gender`";
    $val = "'" . $client['branch_id'] . "', '" . $client['client_name'] . "', '" . $client['contact'] . "', '" . $client['gender'] . "'";

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `client` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function addWallet($db, $model)
{

    extract($model);

    $transaction_type = "Credit";
    $amount_receive_from = "Add_wallet";

    $created_at = date('Y-m-d H:i:s', time());

    $k = "`branch_id`, `client_id`, `date`, `transaction_type`, `paid_amount`, `amount`, `payment_method`, `amount_receive_from`, `notes`, `created_at`";
    $val = "'{$branch_id}', '{$client_id}', '{$date}', '{$transaction_type}', '{$paid_amount}', '{$amount}', '{$payment_method}', '{$amount_receive_from}', '{$notes}', '{$created_at}'";


    $sql = "INSERT INTO `client_wallet` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);

    $last_id = mysqli_insert_id($db);

    return $last_id;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($wallet['client_id'])) {
        $client_id = addClient($db, $client);
        $wallet['client_id'] = $client_id;
    }
    $wallet_id = addWallet($db, $wallet);

    $available = get_client_wallet($db, $wallet['client_id']);
    walletSMS($db, $wallet_id, $available, 17);
    walletWASMS($db, $wallet_id, $available);
    walletMail($db, $wallet_id, $available);

    $m = !empty($wallet_id) ? true : false;

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
