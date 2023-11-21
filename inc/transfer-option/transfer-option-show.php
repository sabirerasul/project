<?php
require_once "../../lib/db.php";

throw_exception();

$sql = "SELECT * FROM service_provider WHERE branch_id='" . BRANCHID . "' AND status=1 ORDER by id DESC";


$modalSql = mysqli_query($db, $sql);
$modal = mysqli_fetch_all($modalSql, MYSQLI_ASSOC);
//$modal = mysqli_fetch_object($modalSql);

//$activeClient = mysqli_num_rows($modalSql);

$html = "";
$target_dir = "./web/employee_doc/";

if (count($modal) > 0) {
    $count = 0;
    foreach ($modal as $key => $val) {

        $value = (object) $val;

        $emp_photo = (!empty($value->photo)) ? $target_dir . $value->photo : $target_dir . 'female.png';

        $actionBtn = "<a data-name='{$value->name}' data-id='{$value->id}' onclick='transferServiceProvider(this)' class='btn btn-success btn-sm btn-block text-nowrap' type='button'>Transfer</a>";

        $count++;
        // /
        $html .= "<tr>
            <td>{$count}</td>
            <td class='avatar'><img src='{$emp_photo}' class='img-responsive'></td>
            <td>{$value->name}</td>
            <td>{$value->contact_number}</td>
            <td>{$value->service_provider_type}</td>
            <td>{$value->working_hours_start} - {$value->working_hours_end}</td>
            <td class='multi-action-btn'>{$actionBtn}</tr>";
    }
} else {
/*
    $html .= "<tr>
    <td colspan='7'>No Data Found</td>
    </tr>";*/
}


echo $html;
