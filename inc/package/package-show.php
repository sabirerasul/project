<?php
require_once "../../lib/db.php";
throw_exception();


$modal = fetch_all($db, "SELECT * FROM package ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {
        $count++;

        $value = (object) $val;

        $html .= "<tr>
            <td>{$count}</td>
            <td>{$value->package_name}</td>
            <td>{$value->duration}</td>
            <td>{$value->package_validity}</td>
            <td>{$value->price}</td>";

        $html .= "<td class='multi-action-btn'>
                <a href='./package.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                <a href='./package-details.php?id={$value->id}' class='btn btn-success btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-eye' aria-hidden='true'></i> View Details</a>";
        $html .= "<a onclick='deletePackage({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
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
