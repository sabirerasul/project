<?php
include('../../lib/db.php');
throw_exception();


$service = $_POST['service'];
$service_product = $_POST['service_product'];

$errors = [];
$data = [];


// if (empty($_REQUEST['category_id'])) {
//     $errors['error'] = 'Category is required.';
// }

if (empty($service['service_category'])) {
    $errors['error'] = 'Category is required.';
}

if (empty($service['service_name'])) {
    $errors['error'] = 'Service Name is required.';
}

if (empty($service['price'])) {
    $errors['error'] = 'Price is required.';
}

if (empty($service['membership_price'])) {
    $errors['error'] = 'Membership Price is required.';
}

if (empty($service['duration'])) {
    $errors['error'] = 'Duration is required.';
}

function addServiceCategory($db, $category)
{
    $chkSql = "SELECT * FROM `service_category` WHERE `name`='" . $category . "'";

    if (num_rows($db, $chkSql) == 0) {
        $created_at = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `service_category` (`name`, `status`, `created_at`) VALUES ('" . $category . "','1','" . $created_at . "')";
        mysqli_query($db, $sql);
        $last_id = mysqli_insert_id($db);
    } else {
        $model = fetch_object($db, $chkSql);
        $last_id = $model->id;
    }

    return $last_id;
}

function addService($db, $service)
{
    $k = '';
    $val = '';

    foreach ($service as $key => $value) {
        if ($key != 'service_submit' && $key != 'service_category') {
            $k .=  "`" . $key . "`,";
            $val .=  "'" . $value . "',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", `created_at`";
    $val = $val . ", '" . $mysqltime . "'";

    $sql = "INSERT INTO `service` ({$k}) VALUES ({$val})";

    mysqli_query($db, $sql);
    $last_id = mysqli_insert_id($db);

    return $last_id;
}

function addServiceProduct($db, $service_product, $service_id)
{
    $sql = '';

    foreach ($service_product as $key => $value) {

        if (empty($value['product_id'])) {
            continue;
        }

        $product_id = $value['product_id'];
        $volume = $value['volume'];
        $unit = $value['unit'];
        $quantity_used = $value['quantity_used'];
        $value = "'" . $service_id . "', '" . $product_id . "', '" . $volume . "', '" . $unit . "', '" . $quantity_used . "'";
        $sql = "INSERT INTO `service_product`(`service_id`, `product_id`, `volume`, `unit`, `quantity_used`) VALUES ({$value})";
        $query = mysqli_query($db, $sql);
    }

    return true;
}

function addServiceProviderServices($db, $newSId1)
{
    if (gettype($newSId1) == 'array') {
        $newSId = $newSId1;
    } else {
        $newSId[] = $newSId1;
    }

    $serviceProviderModels = fetch_all($db, "SELECT id FROM `service_provider` WHERE status=1");
    $serviceProviderIds = array_column($serviceProviderModels, 'id');

    foreach ($serviceProviderIds as $serviceProviderIdskey => $serviceProviderIdsValue) {
        $provider_id = $serviceProviderIdsValue;

        $sql1 = "SELECT s_id FROM service_provider_assign_services WHERE `sp_id`='" . $provider_id . "'";
        $query1 = mysqli_query($db, $sql1);

        $oldModel = mysqli_fetch_all($query1, MYSQLI_ASSOC);
        $oldSId = array_column($oldModel, 's_id');

        $delKey = array_diff($oldSId, $newSId);
        $addKey = array_diff($newSId, $oldSId);

        /*
        $delStringKey = implode(',', $delKey);

        if (!empty($delStringKey)) {
            $delete_sql = ("DELETE FROM service_provider_assign_services WHERE s_id in($delStringKey) AND sp_id='" . $provider_id . "'");
            $delete_query = mysqli_query($db, $delete_sql);
        }
        */

        foreach ($addKey as $key => $value) {

            $mysqltime = date('Y-m-d H:i:s', time());
            $sql = "INSERT INTO `service_provider_assign_services` (`sp_id`, `s_id`, `created_at`) VALUES ('" . $provider_id . "', '" . $value . "', '" . $mysqltime . "')";
            $query = mysqli_query($db, $sql);
        }
    }

    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    if (empty($service['category_id'])) {
        $category_id = addServiceCategory($db, $service['service_category']);
        $service['category_id'] = $category_id;
    }

    $service_id = addService($db, $service);
    $m = addServiceProduct($db, $service_product, $service_id);
    addServiceProviderServices($db, $service_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
