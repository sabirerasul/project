<?php
include('../../lib/db.php');
throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];


if (empty($_REQUEST['name'])) {
    $errors['error'] = 'Name is required.';
}

function addServiceCategory($db, $v, $k, $val){

    foreach ($v as $key => $value) {
        if($key != 'service_category_submit'){
            $k .=  "`".$key."`,";
            $val .=  "'".$value."',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", `created_at`";
    $val = $val.", '".$mysqltime."'";

    $sql = "INSERT INTO `service_category` ({$k}) VALUES ({$val})";

    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addServiceCategory($db, $v, $k, $val);
    $errors['error'] = 'Category Added successfully';
    $data['success'] = true;
    $data['errors'] = $errors;
}

echo json_encode($data);

?>