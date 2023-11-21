<?php
require_once "../../lib/db.php";
check_auth();

$id = $_REQUEST['client_id'];

$packageClientModel = fetch_all($db, "SELECT * FROM client_package WHERE client_id='{$id}' ORDER BY id DESC");

$html = '';
if (count($packageClientModel) > 0) {
    $count = 0;
    foreach ($packageClientModel as $membershipKey => $membershipVal) {
        $packageValue = (object) $membershipVal;
        $count++;
        $packageModel = fetch_object($db, "SELECT * FROM package WHERE id='{$packageValue->package_id}'");
        $billingModel = fetch_object($db, "SELECT * FROM client_billing WHERE id='{$packageValue->billing_id}'");
        $branchModel = fetch_object($db, "SELECT * FROM branch WHERE id='{$billingModel->branch_id}'");
        $packageServiceNum = fetch_object($db, "SELECT sum(quantity) as total_service FROM client_package_details WHERE client_package_id='{$packageValue->id}'");

        $availQuantity = fetch_object($db, "SELECT sum(quantity) as avail_service FROM `client_package_details_usage` WHERE client_package_id='{$packageValue->id}'");
        $availQuantity = !empty($availQuantity->avail_service) ? $availQuantity->avail_service : 0;

        $html .= "
        <tr>
            <td>{$packageModel->package_name}</td>
            <td>{$branchModel->branch_name}</td>
            <td>{$packageValue->valid_upto}</td>
            <td>{$packageModel->price}</td>
            <td>{$packageServiceNum->total_service}</td>
            <td>{$availQuantity}</td>
            <td><a target='_black' href='./client-package-view.php?id={$id}&pkg_id={$packageValue->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-view' aria-hidden='true'></i> View</a></td>
        </tr>";
    }
}

echo $html;
