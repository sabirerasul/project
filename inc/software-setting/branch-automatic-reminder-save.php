<?php
include('../../lib/db.php');
throw_exception();

//$v = $_REQUEST;

$points = $_POST['automatic_reminder'];

$errors = [];
$data = [];

function saveBranchRedeemPoints($db, $model)
{
    extract($model);
    $timeStamp = date('Y-m-d H:i:s', time());


    $birthday = isset($birthday) ? $birthday : 0;
    $anniversary = isset($anniversary) ? $anniversary : 0;
    $appointment = isset($appointment) ? $appointment : 0;
    $package_expiry = isset($package_expiry) ? $package_expiry : 0;
    $membership_expiry = isset($membership_expiry) ? $membership_expiry : 0;


    $query = num_rows($db, "SELECT * FROM branch_automatic_reminder");

    $sql1 = "UPDATE `branch_automatic_reminder` SET `birthday`='{$birthday}',`anniversary`='{$anniversary}',`appointment`='{$appointment}',`membership_expiry`='{$membership_expiry}',`package_expiry`='{$package_expiry}' WHERE id='{$id}'";
    $sql2 = "INSERT INTO `branch_automatic_reminder`(`birthday`, `anniversary`, `appointment`, `membership_expiry`, `package_expiry`) VALUES ('{$birthday}', '{$anniversary}', '{$appointment}', '{$membership_expiry}', '{$package_expiry}')";

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
