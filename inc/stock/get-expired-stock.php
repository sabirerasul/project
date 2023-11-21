<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);

if(isset($client_name)){
    $sql = "SELECT `id`, `client_name`, `contact`, `dob`, `anniversary`, `gender`, `email`, `source_of_client`, `address`, `referral`, CONCAT_WS(' - ', `client_name`, `contact`) AS `value` FROM client WHERE `client_name` LIKE '%{$client_name}%'";
}

if(isset($contact)){
    $sql = "SELECT `id`, `client_name`, `contact`, `dob`, `anniversary`, `gender`, `email`, `source_of_client`, `address`, `referral`, CONCAT_WS(' - ', `client_name`, `contact`) AS `value` FROM client WHERE `contact` LIKE '%{$contact}%'";
}

$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);

echo json_encode($modal);
