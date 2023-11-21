<?php
include('../../lib/db.php');
throw_exception();


extract($_REQUEST);
$servicesArr = explode(',', $services);

$errors = [];
$data = [];

if (empty($services)) {
    $errors['error'] = 'Services is required.';
}

if (empty($provider_id)) {
    $errors['error'] = 'Provider is required.';
}

function addServiceProviderServices($db, $newSId, $provider_id)
{

    $sql1 = "SELECT s_id FROM service_provider_assign_services WHERE `sp_id`='" . $provider_id . "'";
    $query1 = mysqli_query($db, $sql1);

    $oldModel = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    $oldSId = array_column($oldModel, 's_id');

    $delKey = array_diff($oldSId, $newSId);
    $addKey = array_diff($newSId, $oldSId);

    $delStringKey = implode(',', $delKey);

    if (!empty($delStringKey)) {
        $delete_sql = ("DELETE FROM service_provider_assign_services WHERE s_id in($delStringKey) AND sp_id='" . $provider_id . "'");
        $delete_query = mysqli_query($db, $delete_sql);
    }

    foreach ($addKey as $key => $value) {

        $mysqltime = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO `service_provider_assign_services` (`sp_id`, `s_id`, `created_at`) VALUES ('" . $provider_id . "', '" . $value . "', '" . $mysqltime . "')";
        $query = mysqli_query($db, $sql);
    }

    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
    $data['status'] = false;
} else {

    $m = addServiceProviderServices($db, $servicesArr, $provider_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
    $data['status'] = true;
}

echo json_encode($data);
