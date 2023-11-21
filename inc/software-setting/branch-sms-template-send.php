<?php
include('../../lib/db.php');
include('../../lib/sms-config.php');
throw_exception();

$v = $_REQUEST;


$errors = [];
$data = [];


if (!empty($v['schedule_date']) && !empty($v['schedule_time'])) {

    $date = $v['schedule_date'];

    $dateArr = explode('/', $date);
    $date = "{$dateArr[2]}/{$dateArr[1]}/{$dateArr[0]}";

    $time = $v['schedule_time'];
    $timeArr = explode(':', $time);
    $timeArr1 = explode(' ', $timeArr[1]);

    $time = "{$timeArr[0]}:$timeArr1[0]:00 $timeArr1[1]";

    $schedule = "{$date} {$time}";

} else {
    $schedule = '';
}


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



function saveSMSHistory($db, $client_ids, $message_id, $schedule)
{

    $clientModel = fetch_all($db, "SELECT `id` FROM client WHERE id IN ({$client_ids})");

    foreach ($clientModel as $key => $value) {
        $client_id = $value['id'];
        $created_at = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `branch_sms_history`(`client_id`, `message_id`, `schedule`, `created_at`) VALUES ('{$client_id}', '{$message_id}', '{$schedule}', '{$created_at}')";
        $query = mysqli_query($db, $sql);
    }

    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = saveSMSHistory($db, $v['clients_id'], $v['message_id'], $schedule);
    bulkSMS($db, $v['clients_id'], $v['message_id'], $schedule);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
