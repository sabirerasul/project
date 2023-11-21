<?php
include('../../lib/db.php');

throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

$id = $_REQUEST['id'];

$modelSql = mysqli_query($db, "SELECT * FROM service_reminder WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);

if($model->status == 1){
    $status = 0;
}else{
    $status = 1;
}

$updated_at = date ('Y-m-d H:i:s', time());
$sql = "UPDATE `service_reminder` SET status='".$status."', updated_at='".$updated_at."' WHERE id={$id}";


$query = mysqli_query($db, $sql);

header('location: ../../service-reminder.php');


?>