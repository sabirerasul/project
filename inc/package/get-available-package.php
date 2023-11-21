<?php
require_once "../../lib/db.php";
check_auth();

extract($_REQUEST);

$packageClientModel = fetch_all($db, "SELECT * FROM `client_package_details` WHERE client_id='{$client_id}' AND service_id='{$service_id}'");

$html = '';

$data = [];
$status = false;
if (count($packageClientModel) > 0) {
    $status = true;
    foreach ($packageClientModel as $packageClientKey => $packageClientVal) {
        $packageClientValue = (object) $packageClientVal;

        $clientPackageModel = fetch_object($db, "SELECT * FROM `client_package` WHERE id='{$packageClientValue->client_package_id}'");

        $packageServiceNum = fetch_object($db, "SELECT sum(quantity) as total_service FROM client_package_details WHERE client_package_id='{$clientPackageModel->id}'");
        $totalService = !empty($packageServiceNum->total_service) ? $packageServiceNum->total_service : 0;

        $availQuantity = fetch_object($db, "SELECT sum(quantity) as avail_service FROM `client_package_details_usage` WHERE client_package_id='{$packageClientValue->client_package_id}' AND package_details_id='{$packageClientValue->id}' AND client_id='{$client_id}' AND service_id='{$service_id}'");
        $availQuantity = !empty($availQuantity->avail_service) ? $availQuantity->avail_service : 0;

        $remainingQuantity = $totalService - $availQuantity;


        if ($remainingQuantity == 0) {
            continue;
        }


        $packageModel = fetch_object($db, "SELECT * FROM `package` WHERE id='{$clientPackageModel->package_id}'");

        $serviceModel = fetch_object($db, "SELECT * FROM `service` WHERE id='{$packageClientValue->service_id}'");

        $purchaseDate = date("d-m-Y", strtotime($clientPackageModel->created_at));

        $html .= <<<EOT
        <tr>
            <td>{$serviceModel->service_name}</td>
            <td>{$packageClientValue->quantity}</td>
            <td>{$packageModel->package_name}</td>
            <td>{$purchaseDate}</td>
            <td>{$clientPackageModel->valid_upto}</td>
            <td><a class='btn btn-success btn-sm' onclick="consumePackage('{$row_id}', '{$service_id}', '$packageModel->id', '$clientPackageModel->id', '$packageClientValue->id', 1)"> <i class='fa fa-plus'></i> Use</a></td>
        </tr>
        EOT;
    }
}

echo $html;
