<?php
require_once "../../lib/db.php";
throw_exception();


$modal = fetch_all($db, "SELECT * FROM coupon ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $html .= "<tr>
            <td>{$value->coupon_code}</td>
            <td>{$discountArr[$value->discount_type]}</td>
            <td>{$value->min_bill_amount}</td>
            <td>{$value->max_discount_amount}</td>
            <td>{$value->valid_till}</td>
            <td>{$value->coupon_per_user}</td>";

        $html .= "<td class='multi-action-btn'>
                <a href='./coupon.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>";
        $html .= "<a onclick='deleteCoupon({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
            </tr>";
    }
} else {

    /*
    $html .="<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}

echo $html;
