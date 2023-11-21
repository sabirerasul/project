<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$refferalModel = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE referral_code='{$referral_code}'");
$available = '';

if (!empty($refferalModel)) {

    if ($client_id != 0) {

        if ($refferalModel->client_id == $client_id) {
            $available = 0;
        } else {

            $refferalClientModel = fetch_object($db, "SELECT * FROM `client_referral_code_use_history` WHERE `referral_code_id`='{$refferalModel->id}' AND `client_id`='{$client_id}'");
            if (empty($refferalClientModel)) {
                $available = 2;
            } else {
                $available = 1;
            }
        }
    } else {
        $available = 2;
    }
} else {
    $available = 0;
}

$array['available'] = $available;


echo json_encode($array);


// 0 = invalid code
// 1 = already used
// 2 = applied
