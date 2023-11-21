<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$package = $_POST['package'];
$package_service = $_POST['package_service'];

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


function addPackage($db, $package)
{
    $k = '';
    $val = '';
    foreach ($package as $key => $value) {

        $k .=  "`" . $key . "`,";
        $val .=  "'" . $value . "',";
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `package` ({$k}) VALUES ({$val})";


    $query = mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function addPackageService($db, $val, $package_id)
{
    $sql = '';
    foreach ($val as $key => $value) {

        $service_id = $value['service_id'];
        $quantity = $value['quantity'];
        $price = $value['price'];

        $sql .= "('" . $package_id . "', '" . $service_id . "', '" . $quantity . "', '" . $price . "'), ";
    }

    $sq = "INSERT INTO `package_service`(`package_id`, `service_id`, `quantity`, `price`) VALUES ";

    $sql = rtrim($sql, ', ');
    $sql = $sq . $sql;

    $query = mysqli_query($db, $sql);

    return $query ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $package_id = addPackage($db, $package);
    $m = addPackageService($db, $package_service, $package_id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
