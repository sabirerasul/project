<?php
require_once "../../lib/db.php";
check_auth();

extract($_REQUEST);

$packageClientModel = fetch_all($db, "SELECT * FROM `client_package_details_usage` WHERE client_package_id='{$client_package_id}' AND package_details_id='{$package_details_id}' AND client_id='{$client_id}' AND service_id='{$service_id}'");

$html = '';
if (count($packageClientModel) > 0) {
    foreach ($packageClientModel as $membershipKey => $membershipVal) {
        $packageValue = (object) $membershipVal;
        $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$packageValue->billing_id}'");
        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");

        $html .= "
        <tr>
            <td>{$packageValue->use_on}</td>
            <td>{$branchModel->branch_name}</td>
            <td>{$packageValue->quantity}</td>
            <td>{$billingModel->invoice_number}</td>
        </tr>";
    }
} else {

    $html = "
        <tr>
            <td colspan='4'>No date Found</td>
        </tr>";
}

echo $html;
