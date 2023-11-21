<?php
require_once "../../lib/db.php";
throw_exception();

$modal = fetch_all($db, "SELECT * FROM membership ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $button = "
            <a href='./membership.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
            <a onclick='deleteMembership({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>";

        $button = (USERROLE == 'superadmin') ? $button : '';

        $html .= "<tr>
            <td>{$value->membership_name}</td>
            <td>{$value->price}</td>
            <td>{$value->min_reward_point_earned}</td>
            <td>{$value->min_bill_amount}</td>
            <td>{$value->discount_on_service} {$discountArr[$value->discount_on_service_type]}</td>
            <td>{$value->discount_on_product} {$discountArr[$value->discount_on_product_type]}</td>
            <td>{$value->discount_on_package} {$discountArr[$value->discount_on_package_type]}</td>
            <td>{$rewardPointBoostArr[$value->reward_point_boost]}</td>
            <td>{$value->reward_point}</td>
            <td>{$value->validity} Days</td>
        
            <td class='multi-action-btn'>
                {$button}
            </tr>";
    }
} else {

    /*
    $html .= "<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";
    */
}

echo $html;
