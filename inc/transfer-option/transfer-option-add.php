<?php
include('../../lib/db.php');

throw_exception();

$value = $_REQUEST;

$errors = [];
$data = [];


if (empty($_REQUEST['transfer_type'])) {
    $errors['error'] = 'Transfer Type is required.';
}

if (empty($_REQUEST['transfer_date'])) {
    $errors['error'] = 'Transfer Date is required.';
}

if (empty($_REQUEST['service_provider_id'])) {
    $errors['error'] = 'Service Provider is required.';
}

if (empty($_REQUEST['transfer_branch_id'])) {
    $errors['error'] = 'Branch is required.';
}

function transferServiceProvider($db, $v)
{
    $k = $val = '';
    foreach ($v as $key => $value) {
        if ($key != 'product_submit') {
            $k .=  "`" . $key . "`,";
            $val .=  "'" . $value . "',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `transfer_service_provider` ({$k}) VALUES ({$val})";
    $query = mysqli_query($db, $sql);

    $model = fetch_assoc($db, "SELECT `branch_id`, `name`, `dob`, `contact_number`, `email`, `service_provider_type`, `working_hours_start`, `working_hours_end`, `salary`, `emer_contact_number`, `emer_contact_person`, `address`, `username`, `password`, `gender`, `service_commission`, `product_commission`, `photo`, `frontproof`, `backproof`, `status`, `created_at` FROM service_provider WHERE id='{$v['service_provider_id']}'");

    $mk = $mval = '';
    foreach ($model as $modelKey => $modelValue) {

        if($modelKey == 'branch_id'){
            $modelValue = $v['transfer_branch_id'];
        }
        if ($modelKey != 'product_submit') {
            $mk .=  "`" . $modelKey . "`,";
            $mval .=  "'" . $modelValue . "',";
        }
    }

    $mk = rtrim($mk, ',');
    $mval = rtrim($mval, ',');

    $spSql = "INSERT INTO `service_provider` ({$mk}) VALUES ({$mval})";

    mysqli_query($db, $spSql);

    mysqli_query($db, "UPDATE `service_provider` SET `status`=2 WHERE id='{$v['service_provider_id']}'");

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = transferServiceProvider($db, $value);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
