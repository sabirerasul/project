<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$branch_id = BRANCHID;
$todayDate = todayDate();
$sql = "SELECT * FROM stock ORDER by id DESC";

$modal = fetch_all($db, $sql);
//$modal = mysqli_fetch_object($modalSql);

//$activeClient = mysqli_num_rows($modalSql);

$html = "";

if (count($modal) > 0) {
    $count = 1;
    foreach ($modal as $key => $val) {

        if (getDateServerFormat($val['exp_date']) < getDateServerFormat($todayDate)) {
            continue;
        }

        $value = (object) $val;


        $numSql = num_rows($db, "SELECT * FROM `stock_record` WHERE `stock_main_id`='{$value->id}' AND branch_id='$branch_id'");

        if ($numSql == 0) {
            continue;
        }

        

        $availableStock = availableStock($db, $value->id);

        $productModel = fetch_object($db, "SELECT * FROM product WHERE id='{$value->product_id}'");

        $html .= "<tr>
                <td>{$count}</td>
                <td>{$productModel->product} ({$value->quantity} {$value->unit})</td>
                <td>{$availableStock} ({$availableStock} {$value->unit})</td>
                <td>{$value->mrp_price}</td>
                <td>{$value->purchase_price}</td>
                <td>{$value->sale_price}</td>
                <td>
                    <a href='./product-details.php?id={$value->id}' class='btn btn-warning btn-sm btn-block' type='button'> <i class='fas fa-history' aria-hidden='true'></i> View History</a>
                </td>
            </tr>";

        $count++;
    }
} else {
    /*
    $html .="<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";*/
}


echo $html;
