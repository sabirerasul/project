<?php
include('../../lib/db.php');
include('../../lib/sms-config.php');
include('../../lib/whatsapp-sms-config.php');
include('../../lib/mail-config.php');
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
    $val = '';
    foreach ($appointment as $key => $value) {
        if ($key != 'id') {
            $k .=  "`" . $key . "`,";
            $val .=  "'" . $value . "',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `appointment` ({$k}) VALUES ({$val})";


    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function addAppointmentService($db, $val, $appointment_id)
{
    $sql = '';
    foreach ($val as $key => $value) {

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

        $sql = "INSERT INTO `appointment_service`(`appointment_id`, `service_cat_id`, `service_id`, `service_discount`, `service_discount_type`, `start_time`, `end_time`, `start_timestamp`, `end_timestamp`, `price`) VALUES ('" . $appointment_id . "', '" . $service_cat_id . "', '" . $service_id . "', '" . $service_discount . "', '" . $service_discount_type . "', '" . $start_time . "', '" . $end_time . "', '" . $start_timestamp . "', '" . $end_timestamp . "', '" . $price . "')";
        $query = mysqli_query($db, $sql);

        $appointment_service_id = mysqli_insert_id($db);

        foreach ($sp_id as $spkey => $sp_id_value) {
            $sql2 = "INSERT INTO `appointment_assign_service_provider`(`appointment_id`, `appointment_service_id`, `service_provider_id`) VALUES ('{$appointment_id}','{$appointment_service_id}','{$sp_id_value['service_provider_id']}')";
            //$sql2 = "INSERT INTO `appointment_assign_service_provider`(`appointment_id`, `appointment_service_id`, `service_provider_id`) VALUES ('{$appointment_id}','{$appointment_service_id}','{$sp_id_value}')";
            $query2 = mysqli_query($db, $sql2);
        }
    }

    return true;
}

function addAppointmentAdvancePayment($db, $val, $appointment_id)
{
    $sql = '';
    foreach ($val as $key => $value) {
        $transaction_id = $value['transaction_id'];
        $advance = $value['advance'];
        $method = $value['method'];

        if ($method == 7) {
            client_wallet_debit($db, $value, $appointment_id, 'app');
        }
        if($method == 9){
            subtractRewardPoint($db, $advance, $appointment_id, 'app');
        }
        
        $sql .= "('" . $appointment_id . "', '" . $transaction_id . "', '" . $advance . "', '" . $method . "'), ";
    }

    $sql = rtrim($sql, ', ');

    $sq = "INSERT INTO `appointment_advance_payment`(`appointment_id`, `transaction_id`, `advance`, `method`) VALUES ";

    $sql = $sq . $sql;

    $query = mysqli_query($db, $sql);
    return $query ? true : false;
}

function addPaymentHistory($db, $appointment, $appointment_id)
{
    extract($appointment);

    $created_at = date('Y-m-d H:i:s', time());

    $advance = ($total - $pending_due);
    $sql = "INSERT INTO `pending_payment_history`(`date`, `branch_id`, `client_id`, `app_bill_id`, `total`, `advance`, `paid`, `pending`, `bill_type`, `paid_branch_id`, `created_at`) 
            VALUES ('{$appointment_date}', '{$branch_id}', '{$client_id}', '{$appointment_id}', '{$total}','{$advance}',0,'{$pending_due}', 'appointment', '{$branch_id}', '{$created_at}')";
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
    appointmentSMS($db, $appointment_id, 2);
    appointmentWASMS($db, $appointment_id);
    appointmentMail($db, $appointment_id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
