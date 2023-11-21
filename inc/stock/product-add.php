<?php
include('../../lib/db.php');

throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];


if (empty($_REQUEST['product'])) {
    $errors['error'] = 'product is required.';
}

if (empty($_REQUEST['volume'])) {
    $errors['error'] = 'Volume is required.';
}

if (empty($_REQUEST['unit'])) {
    $errors['error'] = 'Unit is required.';
}

if (empty($_REQUEST['mrp'])) {
    $errors['error'] = 'MRP is required.';
}

function addClient($db, $v, $k, $val){

    foreach ($v as $key => $value) {
        if($key != 'product_submit'){
            $k .=  "`".$key."`,";
            $val .=  "'".$value."',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", `created_at`";
    $val = $val.", '".$mysqltime."'";

    $sql = "INSERT INTO `product` ({$k}) VALUES ({$val})";


    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addClient($db, $v, $k, $val);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>