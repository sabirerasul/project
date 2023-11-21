<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$points = $_POST['points'];

$errors = [];
$data = [];

function saveBranchRedeemPoints($db, $model)
{
    extract($model);
    $timeStamp = date('Y-m-d H:i:s', time());

    $query = num_rows($db, "SELECT * FROM branch_redeem_points_setting");

    $sql1 = "UPDATE `branch_redeem_points_setting` SET `redeem_point`='{$redeem_point}',`price`='{$price}',`max_redeem_point`='{$max_redeem_point}'";
    $sql2 = "INSERT INTO `branch_redeem_points_setting`(`redeem_point`, `price`, `max_redeem_point`) VALUES ('{$redeem_point}', '{$price}', '{$max_redeem_point}')";

    $sql = ($query == 0) ? $sql2 : $sql1;
    $query = mysqli_query($db, $sql);

    return ($query) ? true : false;
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $m = saveBranchRedeemPoints($db, $points);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
