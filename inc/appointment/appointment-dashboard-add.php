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
$appointment['appointment_source'] = "on call";
$appointment['service_for'] = '';
$appointment['discount'] = 0;
$appointment['discount_type'] = 'percentage';
$appointment_service = $_POST['appointment_service'];

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

function addAppointment($db, $appointment)
{
    $k = '';
    $val = '';
    foreach ($appointment as $key => $value) {

        $value = ($key == 'appointment_date') ? date("d/m/Y", strtotime($value)) : $value;
        $k .=  "`" . $key . "`,";
        $val .=  "'" . $value . "',";
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `appointment` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    //addRewardPoint($db, $last_id);

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
            $query2 = mysqli_query($db, $sql2);
        }
    }

    return true;
}

/*
function addRewardPoint($db, $appointment_id)
{
    $sql = "SELECT * FROM appointment WHERE id='" . $appointment_id . "'";
    $query = mysqli_query($db, $sql);
    $model = mysqli_fetch_object($query);

    if (($model->status == "Billed" || $model->pending_due == 0) and $model->total != 0) {
        $transaction_type = 'credit';
        $points = ($model->total * 0.01);
        $client_id = $model->client_id;

        $created_at = date('Y-m-d H:i:s', time());
        $rewardSql = "INSERT INTO `reward_point`(`appointment_id`, `client_id`, `points`, `transaction_type`, `created_at`) VALUES ('" . $appointment_id . "','" . $client_id . "','" . $points . "','" . $transaction_type . "', '" . $created_at . "')";
        $rewardQuery = mysqli_query($db, $rewardSql);
    }
}*/

/*
function subtractRewardPoint($db, $appointment_id, $point)
{
    $sql = "SELECT * FROM appointment WHERE id='" . $appointment_id . "'";
    $query = mysqli_query($db, $sql);
    $model = mysqli_fetch_object($query);

    $transaction_type = 'debit';
    $points = -$point;
    $client_id = $model->client_id;
    $created_at = date('Y-m-d H:i:s', time());
    $rewardSql = "INSERT INTO `reward_point`(`appointment_id`, `client_id`, `points`, `transaction_type`, `created_at`) VALUES ('" . $appointment_id . "','" . $client_id . "','" . $points . "','" . $transaction_type . "', '" . $created_at . "')";
    $rewardQuery = mysqli_query($db, $rewardSql);
}*/

function addPaymentHistory($db, $appointment, $appointment_id)
{
    extract($appointment);

    $created_at = date('Y-m-d H:i:s', time());

    $advance = ($total - $pending_due);
    $sql = "INSERT INTO `pending_payment_history`(`date`, `branch_id`, `client_id`, `app_bill_id`, `total`, `advance`, `paid`, `pending`, `bill_type`, `paid_branch_id`, `created_at`) VALUES ('{$appointment_date}', '{$branch_id}', '{$client_id}', '{$appointment_id}', '{$total}','{$advance}',0,'{$pending_due}', 'appointment', '{$branch_id}', '{$created_at}')";
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
    $m = addAppointmentService($db, $appointment_service, $appointment_id);
    addPaymentHistory($db, $appointment, $appointment_id);
    appointmentSMS($db, $appointment_id, 2);
    appointmentWASMS($db, $appointment_id);
    appointmentMail($db, $appointment_id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
