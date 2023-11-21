<?php
include('../../lib/db.php');
throw_exception();

$service = $_POST['service'];

$service['hide_on_website'] = (!isset($service['hide_on_website'])) ? 0 : $service['hide_on_website'];

$service_product = $_POST['service_product'];

$id = $service['id'];

if (empty($id)) {
    header("location: ../../service.php");
}

$errors = [];
$data = [];

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

function updateService($db, $service)
{
    $k = '';
    $id = $service['id'];
    foreach ($service as $key => $value) {
        if ($key != 'service_submit' && $key != 'cid' && $key != 'id' && $key != 'service_category') {
            $k .=  "{$key}='{$value}',";
        }
    }

    $k = rtrim($k, ',');

    $mysqltime = date('Y-m-d H:i:s', time());
    $k = $k . ", updated_at='" . $mysqltime . "'";

    $sql = "UPDATE `service` SET {$k} WHERE id={$id}";
    $query = mysqli_query($db, $sql);

    return $id;
}

function updateServiceProduct($db, $service_product, $service_id)
{

    $oldModel = fetch_all($db, "SELECT id FROM service_product WHERE `service_id`='" . $service_id . "'");
    $oldSId = array_column($oldModel, 'id');
    $newSId = array_column($service_product, 'id');

    $delKey = array_diff($oldSId, $newSId);

    //$addKey = array_diff($newSId, $oldSId);

    $delStringKey = implode(',', $delKey);

    $delStringKey = ($delStringKey != '') ? $delStringKey : 0;

    $delete_sql = ("DELETE FROM service_product WHERE id in($delStringKey) AND service_id='" . $service_id . "'");
    $delete_query = mysqli_query($db, $delete_sql);

    $sql = '';
    foreach ($service_product as $key => $value) {

        if (empty($value['product_id'])) {
            continue;
        }

        $id = (!empty($value['id'])) ? $value['id'] : 0;

        $product_id = $value['product_id'];
        $volume = $value['volume'];
        $unit = $value['unit'];
        $quantity_used = $value['quantity_used'];

        $chkSql = "SELECT * FROM `service_product` WHERE `id`='" . $id . "'";
        $chkNumRow = num_rows($db, $chkSql);

        if ($chkNumRow > 0) {
            $sql = "UPDATE `service_product` SET `service_id`='" . $service_id . "', `product_id`='" . $product_id . "', `volume`='" . $volume . "', `unit`='" . $unit . "', `quantity_used`='" . $quantity_used . "' WHERE id='" . $id . "'";
        } else {
            $sql = "INSERT INTO `service_product` (`service_id`, `product_id`, `volume`, `unit`, `quantity_used`) VALUES ('" . $service_id . "', '" . $product_id . "', '" . $volume . "', '" . $unit . "', '" . $quantity_used . "')";
        }
        $query = mysqli_query($db, $sql);
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

    $service_id = updateService($db, $service);
    $m = updateServiceProduct($db, $service_product, $service_id);

    $errors['error'] = 'Service updated successfully';
    $data['success'] = $m;
    $data['errors'] = $errors;
}

echo json_encode($data);
