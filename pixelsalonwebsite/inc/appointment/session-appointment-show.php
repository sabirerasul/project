<?php
include('../../lib/db.php');

$ids = !empty($_SESSION['appointment']) ? $_SESSION['appointment'] : 0;

$modal = fetch_all($db, "SELECT * FROM `service` WHERE id IN ({$ids})");

$html = "";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {
        $value = (object) $val;
        $type = 'remove';

        $html .= <<<END
        <li class='list-group-item' data-id='{$value->id}'>
            <span class="bg-danger py-1 px-2 me-2 rounded cursor-pointer" onclick='removeCart(this)'><i class="fa text-white fa-trash"></i></span>
            <span>{$value->service_name} - ₹ <span class='service-cart-price'>{$value->price}<span></span>
        </li>
        END;;
    }
}


echo $html;
