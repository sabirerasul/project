<?php
require_once "../../lib/db.php";

throw_exception();


extract($_REQUEST);

$sql = "SELECT * FROM product ORDER by id DESC";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
//$modal = mysqli_fetch_object($modalSql);

//$activeClient = mysqli_num_rows($modalSql);

$html = "";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {
        $count++;
        $value = (object) $val;
        $productUnit = ucfirst($value->unit);
    
        // /
        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->product}</td>
            <td>{$value->volume} {$value->unit}</td>
            <td>{$value->mrp}</td>
            <td>{$value->reward_point_on_purchase}</td>
            <td>{$value->barcode}</td>
            <td>
                    <a href='./product.php?pid={$value->id}' class='btn btn-primary btn-sm btn-block' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                    <a data-href='./inc/product/product-delete.php?pid={$value->id}' onclick='deleteProduct({$value->id})' class='btn btn-danger btn-sm btn-block' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
                </td>
            </tr>
        ";

    }
} else {
/*
    $html .="<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";*/

}


echo $html;
