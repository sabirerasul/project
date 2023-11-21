<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$sql = ($employee_type == 2) ? "SELECT id,name as value FROM service_provider WHERE `name` LIKE '%{$name}%' AND status=1 LIMIT 10" : "SELECT id,name as value FROM employee WHERE `name` LIKE '%{$name}%' AND status=1 LIMIT 10";

$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
$html = json_encode($modal);
echo $html;
