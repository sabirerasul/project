<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$sql = "SELECT id,name as value FROM service_category WHERE `name` LIKE '%{$name}%' AND `status` = 1";

$modal = fetch_all($db, $sql);

echo json_encode($modal);