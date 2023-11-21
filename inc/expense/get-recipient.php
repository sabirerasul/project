<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$sql = "SELECT id,recipient_name as value FROM expense_recipient WHERE `recipient_name` LIKE '%{$name}%'";

$modal = fetch_all($db, $sql);

echo json_encode($modal);