<?php

extract($_REQUEST);



if(empty($id)){
    header('location: ../../feedback.php');
}

include('../../lib/db.php');

throw_exception();

$model = fetch_object($db, "SELECT * FROM feedback WHERE id='{$id}'");

if($model->status == 1){
    $status = 0;
}else{
    $status = 1;
}


$sql = "UPDATE `feedback` SET status='".$status."' WHERE id={$id}";

$query = mysqli_query($db, $sql);

header('location: ../../feedback.php');
