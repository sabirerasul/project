<?php
include('../../lib/db.php');

throw_exception();


$v = $_REQUEST;
$k = '';
$val = '';
$id = $_REQUEST['id'];

if(empty($id)){
    header("location: ../../product.php");
}

$errors = [];
$data = [];

$modelSql = mysqli_query($db, "SELECT * FROM product WHERE id='{$id}'");
$model = mysqli_fetch_object($modelSql);

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


function updateProduct($db, $v, $k, $id){

    foreach ($v as $key => $value) {
        if($key != 'product_submit' && $key != 'cid'){
            $k .=  "{$key}='{$value}',";
        }
    }

    $k = rtrim($k, ',');

    $mysqltime = date ('Y-m-d H:i:s', time());
    $k = $k.", updated_at='".$mysqltime."'";

    $sql = "UPDATE `product` SET {$k} WHERE id={$id}";

    $query = mysqli_query($db, $sql);

    return $query ? true:false;

}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $m = updateProduct($db, $v, $k, $id);
    $errors['error'] = 'Product updated successfully';
    $data['success'] = true;
    $data['errors'] = $errors;
}

echo json_encode($data);

?>