<?php
require_once "../../lib/db.php";
throw_exception();

$modalSql = mysqli_query($db, "SELECT * FROM client");
//$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
//$model = mysqli_fetch_object($modelSql);

echo $activeClient = mysqli_num_rows($modalSql);

?>