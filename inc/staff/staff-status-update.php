<?php
extract($_REQUEST);
include('../../lib/db.php');

throw_exception();


$modelSql = mysqli_query($db, "SELECT * FROM employee WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);

if($model->status == 1){
    $status = 0;
}else{
    $status = 1;
}


$sql = "UPDATE `employee` SET status='".$status."' WHERE id={$id}";

$query = mysqli_query($db, $sql);

header('location: ../../staff.php');

?>