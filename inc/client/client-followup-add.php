<?php
include('../../lib/db.php');
throw_exception();

$v = $_REQUEST;
$k = '';
$val = '';

$errors = [];
$data = [];

function addFollowup($db, $v, $k, $val){

    foreach ($v as $key => $value) {
        if($key != 'client_submit'){
            $k .=  "`".$key."`,";
            $val .=  "'".$value."',";
        }
    }

    $k = rtrim($k, ',');
    $val = rtrim($val, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", `created_at`";
    $val = $val.", '".$mysqltime."'";

    $sql = "INSERT INTO `client_followup` ({$k}) VALUES ({$val})";


    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = addFollowup($db, $v, $k, $val);
    $data['success'] = $m;
    $data['message'] = 'Success!';
}

echo json_encode($data);

?>