<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);

if (!isset($name)) {
    die();
}

$sql = "SELECT `id`, `product`, `volume`, `unit`, `mrp`, `barcode`, `reward_point_on_purchase`, product AS value FROM product WHERE product LIKE '%{$name}%' LIMIT 10";

$modalSql = mysqli_query($db, $sql);
$model = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);

$blankArr = [];

$expDate=date('d/m/Y', strtotime('+1 year'));

foreach ($model as $key => $value) {
    foreach ($value as $key1 => $value1) {
        $value1 = ($key1 == 'value') ? $value['product'] . " ( " . $value['volume'] . " " . $value['unit'] . " ) " : $value1;
        $blankArr[$key][$key1] = $value1;
        $blankArr[$key]['exp_date'] = $expDate;
    }
}
echo json_encode($blankArr);
