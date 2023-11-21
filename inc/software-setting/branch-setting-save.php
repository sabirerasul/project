<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$branch = $_POST['branch'];
$branch_id = BRANCHID;

$errors = [];
$data = [];

function saveBranch($db, $model, $branch_id)
{
    extract($model);
    $updated_at = date('Y-m-d H:i:s', time());
    //`logo`='{$logo}',
    $sql = "UPDATE `branch` SET `salon_name`='{$salon_name}',`address`='{$address}',`phone`='{$phone}',`email`='{$email}',`website`='{$website}',`gst`='{$gst}',`working_hours_start`='{$working_hours_start}',`working_hours_end`='{$working_hours_end}',`updated_at`='{$updated_at}' WHERE id='{$branch_id}'";

    $query = mysqli_query($db, $sql);

    return ($query) ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveBranch($db, $branch, $branch_id);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
