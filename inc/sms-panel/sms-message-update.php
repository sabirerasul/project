<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

$id = $_REQUEST['id'];

if (empty($id)) {
    header("location: ../../sms-message.php");
}

function updateExpense($db, $v, $k, $id)
{

    foreach ($v as $key => $value) {
        if ($key != 'staff_submit' && $key != 'expense_type' && $key != 'recipient_name') {
            $k .=  "{$key}='{$value}',";
        }
    }
    $k = rtrim($k, ',');

    $mysqltime = date('Y-m-d H:i:s', time());

    $k1 = $k . ", updated_at='" . $mysqltime . "'";
    $sql = "UPDATE `branch_sms_message` SET {$k1} WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateExpense($db, $v, $k, $id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
