<?php
require_once "../../lib/db.php";
throw_exception();


$sql = "SELECT id,name as title FROM service_provider WHERE status=1 ORDER by id DESC";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
$html = json_encode($modal);
echo $html;
?>