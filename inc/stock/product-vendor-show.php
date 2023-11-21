<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);
$branch_id = BRANCHID;

$sql = "SELECT * FROM `vendor` WHERE `branch_id`='{$branch_id}' ORDER by id DESC";

$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);

$html = "";

if (count($modal) > 0) {
    $count = 1;
    foreach ($modal as $key => $val) {
        $value = (object) $val;

        $html .= "<tr>
                <td>{$count}</td>
                <td>{$value->vendor_name}</td>
                <td>{$value->contact}</td>
                <td>{$value->email}</td>
                <td>{$value->address}</td>
                <td>
                    <a href='./product-vendor.php?editid={$value->id}' class='btn btn-primary btn-sm btn-block' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                    <a href='./product-vendor-profile.php?editid={$value->id}' class='btn btn-success btn-sm btn-block' type='button'> <i class='fas fa-eye' aria-hidden='true'></i> View Profile</a>
                    <a data-href='./inc/stock/product-vendor-delete.php?id={$value->id}' onclick='deleteService({$value->id})' class='btn btn-danger btn-sm btn-block' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a>
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
