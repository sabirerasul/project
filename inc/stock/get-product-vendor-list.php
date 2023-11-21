<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);
$branch_id = BRANCHID;
if(is_numeric($terms)){
    $contact = $terms;
}else{
    $vendor_name = $terms;
}

if(!empty($vendor_name)){
    $sql = "SELECT `id`, `vendor_name`, `contact`, `email`, `address`, `gst_number`, `company_details`, CONCAT_WS(' - ', `vendor_name`, `contact`) AS `value` FROM vendor WHERE `branch_id`='$branch_id' AND `vendor_name` LIKE '%{$vendor_name}%' LIMIT 15";
}

if(!empty($contact)){
    $sql = "SELECT `id`, `vendor_name`, `contact`, `email`, `address`, `gst_number`, `company_details`, CONCAT_WS(' - ', `vendor_name`, `contact`) AS `value` FROM vendor WHERE `branch_id`='$branch_id' AND `contact` LIKE '%{$contact}%' LIMIT 15";
}

$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);

echo json_encode($modal);
