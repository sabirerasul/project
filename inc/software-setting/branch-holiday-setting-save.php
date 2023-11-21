<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$api = $_POST['holiday'];

$errors = [];
$data = [];

function saveBranchAPI($db, $model)
{
    extract($model);
    $timeStamp = date('Y-m-d H:i:s', time());

    $sql1 = "UPDATE `branch_holiday` SET `date`='{$date}',`title`='{$title}' WHERE id='{$id}'";
    $sql2 = "INSERT INTO `branch_holiday`(`date`, `title`) VALUES ('{$date}', '{$title}')";

    $sql = !empty($model['id']) ? $sql1 : $sql2;
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
