<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$membershipClientModel = fetch_object($db, "SELECT * FROM client_membership WHERE client_id='{$client_id}' ORDER BY id DESC");
if (!empty($membershipClientModel)) {
    $total = 1;


    $membershipModel = fetch_object($db, "SELECT * FROM membership WHERE id='{$membershipClientModel->membership_id}'");
    $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$membershipClientModel->billing_id}'");

    $modal['branch_id'] = $billingModel->branch_id;
    $modal['client_id'] = $client_id;
    $modal['discount_on_package'] = $membershipModel->discount_on_package;
    $modal['discount_on_product'] = $membershipModel->discount_on_product;
    $modal['discount_on_service'] = $membershipModel->discount_on_service;
    $modal['discount_on_package_type'] = $membershipModel->discount_on_package_type;
    $modal['discount_on_product_type'] = $membershipModel->discount_on_product_type;
    $modal['discount_on_service_type'] = $membershipModel->discount_on_service_type;
    $modal['id'] = $membershipClientModel->membership_id;
    $modal['invoice_id'] = $billingModel->invoice_number;
    $modal['membership_condition'] = $membershipModel->membership_condition;
    $modal['membership_name'] = $membershipModel->membership_name;
    $modal['membership_price'] = $membershipModel->price;
    $modal['min_bill_amount'] = $membershipModel->min_bill_amount;
    $modal['min_reward_points_earned'] = $membershipModel->min_reward_point_earned;
    $modal['reward_points_boost'] = $membershipModel->reward_point_boost;
    $modal['reward_points_on_purchase'] = $membershipModel->reward_point;
    $modal['status'] = 1;
    $modal['time_update'] = $membershipModel->updated_at;
    $modal['validity'] = $membershipModel->validity;


    $array[0]['result'] = $modal;
} else {
    $total = 0;
}

$array[0]['total'] = $total;


echo json_encode($array);
