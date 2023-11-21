<?php
include('../../lib/db.php');
throw_exception();


if(isset($_SESSION['clientUpdateError'])){
    unset($_SESSION['clientUpdateError']);
}

$v = $_REQUEST;
$k = '';
$val = '';
$id = $_REQUEST['id'];

if(empty($id)){
    header("location: ../../category.php");
}

$errors = [];
$data = [];

if (empty($_REQUEST['name'])) {
    $errors['error'] = 'Name is required.';
}

function updateServiceCategory($db, $v, $k, $id){

    foreach ($v as $key => $value) {
        if($key != 'service_category_submit' && $key != 'id'){
            $k .=  "{$key}='{$value}',";
        }
    }

    $k = rtrim($k, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", updated_at='".$mysqltime."'";

    $sql = "UPDATE `service_category` SET {$k} WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateServiceCategory($db, $v, $k, $id);
    $errors['error'] = 'Category updated successfully';
    $data['success'] = true;
    $data['errors'] = $errors;
}

echo json_encode($data);
?>