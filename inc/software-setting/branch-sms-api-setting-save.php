<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$api = $_POST['api'];

$errors = [];
$data = [];

function saveBranchAPI($db, $model)
{
    extract($model);
    $timeStamp = date('Y-m-d H:i:s', time());

    $query = num_rows($db, "SELECT * FROM branch_api_setting");

    $sql1 = "UPDATE `branch_api_setting` SET `url`='{$url}',`username`='{$username}',`password`='{$password}',`sender_id`='{$sender_id}'";
    $sql2 = "INSERT INTO `branch_api_setting`(`url`, `username`, `password`, `sender_id`) VALUES ('{$url}', '{$username}', '{$password}', '{$sender_id}')";

    $sql = ($query == 0) ? $sql2 : $sql1;
    $query = mysqli_query($db, $sql);

    return ($query) ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveBranchAPI($db, $api);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
