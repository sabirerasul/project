<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$client = $_POST['client'];
$appointment = $_POST['appointment'];
$appointment['branch_id'] = $client['branch_id'];
$appointment_service = $_POST['appointment_service'];
$appointment_advance_payment = $_POST['appointment_advance_payment'];

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

function addAppointment($db, $appointment)
{
    $k = '';
    foreach ($appointment as $key => $value) {
        if ($key != 'id') {
            $k .=  "`{$key}`='{$value}', ";
        }
    }

    $k = rtrim($k, ',');

    $updated_at = date('Y-m-d H:i:s', time());
    $k = $k . "`updated_at`='{$updated_at}'";

    $sql = "UPDATE `appointment` SET {$k} WHERE id='{$appointment['id']}'";

    $query = mysqli_query($db, $sql);
    //$last_id = mysqli_insert_id($db);

    return $appointment['id'];
}

function addAppointmentService($db, $val, $appointment_id)
{
    $sql = '';

    $oldModel = fetch_all($db, "SELECT id FROM `appointment_service` WHERE `appointment_id`='{$appointment_id}'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($val, 'id');
    $delKey = array_diff($oldSId, $newSId);
    //$addKey = array_diff($newSId, $oldSId);
    $delStringKey = implode(',', $delKey);
    $delStringKey = ($delStringKey != '') ? $delStringKey : 0;
    if ($delStringKey != 0) {
        $delete_sql = ("DELETE FROM `appointment_service` WHERE id in($delStringKey) AND appointment_id='{$appointment_id}'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    foreach ($val as $key => $value) {

        $id = $value['id'];
        $service_cat_id = $value['service_cat_id'];
        $service_id = $value['service_id'];
        $service_discount = $value['service_discount'];
        $service_discount_type = $value['service_discount_type'];
        $sp_id = $value['sp_id'];
        $start_time = $value['start_time'];
        $end_time = $value['end_time'];

        $start_timestamp = $value['start_timestamp'];
        $end_timestamp = $value['end_timestamp'];

        $price = $value['price'];

        if (empty($id)) {
            $sql = "INSERT INTO `appointment_service`(`appointment_id`, `service_cat_id`, `service_id`, `service_discount`, `service_discount_type`, `start_time`, `end_time`, `start_timestamp`, `end_timestamp`, `price`) VALUES ('" . $appointment_id . "', '" . $service_cat_id . "', '" . $service_id . "', '" . $service_discount . "', '" . $service_discount_type . "', '" . $start_time . "', '" . $end_time . "', '" . $start_timestamp . "', '" . $end_timestamp . "', '" . $price . "')";
        } else {
            $sql = "UPDATE `appointment_service` SET `service_cat_id`='{$service_cat_id}', `service_id`='{$service_id}', `service_discount`='{$service_discount}', `service_discount_type`='{$service_discount_type}', `start_time`='{$start_time}', `end_time`='{$end_time}', `start_timestamp`='{$start_timestamp}', `end_timestamp`='{$end_timestamp}', `price`='{$price}' WHERE id='{$id}'";
        }

        $query = mysqli_query($db, $sql);

        $appointment_service_id = empty($id) ? mysqli_insert_id($db) : $id;

        $oldModel1 = fetch_all($db, "SELECT id FROM appointment_assign_service_provider WHERE `appointment_id`='{$appointment_id}' AND appointment_service_id='{$appointment_service_id}'");
        $oldSId1 = array_column($oldModel1, 'id');


        $newSId1 = array_column($sp_id, 'id');
        $delKey1 = array_diff($oldSId1, $newSId1);
        //$addKey = array_diff($newSId, $oldSId);
        $delStringKey1 = implode(',', $delKey1);
        $delStringKey1 = ($delStringKey1 != '') ? $delStringKey1 : 0;
        if ($delStringKey1 != 0) {
            $delete_sql1 = ("DELETE FROM appointment_assign_service_provider WHERE id in($delStringKey1) AND appointment_id='{$appointment_id}'");
            $delete_query = mysqli_query($db, $delete_sql1);
        }

        foreach ($sp_id as $spkey => $sp_id_value) {
            $assignSql1 = "UPDATE `appointment_assign_service_provider` SET `appointment_service_id`='{$appointment_service_id}', `service_provider_id`='{$sp_id_value['service_provider_id']}' WHERE id='{$sp_id_value['id']}'";
            $assignSql2 = "INSERT INTO `appointment_assign_service_provider`(`appointment_id`, `appointment_service_id`, `service_provider_id`) VALUES ('{$appointment_id}','{$appointment_service_id}','{$sp_id_value['service_provider_id']}')";

            $assignSql = (!empty($sp_id_value['id'])) ? $assignSql1 : $assignSql2;
            $query2 = mysqli_query($db, $assignSql);
        }
    }
    return $query2 ? true : false;
}

function addAppointmentAdvancePayment($db, $val, $appointment_id)
{

    $oldModel = fetch_all($db, "SELECT id FROM appointment_advance_payment WHERE `appointment_id`='{$appointment_id}'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($val, 'id');
    $delKey = array_diff($oldSId, $newSId);
    //$addKey = array_diff($newSId, $oldSId);
    $delStringKey = implode(',', $delKey);
    $delStringKey = ($delStringKey != '') ? $delStringKey : 0;
    if ($delStringKey != 0) {
        $delete_sql = ("DELETE FROM appointment_advance_payment WHERE id in($delStringKey) AND appointment_id='{$appointment_id}'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    $sql = '';
    foreach ($val as $key => $value) {
        $transaction_id = $value['transaction_id'];
        $advance = $value['advance'];
        $method = $value['method'];
        $id = $value['id'];

        if (empty($id)) {
            
            if ($method == 7) {
                client_wallet_debit($db, $value, $appointment_id, 'app');
            }
            if($method == 9){
                subtractRewardPoint($db, $advance, $appointment_id, 'app');
            }
        }

        $sql1 = "UPDATE `appointment_advance_payment` SET `transaction_id`='{$transaction_id}', `advance`='{$advance}', `method`='{$method}' WHERE id='{$id}'";
        $sql2 = "INSERT INTO `appointment_advance_payment`(`appointment_id`, `transaction_id`, `advance`, `method`) VALUES ('{$appointment_id}', '{$transaction_id}', '{$advance}', '{$method}')";
        $sql = !empty($id) ? $sql1 : $sql2;
        $query = mysqli_query($db, $sql);
    }
    return $sql1 ? true : false;
}

function addPaymentHistory($db, $appointment, $appointment_id)
{
    extract($appointment);

    $created_at = date('Y-m-d H:i:s', time());

    $advance = ($total - $pending_due);

    $sql = "UPDATE `pending_payment_history` SET `date`='{$appointment_date}', `branch_id`='{$branch_id}', `client_id`='{$client_id}', `app_bill_id`='{$appointment_id}', `total`='{$total}', `advance`='{$advance}', `pending`='{$pending_due}', `paid_branch_id`='{$branch_id}', `updated_at`='{$created_at}' WHERE `app_bill_id`='{$appointment_id}'";
    mysqli_query($db, $sql);
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($appointment['client_id'])) {
        $client_id = addClient($db, $client);
        $appointment['client_id'] = $client_id;
    }
    $appointment_id = addAppointment($db, $appointment);

    $m2 = addAppointmentService($db, $appointment_service, $appointment_id);

    $m = addAppointmentAdvancePayment($db, $appointment_advance_payment, $appointment_id);
    addPaymentHistory($db, $appointment, $appointment_id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
