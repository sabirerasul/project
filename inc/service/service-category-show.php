<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$modal = fetch_all($db, "SELECT * FROM service_category ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {
        $count++;
        $value = (object) $val;

        $catStatus = ($value->status == 1) ? 'Active':'Deactive';
        $catColor = ($value->status == 1) ? 'success':'danger';
        $oppStatus = ($value->status == 1) ? 'Deactive' : 'Active';
        $oppStatusColor = ($value->status == 1) ? 'danger' : 'success';
        $statusIcon = ($value->status == 1) ? 'down':'up';
        $serviceCount = num_rows($db, "SELECT * FROM `service` WHERE `category_id`='{$value->id}'");
        $html .= "
        <tr>
            <td>{$count}</td>
            <td>{$value->name} ({$serviceCount})</td>
            <td><span class='badge rounded-pill text-bg-{$catColor}'>{$catStatus}</span></td>
            <td>
                <a href='./service.php?csid={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                <a href='./inc/service/service-category-status-update.php?csid={$value->id}' class='btn btn-{$oppStatusColor} btn-sm btn-block text-nowrap' type='button'><i class='fas fa-angle-double-{$statusIcon}'></i> {$oppStatus} </a>
                <a data-href='./inc/service/service-category-delete.php?cid={$value->id}' onclick='deleteServiceCategory({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
            </td>
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
