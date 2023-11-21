<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

if (isset($client_name)) {
    $sql = "SELECT `id`, `branch_id`, `client_name`, `contact`, `dob`, `anniversary`, `gender`, `email`, `source_of_client`, `address`, `referral`, CONCAT_WS(' - ', `client_name`, `contact`) AS `value` FROM client WHERE `client_name` LIKE '%{$client_name}%'";
}

if (isset($contact)) {
    $sql = "SELECT `id`, `branch_id`, `client_name`, `contact`, `dob`, `anniversary`, `gender`, `email`, `source_of_client`, `address`, `referral`, CONCAT_WS(' - ', `client_name`, `contact`) AS `value` FROM client WHERE `contact` LIKE '%{$contact}%'";
}

$model = fetch_all($db, $sql);
$arr = [];

foreach ($model as $key => $value) {
    $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$value['branch_id']}'");
    foreach ($value as $k => $v) {
        $arr[$key][$k] = $v;
        if ($k == 'value') {
            $arr[$key][$k] = $v . " - " . $branchModel->branch_name;
        }
    }
}

echo json_encode($arr);
