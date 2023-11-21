<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);


$sql = "SELECT * FROM client WHERE id='{$client_id}'";
$modal = fetch_assoc($db, $sql);

$branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$modal['branch_id']}'");

$feedback_rating = get_client_rating($db, $client_id);
$feedback_comment = get_client_feedback($db, $client_id);

if (!empty($feedback_rating) || !empty($feedback_comment)) {
    $feedback = $feedback_rating . $feedback_comment;
} else {
    $feedback = '----';
}

$total_visit = get_client_total_visit($db, $client_id);
$lastvisit = get_client_last_visit($db, $client_id);
$total_spending = get_client_total_spend($db, $client_id);
$customer_type = get_client_type($db, $client_id);
$wallet = get_client_wallet($db, $client_id);
$bill_pending_amount = get_client_pending_amount($db, $client_id);
$reward_points = get_client_reward_point($db, $client_id);

$clientMembershipModel = fetch_object($db, "SELECT * FROM client_membership WHERE client_id='{$client_id}'");
$clientPackageModel = fetch_all($db, "SELECT * FROM client_package WHERE client_id='{$client_id}'");
if (!empty($clientMembershipModel)) {
    $membershipModel = fetch_object($db, "SELECT * FROM membership WHERE id='{$clientMembershipModel->membership_id}'");
    $membership = "{$membershipModel->membership_name}<br /> Valid : {$clientMembershipModel->valid_upto}<br />";
} else {
    $membership = '----';
}

if (count($clientPackageModel) > 0) {
    $package = '';
    foreach ($clientPackageModel as $clientPackageKey => $clientPackageVal) {
        $clientPackageValue = (object) $clientPackageVal;
        $packageModel = fetch_object($db, "SELECT * FROM package WHERE id='{$clientPackageValue->package_id}'");
        $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$clientPackageValue->billing_id}'");
        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
        $package .= "{$packageModel->package_name}<br /> Valid : {$clientPackageValue->valid_upto}<br /> Branch : {$branchModel->branch_name}<br />--------------------------<br />";
    }
} else {
    $package = '';
}

$modal['branch_name'] = "{$branchModel->branch_name} <i class='fa fa-user' class='mx-0'></i> <a href='client-profile.php?id={$modal['id']}' class='text-nowrap' target='_blank'><u>View profile</u></a>";
$modal['customer_type'] = $customer_type;
$modal['last_feedback'] = $feedback;
$modal['lastvisit'] = $lastvisit;
$modal['membership'] = $membership;
$modal['packages'] = $package;
$modal['reward_points'] = $reward_points;
$modal['total_spending'] = $total_spending;
$modal['total_visit'] = $total_visit;
$modal['wallet'] = $wallet;
$modal['bill_pending_amount'] = $bill_pending_amount;

echo json_encode($modal);
