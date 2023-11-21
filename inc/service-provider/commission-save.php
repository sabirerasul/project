<?php
include('../../lib/db.php');
throw_exception();


$commission = $_POST['commission'];

$service_provider_id = $_POST['service_provider_id'];
$commission_type = $_POST['commission_type'];

//$id = $service['id'];

/*
if (empty($id)) {
    header("location: ../../service.php");
}
*/

$errors = [];
$data = [];

function saveCommission($db, $commission, $service_provider_id, $commission_type)
{
    $sql = '';
    $created_at = date('Y-m-d H:i:s', time());


    $oldModel = fetch_all($db, "SELECT id FROM service_product_commission WHERE `sp_id`='{$service_provider_id}' AND type='{$commission_type}'");
    $oldSId = array_column($oldModel, 'id');

    $newSId = array_column($commission, 'id');
    $delKey = array_diff($oldSId, $newSId);

    $delStringKey = implode(',', $delKey);

    if (!empty($delStringKey)) {
        $delete_sql = ("DELETE FROM service_product_commission WHERE id in($delStringKey) AND sp_id='" . $commission_type . "'");
        $delete_query = mysqli_query($db, $delete_sql);
    }


    foreach ($commission as $key => $value) {

        $id = (!empty($value['id'])) ? $value['id'] : 0;
        $sale_from = $value['sale_from'];
        $sale_to = $value['sale_to'];
        $commission1 = $value['commission'];
        $type = $value['type'];
        $sp_id = $value['sp_id'];

        $chkSql = "SELECT * FROM `service_product_commission` WHERE `id`='" . $id . "'";
        $chkNumRow = num_rows($db, $chkSql);

        if ($chkNumRow > 0) {
            $sql = "UPDATE `service_product_commission` SET `sp_id`='{$sp_id}', `sale_from`='{$sale_from}', `sale_to`='{$sale_to}', `commission`='{$commission1}', `type`='{$type}', `updated_at`='{$created_at}' WHERE id='{$id}'";
        } else {
            $sql = "INSERT INTO `service_product_commission` (`sp_id`, `sale_from`, `sale_to`, `commission`, `type`, `created_at`) VALUES ('{$sp_id}', '{$sale_from}', '{$sale_to}', '{$commission1}', '{$type}', '{$created_at}')";
        }

        $query = mysqli_query($db, $sql);
    }

    return true;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveCommission($db, $commission, $service_provider_id, $commission_type);

    $errors['error'] = 'Commission saved successfully!';
    $data['success'] = $m;
    $data['errors'] = $errors;
}

echo json_encode($data);
