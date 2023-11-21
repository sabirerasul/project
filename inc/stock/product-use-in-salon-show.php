<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$branch_id = BRANCHID;
$sql = "SELECT * FROM product_use_in_salon  WHERE branch_id='{$branch_id}' ORDER by id DESC";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);

$html = "";

if (count($modal) > 0) {
    $count = 1;
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $salonProductModel = fetch_object($db, "SELECT * FROM stock WHERE id='" . $value->salon_product_id . "'");
        $serviceProviderModel = fetch_object($db, "SELECT * FROM service_provider WHERE id='" . $value->service_provider_id . "'");
        $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$salonProductModel->product_id}'");

        $html .= "<tr>
                <td>{$count}</td>
                <td>{$productModel->product}</td>
                <td>{$serviceProviderModel->name}</td>
                <td>{$value->quantity}</td>
                <td>Admin</td>
                <td>" . date("d-m-Y h:i:s A", strtotime($value->created_at)) . "</td>
                <td>
                    <a href='./product-use-in-salon-edit.php?id={$value->id}' class='btn btn-primary btn-sm btn-block' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                    <a data-href='./inc/stock/product-use-in-salon-delete.php?id={$value->id}' onclick='deleteService({$value->id})' class='btn btn-danger btn-sm btn-block' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a>
                </td>
            </tr>";

        $count++;
    }
} else {
    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}


echo $html;
