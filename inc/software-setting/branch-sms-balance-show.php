<?php
require_once "../../lib/db.php";

throw_exception();

$data = sms_balance();

echo json_encode($data);
