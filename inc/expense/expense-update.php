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
    header("location: ../../expense.php");
}

function addExpenseType($db, $expense_type)
{
    $chkSql = "SELECT * FROM `expense_type` WHERE `title`='" . $expense_type . "'";

    if (num_rows($db, $chkSql) == 0) {
        $created_at = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `expense_type` (`title`, `created_at`) VALUES ('" . $expense_type . "', '" . $created_at . "')";
        mysqli_query($db, $sql);
        $last_id = mysqli_insert_id($db);
    } else {
        $model = fetch_object($db, $chkSql);
        $last_id = $model->id;
    }

    return $last_id;
}

function addRecipient($db, $recipient)
{
    $chkSql = "SELECT * FROM `expense_recipient` WHERE `recipient_name`='" . $recipient . "'";

    if (num_rows($db, $chkSql) == 0) {
        $created_at = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `expense_recipient` (`recipient_name`, `created_at`) VALUES ('" . $recipient . "', '" . $created_at . "')";
        mysqli_query($db, $sql);
        $last_id = mysqli_insert_id($db);
    } else {
        $model = fetch_object($db, $chkSql);
        $last_id = $model->id;
    }

    return $last_id;
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

    $k1 = $k . ", created_at='" . $mysqltime . "'";
    $sql = "UPDATE `expense` SET {$k1} WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $expense_type_id = addExpenseType($db, $v['expense_type']);
    $v['expense_type_id'] = $expense_type_id;

    $recipient_name_id = addRecipient($db, $v['recipient_name']);
    $v['recipient_name_id'] = $recipient_name_id;

    $m = updateExpense($db, $v, $k, $id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
