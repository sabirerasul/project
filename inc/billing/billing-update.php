<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$client = $_POST['client'];
$billing = $_POST['billing'];
$billing['branch_id'] = $client['branch_id'];
$billing_product = $_POST['billing_product'];
$billing_payment = $_POST['billing_payment'];

$errors = [];
$data = [];

/*
if (empty($_REQUEST['product'])) {
    $errors['error'] = 'product is required.';
}

if (empty($_REQUEST['volume'])) {
    $errors['error'] = 'Volume is required.';
}

if (empty($_REQUEST['unit'])) {
    $errors['error'] = 'Unit is required.';
}

if (empty($_REQUEST['price'])) {
    $errors['error'] = 'Price is required.';
}

if (empty($_REQUEST['exp_date'])) {
    $errors['error'] = 'Expiry Date is required.';
}*/

function addClient($db, $client)
{
    $k = "`branch_id`, `client_name`,`contact`,`gender`,`dob`,`anniversary`,`source_of_client`";
    $val = "'{$client['branch_id']}', '" . $client['client_name'] . "', '" . $client['contact'] . "', '" . $client['gender'] . "', '" . $client['dob'] . "', '" . $client['anniversary'] . "', '" . $client['source_of_client'] . "'";

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `client` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function updateBilling($db, $billing)
{
    $k = '';
    foreach ($billing as $key => $value) {
        if ($key != 'id') {
            $k .=  "`{$key}`='{$value}', ";
        }
    }

    $k = rtrim($k, ',');

    $updated_at = date('Y-m-d H:i:s', time());
    $k = $k . "`updated_at`='{$updated_at}'";

    $sql = "UPDATE `client_billing` SET {$k} WHERE id='{$billing['id']}'";

    $query = mysqli_query($db, $sql);
    //$last_id = mysqli_insert_id($db);

    return $billing['id'];
}

function updateBillingProduct($db, $billing_product, $billing_id)
{
    $sql = '';

    $oldModel = fetch_all($db, "SELECT id FROM client_billing_product WHERE `billing_id`='{$billing_id}'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($billing_product, 'id');
    $delKey = array_diff($oldSId, $newSId);
    //$addKey = array_diff($newSId, $oldSId);
    $delStringKey = implode(',', $delKey);
    $delStringKey = ($delStringKey != '') ? $delStringKey : 0;
    if ($delStringKey != 0) {
        $delete_sql = ("DELETE FROM client_billing_product WHERE id in($delStringKey) AND appointment_id='{$billing_id}'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    foreach ($billing_product as $key => $value) {

        $id = $value['id'];
        $service_cat_id = !empty($value['service_cat_id']) ? $value['service_cat_id'] : 0;
        $service_id = $value['service_id'];
        $service_type = $value['service_type'];
        $quantity = $value['quantity'];
        $service_discount = $value['service_discount'];
        $service_discount_type = $value['service_discount_type'];
        $sp_id = $value['sp_id'];
        $start_time = $value['start_time'];
        $end_time = $value['end_time'];

        $start_timestamp = $value['start_timestamp'];
        $end_timestamp = $value['end_timestamp'];

        $price = $value['price'];



        if (empty($id)) {
            $sql = "INSERT INTO `client_billing_product`(`billing_id`, `service_cat_id`, `service_id`, `service_type`, `quantity`, `service_discount`, `service_discount_type`, `start_time`, `end_time`, `start_timestamp`, `end_timestamp`, `price`) VALUES ('{$billing_id}', '{$service_cat_id}', '{$service_id}', '{$service_type}', '{$quantity}', '{$service_discount}', '{$service_discount_type}', '{$start_time}', '{$end_time}', '{$start_timestamp}', '{$end_timestamp}', '{$price}')";
        } else {
            $sql = "UPDATE `client_billing_product` SET `service_cat_id`='{$service_cat_id}', `service_id`='{$service_id}', `service_type`='{$service_type}', `quantity`='{$quantity}', `service_discount`='{$service_discount}', `service_discount_type`='{$service_discount_type}', `start_time`='{$start_time}', `end_time`='{$end_time}', `start_timestamp`='{$start_timestamp}', `end_timestamp`='{$end_timestamp}', `price`='{$price}' WHERE id='{$id}'";
        }

        $query = mysqli_query($db, $sql);

        $billing_service_id = empty($id) ? mysqli_insert_id($db) : $id;


        $oldModel1 = fetch_all($db, "SELECT id FROM client_billing_assign_service_provider WHERE `billing_id`='{$billing_id}' AND billing_service_id='{$billing_service_id}'");
        $oldSId1 = array_column($oldModel1, 'id');


        $newSId1 = array_column($sp_id, 'id');
        $delKey1 = array_diff($oldSId1, $newSId1);
        //$addKey = array_diff($newSId, $oldSId);
        $delStringKey1 = implode(',', $delKey1);
        $delStringKey1 = ($delStringKey1 != '') ? $delStringKey1 : 0;
        if ($delStringKey1 != 0) {
            $delete_sql1 = ("DELETE FROM client_billing_assign_service_provider WHERE id in($delStringKey1) AND billing_id='{$billing_id}'");
            $delete_query = mysqli_query($db, $delete_sql1);
        }

        foreach ($sp_id as $spkey => $sp_id_value) {

            $serviceProviderId = $sp_id_value['service_provider_id'];

            if (empty($serviceProviderId)) {
                continue;
            }

            $assignSql1 = "UPDATE `client_billing_assign_service_provider` SET `billing_service_id`='{$billing_service_id}', `service_provider_id`='{$sp_id_value['service_provider_id']}' WHERE id='{$sp_id_value['id']}'";
            $assignSql2 = "INSERT INTO `client_billing_assign_service_provider`(`billing_id`, `billing_service_id`, `service_provider_id`) VALUES ('{$billing_id}','{$billing_service_id}','{$sp_id_value['service_provider_id']}')";

            $assignSql = (!empty($sp_id_value['id'])) ? $assignSql1 : $assignSql2;
            $query2 = mysqli_query($db, $assignSql);
        }
    }

    return $query2 ? true : false;
}

function updateBillingPayment($db, $val, $billing_id)
{

    $oldModel = fetch_all($db, "SELECT id FROM client_billing_payment WHERE `billing_id`='{$billing_id}'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($val, 'id');
    $delKey = array_diff($oldSId, $newSId);
    //$addKey = array_diff($newSId, $oldSId);
    $delStringKey = implode(',', $delKey);
    $delStringKey = ($delStringKey != '') ? $delStringKey : 0;
    if ($delStringKey != 0) {
        $delete_sql = ("DELETE FROM client_billing_payment WHERE id in($delStringKey) AND billing_id='{$billing_id}'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    $sql = '';
    foreach ($val as $key => $value) {
        $transaction_id = $value['transaction_id'];
        $advance = $value['advance'];
        $method = $value['method'];
        $id = $value['id'];

        $sql1 = "UPDATE `client_billing_payment` SET `transaction_id`='{$transaction_id}', `advance`='{$advance}', `method`='{$method}' WHERE id='{$id}'";
        $sql2 = "INSERT INTO `client_billing_payment`(`billing_id`, `transaction_id`, `advance`, `method`) VALUES ('{$billing_id}', '{$transaction_id}', '{$advance}', '{$method}')";
        $sql = !empty($id) ? $sql1 : $sql2;
        $query = mysqli_query($db, $sql);

        if (empty($id)) {

            if ($method == 7) {
                client_wallet_debit($db, $value, $billing_id, 'bill');
            }

            if ($method == 9) {
                subtractRewardPoint($db, $advance, $billing_id, 'bill');
            }
        }
    }
    return $sql1 ? true : false;
}


function addPaymentHistory($db, $billing_id)
{
    $created_at = date('Y-m-d H:i:s', time());

    $model = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'");

    $paid = (($model->total - $model->advance_receive) - $model->pending_amount);
    $sql = "UPDATE `pending_payment_history` SET `date`='{$model->billing_date}', `total`='{$model->total}', `advance`='{$model->advance_receive}', `paid`='{$paid}', `pending`='{$model->pending_amount}', `paid_branch_id`='{$model->branch_id}', `updated_at`='{$created_at}' WHERE `app_bill_id`='{$model->id}' AND `appointment_id`='{$model->appointment_id}'";
    mysqli_query($db, $sql);
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($billing['client_id'])) {
        $client_id = addClient($db, $client);
        $billing['client_id'] = $client_id;
    }
    $billing_id = updateBilling($db, $billing);

    $m2 = updateBillingProduct($db, $billing_product, $billing_id);
    $m = updateBillingPayment($db, $billing_payment, $billing_id);
    addPaymentHistory($db, $billing_id);

    $invoice_number = !empty($billing_id) ? fetch_object($db, "SELECT * FROM client_billing WHERE id='{$billing_id}'")->invoice_number : '0';

    //invoiceSMS($db, $billing_id, 5);

    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['data'] = $invoice_number;
}

echo json_encode($data);
