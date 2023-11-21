<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$sql = "SELECT id,title as value FROM expense_type WHERE `title` LIKE '%{$name}%'";

$modal = fetch_all($db, $sql);

echo json_encode($modal);