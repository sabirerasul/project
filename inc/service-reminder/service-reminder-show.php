<?php
require_once "../../lib/db.php";

throw_exception();


$modal = fetch_all($db, "SELECT * FROM service_reminder ORDER by id DESC");

$html = "";

if (count($modal) > 0) {
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $statusActionText = ($value->status == 0) ? 'active':'deactive';
        $statusActionColor = ($value->status == 0) ? 'success':'danger';
        $statusActionIcon = ($value->status == 0) ? 'arrow-up':'arrow-down';
        $statusText = ($value->status == 0) ? 'deactive':'active';
        $statusColor = ($value->status == 0) ? 'danger':'success';
        $serviceModel = fetch_object($db, "SELECT * FROM service WHERE id='{$value->service_id}'");


        $html .= "<tr>
            <td>{$serviceModel->service_name}</td>
            <td>{$value->interval_days}</td>
            <td>{$value->message}</td>
            <td><span class='badge rounded-pill text-bg-{$statusColor}'>{$statusText}</span></td>";

            
        
        $html .= "<td class='multi-action-btn'>
                <a href='./service-reminder.php?id={$value->id}' class='btn btn-primary btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-edit' aria-hidden='true'></i> Edit</a>
                <a href='./inc/service-reminder/service-reminder-status-update.php?id={$value->id}' class='btn btn-{$statusActionColor} btn-sm btn-block text-nowrap' type='button'> <i class='fas fa-{$statusActionIcon}' aria-hidden='true'></i> {$statusActionText}</a>";
        $html .= "<a onclick='deleteServiceReminder({$value->id})' class='btn btn-danger btn-sm btn-block text-nowrap' type='button'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</a></td>
            </tr>";
    }
} else {
/*
    $html .="<tr>
    <td colspan='13'>No Data Found</td>
    </tr>";*/

}

echo $html;