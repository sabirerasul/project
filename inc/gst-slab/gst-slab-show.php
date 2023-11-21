<?php
require_once "../../lib/db.php";
throw_exception();

extract($_REQUEST);

$modal = fetch_all($db, "SELECT * FROM gst_slab ORDER by id DESC");

$html = "";

$total[] = 0;

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {

        $value = (object) $val;
       
        $count++;

        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->product_service_type}</td>
            <td>{$value->tax_type}</td>
            <td>{$value->gst} % </td>";

        $html .= "<td>
                <a href='./gst-slab.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>";
        $html .= "<a onclick='deleteExpense({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
            </tr>";
    }

    $count++;
}

echo $html;
