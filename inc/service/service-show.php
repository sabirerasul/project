<?php
require_once "../../lib/db.php";
throw_exception();


extract($_REQUEST);

$modal = fetch_all($db, "SELECT * FROM service ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {
        $count++;
        $value = (object) $val;
        $catModel = fetch_object($db, "SELECT * FROM service_category WHERE id='{$value->category_id}'");
        
        $catStatus = ($value->status == 1) ? 'Active':'Deactive';
        $catColor = ($value->status == 1) ? 'success':'danger';
        $oppStatus = ($value->status == 1) ? 'Deactive' : 'Active';
        $oppStatusColor = ($value->status == 1) ? 'danger' : 'success';
        $statusIcon = ($value->status == 1) ? 'down':'up';
    
        // /
        $html .= "<tr>
                <td>{$count}</td>
                <td>{$value->service_name}</td>
                <td>{$serviceForArr[$value->service_for]}</td>
                <td>{$catModel->name}</td>
                <td>{$value->duration} Min</td>
                <td>{$value->price} Rs</td>
                <td>{$value->membership_price} Rs</td>
                <td>{$value->reward_point}</td>
                <td><span class='badge rounded-pill text-bg-{$catColor}'>{$catStatus}</span></td>
                <td>
                    <a href='./service.php?sid={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                    <a href='./inc/service/service-status-update.php?sid={$value->id}' class='btn btn-{$oppStatusColor} btn-sm btn-block text-nowrap' type='button'><i class='fas fa-angle-double-{$statusIcon}'></i> {$oppStatus} </a>
                    <a data-href='./inc/service/service-delete.php?sid={$value->id}' onclick='deleteService({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
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
