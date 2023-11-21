<?php
include('../../lib/db.php');
throw_exception();

$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

$id = $_REQUEST['id'];

if(empty($id)){
    header("location: ../../membership.php");
}

$model = fetch_object($db, "SELECT * FROM membership WHERE id='{$id}'");

function updateMembership($db, $v, $k, $id){

    foreach ($v as $key => $value) {
        if($key != 'staff_submit' && $key != 'id'){
            $k .=  "{$key}='{$value}',";
        }
    }    
    $k = rtrim($k, ',');
    
    $mysqltime = date ('Y-m-d H:i:s', time());

    $k1 = $k.", created_at='".$mysqltime."'";
    $sql = "UPDATE `membership` SET {$k1} WHERE id={$id}";
    
    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateMembership($db, $v, $k, $id);
    
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);
