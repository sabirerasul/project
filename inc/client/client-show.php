<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$cond = 1;

if ($_POST) {

    /*$uid = mysqli_real_escape_string($db, $uid);
    $uid = $uid ? $uid : '';
    $name = mysqli_real_escape_string($db, $name);
    $name = $name ? $name : '';
    $number = mysqli_real_escape_string($db, $number);
    $number = $number ? $number : '';
    $email = mysqli_real_escape_string($db, $email);
    $email = $email ? $email : '';
    $source = mysqli_real_escape_string($db, $source);
    $source = $source ? $source : '';
    $spname = mysqli_real_escape_string($db, $spname);
    $spname = $spname ? $spname : '';
    $sname = mysqli_real_escape_string($db, $sname);
    $sname = $sname ? $sname : '';
    $sid = mysqli_real_escape_string($db, $sid);
    $sid = $sid ? $sid : '';
    $gender = mysqli_real_escape_string($db, $gender);
    $gender = $gender ? $gender : '';

    $cond = "`id` LIKE '{$uid}' AND `client_name` LIKE '%{$name}%' AND `contact` LIKE '%{$number}%' AND `gender` LIKE '{$gender}' AND `email` LIKE '{$email}' AND `source_of_client` LIKE '{$source}'";
    */
}

$removeStr = [
    "`id` LIKE '' AND",
    "`client_name` LIKE '%%' AND",
    "`contact` LIKE '%%' AND",
    "`gender` LIKE '' AND",
    "`email` LIKE '' AND",
    "`source_of_client` LIKE '' AND"
];

foreach ($removeStr as $k => $v) {
    $cond = str_replace($v, '', $cond);
}

$cond = ($cond == '') ? 1 : $cond;

$sql = "SELECT * FROM client WHERE {$cond} ORDER by id DESC";
$modal = fetch_all($db, $sql);

$html = "";

$count = 0;


if (count($modal) > 0) {
    foreach ($modal as $key => $val) {
        $value = (object) $val;


        if ($type != "existing") {
            $clientType = get_client_type($db, $value->id);

            if ($clientType != $type) {
                continue;
            }
        }

        $count++;

        $referralModel = fetch_object($db, "SELECT * FROM `client_referral_code` WHERE client_id='{$value->id}'");
        $cGender = ucfirst($value->gender);
        $refGenLink = "<a class='text-danger text-nowrap text-decoration-none cursor-pointer' onclick='genReferral(this,{$value->id})'><i class='fas fa-eye'></i> Generate</a>";
        $referralCode = !empty($referralModel) ? $referralModel->referral_code : "{$refGenLink}";

        $lastBillingModel = fetch_object($db, "SELECT id FROM client_billing WHERE client_id='{$value->id}' ORDER BY id DESC");
        $billing_id = !empty($lastBillingModel) ? $lastBillingModel->id : 0;

        $clientFirstVisit = get_client_first_visit($db, $value->id);
        $clientLastVisit = get_client_last_visit($db, $value->id);
        $clientLastService = get_client_billing_service($db, $billing_id);
        $clientLastServiceProvider = get_client_billing_service_provider($db, $billing_id);
        $clientLastBillAmount = get_client_last_bill_amount($db, $value->id);
        $clientRewardPoint = get_client_reward_point($db, $value->id);

        $followupModel = fetch_object($db, "SELECT * FROM client_followup WHERE client_id='{$value->id}' ORDER by id DESC");
        $followup = !empty($followupModel) ? $followupModel->response : '';

        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->client_name}</td>
            <td>{$value->contact}</td>
            <td>{$referralCode}</td>
            <td>{$clientFirstVisit}</td>
            <td>{$clientLastVisit}</td>
            <td>{$clientLastService}</td>
            <td>{$clientLastServiceProvider}</td>
            <td>{$clientLastBillAmount}</td>
            <td>{$cGender}</td>
            <td>{$clientRewardPoint}</td>
            <td>{$followup}</td>
            <td style='padding: 0px'>
            <div class=''>
                <a href='./client-profile.php?id={$value->id}' class='btn btn-sm btn-primary m-1 text-nowrap'><i class='fas fa-user'></i> View Profile</a>
                <a data-id='{$value->id}' class='btn btn-sm btn-danger m-1 text-nowrap' onclick='clientDelete({$value->id})'><i class='fas fa-trash'></i> Delete</a>
                <a class='btn btn-sm btn-success m-1 text-nowrap' onclick='addFollowup({$value->id})'><i class='fas fa-plue'></i> Add Followup</a>
            </div>
            </td>
            </tr>";
    }
}


echo $html;
