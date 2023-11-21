<?php
require_once "../../lib/db.php";

extract($_REQUEST);

if (isset($value)) {
    $value = mysqli_real_escape_string($db, $value);
    $sql = "SELECT `id`, `client_name` FROM client WHERE `contact` LIKE '%{$value}%'";
}

$model = fetch_object($db, $sql);
$array = [];

$array['status'] = !empty($model) ? true : false;
$array['error'] = '';
$array['data'] = !empty($model) ? $model : 0;

echo json_encode($array);
