<?php
extract($_REQUEST);
include('../../lib/db.php');
throw_exception();


$modelSql = mysqli_query($db, "SELECT * FROM service_provider WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);

if($model->status == 1){
    $status = 0;
}else{
    $status = 1;
}


$sql = "UPDATE `service_provider` SET status='".$status."' WHERE id={$id}";

$query = mysqli_query($db, $sql);

header('location: ../../service-provider.php');

?>