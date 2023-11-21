<?php
include('../../lib/db.php');
throw_exception();

$package = $_POST['package'];
$package_service = $_POST['package_service'];

$id = $package['id'];

$errors = [];
$data = [];

if (empty($id)) {
    header("location: ../../package.php");
}

function updatePackage($db, $package)
{
    $k = '';
    $id = $package['id'];
    foreach ($package as $key => $value) {
        if ($key != 'service_submit' && $key != 'cid' && $key != 'id' && $key != 'service_category') {
            $k .=  "{$key}='{$value}',";
        }
    }

    $k = rtrim($k, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", updated_at='" . $mysqltime . "'";

    $sql = "UPDATE `package` SET {$k} WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $id;
}

function updatePackageService($db, $package_service, $package_id)
{
    $sql = '';

    $oldModel = fetch_all($db, "SELECT id FROM package_service WHERE `package_id`='{$package_id}'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($package_service, 'id');

    $delKey = array_diff($oldSId, $newSId);

    //$addKey = array_diff($newSId, $oldSId);

    $delStringKey = implode(',', $delKey);
    if (!empty($delStringKey)) {
        $delStringKey = !empty($delStringKey) ? $delStringKey : 0;
        $delete_sql = ("DELETE FROM package_service WHERE id in($delStringKey) AND package_id='{$package_id}'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    foreach ($package_service as $key => $value) {
        $id = (!empty($value['id'])) ? $value['id'] : 0;
        $service_id = $value['service_id'];
        $quantity = $value['quantity'];
        $price = $value['price'];

        $chkSql = "SELECT * FROM `package_service` WHERE `id`='{$id}'";
        $chkNumRow = num_rows($db, $chkSql);

        if ($chkNumRow > 0) {
            $sql = "UPDATE `package_service` SET `package_id`='{$package_id}', `service_id`='{$service_id}', `quantity`='{$quantity}', `price`='{$price}' WHERE id='{$id}'";
        } else {
            $sql = "INSERT INTO `package_service` (`package_id`, `service_id`, `quantity`, `price`) VALUES ('{$package_id}', '{$service_id}', '{$quantity}', '{$price}')";
        }
        $query = mysqli_query($db, $sql);
    }
    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $package_id = updatePackage($db, $package);

    $m = updatePackageService($db, $package_service, $package_id);

    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
